<?php

namespace App\Http\Controllers;

use App\Helpers\Notify;
use App\model\News;
use App\model\Department;
use App\Helpers\Utility;
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

class NewsController extends Controller
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
        $mainData = News::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('news.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('news.main_view')->with('mainData',$mainData);
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
        $validator = Validator::make($request->all(),News::$mainRules);
        if($validator->passes()){

            $countData = News::countData('news_title',$request->input('news_title'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'news_title' => ucfirst($request->input('news_title')),
                    'news_desc' => $request->input('detail'),
                    'embed_video' => $request->input('embed_video'),
                    'created_by' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                News::create($dbDATA);

                    $activeUsers = User::specialColumns('active_status',Utility::STATUS_ACTIVE);
                    foreach ($activeUsers as $userData){
                        $userEmail = $userData->email;

                        $mailContent = [];

                        $messageBody = "Hello '.$userData->firstname.', a new information with title ".ucfirst($request->input('news_title'))." have been
                    created by ".Auth::user()->firstname." ".Auth::user()->lastname.", please visit the portal to read";

                        $mailContent['message'] = $messageBody;
                        $mailContent['fromEmail'] = Auth::user()->email;
                        Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
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
        $request = News::firstRow('id',$request->input('dataId'));
        return view::make('news.edit_form')->with('edit',$request);

    }

    public function fetchNews(Request $request)
    {
        //
        $request = News::firstRow('id',$request->input('dataId'));
        return view::make('news.news_item')->with('edit',$request);

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
        $validator = Validator::make($request->all(),News::$mainRules);
        if($validator->passes()) {

            $dbDATA = [
                'news_title' => ucfirst($request->input('news_title')),
                'news_desc' => $request->input('detail'),
                'embed_video' => $request->input('embed_video'),
                'updated_by' => Auth::user()->id,
            ];
            $rowData = News::specialColumns('news_title', $request->input('news_title'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    News::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

                    $activeUsers = User::specialColumns('active_status',Utility::STATUS_ACTIVE);
                    foreach ($activeUsers as $userData){
                        $userEmail = $userData->email;

                        $mailContent = [];

                        $messageBody = "Hello '.$userData->firstname.', the new/tips with title ".ucfirst($request->input('news_title'))." have been
                    modified by ".Auth::user()->firstname." ".Auth::user()->lastname.", please visit the portal to read";

                        $mailContent['message'] = $messageBody;
                        $mailContent['fromEmail'] = Auth::user()->email;
                        Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
                    }

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

                $activeUsers = User::specialColumns('active_status',Utility::STATUS_ACTIVE);
                foreach ($activeUsers as $userData){
                    $userEmail = $userData->email;

                    $mailContent = [];

                    $messageBody = "Hello '.$userData->firstname.', the news/tips with title ".ucfirst($request->input('news_title'))." have been
                    created by ".Auth::user()->firstname." ".Auth::user()->lastname.", please visit the portal to read";

                    $mailContent['message'] = $messageBody;
                    $mailContent['fromEmail'] = Auth::user()->email;
                    Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
                }

                News::defaultUpdate('id', $request->input('edit_id'), $dbDATA);

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

        $inactiveNews = [];
        $activeNews = [];

        foreach($all_id as $var){
            $newsRequest = News::firstRow('id',$var);
            if($newsRequest->created_by == Auth::user()->id){
                $inactiveNews[] = $var;
            }else{
                $activeNews[] = $var;
            }
        }

        $message = (count($inactiveNews) < 1) ? ' and '.count($activeNews).
            ' news was not created by you and cannot be deleted' : '';
        if(count($inactiveNews) > 0){


            $delete = News::massUpdate('id',$inactiveNews,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($inactiveNews).' data(s) has been deleted'.$message
            ]);

        }else{
            return  response()->json([
                'message2' => 'The '.count($activeNews).' was not created by you and cannot be deleted',
                'message' => 'warning'
            ]);

        }


    }

}
