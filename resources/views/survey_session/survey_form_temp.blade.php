@extends('layouts.temp_app')

@section('content')

    @include('survey_session.form_page',['mainData'=>$mainData,'surveySession'=>$surveySession])

@endsection