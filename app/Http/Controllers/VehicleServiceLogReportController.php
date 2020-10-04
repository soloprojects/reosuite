<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\Vehicle;
use App\model\VehicleServiceLog;
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

class VehicleServiceLogReportController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $serviceType = VehicleServiceType::getAllData();

        return view::make('vehicle_service_log_report.main_view')->with('serviceType',$serviceType);

    }

    public function searchReport(Request $request)
    {

        $startDate = Utility::standardDate($request->input('start_date'));
        $endDate = Utility::standardDate($request->input('end_date'));
        $driver = $request->input('driver');
        $vehicle = $request->input('vehicle');
        $serviceType = $request->input('service_type');
        $dateArray = [$startDate,$endDate];
        $mainData = [];

        $chartObject = new \stdClass();

        //PROCESS SEARCH
        if(!in_array(0,$serviceType) && !empty($vehicle) && !empty($driver)){
            $mainData = VehicleServiceLog::massDataColumnDate7('driver_id', $driver, $serviceType, 'vehicle_id', $vehicle, 'service_type', $dateArray);
        }

        if(!in_array(0,$serviceType) && empty($vehicle) && empty($driver)){
            $mainData = VehicleServiceLog::massDataDate3('service_type', $serviceType,$dateArray);
        }

        if(!in_array(0,$serviceType) && !empty($vehicle) && empty($driver)){
            $mainData = VehicleServiceLog::massDataColumnDate5('vehicle_id', $vehicle, 'service_type', $serviceType, $dateArray);
        }

        if(!in_array(0,$serviceType) && empty($vehicle) && !empty($driver)){
            $mainData = VehicleServiceLog::massDataColumnDate5('driver_id', $driver, 'service_type', $serviceType, $dateArray);
        }

        if(in_array(0,$serviceType) && !empty($vehicle) && empty($driver)){
            $mainData = VehicleServiceLog::specialColumnsDate3('vehicle_id', $vehicle,$dateArray);
        }

        if(in_array(0,$serviceType) && !empty($vehicle) && !empty($driver)){
            $mainData = VehicleServiceLog::specialColumnsDate5('vehicle_id', $vehicle, 'driver_id', $driver,$dateArray);
        }

        if(in_array(0,$serviceType) && empty($vehicle) && !empty($driver)){
            $mainData = VehicleServiceLog::specialColumnsDate3('driver_id', $driver,$dateArray);
        }

        if(in_array(0,$serviceType) && empty($vehicle) && empty($driver)){
            $mainData = VehicleServiceLog::specialColumnsDate($dateArray);
        }

        $this->processData($mainData);
        $monthlyTotalBill = $this->arrangeMonth($mainData,$startDate,$endDate);
        $this->report($mainData,$chartObject);

        return view::make('vehicle_service_log_report.reload')->with('mainData',$mainData)->with('chartObject',$chartObject)
            ->with('monthlyTotalBill',$monthlyTotalBill);

    }

    public function report($mainData,$chartObject){

        $totalBill = []; $workshopMileage = [];
        foreach($mainData as $val){
            $totalBill[] = $val->total_price;
            $workshopMileage[] = $val->mileage_out - $val->mileage_in;

        }

        $chartObject->workshopMileage = array_sum($workshopMileage);
        $chartObject->totalBill = array_sum($totalBill);

    }

    public function arrangeMonth($query,$start,$end){
        $startDate = Utility::standardDate($start);
        $endDate = Utility::standardDate($end);
        $startYear =  date('Y',strtotime($startDate));
        $endYear = date('Y',strtotime($endDate));
        $monthYear = [];
        for($y=$startYear;$y<=$endYear;$y++){
            for($m=1;$m<=12;$m++){
                $monthName = date("F", mktime(0, 0, 0, $m, 10));
                $calcMonthAmtArray = [];
                foreach($query as $val){

                    $stdDate = Utility::standardDate($val->service_date);
                    $getM = date('m',strtotime($stdDate)); $getY = date('Y',strtotime($stdDate));
                    if($getM == $m && $getY == $y){
                        $calcMonthAmtArray[] = $val->total_price;
                    }

                }
                $monthYear[$monthName.'-'.$y] = array_sum($calcMonthAmtArray);
            }
        }
        return $monthYear;

    }

    public function processData($mainData){
        foreach($mainData as $data){
            $vehicle = Vehicle::firstRow('id',$data->vehicle_id);
            $data->vehicle_make = $vehicle->make->make_name;
            $data->vehicle_model = $vehicle->model->model_name;

        }
    }

}
