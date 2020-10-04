@extends('layouts.app')

@section('content')

    @include('task.page',['item'=>$item,'mainData'=>$mainData])

@endsection