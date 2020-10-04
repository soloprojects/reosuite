@extends('layouts.letter_head_internal')

@section('content')

<div class="">
    <table class="table table-bordered table-hover table-striped" id="">
        <thead>
        <tr>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Date</td>
            <td>{{\App\Helpers\Utility::standardDate($data->created_at)}}</td>
        </tr>
        </tbody>
    </table>



    <table class="table table-bordered table-hover table-striped" id="">
        <thead>
        <tr>

            <th>Category</th>
            <th>Description</th>
            <th>Request Type</th>
            <th>Project</th>

        </tr>
        </thead>
        <tbody>

        <tr>

            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->requestCat->request_name}}</td>
            <td>{{$data->req_desc}}</td>

            <td>{{$data->requestType->request_type}}</td>
            <td>
                @if($data->proj_id != 0)
                    {{$data->project->project_name}}
                @endif
            </td>

            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>

        </tbody>
    </table>

    <table class="table table-bordered table-hover table-striped" id="">
        <thead>
        <tr>

        </tr>
        </thead>
        <tbody>


        <tr>
            <td>Approved By</td>
            <td>
                @if($data->approved_users != '')
                    <table class="table table-bordered table-responsive">
                        <thead>
                        <th>Name</th>
                        <th>Signature</th>
                        </thead>
                        <tbody>
                        @foreach($data->approved_by as $users)
                            <tr>
                                <td>{{$users->firstname}} &nbsp; {{$users->lastname}}</td>
                                <td>
                                    @if($data->sign != '')
                                        <img src="{{ asset('images/'.$data->sign) }}" width="72" height="60" alt="User" />
                                    @else
                                        No signature yet
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @else
                    @if($data->approval_status === 1)
                        Management
                    @endif
                @endif
            </td>

        </tr>
        <tr>
            <td>Created By</td>
            <td>
                @if($data->created_by != '0')
                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                @endif
            </td>
        </tr>
        </tbody>
    </table>

</div>

@endsection