
<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>

        <tr>
            
            <th style="text-align: center; font-weight:bold;">
                {{Utility::companyInfo()->name}}<br/>
                OVERDUE BILL(S) <br/>
                {{$from}} - {{$to}}
            </th>
            <th></th>
        </tr>
    </thead>
</table>

<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Customer Preview</th>
        <th>Default Preview</th>
        <th>File Number</th>
        <th>Customer</th>
        <th>Post Date</th>
        <th>Due Date</th>
        <th>Overdue</th>
        <th>invoice Status</th>
        <th>Sum Total</th>
        <th>Sum Total {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Open Balance</th>
        <th>Open Balance {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Created by</th>
        <th>Updated by</th>

    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <td>
                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('invoice_print_preview') ?>','<?php echo csrf_token(); ?>','customer')"><i class="fa fa-pencil-square-o"></i>Customer Preview</a>
            </td>
            <td>
                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('invoice_print_preview') ?>','<?php echo csrf_token(); ?>','default')"><i class="fa fa-pencil-square-o"></i>Default Preview</a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>
                @if(!empty($data->file_no))
                {{$data->file_no}}
                @else
                {{$data->id}}
                @endif
            </td>
            <td>{{$data->vendorCon->name}}</td>
            <td>{{$data->post_date}}</td>
            <td>{{$data->due_date}}</td>
            <td>{{$data->daysOverdue}} day(s)</td>
            <td>{{$data->dataStatus->name}}</td>
            <td>({{$data->currency->code}}){{$data->currency->symbol}}&nbsp;{{Utility::numberFormat($data->sum_total)}}</td>
            <td>{{Utility::numberFormat($data->trans_total)}}</td>
            <td>({{$data->currency->code}}){{$data->currency->symbol}}&nbsp;{{Utility::numberFormat($data->balance)}}</td>
            <td>{{Utility::numberFormat($data->balance_trans)}}</td>
            <td>{{$data->user_c->firstname}} &nbsp;{{$data->user_c->lastname}} </td>
            <td>{{$data->user_u->firstname}} &nbsp;{{$data->user_u->lastname}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
            <input type="hidden" id="customerDisplay" value="{{$data->vendor_customer}}">

        </tr>
    @endforeach
    </tbody>
</table>

<div class="row">
    <div class="col-md-4 pull-right"></div>
    <div class="col-md-4 pull-right" style="font-weight: bold;">Sum Total {{\App\Helpers\Utility::defaultCurrency()}} :  {{Utility::roundNum($mainData->totalBal)}}</div>
    <div class="col-md-4 pull-right"></div>
</div>
