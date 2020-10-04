<?php

namespace App\Http\Controllers;

use App\Helpers\Notify;
use App\model\CrmActivity;
use App\model\CrmActivityType;
use App\model\CrmNotes;
use App\model\CrmSalesCycle;
use App\model\CrmStages;
use Illuminate\Http\Request;
use App\model\CrmOpportunity;
use App\model\SalesTeam;
use App\Helpers\Utility;
use App\User;
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use App\Http\Requests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class CrmOpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $mainData = CrmOpportunity::paginateAllData();
        $salesCycle = CrmSalesCycle::getAllData();
        $salesTeam = SalesTeam::getAllData();
        $opportunityStage = CrmStages::getAllData();
        $activityType = CrmActivityType::getAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('crm_opportunity.reload',array('mainData' => $mainData,
               ))->render());

        }else{
                return view::make('crm_opportunity.main_view')->with('mainData',$mainData)
                    ->with('salesTeam',$salesTeam)->with('opportunityStage',$opportunityStage)
                    ->with('activityType',$activityType)->with('salesCycle',$salesCycle);

        }

    }

    public function opportunityItem(Request $request,$id)
    {

        $mainData = CrmOpportunity::firstRow('id',$id);
        $salesTeam = SalesTeam::getAllData();
        $salesCycleStages = json_decode($mainData->salesCycle->stages,true);
        $opportunityStage = CrmStages::massDataGroupByStage('id',$salesCycleStages);
        $activityType = CrmActivityType::getAllData();
        $this->sortOpportunityStages($opportunityStage,$mainData);
        //return $opportunityStage;exit();

            return view::make('crm_opportunity.opportunity_item')->with('mainData',$mainData)
                ->with('salesTeam',$salesTeam)->with('opportunityStage',$opportunityStage)
                ->with('activityType',$activityType);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $lead = $request->input('lead');
        $stage = $request->input('opportunity_stage');
        $opportunityName = $request->input('opportunity_name');
        $amount = $request->input('amount');
        $expectedRevenue = $request->input('expected_revenue');
        $closingDate = Utility::standardDate($request->input('closing_date'));
        $salesTeam = $request->input('sales_team');
        $salesCycle = $request->input('sales_cycle');

        $validator = Validator::make($request->all(),CrmOpportunity::$mainRules);
        if($validator->passes()){

            $uid = Utility::generateUID('crm_opportunity');

            $dbDATA = [
                'uid' => $uid,
                'lead_id' => $lead,
                'opportunity_name' => $opportunityName,
                'stage_id' => $stage,
                'sales_team_id' => $salesTeam,
                'sales_cycle_id' => $salesCycle,
                'amount' => $amount,
                'expected_revenue' => $expectedRevenue,
                'closing_date' => $closingDate,
                'opportunity_status' => Utility::ONGOING,
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];

            CrmOpportunity::create($dbDATA);

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
        $data = CrmOpportunity::firstRow('id',$request->input('dataId'));
        $salesTeam = SalesTeam::getAllData();
        $salesCycleList = json_decode($data->salesCycle->stages,true);

        $opportunityStage = CrmStages::massData('id',$salesCycleList);
        return view::make('crm_opportunity.edit_form')->with('edit',$data)->with('salesTeam',$salesTeam)
            ->with('opportunityStage',$opportunityStage);

    }

    public function fetchPossibility(Request $request)
    {
        //
        $data = CrmStages::firstRow('id',$request->input('dataId'));
        $probability = (empty($data)) ? 0 : $data->probability;
       return $probability;

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
        $mainRules = [];

        $validator = Validator::make($request->all(),$mainRules);
        if($validator->passes()) {

            $lead = $request->input('lead');
            $stage = $request->input('opportunity_stage');
            $opportunityName = $request->input('opportunity_name');
            $amount = $request->input('amount');
            $expectedRevenue = $request->input('expected_revenue');
            $closingDate = Utility::standardDate($request->input('closing_date'));
            $salesTeam = $request->input('sales_team');

            $dbDATA = [
                'lead_id' => $lead,
                'opportunity_name' => $opportunityName,
                'stage_id' => $stage,
                'sales_team_id' => $salesTeam,
                'amount' => $amount,
                'expected_revenue' => $expectedRevenue,
                'closing_date' => $closingDate,
                'created_by' => Auth::user()->id,
                'status' => Utility::STATUS_ACTIVE
            ];

            CrmOpportunity::defaultUpdate('id',$request->input('edit_id'),$dbDATA);

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

    public function searchOpportunity(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = CrmOpportunity::searchData($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }

        $dataIds = array_unique($obtain_array);
        $mainData =  CrmOpportunity::massDataPaginate('uid', $dataIds);
        //print_r($dataIds); die();
        if (count($dataIds) > 0) {

            return view::make('crm_opportunity.search')->with('mainData',$mainData);
        }else{
            return 'No match found, please search again with sensitive words';
        }

    }

    public function opportunityStatus(Request $request)
    {
        //

        $idArray = json_decode($request->input('all_data'));

        $opportunities = CrmOpportunity::massData('id',$idArray);

        if($request->input('status') == Utility::WON){
            foreach($opportunities as $data){

                    $dbData = [
                        'opportunity_status' => Utility::WON,
                        'lost_reason' => '',
                        'updated_by' => Auth::user()->id
                    ];

                    $update = CrmOpportunity::defaultUpdate('id',$data->id,$dbData);


                    if($update){
                        $management = User::specialColumns('role',Utility::TOP_USERS);
                        if(count($management) >0){ //SEND MAIL TO ALL IN MANAGEMENT ABOUT THIS APPROVAL
                            foreach($management as $userData) {

                                $mailContent = [];

                                $messageBody = "Hello '.$userData->firstname.', ".Utility::companyInfo()->name." have 
                             won ".$data->opportunity_name." business deal, please visit the portal to view";

                                $mailContent['message'] = $messageBody;
                                $mailContent['fromEmail'] = Auth::user()->email;
                                Notify::GeneralMail('mail_views.general', $mailContent, $userData->email);

                            }
                        }

                    }   //END OF WHEN STATUS IS COMPLETE



            }   //END OF LOOP FOR APPROVING PROCESS


            return response()->json([
                'message2' => 'deleted',
                'message' => count($idArray).' have been marked as won'
            ]);

        }

        if($request->input('status') == Utility::LOST){  //LOST OPPORTUNITY CODES BEGINS HERE

            $lostReason = $request->input('input_text');

            foreach($idArray as $id) {

                $dbData = [
                    'updated_by' => Auth::user()->id,
                    'lost_reason' => $lostReason,
                    'opportunity_status' => Utility::LOST,
                ];

                $update = CrmOpportunity::defaultUpdate('id',$id,$dbData);

                return response()->json([
                    'message2' => 'deleted',
                    'message' => count($idArray).' have been marked as lost'
                ]);

            }

        }   //END OF LOST OPPORTUNITY CODES

        if($request->input('status') == Utility::ONGOING){  //LOST OPPORTUNITY CODES BEGINS HERE

            foreach($idArray as $id) {

                $dbData = [
                    'updated_by' => Auth::user()->id,
                    'lost_reason' => '',
                    'opportunity_status' => Utility::ONGOING,
                ];

                $update = CrmOpportunity::defaultUpdate('id',$id,$dbData);

            }

            return response()->json([
                'message2' => 'deleted',
                'message' => count($idArray).' have been marked as ongoing'
            ]);

        }   //END OF LOST OPPORTUNITY CODES

    //END FOR MARKING OPPORTUNITY

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

        $inactiveOpportunity = [];
        $activeOpportunity = [];

        foreach($all_id as $var){
            $opportunityRequest = CrmOpportunity::firstRow('id',$var);
            if($opportunityRequest->created_by == Auth::user()->id || in_array(Auth::user()->id,Utility::TOP_USERS)){
                $inactiveOpportunity[] = $var;
            }else{
                $activeOpportunity[] = $var;
            }
        }

        $message = (count($inactiveOpportunity) < 1) ? ' and '.count($activeOpportunity).
            ' opportunity was not created by you and cannot be deleted' : '';
        if(count($inactiveOpportunity) > 0){


            $delete = CrmOpportunity::massUpdate('id',$inactiveOpportunity,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($inactiveOpportunity).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($activeOpportunity).' was not created by you and cannot be deleted',
                'message' => 'warning'
            ]);

        }
    }

    public function sortOpportunityStages($stages,$opportunityData){

        foreach($stages as $data){
            $stageActivity = CrmActivity::specialColumns2('opportunity_id',$opportunityData->id,'stage_id',$data->id);
            $data->stageActivity = $stageActivity;
            $stageNotes = CrmNotes::specialColumns2('opportunity_id',$opportunityData->id,'stage_id',$data->id);
            $data->stageNotes = $stageNotes;

        }
        return $stages;

    }

}
