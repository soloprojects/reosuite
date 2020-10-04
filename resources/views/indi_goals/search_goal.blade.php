@if($type == 'error')
    No match found, please fill in all required fields
    <ul>
        @foreach($mainData as $data)
            <li>{{$data}}</li>
        @endforeach
    </ul>
@endif

@if($type == 'data')

    <table class="table table-bordered table-hover table-striped" id="main_table">
        <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                       name="check_all" class="" />

            </th>

            <th>Goal Set</th>
            <th>Department</th>
            <th>Individual Goal Category</th>
            <th>Appraisal Status</th>
            <th>Created by</th>
            <th>Updated by</th>
            <th>Created at</th>
            <th>Updated at</th>
            <th>Manage</th>
        </tr>
        </thead>
        <tbody>
        @if(count($mainData) >0)
        @foreach($mainData as $data)
            <tr>
                <td scope="row">
                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                </td>
                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                <td>{{$data->goal_set->goal_name}}</td>
                <td>{{$data->department->dept_name}}</td>
                <td>{{$data->i_goal_cat->goal_name}}</td>
                <td>
                    @if($data->appraisal_status != '0')
                        {{\App\Helpers\Utility::APPRAISAL_STATUS[1]}}
                    @else
                        {{\App\Helpers\Utility::APPRAISAL_STATUS[0]}}
                    @endif
                </td>
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
                <td>
                    @if ($hodId == Auth::user()->id)
                        <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_indi_goal_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i>|Mark Appraisal</a>
                    @endif
                    @if($lowerHodId == Auth::user()->id)
                        <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_indi_goal_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                    @endif
                    @if($lowerHodId != Auth::user()->id)
                        <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_indi_goal_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                    @endif
                    @if($lowerHod == \App\Helpers\Utility::HOD_DETECTOR && Auth::user()->id != $data->user_id)
                        <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_indi_goal_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i>|Mark Appraisal</a>
                    @endif
                </td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>

    <div class=" pagination pull-right">
        {!! $mainData->render() !!}
    </div>


@endif