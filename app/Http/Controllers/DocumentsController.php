<?php

namespace App\Http\Controllers;

use App\model\Department;
use App\Helpers\Utility;
use App\model\DocumentCategory;
use App\model\DocumentComments;
use App\model\Documents;
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

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $mainData = Documents::paginateAllData();
        $dept = Department::getAllData();
        $docCategory = DocumentCategory::getAllData();
        $this->processData($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make('document.reload',array('mainData' => $mainData,
                'dept' => $dept,'docCategory' => $docCategory))->render());

        }else{
            return view::make('document.main_view')->with('mainData',$mainData)->with('dept',$dept)
                ->with('docCategory',$docCategory);
        }

    }

    public function documentArchive(Request $request)
    {
        //
        //$req = new Request();
        $mainData = Documents::paginateDocumentArchive();
        $docCategory = DocumentCategory::getAllData();
        $dept = Department::getAllData();
        $this->processData($mainData);

        if ($request->ajax()) {
            return \Response::json(view::make('document.archive_reload',array('mainData' => $mainData,
                'dept' => $dept,'docCategory' => $docCategory))->render());

        }else{
            return view::make('document.archive')->with('mainData',$mainData)->with('dept',$dept)
                ->with('docCategory',$docCategory);
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
        $validator = Validator::make($request->all(),Documents::$mainRules);
        if($validator->passes()){

            $usersAccessibleToDocuments = $request->input('users');
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

            $countData = Documents::countData('doc_name',$request->input('document_name'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{

                $dbDATA = [
                    'doc_name' => ucfirst($request->input('document_name')),
                    'category_id' => $request->input('document_category'),
                    'doc_desc' => ucfirst($request->input('document_name')),
                    'docs' => json_encode($attachment),
                    'departments' => json_encode($deptArr),
                    'tags' => implode(',',$deptArr),
                    'accessible_users' => $usersAccessibleToDocuments,
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Documents::create($dbDATA);

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
        $document = Documents::firstRow('id',$request->input('dataId'));
        $docCategory = DocumentCategory::getAllData();
        $this->processItemData($document);
        return view::make('document.edit_form')->with('edit',$document)->with('docCategory',$docCategory);

    }

    public function editDeptForm(Request $request)
    {
        //
        $document = Documents::firstRow('id',$request->input('dataId'));
        $this->processItemData($document);
        return view::make('document.dept_form')->with('edit',$document);

    }

    public function attachmentForm(Request $request)
    {
        //
        $request = Documents::firstRow('id',$request->input('dataId'));
        return view::make('document.attach_form')->with('edit',$request);
    }

    public function editAttachment(Request $request){
        $files = $request->file('attachment');

        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = Documents::firstRow('id',$editId);
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
        $save = Documents::defaultUpdate('id',$editId,$dbData);

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
        $oldData = Documents::firstRow('id',$editId);
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
        $save = Documents::defaultUpdate('id',$editId,$dbData);

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
        $oldData = Documents::firstRow('id',$editId);
        $oldUsers = json_decode($oldData->accessible_users,true);


        //REMOVE USER FROM AN ARRAY
        if (($key = array_search($userId, $oldUsers)) != false) {
            unset($oldUsers[$key]);
        }

        $usersArrayToJson = json_encode($oldUsers);
        $dbData = [
            'accessible_users' => $usersArrayToJson,
        ];
        $save = Documents::defaultUpdate('id',$editId,$dbData);

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
        $validator = Validator::make($request->all(),Documents::$mainRulesEdit);
        if($validator->passes()) {
            $usersAccessibleToDocuments = $request->input('users');

            $dbDATA = [
                'doc_name' => ucfirst($request->input('document_name')),
                'category_id' => $request->input('document_category'),
                'doc_desc' => ucfirst($request->input('document_details')),
                'accessible_users' => $usersAccessibleToDocuments,
                'updated_by' => Auth::user()->id,
            ];
            $rowData = Documents::specialColumns('doc_name', $request->input('document_name'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Documents::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
                Documents::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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
     * ADD/REMOVE FOR DOCUMENT DEPARTMENTS the specified resource in storage.
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
        $document = Documents::firstRow('id',$editId);
        $documentDept = json_decode($document->departments,true);

        $newDept = ($status == '1') ? array_merge($documentDept,$idArray) : array_diff($documentDept,$idArray);

        $dbData = [
            'departments' => json_encode($newDept),
            'tags' => implode(',',$newDept),
            'updated_by' => Auth::user()->id,
        ];
        $delete = Documents::defaultUpdate('id',$editId,$dbData);

        return response()->json([
            'message2' => 'department(s) modified Successfully',
            'message' => 'saved'
        ]);

    }

    //DOCUMENT SEARCH REQUEST AND QUERY
    public function searchDocumentUsingDate(Request $request)
    {

        $startDate = Utility::standardDate($request->input('from_date'));
        $endDate = Utility::standardDate($request->input('to_date'));
        $type = $request->input('param');
        $docCategory = $request->input('document_category');
        $dateArray = [$startDate,$endDate];
        $mainData = [];
        //PROCESS SEARCH REQUEST
        if(in_array(0,$docCategory)){
            $mainData = Documents::searchUsingDate($dateArray,$type);
        }

        if(!in_array(0,$docCategory)){
            $mainData = Documents::massDataConditionDate('category_id', $docCategory,$type, $dateArray);
        }

        $this->processData($mainData);
        if($type == Utility::STATUS_ACTIVE){
            return view::make('document.search_document')->with('mainData',$mainData);
        }
        return view::make('document.search_archive_document')->with('mainData',$mainData);

    }

    public function searchDocument(Request $request)
    {

        $type = $request->input('param');
        $searchValue = $request->input('searchVar');
        //PROCESS SEARCH REQUEST
        $mainData = Documents::searchDocument('doc_name',$searchValue,$type);
        $this->processData($mainData);
        if($type == Utility::STATUS_ACTIVE){
            return view::make('document.search_document')->with('mainData',$mainData);
        }
        return view::make('document.search_archive_document')->with('mainData',$mainData);

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
        Documents::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

    public function restoreDocumentArchive(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_ACTIVE
        ];
        Documents::massUpdate('id',$idArray,$dbData);

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
            $docData = Documents::firstRow('id',$id);
            $attachment = json_decode($docData->docs,true);


            //REMOVE FILES FROM AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
            foreach($attachment as $fileName) {
                $fileUrl = Utility::FILE_URL($fileName);
                unlink($fileUrl);
            }
            Documents::destroy($id);
        }

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

    public function processData($data){
        foreach($data as $val){
            $allDept = json_decode($val->departments,true);
            $documentUsers = json_decode($val->accessible_users,true);
            if(!empty($allDept)){
                $fetchDept = Department::massData('id',$allDept);
                $val->deptAccess = $fetchDept;
                $val->deptArray = $allDept;
            }else{
                $val->deptAccess = '';
            }

            if(!empty($documentUsers)){
                $fetchUsers = User::massData('id',$documentUsers);
                $val->userAccess = $fetchUsers;
                $val->userArray = $documentUsers;
            }else{
                $val->userAccess = '';
            }

        }
    }

    public function processItemData($val){
        $documentDept = json_decode($val->departments,true);
        $documentUsers = json_decode($val->accessible_users,true);
        if(!empty($documentDept)){
            $fetchDept = Department::massData('id',$documentDept);
            $val->dept = $fetchDept;

            $allDept = Department::getAllData();
            $uniqueDept = Utility::arrayDiff($allDept,$documentDept);
            $extraDept = Department::massData('id',$uniqueDept);
            $val->extra_dept = $extraDept;
        }else{
            $val->dept = '';
            $val->extra_dept = '';
        }

        if(!empty($documentUsers)){
            $fetchUsers = User::massData('id',$documentUsers);
            $val->userAccess = $fetchUsers;
        }else{
            $val->userAccess = '';
        }

    }

    public function viewComments(Request $request, $id)
    {
        //
        $mainData = Documents::firstRow('id',$id);
        $this->logComments($mainData,$id);

        if ($request->ajax()) {
            return \Response::json(view::make('document.view_comment_reload'),array('mainData' => $mainData,
            ))->render();

        }
        return view::make('document.view_comment')->with('mainData',$mainData);

    }

    public function comment(Request $request)
    {
        //
        $validator = Validator::make($request->all(),DocumentComments::$mainRules);
        if($validator->passes()){

            $dbDATA = [
                'document_id' => $request->input('document_id'),
                'user_id' => Auth::user('')->id,
                'comment' => ucfirst($request->input('comment')),
                'status' => Utility::STATUS_ACTIVE,
                'created_by' => Utility::checkAuth('temp_user')->id,
            ];
            $newComment = DocumentComments::create($dbDATA);

            return view::make('document.view_comment_reload')->with('data',$newComment);


        }

        return '';

    }

    public function freshComments(Request $request)
    {
        //
        $documentId = $request->input('postId');
        $freshComments = DocumentComments::specialColumnsAsc('document_id',$documentId);
        if(!empty($freshComments)){

            return view::make('document.fresh_comments')->with('mainData',$freshComments);

        }
        return '';


    }

    public function logComments($mainData,$id){
        $comments = DocumentComments::specialColumnsAsc('document_id',$id);
        $mainData->allComments = $comments;
        return $mainData;
    }

}
