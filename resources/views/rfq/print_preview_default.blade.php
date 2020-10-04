@extends('layouts.letter_head')

@section('content')

    <table class="table-bordered table-hover table-striped">
        <thead></thead>
        <tbody>
            @php $rfqNumber = (empty($po->rfq_no) ? $po->id : $po->rfq_no) @endphp
        <tr>
            <td>RFQ Number: {{$rfqNumber}}</td>
        </tr>

        </tbody>
    </table><hr/>

    <table class="table-bordered table-hover table-striped">
        <thead>
        <td>Account Name</td>
        <td>Description</td>
        <td>Rate </td>
        <td>Tax(%):</td>
        <td>Tax Amount </td>
        <td>Discount(%):</td>
        <td>Discount Amount </td>
        <td>Sub Total </td>
        </thead>
        <tbody>

        @foreach($poData as $data)

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

    <table class="table-bordered table-hover table-striped">
        <thead>
        <td>Item</td>
        <td>Description</td>
        <td>Quantity</td>
        <td>Unit Measure</td>
        <td>Rate </td>
        <td>Tax(%):</td>
        <td>Tax Amount </td>
        <td>Discount(%):</td>
        <td>Discount Amount </td>
        <td>Sub Total </td>
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
                    <td>{{$data->rfq_desc}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{$data->unit_measurement}}</td>
                    <td></td>
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