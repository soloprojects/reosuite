<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Customer Receipt</th>
        <th>Default Receipt</th>    
        <th>File/Ref Number</th>
        <th>Invoice No.</th>
        <th>Customer</th>
        <th>Post Date</th>
        <th>Status</th>
        <th>Sum Total {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Sum Total</th>
        <th>Open balance {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Open balance</th>
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
                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('receipt_print_preview') ?>','<?php echo csrf_token(); ?>','customer')"><i class="fa fa-pencil-square-o"></i>Customer Receipt</a>
            </td>
            <td>
                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('receipt_print_preview') ?>','<?php echo csrf_token(); ?>','default')"><i class="fa fa-pencil-square-o"></i>Default Receipt</a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>
                @if(!empty($data->file_no))
                {{$data->file_no}}
                @else
                {{$data->id}}
                @endif
            </td>
            <td>{{$data->reference_no}}</td>
            <td>
                {{$data->vendorCon->name}}
            </td>
            <td>{{$data->post_date}}</td>
            <td>{{$data->dataStatus->name}}</td>
            <td>{{Utility::numberFormat($data->trans_total)}}</td>
            <td>({{$data->currency->code}}){{$data->currency->symbol}}&nbsp;{{Utility::numberFormat($data->sum_total)}}</td>
            <td>{{Utility::numberFormat($data->open_balance_trans)}}</td>
            <td>({{$data->currency->code}}){{$data->currency->symbol}}&nbsp;{{Utility::numberFormat($data->open_balance)}}</td>
            <td>{{$data->user_c->firstname}} &nbsp;{{$data->user_c->lastname}} </td>
            <td>{{$data->user_u->firstname}} &nbsp;{{$data->user_u->lastname}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>