<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Attachment</th>
        <th>Project</th>
        <th>Task</th>
        <th>Timesheet Title</th>
        <th>Task Details</th>
        <th>Timesheet Details</th>
        <th>Full Name</th>
        <th>Work Hours (Time Log)</th>
        <th>Work Date</th>
        <th>Approval</th>
        <th>Approval Status</th>
        <th>Created at</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <td>
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_timesheet_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <td>
                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_timesheet_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->project->project_name}}</td>
            <td>{{$data->taskName->task}}</td>
            <td>{{$data->timesheet_title}}</td>
            <td>{{$data->taskName->task_desc}}</td>
            <td>{{$data->timesheet_desc}}</td>
            <td>
                @if(!empty($data->assigned_user))
                    {{$data->assignee->firstname}}&nbsp;{{$data->assignee->lastname}}
                @else
                    {{$data->extUser->firstname}}&nbsp;{{$data->extUser->lastname}}
                @endif
            </td>
            <td>{{$data->work_hours}}</td>
            <td>{{$data->work_date}}</td>
            <td>{{$data->approveName->firstname}} {{$data->approveName->lastname}}</td>
            <td>{{\App\Helpers\Utility::approveStatus($data->approval_status)}}</td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>


            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>

<div class="task pagination pull-left">
    {!! $mainData->render() !!}
</div>