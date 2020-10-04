<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Name</th>
        <th>Description</th>
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
        <td>{{$data->name}}</td>
        <td>{{$data->format_desc}}</td>
        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
        <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
        <td>{{$data->created_at}}</td>
        <td>{{$data->updated_at}}</td>
        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
        <td>
            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_transaction_method_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>