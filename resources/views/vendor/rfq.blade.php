{{-- @extends('mail_views.mail_layout')

@section('content')
@component('mail-message')

    <table class="table table-bordered table-hover table-stripped table-responsive">
        <thead></thead>
        <tbody>
        <tr>
            <td>RFQ Number: {{$data['rfq']->rfq_no}}</td>
            <td>RFQ Due Date: {{$data['rfq']->due_date}}</td>
        </tr>
        <tr>
            <td>Message:  {!!$data['rfq']->message!!}</td>
            <td></td>
        </tr>
        </tbody>
    </table><hr/>

    <table class="table table-bordered table-responsive">
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

        @foreach($data['rfqData'] as $data)

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

@endsection --}}


@component('mail::message')

<thead></thead>
<tbody>
<tr>
    <td>RFQ Number: {{$data['rfq']->rfq_no}}</td>
    <td>RFQ Due Date: {{$data['rfq']->due_date}}</td>
</tr>
<tr>
    <td>Message:  {!!$data['rfq']->message!!}</td>
    <td></td>
</tr>
</tbody>


@component('mail::table')

<td>Account Name</td>
<td>Description</td>
<td>Rate</td>
<td>Tax(%):</td>
<td>Tax Amount</td>
<td>Discount(%):</td>
<td>Discount Amount</td>
<td>Sub Total</td>

@foreach($data['rfqData'] as $data)

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


@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent