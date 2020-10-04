@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Competency Map</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <!-- Tabs With Icon Title -->
                    <div class=" row clearfix">

                                <div class=" body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active">
                                            <a href="#welcome" data-toggle="tab">
                                                <i class="material-icons">home</i> Welcome
                                            </a>
                                        </li>
                                        @foreach($compType as $ap)
                                            <li role="presentation">
                                                <a href="#comp_{{$ap->id}}" data-toggle="tab">
                                                    <i class="material-icons">face</i> {{$ap->skill_comp}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">

                                        <div role="tabpanel" class="tab-pane fade in active" id="welcome">
                                            <b>Welcome</b>
                                            <p>
                                                This is competency Map. Select the tab of your choice to enter the type of
                                                competency map you desire. Please take note of saving before you close
                                                the window.
                                            </p>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="comp_{{\App\Helpers\Utility::PRO_QUAL}}">
                                            <b>Content</b>
                                            <form name="import_excel" id="createMainForm1" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                                <div class=" body">
                                                    <input type="hidden" class="form-control" value="{{\App\Helpers\Utility::PRO_QUAL}}" name="competency_type" >

                                                    <div class="container row clearfix">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" autocomplete="off" id="select_user1" onkeyup="searchOptionList('select_user1','myUL1','{{url('default_select')}}','default_search','user1');" name="select_user" placeholder="Select User">

                                                                    <input type="hidden" class="user_class" name="user" id="user1" />
                                                                </div>
                                                            </div>
                                                            <ul id="myUL1" class="myUL"></ul>
                                                        </div>
                                                    </div>

                                                    <div class="row clearfix">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select  class="form-control department_pro" name="department1" >
                                                                        <option value="">Department</option>
                                                                        @foreach($dept as $ap)
                                                                            <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select  class="form-control position_pro" name="position1" >
                                                                        <option value="">Position</option>
                                                                        @foreach($position as $ap)
                                                                            <option value="{{$ap->id}}">{{$ap->position_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control min_aca_qual" name="min_aca_qual1" placeholder="Minimum Academic Qualification">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select  class="form-control cog_exp" name="cog_exp1" >
                                                                        <option value="">Cognate Experience</option>
                                                                        @for($i=0; $i<51; $i++)
                                                                            <option value="{{$i}}">{{$i}}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control pro_qual" name="pro_qual1" placeholder="Professional Qualification">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select  class="form-control yr_post_cert" name="yr_post_cert1" >
                                                                        <option value="">Years Post Certification</option>
                                                                        @for($i=0; $i<51; $i++)
                                                                            <option value="{{$i}}">{{$i}}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4" id="hide_button_pro">
                                                            <div class="form-group">
                                                                <div onclick="addMore('add_more_pro','hide_button_pro','1','<?php echo URL::to('add_more'); ?>','pro_qual','hide_button_pro');">
                                                                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div id="add_more_pro"></div>

                                                </div>

                                            </form><br><br>
                                            <button onclick="save1('createModal','createMainForm1','<?php echo url('create_comp_map'); ?>','reload_data',
                                                    '<?php echo url('competency_map'); ?>','<?php echo csrf_token(); ?>','department_pro','position_pro','min_aca_qual','cog_exp','pro_qual','yr_post_cert')" type="button" class="pull-right btn btn-info waves-effect">
                                                SAVE
                                            </button>

                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="comp_{{\App\Helpers\Utility::TECH_COMP}}">
                                            <b>Content</b>
                                            <form name="import_excel" id="createMainForm2" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                                <div class="body">

                                                    <input type="hidden" class="form-control" value="{{\App\Helpers\Utility::TECH_COMP}}" name="competency_type" >

                                                    <div class="container row clearfix">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" autocomplete="off" id="select_user2" onkeyup="searchOptionList('select_user2','myUL2','{{url('default_select')}}','default_search','user2');" name="select_user" placeholder="Select User">

                                                                    <input type="hidden" class="user_class" name="user" id="user2" />
                                                                </div>
                                                            </div>
                                                            <ul id="myUL2" class="myUL"></ul>
                                                        </div>
                                                    </div>

                                                    <div class="row clearfix">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select  class="form-control department_tech" name="department1" id="dept_tech" onchange="fillNextInput('dept_tech','tech_compet','<?php echo url('default_select'); ?>','dept_frame_tech')" >
                                                                        <option value="">Department</option>
                                                                        @foreach($dept as $ap)
                                                                            <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select  class="form-control position_tech" name="position1" >
                                                                        <option value="">Position</option>
                                                                        @foreach($position as $ap)
                                                                            <option value="{{$ap->id}}">{{$ap->position_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line"  id="tech_compet">
                                                                    <select  class="form-control competency_cat_tech" name="competency_category" >
                                                                        <option value="">Competency Category</option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <textarea class="form-control cat_desc_tech" name="cat_desc1" placeholder="Item Description"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select  class="form-control tech_level" name="tech_level1" >
                                                                        <option value="">Level</option>
                                                                    @for($i=0; $i<6; $i++)
                                                                        <option value="{{$i}}">{{$i}}</option>
                                                                    @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4" id="hide_button2">
                                                            <div class="form-group">
                                                                <div onclick="addMore('add_more2','hide_button2','1','<?php echo URL::to('add_more'); ?>','tech_comp','hide_button2');">
                                                                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div id="add_more2"></div>

                                                </div>


                                            </form><br><br>
                                            <button onclick="save2('createModal','createMainForm2','<?php echo url('create_comp_map'); ?>','reload_data',
                                                    '<?php echo url('competency_map'); ?>','<?php echo csrf_token(); ?>','department_tech','position_tech','competency_cat_tech','tech_level','cat_desc_tech')" type="button" class="pull-right btn btn-info waves-effect">
                                                SAVE
                                            </button>

                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="comp_{{\App\Helpers\Utility::BEHAV_COMP}}">
                                            <b>Content</b>
                                            <form name="import_excel" id="createMainForm3" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                                <div class="body">
                                                    <input type="hidden" class="form-control" value="{{\App\Helpers\Utility::BEHAV_COMP}}" name="competency_type" >

                                                    <div class="container row clearfix">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control" autocomplete="off" id="select_user3" onkeyup="searchOptionList('select_user3','myUL3','{{url('default_select')}}','default_search','user3');" name="select_user" placeholder="Select User">

                                                                    <input type="hidden" class="user_class" name="user" id="user3" />
                                                                </div>
                                                            </div>
                                                            <ul id="myUL3" class="myUL"></ul>
                                                        </div>
                                                    </div>

                                                    <div class="row clearfix">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select  class="form-control department" name="department1" id="dept_behav" onchange="fillNextInput('dept_behav','behav_compet','<?php echo url('default_select'); ?>','dept_frame_behav')" >
                                                                        <option value="">Department</option>
                                                                        @foreach($dept as $ap)
                                                                            <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select  class="form-control position" name="position1" >
                                                                        <option value="">Position</option>
                                                                        @foreach($position as $ap)
                                                                            <option value="{{$ap->id}}">{{$ap->position_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line" id="behav_compet">
                                                                    <select  class="form-control competency_cat" id="comp_cat" name="competency_category" >
                                                                        <option value="">Competency Category</option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control cat_desc" name="cat_desc1" placeholder="Item Description">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select  class="form-control behav_level" name="behav_level1" >
                                                                        <option value="">Level</option>
                                                                        @for($i=0; $i<6; $i++)
                                                                            <option value="{{$i}}">{{$i}}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4" id="hide_button3">
                                                            <div class="form-group">
                                                                <div onclick="addMore('add_more3','hide_button3','1','<?php echo URL::to('add_more'); ?>','behav_comp','hide_button3');">
                                                                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div id="add_more3"></div>

                                                </div>


                                            </form><br><br>
                                            <button onclick="save3('createModal','createMainForm3','<?php echo url('create_comp_map'); ?>','reload_data',
                                                    '<?php echo url('competency_map'); ?>','<?php echo csrf_token(); ?>','department','position','competency_cat','cat_desc','behav_level')" type="button" class="pull-right btn btn-info waves-effect">
                                                SAVE
                                            </button>

                                        </div>

                                    </div>
                                </div>
                            </div>
                    <!-- #END# Tabs With Icon Title -->

                    <!--    -->

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_comp_map'); ?>','reload_data',
                            '<?php echo url('competency_map'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Competency Map
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('competency_map'); ?>',
                                    '<?php echo url('delete_comp_map'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
                            </ul>
                        </li>

                    </ul>
                </div>

                    <div class="body">

                        <div class="row clearfix">
                            <form name="import_excel" id="searchFrameForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select  class="form-control department_tech" id="dept_search" name="department" >
                                            <option value="">Department</option>
                                            @foreach($dept as $ap)
                                                <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" autocomplete="off" id="select_user5" onkeyup="searchOptionList('select_user5','myUL5','{{url('default_select')}}','default_search','user5');" name="select_user" placeholder="Select User">

                                                <input type="hidden" class="user_class" name="user" id="user5" />
                                            </div>
                                        </div>
                                        <ul id="myUL5" class="myUL"></ul>
                                    </div>
                                </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select  class="form-control" name="competency_type" id="competency_type" onchange="fillNextInput('competency_type','competency_category','<?php echo url('default_select'); ?>','search_comp_cat')" name="competency_category" >
                                            <option value="">Competency Type</option>
                                            @foreach($compType as $ap)
                                                <option value="{{$ap->id}}">{{$ap->skill_comp}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line" id="competency_category">
                                        <select  class="form-control"   >
                                            <option value="">Competency Category</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            </form>
                        </div>

                        <button onclick="searchReport('searchFrameForm','<?php echo url('search_map'); ?>','reload_data',
                                '<?php echo url('competency_map'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                            Search
                        </button>

                    </div>



                <div class="body table-responsive tbl_scroll" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Manage</th>
                            <th>Employee Name</th>
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
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_comp_map_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
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

                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class=" pagination pull-right">
                        {!! $mainData->render() !!}
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    //'min_aca_qual','cog_exp','pro_qual','yr_post_cert'
    function save1(formModal,formId,submitUrl,reload_id,reloadUrl,token,dept,position,min_aca_qual,cog_exp,pro_qual,yr_post_cert) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var dept1 = classToArray(dept);
        var position1 = classToArray(position);
        var min_aca_qual1 = classToArray(min_aca_qual);
        var cog_exp1 = classToArray(cog_exp);
        var pro_qua11 = classToArray(pro_qual);
        var yr_post_cert1 = classToArray(yr_post_cert);
        var jdept1 = sanitizeData(dept);
        var jposition1 = sanitizeData(position);
        var jmin_aca_qual1 = sanitizeData(min_aca_qual);
        var jcog_exp1 = sanitizeData(cog_exp);
        var jpro_qua11 = sanitizeData(pro_qua1);
        var jyr_post_cert1 = sanitizeData(yr_post_cert);

        if(arrayItemEmpty(dept1) == false && arrayItemEmpty(position1) == false && arrayItemEmpty(min_aca_qual1) == false && arrayItemEmpty(cog_exp1) == false && arrayItemEmpty(pro_qua11) == false && arrayItemEmpty(yr_post_cert1) == false){
            var postVars = inputVars + '&editor_input=' + summerNote+'&department='+jdept1+'&min_aca_qual='+jmin_aca_qual1+'&position='+jposition1+'&cog_exp='+jcog_exp1+'&pro_qual='+jpro_qua11+'&yr_post_cert='+jyr_post_cert1;
            //alert(postVars);
            
            $('#'+formModal).modal('hide');
            $('#'+formModal).on('hidden.bs.modal', function () {
                $('#loading_modal').modal('show');
            });

        sendRequestForm(submitUrl, token, postVars)
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4 && ajax.status == 200) {

                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if (message2 == 'fail') {

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error", messageError, "error");

                } else if (message2 == 'saved') {

                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", "Data saved successfully!", "success");
                    //location.reload();
                    //hideAddedInputs('new_pro_qual','add_more_pro','hide_button_pro','<?php echo URL::to('add_more'); ?>','pro_qual','hide_button_pro');

                } else {

                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id, reloadUrl);
            }
        }
        //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

    function save2(formModal,formId,submitUrl,reload_id,reloadUrl,token,dept,position,compCat,level,techDesc) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var dept1 = classToArray(dept);
        var position1 = classToArray(position);
        var compCat1 = classToArray(compCat);
        var level1 = classToArray(level);
        var techDesc1 = classToArray2(techDesc);
        var jdept1 = sanitizeData(dept);
        var jposition1 = sanitizeData(position);
        var jcompCat1 = sanitizeData(compCat);
        var jlevel1 = sanitizeData(level);
        var jtechDesc1 = sanitizeData(techDesc);

        if(arrayItemEmpty(dept1) == false && arrayItemEmpty(position1) == false && arrayItemEmpty(compCat1) == false && arrayItemEmpty(level1) == false){
            var postVars = inputVars + '&editor_input=' + summerNote+'&department='+jdept1+'&competency_category='+jcompCat1+'&position='+jposition1+'&level='+jlevel1+'&tech_desc='+jtechDesc1;
            
            $('#' + formModal).modal('hide');
            //DISPLAY LOADING ICON
            overlayBody('block');

            sendRequestForm(submitUrl, token, postVars)
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4 && ajax.status == 200) {

                    //HIDE LOADING ICON
					overlayBody('none');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if (message2 == 'fail') {

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error", messageError, "error");

                    } else if (message2 == 'saved') {

                         //RESET FORM
                        resetForm(formId);
                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", "Data saved successfully!", "success");
                       
                    } else {

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id, reloadUrl);
                }
            }
            //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

    //'department','position','competency_cat','cat_desc','behav_level'
    function save3(formModal,formId,submitUrl,reload_id,reloadUrl,token,dept,position,compCat,cat_desc,level) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');

        }

        var dept1 = classToArray(dept);
        var position1 = classToArray(position);
        var compCat1 = classToArray(compCat);
        var cat_desc1 = classToArray(cat_desc);
        var level1 = classToArray(level);
        var jdept1 = sanitizeData(dept);
        var jposition1 = sanitizeData(position);
        var jcompCat1 = sanitizeData(compCat);
        var jcat_desc1 = sanitizeData(cat_desc);
        var jlevel1 = sanitizeData(level);

        if(arrayItemEmpty(dept1) == false && arrayItemEmpty(position1) == false && arrayItemEmpty(compCat1) == false && arrayItemEmpty(cat_desc1) == false && arrayItemEmpty(level1) == false){
            var postVars = inputVars + '&editor_input=' + summerNote+'&department='+jdept1+'&competency_category='+jcompCat1+'&category_desc='+jcat_desc1+'&position='+jposition1+'&level='+jlevel1;
            
            $('#' + formModal).modal('hide');
            //DISPLAY LOADING ICON
            overlayBody('block');
            sendRequestForm(submitUrl, token, postVars)
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4 && ajax.status == 200) {

                    //HIDE LOADING ICON
					overlayBody('none');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if (message2 == 'fail') {

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error", messageError, "error");

                    } else if (message2 == 'saved') {

                         //RESET FORM
                        resetForm(formId);
                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", "Data saved successfully!", "success");
                        //location.reload();
                        //hideAddedInputs('new_behav_comp','add_more2','hide_button3','<?php echo URL::to('add_more'); ?>','behav_comp','hide_button3');
                    } else {

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id, reloadUrl);
                }
            }
            //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

</script>

<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        //page = window.location.hash.replace('#','');
        //getProducts(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });

    function getProducts(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }


</script>

    <script>
        $(document).on('click','.search_framework  a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getCustom(page);
        });

        function getCustom(page){
            var deptSearch = $('#dept_search').val();
            var positionSearch = $('#position_search').val();
            var compType = $('#competency_type').val();
            $.ajax({
                url: '<?php echo URL::to('search_map'); ?>?page='+page+'&competency_type='+compType+'&position='+positionSearch+'&department='+deptSearch
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }

    </script>

    <script>
        /*$(function() {
            $( ".datepicker" ).datepicker({
                /!*changeMonth: true,
                changeYear: true*!/
            });
        });*/
    </script>

    <script>
        var li_class = document.getElementsByClassName("myUL");
        $(window).click(function() {
            for (var i = 0; i < li_class.length; i++){
                li_class[i].style.display = 'none';
            }

        });
    </script>

@endsection