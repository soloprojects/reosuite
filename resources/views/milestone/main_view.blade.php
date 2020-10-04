@extends('layouts.app')

@section('content')

    @include('milestone.page',['item'=>$item,'mainData'=>$mainData,'taskList'=>$taskList,'milestone'=>$milestone])

@endsection