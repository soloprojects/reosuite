<?php

namespace App\Http\Controllers;

use App\model\Vehicle;
use App\model\VehicleMake;
use App\Helpers\Utility;
use App\model\VehicleCategory;
use App\User;
use Auth;
use Monolog\Handler\Curl\Util;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData = Vehicle::paginateAllData();
        $vehicleCategory = VehicleCategory::getAllData();
        $vehicleMake = VehicleMake::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('vehicle.reload',array('mainData' => $mainData,
                'vehicleCategory' => $vehicleCategory,'vehicleMake' => $vehicleMake))->render());

        }else{
            return view::make('vehicle.main_view')->with('mainData',$mainData)
                ->with('vehicleMake',$vehicleMake)->with('vehicleCategory',$vehicleCategory);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),Vehicle::$mainRules);
        if($validator->passes()){

            $files = $request->file('attachment');
            $attachment = [];

            if($files != ''){
                foreach($files as $file){

                    $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalName() . $file->getClientOriginalExtension();

                    $file->move(
                        Utility::FILE_URL(), $file_name
                    );
                    //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A TEXT TYPE MYSQL COLUMN
                    $attachment[] =  $file_name;

                }
            }

            $countData = Vehicle::countData('license_plate',$request->input('license_plate'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $uid = Utility::generateUID('vehicle');

                $dbDATA = [
                    'uid' => $uid,
                    'model_id' => $request->input('model'),
                    'make_id' => $request->input('make'),
                    'category_id' => $request->input('category'),
                    'driver_id' => $request->input('driver'),
                    'license_plate' => $request->input('license_plate'),
                    'location' => ucfirst($request->input('location')),
                    'chasis_no' => $request->input('chasis_no'),
                    'model_year' => $request->input('model_year'),
                    'registration_date' => Utility::standardDate($request->input('registration_date')),
                    'registration_due_date' => Utility::standardDate($request->input('registration_due_date')),
                    'purchase_price' => $request->input('purchase_price'),
                    'seat_number' => ucfirst($request->input('seat_numbers')),
                    'doors' => $request->input('doors'),
                    'colour' => $request->input('colour'),
                    'transmission' => $request->input('transmission'),
                    'fuel_type' => $request->input('fuel_type'),
                    'horsepower' => $request->input('horse_power'),
                    'mileage' => ucfirst($request->input('mileage')),
                    'docs' => json_encode($attachment),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Vehicle::create($dbDATA);

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

            }
        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request)
    {
        //
        $request = Vehicle::firstRow('id',$request->input('dataId'));
        $vehicleCategory = VehicleCategory::getAllData();
        $vehicleMake = VehicleMake::getAllData();
        return view::make('vehicle.edit_form')->with('edit',$request)->with('vehicleMake',$vehicleMake)
            ->with('vehicleCategory',$vehicleCategory);

    }

    public function attachmentForm(Request $request)
    {
        //
        $request = Vehicle::firstRow('id',$request->input('dataId'));
        return view::make('vehicle.attach_form')->with('edit',$request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $validator = Validator::make($request->all(),Vehicle::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'model_id' => $request->input('model'),
                'make_id' => $request->input('make'),
                'category_id' => $request->input('category'),
                'driver_id' => $request->input('driver'),
                'license_plate' => $request->input('license_plate'),
                'location' => ucfirst($request->input('location')),
                'chasis_no' => $request->input('chasis_no'),
                'model_year' => $request->input('model_year'),
                'registration_date' => Utility::standardDate($request->input('registration_date')),
                'registration_due_date' => Utility::standardDate($request->input('registration_due_date')),
                'purchase_price' => $request->input('purchase_price'),
                'seat_number' => ucfirst($request->input('seat_numbers')),
                'doors' => $request->input('doors'),
                'colour' => $request->input('colour'),
                'transmission' => $request->input('transmission'),
                'fuel_type' => $request->input('fuel_type'),
                'horsepower' => $request->input('horse_power'),
                'mileage' => ucfirst($request->input('mileage')),
                'updated_by' => Auth::user()->id
            ];
            $rowData = Vehicle::specialColumns('license_plate', $request->input('license_plate'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Vehicle::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                } else {
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Entry already exist, please try another entry'
                    ]);

                }

            } else{
                Vehicle::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);
            }
        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function editAttachment(Request $request){
        $files = $request->file('attachment');

        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = Vehicle::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->docs);

        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                $file->move(
                    Utility::FILE_URL(), $file_name
                );
                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                array_push($oldAttachment,$file_name);

            }
        }

        $attachJson = json_encode($oldAttachment);
        $dbData = [
            'docs' => $attachJson
        ];
        $save = Vehicle::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'saved'
        ]);

    }

    public function removeAttachment(Request $request){
        $file_name = $request->input('attachment');
        //return $files;
        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = Vehicle::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->docs,true);


        //REMOVE FILES FROM AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
        if (($key = array_search($file_name, $oldAttachment)) !== false) {
            $fileUrl = Utility::FILE_URL($file_name);
            unset($oldAttachment[$key]);
            unlink($fileUrl);
        }


        $attachJson = json_encode($oldAttachment);
        $dbData = [
            'docs' => $attachJson
        ];
        $save = Vehicle::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'File have been removed'
        ]);

    }

    public function downloadAttachment(){
        $file = $_GET['file'];
        $download = Utility::FILE_URL($file);
        return response()->download($download);
        //return $file;
    }

    public function searchVehicle(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = Vehicle::searchVehicle($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }

        $data_ids = array_unique($obtain_array);
        $mainData =  Vehicle::massDataPaginate('uid', $data_ids);
        //print_r($data_ids); die();
        if (count($data_ids) > 0) {

            return view::make('vehicle.vehicle_search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));

        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

            $delete = Vehicle::massUpdate('id', $idArray, $dbData);

            return response()->json([
                'message' => 'deleted',
                'message2' => 'Data deleted successfully'
            ]);

         //END FOR VEHICLE DELETE

    }

}
