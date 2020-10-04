<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage Response</th>
        <th>View Report</th>
        <th>Source Type</th>
        <th>Full Name</th>
        <th>Report Type</th>
        <th>Location</th>
        <th>Report Date</th>
        <th>Report Detail</th>
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
                    <a style="cursor: pointer;" class="btn btn-primary" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('hse_report_response_form') ?>','<?php echo csrf_token(); ?>')">Respond Again</a>
                @else
                    <a style="cursor: pointer;" class="btn btn-primary" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('hse_report_response_form') ?>','<?php echo csrf_token(); ?>')">Respond</a>
                @endif
            </td>
            <td>
                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','detail_id','detail_modal','<?php echo url('fetch_hse_report') ?>','{{csrf_token()}}')">View/Export</a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->source->source_name}}</td>
            <td>
                {{$data->user_c->firstname}}&nbsp;{{$data->user_c->lastname}}

            </td>
            <td>{{\App\Helpers\Utility::hseReportType($data->report_type)}}</td>
            <td>{{$data->location}}</td>
            <td>{{$data->report_date}}</td>
            <td>{!!$data->report_details!!}</td>
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

