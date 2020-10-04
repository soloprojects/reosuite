@extends('layouts.temp_app')

@section('content')

    @include('test_session.form_page',['mainData'=>$mainData,'testSession'=>$testSession])

@endsection