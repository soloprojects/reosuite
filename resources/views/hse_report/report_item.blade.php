

@extends('layouts.letter_head_internal')

@section('content')

    <table class="table-bordered table-hover table-striped">
        <thead></thead>
        <tbody>
        <tr>
            <td>Report Type:- {{\App\Helpers\Utility::hseReportType($data->report_type)}}</td>
            <td>Source Type:-{{$data->source->source_name}}</td>
            <td>Reported By:- {{$data->user_c->firstname}}&nbsp;{{$data->user_c->lastname}}</td>
        </tr>

        <tr>
            <td>Location:-{{$data->location}}</td>
            <td>Date of Occurrence:-{{$data->report_date}}</td>
        </tr>

        <tr>
            <td>Details: </td>
            <td>{!!$data->report_details!!}</td>
        </tr>

        <tr>
            <td>Response from HSE Unit: </td>
            <td>{!!$data->response!!}</td>
        </tr>

        </tbody>
    </table><hr/>

@endsection
