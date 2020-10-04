@extends('layouts.app')

@section('content')

<!-- Default Size -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">View Content</h4>
            </div>
            <div class="modal-body" id="edit_content">

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Default Size Attachment-->
<div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Download Attachment</h4>
            </div>
            <div class="modal-body" id="attach_content">


            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<div class=""> <!-- style="overflow:hidden" -->

    <div class="clearfix"></div>
    <div class="row ">
        <div class="col-md-12" style="overflow:auto">
            <div id="MyAccountsTab" class="tabbable tabs-left">
                <!-- Account selection for desktop - I -->
                @include('includes.project_menu',['item',$item])

                <div class="tab-content col-md-10" style="overflow-x:auto;">
                    <div class="tab-pane active" id="overview"><!--style="padding-left: 60px; padding-right:100px"-->
                        <div class="col-md-offset-1">
                            <div class="row" style="line-height: 14px; margin-bottom: 34.5px;">


                                <!-- Bordered Table -->
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="card">
                                            <div class="header">
                                                <h2>
                                                    Timesheet Approval
                                                </h2>
                                                <ul class="header-dropdown m-r--5">
                                                    <li>
                                                        <button type="button" onclick="timesheetApproval('kid_checkbox','reload_data','<?php echo url('project/'.$item->id.'/timesheet_approval'.\App\Helpers\Utility::authLink('temp_user')); ?>',
                                                                '<?php echo url('approve_timesheet'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                                            <i class="fa fa-check-square-o"></i>Approve
                                                        </button>
                                                    </li>
                                                    <li>
                                                    <li>
                                                        <button type="button" onclick="timesheetApproval('kid_checkbox','reload_data','<?php echo url('project/'.$item->id.'/timesheet_approval'.\App\Helpers\Utility::authLink('temp_user')); ?>',
                                                                '<?php echo url('approve_timesheet'); ?>','<?php echo csrf_token(); ?>','2');" class="btn btn-danger">
                                                            <i class="fa fa-close"></i>Deny
                                                        </button>
                                                    </li>
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
                                            <div class="body row">
                                                <form name="import_excel" id="searchTimesheetForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                                    <div class="col-sm-4" id="normal_user">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionListParamCheck('select_user','myUL1','{{url('default_select')}}','default_search_param_check','user','{{$item->id}}','user_tasks','fetch_user_tasks','{{url('default_select')}}');" name="select_user" placeholder="Select User">

                                                                <input type="hidden" class="user_class" name="user" id="user" />
                                                            </div>
                                                        </div>
                                                        <ul id="myUL1" class="myUL"></ul>
                                                    </div>

                                                    <div class="col-sm-4" id="temp_user" style="display:none;">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" autocomplete="off" id="select_users" onkeyup="searchOptionListParamCheck('select_users','myUL','{{url('default_select')}}','default_search_temp_param_check','users','{{$item->id}}','user_tasks','fetch_user_temp_tasks','{{url('default_select')}}');" name="select_user" placeholder="Select External/Contract User">

                                                                <input type="hidden" class="" disabled name="user" id="users" />
                                                            </div>
                                                        </div>
                                                        <ul id="myUL" class="myUL"></ul>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <div class="form-line" id="user_tasks">
                                                                <select  class="form-control" name="task"  >
                                                                    <option value="">Select Task</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="checkbox" class="change_user" value="1" onclick="changeUserT('normal_user','temp_user','change_user','user','users');" id="change_user" />Check to select contract/external user
                                                    <hr/>

                                                </form>

                                                <button id="search_user_timesheet_btn" onclick="searchReport('searchTimesheetForm','<?php echo url('search_timesheet_approval'); ?>','reload_data',
                                                        '<?php echo url('project/'.$item->id.'/timesheet_approval'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                                                    Search
                                                </button>
                                            </div>


                                            <div class="body table-responsive" id="reload_data">
                                                <table class="table table-bordered table-hover table-striped" id="main_table">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                                                   name="check_all" class="" />

                                                        </th>

                                                        <th>Manage</th>
                                                        <th>Attachment</th>
                                                        <th>Project</th>
                                                        <th>Task</th>
                                                        <th>Timesheet Title</th>
                                                        <th>Task Details</th>
                                                        <th>Details</th>
                                                        <th>Full Name</th>
                                                        <th>Work Hours (Time Log)</th>
                                                        <th>Work Date</th>
                                                        <th>Approval</th>
                                                        <th>Approval Status</th>
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
                                                            <td>
                                                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_timesheet_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                                            </td>
                                                            <td>
                                                                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_timesheet_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                                            </td>
                                                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                                            <td>{{$data->project->project_name}}</td>
                                                            <td>{{$data->taskName->task}}</td>
                                                            <td>{{$data->timesheet_title}}</td>
                                                            <td>{{$data->taskName->task_desc}}</td>
                                                            <td>{{$data->timesheet_desc}}</td>
                                                            <td>
                                                                @if(!empty($data->assigned_user))
                                                                    {{$data->assignee->firstname}}&nbsp;{{$data->assignee->lastname}}
                                                                @else
                                                                    {{$data->extUser->firstname}}&nbsp;{{$data->extUser->lastname}}
                                                                @endif
                                                            </td>
                                                            <td>{{$data->work_hours}}</td>
                                                            <td>{{$data->work_date}}</td>
                                                            <td>{{$data->approveName->firstname}} {{$data->approveName->lastname}}</td>
                                                            <td class="{{\App\Helpers\Utility::statusIndicator($data->approval_status)}}">{{\App\Helpers\Utility::approveStatus($data->approval_status)}}</td>
                                                            <td>{{$data->created_at}}</td>
                                                            <td>{{$data->updated_at}}</td>


                                                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                                <div class="task pagination pull-left">
                                                    {!! $mainData->render() !!}
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <!-- #END# Bordered Table -->

                            </div>
                        </div>
                    </div>

                </div>
                <!-- Account selection for desktop - F -->
            </div>
        </div>
    </div>
</div>

<!-- END OF TABS -->

<script>

    //SUBMIT FORM WITH A FILE
    function submitMediaFormClass(formModal,formId,submitUrl,reload_id,reloadUrl,token,classList){
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);

        var postVars = new FormData(form);
        postVars.append('token',token);
        appendClassToPost(classList,postVars);
        $('#loading_modal').modal('show');
        $('#'+formModal).modal('hide');
        /*$('#'+formModal).on("hidden.bs.modal", function () {
         $('#edit_content').html('');
         });*/
        sendRequestMediaForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){

                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", successMessage, "success");
                    //location.reload();

                }else{

                    //alert(message2);
                    console.log(message2)
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id,reloadUrl);
            }
        }

    }


</script>

<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        //page = window.location.hash.replace('#','');
        //getProducts(page);
    });

    $(document).on('click','#task .pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });

    function getProducts(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_task').html(data);
        });
    }

</script>

<script>
    $(function() {
        $( ".datepicker2" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>

@endsection
