<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Name</th>
        <th>Mileage Interval</th>
        <th>Notification Date</th>
        <th>Notification Interval</th>
        <th>Services</th>
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
            @if($data->created_by == Auth::user()->id || in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                <td>
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_vehicle_maintenance_reminder_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                </td>
            @else
                <td></td>
        @endif
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->name}}</td>
            <td>{{$data->mileage}}</td>
            <td>{{$data->last_reminder}}</td>
            <td>{{$data->interval}}</td>
            <td>
                @if(!empty($data->services))
                    <table>
                        <tbody>
                        @foreach($data->services as $stage)
                            <tr><td>{{$stage->name}}</td></tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </td>
            <td>
                {{$data->user_c->firstname}} {{$data->user_c->lastname}}
            </td>
            <td>
                {{$data->user_u->firstname}} {{$data->user_u->lastname}}
            </td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>


