@extends('layouts.app')

@section('content')

    @include('deliverable.page',['item'=>$item,'mainData'=>$mainData])

@endsection