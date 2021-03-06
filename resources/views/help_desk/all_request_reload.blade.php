<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage Response</th>
        <th>Ticket Category</th>
        <th>Full Name</th>
        <th>Department</th>
        <th>Response Rate</th>
        <th>subject</th>
        <th>Details</th>
        <th>Response</th>
        <th>Response Status</th>
        <th>Response Dates</th>
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
                    <a style="cursor: pointer;" class="btn btn-primary" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('help_desk_ticket_response_form') ?>','<?php echo csrf_token(); ?>')">Respond Again</a>
                @else
                    <a style="cursor: pointer;" class="btn btn-primary" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('help_desk_ticket_response_form') ?>','<?php echo csrf_token(); ?>')">Respond</a>
                @endif
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->ticketCategory->request_name}}</td>
            <td>
                {{$data->reqUser->firstname}}&nbsp;{{$data->reqUser->lastname}}

            </td>
            <td>{{$data->department->dept_name}}</td>
            <td>{{$data->response_rate}}</td>
            <td>{{$data->subject}}</td>
            <td>{!!$data->details!!}</td>
            <td>{!!$data->response!!}</td>
            <td class="{{\App\Helpers\Utility::statusIndicator($data->response_status)}}">{{\App\Helpers\Utility::defaultStatus($data->response_status)}}</td>
            <td>{{$data->response_dates}}</td>
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