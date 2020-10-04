<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Department</th>
        <th>Position</th>
        <th>Competency Type</th>
        <th>Competency Category</th>
        <th>Description</th>
        <th>Level</th>
        <th>Minimum Academic Qualification</th>
        <th>Cognate Experience</th>
        <th>Professional Qualification</th>
        <th>Year Post Certification</th>
        <th>Created by</th>
        <th>Created at</th>
        <th>Updated by</th>
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
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_comp_frame_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
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

        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>
