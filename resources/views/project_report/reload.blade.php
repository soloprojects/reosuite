
@if($reportType == 'task')

    <table class="table table-bordered table-hover table-striped" id="main_table">
        <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                       name="check_all" class="" />

            </th>

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
        </tr>
        </thead>
        <tbody>
        @foreach($mainData as $data)
            <tr>
                <td scope="row">
                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                </td>

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


                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

            </tr>
        @endforeach
        </tbody>
    </table>

@endif

@if($reportType == 'list')

    <table class="table table-bordered table-hover table-striped" id="main_table">
        <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                       name="check_all" class="" />

            </th>

            <th>Project</th>
            <th>Task List</th>
            <th>Description</th>
            <th>Task List Status</th>
            <th>No. of Task(s)</th>
            <th>Created by</th>
            <th>Created at</th>
            <th>Updated by</th>
        </tr>
        </thead>
        <tbody>
        @foreach($mainData as $data)
            <tr>
                <td scope="row">
                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                </td>

            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                <td>{{$data->project_name}}</td>
                <td>{{$data->list_name}}</td>
                <td>{{$data->list_desc}}</td>
                <td class="{{\App\Helpers\Utility::taskColor($data->list_status)}}">{{\App\Helpers\Utility::taskVal($data->list_status)}}</td>
                <td class="btn-link">
                    <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','task_form','taskModal','<?php echo url('task_form') ?>','<?php echo csrf_token(); ?>')"><span class="badge bg-cyan ">{{$data->count_task}} task(s)</span> <span class="btn-link">View</span></a>
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


                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

            </tr>
        @endforeach
        </tbody>
    </table>

@endif

@if($reportType == 'milestone')

    <table class="table table-bordered table-hover table-striped" id="main_table">
        <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                       name="check_all" class="" />

            </th>

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
        </tr>
        </thead>
        <tbody>
        @foreach($mainData as $data)
            <tr>
                <td scope="row">
                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                </td>

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


                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

            </tr>
        @endforeach
        </tbody>
    </table>


@endif

<div class="modal fade" id="taskModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Tasks</h4>

            </div>
            <div class="modal-body" id="task_form" style="overflow-x:scroll; ">

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Default Size Task List Modal -->
<div class="modal fade" id="taskListModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Task List</h4>

            </div>
            <div class="modal-body" id="task_list_form" style=" height:450px; overflow:scroll;">

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Default Size Task List Item Modal -->
<div class="modal fade" id="taskListItemModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Task(s)</h4>

            </div>
            <div class="modal-body" id="task_list_item" style=" height:450px; overflow:scroll;">

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>



