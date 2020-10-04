<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\Vehicle;
use App\model\VehicleFuelLog;
use App\model\VehicleFuelStation;
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

class VehicleFuelLogReportController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $fuelStation = VehicleFuelStation::getAllData();

        return view::make('vehicle_fuel_log_report.main_view')->with('fuelStation',$fuelStation);

    }

    public function searchReport(Request $request)
    {

        $startDate = Utility::standardDate($request->input('start_date'));
        $endDate = Utility::standardDate($request->input('end_date'));
        $driver = $request->input('driver');
        $vehicle = $request->input('vehicle');
        $fuelStation = $request->input('fuel_station');
        $dateArray = [$startDate,$endDate];
        $mainData = [];

        $chartObject = new \stdClass();

        //PROCESS SEARCH
        if(!in_array(0,$fuelStation) && !empty($vehicle) && !empty($driver)){
            $mainData = VehicleFuelLog::massDataColumnDate7('driver_id', $driver, $fuelStation, 'vehicle_id', $vehicle, 'fuel_station', $dateArray);
        }

        if(!in_array(0,$fuelStation) && empty($vehicle) && empty($driver)){
            $mainData = VehicleFuelLog::massDataDate3('fuel_station', $fuelStation,$dateArray);
        }

        if(!in_array(0,$fuelStation) && !empty($vehicle) && empty($driver)){
            $mainData = VehicleFuelLog::massDataColumnDate5('vehicle_id', $vehicle, 'fuel_station', $fuelStation, $dateArray);
        }

        if(!in_array(0,$fuelStation) && empty($vehicle) && !empty($driver)){
            $mainData = VehicleFuelLog::massDataColumnDate5('driver_id', $driver, 'fuel_station', $fuelStation, $dateArray);
        }

        if(in_array(0,$fuelStation) && !empty($vehicle) && empty($driver)){
            $mainData = VehicleFuelLog::specialColumnsDate3('vehicle_id', $vehicle,$dateArray);
        }

        if(in_array(0,$fuelStation) && !empty($vehicle) && !empty($driver)){
            $mainData = VehicleFuelLog::specialColumnsDate5('vehicle_id', $vehicle, 'driver_id', $driver,$dateArray);
        }

        if(in_array(0,$fuelStation) && empty($vehicle) && !empty($driver)){
            $mainData = VehicleFuelLog::specialColumnsDate3('driver_id', $driver,$dateArray);
        }

        if(in_array(0,$fuelStation) && empty($vehicle) && empty($driver)){
            $mainData = VehicleFuelLog::specialColumnsDate($dateArray);
        }

        $this->processData($mainData);
        $monthlyTotalPrice = $this->arrangeMonth($mainData,$startDate,$endDate);
        $this->report($mainData,$chartObject);

        return view::make('vehicle_fuel_log_report.reload')->with('mainData',$mainData)->with('chartObject',$chartObject)
            ->with('monthlyTotalPrice',$monthlyTotalPrice);

    }

    public function report($mainData,$chartObject){

        $totalLiters = []; $totalPurchasePrice = []; $allMileage = []; $firstMileage = 0; $lastMileage = 0;
        $totalMileage = 0;
        if(!empty($mainData)) {
            foreach ($mainData as $val) {
                $totalLiters[] = $val->liter;
                $totalPurchasePrice[] = $val->total_price;
                $allMileage[] = $val->mileage;

            }
            $lastMileage = $allMileage[0];
            $firstMileage = $allMileage[count($allMileage) - 1]; //LAST MILEAGE IS KEY 0 COS THE DATA QUERY IS ORDERED BY DESCENDING

            $totalMileage = $lastMileage - $firstMileage;
        }

        $chartObject->totalMileage = $totalMileage;
        $chartObject->totalLiters = array_sum($totalLiters);
        $chartObject->totalPurchasePrice = array_sum($totalPurchasePrice);

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

                    $stdDate = Utility::standardDate($val->purchase_date);
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
