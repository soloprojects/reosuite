<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Attachment</th>
        <th>Preview</th>
        <th>Description</th>
        <th>Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Approval Status</th>
        <th>Finance Status</th>
        <th>Approved by</th>
        <th>Edited</th>
        <th>Request Category</th>
        <th>Request Type</th>
        <th>Project Category</th>
        <th>Requested by</th>
        <th>Department</th>
        <th>Created by</th>
        <th>Updated by</th>
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
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_requisition_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <td>
                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <td>
                @if($data->finance_status == \App\Helpers\Utility::STATUS_ACTIVE)
                    <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('request_print_preview') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o"></i>Preview</a>
                @endif
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->req_desc}}</td>
            <td>{{Utility::numberFormat($data->amount)}}</td>
            <td class="{{\App\Helpers\Utility::statusIndicator($data->approval_status)}}">
                @if($data->approval_status === 1)
                    Request Approved
                @endif
                @if($data->approval_status === 0)
                    Processing Request
                @endif
                @if($data->approval_status === 2)
                    Request Denied
                @endif
            </td>
            <td>
                @if($data->finance_status === 0)
                    Processing
                @endif
                @if($data->finance_status === 1)
                    Complete and Ready for Print
                @endif
            </td>
            <td>
                @if($data->approved_users != '')
                    <table class="table table-bordered table-responsive">
                        <thead>
                        <th>Name</th>
                        <th>Reason</th>
                        </thead>
                        <tbody>
                        @foreach($data->approved_by as $users)
                            <tr>
                                <td>{{$users->firstname}} &nbsp; {{$users->lastname}}</td>
                                <td>Approved</td>
                            </tr>
                        @endforeach
                        <tr>
                            @if($data->deny_reason != '')
                                <td>{{$data->denyUser->firstname}} &nbsp; {{$data->denyUser->lastname}}</td>
                                <td>Denied: {{$data->deny_reason}}</td>
                            @endif
                        </tr>
                        </tbody>
                    </table>
                @else
                    @if($data->approval_status === 1)
                        Management
                    @endif
                @endif
            </td>
            <td>
                @if($data->edit_request != '')
                    <?php $edited = json_decode($data->edit_request,true); ?>
                    @foreach($edited as $key => $val)
                        {{$key}} : {{$val}}<br>
                    @endforeach
                @endif
            </td>
            <td>{{$data->requestCat->request_name}}</td>
            <td>{{$data->requestType->request_type}}</td>
            <td>
                @if($data->proj_id != 0)
                    {{$data->project->project_name}}
                @endif
            </td>
            <td>{{$data->requestUser->firstname}} &nbsp; {{$data->requestUser->lastname}}</td>
            <td>{{$data->department->dept_name}}</td>
            <td>
                @if($data->created_by != '0')
                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                @endif
            </td>
            <td>
                @if($data->updated_by != '0')
                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                @endif
            </td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>