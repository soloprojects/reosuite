@extends('layouts.app')

@section('content')

    @include('survey_session.form_page',['mainData'=>$mainData,'surveySession'=>$surveySession])

@endsection