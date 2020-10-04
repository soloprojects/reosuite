@extends('mail_views.mail_layout')

@section('content')

@if($data->type == 'update_request')
Hello, {{$data->sender}} updated the payroll, please action this task. {{$data->desc}}
@endif

@if($data->type == 'process_request')
    Hello, {{$data->sender}} sent a request, please action this. {{$data->desc}}
@endif

@if($data->type == 'request_approval')
    Hello, {{$data->sender}} from Accounts/Finance department made some payments as briefed below
    {{$data->desc}}
@endif

@endsection