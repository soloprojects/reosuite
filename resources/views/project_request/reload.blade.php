<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Project</th>
        <th>Full Name</th>
        <th>subject</th>
        <th>Request Details</th>
        <th>Response</th>
        <th>Response Status</th>
        <th>Response from</th>
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
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_project_request_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->project->project_name}}</td>
            <td>
                @if(!empty($data->assigned_user))
                    {{$data->assignee->firstname}}&nbsp;{{$data->assignee->lastname}}
                @else
                    {{$data->extUser->firstname}}&nbsp;{{$data->extUser->lastname}}
                @endif
            </td>
            <td>{{$data->subject}}</td>
            <td>{!!$data->details!!}</td>
            <td>{!!$data->response!!}</td>
            <td class="{{\App\Helpers\Utility::statusIndicator($data->response_status)}}">{{\App\Helpers\Utility::defaultStatus($data->response_status)}}</td>
            <td>{{$data->user_u->updated_by}}</td>
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