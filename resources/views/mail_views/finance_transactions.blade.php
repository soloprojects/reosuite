@extends('mail_views.mail_layout')

@section('content')

    <table>
        <th style="text-align: center;">
            <b>{{$data['documentType']}}</b>
        </th>
    </table>

    <table class="table-bordered table-hover table-striped">
        <thead></thead>
        <tbody>
            @php $fileNo = (!empty($itemDetail->file_no)) ? $itemDetail->file_no : $itemDetail->id; @endphp
            @php $contact = ($itemDetail->contact_type == Utility::VENDOR) ? 'Vendor/Supplier' : 'Customer/Client'; @endphp
            @php $address = ($itemDetail->transaction_type == Finance::invoice) ? 'Billing Address' : 'Address'; @endphp
        <tr>
            <td>{{$contact}} : {{$itemDetail->vendorCon->name}}</td>
            <td>{{$itemDetail->documentType}} No.:{{$fileNo}}</td>
            <td>{{$address}}: {{$itemDetail->vendorCon->address}}</td>
        </tr>
        
        </tbody>
    </table><hr/>

    <table class="table-bordered table-hover table-striped">
        <thead>
        <td>Account Name</td>
        <td>Description</td>
        <td>Rate ({{$currencyCode}})</td>
        <td>Tax(%):</td>
        <td>Tax Amount ({{$currencyCode}})</td>
        <td>Discount(%):</td>
        <td>Discount Amount ({{$currencyCode}})</td>
        <td>Sub Total ({{$currencyCode}})</td>
        </thead>
        <tbody>

        @foreach($itemComponents as $data)

            @if($data->account_id != '')
                <tr>
                    <td>{{$data->account->acct_name}}</td>
                    <td>{{$data->trans_desc}}</td>
                    <td>{{Utility::numberFormat($data->unit_cost)}}</td>
                    <td>{{$data->tax_perct}}</td>
                    <td>{{Utility::numberFormat($data->tax_amount)}}</td>
                    <td>{{$data->discount_perct}}</td>
                    <td>{{Utility::numberFormat($data->discount_amount)}}</td>
                    <td>{{Utility::numberFormat($data->extended_amount)}}</td>
                </tr>
            @endif

        @endforeach

        </tbody>
    </table><hr/>

    <table class="table-bordered table-hover table-striped">
        <thead>
        <td>Item</td>
        <td>Description</td>
        <td>Quantity</td>
        <td>Unit Measure</td>
        <td>Rate ({{$currencyCode}})</td>
        <td>Tax(%):</td>
        <td>Tax Amount ({{$currencyCode}})</td>
        <td>Discount(%):</td>
        <td>Discount Amount ({{$currencyCode}})</td>
        <td>Sub Total ({{$currencyCode}})</td>
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
                    <td>{{$data->trans_desc}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{$data->unit_measurement}}</td>
                    <td>{{Utility::numberFormat($data->unit_cost)}}</td>
                    <td>{{$data->tax_perct}}</td>
                    <td>{{Utility::numberFormat($data->tax_amount)}}</td>
                    <td>{{$data->discount_perct}}</td>
                    <td>{{Utility::numberFormat($data->discount_amount)}}</td>
                    <td>{{Utility::numberFormat($data->extended_amount)}}</td>
                </tr>
                @include('includes.display_bom_items',['bomData' => $data->bomData, 'data' => $data])
            @endif

        @endforeach
        </tbody>
    </table><hr/>
    <?php $totalExclTax =  $itemDetail->sum_total - $itemDetail->tax_total; ?>
    <table class="table-bordered table-hover table-striped pull-right">
        <thead>

        </thead>
        <tbody>
        <tr>
            <td>Total Tax (%)</td>
            <td>{{$itemDetail->tax_perct}}</td>
        </tr>
        <tr>
            <td>Total Tax Amount ({{$currencyCode}})</td>
            <td>{{Utility::numberFormat($itemDetail->tax_total)}}</td>
        </tr>
        <tr>
            <td>Total Discount (%)</td>
            <td>{{$itemDetail->discount_perct}}</td>
        </tr>
        <tr>
            <td>Total Discount Amount ({{$currencyCode}})</td>
            <td>{{Utility::numberFormat($itemDetail->discount_total)}}</td>
        </tr>
        <tr>
            <td>Grand Total (Excl. Tax) ({{$currencyCode}})</td>
            <td>{{Utility::numberFormat($totalExclTax)}}</td>
        </tr>
        <tr>
            <td>Grand Total ({{$currencyCode}})</td>
            <td>{{Utility::numberFormat($itemDetail->sum_total)}}</td>
        </tr>
        </tbody>
    </table><hr/>


@endsection