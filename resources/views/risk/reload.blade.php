<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>Project</th>
        <th>Risk Description</th>
        <th>Probability</th>
        <th>Impact</th>
        <th>Detectability</th>
        <th>Category</th>
        <th>Trigger</th>
        <th>Contingency Plan</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            @if($item->project_head == \App\Helpers\Utility::checkAuth('temp_user')->id)
                <td>
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_risk_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                </td>
            @else
                <td></td>
        @endif
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->project->project_name}}</td>
            <td>{{$data->risk_desc}}</td>
            <td>{{$data->probability}}</td>
            <td>{{$data->impact}}</td>
            <td>{{$data->detectability}}</td>
            <td>{{$data->category}}</td>
            <td>{{$data->trigger}}</td>
            <td>{{$data->contingency_plan}}</td>
            <td>
                {{$data->user_c->firstname}} {{$data->user_c->lastname}}
            </td>
            <td>
                {{$data->user_u->firstname}} {{$data->user_u->lastname}}
            </td>
            <td>{{$data->created_at}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>