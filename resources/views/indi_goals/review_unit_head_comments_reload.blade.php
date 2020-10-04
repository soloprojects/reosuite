
@if(!empty($mainData))

    @foreach($mainData as $edit)
        @if($edit->indi_goal_cat == \App\Helpers\Utility::INDI_REV_COMMENT)
        <form name="" id="editMainForm{{$edit->id}}" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

            <hr/>
            <div class="body">
                <div class="row clearfix">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" disabled value="{{$edit->department->dept_name}}" name="wps" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" disabled value="{{$edit->indi_user->firstname}} {{$edit->indi_user->lastname}}" name="wps" placeholder="">
                            </div>
                        </div>
                    </div>

                </div><hr>

                {{--<div class="row clearfix">--}}
                <div class="row clearfix">
                        <div class="col-sm-4">
                            Overview Strength
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea rows="6"  cols="40" class=""  name="overview_str" placeholder="Overview and strengths">{{$edit->overview_str}}</textarea>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="row">
                        <div class="col-sm-4">
                            Areas of Improvement
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea rows="6" cols="40"  class=""  name="area_improv" placeholder="Areas of Improvement">{{$edit->area_improv}}</textarea>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="row">

                        <div class="col-sm-4">
                            Suggestions for personal and professional development
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea rows="6" cols="40" class=""  name="sug_pp_dev" placeholder="Suggestions for personal and professional development">{{$edit->sug_pp_dev}}</textarea>
                                </div>
                            </div>
                        </div>

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
            <hr/>

            <input type="hidden" name="indi_goal_cat" value="{{$edit->indi_goal_cat}}" >
            <input type="hidden" name="edit_user_id" value="{{$edit->user_id}}" >
            <input type="hidden" name="goal_set_id" value="{{$edit->goal_set_id}}" >
            <input type="hidden" name="edit_id" value="{{$edit->id}}" >
        </form>
        @endif
   @endforeach

@endif