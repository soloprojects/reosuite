@extends('layouts.temp_app')

@section('content')

    @include('project.page',['mainData'=>$mainData,'billMethod'=>$billMethod])
@endsection