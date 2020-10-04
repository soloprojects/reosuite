@extends('layouts.app')

@section('content')

    @include('survey_session.page',['mainData'=>$mainData])

@endsection