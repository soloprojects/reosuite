@extends('layouts.temp_app')

@section('content')

    @include('project_team.page',['item'=>$item,'mainData'=>$mainData])

@endsection