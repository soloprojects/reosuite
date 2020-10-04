<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Project</th>
        <th>Task</th>
        <th>Details</th>
        <th>Assigned User</th>
        <th>Status</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Duration</th>
        <th>Priority</th>
        <th>Time Planned(hrs)</th>
        <th>Time Log(hrs)</th>
        <th>Created by</th>
        <th>Created at</th>
        <th>Updated by</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            @if(\App\Helpers\Utility::authColumn('temp_user') != 'temp_user')
            @if($item->project_head == \App\Helpers\Utility::checkAuth('temp_user')->id)
            <td>
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_task_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            @endif
            @endif
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->project->project_name}}</td>
            <td>{{$data->task}}</td>
            <td>{{$data->task_desc}}</td>
            <td>
                @if(!empty($data->assigned_user))
                    {{$data->assignee->firstname}}&nbsp;{{$data->assignee->lastname}}
                @else
                    {{$data->extUser->firstname}}&nbsp;{{$data->extUser->lastname}}
                @endif
            </td>
            <td class="{{\App\Helpers\Utility::taskColor($data->task_status)}}">{{\App\Helpers\Utility::taskVal($data->task_status)}}</td>
            <td>{{$data->start_date}}</td>
            <td>{{$data->end_date}}</td>
            <td class="btn-link">{{\App\Helpers\Utility::daysDuration($data->start_date,$data->end_date)}}</td>
            <td>{{$data->task_priority}}</td>
            <td>{{$data->work_hours}}</td>
            <td></td>
            <td>
                @if($data->created_by != '0')
                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                @endif
            </td>
            <td>{{$data->created_at}}</td>
            <td>
                @if($data->updated_by != '0')
                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                @endif
            </td>
            <td>{{$data->updated_at}}</td>


            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>

<div class="task pagination pull-left">
    {!! $mainData->render() !!}
</div>