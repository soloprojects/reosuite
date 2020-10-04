<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\CrmLead;
use App\model\CrmSalesCycle;
use App\model\CrmStages;
use App\model\CrmOpportunity;
use App\model\SalesTeam;
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

class CrmReportController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $salesCycle = CrmSalesCycle::getAllData();
        $salesTeam = SalesTeam::getAllData();

        return view::make('crm_report.main_view')->with('salesCycle',$salesCycle)->with('salesTeam',$salesTeam);

    }

    public function searchReport(Request $request)
    {

        $startDate = Utility::standardDate($request->input('start_date'));
        $endDate = Utility::standardDate($request->input('end_date'));
        $salesCycle = $request->input('sales_cycle');
        $salesTeam = $request->input('sales_team');
        $dateArray = [$startDate,$endDate];
        $mainData = [];
        $salesCycleData = (in_array(0,$salesCycle)) ? CrmSalesCycle::getAllData() : CrmSalesCycle::massData('id',$salesCycle);
        $stages = '';
        foreach($salesCycleData as $data){
            $dataStages = json_decode($data->stages,true);
            $implodeStages = implode(',',$dataStages);
            $stages .= ','.$implodeStages;
        }
        $stagesArray = explode(',',$stages);
        $crmStages = CrmStages::massData('id',$stagesArray);

        $chartObject = new \stdClass();

            //PROCESS SEARCH
            if(!in_array(0,$salesCycle) && in_array(0,$salesTeam)){
                $mainData = CrmOpportunity::massDataDate3('sales_cycle_id', $salesCycle,$dateArray);
            }

            if(in_array(0,$salesCycle) && !in_array(0,$salesTeam)){
                $mainData = CrmOpportunity::massDataDate3('sales_team_id', $salesTeam, $dateArray);
            }

            if(in_array(0,$salesCycle) && in_array(0,$salesTeam)){
                $mainData = CrmOpportunity::specialColumnsDate($dateArray);
            }

            if(!in_array(0,$salesCycle) && !in_array(0,$salesTeam)){
                $mainData = CrmOpportunity::massDataDate4('sales_team_id', $salesTeam, 'sales_cycle_id', $salesCycle,$dateArray);
            }

            $this->report($mainData,$crmStages,$chartObject);

        return view::make('crm_report.reload')->with('mainData',$mainData)->with('chartObject',$chartObject);

    }

    public function countStatus($statusArr){
        $newArr = [];
        foreach($statusArr as $key => $val){
            if(is_array($val)){
                $newArr[$key] = count($val);
            }else{
                $new[$key] = 0;
            }
        }
        return $newArr;
    }

    public function report($mainData,$crmStages,$chartObject){

         $stageOpportCount = []; $overdueOpport = []; $opportClosingToday = [];
         $ongoingOpport = []; $wonOpport = []; $lostOpport = [];
        $ongoingOpportAmount = []; $wonOpportAmount = []; $lostOpportAmount = [];
        $currDate = date('Y-m-d');
        foreach($mainData as $val){

            foreach($crmStages as  $var){
                if($var->id == $val->stage_id){
                    $stageOpportCount[$var->name][] = $val->stage_id;
                }
            }

            if($val->opportunity_status == Utility::ONGOING){
                $ongoingOpport[] = $val->opportunity_status;
                $ongoingOpportAmount[] = $val->expected_revenue;
            }

            if($val->opportunity_status == Utility::LOST){
                $lostOpport[] = $val->opportunity_status;
                $lostOpportAmount[] = $val->expected_revenue;
            }

            if($val->opportunity_status == Utility::WON){
                $wonOpport[] = $val->opportunity_status;
                $wonOpportAmount[] = $val->expected_revenue;
            }

            if($currDate > $val->closing_date && $val->opportunity_status != Utility::WON){
                $overdueOpport[] = $val->closing_date;
            }
            if($currDate == $val->closing_date && $val->opportunity_status == Utility::ONGOING){
                $opportClosingToday[] = $currDate;
            }

        }

        $chartObject->stageOpportCount = $this->countStatus($stageOpportCount);
        $chartObject->overdueOpport = count($overdueOpport);
        $chartObject->opportClosingToday = count($opportClosingToday);
        $chartObject->ongoingOpport = count($ongoingOpport);
        $chartObject->wonOpport = count($wonOpport);
        $chartObject->lostOpport = count($lostOpport);
        $chartObject->ongoingOpportAmount = array_sum($ongoingOpportAmount);
        $chartObject->wonOpportAmount = array_sum($wonOpportAmount);
        $chartObject->lostOpportAmount = array_sum($lostOpportAmount);

    }

}
