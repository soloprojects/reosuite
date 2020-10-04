<div class="row clearfix">
    <div class="col-sm-4">
        <div class="form-group">
            <div class="form-line">
                <input type="text" class="form-control task_title" name="task_title" placeholder="Task title">
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <div class="form-line">
                <textarea type="text" class="form-control task_details" name="task" placeholder="Task Details"></textarea>
            </div>
        </div>
    </div>

    <div class="col-sm-4" id="normal_user">
        <div class="form-group">
            <div class="form-line">
                <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionListParam('select_user','myUL1','{{url('default_select')}}','default_search_param','user','{{$item->id}}');" name="select_user" placeholder="Select User">

                <input type="hidden" class="user_class" name="user" id="user" />
            </div>
        </div>
        <ul id="myUL1" class="myUL"></ul>
    </div>

    <div class="col-sm-4" id="temp_user" style="display:none;">
        <div class="form-group">
            <div class="form-line">
                <input type="text" class="form-control" autocomplete="off" id="select_users" onkeyup="searchOptionListParam('select_users','myUL','{{url('default_select')}}','default_search_temp_param','users','{{$item->id}}');" name="select_user" placeholder="Select External/Contract User">

                <input type="hidden" class="" name="user" id="users" />
            </div>
        </div>
        <ul id="myUL" class="myUL"></ul>
    </div>
</div>
<input type="checkbox" class="change_user" value="1" onclick="changeUserT('normal_user','temp_user','change_user','user','users');" id="change_user" />Check to select contract/external user
<hr/>

<div class="row clearfix">

    <div class="col-sm-4">
        <div class="form-group">
            <div class="form-line">
                <select class="form-control task_status" name="task_status" placeholder="Task Status">
                    <option value="">Select Status</option>
                    @foreach(\App\Helpers\Utility::TASK_STATUS as $key => $task)
                        <option value="{{$key}}">{{$task}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <div class="form-line">
                <select class="form-control task_priority" name="task_priority" >
                    <option value="">Select Priority</option>
                    @foreach(\App\Helpers\Utility::TASK_PRIORITY as $task)
                        <option value="{{$task}}">{{$task}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <div class="form-line">
                <input type="number" class="form-control time_planned" name="time_planned" placeholder="Time(hrs) Planned">
            </div>
        </div>
    </div>

</div>
<hr/>

<div class="row clearfix">
    <div class="col-sm-4">
        <div class="form-group">
            <div class="form-line">
                <input type="text" class="form-control start_date datepicker" autocomplete="off" name="start_date" placeholder="Start Date">
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <div class="form-line">
                <input type="text" class="form-control end_date datepicker" autocomplete="off" name="end_date" placeholder="End Date">
            </div>
        </div>
    </div>

    <div class="col-sm-4" id="hide_button">
        <div class="form-group">
            <div onclick="addMoreParam('add_more','hide_button','1','<?php echo URL::to('add_more'); ?>','task','hide_button','{{$itemId}}');">
                <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
            </div>
        </div>
    </div>
</div>
<hr/>

<div id="add_more"></div>