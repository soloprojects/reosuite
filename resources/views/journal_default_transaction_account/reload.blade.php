<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>Name</th>

        <th>Default Account Payable</th>
        <th>Default Account Receivable</th>
        <th>Default Sales Tax</th>
        <th>Default Purchase Tax</th>
        <th>Default Discount Allowed</th>
        <th>Default Discount Received</th>
        <th>Default Inventory</th>
        <th>Default Payroll Tax</th>
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
            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_journal_default_transaction_account_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
        </td>
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

        <td>
            @if($data->active_status == \App\Helpers\Utility::STATUS_ACTIVE)
                <span class="alert-success" style="color:white">{{$data->name}}</span>
            @else
                {{$data->name}}
            @endif
        </td>
        <td>{{$data->accountPayable->acct_name}}</td>
        <td>{{$data->accountReceivable->acct_name}}</td>
        <td>{{$data->salesTax->acct_name}}</td>
        <td>{{$data->purchaseTax->acct_name}}</td>
        <td>{{$data->salesDiscount->acct_name}}</td>
        <td>{{$data->purchaseDiscount->acct_name}}</td>
        <td>{{$data->inventoryAcc->acct_name}}</td>
        <td>{{$data->payrollTax->acct_name}}</td>
        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
        <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
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