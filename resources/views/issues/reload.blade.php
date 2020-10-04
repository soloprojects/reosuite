<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Project</th>
        <th>Issue Description</th>
        <th>Impact</th>
        <th>Resolution</th>
        <th>Importance</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated by</th>
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
            <td>{{$data->project->project_name}}</td>
            <td>{{$data->issue_desc}}</td>
            <td>{{$data->impact}}</td>
            <td>{{$data->resolution}}</td>
            <td>{{$data->importance}}</td>
            <td>
                @if($data->user_type == \App\Helpers\Utility::P_USER)
                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                @else
                    {{$data->tempUser_c->firstname}} {{$data->tempUser_c->lastname}}
                @endif
            </td>
            <td>
                @if($data->user_type == \App\Helpers\Utility::P_USER)
                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                @else
                    {{$data->tempUser_u->firstname}} {{$data->tempUser_u->lastname}}
                @endif
            </td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
            @if($data->user_type == \App\Helpers\Utility::P_USER && $data->created_by == \App\Helpers\Utility::checkAuth('temp_user')->id)

                <td>
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_issues_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                </td>
            @elseif($data->user_type == \App\Helpers\Utility::T_USER && $data->created_by == \App\Helpers\Utility::checkAuth('temp_user')->id)
                <td>
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_issues_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                </td>
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