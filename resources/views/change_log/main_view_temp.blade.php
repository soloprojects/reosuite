@extends('layouts.temp_app')

@section('content')

    @include('change_log.page',['item'=>$item,'mainData'=>$mainData])

@endsection