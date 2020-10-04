@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Individual Goal
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        {{--@if($lowerHodId == Auth::user()->id && $hodId != Auth::user()->id)--}}

                        {{--@endif--}}
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'detail_id', $exportDocId = 'detail_id'])
                            </ul>
                        </li>

                    </ul>
                </div>

                <div class="body">

                    <div class="row clearfix">
                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                            <form name="import_excel" action="{{url('mark_indi_goal')}}" id="" class="form form-horizontal" method="get" enctype="multipart/form-data">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control " name="goal_set" >
                                                <option value="">Goal Set</option>
                                                @foreach($indiGoalSeries as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control " name="user" id="user_detail">
                                                <option value="">Select Head of Department (HOD)</option>
                                                @if(!empty($deptHead))
                                                    @foreach($deptHead as $ap)
                                                        <option value="{{$ap->dept_head}}">{{$ap->hod->firstname}} {{$ap->hod->lastname}}({{$ap->department->dept_name}})</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="">
                                    <div class="">
                                        <div class="" id="" >
                                            <input type="hidden" id="dept2" class="" value="0" name="department"  >

                                        </div>
                                    </div>
                                </div>

                                <button  type="submit" class="btn btn-info waves-effect">
                                    Mark HOD Appraisals
                                </button>
                            </form>
                            <hr/><hr/>
                        @endif

                        <form name="import_excel" id="searchFrameForm" class="form form-horizontal" method="GET" enctype="multipart/form-data">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select  class="form-control " name="goal_set" >
                                            <option value="">Goal Set</option>
                                            @foreach($indiGoalSeries as $ap)
                                                <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT) || ($lowerHod == \App\Helpers\Utility::HOD_DETECTOR && in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT)))
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select  class="form-control " name="department" id="dept" onchange="fillNextInput('dept','display_user','<?php echo url('default_select'); ?>','dept_users')">
                                            <option value="">Department</option>
                                            @foreach($dept as $ap)
                                                <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line" id="display_user" >
                                        <select  class="form-control" name="user"  >
                                            <option value="">Select User</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                           @endif
                            @if($lowerHod == \App\Helpers\Utility::HOD_DETECTOR && !in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control " name="department" id="dept" onchange="fillNextInput('dept','display_user','<?php echo url('default_select'); ?>','dept_users')">
                                                <option value="{{Auth::user()->dept_id}} selected">My Department</option>
                                                <option value="{{Auth::user()->dept_id}}">My Department</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line" id="display_user" >
                                            <select  class="form-control" name="user"  >
                                                <option value="">Select User</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(!in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT) && $lowerHod != \App\Helpers\Utility::HOD_DETECTOR)
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control " name="department" id="dept">
                                                <option value="">Department</option>
                                                @foreach($dept as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line" >
                                            <select  class="form-control" name="user"  >
                                                <option value="{{Auth::user()->id}}">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-info waves-effect">
                                Search Employee
                            </button>
                        </form>
                    </div>

                </div>

                @if($indiGoal->count() > 0)
                <div class="body table-responsive" id="reload_data">

                <!-- BEGIN OF TAB WIZARD -->

                <div class="row">
                    @if(!empty($userDetail))
                        <span class="text-center" style="font-size:25px;"> {{$userDetail->firstname}} {{$userDetail->lastname}}</span>
                        <hr/>
                    @endif

                </div>

                <div class="row">
                    <section >
                        <div class="wizard">
                            <div class="wizard-inner">
                                <div class="connecting-line"></div>
                                <ul class="nav nav-tabs" role="tablist">

                                    <li role="presentation" class="active">
                                        <a href="#step{{\App\Helpers\Utility::APP_OBJ_GOAL}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::APP_OBJ_GOAL}}" role="tab" title="Appraisal Objectives and Goals">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-pencil">Appraisal Objectives and Goals</i>
                        </span>
                                        </a>
                                    </li>

                                    <li role="presentation" class="">
                                        <a href="#step{{\App\Helpers\Utility::COMP_ASSESS}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::COMP_ASSESS}}" role="tab" title="Competency Assessment">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-pencil">Competency Assessment</i>
                        </span>
                                        </a>
                                    </li>
                                    <li role="presentation" class="">
                                        <a href="#step{{\App\Helpers\Utility::BEHAV_COMP2}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::BEHAV_COMP2}}" role="tab" title="Behavioural Competency">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-pencil">Behavioural Competency</i>
                        </span>
                                        </a>
                                    </li>

                                    <li role="presentation" class="">
                                        <a href="#step{{\App\Helpers\Utility::INDI_REV_COMMENT}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::INDI_REV_COMMENT}}" role="tab" title="Individual/Reviewers Comment">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-pencil">Individual/Reviewers Comment</i>
                        </span>
                                        </a>
                                    </li>

                                    <li role="presentation" class="">
                                        <a href="#step{{\App\Helpers\Utility::EMP_COM_APP_PLAT}}" data-toggle="tab" aria-controls="step{{\App\Helpers\Utility::EMP_COM_APP_PLAT}}" role="tab" title="Employee Comment of Appraisal Platform">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-pencil">Employee Comment of Appraisal</i>
                        </span>
                                        </a>
                                    </li>

                                    <li role="presentation" class="disabled">
                                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                        <span class="round-tab">
                            <i class="glyphicon glyphicon-ok">Complete</i>
                        </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                                <?php $arr1 = []; $arr2 = []; $arr3 = []; $arr4 = []; $arr5 = [];  ?>
                                <div class="tab-content" id="main_table" >
                                    <div class="tab-pane active" role="tabpanel" id="step{{\App\Helpers\Utility::APP_OBJ_GOAL}}">
                                        @foreach($indiGoal as $edit)
                                        @if($edit->indi_goal_cat == \App\Helpers\Utility::APP_OBJ_GOAL)
                                                <?php $arr1[] = 1; ?>
                                            <form name="" id="editMainForm{{$edit->id}}" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                                                <div class="body" >
                                                    <div class="row clearfix">

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" disabled value="{{$edit->department->dept_name}}" name="wps" placeholder="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select  class="form-control" name="goal_set" >
                                                                        @foreach($indiGoalSeries as $ap)
                                                                            @if($edit->goal_set_id == $ap->id)
                                                                                <option value="{{$ap->id}}" selected>{{$ap->goal_name}}</option>
                                                                            @else
                                                                                <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div><hr>

                                                    {{--<div class="row clearfix">--}}
                                                    <table class="table table-responsive">
                                                        <thead>
                                                        <th></th>
                                                        <th>Objectives</th>
                                                        <th>Individual Ratings</th>
                                                        <th>Reviewer Ratings</th>
                                                        <th>...</th>
                                                        <th>...</th>
                                                        </thead>
                                                        <tbody id="add_more_edit">

                                                        <?php $num = 0; $countData = []; ?>
                                                        @foreach($edit->indiObj as $data)
                                                            <?php $num++  ?>
                                                            <?php $countData[] = $num;  ?>
                                                            <tr>
                                                                <td></td>

                                                                @if(Auth::user()->id == $edit->user_id)
                                                                    <td>
                                                                        <div class="col-md-10">
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                    <textarea rows="6" cols="40" class=" " name="obj_edit{{$num}}" placeholder="Objectives">{{$data->objectives}}
                                    </textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td>
                                                                        <div class="">
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <select  class="form-control " name="obj_level_edit{{$num}}" >
                                                                                        @foreach(APP\Helpers\Utility::REVIEW_RATE as $key => $val)
                                                                                            @if($val == $data->obj_level)
                                                                                                <option value="{{$val}}" selected>{{$val}}</option>
                                                                                            @else
                                                                                                <option value="{{$val}}">{{$val}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td>
                                                                        <div class="">
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <select  class="form-control " disabled name="rev_rate_edit{{$num}}" >
                                                                                        @foreach(APP\Helpers\Utility::REVIEW_RATE as $key => $val)
                                                                                            @if($key == $data->reviewer_rating)
                                                                                                <option value="{{$key}}" selected>{{$val}}</option>
                                                                                            @else
                                                                                                <option value="{{$key}}">{{$val}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                @endif

                                                                @if(Auth::user()->id != $edit->user_id)
                                                                    <td>
                                                                        <div class="col-md-10">
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                    <textarea rows="6" cols="40" class=" " disabled name="obj_edit{{$num}}" placeholder="Objectives">{{$data->objectives}}
                                    </textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td>
                                                                        <div class="">
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <select  class="form-control " disabled name="obj_level_edit{{$num}}" >
                                                                                        <option value="" selected>Level</option>
                                                                                        @foreach(APP\Helpers\Utility::REVIEW_RATE as $key => $val)
                                                                                            @if($val == $data->obj_level)
                                                                                                <option value="{{$val}}" selected>{{$val}}</option>
                                                                                            @else
                                                                                                <option value="{{$val}}">{{$val}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td>
                                                                        <div class="">
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <select  class="form-control " name="rev_rate_edit{{$num}}" >
                                                                                        @foreach(APP\Helpers\Utility::REVIEW_RATE as $key => $val)
                                                                                            @if($key == $data->reviewer_rating)
                                                                                                <option value="{{$key}}" selected>{{$val}}</option>
                                                                                            @else
                                                                                                <option value="{{$key}}">{{$val}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                @endif

                                                                <input type="hidden"  value="{{$data->id}}" name="ext_id{{$num}}">
                                                            </tr>
                                                        @endforeach

                                                        <tr>
                                                            <td>
                                                                @if(Auth::user()->id == $edit->user_id)
                                                                    <div class="col-sm-4" id="hide_button_edit">
                                                                        <div class="form-group">
                                                                            <div onclick="addMore('add_more_edit','hide_button_edit','1','<?php echo URL::to('add_more'); ?>','app_obj_goal','hide_button_edit');">
                                                                                <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                            </td>
                                                            <td></td><td></td>
                                                        </tr>

                                                        </tbody>
                                                    </table>

                                                    <div class="row clearfix">

                                                        @if(Auth::user()->id == $edit->user_id)
                                                            <div class="col-sm-4">
                                                                Individual comments on achievement of objectives
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <textarea rows="6" cols="50" class="" name="individual" placeholder="Individual comments on achievement of objectives">{{$edit->indi_comment}}</textarea>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                Reviewer comments on achievement of objectives
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <textarea rows="6" cols="50" class="" disabled name="reviewer" placeholder="Reviewer comments on achievement of objectives">{{$edit->reviewer_comment}}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if(Auth::user()->id != $edit->user_id)
                                                            <div class="col-sm-4">
                                                                Individual comments on achievement of objectives
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <textarea rows="6" cols="50" class="" disabled name="individual" placeholder="Individual comments on achievement of objectives">{{$edit->indi_comment}}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                Reviewer comments on achievement of objectives
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <textarea rows="6" cols="50" class="" name="reviewer" placeholder="Reviewer comments on achievement of objectives">{{$edit->reviewer_comment}}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </div>

                                                </div>

                                                <input type="hidden" name="count_ext" value="<?php echo count($countData) ?>" >
                                                <input type="hidden" name="edit_user_id" value="{{$edit->user_id}}" >
                                                <input type="hidden" name="indi_goal_cat" value="{{$edit->indi_goal_cat}}" >
                                                <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
                                                <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                                            </form>

                                            <ul class="list-inline pull-right">
                                                <li><button type="button" onclick="save1('editModal','editMainForm{{$edit->id}}','<?php echo url('edit_indi_goal'); ?>','reload_data',
                                                            '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>','obj_edit','rev_rate_edit','obj_level_edit')" class="btn btn-primary next-step">Save and continue</button></li>
                                            </ul>
                                    @endif
                                    <hr/>
                                    @endforeach

                                            @if(count($arr1) < 1)
                                                <ul class="list-inline pull-right">
                                                    <li><button type="button" class="btn btn-default prev-step" >Previous</button></li>
                                                    <li><button type="button" class="btn btn-default next-step" >Skip</button></li>
                                                    <li><button type="button" class="btn btn-primary btn-info-full next-step" >Save and continue</button></li>

                                                </ul>
                                            @endif
                                    <!--END OF INDIVIDUAL OBJECTIVES-->

                                    </div>

                                    <div class="tab-pane" role="tabpanel" style="width:1000px; overflow-x:scroll;" id="step{{\App\Helpers\Utility::COMP_ASSESS}}">

                                        @foreach($indiGoal as $edit)
                                        @if($edit->indi_goal_cat == \App\Helpers\Utility::COMP_ASSESS)
                                                <?php $arr2[] = 2; ?>
                                            <form name="" id="editMainForm{{$edit->id}}" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                                                <div class="body">
                                                    <div class="row clearfix">

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" disabled value="{{$edit->department->dept_name}}" name="wps" placeholder="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select  class="form-control" name="goal_set" >
                                                                        @foreach($indiGoalSeries as $ap)
                                                                            @if($edit->goal_set_id == $ap->id)
                                                                                <option value="{{$ap->id}}" selected>{{$ap->goal_name}}</option>
                                                                            @else
                                                                                <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div><hr>

                                                    {{--<div class="row clearfix">--}}
                                                    <table class="table table-responsive">
                                                        <thead>
                                                        <th></th>
                                                        <th>Core Competencies</th>
                                                        <th>Capabilities</th>
                                                        <th>Individual Rating</th>
                                                        <th>Reviewer Ratings</th>
                                                        <th>...</th>
                                                        <th>...</th>
                                                        </thead>
                                                        <tbody id="add_more_edit">

                                                        <?php $num = 0; $countData = []; ?>
                                                        @foreach($edit->compAssess as $data)
                                                            <?php $num++  ?>
                                                            <?php $countData[] = $num;  ?>
                                                            <tr>
                                                                <td></td>

                                                                @if(Auth::user()->id == $edit->user_id)
                                                                    <td>
                                                                        <div class="col-md-10">
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <select class=" " name="core_comp_edit{{$num}}" id="core_comp_edit" onchange="fillNextInput('core_comp_edit','capable_edit','<?php echo url('default_select'); ?>','core_tech_comp')" >
                                                                                        <option value="">Core Technical Competency</option>
                                                                                        @foreach($techComp as $ap)
                                                                                            @if($data->core_comp == $ap->id)
                                                                                                <option value="{{$ap->id}}" selected>{{$ap->category_name}}</option>
                                                                                            @else
                                                                                                <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>


                                                                    <td>
                                                                        <div class="col-md-10">
                                                                            <div class="form-group">
                                                                                <div class="form-line " id="capable_edit" >
                                                                                    <select  class="form-control" name="capable_edit{{$num}}"  >
                                                                                        <option value="{{$data->capability}}" selected>{{$data->capability}}</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td>
                                                                        <div class="">
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <select  class="form-control " name="comp_level_edit{{$num}}" >
                                                                                        @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                                                                            @if($data->level == $val)
                                                                                                <option value="{{$val}}" selected>{{$val}}</option>
                                                                                            @else
                                                                                                <option value="{{$val}}">{{$val}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td>
                                                                        <div class="">
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <select  class="form-control " disabled name="rev_rate_edit{{$num}}" >
                                                                                        @foreach(APP\Helpers\Utility::REVIEW_COMP as $key => $val)
                                                                                            @if($data->reviewer_rating == $key)
                                                                                                <option value="{{$key}}" selected>{{$val}}</option>
                                                                                            @else
                                                                                                <option value="{{$key}}">{{$val}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                @endif

                                                                @if(Auth::user()->id != $edit->user_id)
                                                                    <td>
                                                                        <div class="col-md-10">
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <select class=" " name="core_comp_edit{{$num}}" disabled id="core_comp_edit" onchange="fillNextInput('core_comp_edit','capable_edit','<?php echo url('default_select'); ?>','core_tech_comp')" >
                                                                                        <option value="">Core Technical Competency</option>
                                                                                        @foreach($techComp as $ap)
                                                                                            @if($data->core_comp == $ap->id)
                                                                                                <option value="{{$ap->id}}" selected>{{$ap->category_name}}</option>
                                                                                            @else
                                                                                                <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>


                                                                    <td>
                                                                        <div class="col-md-10">
                                                                            <div class="form-group">
                                                                                <div class="form-line " id="capable_edit" disabled="" >
                                                                                    <select  class="form-control" name="capable_edit{{$num}}"  >
                                                                                        <option value="{{$data->capability}}" selected>{{$data->capability}}</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td>
                                                                        <div class="">
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <select  class="form-control " disabled name="comp_level_edit{{$num}}" >
                                                                                        @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                                                                            @if($data->level == $val)
                                                                                                <option value="{{$val}}" selected>{{$val}}</option>
                                                                                            @else
                                                                                                <option value="{{$val}}">{{$val}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td>
                                                                        <div class="">
                                                                            <div class="form-group">
                                                                                <div class="form-line">
                                                                                    <select  class="form-control " name="rev_rate_edit{{$num}}" >
                                                                                        @foreach(APP\Helpers\Utility::REVIEW_COMP as $key => $val)
                                                                                            @if($data->reviewer_rating == $key)
                                                                                                <option value="{{$key}}" selected>{{$val}}</option>
                                                                                            @else
                                                                                                <option value="{{$key}}">{{$val}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                @endif


                                                                <input type="hidden"  value="{{$data->id}}" name="ext_id{{$num}}">
                                                            </tr>
                                                        @endforeach

                                                        <tr>
                                                            <td>
                                                                @if(Auth::user()->id ==$edit->user_id)
                                                                    <div class="col-sm-4" id="hide_button_edit">
                                                                        <div class="form-group">
                                                                            <div onclick="addMore('add_more_edit','hide_button_edit','1','<?php echo URL::to('add_more'); ?>','comp_assess','hide_button_edit');">
                                                                                <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                            </td>
                                                            <td></td><td></td>
                                                        </tr>

                                                        </tbody>
                                                    </table>

                                                    <div class="row clearfix">

                                                        @if(Auth::user()->id == $edit->user_id)
                                                            <div class="col-sm-4">
                                                                Individual comments on achievement of objectives
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <textarea rows="6" cols="50" class="" name="individual" placeholder="Individual comments on achievement of objectives">{{$edit->indi_comment}}</textarea>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                Reviewer comments on achievement of objectives
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <textarea rows="6" cols="50" class="" disabled name="reviewer" placeholder="Reviewer comments on achievement of objectives">{{$edit->reviewer_comment}}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if(Auth::user()->id != $edit->user_id)
                                                            <div class="col-sm-4">
                                                                Individual comments on achievement of objectives
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <textarea rows="6" cols="50" class="" disabled name="individual" placeholder="Individual comments on achievement of objectives">{{$edit->indi_comment}}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                Reviewer comments on achievement of objectives
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <textarea rows="6" cols="50" class="" name="reviewer" placeholder="Reviewer comments on achievement of objectives">{{$edit->reviewer_comment}}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </div>

                                                </div>

                                                <input type="hidden" name="count_ext" value="<?php echo count($countData) ?>" >
                                                <input type="hidden" name="edit_user_id" value="{{$edit->user_id}}" >
                                                <input type="hidden" name="indi_goal_cat" value="{{$edit->indi_goal_cat}}" >
                                                <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
                                                <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                                            </form>

                                            <ul class="list-inline pull-left">
                                                <li><button type="button" class="btn btn-default prev-step" onclick="save2('editModal','editMainForm{{$edit->id}}','<?php echo url('edit_indi_goal'); ?>','reload_data',
                                                            '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>','core_comp_edit','capable_edit','comp_level_edit','comp_rev_rate_edit')">Previous</button></li>
                                            </ul>

                                            <ul class="list-inline pull-right">

                                                <li><button type="button" class="btn btn-primary next-step" onclick="save2('editModal','editMainForm{{$edit->id}}','<?php echo url('edit_indi_goal'); ?>','reload_data',
                                                            '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>','core_comp_edit','capable_edit','comp_level_edit','comp_rev_rate_edit')">Save and continue</button></li>
                                            </ul>
                                        @endif
                                        <hr/>
                                        @endforeach

                                            @if(count($arr2) < 1)
                                                <ul class="list-inline pull-left">
                                                    <li><button type="button" class="btn btn-default prev-step" >Previous</button></li>

                                                </ul>

                                                <ul class="list-inline pull-right">

                                                    <li><button type="button" class="btn btn-primary btn-info-full next-step" >Save and continue</button></li>

                                                </ul>
                                            @endif

                                    </div>

                                    <div class="tab-pane" style="width:1000px; overflow-x:scroll;" role="tabpanel" id="step{{\App\Helpers\Utility::BEHAV_COMP2}}">
                                        @foreach($indiGoal as $edit)

                                            @if($edit->indi_goal_cat == \App\Helpers\Utility::BEHAV_COMP2)
                                                <?php $arr3[] = 3; ?>
                                                <form name="" id="editMainForm{{$edit->id}}" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                                                    <div class="body" >
                                                        <div class="row clearfix">

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" disabled value="{{$edit->department->dept_name}}" name="wps" placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <select  class="form-control" name="goal_set" >
                                                                            @foreach($indiGoalSeries as $ap)
                                                                                @if($edit->goal_set_id == $ap->id)
                                                                                    <option value="{{$ap->id}}" selected>{{$ap->goal_name}}</option>
                                                                                @else
                                                                                    <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div><hr>

                                                        {{--<div class="row clearfix">--}}
                                                        <table class="table table-responsive">
                                                            <thead>
                                                            <th></th>
                                                            <th>Core Behavioural Competency</th>
                                                            <th>Elements of Behavioural Competency</th>
                                                            <th>Individual Reviewer</th>
                                                            <th>Reviewer Ratings</th>
                                                            <th>...</th>
                                                            <th>...</th>
                                                            </thead>
                                                            <tbody id="add_more_edit">

                                                            <?php $num = 0; $countData = []; ?>
                                                            @foreach($edit->behavCompetency as $data)
                                                                <?php $num++  ?>
                                                                <?php $countData[] = $num;  ?>
                                                                <tr>
                                                                    <td></td>

                                                                    @if(Auth::user()->id == $edit->user_id)
                                                                        <td>
                                                                            <div class="">
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <select  class="form-control" name="core_behav_comp_edit{{$num}}" id="core_behave_comp_edit" onchange="fillNextInput('core_behav_comp_edit','element_edit','<?php echo url('default_select'); ?>','core_behav_comp')" >

                                                                                            @foreach($behavComp as $ap)
                                                                                                @if($data->core_behav_comp == $ap->id)
                                                                                                    <option value="{{$ap->id}}" selected>{{$ap->category_name}}</option>
                                                                                                @else
                                                                                                    <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="col-md-10">
                                                                                <div class="form-group">
                                                                                    <div class="form-line" id="element_edit" >
                                                                                        <select  class="form-control" name="element_edit{{$num}}"  >
                                                                                            <option value="{{$data->element_behav_comp}}" selected>{{$data->element_behav_comp}}</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="">
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <select  class="form-control" name="behav_level_edit{{$num}}" >
                                                                                            @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                                                                                @if($data->level == $val)
                                                                                                    <option value="{{$val}}" selected>{{$val}}</option>
                                                                                                @else
                                                                                                    <option value="{{$val}}">{{$val}}</option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="">
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <select  class="form-control" disabled name="behav_rev_rate_edit{{$num}}" >
                                                                                            @foreach(APP\Helpers\Utility::REVIEW_RATE2 as $key => $val)
                                                                                                @if($data->reviewer_rating == $val)
                                                                                                    <option value="{{$val}}" selected>{{$val}}</option>
                                                                                                @else
                                                                                                    <option value="{{$val}}">{{$val}}</option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @endif

                                                                    @if(Auth::user()->id != $edit->user_id)
                                                                        <td>
                                                                            <div class="">
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <select  class="form-control " disabled name="core_behav_comp_edit{{$num}}" id="core_behav_comp_edit" >

                                                                                            @foreach($behavComp as $ap)
                                                                                                @if($data->core_behav_comp == $ap->id)
                                                                                                    <option value="{{$ap->id}}" selected>{{$ap->category_name}}</option>
                                                                                                @else
                                                                                                    <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="col-md-10">
                                                                                <div class="form-group">
                                                                                    <div class="form-line" id="element_edit" disabled>
                                                                                        <select  class="form-control" name="element_edit{{$num}}"  >
                                                                                            <option value="{{$data->element_behav_comp}}" selected>{{$data->element_behav_comp}}</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="">
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <select  class="form-control" disabled name="behav_level_edit{{$num}}" >
                                                                                            @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                                                                                @if($data->level == $val)
                                                                                                    <option value="{{$val}}" selected>{{$val}}</option>
                                                                                                @else
                                                                                                    <option value="{{$val}}">{{$val}}</option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>

                                                                        <td>
                                                                            <div class="">
                                                                                <div class="form-group">
                                                                                    <div class="form-line">
                                                                                        <select  class="form-control" name="behav_rev_rate_edit{{$num}}" >
                                                                                            @foreach(APP\Helpers\Utility::REVIEW_RATE2 as $key => $val)
                                                                                                @if($data->reviewer_rating == $val)
                                                                                                    <option value="{{$val}}" selected>{{$val}}</option>
                                                                                                @else
                                                                                                    <option value="{{$val}}">{{$val}}</option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    @endif

                                                                    <input type="hidden"  value="{{$data->id}}" name="ext_id{{$num}}">
                                                                </tr>
                                                            @endforeach

                                                            <tr>
                                                                <td>
                                                                    @if(Auth::user()->id == $edit->user_id)
                                                                        <div class="col-sm-4" id="hide_button_edit">
                                                                            <div class="form-group">
                                                                                <div onclick="addMore('add_more_edit','hide_button_edit','1','<?php echo URL::to('add_more'); ?>','behav_comp2','hide_button_edit');">
                                                                                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                </td>
                                                                <td></td><td></td>
                                                            </tr>

                                                            </tbody>
                                                        </table>

                                                        <div class="row clearfix">

                                                            @if(Auth::user()->id == $edit->user_id)
                                                                <div class="col-sm-4">
                                                                    Individual comments on achievement of objectives
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <textarea rows="6" cols="50" class="" name="individual" placeholder="Individual comments on achievement of objectives">{{$edit->indi_comment}}</textarea>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    Reviewer comments on achievement of objectives
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <textarea rows="6" cols="50" class="" disabled name="reviewer" placeholder="Reviewer comments on achievement of objectives">{{$edit->reviewer_comment}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if(Auth::user()->id != $edit->user_id)
                                                                <div class="col-sm-4">
                                                                    Individual comments on achievement of objectives
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <textarea rows="6" cols="50" class="" disabled name="individual" placeholder="Individual comments on achievement of objectives">{{$edit->indi_comment}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    Reviewer comments on achievement of objectives
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <textarea rows="6" cols="50" class="" name="reviewer" placeholder="Reviewer comments on achievement of objectives">{{$edit->reviewer_comment}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        </div>

                                                    </div>

                                                    <input type="hidden" name="count_ext" value="<?php echo count($countData) ?>" >
                                                    <input type="hidden" name="edit_user_id" value="{{$edit->user_id}}" >
                                                    <input type="hidden" name="indi_goal_cat" value="{{$edit->indi_goal_cat}}" >
                                                    <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
                                                    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                                                </form>

                                                <ul class="list-inline pull-left">
                                                    <li><button type="button" class="btn btn-default prev-step" onclick="save3('editModal','editMainForm{{$edit->id}}','<?php echo url('edit_indi_goal'); ?>','reload_data',
                                                                '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>','core_behav_comp_edit','element_edit','behav_level_edit','behav_rev_rate_edit')">Previous</button></li>

                                                </ul>

                                                <ul class="list-inline pull-right">

                                                    <li><button type="button" class="btn btn-primary btn-info-full next-step" onclick="save3('editModal','editMainForm{{$edit->id}}','<?php echo url('edit_indi_goal'); ?>','reload_data',
                                                                '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>','core_behav_comp_edit','element_edit','behav_level_edit','behav_rev_rate_edit')">Save and continue</button></li>

                                                </ul>
                                            @endif
                                            <hr/>
                                        <!-- END OF BEHAVIOURAL ASSESSMENT -->

                                        @endforeach

                                        @if(count($arr3) < 1)
                                                <ul class="list-inline pull-left">
                                                    <li><button type="button" class="btn btn-default prev-step" >Previous</button></li>

                                                </ul>

                                                <ul class="list-inline pull-right">

                                                    <li><button type="button" class="btn btn-primary btn-info-full next-step" >Save and continue</button></li>

                                                </ul>
                                        @endif

                                    </div>

                                    <div class="tab-pane" role="tabpanel" id="step{{\App\Helpers\Utility::INDI_REV_COMMENT}}">
                                        @foreach($indiGoal as $edit)

                                            <!-- START  -->
                                                @if($edit->indi_goal_cat == \App\Helpers\Utility::INDI_REV_COMMENT)
                                                    <?php $arr4[] = 4; ?>
                                                    <form name="" id="editMainForm{{$edit->id}}" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                                                        <div class="body">
                                                            <div class="row clearfix">

                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <input type="text" class="form-control" disabled value="{{$edit->department->dept_name}}" name="wps" placeholder="">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <select  class="form-control" name="goal_set" >
                                                                                @foreach($indiGoalSeries as $ap)
                                                                                    @if($edit->goal_set_id == $ap->id)
                                                                                        <option value="{{$ap->id}}" selected>{{$ap->goal_name}}</option>
                                                                                    @else
                                                                                        <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div><hr>

                                                            {{--<div class="row clearfix">--}}
                                                            <div class="row clearfix">

                                                                @if(Auth::user()->id == $edit->user_id)
                                                                    <div class="col-sm-4">
                                                                        Overview Strength
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <textarea rows="6" disabled cols="40" class=""  name="overview_str" placeholder="Overview and strengths">{{$edit->overview_str}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        Areas of Improvement
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <textarea rows="6" cols="40" disabled class=""  name="area_improv" placeholder="Areas of Improvement">{{$edit->area_improv}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        Suggestions for personal and professional development
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <textarea rows="6" disabled cols="40" class=""  name="sug_pp_dev" placeholder="Suggestions for personal and professional development">{{$edit->sug_pp_dev}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if(Auth::user()->id != $edit->user_id)
                                                                    <div class="col-sm-4">
                                                                        Overview Strength
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <textarea rows="6"  cols="40" class=""  name="overview_str" placeholder="Overview and strengths">{{$edit->overview_str}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        Areas of Improvement
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <textarea rows="6" cols="40"  class=""  name="area_improv" placeholder="Areas of Improvement">{{$edit->area_improv}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        Suggestions for personal and professional development
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <textarea rows="6" cols="40" class=""  name="sug_pp_dev" placeholder="Suggestions for personal and professional development">{{$edit->sug_pp_dev}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                            </div>

                                                            <div class="row clearfix">
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <div class="form-line">

                                                                            @if(Auth::user()->id == $edit->user_id)
                                                                                <select disabled class="form-control" name="over_rate" >
                                                                                    <option value="" selected>Overall Ratings</option>
                                                                                    @foreach(APP\Helpers\Utility::OVERALL_RATING as $key => $val)
                                                                                        @if($edit->final_review == $key)
                                                                                            <option value="{{$key}}" selected>{{$val}}</option>
                                                                                        @else
                                                                                            <option value="{{$key}}">{{$val}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            @endif
                                                                            @if(Auth::user()->id != $edit->user_id)
                                                                                <select  class="form-control" name="over_rate" >
                                                                                    <option value="" selected>Overall Ratings</option>
                                                                                    @foreach(APP\Helpers\Utility::OVERALL_RATING as $key => $val)
                                                                                        @if($edit->final_review == $key)
                                                                                            <option value="{{$key}}" selected>{{$val}}</option>
                                                                                        @else
                                                                                            <option value="{{$key}}">{{$val}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>



                                                        <input type="hidden" name="indi_goal_cat" value="{{$edit->indi_goal_cat}}" >
                                                        <input type="hidden" name="edit_user_id" value="{{$edit->user_id}}" >
                                                        <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
                                                        <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                                                    </form>


                                                    <ul class="list-inline pull-left">
                                                        <li><button type="button" class="btn btn-default prev-step" onclick="submitDefaultApp('editModal','editMainForm{{$edit->id}}','<?php echo url('edit_indi_goal'); ?>','reload_data',
                                                                    '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>')">Previous</button></li>

                                                    </ul>
                                                    <ul class="list-inline pull-right">

                                                        <li><button type="button" class="btn btn-primary btn-info-full next-step" onclick="submitDefaultApp('editModal','editMainForm{{$edit->id}}','<?php echo url('edit_indi_goal'); ?>','reload_data',
                                                                    '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>')">Save and continue</button></li>
                                                    </ul>
                                                @endif
                                                <hr/>
                                            <!--END OF INDIVIDUAL/REVIEWER COMMENTS-->
                                            <!--  END  -->

                                        @endforeach

                                            @if(count($arr4) < 1)
                                                <ul class="list-inline pull-left">
                                                    <li><button type="button" class="btn btn-default prev-step" >Previous</button></li>

                                                </ul>

                                                <ul class="list-inline pull-right">

                                                    <li><button type="button" class="btn btn-primary btn-info-full next-step" >Save and continue</button></li>

                                                </ul>
                                            @endif

                                    </div>

                                    <div class="tab-pane" role="tabpanel"  id="step{{\App\Helpers\Utility::EMP_COM_APP_PLAT}}">
                                        @foreach($indiGoal as $edit)
                                            @if($edit->indi_goal_cat == \App\Helpers\Utility::EMP_COM_APP_PLAT)
                                                <?php $arr5[] = 5; ?>
                                                <form name="" id="editMainForm{{$edit->id}}" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                                                    <div class="body">
                                                        <div class="row clearfix">

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control" disabled value="{{$edit->department->dept_name}}" name="wps" placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <select  class="form-control" name="goal_set" >
                                                                            @foreach($indiGoalSeries as $ap)
                                                                                @if($edit->goal_set_id == $ap->id)
                                                                                    <option value="{{$ap->id}}" selected>{{$ap->goal_name}}</option>
                                                                                @else
                                                                                    <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div><hr>

                                                        {{--<div class="row clearfix">--}}
                                                        <div class="row clearfix">

                                                            @if(Auth::user()->id == $edit->user_id)
                                                                <div class="col-sm-4">
                                                                    Employee comment of Appraisal Outcome{{$lowerHodId}}
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <textarea rows="6" cols="40" class=""  name="emp_comment" placeholder="Employee comment of Appraisal Outcome">{{$edit->emp_comment}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                @if($edit->emp_sign == '')
                                                                    <div class="col-sm-4">
                                                                        Employee sign off
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <select  class="form-control" name="emp_sign" >
                                                                                    @foreach(App\Helpers\Utility::SIGN_OFF as $key => $val)
                                                                                        @if($key == 1)
                                                                                            <option value="" selected>{{$val}}</option>
                                                                                        @else
                                                                                            <option value="{{$val}}">{{$val}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <strong>Employee Sign Off</strong>&nbsp;-><strong>{{$edit->indi_user->firstname}} &nbsp;{{$edit->indi_user->lastname}}</strong>&nbsp;&nbsp;
                                                                    {{$edit->emp_sign}}&nbsp;
                                                                    <input type="hidden" value="{{$edit->emp_sign}}" name="emp_sign" >
                                                                @endif

                                                                @if($edit->rev_sign == '')
                                                                    <div class="col-sm-4">
                                                                        Reviewer sign off
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <select  class="form-control" name="rev_sign"  >
                                                                                    @foreach(App\Helpers\Utility::SIGN_OFF as $key => $val)
                                                                                        @if($key == 1)
                                                                                            <option value="" selected>{{$val}}</option>
                                                                                        @else
                                                                                            <option value="{{$key}}">{{$val}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <strong>Reviewer Sign Off</strong> &nbsp;{{$edit->sup_id->firstname}} &nbsp;{{$edit->sup_id->lastname}}
                                                                    {{$edit->rev_sign}}
                                                                    <input type="hidden" value="{{$edit->rev_sign}}" name="rev_sign" >
                                                                @endif

                                                            @endif

                                                            @if(Auth::user()->id != $edit->user_id)
                                                                <div class="col-sm-4">
                                                                    Employee comment of Appraisal Outcome{{$lowerHodId}}
                                                                    <div class="form-group">
                                                                        <div class="form-line">
                                                                            <textarea rows="6" cols="50" class="" disabled name="emp_comment" placeholder="Employee comment of Appraisal Outcome">{{$edit->emp_comment}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                @if($edit->emp_sign == '')
                                                                    <div class="col-sm-4">
                                                                        Employee sign off
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <select  class="form-control" name="emp_sign" disabled >
                                                                                    @foreach(App\Helpers\Utility::SIGN_OFF as $key => $val)
                                                                                        @if($key == 1)
                                                                                            <option value="" selected>{{$val}}</option>
                                                                                        @else
                                                                                            <option value="{{$key}}">{{$val}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <strong>Employee Sign Off</strong>&nbsp;{{$edit->indi_user->firstname}} &nbsp;{{$edit->indi_user->lastname}}&nbsp;&nbsp;
                                                                    {{$edit->emp_sign}}&nbsp;
                                                                    <input type="hidden" value="{{$edit->emp_sign}}" name="emp_sign" >
                                                                @endif

                                                                @if($edit->rev_sign == '')
                                                                    <div class="col-sm-4">
                                                                        Reviewer sign off
                                                                        <div class="form-group">
                                                                            <div class="form-line">
                                                                                <select  class="form-control" name="rev_sign" >
                                                                                    @foreach(App\Helpers\Utility::SIGN_OFF as $key => $val)
                                                                                        @if($key == 1)
                                                                                            <option value="" selected>{{$val}}</option>
                                                                                        @else
                                                                                            <option value="{{$key}}">{{$val}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <strong>Reviewer Sign Off</strong> &nbsp;{{$edit->sup_id->firstname}} &nbsp;{{$edit->sup_id->lastname}}
                                                                    {{$edit->rev_sign}}
                                                                    <input type="hidden" value="{{$edit->rev_sign}}" name="rev_sign" >
                                                                @endif

                                                            @endif

                                                        </div>

                                                    </div>


                                    <input type="hidden" name="indi_goal_cat" value="{{$edit->indi_goal_cat}}" >
                                    <input type="hidden" name="edit_user_id" value="{{$edit->user_id}}" >
                                    <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
                                    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                                    </form>

                                    <ul class="list-inline pull-left">
                                        <li><button type="button" class="btn btn-default prev-step" onclick="submitDefaultApp('editModal','editMainForm{{$edit->id}}','<?php echo url('edit_indi_goal'); ?>','reload_data',
                                                    '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>')">Previous</button></li>
                                    </ul>
                                    <ul class="list-inline pull-right">

                                        <li><button type="button" class="btn btn-primary btn-info-full next-step" onclick="submitDefaultApp('editModal','editMainForm{{$edit->id}}','<?php echo url('edit_indi_goal'); ?>','reload_data',
                                                    '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>')">Save and continue</button></li>
                                    </ul>
                                @endif
                                <!--END OF INDIVIDUAL/REVIEWER COMMENTS-->
                                        @endforeach

                                            @if(count($arr5) < 1)
                                                <ul class="list-inline pull-left">
                                                    <li><button type="button" class="btn btn-default prev-step" >Previous</button></li>

                                                </ul>
                                                <ul class="list-inline pull-right">
                                                    <li><button type="button" class="btn btn-primary btn-info-full next-step" >Save and continue</button></li>

                                                </ul>
                                            @endif

                                    </div>

                                    <div class="tab-pane" role="tabpanel" id="complete">
                                        <h3>Complete</h3>
                                        <p>You have successfully completed all steps.</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                        </div>
                    </section>
                </div>

                <!-- END OF TAB WIZARD -->

                </div>
                @else
                <span class="text-center" style="font-size:20px;">No match found, please search again</span>
                @endif

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    function save1(formModal,formId,submitUrl,reload_id,reloadUrl,token,obj,review,level) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var obj1 = classToArray2(obj);
        var level1 = classToArray2(level);
        var review1 = classToArray2(review);

        var jobj = sanitizeData(obj);
        var jlevel = sanitizeData(level);
        var jreview = sanitizeData(review);
        //alert(jcompName);

        if(arrayItemEmpty(obj1) == false && arrayItemEmpty(review1) == false){
        var postVars = inputVars + '&editor_input=' + summerNote+'&obj='+jobj+'&review='+jreview+'&level='+jlevel;
        //alert(postVars);
            //$('#loading_modal').modal('show');
        //$('#' + formModal).modal('hide');
        sendRequestForm(submitUrl, token, postVars)
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4 && ajax.status == 200) {

                //$('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if (message2 == 'fail') {

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error", messageError, "error");

                } else if (message2 == 'saved') {

                    var successMessage = swalSuccess('Data saved successfully');
                    //swal("Success!", "Data saved successfully!", "success");
                    //location.reload();
                   /* clearClassInputs('obj_edit,obj_level_edit,');
                    hideAddedInputs2('new_app_obj_goal','add_more_obj','hide_button_obj','<?php echo URL::to('add_more'); ?>','app_obj_goal');
*/
                } else {

                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                //reloadContent(reload_id, reloadUrl);
            }
        }
        //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

    function save2(formModal,formId,submitUrl,reload_id,reloadUrl,token,core_comp,capable,level,review) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var core_comp1 = classToArray2(core_comp);
        var capable1 = classToArray2(capable);
        var level1 = classToArray2(level);
        var review1 = classToArray2(review);
        var jcore_comp = sanitizeData(core_comp);
        var jcapable = sanitizeData(capable);
        var jlevel = sanitizeData(level);
        var jreview = sanitizeData(review);

        if(arrayItemEmpty(core_comp1) == false && arrayItemEmpty(level1) == false){
            var postVars = inputVars + '&editor_input=' + summerNote+'&core_comp='+jcore_comp+'&capable='+jcapable+'&level='+jlevel+'&review='+jreview;
            //alert(postVars);
            //$('#loading_modal').modal('show');
            //$('#' + formModal).modal('hide');
            sendRequestForm(submitUrl, token, postVars)
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4 && ajax.status == 200) {

                    //$('#loading_modal').modal('hide');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if (message2 == 'fail') {

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error", messageError, "error");

                    } else if (message2 == 'saved') {

                        /*var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", "Data saved successfully!", "success");
                        location.reload();*/

                    } else {

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    //reloadContent(reload_id, reloadUrl);
                }
            }
            //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

    function save3(formModal,formId,submitUrl,reload_id,reloadUrl,token,core_comp,element,level,review) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var core_comp1 = classToArray2(core_comp);
        var element1 = classToArray2(element);
        var level1 = classToArray2(level);
        var review1 = classToArray2(review);
        var jcore_comp = sanitizeData(core_comp);
        var jelement = sanitizeData(element);
        var jlevel = sanitizeData(level);
        var jreview = sanitizeData(review);

        if(arrayItemEmpty(core_comp1) == false && arrayItemEmpty(level1) == false){
            var postVars = inputVars + '&editor_input=' + summerNote+'&core_comp='+jcore_comp+'&element='+jelement+'&level='+jlevel+'&review='+jreview;
            //alert(postVars);
            //$('#loading_modal').modal('show');
            //$('#' + formModal).modal('hide');
            sendRequestForm(submitUrl, token, postVars)
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4 && ajax.status == 200) {

                    $('#loading_modal').modal('hide');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if (message2 == 'fail') {

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error", messageError, "error");

                    } else if (message2 == 'saved') {

                        /*var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", "Data saved successfully!", "success");
                        location.reload();*/

                    } else {

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    //reloadContent(reload_id, reloadUrl);
                }
            }
            //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

    function submitDefaultApp(formModal,formId,submitUrl,reload_id,reloadUrl,token){
        var inputVars = $('#'+formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');;
        }
        var postVars = inputVars+'&editor_input='+summerNote;
        //alert(postVars);
        //$('#loading_modal').modal('show');
        //$('#'+formModal).modal('hide');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                //$('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){

                    var successMessage = swalSuccess('Data saved successfully');
                    //swal("Success!", "Data saved successfully!", "success");

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                //reloadContent(reload_id,reloadUrl);
            }
        }

    }

</script>



<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getProducts(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });

    function getProducts(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

</script>

    <script>
        /*$(function() {
            $( ".datepicker" ).datepicker({
                /!*changeMonth: true,
                changeYear: true*!/
            });
        });*/
    </script>

@endsection