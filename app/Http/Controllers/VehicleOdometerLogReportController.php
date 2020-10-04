<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\Vehicle;
use App\model\VehicleOdometerLog;
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

class VehicleOdometerLogReportController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //$req = new Request();

        return view::make('vehicle_odometer_log_report.main_view');

    }

    public function searchReport(Request $request)
    {

        $startDate = Utility::standardDate($request->input('start_date'));
        $endDate = Utility::standardDate($request->input('end_date'));
        $driver = $request->input('driver');
        $vehicle = $request->input('vehicle');
        $dateArray = [$startDate,$endDate];
        $mainData = [];

        $chartObject = new \stdClass();

        //PROCESS SEARCH

        if(!empty($vehicle) && empty($driver)){
            $mainData = VehicleOdometerLog::specialColumnsDate3('vehicle_id', $vehicle,$dateArray);
        }

        if(!empty($vehicle) && !empty($driver)){
            $mainData = VehicleOdometerLog::specialColumnsDate5('vehicle_id', $vehicle, 'driver_id', $driver,$dateArray);
        }

        if(empty($vehicle) && !empty($driver)){
            $mainData = VehicleOdometerLog::specialColumnsDate3('driver_id', $driver,$dateArray);
        }

        if( empty($vehicle) && empty($driver)){
            $mainData = VehicleOdometerLog::specialColumnsDate($dateArray);
        }

        $this->processData($mainData);
        $monthlyTotalMileage = $this->arrangeMonth($mainData,$startDate,$endDate);
        $this->report($mainData,$chartObject);

        return view::make('vehicle_odometer_log_report.reload')->with('mainData',$mainData)->with('chartObject',$chartObject)
            ->with('monthlyTotalMileage',$monthlyTotalMileage);

    }

    public function report($mainData,$chartObject){

        $totalDailyMileage = [];
        foreach($mainData as $val){
            $totalDailyMileage[] = $val->daily_mileage;

        }

        $chartObject->totalDailyMileage = array_sum($totalDailyMileage);

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
                $calcMonthMileageArray = [];
                foreach($query as $val){

                    $stdDate = Utility::standardDate($val->log_date);
                    $getM = date('m',strtotime($stdDate)); $getY = date('Y',strtotime($stdDate));
                    if($getM == $m && $getY == $y){
                        $calcMonthMileageArray[] = $val->daily_mileage;
                    }

                }
                $monthYear[$monthName.'-'.$y] = array_sum($calcMonthMileageArray);
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
