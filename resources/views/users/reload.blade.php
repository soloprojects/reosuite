<table class="table table-bordered table-hover table-striped tbl_order" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>Name</th>
        <th>Department</th>
        <th>Position</th>
        <th>Employment Type</th>
        <th>Email</th>
        <th>Gender</th>
        <th>Phone</th>
        <th>Salary Structure</th>
        <th>Job Role</th>
        <th>Date of Birth</th>
        <th>Address</th>
        <th>State of Origin</th>
        <th>Nationality</th>
        <th>Marital Status</th>
        <th>Date of Employment</th>
        <th>Qualifications</th>
        <th>blood Group</th>
        <th>Next of Kin</th>
        <th>Next of Kin Phone</th>
        <th>Emergency Contact Address</th>
        <th>emergency Contact Name</th>
        <th>emergency Phone</th>
        <th>Role</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Sign</th>
        <th>Photo</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
    @if($data->role == Utility::CONTROLLER)
    @else
    <tr>
        <td scope="row">
            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

        </td>
        <td>
            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_user_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
        </td>
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
        <td>
            @if($data->active_status == 1)
            <a href="{{route('profile', ['uid' => $data->uid])}}">{{$data->title}}&nbsp;{{$data->firstname}}&nbsp;{{$data->othername}}&nbsp;{{$data->lastname}}</a>
            @else
                <a href="{{route('profile', ['uid' => $data->uid])}}">
                    <span class="alert-warning">{{$data->title}}&nbsp;{{$data->firstname}}&nbsp;{{$data->othername}}&nbsp;{{$data->lastname}}</span>
                </a>
            @endif
        </td>
        <td>
            @if($data->dept_id == '' || $data->dept_id == 0)
            @else
                {{$data->department->dept_name}}
            @endif
        </td>
        <td>
            @if($data->position_id == '' || $data->position_id == 0)
            @else
                {{$data->position->position_name}}
            @endif
        </td>
        <td>{{$data->employ_type}}</td>
        <td>{{$data->email}}</td>
        <td>{{$data->sex}}</td>
        <td>{{$data->phone}}</td>
        <td>
            @if($data->salary_id == '' || $data->salary_id == 0)
            @else
            {{$data->salary->salary_name}}
            @endif
        </td>
        <td>{{$data->job_role}}</td>
        <td>{{$data->dob}}</td>
        <td>{{$data->address}}</td>
        <td>{{$data->state}}</td>
        <td>{{$data->nationality}}</td>
        <td>{{$data->marital}}</td>
        <td>{{$data->employ_date}}</td>
        <td>{{$data->qualification}}</td>
        <td>{{$data->blood_group}}</td>
        <td>{{$data->next_kin}}</td>
        <td>{{$data->next_kin_phone}}</td>
        <td>{{$data->emergency_contact}}</td>
        <td>{{$data->emergency_name}}</td>
        <td>{{$data->emergency_phone}}</td>
        <td>{{$data->roles->role_name}}</td>
        <td>{{$data->created_by}}</td>
        <td>{{$data->updated_by}}</td>
        <td>{{$data->created_at}}</td>
        <td>{{$data->updated_at}}</td>
        <td>
            @if($data->sign != '')
            <img src="{{ asset('images/'.$data->sign) }}" width="72" height="60" alt="User" />
            @else
            No signature yet
            @endif
        </td>
        <td><img src="{{ asset('images/'.$data->photo) }}"  alt="User" /></td>

        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

    </tr>
    @endif
    @endforeach
    </tbody>
</table>