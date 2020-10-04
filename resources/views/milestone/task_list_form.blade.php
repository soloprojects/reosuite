<table class="table table-bordered table-hover table-striped" id="main_table_task_list">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_task_list');" id="parent_check_task_list"
                   name="check_all_task_list" class="" />

        </th>

        <th>Project</th>
        <th>Milestone</th>
        <th>Task List</th>
        <th>Description</th>
        <th>No. of Task(s)</th>
        <th>Created by</th>
        <th>Created at</th>
        <th>Updated by</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr id="tr_task_list_{{$data->id}}">
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="task_list_{{$data->id}}" class="kid_checkbox_task_list" />

            </td>

        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->project->project_name}}</td>
            <td>{{$milestone}}</td>
            <td>{{$data->list_name}}</td>
            <td>{{$data->list_desc}}</td>
            <td class="btn-link">
                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','task_list_item','taskListItemModal','<?php echo url('milestone_item') ?>','<?php echo csrf_token(); ?>')"><span class="badge bg-cyan ">{{$data->count_task}} task(s)</span> <span class="btn-link">View</span></a>
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


