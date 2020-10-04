
    <form name="" id="editMainForm2" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

        <div class="body">
            <div class="row clearfix">
                <div class="col-sm-4">
                    <div class="form-group">
                        User
                        <div class="form-line">
                            {{$edit->user_detail->firstname}} {{$edit->user_detail->lastname}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        Coach Name
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{$edit->coach->firstname}} {{$edit->coach->lastname}}" autocomplete="off" id="select_user2" onkeyup="searchOptionList('select_user2','myUL2','{{url('default_select')}}','default_search','user2');" name="select_user" placeholder="Select User">

                            <input type="hidden" value="{{$edit->coach_id}}" class="user_class" name="user" id="user2" />
                        </div>
                    </div>
                    <ul id="myUL2" class="myUL"></ul>
                </div>

            </div><hr>

            <div class="row clearfix">

                <div class="col-sm-4">
                    <div class="form-group">
                        Short Term Goals
                        <div class="form-line">
                            <textarea rows="6" cols="50" class="" name="short_term" placeholder="Short Term Goals">{{$edit->short_term}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        Long Term Goals
                        <div class="form-line">
                            <textarea rows="6" cols="50" class="" name="long_term" placeholder="Long Term Goals">{{$edit->long_term}}</textarea>
                        </div>
                    </div>
                </div>

            </div><hr>

            <div class="row clearfix">

                <div class="col-sm-4">
                    <div class="form-group">
                        Developmental Objectives
                        <div class="form-line">
                            <textarea  class="" name="dev_obj" placeholder="Development Objectives (KSAs) needed to reach goal.">{{$edit->dev_obj}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        Developmental Assignments
                        <div class="form-line">
                            <textarea  class="" name="dev_assign" placeholder="Developmental Assignments, etc., including target completion dates.">{{$edit->dev_assign}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        Other Activities
                        <div class="form-line">
                            <textarea  class="" name="other_activities" placeholder="other_activities">{{$edit->other_act}}</textarea>
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
                <th>...</th>
                <th>...</th>
                </thead>
                <tbody id="add_more_edit">

                <?php $num = 0; $countData = []; ?>
                @foreach($edit->indiComp as $data)
                    <?php $num++  ?>
                    <?php $countData[] = $num;  ?>
                    <tr>
                        <td></td>

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

                        <input type="hidden"  value="{{$data->id}}" name="ext_id{{$num}}">
                    </tr>
                @endforeach

                <tr>
                    <td>
                        @if(Auth::user()->id ==$edit->user_id)
                            <div class="col-sm-4" id="hide_button_edit">
                                <div class="form-group">
                                    <div onclick="addMore('add_more_edit','hide_button_edit','1','<?php echo URL::to('add_more'); ?>','idp_comp_assess','hide_button_edit');">
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
                            <div class="form-group">
                                Remarks
                                <div class="form-line">
                                    <textarea rows="6" cols="50" disabled class="" name="remarks" placeholder="Remarks">{{$edit->remarks}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                Formal Training
                                <div class="form-line">
                                    <textarea rows="6" cols="50" disabled class="" name="formal_training" placeholder="Formal Training">{{$edit->formal_training}}</textarea>
                                </div>
                            </div>
                        </div>
            </div>
            <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="form-group">
                                Target Compete Date
                                <div class="form-line">
                                    <input type="text" value="{{$edit->target_comp_date}}" disabled class="datepicker2" name="target_completed_date" placeholder="Target Completed Date">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                Actual Compete Date
                                <div class="form-line">
                                    <input class="datepicker2" disabled value="{{$edit->actual_comp_date}}" name="actual_completed_date" placeholder="Actual Completed Date">
                                </div>
                            </div>
                        </div>

                @endif
                @if(Auth::user()->id != $edit->user_id)

                            <div class="col-sm-4">
                                <div class="form-group">
                                    Remarks
                                    <div class="form-line">
                                        <textarea rows="6" cols="50" class="" name="remarks" placeholder="Remarks">{{$edit->remarks}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    Formal Training
                                    <div class="form-line">
                                        <textarea rows="6" cols="50" class="" name="formal_training" placeholder="Formal Training">{{$edit->formal_training}}</textarea>
                                    </div>
                                </div>
                            </div>
                </div>
                <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    Target Compete Date
                                    <div class="form-line">
                                        <input type="text" value="{{$edit->target_comp_date}}" class="datepicker2" name="target_completed_date" placeholder="Target Completed Date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    Actual Complete Date
                                    <div class="form-line">
                                        <input class="datepicker2" value="{{$edit->actual_comp_date}}" name="actual_completed_date" placeholder="Actual Completed Date">
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

    <button onclick="save2('editModal','editMainForm2','<?php echo url('edit_idp'); ?>','reload_data',
            '<?php echo url('idp'); ?>','<?php echo csrf_token(); ?>','core_comp_edit','capable_edit','comp_level_edit')" type="button" class="pull-right btn btn-info waves-effect">
        SAVE
    </button>
    <button type="button" class="pull-right btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>

<!-- END OF COMPETENCY ASSESSMENT -->

    <script>
        $(function() {
            $( ".datepicker2" ).datepicker({
                /*changeMonth: true,
                 changeYear: true*/
            });
        });
    </script>