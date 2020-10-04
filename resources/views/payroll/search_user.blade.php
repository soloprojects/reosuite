<table class="table table-bordered table-hover table-striped tbl_order" id="main_table1">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>Name</th>
        <th>Department</th>
        <th>Employment Type</th>
        <th>Job Role</th>
        <th>Position</th>
        <th>Salary Structure</th>
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
        @if($data->id == Auth::user()->id)
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
                <td>{{$data->employ_type}}</td>
                <td>{{$data->job_role}}</td>
                <td>
                    @if($data->position_id == '' || $data->position_id == 0)
                    @else
                        {{$data->position->position_name}}
                    @endif
                </td>
                <td>
                    @if($data->salary_id == '' || $data->salary_id == 0)
                    @else
                        {{$data->salary->salary_name}}
                    @endif
                </td>

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
                <td><img src="{{ asset('images/'.$data->photo) }}" width="72" height="60" alt="User" /></td>

                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

            </tr>
        @endif
    @endforeach
    </tbody>
</table>


<script>
    $('.tbl_order').on('scroll', function () {
        $(".tbl_order > *").width($(".tbl_order").width() + $(".tbl_order").scrollLeft());
    });
</script>
