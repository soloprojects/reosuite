<?php

namespace App\Http\Controllers;

use App\Helpers\Notify;
use App\model\BudgetSummary;
use App\model\Budget;
use App\model\AccountChart;
use App\Helpers\Utility;
use App\model\FinancialYear;
use App\User;
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

class BudgetSummaryController extends Controller
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
        $mainData = BudgetSummary::specialColumnsPage('dept_id',Auth::user()->dept_id);
        $detectHod = Utility::detectHOD(Auth::user()->id);
        $finYear = FinancialYear::getAllData();
        $budgetCopy = BudgetSummary::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('budget_summary.reload',array('mainData' => $mainData,
            'detectHod'=> $detectHod,'finYear'=> $finYear,'budgetCopy'=> $budgetCopy))->render());

        }else{
            return view::make('budget_summary.main_view')->with('mainData',$mainData)
                ->with('detectHod',$detectHod)->with('finYear',$finYear)->with('budgetCopy',$budgetCopy);
        }

    }

    public function budgetApprovalView(Request $request)
    {
        //
        //$req = new Request();
        $mainData = BudgetSummary::specialColumnsPage('budget_status',Utility::READY_FOR_APPROVAL);
        $detectHod = Utility::detectHOD(Auth::user()->id);
        $finYear = FinancialYear::getAllData();
        $budgetCopy = BudgetSummary::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('budget_summary.reload_approval',array('mainData' => $mainData,
                'detectHod'=> $detectHod,'finYear'=> $finYear,'budgetCopy'=> $budgetCopy))->render());

        }else{
            return view::make('budget_summary.main_view_approval')->with('mainData',$mainData)
                ->with('detectHod',$detectHod)->with('finYear',$finYear)->with('budgetCopy',$budgetCopy);
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
        $validator = Validator::make($request->all(),BudgetSummary::$mainRules);
        if($validator->passes()){

            $files = $request->file('attachment');
            $attachment = [];
            $countData = BudgetSummary::specialColumnsOr2('name',$request->input('name'),'fin_year_id',$request->input('financial_year'));
            if($countData->count() > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry (Financial year/Budget name) already exist, please try another entry'
                ]);

            }else{

                if($files != ''){
                    foreach($files as $file){

                        $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalName() . $file->getClientOriginalExtension();

                        $file->move(
                            Utility::FILE_URL(), $file_name
                        );
                        //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A TEXT TYPE MYSQL COLUMN
                        $attachment[] =  $file_name;

                    }
                }

                $dbDATA = [
                    'name' => $request->input('name'),
                    'fin_year_id' => $request->input('financial_year'),
                    'approval_status' => $request->input('budget_approval'),
                    'dept_id' => Auth::user()->dept_id,
                    'budget_amount' => $request->input('total_budget_amount'),
                    'budget_status' => $request->input('budget_status'),
                    'comment' => ucfirst($request->input('comment')),
                    'docs' => json_encode($attachment),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                $createBudget = BudgetSummary::create($dbDATA);
                if(!empty($request->input('copy_budget'))){
                    $this->copyBudget($createBudget,$request->input('copy_budget'));
                }

                if($request->input('budget_approval') != '0'){
                    $managementTeam = User::massDataCondition('role',Utility::TOP_USERS,'active_status',Utility::STATUS_ACTIVE);

                    foreach ($managementTeam as $userData){
                        $userEmail = $userData->email;

                        $mailContent = [];

                        $messageBody = "Hello ".$userData->title." ".$userData->firstname.", the budget ".ucfirst($request->input('name'))." have been
                    sent to management for review and approval from ".Auth::user()->firstname." ".Auth::user()->lastname.
                            ", please visit the portal to review";

                        $mailContent['message'] = $messageBody;
                        $mailContent['fromEmail'] = Auth::user()->email;
                        Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
                    }
                }

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
        $request = BudgetSummary::firstRow('id',$request->input('dataId'));
        $detectHod = Utility::detectHOD(Auth::user()->id);
        $finYear = FinancialYear::getAllData();
        $budgetCopy = BudgetSummary::getAllData();
        return view::make('budget_summary.edit_form')->with('edit',$request)
            ->with('detectHod',$detectHod)->with('finYear',$finYear)->with('budgetCopy',$budgetCopy);

    }

    public function attachmentForm(Request $request)
    {
        //
        $request = BudgetSummary::firstRow('id',$request->input('dataId'));
        return view::make('budget_summary.attach_form')->with('edit',$request);
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
        $validator = Validator::make($request->all(), BudgetSummary::$mainRules);

        if ($validator->passes()) {

            $dbDATA = [
                'reviewer_comment' => ucfirst($request->input('reviewer_comment')),
                'updated_by' => Auth::user()->id,
            ];

            $budgetStatus = ($request->input('approval_status') == Utility::APPROVED) ? Utility::READY_FOR_APPROVAL : $request->input('budget_status');
            if($request->input('created_by') == Auth::user()->id){

                $dbDATA = [
                    'name' => $request->input('name'),
                    'fin_year_id' => $request->input('financial_year'),
                    'dept_id' => Auth::user()->dept_id,
                    'budget_amount' => $request->input('total_budget_amount'),
                    'budget_status' => $budgetStatus,
                    'comment' => ucfirst($request->input('comment')),
                    'updated_by' => Auth::user()->id,
                ];
            }

            $currentBudget = new \stdClass();
            $currentBudget->id = $request->input('edit_id');
            $currentBudget->name = $request->input('name');
            $currentBudget->dept_id = Auth::user()->dept_id;
            $currentBudget->fin_year_id = $request->input('financial_year');

            $existingData = BudgetSummary::specialColumnsOr2('name', $request->input('name'), 'fin_year_id', $request->input('financial_year'));

                if ($existingData->count() > 0) {
                if ($existingData[0]->id == $request->input('edit_id')) {

                    BudgetSummary::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    if($request->input('budget_approval') != '0'){
                        $managementTeam = User::massDataCondition('role',Utility::TOP_USERS,'active_status',Utility::STATUS_ACTIVE);

                        foreach ($managementTeam as $userData){
                            $userEmail = $userData->email;

                            $mailContent = [];

                            $messageBody = "Hello ".$userData->title." ".$userData->firstname.", the budget ".ucfirst($request->input('name'))." have been
                    sent to management for review and approval from ".Auth::user()->firstname." ".Auth::user()->lastname.
                                ", please visit the portal to review";

                            $mailContent['message'] = $messageBody;
                            $mailContent['fromEmail'] = Auth::user()->email;
                            Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
                        }
                    }

                    if(!empty($request->input('copy_budget'))){
                        $this->copyBudget($currentBudget,$request->input('copy_budget'));
                    }
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                }
                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry (Financial year/Budget name) already exist, please try another entry'
                ]);

            } else {

                    BudgetSummary::defaultUpdate('id', $request->input('edit_id'), $dbDATA);
                    if(!empty($request->input('copy_budget'))){
                        $this->copyBudget($currentBudget,$request->input('copy_budget'));
                    }

                    if($request->input('budget_approval') != '0'){
                        $managementTeam = User::massDataCondition('role',Utility::TOP_USERS,'active_status',Utility::STATUS_ACTIVE);

                        foreach ($managementTeam as $userData){
                            $userEmail = $userData->email;

                            $mailContent = [];

                            $messageBody = "Hello ".$userData->title." ".$userData->firstname.", the budget ".ucfirst($request->input('name'))." have been
                    sent to management for review and approval from ".Auth::user()->firstname." ".Auth::user()->lastname.
                                ", please visit the portal to review";

                            $mailContent['message'] = $messageBody;
                            $mailContent['fromEmail'] = Auth::user()->email;
                            Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
                        }
                    }

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

    public function editAttachment(Request $request){
        $files = $request->file('attachment');

        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = BudgetSummary::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->docs);
        if($request->input('created_by') == Auth::user()->id) {

            if ($files != '') {
                foreach ($files as $file) {
                    //return$file;
                    $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                    $file->move(
                        Utility::FILE_URL(), $file_name
                    );
                    //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                    array_push($oldAttachment, $file_name);

                }
            }

            $attachJson = json_encode($oldAttachment);
            $dbData = [
                'docs' => $attachJson
            ];
            $save = BudgetSummary::defaultUpdate('id', $editId, $dbData);

            return response()->json([
                'message' => 'good',
                'message2' => 'saved'
            ]);

        }else{

            return response()->json([
                'message' => 'warning',
                'message2' => 'upload failed, the entry was not created by you'
            ]);
        }

    }

    public function removeAttachment(Request $request){
        $file_name = $request->input('attachment');
        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = BudgetSummary::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->docs,true);


        //REMOVE FILES FROM AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
        if (($key = array_search($file_name, $oldAttachment)) !== false) {
            $fileUrl = Utility::FILE_URL($file_name);
            unset($oldAttachment[$key]);
            unlink($fileUrl);
        }


        $attachJson = json_encode($oldAttachment);
        $dbData = [
            'docs' => $attachJson
        ];
        $save = BudgetSummary::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'File have been removed'
        ]);

    }

    public function downloadAttachment(){
        $file = $_GET['file'];
        $download = Utility::FILE_URL($file);
        return response()->download($download);
        //return $file;
    }

    public function approveBudget(Request $request)
    {
        //
        $allId = json_decode($request->input('all_data'));
        $status = $request->input('status');

        $dbData = [
            'approval_status' => $status,
            'approved_by' => 0,
        ];

        if($status == Utility::APPROVED){
            $dbData = [
                'approval_status' => $status,
                'approved_by' => Auth::user()->id,
                'approval_date' => date('Y-m-d'),
            ];
        }


        $updateApproval = BudgetSummary::massUpdate('id',$allId,$dbData);

        return response()->json([
            'message' => 'saved',
            'message2' => 'Success'
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
        $all_id = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

        $inactiveBudget = [];
        $activeBudget = [];

        foreach($all_id as $var){
            $budgetRequest = BudgetSummary::firstRow('id',$var);
            if($budgetRequest->approval_status != Utility::STATUS_ACTIVE){
                $inactiveBudget[] = $var;
            }else{
                $activeBudget[] = $var;
            }
        }

        $message = (count($inactiveBudget) < 1) ? ' and '.count($activeBudget).
            ' budget summary was not created by you and cannot be deleted' : '';
        if(count($inactiveBudget) > 0){


            $delete = BudgetSummary::massUpdate('id',$inactiveBudget,$dbData);
            $deleteBudgetItems = Budget::massUpdate('budget_id',$inactiveBudget,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($inactiveBudget).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($activeBudget).$message,
                'message' => 'warning'
            ]);

        }

    }

    public function copyBudget($newBudget,$copiedBudgetId){


        if($newBudget->id == $copiedBudgetId){
            exit(json_encode([
                'message2' => 'You cannot copy a budget to itself ',
                'message' => 'Budget already contains data'
            ]));
        }

        $budgetData = Budget::firstRow2('dept_id',$newBudget->dept_id,'fin_year_id',$newBudget->fin_year_id);
        if(empty($budgetData)){

            $copyBudget = Budget::specialColumns2('dept_id',$newBudget->dept_id,'budget_id',$copiedBudgetId);

            foreach ($copyBudget as $budget){
                $dbData = [

                    'budget_id' => $newBudget->id,
                    'fin_year_id' => $newBudget->fin_year_id,
                    'request_cat_id' => $budget->id,
                    'acct_id' => $budget->acct_id,
                    'acct_cat_id' => $budget->acct_cat_id,
                    'acct_detail_id' => $budget->acct_detail_id,
                    'dept_id' => $newBudget->dept_id,
                    'jan' => $budget->jan,
                    'feb' => $budget->feb,
                    'march' => $budget->march,
                    'first_quarter' => $budget->first_quarter,
                    'april' => $budget->april,
                    'may' => $budget->may,
                    'june' => $budget->june,
                    'second_quarter' => $budget->second_quarter,
                    'july' => $budget->july,
                    'august' => $budget->august,
                    'sept' => $budget->sept,
                    'third_quarter' => $budget->third_quarter,
                    'oct' => $budget->oct,
                    'nov' => $budget->nov,
                    'dec' => $budget->dec,
                    'fourth_quarter' => $budget->fourth_quarter,
                    'total_cat_month' => $budget->total_cat_month,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE,

                ];
                Budget::create($dbData);

            }

            exit(json_encode([
                'message2' => 'Data saved, and budget copied successfully',
                'message' => 'saved'
            ]));

        }else{

            exit(json_encode([
                'message2' => 'Data saved, but the copied budget did not execute because '.$newBudget->name.' already contains data, please remove data associated with this budget to continue copying',
                'message' => 'Budget already contains data'
            ]));

        }



    }

}
