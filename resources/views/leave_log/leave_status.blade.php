<table class="table table-bordered table-hover table-striped" id="main_table_leave_status">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_leave_status');" id="parent_check"
                   name="check_all_leave_status" class="" />

        </th>

        <th>Leave Type</th>
        <th>Number of Days</th>
        <th>Days Remaining</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="leave_status{{$data->id}}" class="kid_checkbox_leave_status" />

            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->leave_type}}</td>
            <td>{{$data->days}}</td>
            <td>{{$data->daysRemaining}}</td>
            <td>{{$data->leave_desc}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>
