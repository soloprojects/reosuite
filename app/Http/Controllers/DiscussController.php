<?php

namespace App\Http\Controllers;

use App\Helpers\Notify;
use App\model\Department;
use App\Helpers\Utility;
use App\model\Discuss;
use App\model\DiscussComments;
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

class DiscussController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $mainData = Discuss::paginateAllData();
        $dept = Department::getAllData();
        $this->processData($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make('discuss.reload',array('mainData' => $mainData,
                'dept' => $dept))->render());

        }else{
            return view::make('discuss.main_view')->with('mainData',$mainData)->with('dept',$dept);
        }

    }

    public function discussArchive(Request $request)
    {
        //
        //$req = new Request();
        $mainData = Discuss::paginateDiscussArchive();
        $dept = Department::getAllData();
        $this->processData($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make('discuss.archive_reload',array('mainData' => $mainData,
                'dept' => $dept))->render());

        }else{
            return view::make('discuss.archive')->with('mainData',$mainData)->with('dept',$dept);
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
        $validator = Validator::make($request->all(),Discuss::$mainRules);
        if($validator->passes()){

            $usersAccessibleToDiscuss = $request->input('users');
            $deptArr = [];
            $allDept = $request->input('department');
            if(!empty($allDept)) {
                foreach ($allDept as $dept) {
                    $deptArr[] = $dept;
                }
            }
            $files = $request->file('attachment');
            $attachment = [];

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

            $countData = Discuss::countData('title',$request->input('title'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $dbDATA = [
                    'title' => ucfirst($request->input('title')),
                    'docs' => json_encode($attachment),
                    'departments' => json_encode($deptArr),
                    'tags' => implode(',',$deptArr),
                    'accessible_users' => $usersAccessibleToDiscuss,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Discuss::create($dbDATA);

                if(!empty($deptArr)){
                    $activeUsers = User::massDataCondition('dept_id',$deptArr,'active_status',Utility::STATUS_ACTIVE);
                    foreach ($activeUsers as $userData){
                        $userEmail = $userData->email;

                        $mailContent = [];

                        $messageBody = "Hello '.$userData->firstname.', you have been invited by ".Auth::user()->firstname." ".Auth::user()->lastname.
                            " to join a topic discussion with title ".ucfirst($request->input('title')).
                            " please visit the portal to join discussion";

                        $mailContent['message'] = $messageBody;
                        $mailContent['fromEmail'] = Auth::user()->email;
                        Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
                    }
                }
                if(!empty(json_decode($usersAccessibleToDiscuss))){
                    $getUsers = json_decode($usersAccessibleToDiscuss);
                    $activeUsers = User::massDataCondition('id',$getUsers,'active_status',Utility::STATUS_ACTIVE);
                    foreach ($activeUsers as $userData){
                        $userEmail = $userData->email;

                        $mailContent = [];

                        $messageBody = "Hello '.$userData->firstname.', you have been invited by ".Auth::user()->firstname." ".Auth::user()->lastname.
                            " to join a topic discussion with title ".ucfirst($request->input('title')).
                            " please visit the portal to join discussion";

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
        $discuss = Discuss::firstRow('id',$request->input('dataId'));
        $this->processItemData($discuss);
        return view::make('discuss.edit_form')->with('edit',$discuss);

    }

    public function editDeptForm(Request $request)
    {
        //
        $discuss = Discuss::firstRow('id',$request->input('dataId'));
        $this->processItemData($discuss);
        return view::make('discuss.dept_form')->with('edit',$discuss);

    }

    public function attachmentForm(Request $request)
    {
        //
        $request = Discuss::firstRow('id',$request->input('dataId'));
        return view::make('discuss.attach_form')->with('edit',$request);
    }

    public function editAttachment(Request $request){
        $files = $request->file('attachment');

        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = Discuss::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->docs);

        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . ".".$file->getClientOriginalName() . $file->getClientOriginalExtension();

                $file->move(
                    Utility::FILE_URL(), $file_name
                );
                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                array_push($oldAttachment,$file_name);

            }
        }

        $attachJson = json_encode($oldAttachment);
        $dbData = [
            'docs' => $attachJson,
        ];
        $save = Discuss::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'saved'
        ]);

    }

    public function removeAttachment(Request $request){
        $file_name = $request->input('attachment');
        //return $files;
        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = Discuss::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->docs,true);


        //REMOVE FILES FROM AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
        if (($key = array_search($file_name, $oldAttachment)) !== false) {
            $fileUrl = Utility::FILE_URL($file_name);
            unset($oldAttachment[$key]);
            unlink($fileUrl);
        }


        $attachJson = json_encode($oldAttachment);
        $dbData = [
            'docs' => $attachJson,
        ];
        $save = Discuss::defaultUpdate('id',$editId,$dbData);

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

    public function removeAccessibleUser(Request $request){

        $editId = $request->input('dataId');
        $userId = $request->input('param');
        $oldData = Discuss::firstRow('id',$editId);
        $oldUsers = json_decode($oldData->accessible_users,true);


        //REMOVE USER FROM AN ARRAY
        if (($key = array_search($userId, $oldUsers)) != false) {
            unset($oldUsers[$key]);
        }

        $usersArrayToJson = json_encode($oldUsers);
        $dbData = [
            'accessible_users' => $usersArrayToJson,
        ];
        $save = Discuss::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message' => 'good',
            'message2' => 'User have been removed'
        ]);

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
        $validator = Validator::make($request->all(),Discuss::$mainRulesEdit);
        if($validator->passes()) {
            $usersAccessibleToDiscuss = $request->input('users');

            $dbDATA = [
                'title' => ucfirst($request->input('title')),
                'accessible_users' => $usersAccessibleToDiscuss,
                'updated_by' => Auth::user()->id,
            ];
            $rowData = Discuss::specialColumns('title', $request->input('title'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Discuss::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                Discuss::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
     * ADD/REMOVE FOR discuss DEPARTMENTS the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modifyDept(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $status = $request->input('status');
        $editId = $request->input('param');
        $discuss = Discuss::firstRow('id',$editId);
        $discussDept = json_decode($discuss->departments,true);

        $newDept = ($status == '1') ? array_merge($discussDept,$idArray) : array_diff($discussDept,$idArray);

        $dbData = [
            'departments' => json_encode($newDept),
            'tags' => implode(',',$newDept),
            'updated_by' => Auth::user()->id,
        ];
        $delete = Discuss::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message2' => 'department(s) modified Successfully',
            'message' => 'saved'
        ]);

    }

    //discuss SEARCH REQUEST AND QUERY
    public function searchDiscussUsingDate(Request $request)
    {

        $startDate = Utility::standardDate($request->input('from_date'));
        $endDate = Utility::standardDate($request->input('to_date'));
        $type = $request->input('param');
        $dateArray = [$startDate,$endDate];

        //PROCESS SEARCH REQUEST
        $mainData = Discuss::searchUsingDate($dateArray,$type);
        $this->processData($mainData);
        if($type == Utility::STATUS_ACTIVE){
            return view::make('discuss.search_discuss')->with('mainData',$mainData);
        }
        return view::make('discuss.search_archive_discuss')->with('mainData',$mainData);

    }

    public function searchDiscuss(Request $request)
    {

        $type = $request->input('param');
        $searchValue = $request->input('searchVar');
        //PROCESS SEARCH REQUEST
        $mainData = Discuss::searchDiscuss('title',$searchValue,$type);
        $this->processData($mainData);
        if($type == Utility::STATUS_ACTIVE){
            return view::make('discuss.search_discuss')->with('mainData',$mainData);
        }
        return view::make('discuss.search_archive_discuss')->with('mainData',$mainData);

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
        Discuss::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

    public function restoreDiscussArchive(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_ACTIVE
        ];
        Discuss::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message' => 'warning',
            'message2' => 'Data restored successfully'
        ]);

    }

    public function destroyArchive(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        foreach ($idArray as $id){
            $docData = Discuss::firstRow('id',$id);
            $attachment = json_decode($docData->docs,true);


            //REMOVE FILES FROM AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
            foreach($attachment as $fileName) {
                $fileUrl = Utility::FILE_URL($fileName);
                unlink($fileUrl);
            }
            Discuss::destroy($id);
        }

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

    public function processData($data){
        foreach($data as $val){
            $allDept = json_decode($val->departments,true);
            $discussUsers = json_decode($val->accessible_users,true);
            if(!empty($allDept)){
                $fetchDept = Department::massData('id',$allDept);
                $val->deptAccess = $fetchDept;
                $val->deptArray = $allDept;
            }else{
                $val->deptAccess = '';
            }

            if(!empty($discussUsers)){
                $fetchUsers = User::massData('id',$discussUsers);
                $val->userAccess = $fetchUsers;
                $val->userArray = $discussUsers;
            }else{
                $val->userAccess = '';
            }

        }
    }

    public function processItemData($val){
        $discussDept = json_decode($val->departments,true);
        $discussUsers = json_decode($val->accessible_users,true);
        if(!empty($discussDept)){
            $fetchDept = Department::massData('id',$discussDept);
            $val->dept = $fetchDept;

            $allDept = Department::getAllData();
            $uniqueDept = Utility::arrayDiff($allDept,$discussDept);
            $extraDept = Department::massData('id',$uniqueDept);
            $val->extra_dept = $extraDept;
        }else{
            $val->dept = '';
            $val->extra_dept = '';
        }

        if(!empty($discussUsers)){
            $fetchUsers = User::massData('id',$discussUsers);
            $val->userAccess = $fetchUsers;
        }else{
            $val->userAccess = '';
        }

    }

    public function viewComments(Request $request, $id)
    {
        //
        $mainData = Discuss::firstRow('id',$id);
        $this->logComments($mainData,$id);

        if ($request->ajax()) {
            return \Response::json(view::make('discuss.view_comment_reload'),array('mainData' => $mainData,
                ))->render();

        }
        return view::make('discuss.view_comment')->with('mainData',$mainData);

    }

    public function comment(Request $request)
    {
        //
        $validator = Validator::make($request->all(),DiscussComments::$mainRules);
        if($validator->passes()){

            $dbDATA = [
                'discuss_id' => $request->input('discuss_id'),
                'user_id' => Auth::user('')->id,
                'comment' => ucfirst($request->input('comment')),
                'status' => Utility::STATUS_ACTIVE,
                'created_by' => Utility::checkAuth('temp_user')->id,
            ];
            $newComment = DiscussComments::create($dbDATA);

            return view::make('discuss.view_comment_reload')->with('data',$newComment);


        }

        return '';

    }

    public function freshComments(Request $request)
    {
        //
        $discussId = $request->input('postId');
        $freshComments = DiscussComments::specialColumnsAsc('discuss_id',$discussId);
        if(!empty($freshComments)){

            return view::make('discuss.fresh_comments')->with('mainData',$freshComments);

        }
        return '';


    }

    public function logComments($mainData,$id){
        $comments = DiscussComments::specialColumnsAsc('discuss_id',$id);
        $mainData->allComments = $comments;
        return $mainData;
    }

}
