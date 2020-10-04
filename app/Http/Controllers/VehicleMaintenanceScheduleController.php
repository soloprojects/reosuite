<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\VehicleMaintenanceReminder;
use App\model\VehicleMaintenanceSchedule;
use App\model\Vehicle;
use App\User;
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class VehicleMaintenanceScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $mainData = VehicleMaintenanceSchedule::paginateAllData();
        $maintenanceReminder = VehicleMaintenanceReminder::getAllData();
        $this->processData($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make('vehicle_maintenance_schedule.reload',array('mainData' => $mainData,
                'maintenanceReminder' => $maintenanceReminder))->render());

        }else{
            return view::make('vehicle_maintenance_schedule.main_view')->with('mainData',$mainData)
                ->with('maintenanceReminder',$maintenanceReminder);
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
        $validator = Validator::make($request->all(),VehicleMaintenanceSchedule::$mainRules);
        if($validator->passes()){

            $jsonMileage = $request->input('mileage');
            $decodeMileage = json_decode($jsonMileage);

            $jsonVehicle = $request->input('vehicle');
            $decodeVehicle = json_decode($jsonVehicle);

            for($i=0;$i<count($decodeVehicle);$i++) {
                $dbDATA = [
                    'reminder_id' => $request->input('reminder'),
                    'mileage' =>  Utility::checkEmptyArrayItem($decodeMileage,$i,'0'),
                    'vehicle_id' => Utility::checkEmptyArrayItem($decodeVehicle,$i,'0'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];

                VehicleMaintenanceSchedule::create($dbDATA);
            }
                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

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
        $mainData = VehicleMaintenanceSchedule::firstRow('id',$request->input('dataId'));
        $maintenanceReminder = VehicleMaintenanceReminder::getAllData();
        return view::make('vehicle_maintenance_schedule.edit_form')->with('edit',$mainData)
            ->with('maintenanceReminder',$maintenanceReminder);

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
        $validator = Validator::make($request->all(),VehicleMaintenanceSchedule::$mainRules);
        if($validator->passes()) {
            $vehicle = $request->input('vehicle');
            $mileage = $request->input('mileage');


                $dbDATA = [
                    'reminder_id' => ucfirst($request->input('reminder')),
                    'vehicle_id' => $vehicle,
                    'mileage' => $mileage,
                    'updated_by' => Auth::user()->id,
                ];


                VehicleMaintenanceSchedule::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function searchData(Request $request)
    {
        //
        $search = VehicleMaintenanceSchedule::searchData($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->reminder_id;
        }

        $data_ids = array_unique($obtain_array);
        $mainData =  VehicleMaintenanceSchedule::massDataPaginate('reminder_id', $data_ids);
        //print_r($data_ids); die();
        if (count($data_ids) > 0) {

            return view::make('vehicle_maintenance_schedule.search')->with('mainData',$mainData);
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
        $all_id = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

        $inactiveMaintenanceSchedule = [];
        $activeMaintenanceSchedule = [];

        foreach($all_id as $var){
            $salesTeamRequest = VehicleMaintenanceSchedule::firstRow('id',$var);
            if($salesTeamRequest->created_by == Auth::user()->id || in_array(Auth::user()->id,Utility::TOP_USERS)){
                $inactiveMaintenanceSchedule[] = $var;
            }else{
                $activeMaintenanceSchedule[] = $var;
            }
        }

        $message = (count($inactiveMaintenanceSchedule) < 1) ? ' and '.count($activeMaintenanceSchedule).
            ' maintenance Schedule was not created by you and cannot be deleted' : '';
        if(count($inactiveMaintenanceSchedule) > 0){


            $delete = VehicleMaintenanceSchedule::massUpdate('id',$inactiveMaintenanceSchedule,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($inactiveMaintenanceSchedule).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($activeMaintenanceSchedule).' was not created by you and cannot be deleted',
                'message' => 'warning'
            ]);

        }

    }

    public function processData($mainData){
        foreach($mainData as $data){
            $vehicle = Vehicle::firstRow('id',$data->vehicle_id);
            $data->vehicle_make = $vehicle->make->make_name;
            $data->vehicle_model = $vehicle->model->model_name;

        }
    }

}
