<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Manage Docs</th>
        <th>View</th>
        <th>Add to Budget</th>
        <th>Name</th>
        <th>Financial Year</th>
        <th>Department</th>
        <th>Total Budget Amount ({{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Approval Status</th>
        <th>Last Date Approved</th>
        <th>Approved By</th>
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
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_budget_summary_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <td>
                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_budget_summary_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <td>
                <a class="fa fa-eye pull-right" href="<?php echo url('budget_item/view/'.$data->id) ?>">View</a>
            </td>
            <td>
                <a class="fa fa-plus-circle pull-left" href="<?php echo url('budget_item/modify/'.$data->id) ?>">Add</a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->name}} </td>
            <td>{{$data->financialYear->fin_name}}</td>
            <td>{{$data->department->dept_name}}</td>
            <td>{{Utility::numberFormat($data->budget_amount)}}</td>
            <td class="{{\App\Helpers\Utility::statusIndicator($data->approval_status)}}">{{\App\Helpers\Utility::approveStatus($data->approval_status)}}</td>
            <td>{{$data->approval_date}}</td>
            <td>{{$data->approval->firstname}} &nbsp; {{$data->approval->lastname}}</td>
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