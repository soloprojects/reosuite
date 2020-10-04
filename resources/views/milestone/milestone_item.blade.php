<table class="table table-bordered table-hover table-striped" id="main_table_task_list_item">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_task_list_item');" id="parent_check_task_list_item"
                   name="check_all_task_list_item" class="" />

        </th>

        <th>Project</th>
        <th>Task List</th>
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
        <tr id="tr_task_list_item_{{$data->id}}">
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="task_list_item_{{$data->id}}" class="kid_checkbox_task_list_item" />

            </td>

            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->project->project_name}}</td>
            <td>{{$listName}}</td>
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

