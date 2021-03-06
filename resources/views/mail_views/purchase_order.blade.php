@extends('mail_views.mail_layout')

@section('content')

    <table>
        <thead>
            <th style="text-align: center;">
                <b>PURCHASE ORDER</b>
            </th>
        </thead>
    </table>

    <table class="table table-responsive">
        <thead></thead>
        <tbody>
        <tr>
            <td>Vendor: {{$itemDetail->vendorCon->name}}</td>
            <td>Vendor Invoice No.:{{$itemDetail->vendor_invoice_no}}</td>
            <td>Address: {{$itemDetail->vendorCon->address}}</td>
        </tr>
        <tr>
            <td>PO Number: {{$itemDetail->po_number}}</td>
            <td>Ship to city: {{$itemDetail->ship_to_city}}</td>
            <td>Ship to address: {{$itemDetail->ship_to_address}}</td>

        </tr>
        <tr>
            <td>Message: {!!$itemDetail->message!!}</td>
        </tr>
        </tbody>
    </table><hr/>

    <table class="table table-responsive">
        <thead>
            <td>Account Name</td>
            <td>Description</td>
            <td>Rate {{$currencyCode}}</td>
            <td>Tax(%):</td>
            <td>Tax Amount {{$currencyCode}}</td>
            <td>Discount(%):</td>
            <td>Discount Amount {{$currencyCode}}</td>
            <td>Sub Total {{$currencyCode}}</td>
        </thead>
        <tbody>

        @foreach($itemComponents as $data)

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
        <td>Rate {{$currencyCode}}</td>
        <td>Tax(%):</td>
        <td>Tax Amount {{$currencyCode}}</td>
        <td>Discount(%):</td>
        <td>Discount Amount {{$currencyCode}}</td>
        <td>Sub Total {{$currencyCode}}</td>
        </thead>
        <tbody>
        
        @foreach($itemComponents as $data)
            @php $bomItem = (count($data->bomData) >0) ? 'Click to view Bill of Materials' : '' ; @endphp
            @if($data->item_id != '')
                <tr onclick="idDisplayClass('bom_{{$data->id}}');">
                    <td>
                        {{$data->inventory->item_name}} ({{$data->inventory->item_no}})
                        <h6>{{$bomItem}}</h6>
                    </td>
                    <td>{{$data->po_desc}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{$data->unit_measurement}}</td>
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
    <?php $totalExclTax =  $itemDetail->trans_total + $itemDetail->tax_trans; ?>
    <table class="table table-responsive">
        <thead>

        </thead>
        <tbody>
        <tr>
            <td>Total Tax (%) </td>
            <td>{{$itemDetail->tax_perct}}</td>
        </tr>
        <tr>
            <td>Total Tax Amount {{$currencyCode}}</td>
            <td>{{Utility::numberFormat($itemDetail->tax_trans)}}</td>
        </tr>
        <tr>
            <td>Total Discount (%) </td>
            <td>{{$itemDetail->discount_perct}}</td>
        </tr>
        <tr>
            <td>Total Discount Amount {{$currencyCode}}</td>
            <td>{{Utility::numberFormat($itemDetail->discount_trans)}}</td>
        </tr>
        <tr>
            <td>Grand Total (Excl. Tax) {{$currencyCode}}</td>
            <td>{{Utility::numberFormat($totalExclTax)}}</td>
        </tr>
        <tr>
            <td>Grand Total {{$currencyCode}}</td>
            <td>{{Utility::numberFormat($itemDetail->trans_total)}}</td>
        </tr>
        </tbody>
    </table><hr/>


@endsection