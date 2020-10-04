<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\JobApplicants;
use App\model\Jobs;
use App\model\Department;

use App\User;
use Auth;
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

class JobsController extends Controller
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
        $mainData = Jobs::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('jobs.reload',array('mainData' => $mainData))->render());

        }else{
            return view::make('jobs.main_view')->with('mainData',$mainData);
        }

    }

    public function filterApplicants(Request $request)
    {
        //
        //$req = new Request();
        $mainData = Jobs::getAllData2();
        if ($request->ajax()) {
            return \Response::json(view::make('jobs.applicants_reload',array('mainData' => $mainData))->render());

        }else {
            return view::make('jobs.applicants')->with('mainData', $mainData);
        }

    }

    public function availablePositions(Request $request)
    {
        //
        $mainData = Jobs::specialColumnsPage('job_status',Utility::STATUS_ACTIVE);

        return view::make('jobs.job_list')->with('mainData',$mainData);

    }

    public function jobPosition(Request $request, $id)
    {
        //
        $job = Jobs::firstRow('id',$id);
        //print_r($project);exit();
        return view::make('jobs.view_apply')->with('data',$job);

    }

    public function applyJob(Request $request)
    {
        //
        $validator = Validator::make($request->all(),JobApplicants::$mainRules);
        if($validator->passes()){

                $cv = 'user.png';
                if($request->hasFile('cv_file')){

                    $file = $request->file('cv_file');
                    $filename = date('Y-m-d-H-i-s')."_". Utility::generateUID(null, 10) .$file->getClientOriginalName();
                    $file->move(
                        Utility::FILE_URL(), $filename
                    );
                    $cv = $filename;

                }

                $dbDATA = [
                    'email' => ucfirst($request->input('email')),
                    'cover_letter' => ucfirst($request->input('cover_letter')),
                    'job_id' => $request->input('job'),
                    'firstname' => ucfirst($request->input('firstname')),
                    'lastname' => ucfirst($request->input('lastname')),
                    'phone' => ucfirst($request->input('phone')),
                    'address' => ucfirst($request->input('address')),
                    'experience' => $request->input('experience'),
                    'cv_file' => $cv,
                    'status' => Utility::STATUS_ACTIVE
                ];
                JobApplicants::create($dbDATA);

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

    public function searchApplicants(Request $request)
    {
        //


        $job = $request->input('job');
        $exp = $request->input('experience');
        $startDate = Utility::standardDate($request->input('from_date'));
        $endDate = Utility::standardDate($request->input('to_date'));
        $dateArray = [$startDate,$endDate];
        $mainData = [];

            if($job != '' && $exp != ''){
                $mainData = JobApplicants::specialColumns2Date('job_id', $job, 'experience', $exp,$dateArray);
            }
            if($job != '' && $exp == '00'){
                $mainData = JobApplicants::specialColumnsDate('job_id', $job,$dateArray);
            }
            if($exp != '00' && $job == ''){
                $mainData = JobApplicants::specialColumnsDate('experience', $exp,$dateArray);
            }

        //return $exp.$job;exit();
        return view::make('jobs.search_applicants')->with('mainData',$mainData);

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
        $validator = Validator::make($request->all(),Jobs::$mainRules);
        if($validator->passes()){

            $countData = Jobs::countData('job_title',$request->input('job_title'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'job_title' => ucfirst($request->input('job_title')),
                    'job_purpose' => Utility::decodeUriData(ucfirst($request->input('job_purpose'))),
                    'job_desc' => Utility::decodeUriData(ucfirst($request->input('job_desc'))),
                    'job_spec' => Utility::decodeUriData(ucfirst($request->input('job_spec'))),
                    'job_type' => ucfirst($request->input('job_type')),
                    'experience' => ucfirst($request->input('experience')),
                    'location' => ucfirst($request->input('location')),
                    'salary_range' => ucfirst($request->input('salary_range')),
                    'job_status' => ucfirst($request->input('job_status')),
                    'status' => Utility::STATUS_ACTIVE
                ];
                Jobs::create($dbDATA);

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
        $dept = Jobs::firstRow('id',$request->input('dataId'));
        return view::make('jobs.edit_form')->with('edit',$dept);

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
        $validator = Validator::make($request->all(),Jobs::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'job_title' => ucfirst($request->input('job_title')),
                'job_purpose' => Utility::decodeUriData(ucfirst($request->input('job_purpose'))),
                'job_desc' => Utility::decodeUriData(ucfirst($request->input('job_desc'))),
                'job_spec' => Utility::decodeUriData(ucfirst($request->input('job_spec'))),
                'job_type' => ucfirst($request->input('job_type')),
                'experience' => ucfirst($request->input('experience')),
                'location' => ucfirst($request->input('location')),
                'salary_range' => ucfirst($request->input('salary_range')),
                'job_status' => ucfirst($request->input('job_status')),
            ];
            $rowData = Jobs::specialColumns('job_title', $request->input('job_title'));

            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Jobs::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                } else {
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Entry already exist, please try another entry'
                    ]);

                }

            } else{
                Jobs::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function jobItem(Request $request, $id)
    {
        //
        $job = JobApplicants::specialColumnsPage('job_id',$id);
        //print_r($project);exit();
        if ($request->ajax()) {
            return \Response::json(view::make('jobs.job_item_reload',array('mainData' => $job,'jobId'=>$id))->render());

        }else {
            return view::make('jobs.job_item')->with('mainData', $job)->with('jobId', $id);
        }

    }

    public function downloadAttachment(){
        $file = $_GET['file'];
        $download = Utility::FILE_URL($file);
        return response()->download($download);
        //return $file;
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
        $delete = Jobs::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }

    public function destroyApplicants(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        foreach($idArray as $id){
            $data = JobApplicants::firstRow('id',$id);
            $fileUrl = Utility::FILE_URL($data->cv_file);
            unlink($fileUrl);
        }
        //$delete = JobApplicants::massUpdate('id',$idArray,$dbData);
        $delete = JobApplicants::destroy($idArray);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);
    }

    public function changeStatus(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $dbData = [
            'job_status' => $status
        ];
        $delete = Jobs::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'changed successfully',
            'message' => 'Status change'
        ]);

    }

}
