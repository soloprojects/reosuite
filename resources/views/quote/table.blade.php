<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>Vendor Preview</th>
        <th>Default Preview</th>
        <th>Quote Number</th>
        <th>Customer</th>
        <th>Post Date</th>
        <th>Ship to Contact</th>
        <th>Quote Status</th>
        <th>Assigned User</th>
        <th>Sum Total</th>
        <th>Sum Total {{\App\Helpers\Utility::defaultCurrency()}}</th>
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
                <a style="cursor: pointer;" onclick="editTransactForm('{{$data->id}}','edit_content','<?php echo url('edit_quote_form') ?>','<?php echo csrf_token(); ?>','foreign_amount_edit','<?php echo url('vendor_customer_currency') ?>','customerDisplay','billing_address_edit','curr_rate_edit','','')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <td>
                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('quote_print_preview') ?>','<?php echo csrf_token(); ?>','vendor')"><i class="fa fa-pencil-square-o"></i>Vendor Preview</a>
            </td>
            <td>
                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('quote_print_preview') ?>','<?php echo csrf_token(); ?>','default')"><i class="fa fa-pencil-square-o"></i>Default Preview</a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            @php $quoteNumber = (empty($data->quote_number) ? $data->id : $data->quote_number) @endphp
            <td>{{$quoteNumber}}</td>
            <td>{{$data->vendorCon->name}}</td>
            <td>{{$data->post_date}}</td>
            <td>{{$data->ship_to_contact}}</td>
            <td>{{$data->dataStatus->name}}</td>
            <td>{{$data->UserDetail->firstname}} &nbsp; {{$data->userDetail->lastname}}</td>
            <td>({{$data->currency->code}}){{$data->currency->symbol}}&nbsp;{{Utility::numberFormat($data->sum_total)}}</td>
            <td>{{Utility::numberFormat($data->trans_total)}}</td>
            <td>{{$data->user_c->firstname}} &nbsp;{{$data->user_c->lastname}} </td>
            <td>{{$data->user_u->firstname}} &nbsp;{{$data->user_u->lastname}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
            <input type="hidden" id="customerDisplay" value="{{$data->customer}}">

        </tr>
    @endforeach
    </tbody>
</table>