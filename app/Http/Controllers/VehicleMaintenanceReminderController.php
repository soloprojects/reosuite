<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\VehicleMaintenanceReminder;
use App\model\VehicleMaintenanceSchedule;
use App\model\VehicleServiceType;
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

class VehicleMaintenanceReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $mainData = VehicleMaintenanceReminder::paginateAllData();
        $serviceTypes = VehicleServiceType::getAllData();
        $this->processData($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make('vehicle_maintenance_reminder.reload',array('mainData' => $mainData,
                'serviceType' => $serviceTypes))->render());

        }else{
            return view::make('vehicle_maintenance_reminder.main_view')->with('mainData',$mainData)
                ->with('serviceType',$serviceTypes);
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
        $validator = Validator::make($request->all(),VehicleMaintenanceReminder::$mainRules);
        if($validator->passes()){

            $jsonServices = $request->input('services');
            $decodeServices = json_decode($jsonServices);
            $services = array_unique($decodeServices);
            $interval = $request->input('interval');
            $notificationDate = Utility::standardDate($request->input('notification_date'));
            $nextDate = (!empty($interval)) ? date('Y-m-d', strtotime(date('Y-m-d'). ' + '.$interval.' days')) : '2500-10-15';
            $countData = VehicleMaintenanceReminder::countData('name',$request->input('name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                if(!empty($notificationDate)) {
                    $dbDATA = [
                        'name' => ucfirst($request->input('name')),
                        'interval' => $request->input('interval'),
                        'mileage' => $request->input('mileage'),
                        'last_reminder' => $notificationDate,
                        'next_reminder' => $nextDate,
                        'service_types' => json_encode($services),
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                }else{
                    $dbDATA = [
                        'name' => ucfirst($request->input('name')),
                        'interval' => $request->input('interval'),
                        'next_reminder' => $nextDate,
                        'mileage' => $request->input('mileage'),
                        'service_types' => json_encode($services),
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                }
                VehicleMaintenanceReminder::create($dbDATA);

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
        $mainData = VehicleMaintenanceReminder::firstRow('id',$request->input('dataId'));
        $serviceTypes = VehicleServiceType::getAllData();
        $this->processItemData($mainData);
        return view::make('vehicle_maintenance_reminder.edit_form')->with('edit',$mainData)
            ->with('serviceType',$serviceTypes);

    }

    public function removeService(Request $request){

        $editId = $request->input('dataId');
        $stageId = $request->input('param');
        $oldData = VehicleMaintenanceReminder::firstRow('id',$editId);
        $oldServiceTypes = json_decode($oldData->service_types,true);


        //REMOVE USER FROM AN ARRAY
        if (($key = array_search($stageId, $oldServiceTypes)) != false) {
            unset($oldServiceTypes[$key]);
        }

        $oldServiceTypesArrayToJson = json_encode($oldServiceTypes);
        $dbData = [
            'service_types' => $oldServiceTypesArrayToJson,
        ];
        $save = VehicleMaintenanceReminder::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'Stage have been removed'
        ]);

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
        $validator = Validator::make($request->all(),VehicleMaintenanceReminder::$mainRules);
        if($validator->passes()) {
            $jsonServices = $request->input('services');
            $decodeServices = json_decode($jsonServices);
            $services = array_unique($decodeServices);
            $interval = $request->input('interval');
            $notificationDate = Utility::standardDate($request->input('notification_date'));
            $nextDate = (!empty($interval)) ? date('Y-m-d', strtotime(date('Y-m-d'). ' + '.$interval.' days')) : '2500-10-15';

            $dbDATA = [];
            if(!empty($notificationDate)) {
                $dbDATA = [
                    'name' => ucfirst($request->input('name')),
                    'interval' => $request->input('interval'),
                    'mileage' => $request->input('mileage'),
                    'last_reminder' => $notificationDate,
                    'next_reminder' => $nextDate,
                    'service_types' => json_encode($services),
                    'updated_by' => Auth::user()->id,
                ];
            }else{
                $dbDATA = [
                    'name' => ucfirst($request->input('name')),
                    'interval' => $request->input('interval'),
                    'next_reminder' => $nextDate,
                    'mileage' => $request->input('mileage'),
                    'service_types' => json_encode($services),
                    'updated_by' => Auth::user()->id,
                ];
            }
            $rowData = VehicleMaintenanceReminder::specialColumns('name', $request->input('name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    VehicleMaintenanceReminder::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                VehicleMaintenanceReminder::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function searchData(Request $request)
    {

        $searchValue = $request->input('searchVar');
        //PROCESS SEARCH REQUEST
        $mainData = VehicleMaintenanceReminder::searchData('name',$searchValue);
        $this->processData($mainData);
        return view::make('vehicle_maintenance_reminder.search')->with('mainData',$mainData);

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

        $inactiveMaintenanceReminder = [];
        $activeMaintenanceReminder = [];

        foreach($all_id as $var){
            $salesTeamRequest = VehicleMaintenanceReminder::firstRow('id',$var);
            if($salesTeamRequest->created_by == Auth::user()->id || in_array(Auth::user()->id,Utility::TOP_USERS)){
                $inactiveMaintenanceReminder[] = $var;
            }else{
                $activeMaintenanceReminder[] = $var;
            }
        }

        $message = (count($inactiveMaintenanceReminder) < 1) ? ' and '.count($activeMaintenanceReminder).
            ' maintenance reminder was not created by you and cannot be deleted' : '';
        if(count($inactiveMaintenanceReminder) > 0){


            $delete = VehicleMaintenanceReminder::massUpdate('id',$inactiveMaintenanceReminder,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($inactiveMaintenanceReminder).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($activeMaintenanceReminder).' was not created by you and cannot be deleted',
                'message' => 'warning'
            ]);

        }

    }

    public function processData($data){
        foreach($data as $val){
            $serviceTypes = json_decode($val->service_types,true);

            if(!empty($serviceTypes)){
                $fetchServiceTypes = VehicleServiceType::massData('id',$serviceTypes);
                $val->services = $fetchServiceTypes;
                $val->serviceTypeArray = $serviceTypes;
            }else{
                $val->services = '';
            }

        }
    }

    public function processItemData($val){
        $serviceTypes = json_decode($val->service_types,true);

        if(!empty($serviceTypes)){
            $fetchServiceTypes = VehicleServiceType::massData('id',$serviceTypes);
            $val->services = $fetchServiceTypes;
        }else{
            $val->services = '';
        }

    }

}
