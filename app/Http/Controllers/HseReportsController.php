<?php

namespace App\Http\Controllers;

use App\Helpers\Notify;
use App\model\Department;
use App\model\HseAccess;
use App\model\HseReports;
use Illuminate\Http\Request;
use App\model\HseSourceType;
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

class HseReportsController extends Controller
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
        $mainData = HseReports::paginateAllData();
        $sourceType = HseSourceType::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('hse_report.reload',array('mainData' => $mainData,
                'ticketCat' => $sourceType))->render());

        }else{
            return view::make('hse_report.main_view')->with('mainData',$mainData)->with('sourceType',$sourceType);
        }

    }

    public function requestResponse(Request $request)
    {
        //
        $validator = Validator::make($request->all(),HseReports::$responseRules);
        if($validator->passes()) {
            $editId = $request->input('edit_id');
            $response = $request->input('response');

                $dbData = [
                    'response' => $response,
                    'response_status' => Utility::STATUS_ACTIVE,
                    'updated_by' => Utility::checkAuth('temp_user')->id,
                ];

            HseReports::defaultUpdate('id', $editId, $dbData);

            $hseData = HseReports::firstRow('id',$editId);
                $userEmail = $hseData->reqUser->email;  //email of user who logged report

                $mailContent = [];

                $messageBody = "Hello ".$hseData->reqUser->firstname.", ".Auth::user()->firstname." ".Auth::user()->lastname.
                    " responded to your incident/hazard report, please visit the portal to view";

                $mailContent['message'] = $messageBody;
                Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);

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

    //FETCH HSE REPORT ITEM
    public function fetchHseReportItem(Request $request)
    {
        //
        $hseReport = HseReports::firstRow('id',$request->input('dataId'));
        return view::make('hse_report.report_item')->with('data',$hseReport);

    }

    //FETCH HSE REPORT SEARCH FORM
    public function report(Request $request)
    {
        //
        $sourceType = HseSourceType::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('hse_report.report_reload',array('sourceType' => $sourceType,
                ))->render());

        }else{
            return view::make('hse_report.report')->with('sourceType',$sourceType);
        }

    }

    //HSE REPORT SEARCH REQUEST AND QUERY
    public function searchReport(Request $request)
    {

        $startDate = Utility::standardDate($request->input('from_date'));
        $endDate = Utility::standardDate($request->input('to_date'));
        $sourceType = $request->input('source_type');
        $reportType = $request->input('report_type');
        $dateArray = [$startDate,$endDate];
        $mainData = [];

        //PROCESS SEARCH REQUEST

        if($sourceType != '' && $reportType != ''){
            $mainData = HseReports::specialColumnsDate5('report_type', $reportType, 'source_id', $sourceType, $dateArray);
        }
        if($sourceType != '' && $reportType == ''){
            $mainData = HseReports::specialColumnsDate3('source_id', $sourceType, $dateArray);
        }
        if($sourceType == '' && $reportType != ''){
            $mainData = HseReports::specialColumnsDate3('report_type', $reportType, $dateArray);
        }
        if($sourceType == '' && $reportType == ''){
            $mainData = HseReports::specialColumnsDate($dateArray);
        }

        //print_r($sourceType.$reportType.$startDate.$endDate);
        return view::make('hse_report.report_reload')->with('mainData',$mainData);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),HseReports::$mainRules);
        if($validator->passes()){

            $sourceType = $request->input('source_type');
            $details = $request->input('detail');
            $reportType = $request->input('report_type');
            $location = $request->input('location');
            $reportDate = $request->input('occurrence_date');

            $dbDATA = [
                'source_id' => $sourceType,
                'report_details' => $details,
                'report_type' => $reportType,
                'location' => $location,
                'report_date' => Utility::standardDate($reportDate),
                'response_status' => Utility::ZERO,
                'created_by' => Utility::checkAuth('temp_user')->id,
                'status' => Utility::STATUS_ACTIVE
            ];
            HseReports::create($dbDATA);

            $hseManagers = HseAccess::specialColumns('user_id',Utility::STATUS_ACTIVE);
            foreach ($hseManagers as $userData){
                $userEmail = $userData->access_user->email;

                $mailContent = [];

                $messageBody = "Hello ".$userData->access_user->firstname.", ".Auth::user()->firstname." ".Auth::user()->lastname.
                    " just logged an incident/hazard report, please visit the portal to action report";

                $mailContent['message'] = $messageBody;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request)
    {
        //
        $sourceType = HseSourceType::getAllData();
        $hseReport = HseReports::firstRow('id',$request->input('dataId'));
        return view::make('hse_report.edit_form')->with('edit',$hseReport)->with('sourceType',$sourceType);

    }

    public function requestResponseForm(Request $request)
    {
        //
        $hseReport = HseReports::firstRow('id',$request->input('dataId'));
        return view::make('hse_report.attach_form')->with('edit',$hseReport);

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

        $validator = Validator::make($request->all(),HseReports::$mainRules);
        if($validator->passes()) {

            $sourceType = $request->input('source_type');
            $details = $request->input('detail');
            $reportType = $request->input('report_type');
            $location = $request->input('location');
            $reportDate = $request->input('occurrence_date');

            $dbDATA = [
                'source_id' => $sourceType,
                'report_details' => $details,
                'report_type' => $reportType,
                'location' => $location,
                'report_date' => Utility::standardDate($reportDate),
                'response_status' => Utility::ZERO,
            ];

            HseReports::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

            $hseManagers = HseAccess::specialColumns('user_id',Utility::STATUS_ACTIVE);
            foreach ($hseManagers as $userData){
                $userEmail = $userData->access_user->email;

                $mailContent = [];

                $messageBody = "Hello ".$userData->access_user->firstname.", ".Auth::user()->firstname." ".Auth::user()->lastname.
                    " just modified a logged incident/hazard report, please visit the portal to action report";

                $mailContent['message'] = $messageBody;
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
        $all_id = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

        $inactiveHse = [];
        $activeHse = [];

        foreach($all_id as $var){
            $newsRequest = HseReports::firstRow('id',$var);
            if($newsRequest->created_by == Auth::user()->id){
                $inactiveHse[] = $var;
            }else{
                $activeHse[] = $var;
            }
        }

        $message = (count($inactiveHse) < 1) ? ' and '.count($activeHse).
            ' news was not created by you and cannot be deleted' : '';
        if(count($inactiveHse) > 0){


            $delete = HseReports::massUpdate('id',$inactiveHse,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($inactiveHse).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($activeHse).' was not created by you and cannot be deleted',
                'message' => 'warning'
            ]);

        }


    }
}
