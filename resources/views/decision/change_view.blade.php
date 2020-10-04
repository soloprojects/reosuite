@extends('layouts.app')

@section('content')

    @include('decision.change_view_page',['item'=>$item,'mainData'=>$mainData])

@endsection
