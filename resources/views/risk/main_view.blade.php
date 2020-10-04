@extends('layouts.app')

@section('content')

    @include('risk.page',['item'=>$item,'mainData'=>$mainData])

@endsection