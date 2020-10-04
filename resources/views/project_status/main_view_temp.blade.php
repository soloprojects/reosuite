@extends('layouts.temp_app')

@section('content')

    @include('project_status.page',['item'=>$item])

@endsection