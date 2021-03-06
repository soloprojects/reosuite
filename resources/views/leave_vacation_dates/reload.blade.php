<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>User</th>
        <th>Week</th>
        <th>Month</th>
        <th>Year</th>
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
        <td>{{$data->user->firstname}} {{$data->user->lastname}}</td>
        <td>Week {{$data->week}}</td>
        <td>{{date("F", mktime(0, 0, 0, $data->month, 10))}}</td>
        <td>{{$data->year}}</td>
        <td>{{$data->created_at}}</td>
        <td>{{$data->updated_at}}</td>
        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
        <td>
            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_leave_vacation_dates_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>
