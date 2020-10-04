<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

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
                            @foreach($unitGoalSeries as $ap)
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

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control " name="unit_goal_category" >
                            @foreach($unitGoalCat as $ap)
                                @if($edit->unit_goal_cat == $ap->id)
                                <option value="{{$ap->id}}" selected>{{$ap->category_name}}</option>
                                @else
                                 <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                @endif
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
                        @if($hod == App\Helpers\Utility::HOD_DETECTOR)
                        <input type="text" class="form-control" value="{{$edit->weight_perf_score}}" name="wps" placeholder="Weight Performance Score">
                        @else
                        <input type="text" class="form-control" disabled value="{{$edit->weight_perf_score}}" name="wps" placeholder="Weight Performance Score">
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" cols="80" class=""  name="program" placeholder="Program">
                            {{$edit->program}}
                        </textarea>
                    </div>
                </div>
            </div>

        </div>

        <table class="table table-responsive">
            <thead>
            <th></th>
            <th>Strategic Objectives</th>
            <th>Measurements</th>
            <th>Target Q1</th>
            <th>Target Q2</th>
            <th>Target Q3</th>
            <th>Target Q4</th>
            <th>Overall Perf. Score %</th>
            <th>...</th>
            <th>...</th>
            </thead>
            <tbody id="add_more_edit">

                <?php $num = 0; $countData = []; ?>
                @foreach($edit->unit_goal_ext as $data)
                <?php $num++  ?>
                <?php $countData[] = $num;  ?>
                <tr>
                <td></td>


                    @if($hod == App\Helpers\Utility::HOD_DETECTOR)
                        <td>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <div class="form-line">
                                <textarea rows="6" class=" " disabled name="strat_obj_edit{{$num}}" placeholder="Strategic Objective">{{$data->strat_obj}}</textarea>

                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                <textarea rows="6" class=" " disabled name="measure_edit{{$num}}" placeholder="Measurement">{{$data->measurement}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                <textarea rows="6" class=" " disabled name="q1_edit{{$num}}" placeholder="Target Q1">{{$data->q1}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                <textarea rows="6" class=" " disabled name="q2_edit{{$num}}" placeholder="Target Q2">{{$data->q2}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                <textarea rows="6" class=" " disabled name="q3_edit{{$num}}" placeholder="Target Q3">{{$data->q3}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                <textarea rows="6" class=" " disabled name="q4_edit{{$num}}" placeholder="Target Q4">{{$data->q4}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea rows="6" class=" " name="ops_edit{{$num}}" placeholder="over_perf_score">{{$data->over_perf_score}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </td>
                    @else
                        <td>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <div class="form-line">
                                <textarea rows="6" class=" "  name="strat_obj_edit{{$num}}" placeholder="Strategic Objective">{{$data->strat_obj}}</textarea>

                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                <textarea rows="6" class=" "  name="measure_edit{{$num}}" placeholder="Measurement">{{$data->measurement}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                <textarea rows="6" class=" " name="q1_edit{{$num}}" placeholder="Target Q1">{{$data->q1}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                <textarea rows="6" class=" " name="q2_edit{{$num}}" placeholder="Target Q2">{{$data->q2}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                <textarea rows="6" class=" " name="q3_edit{{$num}}" placeholder="Target Q3">{{$data->q3}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                <textarea rows="6" class=" " name="q4_edit{{$num}}" placeholder="Target Q4">{{$data->q4}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea rows="6" class=" " disabled name="ops_edit{{$num}}" placeholder="over_perf_score">{{$data->over_perf_score}}</textarea>
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
                    @if($lowerHod == App\Helpers\Utility::HOD_DETECTOR)
                    <div class="col-sm-4" id="hide_button_edit">
                        <div class="form-group">
                            <div onclick="addMore('add_more_edit','hide_button_edit','1','<?php echo URL::to('add_more'); ?>','unit_goal','hide_button_edit');">
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

    </div>

    <input type="hidden" name="count_ext" value="<?php echo count($countData) ?>" >
    <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>