@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Discussion</h4>
                </div>
                <div class="modal-body" style="height: 400px; overflow-y:scroll;">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="title" placeholder="Title">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" multiple name="department[]" >
                                                <option value="">Department(s) Accessible to Discussion(s) </option>
                                                @foreach($dept as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div><hr/>

                            <div class="row clearfix">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        Upload File (multiple selection allowed)
                                        <div class="form-line">
                                            <input type="file" class="form-control" multiple="multiple" name="attachment[]" placeholder="Attachment">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-4" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select User">

                                            <input type="hidden" class="user_class" name="user" id="user" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>

                                <div class="col-sm-1" id="hide_button">
                                    <div class="form-group">
                                        <div onclick="addMoreEditable('add_more','hide_button','1','<?php echo URL::to('add_more'); ?>','multiple_users','hide_button','user_class');">
                                            <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="" id="add_more">

                            </div>

                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitDiscuss('createModal','createMainForm','<?php echo url('create_discuss'); ?>','reload_data',
                            '<?php echo url('discuss'); ?>','<?php echo csrf_token(); ?>','user_class')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content" style="height: 400px; overflow-y:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitDiscuss('editModal','editMainForm','<?php echo url('edit_discuss'); ?>','reload_data',
                            '<?php echo url('discuss'); ?>','<?php echo csrf_token(); ?>','user_class_edit')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size Edit Department Form -->
    <div class="modal fade" id="editDeptModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Modify Department(s)</h4>
                </div>
                <ul class="header-dropdown m-r--5 " style="list-style-type: none;">
                    <li class="pull-right">
                            <button type="button" onclick="removeAddItem('kid_checkbox_add','reload_data','<?php echo url('discuss'); ?>',
                                    '<?php echo url('modify_discuss_dept'); ?>','<?php echo csrf_token(); ?>','1','add selected Item(s)','discuss_id','editDeptModal');" class="btn btn-success">
                                <i class="fa fa-plus"></i>Add
                            </button>
                    </li>
                    <li>
                        <button type="button" onclick="removeAddItem('kid_checkbox_remove','reload_data','<?php echo url('discuss'); ?>',
                                '<?php echo url('modify_discuss_dept'); ?>','<?php echo csrf_token(); ?>','0','remove selected Item(s)','discuss_id','editDeptModal');" class="btn btn-danger">
                            <i class="fa fa-trash-o"></i>Remove
                        </button>
                    </li>
                </ul>
                <div class="modal-body" id="edit_dept_content" style="height: 400px; overflow-y:scroll;">

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size Attachment-->
    <div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Attachment</h4>
                </div>
                <div class="modal-body" id="attach_content" style="height: 400px; overflow-y:scroll;">


                </div>
                <div class="modal-footer">

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
                        Discussion(s)
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('discuss'); ?>',
                                    '<?php echo url('delete_discuss'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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

                <!-- BEGIN OF SEARCH WITH DATE INTERVALS -->
                <div class="container">
                    <form name="import_excel" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class=" body">

                            <div class="row clearfix">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="start_date" name="from_date" placeholder="From e.g 2019-02-22">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="end_date" name="to_date" placeholder="To e.g 2019-04-21">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="1" name="param"/>

                                <div class="col-sm-4" id="" style="">
                                    <div class="form-group">
                                        <button class="btn btn-info col-sm-8" type="button" onclick="searchUsingDate('searchMainForm','<?php echo url('search_discuss_using_date'); ?>','reload_data',
                                                '<?php echo url('discuss'); ?>','<?php echo csrf_token(); ?>','start_date','end_date')" id="search_hse_button">Search</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>

                </div><hr/>
                <!-- END OF SEARCH WITH DATE INTERVALS -->

                <!-- BEGIN OF SEARCH WITH Discuss NAME -->
                <div class="container">
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="search_discuss" class="form-control"
                                       onkeyup="searchItemParam('search_discuss','reload_data','<?php echo url('search_discuss') ?>','{{url('discuss')}}','<?php echo csrf_token(); ?>','type_id')"
                                       name="search_discuss" placeholder="Search Discussion" >
                            </div>
                        </div>
                        <input type="hidden" id="type_id" value="1" name="type"/>
                    </div>
                </div><hr/>
                <!-- BEGIN OF SEARCH WITH Discuss NAME -->

                <div class="body table-responsive tbl_scroll" id="reload_data">

                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>

                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Manage</th>
                            <th>Manage Department(s)</th>
                            <th>Manage Attachment(s)</th>
                            <th>Comment</th>
                            <th>Title</th>
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
                            @if(in_array(Auth::user()->dept_id,$data->deptArray) || in_array(Auth::user()->id,$data->userArray) || $data->created_by == Auth::user()->id )
                            <tr>
                                <td scope="row">
                                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                </td>
                                @if($data->created_by == Auth::user()->id))
                                <td>
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_discuss_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                <td>
                                    <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','edit_dept_content','editDeptModal','<?php echo url('edit_discuss_dept_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                @else
                                <td></td>
                                <td></td>
                                @endif
                                <td>
                                    <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_discuss_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>
                                    <a href="<?php echo url('discuss/'.$data->id) ?>">View/Comment</a>
                                </td>
                                <td>{{$data->title}}</td>
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

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

    <script>

        //SUBMIT FORM WITH A FILE
        function submitDiscuss(formModal,formId,submitUrl,reload_id,reloadUrl,token,userClass){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            var postVars = new FormData(form);
            postVars.append('token',token);
            postVars.append('users',sanitizeDataWithoutEncode(userClass));
            
            $('#'+formModal).modal('hide');
            //DISPLAY LOADING ICON
            overlayBody('block');

            sendRequestMediaForm(submitUrl,token,postVars);
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {
                    //HIDE LOADING ICON
					overlayBody('none');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if(message2 == 'fail'){

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error",messageError, "error");

                    }else if(message2 == 'saved'){

                        //RESET FORM
						resetForm(formId);
                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", successMessage, "success");

                    }else if(message2 == 'token_mismatch'){

                        location.reload();

                    }else {
                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");
                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id,reloadUrl);
                }
            }

        }

        /*==================== PAGINATION =========================*/

        $(window).on('hashchange',function(){
            page = window.location.hash.replace('#','');
            getProducts(page);
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
        /*$(function() {
         $( ".datepicker" ).datepicker({
         /!*changeMonth: true,
         changeYear: true*!/
         });
         });*/
    </script>

@endsection