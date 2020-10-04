@if($type == 'error')
    <ul>
    @foreach($mainData as $data)
        <li>{{$data}}</li>
    @endforeach
    </ul>
@endif

@if($type == \App\Helpers\Utility::PRO_QUAL)

    <table class="table table-bordered table-hover table-striped" id="main_table">
        <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                       name="check_all" class="" />

            </th>
            <th>Employee Name</th>
            <th>Department</th>
            <th>Position</th>
            <th>Competency Type</th>
            <th>Minimum Academic Qualification</th>
            <th>Cognate Experience</th>
            <th>Professional Qualification</th>
            <th>Year Post Certification</th>
            <th>Created by</th>
            <th>Created at</th>
            <th>Updated by</th>
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
                <td>{{$data->userInfo->firstname}} {{$data->userInfo->lastname}}</td>
                <td>{{$data->department->dept_name}}</td>
                <td>{{$data->position->position_name}}</td>
                <td>{{$data->compFrame->skill_comp}}</td>
                <td>{{$data->min_aca_qual}}</td>
                <td>{{$data->cog_exp}}</td>
                <td>{{$data->pro_qual}}</td>
                <td>{{$data->yr_post_cert}}</td>
                <td>
                    @if($data->created_by != '0')
                        {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                    @endif
                </td>
                <td>{{$data->created_at}}</td>
                <td>
                    @if($data->updated_by != '0')
                        {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                    @endif
                </td>
                <td>{{$data->updated_at}}</td>


                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                <td>
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_comp_map_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endif

@if($type == \App\Helpers\Utility::TECH_COMP)

    <table class="table table-bordered table-hover table-striped" id="main_table">
        <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                       name="check_all" class="" />

            </th>
            <th>Employee Name</th>
            <th>Department</th>
            <th>Position</th>
            <th>Competency Type</th>
            <th>Competency Category</th>
            <th>Level</th>
            <th>Created by</th>
            <th>Created at</th>
            <th>Updated by</th>
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
                <td>{{$data->userInfo->firstname}} {{$data->userInfo->lastname}}</td>
                <td>{{$data->department->dept_name}}</td>
                <td>{{$data->position->position_name}}</td>
                <td>{{$data->compFrame->skill_comp}}</td>
                <td>
                    @if($data->sub_comp_cat != 0)
                        {{$data->compCat->category_name}}
                    @endif
                </td>
                <td>{{$data->comp_level}}</td>
                <td>
                    @if($data->created_by != '0')
                        {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                    @endif
                </td>
                <td>{{$data->created_at}}</td>
                <td>
                    @if($data->updated_by != '0')
                        {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                    @endif
                </td>
                <td>{{$data->updated_at}}</td>


                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                <td>
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_comp_map_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endif

@if($type == \App\Helpers\Utility::BEHAV_COMP)

    <table class="table table-bordered table-hover table-striped" id="main_table">
        <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                       name="check_all" class="" />

            </th>
            <th>Employee Name </th>
            <th>Department</th>
            <th>Position</th>
            <th>Competency Type</th>
            <th>Competency Category</th>
            <th>Description</th>
            <th>Level</th>
            <th>Created by</th>
            <th>Created at</th>
            <th>Updated by</th>
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
                <td>{{$data->userInfo->firstname}} {{$data->userInfo->lastname}}</td>
                <td>{{$data->department->dept_name}}</td>
                <td>{{$data->position->position_name}}</td>
                <td>{{$data->compFrame->skill_comp}}</td>
                <td>
                    @if($data->sub_comp_cat != 0)
                        {{$data->compCat->category_name}}
                    @endif
                </td>
                <td>
                    {{$data->item_desc}}
                </td>
                <td>{{$data->comp_level}}</td>
                <td>{{$data->min_aca_qual}}</td>
                <td>{{$data->cog_experience}}</td>
                <td>{{$data->pro_qual}}</td>
                <td>{{$data->yr_post_cert}}</td>
                <td>
                    @if($data->created_by != '0')
                        {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                    @endif
                </td>
                <td>{{$data->created_at}}</td>
                <td>
                    @if($data->updated_by != '0')
                        {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                    @endif
                </td>
                <td>{{$data->updated_at}}</td>


                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                <td>
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_comp_map_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endif