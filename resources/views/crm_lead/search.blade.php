<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>Convert</th>
        <th>Name</th>
        <th>Address</th>
        <th>Contact Name</th>
        <th>Contact No</th>
        <th>Email</th>
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
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_crm_lead_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <td>
                <a class="btn btn-sm btn-info" onclick="fetchHtml('{{$data->id}}','convert_lead','convertLeadModal','<?php echo url('convert_crm_lead_form') ?>','<?php echo csrf_token(); ?>')">Convert to Customer</a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>
                @if($data->active_status == 1)
                    {{$data->name}}
                @else
                    <span class="alert-warning">{{$data->name}}</span>
                @endif
            </td>

            <td>{{$data->address}}</td>
            <td>{{$data->contact_name}}</td>
            <td>{{$data->contact_no}}</td>
            <td>{{$data->contact_no}}</td>
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

