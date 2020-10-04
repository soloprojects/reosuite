<?php

namespace App\Http\Controllers;

use App\model\AccountChart;
use App\model\Budget;
use App\model\BudgetSummary;
use App\model\RequestCategory;
use App\model\AccountCategory;
use App\model\Department;
use App\Helpers\Utility;
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

class BudgetController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response

     * Show the form for creating a new resource.
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response

     */
    public function budgetRequestCategoryDimension(Request $request, $id)
    {
        //
        $bExist = []; $bNotExist = [];
        $existingBudget = Budget::specialColumns2OneRow('budget_id',$id,'dept_id',Auth::user()->dept_id,'request_cat_id');
        $deptRequest = RequestCategory::specialColumnsOr2('dept_id',Auth::user()->dept_id,'general',Utility::DETECT);

        foreach($deptRequest as $data){
            $bNotExist[] = $data->id;
        }
        foreach($existingBudget as $data){
            $bExist[] = $data->request_cat_id;
        }

        $budgetData = Budget::specialColumns2Asc('budget_id',$id,'dept_id',Auth::user()->dept_id);
        $emptyRequestIdArr = array_diff($bNotExist,$bExist);

        $mainData = RequestCategory::massDataAlphaOrder('id',$emptyRequestIdArr);
        $this->addCorrespondingAccountChart($mainData);
        $this->addCorrespondingAccountChart2($budgetData);
        //print_r($emptyRequestIdArr); exit();
        $detectHod = Utility::detectHOD(Auth::user()->id);
        $budgetDetail = BudgetSummary::firstRow('id',$id);

            return view::make('budget.main_view')->with('mainData',$mainData)
                ->with('detectHod',$detectHod)->with('budgetDetail',$budgetDetail)->with('budget',$budgetData);

    }

    public function budgetAccountChartDimension(Request $request, $id)
    {
        //
        $bExist = []; $bNotExist = [];
        $existingBudget = Budget::specialColumns2OneRow('budget_id',$id,'dept_id',Auth::user()->dept_id,'acct_id');
        $deptAcctChart = AccountChart::getAllData();

        foreach($deptAcctChart as $data){
            $bNotExist[] = $data->id;
        }
        foreach($existingBudget as $data){
            $bExist[] = $data->acct_id;
        }

        $budgetData = Budget::specialColumns2Asc('budget_id',$id,'dept_id',Auth::user()->dept_id);
        $this->processAccountChartBudget($budgetData);
        $emptyAcctChartIdArr = array_diff($bNotExist,$bExist);

        $mainData = AccountChart::massDataAlphaOrder('account_chart.id',$emptyAcctChartIdArr);
        //print_r($emptyRequestIdArr); exit();
        $detectHod = Utility::detectHOD(Auth::user()->id);
        $budgetDetail = BudgetSummary::firstRow('id',$id);

        return view::make('budget.budget_account_chart')->with('mainData',$mainData)
            ->with('detectHod',$detectHod)->with('budgetDetail',$budgetDetail)->with('budget',$budgetData);

    }


    public function budgetViewRequestCategoryDimension(Request $request, $id)
    {
        //
        $bExist = []; $bNotExist = [];
        $existingBudget = Budget::specialColumns2OneRow('budget_id',$id,'dept_id',Auth::user()->dept_id,'request_cat_id');
        $deptRequest = RequestCategory::specialColumnsOr2('dept_id',Auth::user()->dept_id,'general',Utility::DETECT);

        foreach($deptRequest as $data){
            $bNotExist[] = $data->id;
        }
        foreach($existingBudget as $data){
            $bExist[] = $data->request_cat_id;
        }

        $budgetData = Budget::specialColumns2Asc('budget_id',$id,'dept_id',Auth::user()->dept_id);
        $emptyRequestIdArr = array_diff($bNotExist,$bExist);

        $mainData = RequestCategory::massDataAlphaOrder('id',$emptyRequestIdArr);
        $this->addCorrespondingAccountChart($mainData);
        $this->addCorrespondingAccountChart2($budgetData);
        //print_r($emptyRequestIdArr); exit();
        $detectHod = Utility::detectHOD(Auth::user()->id);
        $budgetDetail = BudgetSummary::firstRow('id',$id);


        return view::make('budget.budget_view')->with('mainData',$mainData)
            ->with('detectHod',$detectHod)->with('budgetDetail',$budgetDetail)->with('budget',$budgetData);

    }

    public function budgetViewAccountChartDimension(Request $request, $id)
    {
        //
        $bExist = []; $bNotExist = [];
        $existingBudget = Budget::specialColumns2OneRow('budget_id',$id,'dept_id',Auth::user()->dept_id,'acct_id');
        $deptAcctChart = AccountChart::getAllData();

        foreach($deptAcctChart as $data){
            $bNotExist[] = $data->id;
        }
        foreach($existingBudget as $data){
            $bExist[] = $data->acct_id;
        }

        $budgetData = Budget::specialColumns2Asc('budget_id',$id,'dept_id',Auth::user()->dept_id);
        $this->processAccountChartBudget($budgetData);
        $emptyAcctChartIdArr = array_diff($bNotExist,$bExist);

        $mainData = AccountChart::massDataAlphaOrder('account_chart.id',$emptyAcctChartIdArr);
        //print_r($emptyRequestIdArr); exit();
        $detectHod = Utility::detectHOD(Auth::user()->id);
        $budgetDetail = BudgetSummary::firstRow('id',$id);

        return view::make('budget.budget_view_account_chart')->with('mainData',$mainData)
            ->with('detectHod',$detectHod)->with('budgetDetail',$budgetDetail)->with('budget',$budgetData);

    }

    /**
     * Show the form for creating a new resource.
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     */

    public function createModify(Request $request)
    {
        //

        $budgetApproval = BudgetSummary::firstRow('id',$request->input('budget'));
        if($budgetApproval->approval_status != Utility::APPROVED){
            $month = $this->monthName($request->input('monthName'));
            $quarter = $request->input('quarterName');

            if($request->input('requestCat') != '') { // DO THIS IF REQUEST CATEGORY IS NOT EMPTY
                $checkCat = Budget::firstRow2('request_cat_id', $request->input('requestCat'),'dept_id', $request->input('deptId'));
                if (!empty($checkCat)) {
                    $dbDATA = [
                        $month => $request->input('monthCatAmount'),
                        $quarter => $request->input('quarterAmount'),
                        'total_cat_amount' => $request->input('totalCatAmount'),
                        'budget_id' => $request->input('budget'),
                        'request_cat_id' => $request->input('requestCat'),
                        'fin_year_id' => $request->input('finYear'),
                        'updated_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                    Budget::defaultUpdate('request_cat_id', $request->input('requestCat'), $dbDATA);

                } else {

                    $dbDATA = [
                        $month => $request->input('monthCatAmount'),
                        $quarter => $request->input('quarterAmount'),
                        'total_cat_amount' => $request->input('totalCatAmount'),
                        'budget_id' => $request->input('budget'),
                        'request_cat_id' => $request->input('requestCat'),
                        'fin_year_id' => $request->input('finYear'),
                        'dept_id' => $request->input('deptId'),
                        'dimension' => Utility::REQUEST_CATEGORY_DIMENSION,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                    Budget::create($dbDATA);

                }

            }else{  //IF AMOUNT WAS ENTERED FROM THE ACCOUNT CHART DIMENSION DO THIS
                $dbUpdateDATA = [
                    $month => $request->input('monthCatAmount'),
                    $quarter => $request->input('quarterAmount'),
                    'total_cat_amount' => $request->input('totalCatAmount'),
                    'budget_id' => $request->input('budget'),
                    'fin_year_id' => $request->input('finYear'),
                    'updated_by' => Auth::user()->id,
                ];
                Budget::defaultUpdate('id', $request->input('dbDataId'), $dbUpdateDATA);

            }

            return response()->json([
                'message2' => 'saved',
                'message' => 'success'
            ]);

        }

        return response()->json([
            'message' => 'warning',
            'message2' => 'Budget have been approved and cannot be modified at the moment'
        ]);

    }

    public function createModifyAccountChartDimension(Request $request)
    {
        //

        $budgetApproval = BudgetSummary::firstRow('id',$request->input('budget'));
        if($budgetApproval->approval_status != Utility::APPROVED){  //CHECK IF BUDGET HAVE BEEN APPROVED
            $month = $this->monthName($request->input('monthName'));
            $quarter = $request->input('quarterName');


            $dbUpdateDATA = [
                $month => $request->input('monthCatAmount'),
                $quarter => $request->input('quarterAmount'),
                'total_cat_amount' => $request->input('totalCatAmount'),
                'budget_id' => $request->input('budget'),
                'fin_year_id' => $request->input('finYear'),
                'updated_by' => Auth::user()->id,
            ];

            if(!empty($request->input('dbDataId'))){   //CHECK WHETHER IS A DEFAULT UPDATE REQUEST

                Budget::defaultUpdate('id', $request->input('dbDataId'), $dbUpdateDATA);

            }else { //IF NOT DEFAULT UPDATE REQUEST, CHECK WHETHER THE ACCOUNT DIMENSION WITH THE DEPT AND ACCOUNT ID EXISTS

                $acctExist = Budget::firstRow3('acct_id', $request->input('accountId'),'dimension', Utility::ACCOUNT_CHART_DIMENSION,'dept_id', $request->input('deptId'));

                if (!empty($acctExist)) {   //IF DATA ENTRY ALREADY EXISTS, THEN UPDATE

                    Budget::defaultUpdate2('acct_id', $request->input('accountId'),'dimension', Utility::ACCOUNT_CHART_DIMENSION, $dbUpdateDATA);

                } else {    //IF DATA ENTRY DOESN'T EXIST THEN CREATE

                    $acctData = AccountChart::firstRow('id', $request->input('accountId'));

                    $dbDATA = [
                        $month => $request->input('monthCatAmount'),
                        $quarter => $request->input('quarterAmount'),
                        'acct_id' => $request->input('accountId'),
                        'acct_cat_id' => $acctData->acct_cat_id,
                        'acct_detail_id' => $acctData->detail_id,
                        'total_cat_amount' => $request->input('totalCatAmount'),
                        'budget_id' => $request->input('budget'),
                        'request_cat_id' => $request->input('requestCat'),
                        'fin_year_id' => $request->input('finYear'),
                        'dept_id' => $request->input('deptId'),
                        'dimension' => Utility::ACCOUNT_CHART_DIMENSION,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                    Budget::create($dbDATA);

                }

            }

            return response()->json([
                'message2' => 'saved',
                'message' => 'success'
            ]);

        }

        return response()->json([
            'message' => 'warning',
            'message2' => 'Budget have been approved and cannot be modified at the moment'
        ]);

    }

    /**
     * Show the form for creating a new resource.
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     */


    public function createModifyAcct(Request $request)
    {
        //

        $budgetApproval = BudgetSummary::firstRow('id', $request->input('budget'));
        if ($budgetApproval->approval_status != Utility::APPROVED) {


            $acctData = AccountChart::firstRow('id', $request->input('accountId'));

            $checkCat = Budget::firstRow2('request_cat_id',$request->input('requestCat'),'dept_id',$request->input('deptId'));
            if(!empty($checkCat)) {
                $dbDATA = [
                    'acct_id' => $request->input('accountId'),
                    'acct_cat_id' => $acctData->acct_cat_id,
                    'acct_detail_id' => $acctData->detail_id,
                    'updated_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Budget::defaultUpdate('request_cat_id', $request->input('requestCat'), $dbDATA);

                return response()->json([
                    'message2' => 'saved',
                    'message' => 'success'
                ]);

            } else {

                    $dbDATA = [
                        'request_cat_id' => $request->input('requestCat'),
                        'acct_id' => $request->input('accountId'),
                        'acct_cat_id' => $acctData->acct_cat_id,
                        'acct_detail_id' => $acctData->detail_id,
                        'budget_id' => $request->input('budget'),
                        'dept_id' => $request->input('deptId'),
                        'fin_year_id' => $request->input('finYear'),
                        'dimension' => Utility::REQUEST_CATEGORY_DIMENSION,
                        'created_by' => Auth::user()->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                    Budget::create($dbDATA);
            }

            return response()->json([
                'message2' => 'saved',
                'message' => 'success'
            ]);

        }

        return response()->json([
            'message' => 'warning',
            'message2' => 'Budget have been approved and cannot be modified at the moment'
        ]);


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
        $deleteId = $request->input('dataId');
        $budgetApproval = BudgetSummary::firstRow('id',$request->input('param'));
        if($budgetApproval->approval_status != Utility::APPROVED) {

            $delete = Budget::destroy($deleteId);
            return response()->json([
                'message2' => 'deleted',
                'message' => 'Data deleted successfully'
            ]);

        }

        return response()->json([
            'message' => 'warning',
            'message2' => 'Budget have been approved and cannot be modified at the moment'
        ]);

    }
    public function addCorrespondingAccountChart($mainData){
        foreach($mainData as $data){
            $accountCategories = AccountChart::specialColumns('acct_cat_id',$data->acct_id);
            $data->accountCategories = $accountCategories;
        }
        return $mainData;
    }

    public function addCorrespondingAccountChart2($mainData){
        $jan = 0; $feb = 0; $march = 0; $april = 0; $may = 0; $june = 0; $july = 0; $august = 0;
        $sept = 0; $oct = 0; $nov = 0; $dec = 0; $fiQuarter = 0; $sQuarter = 0; $tQuarter = 0; $foQuarter = 0;
        $totalBudget = 0;

        foreach($mainData as $data){
            $accountCategories = AccountChart::specialColumns('acct_cat_id',$data->acct_cat_id);
            $data->accountCategories = $accountCategories;

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

    public function processAccountChartBudget($mainData){
        $jan = 0; $feb = 0; $march = 0; $april = 0; $may = 0; $june = 0; $july = 0; $august = 0;
        $sept = 0; $oct = 0; $nov = 0; $dec = 0; $fiQuarter = 0; $sQuarter = 0; $tQuarter = 0; $foQuarter = 0;
        $totalBudget = 0;

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

    public function monthName($monthNum){

        switch ($monthNum) {
            case 'month_1' :
                $month = 'Jan';
                break;
            case 'month_2':
                $month = 'Feb';
                break;
            case 'month_3':
                $month = 'March';
                break;
            case 'month_4' :
                $month = 'April';
                break;
            case 'month_5':
                $month = 'May';
                break;
            case 'month_6':
                $month = 'June';
                break;
            case 'month_7' :
                $month = 'July';
                break;
            case 'month_8':
                $month = 'August';
                break;
            case 'month_9':
                $month = 'Sept';
                break;
            case 'month_10' :
                $month = 'Oct';
                break;
            case 'month_11':
                $month = 'Nov';
                break;
            case 'month_12':
                $month = 'Dec';
                break;

            default:
                $month = 'Jan';
                break;
        }
        return $month;
    }

}
