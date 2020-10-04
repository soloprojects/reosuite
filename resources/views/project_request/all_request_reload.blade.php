<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage Response</th>
        <th>Project</th>
        <th>Requested By</th>
        <th>Subject</th>
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
                @if($data->response != '')
                    <a style="cursor: pointer;" class="btn btn-primary" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('project_request_response_form') ?>','<?php echo csrf_token(); ?>')">Respond Again</a>
                @else
                    <a style="cursor: pointer;" class="btn btn-primary" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('project_request_response_form') ?>','<?php echo csrf_token(); ?>')">Respond</a>
                @endif
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
            <td>
                @if($data->response == '')
                    @if(($data->assigned_user != Utility::checkAuth('temp_user')->id && !empty($data->assigned_user)) || ($data->temp_user != Utility::checkAuth('temp_user')->id && !empty($data->temp_user)) )
                        <a style="cursor: pointer;" class="btn btn-primary" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('project_request_response_form') ?>','<?php echo csrf_token(); ?>')">Respond</a>
                    @endif
                @else
                    {!!$data->response!!}
                @endif
            </td>
            <td class="{{\App\Helpers\Utility::statusIndicator($data->response_status)}}">
                {{\App\Helpers\Utility::defaultStatus($data->response_status)}}
            </td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>

