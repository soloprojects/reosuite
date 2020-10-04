<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\Department;
use App\model\Payroll;
use App\model\Requisition;
use App\model\Company;
use App\model\Tax;
use App\model\AccountJournal;
use App\model\SalaryStructure;
use App\User;
use App\Helpers\Notify;
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
use Illuminate\Support\Facades\Log;

class PayrollController extends Controller

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
        $dept = Department::getAllData();
        $mainData = (in_array(Auth::user()->role,Utility::HR_MANAGEMENT)) ? Payroll::paginateAllData() :Payroll::specialColumnsPage('payroll_status',Utility::APPROVED) ;
        $salarySum = Utility::sumColumnDataCondition('payroll','payroll_status',Utility::PROCESSING,'total_amount');

        if ($request->ajax()) {
            return \Response::json(view::make('payroll.reload',array('mainData' => $mainData,'salarySum' => $salarySum,'dept' => $dept))->render());

        }else{
            return view::make('payroll.main_view')->with('mainData',$mainData)->with('salarySum',$salarySum)
            ->with('dept',$dept);
        }

    }

    public function payrollReport(Request $request)
    {
        //
        //$req = new Request();
        $department = Department::getAllData();

            return view::make('payroll.payroll_report')->with('department',$department);

    }

    public function paySlip(Request $request)
    {
        //
        //$req = new Request();
        $mainData = Payroll::specialColumnsPage2('user_id',Auth::user()->id,'payroll_status',Utility::APPROVED);
        if ($request->ajax()) {
            return \Response::json(view::make('payroll.payslip_reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('payroll.paySlip')->with('mainData',$mainData);
        }

    }

    /**
     * Display payslip item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payslipItem(Request $request)
    {
        //
        $companyInfo = Company::firstRow('active_status',Utility::STATUS_ACTIVE);
        //print_r($companyInfo); exit();
        $payslip = Payroll::firstRow('id',$request->input('dataId'));
        $user = User::firstRow('id',Auth::user()->id);
        $tax = Tax::firstRow('id',$user->salary->tax_id);
        $month = Utility::getMonthFromDate($payslip->month);
        $loan = Utility::checkForDeductions(Auth::user()->id,$month,Utility::EMPLOYEE_LOAN_ID);
        $advance = Utility::checkForDeductions(Auth::user()->id,$month,Utility::SALARY_ADVANCE_ID);
        //$taxAmount = ($tax->sum_percentage/100)*$user->salary->gross_pay;
        $taxAmount = $payslip->tax_amount;
        $payrollDeduct = ($payslip->bonus_deduc_type == Utility::PAYROLL_DEDUCTION) ? $payslip->bonus_deduc : 0;
        $totalSalaryDeduction = $this->primarySalaryDeduction($payslip->component,$loan,$advance,$payrollDeduct);
        //print_r($tax); exit();
        return view::make('payroll.edit_form')->with('edit',$payslip)->with('companyInfo',$companyInfo)
            ->with('user',$user)->with('tax',$tax)->with('taxAmount',$taxAmount)->with('totalDeduction',$totalSalaryDeduction);

    }

    public function primarySalaryDeduction($jsonData,$loan,$salAdv,$payrollDeduct){
        $array = json_decode($jsonData,true);
        $holdArray = [];
        foreach($array as $data){
            if($data['component_type'] == Utility::COMPONENT_TYPE[2]){
                $holdArray[] = $data['amount'];
            }

        }
        $sum = array_sum($holdArray);
        $totalDeduct = $sum+$loan+$salAdv+$payrollDeduct;
        return $totalDeduct;

    }

    public function removeNullFromArray($array){
        foreach($array as $key => $val){
            if($val == 'null' || $val == ''){
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function process(Request $request)
    {
        //

        $validator = Validator::make($request->all(),Payroll::$mainRules);
        if($validator->passes()){

            $bonusDeduc = ($request->input('extra_amount') == '') ? Utility::ZERO : $request->input('bonus_deduct_type');
            $extraAmount = ($request->input('extra_amount') == '') ? Utility::ZERO : $request->input('extra_amount');
            $all_id = json_decode($request->input('all_data'));
            $processDate = $request->input('date');
            $month = $request->input('month');
            $year = $request->input('year');
            $week = (empty($request->input('week'))) ? '' : json_encode($this->removeNullFromArray($request->input('week')));

            $dataExist = [];
            Utility::checkCurrencyActiveStatus();

            if(count($all_id) > 0){

                $defaultCurr = session('currency')['id'];
                for($i=0;$i<count($all_id);$i++){
                    $user =  User::firstRow('id',$all_id[$i]);
                    if(!empty($user->salary_id)){
                        $salaryId = SalaryStructure::firstRow('id',$user->salary_id);
                        $tax = Tax::firstRow('id',$salaryId->id);
                        $taxAmount = ($tax->sum_percentage/100)*$salaryId->gross_pay;
                        $totalAmount = ($request->input('auto_deduct') != 1) ? Utility::calculateSalaryWithoutLoanSalAdv($all_id[$i],$extraAmount,$bonusDeduc) : Utility::calculateSalary($all_id[$i],$extraAmount,$bonusDeduc);


                        $loanDeduct = ($request->input('auto_deduct') != 1) ? '' : Utility::userLoanTotal($all_id[$i]);
                        $salAdvDeduct =  ($request->input('auto_deduct') != 1) ? '' : Utility::userSalAdvTotal($all_id[$i]);

                        /*return response()->json([
                            'message2' => $totalAmount,
                            'message' => 'warning'
                        ]);*/
                        $dbData = [
                            'user_id' => $all_id[$i],
                            'bonus_deduc' => $extraAmount,
                            'bonus_deduc_type' => $bonusDeduc,
                            'bonus_deduc_desc' => $request->input('amount_desc'),
                            'salary_id' => $salaryId->id,
                            'component' => $salaryId->component,
                            'dept_id' => $user->dept_id,
                            'position_id' => $user->position_id,
                            'gross_pay' => $salaryId->gross_pay,
                            'total_amount' => $totalAmount,
                            'tax_amount' => $taxAmount,
                            'sal_adv_deduct' => $salAdvDeduct,
                            'loan_deduct' => $loanDeduct,
                            'curr_id' => $defaultCurr,
                            'process_date' => Utility::standardDate($processDate),
                            'payroll_status' => Utility::PROCESSING,
                            'pay_year' => $year,
                            'month' => $month,
                            'week' => $week,
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        $create = Payroll::create($dbData);

                    }

                }

                return response()->json([
                'message2' => 'saved',
                'message' => 'saved successfully'
            ]);
                    $mailContentApproved = new \stdClass();
                    $mailContentApproved->type = 'process_request';
                    $mailContentApproved->desc = 'Payroll for '.$month.' '.$year;
                    $mailContentApproved->sender = Auth::user()->firstname . ' ' . Auth::user()->lastname;

                    $accountants = User::specialColumns('role',Utility::ACCOUNTANTS);
                    if(count($accountants) >0){ //SEND MAIL TO ALL IN ACCOUNTS DEPARTMENT ABOUT THIS APPROVAL
                        foreach($accountants as $data) {
                            Notify::payrollMail('mail_views.payroll', $mailContentApproved, $data->email, Auth::user()->firstname, 'Process Request');
                        }
                    }


                return response()->json([
                    'message2' => 'saved',
                    'message' => count($in_use).' data(s) has been sent to accounts for processing '
                ]);

            }
            /////////////////////////////////////////////////


        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    public function updateSalaryProcess(Request $request)
    {
        //

        $validator = Validator::make($request->all(),Payroll::$mainRulesEdit);
        if($validator->passes()){

            $bonusDeduc = ($request->input('extra_amount') == '') ? Utility::ZERO : $request->input('bonus_deduct_type');
            $extraAmount = ($request->input('extra_amount') == '') ? Utility::ZERO : $request->input('extra_amount');
            $all_id = json_decode($request->input('all_data'));
            $processDate = $request->input('date');
            $month = $request->input('month');
            $year = $request->input('year');
            $week = (empty($request->input('week'))) ? '' : json_encode($this->removeNullFromArray($request->input('week')));

            $dataExist = [];
            Utility::checkCurrencyActiveStatus();

            /////////////////////////////////////////////////

            if(count($all_id) > 0){

                $defaultCurr = session('currency')['id'];
                for($i=0;$i<count($all_id);$i++){
                    $paid = Payroll::firstRow('id',$all_id[$i]);
                    $user =  User::firstRow('id',$paid->user_id);
                    if(!empty($user->salary_id)){
                        $salaryId = SalaryStructure::firstRow('id',$user->salary_id);
                        $tax = Tax::firstRow('id',$salaryId->id);
                        $taxAmount = ($tax->sum_percentage/100)*$salaryId->gross_pay;
                    
                        $totalAmount = ($request->input('auto_deduct') != 1) ? Utility::calculateSalaryWithoutLoanSalAdv($user->id,$extraAmount,$bonusDeduc) : Utility::calculateSalary($user->id,$extraAmount,$bonusDeduc);


                        $loanDeduct = ($request->input('auto_deduct') != 1) ? '' : Utility::userLoanTotal($user->id);
                        $salAdvDeduct =  ($request->input('auto_deduct') != 1) ? '' : Utility::userSalAdvTotal($user->id);

                        $dbData = [
                            'bonus_deduc' => $extraAmount,
                            'bonus_deduc_type' => $bonusDeduc,
                            'bonus_deduc_desc' => $request->input('amount_desc'),
                            'salary_id' => $salaryId->id,
                            'component' => $salaryId->component,
                            'dept_id' => $user->dept_id,
                            'gross_pay' => $salaryId->gross_pay,
                            'total_amount' => $totalAmount,
                            'tax_amount' => $taxAmount,
                            'sal_adv_deduct' => $salAdvDeduct,
                            'loan_deduct' => $loanDeduct,
                            'curr_id' => $defaultCurr,
                            'process_date' => Utility::standardDate($processDate),
                            'payroll_status' => Utility::PROCESSING,
                            'pay_year' => $year,
                            'month' => $month,
                            'week' => $week,
                            'updated_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        $update = Payroll::defaultUpdate('id',$all_id[$i],$dbData);

                    }

                }


                $mailContentApproved = new \stdClass();
                $mailContentApproved->type = 'update_request';
                $mailContentApproved->desc = 'Payroll for '.$month.' '.$year;
                $mailContentApproved->sender = Auth::user()->firstname . ' ' . Auth::user()->lastname;

                $accountants = User::specialColumns('role',Utility::ACCOUNTANTS);
                if(count($accountants) >0){ //SEND MAIL TO ALL IN ACCOUNTS DEPARTMENT ABOUT THIS APPROVAL
                    foreach($accountants as $data) {
                        Notify::payrollMail('mail_views.payroll', $mailContentApproved, $data->email, Auth::user()->firstname, 'Process Request');
                    }
                }


                return response()->json([
                    'message2' => 'saved',
                    'message' => count($all_id).' data(s) has been sent to accounts for processing '
                ]);

            }

            ///////////////////////////////////////////////////

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    //PAYROLL REPORT SEARCH REQUEST AND QUERY
    public function searchPayroll(Request $request)
    {
        //

        $month = $request->input('month');
        $year = $request->input('year');
        $dept = $request->input('department');
        $status = $request->input('payroll_status');

        $earningDeductions = 0.00;   $totalTax = 0.00;  $totalNet = 0.00; $totalGross = 0.00;
        $earningsArr = []; $deductionsArr = [];

        $mainData = [];

        //PROCESS SEARCH REQUEST

        if(!empty($year)) {
            if ($month != '' && $status != '' && $dept != '') {
                $mainData = Payroll::specialColumns4('month', $month, 'dept_id', $dept, 'payroll_status', $status,'pay_year',$year);
            }
            if ($month != '' && $status != '' && $dept == '')  {
                $mainData = Payroll::specialColumns3('month', $month, 'payroll_status', $status,'pay_year',$year);
            }
            if ($month != '' && $status == '' && $dept != '')  {
                $mainData = Payroll::specialColumns3('month', $month, 'dept_id', $dept,'pay_year',$year);
            }
            if ($month == '' && $status != '' && $dept != '')  {
                $mainData = Payroll::specialColumns3('dept_id', $dept, 'payroll_status', $status,'pay_year',$year);
            }
            if ($month == '' && $status != '' && $dept == '')  {
                $mainData = Payroll::specialColumns2('payroll_status', $status,'pay_year',$year);
            }
            if ($month != '' && $status == '' && $dept == '')  {
                $mainData = Payroll::specialColumns2('month', $month,'pay_year',$year);
            }
            if ($month == '' && $status == '' && $dept != '')  {
                $mainData = Payroll::specialColumns2('dept_id', $dept,'pay_year',$year);
            }
            if ($month == '' && $status == '' && $dept == '')  {
                $mainData = Payroll::specialColumns('pay_year',$year);
            }
            $earnings = 0; $deductions = 0;
            if(!empty($mainData)){
                foreach($mainData as $data){
                    $earningDeductions = ($data->bonus_deduc_type == Utility::PAYROLL_BONUS) ? $earningDeductions+=floatval($data->bonus_deduc) : $earningDeductions-=floatval($data->bonus_deduc);
                    if($data->bonus_deduc_type == Utility::PAYROLL_BONUS){
                        $earnings+= $data->bonus_deduc;
                    }
                    if($data->bonus_deduc_type == Utility::PAYROLL_DEDUCTION){
                        $deductions+=$data->bonus_deduc;
                    }
                    $totalTax += $data->tax_amount;
                    $totalNet += $data->total_amount;
                    $totalGross += $data->gross_pay;
                
                
                }
                
            }

            return view::make('payroll.payroll_report_reload')->with('mainData', $mainData)->with('totalNet', $totalNet)
            ->with('totalTax', $totalTax)->with('totalGross', $totalGross)->with('earningDeductions', $earningDeductions)
            ->with('earnings', $earnings)->with('deductions', $deductions);

        }else{
            return 'Please ensure to select Year, to continue';
        }


    }

     //PAYROLL REPORT SEARCH REQUEST AND QUERY
     public function searchPayrollLite(Request $request)
     {
         //
 
         $from = Utility::standardDate($request->input('from_date'));
         $to = Utility::standardDate($request->input('to_date'));
         $dept = $request->input('department');
         $dateArray = [$from,$to];
         $mainData = [];
 
         //PROCESS SEARCH REQUEST
 
        if ($dept != '')  {
            $mainData = Payroll::specialColumnsDate('dept_id', $dept,'process_date',$dateArray);
        }
        if ($dept == '')  {
            $mainData = Payroll::getByDate('process_date',$dateArray);
        }

        return view::make('payroll.payroll_search')->with('mainData', $mainData);

 
 
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request)
    {
        //
        $all_id = json_decode($request->input('all_data'));
        $journalValid = $request->input('ledger_valid');
        $status = $request->input('input');
        $payDate = $request->input('date');

        $dbData = [
            'payroll_status' => Utility::APPROVED,
            'pay_date' => Utility::standardDate($payDate),
            'updated_by' => Auth::user()->id
        ];


        $mailContentApproved = new \stdClass();
        $mailContentApproved->type = 'request_approval';
        $mailContentApproved->desc = count($all_id).' users in the payroll have received payment';
        $mailContentApproved->sender = Auth::user()->firstname . ' ' . Auth::user()->lastname;

        $updateApproval = Payroll::massUpdate('id',$all_id,$dbData);


        if($status == 1) {
            $hr = User::specialColumns('role', Utility::HR);
            if (count($hr) > 0) { //SEND MAIL TO ALL IN ACCOUNTS DEPARTMENT ABOUT THIS APPROVAL
                foreach ($hr as $data) {
                    Notify::payrollMail('mail_views.payroll', $mailContentApproved, $data->email, Auth::user()->firstname, 'Request Approval');
                }
            }
        }

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Payment was made to '.count($all_id).' entry(ies)'
        ]);



    }

    /**
     * Search the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchUser(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = User::searchEnabledUser($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/

        $user_ids = array_unique($obtain_array);
        $mainData =  (Auth::user()->id == 3) ? User::massDataMassCondition('uid',$user_ids,'role',Utility::USER_ROLES_ARRAY)
            :User::massData('uid', $user_ids);
        //print_r($obtain_array); die();
        if(!empty($search)){
            if (count($user_ids) > 0) {

                return view::make('payroll.search_user')->with('mainData',$mainData);
            }else{
                return 'No match found, please search again with sensitive words';
            }

        }else{
            $mainData = User::specialColumns('active_status',Utility::STATUS_ACTIVE);
            return view::make('payroll.search_user')->with('mainData',$mainData);
        }

    }

    public function searchUserStrict(Request $request)
    {
        //
       
        
            $dept = $request->input('department');

            $mainData = User::specialColumns2('dept_id', $dept,'active_status',Utility::STATUS_ACTIVE);

            if ($mainData->count() > 0) {

                return view::make('payroll.search_user')->with('mainData',$mainData);
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

            $delete = Payroll::massUpdate('id',$all_id,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($all_id).' data(s) has been deleted'
            ]);

    }

    public function refineData($data){
        $holdArray = [];
        if(count($data) >0){
            foreach($data as $value){
                if($value->payroll_status == Utility::PROCESSING){
                    $holdArray[] = $value->total_amount;
                }
            }
            $data->salary_sum = array_sum($holdArray);
        }


    }

}
