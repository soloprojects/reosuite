<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Project</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Project Status</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Manage</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td><a href="{{url('project_item/'.$data->id.\App\Helpers\Utility::authLink('temp_user'))}}">{{$data->project_name}}</a></td>
            <td>{{$data->start_date}}</td>
            <td>{{$data->end_date}}</td>
            <td class="{{\App\Helpers\Utility::taskColor($data->project_status)}}">{{\App\Helpers\Utility::taskVal($data->project_status)}}</td>
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
            @if(\App\Helpers\Utility::authColumn('temp_user') != 'temp_user')
            @if(in_array(\App\Helpers\Utility::checkAuth('temp_user')->role,\App\Helpers\Utility::HR_MANAGEMENT) || $data->project_head == \App\Helpers\Utility::checkAuth('temp_user')->id)
                <td>
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_project_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                </td>
            @endif
            @else
                <td></td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>