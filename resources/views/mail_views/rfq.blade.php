@extends('mail_views.mail_layout')

@section('content')

    <table>
        <thead>
            <th style="text-align: center;">
                <b>REQUEST FOR QUOTE (RFQ)</b>
            </th>
        </thead>
    </table>

    <table class="table table-responsive">
        <thead></thead>
        <tbody>
        <tr>
            <td>RFQ Number: {{$itemDetail->rfq_no}}</td>
            <td>RFQ Due Date: {{$itemDetail->due_date}}</td>
        </tr>
        <tr>
            <td>Message:  {!!$itemDetail->message!!}</td>
            <td></td>
        </tr>
        </tbody>
    </table><hr/>

    <table class="table table-responsive">
        <thead>
            <td>Account Name</td>
            <td>Description</td>
            <td>Rate</td>
            <td>Tax(%):</td>
            <td>Tax Amount</td>
            <td>Discount(%):</td>
            <td>Discount Amount</td>
            <td>Sub Total</td>
        </thead>
        <tbody>

        @foreach($itemComponents as $data)

            @if($data->account_id != '')
                <tr>
                    <td>{{$data->account->acct_name}}</td>
                    <td>{{$data->rfq_desc}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
        <td>Rate</td>
        <td>Tax(%):</td>
        <td>Tax Amount</td>
        <td>Discount(%):</td>
        <td>Discount Amount</td>
        <td>Sub Total</td>
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
                    <td>{{$data->rfq_desc}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{$data->unit_measurement}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @include('includes.display_bom_items',['bomData' => $data->bomData, 'data' => $data])
            @endif

        @endforeach
        </tbody>
    </table><hr/>
    


@endsection