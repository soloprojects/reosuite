@if($edit->indi_goal_cat == \App\Helpers\Utility::APP_OBJ_GOAL)

<form name="" id="editMainForm1" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

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

<button onclick="save1('editModal','editMainForm1','<?php echo url('edit_indi_goal'); ?>','reload_data',
        '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>','obj_edit','rev_rate_edit','obj_level_edit')" type="button" class="pull-right btn btn-info waves-effect">
    SAVE
</button>
<button type="button" class="pull-right btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>

@endif
<!--END OF INDIVIDUAL OBJECTIVES-->

@if($edit->indi_goal_cat == \App\Helpers\Utility::COMP_ASSESS)
    <form name="" id="editMainForm2" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

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

    <button onclick="save2('editModal','editMainForm2','<?php echo url('edit_indi_goal'); ?>','reload_data',
            '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>','core_comp_edit','capable_edit','comp_level_edit','comp_rev_rate_edit')" type="button" class="pull-right btn btn-info waves-effect">
        SAVE
    </button>
    <button type="button" class="pull-right btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>

@endif
<!-- END OF COMPETENCY ASSESSMENT -->

@if($edit->indi_goal_cat == \App\Helpers\Utility::BEHAV_COMP2)
    <form name="" id="editMainForm3" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

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

    <button onclick="save3('editModal','editMainForm3','<?php echo url('edit_indi_goal'); ?>','reload_data',
            '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>','core_behav_comp_edit','element_edit','behav_level_edit','behav_rev_rate_edit')" type="button" class="pull-right btn btn-info waves-effect">
        SAVE
    </button>
    <button type="button" class="pull-right btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>

@endif
<!-- END OF BEHAVIOURAL ASSESSMENT -->

@if($edit->indi_goal_cat == \App\Helpers\Utility::INDI_REV_COMMENT)
    <form name="" id="editMainForm4" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

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
                                    <textarea rows="6" disabled cols="50" class=""  name="overview_str" placeholder="Overview and strengths">{{$edit->overview_str}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            Areas of Improvement
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea rows="6" cols="50" disabled class=""  name="area_improv" placeholder="Areas of Improvement">{{$edit->area_improv}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            Suggestions for personal and professional development
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea rows="6" disabled cols="50" class=""  name="sug_pp_dev" placeholder="Suggestions for personal and professional development">{{$edit->sug_pp_dev}}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(Auth::user()->id != $edit->user_id)
                        <div class="col-sm-4">
                            Overview Strength
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea rows="6"  cols="50" class=""  name="overview_str" placeholder="Overview and strengths">{{$edit->overview_str}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            Areas of Improvement
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea rows="6" cols="50"  class=""  name="area_improv" placeholder="Areas of Improvement">{{$edit->area_improv}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            Suggestions for personal and professional development
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea rows="6" cols="50" class=""  name="sug_pp_dev" placeholder="Suggestions for personal and professional development">{{$edit->sug_pp_dev}}</textarea>
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

        </div>

        <input type="hidden" name="indi_goal_cat" value="{{$edit->indi_goal_cat}}" >
        <input type="hidden" name="edit_user_id" value="{{$edit->user_id}}" >
        <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
        <input type="hidden" name="edit_id" value="{{$edit->id}}" >
    </form>

    <button onclick="submitDefault('editModal','editMainForm4','<?php echo url('edit_indi_goal'); ?>','reload_data',
            '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>')" type="button" class="pull-right btn btn-info waves-effect">
        SAVE
    </button>
    <button type="button" class="pull-right btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>

@endif
<!--END OF INDIVIDUAL/REVIEWER COMMENTS-->

@if($edit->indi_goal_cat == \App\Helpers\Utility::EMP_COM_APP_PLAT)
    <form name="" id="editMainForm5" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

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
                                <textarea rows="6" cols="50" class=""  name="emp_comment" placeholder="Employee comment of Appraisal Outcome">{{$edit->emp_comment}}</textarea>
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

        </div>

        <input type="hidden" name="indi_goal_cat" value="{{$edit->indi_goal_cat}}" >
        <input type="hidden" name="edit_user_id" value="{{$edit->user_id}}" >
        <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
        <input type="hidden" name="edit_id" value="{{$edit->id}}" >
    </form>

    <button onclick="submitDefault('editModal','editMainForm5','<?php echo url('edit_indi_goal'); ?>','reload_data',
            '<?php echo url('individual_goal'); ?>','<?php echo csrf_token(); ?>')" type="button" class="pull-right btn btn-info waves-effect">
        SAVE
    </button>
    <button type="button" class="pull-right btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>

@endif
<!--END OF INDIVIDUAL/REVIEWER COMMENTS-->