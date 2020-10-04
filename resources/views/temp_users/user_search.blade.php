<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>CV</th>
        <th>Name</th>
        <th>Department</th>
        <th>Email</th>
        <th>Gender</th>
        <th>Phone</th>
        <th>Date of Birth</th>
        <th>Address</th>
        <th>Nationality</th>
        <th>Qualifications</th>
        <th>Role</th>
        <th>Salary Structure</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Photo</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
            <tr>
                <td scope="row">
                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                </td>
                <td>
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_user_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                </td>
                <td>
                @if($data->cv != '')
                    <a target="_blank" href="<?php echo URL::to('temp_user_cv?file='); ?>{{$data->cv}}">
                        <i class="fa fa-files-o fa-2x"></i>
                    </a>
                @else
                    No CV to display
                    @endif
                    </td>
                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                    <td>
                        @if($data->active_status == 1)
                            <a href="{{route('profile', ['uid' => $data->uid])}}">{{$data->title}}&nbsp;{{$data->firstname}}&nbsp;{{$data->othername}}&nbsp;{{$data->lastname}}</a>
                        @else
                            <a href="{{route('temp_profile', ['uid' => $data->uid])}}">
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
                    <td>{{$data->email}}</td>
                    <td>{{$data->sex}}</td>
                    <td>{{$data->phone}}</td>

                    <td>{{$data->dob}}</td>
                    <td>{{$data->address}}</td>
                    <td>{{$data->nationality}}</td>
                    <td>{{$data->qualification}}</td>
                    <td>{{$data->roles->role_name}}</td>
                    <td>{{$data->salary->salary_name}}</td>
                    <td>{{$data->created_by}}</td>
                    <td>{{$data->updated_by}}</td>
                    <td>{{$data->created_at}}</td>

                    <td><img src="{{ asset('images/'.$data->photo) }}" width="72" height="60" alt="User" /></td>

                    <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

            </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>