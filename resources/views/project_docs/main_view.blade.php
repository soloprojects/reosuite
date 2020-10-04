@extends('layouts.app')

@section('content')

    @include('project_docs.page',['item'=>$item,'mainData'=>$mainData,'active'=>$active])

@endsection