@extends('layouts.app')

@section('content')

    @include('decision.page',['item'=>$item,'mainData'=>$mainData])

@endsection