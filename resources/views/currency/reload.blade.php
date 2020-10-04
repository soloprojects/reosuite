<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Currency</th>
        <th>Default Rate</th>
        <th>Default Rate Status</th>
        <th>Currency Code</th>
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
            @if($data->active_status == 1)
            <td class="alert-success">{{$data->currency}}</td>
            @else
                <td >{{$data->currency}}</td>
            @endif
            <td>{{$data->default_currency}}</td>
            <td>
            @if($data->default_curr_status == 1)
                Active
            @else
                Inactive
            @endif
            </td>
            <td>{{$data->code}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>
                <a style="cursor: pointer;" class="btn btn-info" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_currency_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o "></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>