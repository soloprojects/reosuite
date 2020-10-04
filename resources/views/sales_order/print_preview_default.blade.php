@extends('layouts.letter_head_internal')

@section('content')

    <table class="table-bordered table-hover table-striped">
        <thead></thead>
        <tbody>
        <tr>
            <td>Vendor: {{$sales->vendorCon->name}}</td>
            <td>Vendor Po No.:{{$sales->vendor_po_no}}</td>
            <td>Billing Address: {{$sales->vendorCon->address}}</td>
        </tr>
        <tr>
            @php $salesNumber = (empty($sales->sales_number) ? $sales->id : $sales->sales_number) @endphp
            <td>Sales Number: {{$salesNumber}}</td>
            <td>Ship to city: {{$sales->ship_to_city}}</td>
            <td>Ship to address: {{$sales->ship_address}}</td>

        </tr>

        </tbody>
    </table><hr/>

    <table class="table-bordered table-hover table-striped">
        <thead>
        <td>Account Name</td>
        <td>Description</td>
        <td>Rate ({{$currency}})</td>
        <td>Tax(%):</td>
        <td>Tax Amount ({{$currency}})</td>
        <td>Discount(%):</td>
        <td>Discount Amount ({{$currency}})</td>
        <td>Sub Total ({{$currency}})</td>
        </thead>
        <tbody>

        @foreach($salesData as $data)

            @if($data->account_id != '')
                <tr>
                    <td>{{$data->account->acct_name}}</td>
                    <td>{{$data->sales_desc}}</td>
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
        <td>Rate ({{$currency}})</td>
        <td>Tax(%):</td>
        <td>Tax Amount ({{$currency}})</td>
        <td>Discount(%):</td>
        <td>Discount Amount ({{$currency}})</td>
        <td>Sub Total ({{$currency}})</td>
        </thead>
        <tbody>

        @foreach($salesData as $data)
            @php $bomItem = (count($data->bomData) >0) ? 'Click to view Bill of Materials' : '' ; @endphp
            @if($data->item_id != '')
                <tr onclick="idDisplayClass('bom_{{$data->id}}');">
                    <td>
                        {{$data->inventory->item_name}} ({{$data->inventory->item_no}})
                        <h6>{{$bomItem}}</h6>
                    </td>
                    <td>{{$data->sales_desc}}</td>
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
    <?php $totalExclTax =  $sales->sum_total - $sales->tax_total; ?>
    <table class="table-bordered table-hover table-striped pull-right">
        <thead>

        </thead>
        <tbody>
        <tr>
            <td>Total Tax (%)</td>
            <td>{{$sales->tax_perct}}</td>
        </tr>
        <tr>
            <td>Total Tax Amount ({{$currency}})</td>
            <td>{{Utility::numberFormat($sales->tax_total)}}</td>
        </tr>
        <tr>
            <td>Total Discount (%)</td>
            <td>{{$sales->discount_perct}}</td>
        </tr>
        <tr>
            <td>Total Discount Amount ({{$currency}})</td>
            <td>{{Utility::numberFormat($sales->discount_total)}}</td>
        </tr>
        <tr>
            <td>Grand Total (Excl. Tax)</td>
            <td>{{Utility::numberFormat($totalExclTax)}}</td>
        </tr>
        <tr>
            <td>Grand Total ({{$currency}})</td>
            <td>{{Utility::numberFormat($sales->sum_total)}}</td>
        </tr>
        </tbody>
    </table><hr/>


@endsection