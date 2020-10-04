<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Attachment</th>
        <th>Name</th>
        <th>Contract Type</th>
        <th>Recurring Bill {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Recurring Interval(Days)</th>
        <th>Status</th>
        <th>Customer</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Invoice No.</th>
        <th>Invoice Date</th>
        <th>Total Bill {{\App\Helpers\Utility::defaultCurrency()}}</th>
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
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_inventory_contract_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <td>
                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_inventory_contract_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>
                @if($data->active_status == 1)
                    {{$data->name}}
                @else
                    <span class="alert-warning">{{$data->name}}</span>
                @endif
            </td>
            <td>{{$data->contract->name}}</td>
            <td>{{Utility::numberFormat($data->recurring_cost)}}</td>
            <td>{{$data->recurring_interval}}</td>
            <td>{{$data->statusType->name}}</td>
            <td>{{$data->customer->name}}</td>
            <td>{{$data->start_date}}</td>
            <td>{{$data->end_date}}</td>
            <td>{{$data->recurring_interval}}</td>
            <td>{{$data->invoice_id}}</td>
            <td>{{$data->invoice_date}}</td>
            <td>{{$data->total_amount}}</td>
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





