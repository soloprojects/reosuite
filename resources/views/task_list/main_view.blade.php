@extends('layouts.app')

@section('content')

    @include('task_list.page',['item'=>$item,'mainData'=>$mainData,'taskList'=>$taskList])

@endsection