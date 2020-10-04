<?php

namespace App\Http\Controllers;

use App\Helpers\Approve;
use App\model\AccountChart;
use App\model\ApprovalSys;
use App\model\Budget;
use App\model\BudgetSummary;
use App\model\FinancialYear;
use App\model\ProjectTeam;
use App\model\RequestAccess;
use App\model\RequestCategory;
use App\model\AccountCategory;
use App\model\Department;
use App\Helpers\Utility;
use App\model\RequestType;
use App\model\Requisition;
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

class BudgetReportController extends Controller
{
    //

    //METHODS FOR PROCESSING BUDGET VS BUDGET REPORT
    public function budgetBudgetReport(Request $request)
    {
        //
        //$req = new Request();
        $budget = BudgetSummary::getAllData();

        return view::make('budget_report.budget_budget')->with('budget',$budget);

    }

    public function searchBudgetBudgetCompare(Request $request)
    {

        $budget1 = $request->input('budget1');
        $budget2 = $request->input('budget2');
        if(!empty($budget1) && !empty($budget2)) {
            $budgetData1 = Budget::specialColumns('budget_id', $budget1);
            $budgetData2 = Budget::specialColumns('budget_id', $budget2);

            $budgetDetail1 = BudgetSummary::firstRow('id', $budget1);
            $budgetDetail2 = BudgetSummary::firstRow('id', $budget2);

            $processBudget1 = $this->processBudget($budgetData1);
            $processBudget2 = $this->processBudget($budgetData2);
            $chartData = Utility::budgetBudgetCompare($processBudget1->budgetArray, $processBudget2->budgetArray);

            return view::make('budget_report.budget_budget_reload')->with('budget1', $processBudget1)
                ->with('budget2', $processBudget2)->with('chart_data', $chartData)
                ->with('budgetDetail1', $budgetDetail1)->with('budgetDetail2', $budgetDetail2);
        }else{
            return 'Please ensure to select  two budgets to compare';
        }


    }

    //END OF METHODS FOR PROCESSING BUDGET VS BUDGET REPORT


    // SEARCH BUDGET ARCHIVE METHOD
    public function budgetArchive(Request $request)
    {
        //
        //$req = new Request();
        $financialYear = FinancialYear::getAllData();
        $department = Department::getAllData();

        return view::make('budget_report.archive')->with('financialYear',$financialYear)->with('department',$department);

    }

    public function searchBudgetArchive(Request $request)
    {

        $finYear = $request->input('financial_year');
        $dept = $request->input('department');

        //PROCESS SEARCH


        $budgetAccountChartDimension = $this->processAccountChartBudget($finYear,$dept);
        $budgetRequestCategoryDimension = $this->processRequestCategoryBudget($finYear,$dept);

        return view::make('budget_report.archive_reload')->with('budgetAccountChartDimension',$budgetAccountChartDimension)
            ->with('budgetRequestCategoryDimension',$budgetRequestCategoryDimension);

    }

    public function processRequestCategoryBudget($finYear,$dept){
        $jan = 0; $feb = 0; $march = 0; $april = 0; $may = 0; $june = 0; $july = 0; $august = 0;
        $sept = 0; $oct = 0; $nov = 0; $dec = 0; $fiQuarter = 0; $sQuarter = 0; $tQuarter = 0; $foQuarter = 0;
        $totalBudget = 0;

        $mainData = [];
        if(!in_array(0,$finYear) && in_array(0,$dept)){
            $mainData = Budget::massData('fin_year_id', $finYear);
        }

        if(in_array(0,$finYear) && !in_array(0,$dept)){
            $mainData = Budget::massData('dept_id', $dept);
        }

        if(in_array(0,$finYear) && in_array(0,$dept)){
            $mainData = Budget::getAllData();
        }

        if(!in_array(0,$finYear) && !in_array(0,$dept)){
            $mainData = Budget::massData2('fin_year_id', $finYear, 'dept_id', $dept);
        }

        foreach($mainData as $data){

            $jan += $data->jan;
            $feb += $data->feb;
            $march += $data->march;
            $april += $data->april;
            $may += $data->may;
            $june += $data->june;
            $july += $data->july;
            $august += $data->august;
            $sept += $data->sept;
            $oct += $data->oct;
            $nov += $data->nov;
            $dec += $data->dec;
            $fiQuarter += $data->first_quarter;
            $sQuarter += $data->second_quarter;
            $tQuarter += $data->third_quarter;
            $foQuarter += $data->fourth_quarter;
            $totalBudget += $data->total_cat_amount;

        }

        $mainData->totalJan = $jan;
        $mainData->totalFeb = $feb;
        $mainData->totalMarch = $march;
        $mainData->totalApril = $april;
        $mainData->totalMay = $may;
        $mainData->totalJune = $june;
        $mainData->totalJuly = $july;
        $mainData->totalAugust = $august;
        $mainData->totalSept = $sept;
        $mainData->fiQuarter = $fiQuarter;
        $mainData->totalOct = $oct;
        $mainData->totalNov = $nov;
        $mainData->totalDec = $dec;
        $mainData->sQuarter = $sQuarter;
        $mainData->tQuarter = $tQuarter;
        $mainData->foQuarter = $foQuarter;
        $mainData->totalBudget = $totalBudget;


        return $mainData;
    }

    public function processAccountChartBudget($finYear,$dept){
        $jan = 0; $feb = 0; $march = 0; $april = 0; $may = 0; $june = 0; $july = 0; $august = 0;
        $sept = 0; $oct = 0; $nov = 0; $dec = 0; $fiQuarter = 0; $sQuarter = 0; $tQuarter = 0; $foQuarter = 0;
        $totalBudget = 0;

        $mainData = []; $accounts = []; $fetchOnlyAcctId = []; $resultType = 0;
        if(!in_array(0,$finYear) && in_array(0,$dept)){
            $mainData = Budget::massData('fin_year_id', $finYear);
            $fetchOnlyAcctId = Budget::massDataOneRow('fin_year_id', $finYear,'acct_id');
        }

        if(in_array(0,$finYear) && !in_array(0,$dept)){
            $mainData = Budget::massData('dept_id', $dept);
            $fetchOnlyAcctId = Budget::massDataOneRow('dept_id', $dept,'acct_id');
        }

        if(in_array(0,$finYear) && in_array(0,$dept)){
            $mainData = Budget::getAllDataOrderByGroupBy();
            $fetchOnlyAcctId = Budget::getAllDataOneRow('acct_id');
        }

        if(!in_array(0,$finYear) && !in_array(0,$dept)){
            $mainData = Budget::massData2('fin_year_id', $finYear, 'dept_id', $dept);
            $fetchOnlyAcctId = Budget::massData2OneRow('fin_year_id', $finYear, 'dept_id', $dept,'acct_id');
        }

        if(!empty($fetchOnlyAcctId)){
            foreach($fetchOnlyAcctId as $data){
                $accounts[] = $data->acct_id;
            }
        }

        $accountChart = AccountChart::massDataAlphaOrder('account_chart.id',$accounts);

        $totalJan = 0; $totalFeb = 0; $totalMarch = 0; $totalApril = 0; $totalMay = 0; $totalJune = 0; $totalJuly = 0; $totalAugust = 0;
        $totalSept = 0; $totalOct = 0; $totalNov = 0; $totalDec = 0; $totalFiQuarter = 0; $totalSQuarter = 0; $totalTQuarter = 0; $totalFoQuarter = 0;
        $totalBudget = 0;

        foreach($accountChart as $data){
            $jan = 0; $feb = 0; $march = 0; $april = 0; $may = 0; $june = 0; $july = 0; $august = 0;
            $sept = 0; $oct = 0; $nov = 0; $dec = 0; $fiQuarter = 0; $sQuarter = 0; $tQuarter = 0; $foQuarter = 0;
            $totalCatAmount = 0; $deptId = '';
            $budgetForAccount = [];
            if(!in_array(0,$finYear) && in_array(0,$dept)){
                $budgetForAccount = Budget::massDataCondition('fin_year_id', $finYear,'acct_id',$data->id);
            }
            if(in_array(0,$finYear) && !in_array(0,$dept)){
                $budgetForAccount = Budget::massDataCondition('dept_id', $dept,'acct_id',$data->id);
            }
            if(in_array(0,$finYear) && in_array(0,$dept)){
                $budgetForAccount = Budget::specialColumns('acct_id',$data->id);
            }
            if(!in_array(0,$finYear) && !in_array(0,$dept)){
                $budgetForAccount = Budget::massData2Condition('fin_year_id', $finYear, 'dept_id', $dept,'acct_id',$data->id);
            }

            foreach($budgetForAccount as $data2){    //ADD UP FOR ACCOUNTS THAT EXIST TWICE

                $deptId = $data2->dept_id;

                $jan += $data2->jan;
                $feb += $data2->feb;
                $march += $data2->march;
                $april += $data2->april;
                $may += $data2->may;
                $june += $data2->june;
                $july += $data2->july;
                $august += $data2->august;
                $sept += $data2->sept;
                $oct += $data2->oct;
                $nov += $data2->nov;
                $dec += $data2->dec;
                $fiQuarter += $data2->first_quarter;
                $sQuarter += $data2->second_quarter;
                $tQuarter += $data2->third_quarter;
                $foQuarter += $data2->fourth_quarter;
                $totalCatAmount += $data2->total_cat_amount;
            }

            $data->department = Department::firstRow('id',$deptId);

            $data->jan = $jan;
            $data->feb = $feb;
            $data->march = $march;
            $data->april = $april;
            $data->may = $may;
            $data->june = $june;
            $data->july = $july;
            $data->august = $august;
            $data->sept = $sept;
            $data->first_quarter = $fiQuarter;
            $data->oct = $oct;
            $data->nov = $nov;
            $data->dec = $dec;
            $data->second_quarter = $sQuarter;
            $data->third_quarter = $tQuarter;
            $data->fourth_quarter = $foQuarter;
            $data->total_cat_amount = $totalCatAmount;

            //GET A TOTAL OF THE MONTHS, QUARTERS AND OVERALL TOTAL
            $totalJan += $jan;
            $totalFeb += $feb;
            $totalMarch += $march;
            $totalApril += $april;
            $totalMay += $may;
            $totalJune += $june;
            $totalJuly += $july;
            $totalAugust += $august;
            $totalSept += $sept;
            $totalFiQuarter += $fiQuarter;
            $totalOct += $oct;
            $totalNov += $nov;
            $totalDec += $dec;
            $totalSQuarter += $sQuarter;
            $totalTQuarter += $tQuarter;
            $totalFoQuarter += $foQuarter;
            $totalBudget += $totalCatAmount;

        }

        $accountChart->totalJan = $totalJan;
        $accountChart->totalFeb = $totalFeb;
        $accountChart->totalMarch = $totalMarch;
        $accountChart->totalApril = $totalApril;
        $accountChart->totalMay = $totalMay;
        $accountChart->totalJune = $totalJune;
        $accountChart->totalJuly = $totalJuly;
        $accountChart->totalAugust = $totalAugust;
        $accountChart->totalSept = $totalSept;
        $accountChart->fiQuarter = $totalFiQuarter;
        $accountChart->totalOct = $totalOct;
        $accountChart->totalNov = $totalNov;
        $accountChart->totalDec = $totalDec;
        $accountChart->sQuarter = $totalSQuarter;
        $accountChart->tQuarter = $totalTQuarter;
        $accountChart->foQuarter = $totalFoQuarter;
        $accountChart->totalBudget = $totalBudget;


        return $accountChart;
    }
    //END OF SEARCHING FOR BUDGET ARCHIVE METHODS


    //METHODS FOR PROCESSING REQUISITION VS BUDGET REPORT
    public function budgetRequisitionReport(Request $request)
    {
        //
        //$req = new Request();
        $financialYear = FinancialYear::getAllData();
        $department = Department::getAllData();
        $budget = BudgetSummary::getAllData();
        $reqCat = RequestCategory::getAllData();
        $requestType = RequestType::getAllData();
        $project = ProjectTeam::specialColumns('user_id',Auth::user()->id);
        $currSymbol = session('currency')['symbol'];
        $dept = Department::getAllData();

        $detectHod = Utility::detectHOD(Auth::user()->id);
        $requestAccess = RequestAccess::getAllData();
        $access = Utility::detectRequestAccess($requestAccess);
        $approveSys = ApprovalSys::getAllData();
        $approveAccess = Approve::approveAccess($approveSys);


        return view::make('budget_report.budget_requisition')->with('financialYear',$financialYear)
            ->with('department',$department)->with('budget',$budget)->with('reqType',$requestType)
            ->with('project',$project)->with('reqCat',$reqCat)->with('appAccess',$approveAccess)
            ->with('curr_symbol',$currSymbol)->with('access',$access)->with('dept',$dept)
            ->with('detectHod',$detectHod);

    }

    public function allOrSome($array){
        $data = '';
        $mainData = '';
        if(is_array($array)){
            if(count($array) >0){
                foreach($array as $var){
                    if($var == 0){
                        $data = 0;
                    }
                }
            }

            if($data == 0 && count($array) >0){
                $mainData = Utility::ALL_DATA;
            }
            if($data != '0' && count($array) >0){
                $mainData = Utility::SELECTED;
            }


        }else{
            $mainData = Utility::ALL_DATA;
        }

        return $mainData;

    }

    public function valdDeptUsers($dept1,$users){

        $data = '';
        if(is_array($dept1)){
            $dept = count($dept1);
            if($dept > 0 && $users == ''){
                $data = 1;
            }
            if($dept > 0 && $users != ''){
                $data = 1;
            }
            if($dept < 1 && $users != ''){
                $data = 0;
            }

        }else{
            if($dept1 == '' && $users == ''){
                $data = 1;
            }else{
                $data = 0;
            }
        }

        return $data;

    }

    public function valSelType($type){
        $dataType = '';
        if($type == Utility::USUAL_REQUEST_TYPE){
            $dataType = Utility::USUAL_REQUEST_TYPE;
        }
        if($type == Utility::PROJECT_REQUEST_TYPE){
            $dataType =  Utility::PROJECT_REQUEST_TYPE;
        }
        if($type == Utility::ALL_DATA){
            $dataType = Utility::ALL_DATA;
        }
        return $dataType;
    }

    public function valReqType($reqType){
        $type = '';
        if($reqType == '1' || $reqType == '2'){
            $type = 1;
        }
        if($reqType == '0'){
            $type = 0;
        }
        return $type;
    }

    public function searchBudgetRequestCompare(Request $request){

        $reportType = $request->input('report_type');
        $dept = $request->input('department');
        $user = $request->input('user');
        $category = $request->input('request_category');
        $type = $request->input('request_type');
        $project = $request->input('project');
        $budgetId = $request->input('budget');

        $deptN = '';
        $userN = (!empty($dept)) ? '' : ($user == '')? '' : User::firstRow('id',$request->input('user'));
        $categoryN = '';
        $typeN = '';
        $projectN = '';

        $fromDate = Utility::standardDate($request->input('from_date'));
        $toDate = Utility::standardDate($request->input('to_date'));
        $code = $this->valdDeptUsers($dept,$user).$this->allOrSome($category).$this->valReqType($type);
        $dateArray = [$fromDate,$toDate];
        $query = [];
        $budget = [];

        if($toDate < $fromDate){
            return  'Please ensure that the start/from date is less than the end/to date';
        }

        if(empty($budgetId)){
            return  'Please select a budget to continue the search report';
        }

        //FIRST CONDITION
        //SELECT FROM WHEN DEPARTMENT IS NOT EMPTY AND TYPE IS SELECTED BUT NOT ALL, CATEGORY SELECTED ALSO NOT ALL
        if($this->valdDeptUsers($dept,$user)== '1' && $this->allOrSome($category) == Utility::SELECTED && $this->valReqType($type) == '1'){

            //DEPARTMENT,CATEGORY SELECTED, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::SELECTED && $this->valSelType($type) == Utility::USUAL_REQUEST_TYPE){

                $deptN = Department::specialColumnsMass('id',$dept);
                $categoryN = RequestCategory::specialColumnsMass('id',$category);
                $typeN = 'Usual Requisition';
                $projectN = 'None';

                $query = Requisition::specialArraySingleColumnsPageDate3('dept_id',$dept,'req_cat',$category,'req_type',$type,$dateArray);
                $budget = Budget::massData3('dept_id',$dept,'request_cat_id',$category,'budget_id',$budgetId);

            }
            //DEPARTMENT IS ALL,CATEGORY SELECTED, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::ALL_DATA && $this->valSelType($type) == Utility::USUAL_REQUEST_TYPE){

                $deptN = 'All';
                $categoryN = RequestCategory::specialColumnsMass('id',$category);
                $typeN = 'Usual Requisition';
                $projectN = 'None';

                $query = Requisition::specialArraySingleColumns1PageDate2('req_cat',$category,'req_type',$type,$dateArray);
                $budget = Budget::massData2('request_cat_id',$category,'budget_id',$budgetId);
            }

            //DEPARTMENT,CATEGORY,TYPE SELECTED
            if($this->allOrSome($dept) == Utility::SELECTED && $this->valSelType($type) == Utility::PROJECT_REQUEST_TYPE){

                //PROJECT IS ALL,CATEGORY,DEPARTMENT SELECTED
                if($this->allOrSome($dept) == Utility::SELECTED && $this->allOrSome($project) == Utility::ALL_DATA){

                    $deptN = Department::specialColumnsMass('id',$dept);
                    $categoryN = RequestCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Requisition';
                    $projectN = 'All';

                    $query = Requisition::specialArraySingleColumnsPageDate3('dept_id',$dept,'req_cat',$category,'req_type',$type,$dateArray);
                    $budget = Budget::massData3('dept_id',$dept,'request_cat_id',$category,'budget_id',$budgetId);
                }
                //PROJECT,CATEGORY,DEPARTMENT SELECTED
                if($this->allOrSome($dept) == Utility::SELECTED && $this->allOrSome($project) == Utility::SELECTED){

                    $deptN = Department::specialColumnsMass('id',$dept);
                    $categoryN = RequestCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Requisition';
                    $projectN = Project::specialColumnsMass('id',$project);

                    $query = Requisition::specialArrayColumnsPageDate3('dept_id',$dept,'req_cat',$category,'proj_id',$project,$dateArray);
                    $budget = Budget::massData3('dept_id',$dept,'request_cat_id',$category,'budget_id',$budgetId);
                }
            }

            //DEPARTMENT IS ALL,CATEGORY,TYPE SELECTED
            if($this->allOrSome($dept) == Utility::ALL_DATA && $this->valSelType($type) == Utility::PROJECT_REQUEST_TYPE){

                //PROJECT IS ALL,CATEGORY,DEPARTMENT SELECTED
                if($this->allOrSome($dept) == Utility::ALL_DATA && $this->allOrSome($project) == Utility::ALL_DATA){

                    $deptN = 'All';
                    $categoryN = RequestCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Requisition';
                    $projectN = 'All';

                    $query = Requisition::specialArraySingleColumns1PageDate2('req_cat',$category,'req_type',$type,$dateArray);
                    $budget = Budget::massData2('request_cat_id',$category,'budget_id',$budgetId);
                }
                //PROJECT,CATEGORY,DEPARTMENT SELECTED
                if($this->allOrSome($dept) == Utility::ALL_DATA && $this->allOrSome($project) == Utility::SELECTED){

                    $deptN = 'All';
                    $categoryN = RequestCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Requisition';
                    $projectN = Project::specialColumnsMass('id',$project);

                    $query = Requisition::specialArrayColumnsPageDate2('req_cat',$category,'proj_id',$project,$dateArray);
                    $budget = Budget::massData2('request_cat_id',$category,'budget_id',$budgetId);
                }
            }

        }

        //SECOND CONDITION
        //SELECT FROM WHEN USER IS NOT EMPTY AND TYPE IS SELECTED BUT NOT ALL, CATEGORY SELECTED ALSO NOT ALL
        if($this->valdDeptUsers($dept,$user)== '0' && $this->allOrSome($category) == Utility::SELECTED && $this->valReqType($type) == '1'){

            //USER,CATEGORY SELECTED, TYPE IS USUAL REQUEST TYPE
            if($this->valSelType($type) == Utility::USUAL_REQUEST_TYPE){

                $deptN = 'None';
                $categoryN = RequestCategory::specialColumnsMass('id',$category);
                $typeN = 'Usual Request';
                $projectN = 'None';

                $query = Requisition::specialArraySingleColumns2PageDate3('request_user',$user,'req_cat',$category,'req_type',$type,$dateArray);
                $budget = Budget::massData2('request_cat_id',$category,'budget_id',$budgetId);
            }

            //USER,CATEGORY,TYPE SELECTED
            if($this->valSelType($type) == Utility::PROJECT_REQUEST_TYPE){

                //PROJECT IS ALL,CATEGORY,USER SELECTED
                if($this->allOrSome($category) == Utility::SELECTED && $this->allOrSome($project) == Utility::ALL_DATA){

                    $deptN = 'None';
                    $categoryN = RequestCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Request';
                    $projectN = 'All';

                    $query = Requisition::specialArraySingleColumns2PageDate3('request_user',$user,'req_cat',$category,'req_type',$type,$dateArray);
                    $budget = Budget::massData2('request_cat_id',$category,'budget_id',$budgetId);
                }
                //PROJECT,CATEGORY,USER SELECTED
                if($this->allOrSome($category) == Utility::SELECTED && $this->allOrSome($project) == Utility::SELECTED){

                    $deptN = 'None';
                    $categoryN = RequestCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Request';
                    $projectN = Project::specialColumnsMass('id',$project);

                    $query = Requisition::specialArrayColumnsPageDate3('request_user',$user,'req_cat',$category,'proj_id',$project,$dateArray);
                    $budget = Budget::massData2('request_cat_id',$category,'budget_id',$budgetId);
                }
            }


        }

        //THIRD CONDITION
        //SELECT FROM WHEN DEPARTMENT IS NOT EMPTY AND TYPE IS SELECTED BUT NOT ALL, CATEGORY SELECTED ALSO NOT ALL
        if($this->valdDeptUsers($dept,$user)== '1' && $this->allOrSome($category) == Utility::ALL_DATA && $this->valReqType($type) == '1'){

            //DEPARTMENT,CATEGORY SELECTED, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::SELECTED && $this->valSelType($type) == Utility::USUAL_REQUEST_TYPE){

                $deptN = Department::specialColumnsMass('id',$dept);
                $categoryN = RequestCategory::specialColumnsMass('id',$category);
                $typeN = 'Usual Request';
                $projectN = 'None';

                $query = Requisition::specialArrayColumnsPageDate2('dept_id',$dept,'req_type',$type,$dateArray);
                $budget = Budget::massData2('dept_id',$dept,'budget_id',$budgetId);
            }
            //DEPARTMENT IS ALL,CATEGORY SELECTED, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::ALL_DATA && $this->valSelType($type) == Utility::USUAL_REQUEST_TYPE){

                $deptN = Department::getAllData();
                $categoryN = RequestCategory::specialColumnsMass('id',$category);
                $typeN = 'Usual Request';
                $projectN = 'None';

                $query = Requisition::specialColumnsPageDate('req_type',$type,$dateArray);
                $budget = Budget::massData('budget_id',$budgetId);
            }

            //DEPARTMENT,CATEGORY ALL,TYPE SELECTED
            if($this->allOrSome($dept) == Utility::SELECTED && $this->valSelType($type) == Utility::PROJECT_REQUEST_TYPE){

                //PROJECT IS ALL,CATEGORY,DEPARTMENT SELECTED
                if($this->allOrSome($dept) == Utility::SELECTED && $this->allOrSome($project) == Utility::ALL_DATA){

                    $deptN = Department::specialColumnsMass('id',$dept);
                    $categoryN = RequestCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Request';
                    $projectN = 'All';

                    $query = Requisition::specialArrayColumnsPageDate2('dept_id',$dept,'req_type',$type,$dateArray);
                    $budget = Budget::massData2('dept_id',$dept,'budget_id',$budgetId);
                }
                //PROJECT,CATEGORY,DEPARTMENT SELECTED
                if($this->allOrSome($dept) == Utility::SELECTED && $this->allOrSome($project) == Utility::SELECTED){

                    $deptN = Department::specialColumnsMass('id',$dept);
                    $categoryN = RequestCategory::specialColumnsMass('id',$category);
                    $typeN = 'Project Request';
                    $projectN = Project::specialColumnsMass('id',$project);

                    $query = Requisition::specialArrayColumnsPageDate2('dept_id',$dept,'proj_id',$project,$dateArray);
                    $budget = Budget::massData2('dept_id',$dept,'budget_id',$budgetId);
                }
            }

            //DEPARTMENT IS ALL,CATEGORY ALL,TYPE SELECTED
            if($this->allOrSome($dept) == Utility::ALL_DATA && $this->valSelType($type) == Utility::PROJECT_REQUEST_TYPE){

                //PROJECT IS ALL,CATEGORY ALL,DEPARTMENT ALL
                if($this->allOrSome($dept) == Utility::ALL_DATA && $this->allOrSome($project) == Utility::ALL_DATA){

                    $deptN = 'All';
                    $categoryN = 'All';
                    $typeN = 'Project Request';
                    $projectN = 'All';

                    $query = Requisition::specialColumnsPageDate('req_type',$type,$dateArray);
                }
                //PROJECT,CATEGORY,DEPARTMENT ALL
                if($this->allOrSome($dept) == Utility::ALL_DATA && $this->allOrSome($project) == Utility::SELECTED){

                    $deptN = 'All';
                    $categoryN = 'All';
                    $typeN = 'Project Request';
                    $projectN = Project::specialColumnsMass('id',$project);

                    $query = Requisition::specialColumnsPageDate('proj_id',$project,$dateArray);
                    $budget = Budget::massData('budget_id',$budgetId);

                }
            }

        }

        //FOURTH CONDITION
        //SELECT FROM WHEN USER IS NOT EMPTY AND TYPE IS SELECTED BUT NOT ALL, CATEGORY SELECTED ALSO NOT ALL
        if($this->valdDeptUsers($dept,$user)== '0' && $this->allOrSome($category) == Utility::ALL_DATA && $this->valReqType($type) == '1'){

            //DEPARTMENT,CATEGORY ALL, TYPE IS ALL
            if($this->valSelType($type) == Utility::USUAL_REQUEST_TYPE){

                $deptN = 'None';
                $categoryN = 'All';
                $typeN = 'Usual Requisition';
                $projectN = 'None';

                $query = Requisition::specialColumnsPageDate2('request_user',$user,'req_type',$type,$dateArray);
                $budget = Budget::massData('budget_id',$budgetId);
            }

            //USER,CATEGORY,TYPE SELECTED
            if($this->valSelType($type) == Utility::PROJECT_REQUEST_TYPE){

                //PROJECT IS ALL,CATEGORY IS ALL,USER SELECTED
                if($this->allOrSome($project) == Utility::ALL_DATA){

                    $deptN = 'None';
                    $categoryN = 'All';
                    $typeN = 'Project Requisition';
                    $projectN = 'All';

                    $query = Requisition::specialColumnsPageDate2('request_user',$user,'req_type',$type,$dateArray);
                    $budget = Budget::massData('budget_id',$budgetId);
                }
                //PROJECT,CATEGORY,DEPARTMENT SELECTED
                if($this->allOrSome($project) == Utility::SELECTED){

                    $deptN = 'None';
                    $categoryN = 'All';
                    $typeN = 'Project Requisition';
                    $projectN = Project::specialColumnsMass('id',$project);
                    $query = Requisition::specialArraySingleColumns1PageDate2('proj_id',$project,'request_user',$user,$dateArray);
                    $budget = Budget::massData('budget_id',$budgetId);
                }
            }


        }

        //FIFTH CONDITION
        //SELECT FROM WHEN USER IS NOT EMPTY AND TYPE IS SELECTED BUT NOT ALL, CATEGORY SELECTED ALSO NOT ALL
        if($this->valdDeptUsers($dept,$user)== '1' && $this->allOrSome($category) == Utility::SELECTED && $this->valReqType($type) == '0'){

            //DEPARTMENT,CATEGORY SELECTED, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::SELECTED){

                $deptN = Department::specialColumnsMass('id',$dept);
                $categoryN = RequestCategory::specialColumnsMass('id',$category);
                $typeN = 'All';
                $projectN = 'All';

                $query = Requisition::specialArrayColumnsPageDate2('req_cat',$category,'dept_id',$dept,$dateArray);
                $budget = Budget::massData3('dept_id',$dept,'request_cat_id',$category,'budget_id',$budgetId);
            }

            //DEPARTMENT IS ALL,CATEGORY ALL, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::ALL_DATA){

                $deptN = 'All';
                $categoryN = RequestCategory::specialColumnsMass('id',$category);
                $typeN = 'All';
                $projectN = 'All';

                $query = Requisition::specialArrayColumnsPageDate('req_cat',$category,$dateArray);
                $budget = Budget::massData2('request_cat_id',$category,'budget_id',$budgetId);
            }

        }

        //SIXTH CONDITION
        //SELECT FROM WHEN USER IS NOT EMPTY AND TYPE IS SELECTED BUT NOT ALL, CATEGORY SELECTED ALSO NOT ALL
        if($this->valdDeptUsers($dept,$user)== '0' && $this->allOrSome($category) == Utility::SELECTED && $this->valReqType($type) == '0'){

            //DEPARTMENT,CATEGORY SELECTED, TYPE IS ALL
            if($this->allOrSome($category) == Utility::SELECTED){

                $deptN = 'None';
                $categoryN = RequestCategory::specialColumnsMass('id',$category);
                $typeN = 'All';
                $projectN = 'All';

                $query = Requisition::specialArraySingleColumns1PageDate2('req_cat',$category,'request_user',$user,$dateArray);
                $budget = Budget::massData2('request_cat_id',$category,'budget_id',$budgetId);
            }

        }

        //SEVENTH CONDITION
        //SELECT FROM WHEN DEPARTMENT IS NOT EMPTY AND TYPE IS ALL, CATEGORY ALL
        if($this->valdDeptUsers($dept,$user)== '1' && $this->allOrSome($category) == Utility::ALL_DATA && $this->valReqType($type) == '0'){

            //DEPARTMENT,CATEGORY SELECTED, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::SELECTED){

                $deptN = Department::specialColumnsMass('id',$dept);
                $categoryN = 'All';
                $typeN = 'All';
                $projectN = 'All';

                $query = Requisition::specialArrayColumnsPageDate('dept_id',$dept,$dateArray);
                $budget = Budget::massData2('dept_id',$dept,'budget_id',$budgetId);
            }

            //DEPARTMENT IS ALL,CATEGORY ALL, TYPE IS ALL
            if($this->allOrSome($dept) == Utility::ALL_DATA){

                $deptN = 'All';
                $categoryN = 'All';
                $typeN = 'All';
                $projectN = 'All';

                $query = Requisition::paginateAllDataDate($dateArray);
                $budget = Budget::massData('budget_id',$budgetId);
            }

        }

        //EIGHT CONDITION
        //SELECT FROM WHEN USER IS NOT EMPTY AND TYPE IS ALL, CATEGORY ALL
        if($this->valdDeptUsers($dept,$user)== '0' && $this->allOrSome($category) == Utility::ALL_DATA && $this->valReqType($type) == '0'){

            //DEPARTMENT,CATEGORY ALL, TYPE IS ALL
            if($this->allOrSome($category) == Utility::ALL_DATA){

                $deptN = 'None';
                $categoryN = 'All';
                $typeN = 'All';
                $projectN = 'All';

                $query = Requisition::specialColumnsPageDate('request_user',$user,$dateArray);
                $budget = Budget::massData('budget_id',$budgetId);
            }

        }

        $newDept = '';
        $newCat = '';
        $newProj = '';
        //return $deptN;
        if(is_object($deptN) && !empty($deptN)){
            $dep = [];
            foreach($deptN as $val){
                $dep[] = $val->dept_name;
            }
            $newDept = implode(',',$dep);
        }else{
            $newDept = $deptN;
        }

        //return json_encode($categoryN);
        if(is_object($categoryN) && !empty($categoryN)){
            $cat = [];
            foreach($categoryN as $val){
                $cat[] = $val->request_name;
            }
            $newCat = implode(',',$cat);
        }else{
            $newCat = $categoryN;
        }

        if(is_object($projectN) && !empty($projectN)){
            $proj = [];
            foreach($projectN as $val){
                $proj[] = $val->project_name;
            }
            $newProj = implode(',',$proj);
        }else{
            $newProj = $projectN;
        }
        $newDept = ($newDept == 'None') ? '': $newDept;
        if(!empty($query)){
            $userN = (!empty($userN)) ? $userN->firstname.' '.$userN->lastname: '';
            $categoryN = (is_array($category)) ? json_encode($category) : $categoryN;
            $projectN = (is_array($project)) ? json_encode($project) : $projectN;

            $sumAmount = $this->sumReportAmount($query);

            //CHECK THE REPORT TYPE IS TABLE OR CHART

            if($reportType == 'chart'){
                $processRequisition = $this->arrangeMonth($query,$fromDate,$toDate);
                $processBudget = $this->processBudget($budget);
                $chartData = Utility::budgetRequestCompare($processRequisition,$processBudget->budgetArray);
                    $this->filterData($query);
                //print_r($chartData); exit();
                return view::make('budget_report.budget_requisition_reload')->with('mainData',$query)
                    ->with('sumAmount',$sumAmount)->with('from_date',$request->input('from_date'))
                    ->with('to_date',$request->input('to_date'))->with('chart_data',$chartData)
                    ->with('deptN',$newDept)->with('userN',$userN)->with('categoryN',$newCat)
                    ->with('typeN',$typeN)->with('projectN',$newProj)->with('budget',$processBudget);
            }

        }else{
            return 'Match not found';
        }


    }

    public function sumReportAmount($query){
        $amountArray = [];
        $sum = 0.00;
        if(!empty($query)){
            foreach($query as $val){
                $amountArray[] = $val->amount;
            }
            $sum = array_sum($amountArray);
        }

        return number_format($sum);
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

                    $stdDate = Utility::standardDate($val->created_at);
                    $getM = date('m',strtotime($stdDate)); $getY = date('Y',strtotime($stdDate));
                    if($getM == $m && $getY == $y){
                        $calcMonthAmtArray[] = $val->amount;
                    }

                }
                $monthYear[$monthName.'-'.$y] = array_sum($calcMonthAmtArray);

            }
        }
        return $monthYear;

    }

    public function processBudget($mainData){
        $jan = 0; $feb = 0; $march = 0; $april = 0; $may = 0; $june = 0; $july = 0; $august = 0;
        $sept = 0; $oct = 0; $nov = 0; $dec = 0; $fiQuarter = 0; $sQuarter = 0; $tQuarter = 0; $foQuarter = 0;
        $totalBudget = 0; $finYear = '';

        $budgetArray = [];

        foreach($mainData as $data){

            $finYear = date("Y", strtotime($data->finYear->fin_date));
            $jan += $data->jan;
            $feb += $data->feb;
            $march += $data->march;
            $april += $data->april;
            $may += $data->may;
            $june += $data->june;
            $july += $data->july;
            $august += $data->august;
            $sept += $data->sept;
            $oct += $data->oct;
            $nov += $data->nov;
            $dec += $data->dec;
            $fiQuarter += $data->first_quarter;
            $sQuarter += $data->second_quarter;
            $tQuarter += $data->third_quarter;
            $foQuarter += $data->fourth_quarter;
            $totalBudget += $data->total_cat_amount;

        }

        $budgetArray['January-'.$finYear] = $jan;
        $budgetArray['February-'.$finYear] = $feb;
        $budgetArray['March-'.$finYear] = $march;
        $budgetArray['April-'.$finYear] = $april;
        $budgetArray['May-'.$finYear] = $may;
        $budgetArray['June-'.$finYear] = $june;
        $budgetArray['July-'.$finYear] = $july;
        $budgetArray['August-'.$finYear] = $august;
        $budgetArray['September-'.$finYear] = $sept;
        $budgetArray['October-'.$finYear] = $oct;
        $budgetArray['November-'.$finYear] = $nov;
        $budgetArray['December-'.$finYear] = $dec;

        $mainData->totalJan = $jan;
        $mainData->totalFeb = $feb;
        $mainData->totalMarch = $march;
        $mainData->totalApril = $april;
        $mainData->totalMay = $may;
        $mainData->totalJune = $june;
        $mainData->totalJuly = $july;
        $mainData->totalAugust = $august;
        $mainData->totalSept = $sept;
        $mainData->fiQuarter = $fiQuarter;
        $mainData->totalOct = $oct;
        $mainData->totalNov = $nov;
        $mainData->totalDec = $dec;
        $mainData->sQuarter = $sQuarter;
        $mainData->tQuarter = $tQuarter;
        $mainData->foQuarter = $foQuarter;
        $mainData->totalBudget = $totalBudget;

        $mainData->budgetArray = $budgetArray;

        return $mainData;
    }

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

    //END OF METHODS FOR PROCESSING REQUISITION VS BUDGET REPORT

}
