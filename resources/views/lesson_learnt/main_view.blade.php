@extends('layouts.app')

@section('content')

    @include('lesson_learnt.page',['item'=>$item,'mainData'=>$mainData])

@endsection