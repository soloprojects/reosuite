@extends('mail_views.mail_layout')

@section('content')

    <table class="table table-responsive">
        <thead></thead>
        <tbody>
        <tr>
            <td>Vendor: {{$data['po']->vendorCon->name}}</td>
            <td>Vendor Invoice No.:{{$data['po']->vendor_invoice_no}}</td>
            <td>Billing Address: {{$data['po']->vendorCon->address}}</td>
        </tr>
        <tr>
            <td>PO Number: {{$data['po']->po_number}}</td>
            <td>Ship to city: {{$data['po']->ship_to_city}}</td>
            <td>Ship to address: {{$data['po']->ship_to_address}}</td>

        </tr>
        <tr>
            <td>Message: {!!$data['po']->message!!}</td>
            <td></td>
        </tr>
        </tbody>
    </table><hr/>

    <table class="table table-responsive">
        <thead>
            <td>Account Name</td>
            <td>Description</td>
            <td>Rate {{$data['currency']}}</td>
            <td>Tax(%):</td>
            <td>Tax Amount {{$data['currency']}}</td>
            <td>Discount(%):</td>
            <td>Discount Amount {{$data['currency']}}</td>
            <td>Sub Total {{$data['currency']}}</td>
        </thead>
        <tbody>

        @foreach($data['poData'] as $data)

            @if($data->account_id != '')
                <tr>
                    <td>{{$data->account->acct_name}}</td>
                    <td>{{$data->po_desc}}</td>
                    <td>{{Utility::numberFormat($data->unit_cost_trans)}}</td>
                    <td>{{$data->tax_perct}}</td>
                    <td>{{Utility::numberFormat($data->tax_amount_trans)}}</td>
                    <td>{{$data->discount_perct}}</td>
                    <td>{{Utility::numberFormat($data->discount_amount_trans)}}</td>
                    <td>{{Utility::numberFormat($data->extended_amount_trans)}}</td>
                </tr>
            @endif

        @endforeach

        </tbody>
    </table><hr/>

    <table class="table table-responsive">
        <thead>
        <td>Item</td>
        <td>Description</td>
        <td>Quantity</td>
        <td>Unit Measure</td>
        <td>Rate {{$data['currency']}}</td>
        <td>Tax(%):</td>
        <td>Tax Amount {{$data['currency']}}</td>
        <td>Discount(%):</td>
        <td>Discount Amount {{$data['currency']}}</td>
        <td>Sub Total {{$data['currency']}}</td>
        </thead>
        <tbody>
        @foreach($data['poData'] as $data)
            @php $bomItem = (count($data->bomData) >0) ? 'Click to view Bill of Materials' : '' ; @endphp
            @if($data->item_id != '')
                <tr onclick="idDisplayClass('bom_{{$data->id}}');">
                    <td>
                        {{$data->inventory->item_name}} ({{$data->inventory->item_no}})
                        <h6>{{$bomItem}}</h6>
                    </td>
                    <td>{{$data->po_desc}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{Utility::numberFormat($data->unit_cost_trans)}}</td>
                    <td>{{$data->tax_perct}}</td>
                    <td>{{Utility::numberFormat($data->tax_amount_trans)}}</td>
                    <td>{{$data->discount_perct}}</td>
                    <td>{{Utility::numberFormat($data->discount_amount_trans)}}</td>
                    <td>{{Utility::numberFormat($data->extended_amount_trans)}}</td>
                </tr>
                @include('includes.display_bom_items',['bomData' => $data->bomData, 'data' => $data])
            @endif

        @endforeach
        </tbody>
    </table><hr/>
    <?php $totalExclTax =  $data['po']->trans_total + $data['po']->tax_trans; ?>
    <table class="table table-responsive">
        <thead>

        </thead>
        <tbody>
        <tr>
            <td>Total Tax (%)</td>
            <td>{{$data['po']->tax_perct}}</td>
        </tr>
        <tr>
            <td>Total Tax Amount {{$data['currency']}}</td>
            <td>{{Utility::numberFormat($data['po']->tax_trans)}}</td>
        </tr>
        <tr>
            <td>Total Discount (%)</td>
            <td>{{$data['po']->discount_perct}}</td>
        </tr>
        <tr>
            <td>Total Discount Amount {{$data['currency']}}</td>
            <td>{{Utility::numberFormat($data['po']->discount_trans)}}</td>
        </tr>
        <tr>
            <td>Grand Total (Excl. Tax) {{$data['currency']}}</td>
            <td>{{Utility::numberFormat($totalExclTax)}}</td>
        </tr>
        <tr>
            <td>Grand Total {{$data['currency']}}</td>
            <td>{{Utility::numberFormat($data['po']->trans_total)}}</td>
        </tr>
        </tbody>
    </table><hr/>


@endsection