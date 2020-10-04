@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Entry</h4>
                </div>
                <div class="modal-body" style="overflow:scroll; height:500px;">

                    <!-- Tabs With Icon Title -->
                    <div class="row clearfix">

                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#welcome" data-toggle="tab">
                                        <i class="material-icons">home</i> Welcome
                                    </a>
                                </li>
                                @foreach($indiGoalCat as $ap)
                                    <li role="presentation">
                                        <a href="#comp_{{$ap->id}}" data-toggle="tab">
                                            <i class="material-icons">face</i> {{$ap->goal_name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="welcome">
                                    <b>Welcome</b>
                                    <p>
                                        This is Individual Goal System. Select the tab of your choice to enter the type of
                                        individual goal you desire. Please take note of saving before you close
                                        the window.
                                    </p><br><br>
                                    <button type="button" class="pull-right btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="comp_{{\App\Helpers\Utility::APP_OBJ_GOAL}}">
                                    <b>Content</b>

                                    <form name="import_excel" id="createMainForm1" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                        <div class="body">

                                            <div class="row clearfix">

                                                <input type="hidden" class="form-control" value="{{\App\Helpers\Utility::APP_OBJ_GOAL}}" name="competency_type" >

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select  class="form-control" name="goal_set" >
                                                                <option value="">Goal Set</option>
                                                                @foreach($indiGoalSeries as $ap)
                                                                    <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div><hr>

                                            {{--<div class="row clearfix">--}}
                                            <table class="table table-responsive">
                                                <thead>
                                                <th>...</th>
                                                <th>Objectives</th>
                                                <th>Individual Ratings</th>
                                                <th>Reviewer Ratings</th>
                                                <th>...</th>
                                                <th>...</th>
                                                </thead>
                                                <tbody id="add_more_obj">
                                                <tr>
                                                    <td>

                                                            <div class="col-sm-4" id="hide_button_obj">
                                                                <div class="form-group">
                                                                    <div onclick="addMore('add_more_obj','hide_button_obj','1','<?php echo URL::to('add_more'); ?>','app_obj_goal','hide_button_obj');">
                                                                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </td>

                                                        <td>
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <textarea rows="6" cols="40" class=" obj" name="obj" placeholder="Objectives"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <select  class="form-control obj_level" name="obj_level" >
                                                                            <option value="" selected>Rate</option>
                                                                            @foreach(APP\Helpers\Utility::REVIEW_RATE as $key => $val)
                                                                                <option value="{{$val}}">{{$val}}</option>
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
                                                                        <select  class="form-control rev_rate" disabled name="rev_rate" >
                                                                            <option value="">Reviewer Ratings</option>
                                                                            @foreach(APP\Helpers\Utility::REVIEW_RATE as $key => $val)
                                                                                <option value="{{$key}}">{{$val}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>



                                                </tr>


                                                </tbody>
                                            </table>
                                            {{-- </div>--}}
                                            <div class="row clearfix">

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <textarea rows="6" cols="50" class="" disabled name="individual" placeholder="Individual comments on achievement of objectives"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <textarea rows="6" cols="50" class="" disabled name="reviewer" placeholder="Reviewer comments on achievement of objectives"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>


                                            </div>


                                        </div>


                                    </form>
                                    <br><br>
                                    <button onclick="save1('createModal','createMainForm1','<?php echo url('create_indi_goal'); ?>','reload_data',
                                            '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>','obj','rev_rate','obj_level')" type="button" class="pull-right btn btn-info waves-effect">
                                        SAVE
                                    </button>
                                    <button type="button" class="pull-right btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>

                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="comp_{{\App\Helpers\Utility::COMP_ASSESS}}">
                                    <b>Content</b>
                                    <form name="import_excel" id="createMainForm2" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                        <div class="body">

                                            <div class="row clearfix">

                                                <input type="hidden" class="form-control" value="{{\App\Helpers\Utility::COMP_ASSESS}}" name="competency_type" >

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select  class="form-control" name="goal_set" >
                                                                <option value="">Goal Set</option>
                                                                @foreach($indiGoalSeries as $ap)
                                                                    <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div><hr>

                                            {{--<div class="row clearfix">--}}
                                            <table class="table table-responsive">
                                                <thead>
                                                <th>...</th>
                                                <th>Core Competencies</th>
                                                <th>Capabilities</th>
                                                <th>Individual Ratings</th>
                                                <th>Reviewer Ratings</th>
                                                <th>...</th>
                                                <th>...</th>
                                                </thead>
                                                <tbody id="add_more_comp">
                                                <tr>
                                                    <td>
                                                            <div class="col-sm-4" id="hide_button_comp">
                                                                <div class="form-group">
                                                                    <div onclick="addMore('add_more_comp','hide_button_comp','1','<?php echo URL::to('add_more'); ?>','comp_assess','hide_button_comp');">
                                                                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    </td>

                                                        <td>
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <select class=" core_comp" name="core_comp" id="core_comp" onchange="fillNextInput('core_comp','capable','<?php echo url('default_select'); ?>','core_tech_comp')">
                                                                            <option value="">Core Technical Competency</option>
                                                                            @foreach($techComp as $ap)
                                                                                <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <div class="form-line capable" id="capable" >
                                                                        <select  class="form-control" name="capable"  >
                                                                            <option value="">Capabilities</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <select  class="form-control comp_level" name="comp_level" >
                                                                            <option value="" selected>Level</option>
                                                                            @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                                                                <option value="{{$val}}">{{$val}}</option>
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
                                                                        <select  class="form-control comp_rev_rate" disabled name="rev_rate" >
                                                                            <option value="" selected>Reviewer Ratings</option>
                                                                            @foreach(APP\Helpers\Utility::REVIEW_RATE as $key => $val)
                                                                                <option value="{{$key}}">{{$val}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>



                                                </tr>


                                                </tbody>
                                            </table>
                                            {{-- </div>--}}
                                            <div class="row clearfix">


                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <textarea rows="6" cols="50" class="" disabled name="individual" placeholder="Individual comments on achievement of objectives"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <textarea rows="6" cols="50" class="" disabled name="reviewer" placeholder="Reviewer comments on achievement of objectives"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>


                                            </div>


                                        </div>


                                    </form>
                                    <br><br>
                                    <button onclick="save2('createModal','createMainForm2','<?php echo url('create_indi_goal'); ?>','reload_data',
                                            '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>','core_comp','capable','comp_level','comp_rev_rate')" type="button" class="pull-right btn btn-info waves-effect">
                                        SAVE
                                    </button>
                                    <button type="button" class="pull-right btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>

                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="comp_{{\App\Helpers\Utility::BEHAV_COMP2}}">
                                    <b>Content</b>
                                <form name="import_excel" id="createMainForm3" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                    <div class="body">

                                        <div class="row clearfix">

                                            <input type="hidden" class="form-control" value="{{\App\Helpers\Utility::BEHAV_COMP2}}" name="competency_type" >

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <select  class="form-control" name="goal_set" >
                                                            <option value="">Goal Set</option>
                                                            @foreach($indiGoalSeries as $ap)
                                                                <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div><hr>

                                        {{--<div class="row clearfix">--}}
                                        <table class="table table-responsive">
                                            <thead>
                                            <th>...</th>
                                            <th>Core Behavioural Competency</th>
                                            <th>Elements of Behavioural Competency</th>
                                            <th>Individual Ratings</th>
                                            <th>Reviewer Ratings</th>
                                            <th>...</th>
                                            <th>...</th>
                                            </thead>
                                            <tbody id="add_more_behav">
                                            <tr>
                                                <td>
                                                            <div class="col-sm-4" id="hide_button_behav">
                                                                <div class="form-group">
                                                                    <div onclick="addMore('add_more_behav','hide_button_behav','1','<?php echo URL::to('add_more'); ?>','behav_comp2','hide_button_behav');">
                                                                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                </td>


                                                    <td>
                                                        <div class="">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select  class="form-control core_behav_comp" id="core_behav_comp" name="core_behav_comp" onchange="fillNextInput('core_behav_comp','element','<?php echo url('default_select'); ?>','core_behav_comp')" >
                                                                        <option value="">Core Behavioural Competency</option>
                                                                        @foreach($behavComp as $ap)
                                                                            <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                    <div class="form-line element" id="element" >
                                                                        <select  class="form-control" name="element"  >
                                                                            <option value="">Elements of behavioural competency</option>
                                                                        </select>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select  class="form-control behav_level" name="behav_level" >
                                                                        <option value="" selected>Level</option>
                                                                        @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                                                            <option value="{{$val}}">{{$val}}</option>
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
                                                                    <select  class="form-control behav_rev_rate" disabled name="behav_rev_rate" >
                                                                        <option value="" selected>Reviewer Ratings</option>
                                                                        @foreach(APP\Helpers\Utility::REVIEW_RATE2 as $key => $val)
                                                                            <option value="{{$val}}">{{$val}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                            </tr>


                                            </tbody>
                                        </table>
                                        {{-- </div>--}}
                                        <div class="row clearfix">


                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <textarea rows="6" cols="50" class=" " disabled name="individual" placeholder="Individual comments on achievement of objectives"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <textarea rows="6" cols="50" class="" disabled name="reviewer" placeholder="Reviewer comments on achievement of objectives"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                        </div>


                                    </div>


                                </form>
                                <br><br>
                                <button onclick="save3('createModal','createMainForm3','<?php echo url('create_indi_goal'); ?>','reload_data',
                                        '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>','core_behav_comp','element','behav_level','behav_rev_rate')" type="button" class="pull-right btn btn-info waves-effect">
                                    SAVE
                                </button>
                                    <button type="button" class="pull-right btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="comp_{{\App\Helpers\Utility::INDI_REV_COMMENT}}">
                                    <b>Content</b>
                                    <form name="import_excel" id="createMainForm4" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                        <div class="body">

                                            <div class="row clearfix">

                                                <input type="hidden" class="form-control" value="{{\App\Helpers\Utility::INDI_REV_COMMENT}}" name="competency_type" >

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select  class="form-control" name="goal_set" >
                                                                <option value="">Goal Set</option>
                                                                @foreach($indiGoalSeries as $ap)
                                                                    <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div><hr>

                                            <div class="row clearfix">

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <textarea rows="6" cols="50" class="" disabled name="overview_str" placeholder="Overview and strengths"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <textarea rows="6" cols="50" class="" disabled name="area_improv" placeholder="Areas of Improvement"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <textarea rows="6" cols="50" class="" disabled name="sug_pp_dev" placeholder="Suggestions for personal and professional development"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row clearfix">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select  class="form-control" disabled name="over_rate" >
                                                                <option value="Nil" selected>Overall Ratings</option>
                                                                @foreach(APP\Helpers\Utility::OVERALL_RATING as $key => $val)
                                                                    <option value="{{$key}}">{{$val}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                    </form>
                                    <br><br>
                                    <button onclick="submitDefault('createModal','createMainForm4','<?php echo url('create_indi_goal'); ?>','reload_data',
                                            '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>')" type="button" class="pull-right btn btn-info waves-effect">
                                        SAVE
                                    </button>
                                    <button type="button" class="pull-right btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="comp_{{\App\Helpers\Utility::EMP_COM_APP_PLAT}}">
                                    <b>Content</b>
                                    <form name="import_excel" id="createMainForm5" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                        <div class="body">

                                            <div class="row clearfix">

                                                <input type="hidden" class="form-control" value="{{\App\Helpers\Utility::EMP_COM_APP_PLAT}}" name="competency_type" >

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select  class="form-control" name="goal_set" >
                                                                <option value="">Goal Set</option>
                                                                @foreach($indiGoalSeries as $ap)
                                                                    <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div><hr>

                                            <div class="row clearfix">

                                                    <div class="col-sm-4">
                                                        Employee comment of Appraisal Outcome
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <textarea rows="6" cols="50" class="" disabled name="emp_comment" placeholder="Employee comment of Appraisal Outcome"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

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

                                                    <div class="col-sm-4">
                                                        Reviewer sign off
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <select  class="form-control" name="rev_sign" disabled >
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

                                            </div>


                                        </div>


                                    </form>
                                    <br><br>
                                    <button onclick="submitDefault('createModal','createMainForm5','<?php echo url('create_indi_goal'); ?>','reload_data',
                                            '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>')" type="button" class="pull-right btn btn-info waves-effect">
                                        SAVE
                                    </button>
                                    <button type="button" class="pull-right btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                                </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Tabs With Icon Title -->

                    <!--    -->

                </div>
                {{--<div class="modal-footer">

                </div>--}}
            </div>
        </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content" style="overflow:scroll; height:500px;">

                </div>
                {{--<div class="modal-footer">

                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>--}}
            </div>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Individual Goals
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        {{--@if($lowerHodId == Auth::user()->id && $hodId != Auth::user()->id)--}}
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('individual_goal'); ?>',
                                    '<?php echo url('delete_indi_goal'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        @if(($lowerHod != Auth::user()->id && $lowerHod == \App\Helpers\Utility::HOD_DETECTOR) || $hod == \App\Helpers\Utility::HOD_DETECTOR)
                        <li>
                            <button type="button" onclick="changeAppraisalStatus('kid_checkbox','reload_data','<?php echo url('individual_goal'); ?>',
                                    '<?php echo url('status_indi_goal'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-o"></i>Mark as complete
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeAppraisalStatus('kid_checkbox','reload_data','<?php echo url('individual_goal'); ?>',
                                    '<?php echo url('status_indi_goal'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                <i class="fa fa-check-o"></i>Mark as incomplete
                            </button>
                        </li>
                        @endif
                        {{--@endif--}}
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
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
                            @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT) || ($lowerHod == \App\Helpers\Utility::HOD_DETECTOR && in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT)))
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control " name="department" id="dept1" onchange="fillNextInput('dept1','display_user1','<?php echo url('default_select'); ?>','dept_users')">
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
                                        <div class="form-line" id="display_user1" >
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
                                            <select  class="form-control " name="department" id="dept1" onchange="fillNextInput('dept1','display_user1','<?php echo url('default_select'); ?>','dept_users')">
                                                <option value="" selected>Select Department</option>
                                                <option value="{{Auth::user()->dept_id}}">My Department</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line" id="display_user1" >
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
                            <button  type="submit" class="btn btn-info waves-effect">
                                Mark/View Appraisal
                            </button>
                        </form>

                        <hr/>
                        <form name="import_excel" id="searchFrameForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

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
                                                <option value="" selected>Select Department</option>
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
                        </form>
                    </div>

                    <button onclick="searchReport('searchFrameForm','<?php echo url('search_indi_goal'); ?>','reload_data',
                            '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        Search
                    </button>

                </div>


                <div class="body table-responsive tbl_scroll" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Goal Set</th>
                            <th>Department</th>
                            <th>Individual Goal Category</th>
                            <th>Appraisal Status</th>
                            <th>Created by</th>
                            <th>Updated by</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->goal_set->goal_name}}</td>
                            <td>{{$data->department->dept_name}}</td>
                            <td>{{$data->i_goal_cat->goal_name}}</td>
                            <td>
                                @if($data->appraisal_status != '0')
                                    {{\App\Helpers\Utility::APPRAISAL_STATUS[1]}}
                                @else
                                    {{\App\Helpers\Utility::APPRAISAL_STATUS[0]}}
                                @endif
                            </td>
                            <td>
                                @if($data->created_by != '0')
                                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                @endif
                            </td>
                            <td>
                                @if($data->updated_by != '0')
                                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                                @endif
                            </td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->updated_at}}</td>
                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>
                                @if ($hodId == Auth::user()->id)
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_indi_goal_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i>|Mark Appraisal</a>
                                @endif
                                @if($lowerHodId == Auth::user()->id)
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_indi_goal_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                @endif
                                @if($lowerHodId != Auth::user()->id)
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_indi_goal_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                @endif
                                @if($lowerHod == \App\Helpers\Utility::HOD_DETECTOR && Auth::user()->id != $data->user_id)
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_indi_goal_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i>|Mark Appraisal</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class=" pagination pull-right">
                        {!! $mainData->render() !!}
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    function updateDeptValue(deptId,userId,deptVal){
        var dept = $('#'+deptId);
        var user = $('#'+userId).val();
        if(user != ''){
            dept.val(deptVal);
        }
    }

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

        $('#'+formModal).modal('hide');
        //DISPLAY LOADING ICON
        overlayBody('block');
                
        sendRequestForm(submitUrl, token, postVars)
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4 && ajax.status == 200) {

                //HIDE LOADING ICON
				overlayBody('none');
                
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if (message2 == 'fail') {

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error", messageError, "error");

                } else if (message2 == 'saved') {

                    //RESET FORM
					resetForm(formId);
                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", "Data saved successfully!", "success");
                    location.reload();
                    clearClassInputs('obj_edit,obj_level_edit,');
                    hideAddedInputs2('new_app_obj_goal','add_more_obj','hide_button_obj','<?php echo URL::to('add_more'); ?>','app_obj_goal');

                } else {

                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id, reloadUrl);
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
            
            $('#' + formModal).modal('hide');
            //DISPLAY LOADING ICON
            overlayBody('block');
            sendRequestForm(submitUrl, token, postVars)
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4 && ajax.status == 200) {

                    //HIDE LOADING ICON
				    overlayBody('none');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if (message2 == 'fail') {

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error", messageError, "error");

                    } else if (message2 == 'saved') {

                        //RESET FORM
					    resetForm(formId);
                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", "Data saved successfully!", "success");
                        location.reload();

                    } else {

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id, reloadUrl);
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
            
            $('#' + formModal).modal('hide');
            //DISPLAY LOADING ICON
            overlayBody('block');
            sendRequestForm(submitUrl, token, postVars)
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4 && ajax.status == 200) {

                    //HIDE LOADING ICON
				    overlayBody('none');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if (message2 == 'fail') {

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error", messageError, "error");

                    } else if (message2 == 'saved') {

                        //RESET FORM
					    resetForm(formId);
                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", "Data saved successfully!", "success");
                        location.reload();

                    } else {

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id, reloadUrl);
                }
            }
            //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
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