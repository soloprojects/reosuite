<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Employee</th>
        <th>Name</th>
        <th>Description</th>
        <th>Training Type</th>
        <th>Vendor</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Number of Days</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <td>
                @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_training_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                @endif
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->user_detail->firstname}} &nbsp; {{$data->user_detail->lastname}}</td>
            <td>{{$data->training_name}}</td>
            <td>{{$data->training_desc}}</td>
            <td>
                {{$data->type}}
            </td>
            <td>{{$data->vendor}}</td>
            <td>{{$data->from_date}}</td>
            <td>{{$data->to_date}}</td>
            <td>{{$data->duration}} &nbsp; day(s)</td>
            <td>
                @if($data->created_by != '0')
                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                @endif
            </td>
            <td>
                @if($data->updated_by != '0')
                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                @endif
            </td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>