<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Project</th>
        <th>Milestone</th>
        <th>Description</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Milestone Status</th>
        <th>No. of Task(s)</th>
        <th>No. of Task List</th>
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
            @if($item->project_head != \App\Helpers\Utility::checkAuth('temp_user')->id || in_array(\App\Helpers\Utility::checkAuth('temp_user')->role,\App\Helpers\Utility::TOP_USERS))
                <td>
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_milestone_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                </td>
            @endif
            @else
                <td></td>
        @endif
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->project->project_name}}</td>
            <td>{{$data->milestone_name}}</td>
            <td>{{$data->milestone_desc}}</td>
            <td>{{$data->start_date}}</td>
            <td>{{$data->end_date}}</td>
            <td class="{{\App\Helpers\Utility::taskColor($data->milestone_status)}}">{{\App\Helpers\Utility::taskVal($data->milestone_status)}}</td>
            <td class="btn-link">
                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','task_form','taskModal','<?php echo url('milestone_task_form') ?>','<?php echo csrf_token(); ?>')"><span class="badge bg-cyan ">{{$data->count_task}} task(s)</span> <span class="btn-link">View</span></a>
            </td>
            <td class="btn-link">
                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','task_list_form','taskListModal','<?php echo url('milestone_task_list_form') ?>','<?php echo csrf_token(); ?>')"><span class="badge bg-cyan ">{{$data->count_task_list}} task list(s)</span> <span class="btn-link">View</span></a>
            </td>
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