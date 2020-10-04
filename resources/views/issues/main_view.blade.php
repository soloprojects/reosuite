@extends('layouts.app')

@section('content')

    @include('issues.page',['item'=>$item,'mainData'=>$mainData])

@endsection