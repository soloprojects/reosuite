<?php

namespace App\Http\Controllers;

use App\model\Budget;
use App\model\Department;
use App\model\FinancialYear;
use App\model\Helpdesk;
use App\model\LeaveLog;
use App\model\News;
use App\model\ProjectTeam;
use App\model\Project;
use App\model\Requisition;
use App\model\VehicleFleetAccess;
use App\model\CrmOpportunity;
use App\model\VehicleFuelLog;
use App\model\VehicleServiceLog;
use App\User;
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use App\model\Currency;
use App\Helpers\Utility;
use Intervention\Image\Facades\Image;
use Request;
use App\Http\Requests;
use App\model\RequestCategory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeCurr = Currency::firstRow('active_status','1');
        $holdArr = [];
        $holdArr['id'] = $activeCurr->id;
        $holdArr['code'] = $activeCurr->code;
        $holdArr['currency'] = $activeCurr->currency;
        $holdArr['symbol'] = $activeCurr->symbol;
        $holdArr['active_status'] = $activeCurr->active_status;
        $holdArr['status'] = $activeCurr->status;
        session(['currency' => $holdArr]);

        return view::make('auth.dashboard');
    }

    //Signin
    public function signin() {

        return view::make('auth.login');
    }

    public function dashboardReport()
    {
        //DISPLAY ON DASHBOARD
        $budgetRequestReport = (in_array(Auth::user()->role,Utility::TOP_USERS)) ? $this->requisitionBudget() : $this->requisitionBudgetUsers(Auth::user()->dept_id);
        $requisitionReport = (in_array(Auth::user()->role,Utility::TOP_USERS)) ? $this->requisition() : $this->requisitionUsers(Auth::user()->dept_id);
        $projectReport = (in_array(Auth::user()->role,Utility::TOP_USERS)) ? $this->projectReport() :  $this->projectReport(Auth::user()->id);
        $crmReport = $this->crmReport();

        $vehicleServiceLogReport = (in_array(Auth::user()->role,Utility::TOP_USERS) ||
            !empty(VehicleFleetAccess::firstRow('user_id',Auth::user()->id))) ? $this->vehicleServiceLogReport() : '';

        $vehicleFuelLogReport = (in_array(Auth::user()->role,Utility::TOP_USERS) ||
            !empty(VehicleFleetAccess::firstRow('user_id',Auth::user()->id))) ? $this->vehicleFuelLogReport() : '';

        $lastHelpDesk = $this->lastHelpDeskReport();
        $lastRequisition = $this->lastRequisitionReport();
        $lastNews = $this->lastNewsReport();
        $lastLeave = $this->lastLeaveRequests();


        return view::make('dashboard_report.dashboard_report')->with('budgetRequisitionReport',$budgetRequestReport)
            ->with('projectReport',$projectReport)->with('vehicleServiceLogReport',$vehicleServiceLogReport)
            ->with('vehicleFuelLogReport',$vehicleFuelLogReport)->with('crmReport',$crmReport)
            ->with('lastHelpDesk',$lastHelpDesk)->with('lastNews',$lastNews)->with('requisitionReport',$requisitionReport)
            ->with('lastLeave',$lastLeave)->with('lastRequisition',$lastRequisition);
    }

    public function addItemToArray($itemKey,$itemVal,&$array){
        if(!empty($array)) {
            foreach ($array as $key => $var) {
                if($key == $itemKey){
                    $newValue = $itemVal+$var;
                    $array[$itemKey] = $newValue;
                }
            }
        }else{
            $array[$itemKey] = $itemVal;
        }

    }

    public function monthName($monthNum){

        switch ($monthNum) {
            case '1' :
                $month = 'Jan';
                break;
            case '2':
                $month = 'Feb';
                break;
            case '3':
                $month = 'March';
                break;
            case '4' :
                $month = 'April';
                break;
            case '5':
                $month = 'May';
                break;
            case '6':
                $month = 'June';
                break;
            case '7' :
                $month = 'July';
                break;
            case '8':
                $month = 'August';
                break;
            case '9':
                $month = 'Sept';
                break;
            case '10' :
                $month = 'Oct';
                break;
            case '11':
                $month = 'Nov';
                break;
            case '12':
                $month = 'Dec';
                break;

            default:
                $month = 'Jan';
                break;
        }
        return $month;
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

    public function requisitionBudget(){
        $thisMonth = date('n'); $thisYear = date('Y');
        $requisition = Requisition::getAllDataByMonthYear($thisMonth,$thisYear);

        $deptReqArr = [];
        $deptForBudget = [];
        foreach($requisition as $val){
            $deptForBudget[] = $val->dept_id;
            $dept = Department::firstRow('id',$val->dept_id);
            //$this->addItemToArray($dept->dept_name,$val->amount,$deptReqArr);
            if(!empty($deptReqArr)) {
                foreach ($deptReqArr as $key => $var) {
                    if($key == $dept->dept_name){
                        $newValue = $val->amount+$var;
                        $deptReqArr[$dept->dept_name] = $newValue;
                    }
                }
            }else{
                $deptReqArr[$dept->dept_name] = $val->amount;
            }


        }
        $finYear = FinancialYear::firstRow('active_status',Utility::STATUS_ACTIVE);
        if(!empty($finYear)) {
            $budgetArr = [];
            $budgetMonth = $this->monthName($thisMonth);
            $budgetData = Budget::specialColumnsOneRow('fin_year_id',$finYear->id,$budgetMonth);

            $deptForBudgetFilter = array_unique($deptForBudget);

            foreach($deptForBudgetFilter as $deptId){
                $dept = Department::firstRow('id',$deptId);
                $amount = Utility::sumColumnDataCondition2('budget','dept_id',$deptId,'fin_year_id',$finYear->id,$budgetMonth);
                $sumAmount = ($amount != '') ? $amount : 0;
                $budgetArr[$dept->dept_name] = $sumAmount;
            }

            $compare = Utility::budgetRequestCompare($deptReqArr,$budgetArr);
            //print_r($budgetArr);exit();
            return $compare;

        }

        return [];

    }

    public function requisitionBudgetUsers($dept){
        $thisMonth = date('n'); $thisYear = date('Y');
        $requisition = Requisition::specialColumnsByMonthYear('dept_id',$dept,$thisMonth,$thisYear);

        $categoryReqArr = [];
        $categoryForBudget = [];
        foreach($requisition as $val){
            $categoryForBudget[] = $val->req_cat;
            $category = RequestCategory::firstRow('id',$val->req_cat);
            $this->addItemToArray($category->request_name,$val->amount,$categoryReqArr);

        }
        $finYear = FinancialYear::firstRow('active_status',Utility::STATUS_ACTIVE);
        if(!empty($finYear)) {
            $budgetArr = [];
            $budgetMonth = $this->monthName($thisMonth);
            $budgetData = Budget::specialColumnsOneRow('fin_year_id',$finYear->id,$budgetMonth);

            $categoryForBudgetFilter = array_unique($categoryForBudget);
            foreach($categoryForBudgetFilter as $catId){
                $budgetCat = RequestCategory::firstRow('id',$catId);
                $amount = Utility::sumColumnDataCondition('budget','dept_id',$dept,'request_cat_id',$catId,$budgetMonth);
                $sumAmount = (!empty($amount)) ? $amount : 0;
                $budgetArr[$budgetCat->request_name] = $sumAmount;
            }

            $compare = Utility::budgetRequestCompare($categoryReqArr,$budgetArr);
            return $compare;

        }

        return $categoryReqArr;

    }

    public function requisition(){
        $thisMonth = date('n'); $thisYear = date('Y');
        $requisition = Requisition::getAllDataByMonthYear($thisMonth,$thisYear);

        $deptReqArr = [];
        $deptForBudget = [];
        foreach($requisition as $val){
            $deptForBudget[] = $val->dept_id;
            $dept = Department::firstRow('id',$val->dept_id);
            $this->addItemToArray($dept->dept_name,$val->amount,$deptReqArr);

        }

        return $deptReqArr;

    }

    public function requisitionUsers($dept){
        $thisMonth = date('n'); $thisYear = date('Y');
        $requisition = Requisition::specialColumnsByMonthYear('dept_id',$dept,$thisMonth,$thisYear);

        $categoryReqArr = [];
        $categoryForBudget = [];
        foreach($requisition as $val){
            $categoryForBudget[] = $val->req_cat;
            $category = RequestCategory::firstRow('id',$val->req_cat);
            $this->addItemToArray($category->request_name,$val->amount,$categoryReqArr);

        }

        return $categoryReqArr;

    }

    public function projectReport($userId = 0){

        $project = new \stdClass();
        $projectData = Project::getAllData();
        if($userId == 0){
            $userProjects = ProjectTeam::specialColumns('user_id',$userId);
            $userProjectArr = [];
            foreach($userProjects as $pro){
                $userProjectArr[] = $pro->project_id;
            }
            $projectData = Project::massData('id',$userProjectArr);
        }

        $openProject = []; $closedProject = []; $overdueProject = []; $todayProject = []; $ProjectStatus = [];

        $statusOpen = [1,2,5]; //KEY FROM TASK STATUS
        $statusClosed = 3; $currDate = date('Y-m-d');

        $projectHoldArr = []; $projectMainArr = []; $arrStatus = Utility::TASK_STATUS;

        foreach($projectData as $val){

            foreach($arrStatus as $key => $var){
                if($key == $val->project_status){
                    $projectHoldArr[$key][] = $val->project_status;
                    $projectMainArr[$var][] = $val->project_status;
                }
            }

            if(in_array($val->project_status,$statusOpen)){
                $openProject[] = $val->project_status;
            }
            if($val->project_status == $statusClosed){
                $closedProject[] = $val->project_status;
            }
            if($currDate > $val->end_date && $val->project_status != $statusClosed){
                $overdueProject[] = $val->end_date;
            }
            if($currDate <= $val->end_date && $val->project_status != $statusClosed){
                $todayProject[] = $currDate;
            }

        }

        $project->openProject = count($openProject);
        $project->closedProject = count($closedProject);
        $project->projectStatus = $this->countStatus($projectMainArr);
        $project->overdueProject = count($overdueProject);
        $project->todayProject = count($todayProject);
        $project->totalProject = $projectData->count();

        return $project;

    }

    public function crmReport(){

        $chartObject = new \stdClass();
        $thisYear = date('Y');
        $mainData = CrmOpportunity::getAllDataByYear($thisYear);

        $stageOpportCount = []; $overdueOpport = []; $opportClosingToday = [];
        $ongoingOpport = []; $wonOpport = []; $lostOpport = [];
        $ongoingOpportAmount = []; $wonOpportAmount = []; $lostOpportAmount = [];
        $currDate = date('Y-m-d');
        foreach($mainData as $val){

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

        $chartObject->overdueOpport = count($overdueOpport);
        $chartObject->opportClosingToday = count($opportClosingToday);
        $chartObject->ongoingOpport = count($ongoingOpport);
        $chartObject->wonOpport = count($wonOpport);
        $chartObject->lostOpport = count($lostOpport);
        $chartObject->ongoingOpportAmount = array_sum($ongoingOpportAmount);
        $chartObject->wonOpportAmount = array_sum($wonOpportAmount);
        $chartObject->lostOpportAmount = array_sum($lostOpportAmount);

        return $chartObject;

    }

    public function vehicleServiceLogReport(){
        $chartObject = new \stdClass();
        $thisYear = date('Y'); $thisMonth = date('n');
        $mainData = VehicleServiceLog::getAllDataByMonthYear($thisMonth,$thisYear);
        $totalBill = []; $workshopMileage = [];
        foreach($mainData as $val){
            $totalBill[] = $val->total_price;
            $workshopMileage[] = $val->mileage_out - $val->mileage_in;

        }

        $chartObject->workshopMileage = array_sum($workshopMileage);
        $chartObject->totalBill = array_sum($totalBill);

        return $chartObject;

    }

    public function vehicleFuelLogReport(){

        $chartObject = new \stdClass();
        $thisYear = date('Y'); $thisMonth = date('n');
        $mainData = VehicleFuelLog::getAllDataByMonthYear($thisMonth,$thisYear);

        $totalLiters = []; $totalPurchasePrice = []; $allMileage = []; $firstMileage = 0; $lastMileage = 0;
        $totalMileage = 0;
        if($mainData->count() > 0) {
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

        return $chartObject;

    }

    public function lastHelpDeskReport()
    {

        $mainData = (Auth::user()->role == Utility::ADMIN) ? Helpdesk::customDataPaginate('5') : Helpdesk::customDataPaginate2('user_id',Auth::user()->id,'5');

        return $mainData;

    }

    public function lastRequisitionReport()
    {

        $mainData = (in_array(Auth::user()->role,Utility::TOP_USERS)) ? Requisition::customDataPaginate('5') : Requisition::customDataPaginate2('request_user',Auth::user()->id,'5');

        return $this->filterData($mainData);

    }

    //FILETER REQUISITION DATA
    public function filterData($dbData){
        foreach($dbData as $data) {
            if ($data->approved_users != '') {
                $jsonUsers = json_decode($data->approved_users,true);
                if (count($jsonUsers) > 0) {
                    $data->approved_by = User::massData('id', $jsonUsers);
                }
            }

            if ($data->complete_status != 1){
                $jsonLevels = json_decode($data->approval_level, true);
            $jsonApp = json_decode($data->approval_json, true);
            $leastLevel = min($jsonLevels);
            $nextUser = $jsonApp[$leastLevel];
                $data->next_user = $nextUser.Auth::user()->id;
            if ($nextUser == Auth::user()->id) {
                $data->approval_view = 1;
            } else {
                $data->approval_view = 0;
            }
         }

        }
        return $dbData;
    }   //END OF FILTERING DATA

    public function lastNewsReport()
    {

        $mainData = News::customDataPaginate('5');

        return $mainData;

    }

    public function lastLeaveRequests()
    {

        $mainData = (in_array(Auth::user()->role,Utility::TOP_USERS)) ? LeaveLog::customDataPaginate('5') : LeaveLog::customDataPaginate2('request_user',Auth::user()->id,'5');

        return $mainData;

    }


}
