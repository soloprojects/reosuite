<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Manage Department(s)</th>
        <th>Manage Document(s)</th>
        <th>Comment</th>
        <th>Document Name</th>
        <th>Category</th>
        <th>Details</th>
        <th>Department Access</th>
        <th>User(s) Access</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        @if(in_array(Auth::user()->dept_id,$data->deptArray) || in_array(Auth::user()->id,$data->userArray) || in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS) || $data->created_by == Auth::user()->id)
            <tr>
                <td scope="row">
                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                </td>
                @if($data->created_by == Auth::user()->id || in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                    <td>
                        <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_document_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                    </td>
                    <td>
                        <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','edit_dept_content','editDeptModal','<?php echo url('edit_document_dept_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                    </td>
                @else
                    <td></td>
                    <td></td>
                @endif
                <td>
                    <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_document_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                </td>
                <td>
                    <a href="<?php echo url('document/'.$data->id) ?>">View/Comment</a>
                </td>
                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                <td>{{$data->doc_name}}</td>
                <td>{{$data->docCategory->category_name}}</td>
                <td>{{$data->doc_desc}}</td>
                <td>
                    @if(!empty($data->deptAccess))
                        <table>
                            <tbody>
                            @foreach($data->deptAccess as $dept)
                                <tr><td>{{$dept->dept_name}}</td></tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </td>
                <td>
                    @if(!empty($data->userAccess))
                        <table>
                            <tbody>
                            @foreach($data->userAccess as $user)
                                <tr><td>{{$user->firstname}} {{$user->lastname}}</td></tr>
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
        @endif
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>