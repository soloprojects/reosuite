@extends('mail_views.mail_layout')

@section('content')

@if($data->type == 'individual_goal')
Hello, {{$data->receiver_name}}, {{$data->sender_mail}} just entered {{$data->comp_type}} for individual goal
@endif

@if($data->type == 'unit_goal')
    Hello, {{$data->receiver_name}}, {{$data->sender_mail}} just entered a Unit goal category
@endif


@endsection