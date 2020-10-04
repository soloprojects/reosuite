@extends('layouts.temp_app')

@section('content')

    @include('survey_session.page',['mainData'=>$mainData])

@endsection