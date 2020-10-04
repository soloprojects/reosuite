@extends('mail_views.mail_layout')

@section('content')


Hello {{$data->name}}, {{$data->item}} is below {{$data->re_order_level}} in quantity.
The quantity is currently {{$data->qty}}. Please reorder this item.

@endsection