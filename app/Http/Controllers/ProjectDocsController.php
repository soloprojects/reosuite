<?php

namespace App\Http\Controllers;

use App\model\ProjectDocs;
use App\model\Project;
use App\Helpers\Utility;use App\User;
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

class ProjectDocsController extends Controller
{
    //

    public function index(Request $request, $id)
    {
        //
        //$req = new Request();
        $mainData = ProjectDocs::paginateAllData();

        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);
        $active = 0;
        if(Utility::authColumn('temp_user') == 'assigned_user'){
            if(in_array(Utility::checkAuth('temp_user')->id,Utility::TOP_USERS))
            $active = 1;
        }

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','project_docs.reload','project_docs.reload'),array('mainData' => $mainData,
                'item' => $project, 'active' => $active))->render());

        }
        return view::make(Utility::authBlade('temp_user','project_docs.main_view','project_docs.main_view_temp'))->with('mainData',$mainData)
            ->with('item',$project)->with('active',$active);

    }

    public function indexTemp(Request $request, $id)
    {
        //
        //$req = new Request();
        $mainData = ProjectDocs::paginateAllData();

        $project = Project::firstRow('id',$id);
        Utility::processProjectItem($project);

        $active = 0;
        if(Utility::authColumn('temp_user') == 'user_id'){
            if(in_array(Utility::checkAuth('temp_user')->id,Utility::TOP_USERS))
                $active = 1;
        }

        if ($request->ajax()) {
            return \Response::json(view::make(Utility::authBlade('temp_user','project_docs.reload','project_docs.reload'),array('mainData' => $mainData,
                'item' => $project, 'active' => $active))->render());

        }
        return view::make(Utility::authBlade('temp_user','project_docs.main_view','project_docs.main_view_temp'))->with('mainData',$mainData)
            ->with('item',$project)->with('active',$active);

    }

    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),ProjectDocs::$mainRules);
        if($validator->passes()) {

                    $files = $request->file('attachment');
                    //return $files;
                    $attachment = [];

                    if ($files != '') {
                        foreach ($files as $file) {
                            //return$file;
                            $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();
                            $real_images[] = $file_name;
                            $file->move(
                                Utility::FILE_URL(), $file_name
                            );
                            //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                            //array_push($cdn_images,$file_name);
                            $attachment[] = $file_name;

                        }
                    }

                    $attachJson = json_encode($attachment);

                    $dbDATA = [
                        'doc_name' => ucfirst($request->input('title')),
                        'project_id' => $request->input('project'),
                        'docs' => $attachJson,
                        'created_by' => Utility::checkAuth('temp_user')->id,
                        'status' => Utility::STATUS_ACTIVE
                    ];
                    $requisition = ProjectDocs::create($dbDATA);


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

    public function editForm(Request $request)
    {
        //
        $projectDoc = ProjectDocs::firstRow('id',$request->input('dataId'));
        return view::make('project_docs.edit_form')->with('edit',$projectDoc);

    }

    public function edit(Request $request)
    {
        //
        $validator = Validator::make($request->all(),ProjectDocs::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'doc_name' => ucfirst($request->input('title')),
                'updated_by' => Utility::checkAuth('temp_user')->id,
            ];

            ProjectDocs::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

    public function attachmentForm(Request $request)
    {
        //
        $request = ProjectDocs::firstRow('id',$request->input('dataId'));
        return view::make('project_docs.attach_form')->with('edit',$request);

    }

    public function editAttachment(Request $request){
        $files = $request->file('attachment');
        //return $files;
        $attachment = [];
        $editId = $request->input('edit_id');
        $oldData = ProjectDocs::firstRow('id',$editId);
        $oldAttachment = json_decode($oldData->docs);

        if($files != ''){
            foreach($files as $file){
                //return$file;
                $file_name = time() . "_" . Utility::generateUID(null, 10) . "." . $file->getClientOriginalExtension();

                $file->move(
                    Utility::FILE_URL(), $file_name
                );
                //PUSH FILES TO AN ARRAY AND STORE IN JSON FORMAT IN A LONGTEXT MYSQL COLUMN
                array_push($oldAttachment,$file_name);

            }
        }

        $attachJson = json_encode($oldAttachment);
        $dbData = [
            'docs' => $attachJson
        ];
        $save = ProjectDocs::defaultUpdate('id',$editId,$dbData);

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
        $oldData = ProjectDocs::firstRow('id',$editId);
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
        $save = ProjectDocs::defaultUpdate('id',$editId,$dbData);

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

    public function destroy(Request $request)
    {
        //
        $all_id = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];


        $delete = ProjectDocs::massUpdate('id',$all_id,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => count($all_id).' data(s) has been deleted'
        ]);

    }

}
