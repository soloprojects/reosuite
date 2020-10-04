@extends('layouts.app')

@section('content')

    @include('deliverable.change_view_page',['item'=>$item,'mainData'=>$mainData])

@endsection
