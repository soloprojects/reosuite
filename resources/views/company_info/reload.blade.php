<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>Name</th>

        <th>Address</th>
        <th>Phone1</th>
        <th>Phone2</th>
        <th>Email</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Logo</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <td>
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_company_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

            <td>
                @if($data->active_status == \App\Helpers\Utility::STATUS_ACTIVE)
                    <span class="alert-success" style="color:white">{{$data->name}}</span>
                @else
                    {{$data->name}}
                @endif
            </td>
            <td>{{$data->address}}</td>
            <td>{{$data->phone1}}</td>
            <td>{{$data->phone2}}</td>
            <td>{{$data->email}}</td>
            <td>{{$data->created_by}}</td>
            <td>{{$data->updated_by}}</td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <td><img src="{{ asset('images/'.$data->logo) }}" width="160" height="75" alt="User" /></td>

            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>