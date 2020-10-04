@extends('layouts.letter_head_internal')

@section('content')

    <table class="table-bordered table-hover table-striped">
        <thead></thead>
        <tbody>
        @php $fileNo = (!empty($payment->file_no)) ? $payment->file_no : $po->id @endphp
        <tr>
            <td>Vendor: {{$po->vendorCon->name}}</td>
            <td>Bill No.:{{$fileNo}}</td>
            <td>Billing Address: {{$po->vendorCon->address}}</td>
        </tr>
        </tbody>
    </table><hr/>

    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <span class="pull-right">
            <table class="table-bordered table-hover table-striped">
                <thead></thead>
                <tbody>                
                <tr >
                    <td>Amount Paid : </td>
                    <td><h4>{{Utility::defaultCurrency()}} {{Utility::numberFormat($payment->trans_total)}}</h4></td>
                </tr>                  
                </tbody>
            </table>
            </span>
        </div>
    </div><hr/>

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

        @foreach($poData as $data)

            @if($data->account_id != '')
                <tr>
                    <td>{{$data->account->acct_name}}</td>
                    <td>{{$data->trans_desc}}</td>
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
        @foreach($poData as $data)
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
    <?php $totalExclTax =  $po->trans_total - $po->tax_trans; ?>
    <table class="table-bordered table-hover table-striped pull-right">
        <thead>

        </thead>
        <tbody>
        <tr>
            <td>Total Tax (%)</td>
            <td>{{$po->tax_perct}}</td>
        </tr>
        <tr>
            <td>Total Tax Amount ({{$currency}})</td>
            <td>{{Utility::numberFormat($po->tax_trans)}}</td>
        </tr>
        <tr>
            <td>Total Discount (%)</td>
            <td>{{$po->discount_perct}}</td>
        </tr>
        <tr>
            <td>Total Discount Amount ({{$currency}})</td>
            <td>{{Utility::numberFormat($po->discount_trans)}}</td>
        </tr>
        <tr>
            <td>Grand Total (Excl. Tax)</td>
            <td>{{Utility::numberFormat($totalExclTax)}}</td>
        </tr>
        <tr>
            <td>Grand Total ({{$currency}})</td>
            <td>{{Utility::numberFormat($po->trans_total)}}</td>
        </tr>
        </tbody>
    </table><hr/>


@endsection