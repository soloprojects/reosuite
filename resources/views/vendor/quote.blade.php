@extends('mail_views.mail_layout')

@section('content')

    <table class="table table-responsive">
        <thead></thead>
        <tbody>
        <tr>
            <td>Vendor: {{$data['quote']->vendorCon->name}}</td>
            <td>Quote No.:{{$data['quote']->quote_number}}</td>
            <td>Billing Address: {{$data['quote']->vendorCon->address}}</td>
        </tr>
        <tr>
            <td>Ship to city: {{$data['quote']->ship_to_city}}</td>
            <td>Ship to address: {{$data['quote']->ship_to_address}}</td>

        </tr>
        <tr>
            <td>Message: {!!$data['quote']->message!!}</td>
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

        @foreach($data['quoteData'] as $data)

            @if($data->account_id != '')
                <tr>
                    <td>{{$data->account->acct_name}}</td>
                    <td>{{$data->quote_desc}}</td>
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
        @foreach($data['quoteData'] as $data)
            @php $bomItem = (count($data->bomData) >0) ? 'Click to view Bill of Materials' : '' ; @endphp
            @if($data->item_id != '')
                <tr onclick="idDisplayClass('bom_{{$data->id}}');">
                    <td>
                        {{$data->inventory->item_name}} ({{$data->inventory->item_no}})
                        <h6>{{$bomItem}}</h6>
                    </td>
                    <td>{{$data->quote_desc}}</td>
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
    <?php $totalExclTax =  $data['quote']->trans_total + $data['quote']->tax_trans; ?>
    <table class="table table-responsive">
        <thead>

        </thead>
        <tbody>
        <tr>
            <td>Total Tax (%)</td>
            <td>{{$data['quote']->tax_perct}}</td>
        </tr>
        <tr>
            <td>Total Tax Amount {{$data['currency']}}</td>
            <td>{{Utility::numberFormat($data['quote']->tax_trans)}}</td>
        </tr>
        <tr>
            <td>Total Discount (%)</td>
            <td>{{$data['quote']->discount_perct}}</td>
        </tr>
        <tr>
            <td>Total Discount Amount {{$data['currency']}}</td>
            <td>{{Utility::numberFormat($data['quote']->discount_trans)}}</td>
        </tr>
        <tr>
            <td>Grand Total (Excl. Tax) {{$data['currency']}}</td>
            <td>{{Utility::numberFormat($totalExclTax)}}</td>
        </tr>
        <tr>
            <td>Grand Total {{$data['currency']}}</td>
            <td>{{Utility::numberFormat($data['quote']->trans_total)}}</td>
        </tr>
        </tbody>
    </table><hr/>


@endsection