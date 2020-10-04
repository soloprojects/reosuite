<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Project</th>
        <th>Details</th>
        <th>Type</th>
        <th>Comment</th>
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
            <td>{{$data->assump_desc}}</td>
            <td>{{$data->type}}</td>
            <td>
                <a href="<?php echo url('project/'.$item->id.'/assump_constraint/'.$data->id.\App\Helpers\Utility::authLink('temp_user')) ?>">View/Comment on {{$data->type}}</a>
            </td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

            @if(\App\Helpers\Utility::checkAuth('temp_user')->id == $data->created_by)
                <td>
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_assump_constraint_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
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