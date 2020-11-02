<?php

namespace App\Http\Controllers;

use App\Helpers\Notify;
use App\model\Department;
use Illuminate\Http\Request;
use App\model\Helpdesk;
use App\model\TicketCategory;
use App\Helpers\Utility;
use App\User;
use Illuminate\Support\Facades\Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class HelpDeskController extends Controller
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
        $mainData = Helpdesk::specialColumnsPage('user_id',Auth::user()->id);
        $ticketCat = TicketCategory::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('help_desk.reload',array('mainData' => $mainData,
               'ticketCat' => $ticketCat))->render());

        }else{
            return view::make('help_desk.main_view')->with('mainData',$mainData)->with('ticketCat',$ticketCat);
        }

    }

    public function allRequests(Request $request)
    {


        $mainData = Helpdesk::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('help_desk.all_request_reload',array('mainData' => $mainData,
                ))->render());

        }
        return view::make('help_desk.all_request')->with('mainData',$mainData);

    }

    public function requestResponse(Request $request)
    {
        //
        $validator = Validator::make($request->all(),Helpdesk::$responseRules);
        if($validator->passes()) {
            $editId = $request->input('edit_id');
            $response = $request->input('response');
            $responseDate = date("d-m-Y H:i:s");
            $helpDeskData = Helpdesk::firstRow('id',$editId);
            $responseRate = Utility::dateTimeDiff($helpDeskData->created_at,$responseDate);
            $formerResponseDate = $helpDeskData->response_dates;
            $dbData = [];
            if(empty($helpDeskData->response_rate)) {
                $dbData = [
                    'response' => $response,
                    'response_rate' => $responseRate,
                    'response_dates' => $formerResponseDate.'|Responded at '.$responseDate.'| ',
                    'response_status' => Utility::STATUS_ACTIVE,
                    'updated_by' => Utility::checkAuth('temp_user')->id,
                ];
            }else{
                $dbData = [
                    'response' => $response,
                    'response_dates' => $formerResponseDate.'|Responded at '.$responseDate.'| ',
                    'response_status' => Utility::STATUS_ACTIVE,
                    'updated_by' => Utility::checkAuth('temp_user')->id,
                ];
            }

            Helpdesk::defaultUpdate('id', $editId, $dbData);

            return response()->json([
                'message' => 'saved',
                'message2' => 'Processed'
            ]);
        }

        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);

    }

    public function createFeedback(Request $request)
    {
        //
        $validator = Validator::make($request->all(),Helpdesk::$feedbackMainRules);
        if($validator->passes()){


            $dbData = [
                'feedback' => ucfirst($request->input('feedback')),
                'updated_by' => Auth::user()->id,
            ];
            Helpdesk::defaultUpdate('id',$request->input('request_id'),$dbData);

            return response()->json([
                'message' => 'good',
                'message2' => 'saved'
            ]);

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    //FETCH HELP DESK REPORT SEARCH FORM
    public function report(Request $request)
    {
        //
        $mainData = Helpdesk::paginateAllData();
        $ticketCat = TicketCategory::getAllData();
        $dept = Department::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('help_desk.report_reload',array('ticketCat' => $ticketCat,
                'dept' => $dept))->render());

        }else{
            return view::make('help_desk.report')->with('ticketCat',$ticketCat)->with('dept',$dept);
        }

    }

    //HELP DESK REPORT SEARCH REQUEST AND QUERY
    public function searchReport(Request $request)
    {
        //
        /*$searchResultRules = [
            'project' => 'required',
            'report_type' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
        ];
        $validator = Validator::make($request->all(),$searchResultRules);
        if($validator->passes()) {*/

        $startDate = Utility::standardDate($request->input('from_date'));
        $endDate = Utility::standardDate($request->input('to_date'));
        $ticketCat = $request->input('ticket_category');
        $dept = $request->input('department');
        $status = $request->input('status');
        $dateArray = [$startDate,$endDate];
        $mainData = [];

        //PROCESS SEARCH REQUEST
        //$mainData = Helpdesk::specialColumnsDate5('ticket_cat', $ticketCat, 'dept_id', $dept, 'response_status', $status, $dateArray);

        if($ticketCat != '' && $dept != '' && $status != ''){
                $mainData = Helpdesk::specialColumnsDate7('ticket_cat', $ticketCat, 'dept_id', $dept, 'response_status', $status, $dateArray);
            }
            if($ticketCat != '' && $dept != '' && $status == ''){
                $mainData = Helpdesk::specialColumnsDate5('ticket_cat', $ticketCat, 'dept_id', $dept, $dateArray);
            }
            if($ticketCat != '' && $dept == '' && $status == ''){
                $mainData = Helpdesk::specialColumnsDate3('ticket_cat', $ticketCat, $dateArray);
            }
            if($ticketCat == '' && $dept != '' && $status != ''){
                $mainData = Helpdesk::specialColumnsDate5('dept_id', $dept,'response_status', $status, $dateArray);
            }
            if($ticketCat == '' && $dept == '' && $status != ''){
                $mainData = Helpdesk::specialColumnsDate3('response_status', $status, $dateArray);
            }
            if($ticketCat != '' && $dept == '' && $status != ''){
                $mainData = Helpdesk::specialColumnsDate5('ticket_cat', $ticketCat, 'response_status', $status, $dateArray);
            }
            if($ticketCat == '' && $dept != '' && $status == ''){
                $mainData = Helpdesk::specialColumnsDate3('dept_id', $dept, $dateArray);
            }
            if($ticketCat == '' && $dept == '' && $status == ''){
                $mainData = Helpdesk::specialColumnsDate($dateArray);
            }

        return view::make('help_desk.report_reload')->with('mainData',$mainData);

        /*}else{

            $errors = $validator->errors();
            return response()->json([
                'message2' => 'fail',
                'message' => $errors
            ]);

        }*/

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),Helpdesk::$mainRules);
        if($validator->passes()){

            $subject = $request->input('subject');
            $ticketCat = $request->input('ticket_category');
            $details = $request->input('ckInput');

            $dbDATA = [
                'subject' => $subject,
                'details' => $details,
                'ticket_cat' => $ticketCat,
                'dept_id' => Utility::checkAuth('temp_user')->dept_id,
                'user_id' => Utility::checkAuth('temp_user')->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            Helpdesk::create($dbDATA);

            $adminUser = User::specialColumns('role',Utility::ADMIN);
            foreach ($adminUser as $userData){
                $adminEmail = $userData->email;
                $fullName = Auth::user()->firstname.' '.Auth::user()->lastname;

                $mailContent = [];

                $messageBody = "Hello '.$fullName.', sent in a request
                 on the subject ".$subject." please visit the portal to respond";

                $mailContent['message'] = $messageBody;
                $mailContent['fromEmail'] = Auth::user()->email;
                Notify::GeneralMail('mail_views.general', $mailContent, $adminEmail);
            }

            return response()->json([
                'message' => 'good',
                'message2' => 'saved'
            ]);

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
        $ticketCat = TicketCategory::getAllData();
        $helpDesk = Helpdesk::firstRow('id',$request->input('dataId'));
        return view::make('help_desk.edit_form')->with('edit',$helpDesk)->with('ticketCat',$ticketCat);

    }

    public function requestResponseForm(Request $request)
    {
        //
        $helpDesk = Helpdesk::firstRow('id',$request->input('dataId'));
        return view::make('help_desk.attach_form')->with('edit',$helpDesk);

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

        $validator = Validator::make($request->all(),Helpdesk::$mainRules);
        if($validator->passes()) {

            $subject = $request->input('subject');
            $ticketCat = $request->input('ticket_category');
            $details = $request->input('ckInput');

            $dbDATA = [
                'subject' => $subject,
                'ticket_cat' => $ticketCat,
                'details' => $details,
                'response_status' => Utility::ZERO,
            ];

            Helpdesk::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

            if(Auth::user()->role != Utility::ADMIN){
                $adminUser = User::specialColumns('role',Utility::ADMIN);
                foreach ($adminUser as $userData){
                    $adminEmail = $userData->email;
                    $fullName = Auth::user()->firstname.' '.Auth::user()->lastname;

                    $mailContent = [];

                    $messageBody = "Hello '.$fullName.', sent in a request
                 on the subject ".$subject." please visit the portal to respond";

                    $mailContent['message'] = $messageBody;
                    $mailContent['fromEmail'] = Auth::user()->email;
                    Notify::GeneralMail('mail_views.general', $mailContent, $adminEmail);
                }
            }else{
                $userData = Helpdesk::firstRow('',$request->input('edit_id'));

                $userEmail = $userData->reqUser->email;
                $fullName = $userData->reqUser->firstname.' '.$userData->reqUser->lastname;

                $mailContent = [];

                $messageBody = "Hello '.$fullName.', your request with the subject ".$subject.
                    " has been resolved, please visit the portal to confirm";

                $mailContent['message'] = $messageBody;
                $mailContent['fromEmail'] = Auth::user()->email;
                Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);


            }

            return response()->json([
                'message' => 'good',
                'message2' => 'saved'
            ]);


        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
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
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        Helpdesk::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }
}
