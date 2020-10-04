@extends('layouts.app')

@section('content')

    @include('change_log.change_view_page',['item'=>$item,'mainData'=>$mainData])

@endsection
