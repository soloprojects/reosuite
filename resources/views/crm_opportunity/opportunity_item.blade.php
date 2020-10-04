
    @extends('layouts.app')

    @section('content')

        <!-- ADD ACTIVITY MODAL -->
        <div class="modal fade" id="createActivityModal" tabindex="-1" role="dialog" xmlns="http://www.w3.org/1999/html">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Add Activity</h4>
                    </div>
                    <div class="modal-body" style="height:400px; overflow:scroll;">

                        <form name="activity_form" id="createActivityMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                            <div class="body">
                                <div class="row clearfix">

                                    <div class="col-sm-6">
                                        <b>Subject</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="subject" placeholder="Subject">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <b>Activity Type</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" name="activity_type" >
                                                    <option value="">Select Activity Type</option>
                                                    @foreach($activityType as $d)
                                                        <option value="{{$d->id}}">{{$d->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <b>Opportunity Stage</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" id="activity_stage" name="opportunity_stage" id="stage" >
                                                    <option value="">Select Opportunity Stage</option>
                                                    @foreach($opportunityStage as $d)
                                                        <option value="{{$d->id}}">{{$d->name}}(Stage {{$d->stage}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <b>Due Date</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" name="due_date" placeholder="Due Date">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <b>Details</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea class="form-control" name="details" placeholder="Details"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="opportunity" value="{{$mainData->id}}" />

                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button onclick="submitMediaFormReloadWithInputsCrm('createActivityModal','createActivityMainForm','<?php echo url('create_crm_activity'); ?>','reload_activity_data',
                                '<?php echo url('crm_activity'); ?>','<?php echo csrf_token(); ?>','activity_stage')" type="button" class="btn btn-link waves-effect">
                            SAVE
                        </button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADD NOTES MODAL -->
        <div class="modal fade" id="createNotesModal" tabindex="-1" role="dialog" xmlns="http://www.w3.org/1999/html">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Add Note</h4>
                    </div>
                    <div class="modal-body" style="height:400px; overflow:scroll;">

                        <form name="note_form" id="createNoteMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="body">

                                <div class="row clearfix">
                                    <div class="col-sm-8">
                                        <b>Opportunity Stage</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" id="note_stage" name="opportunity_stage" >
                                                    <option value="">Select Opportunity Stage</option>
                                                    @foreach($opportunityStage as $d)
                                                        <option value="{{$d->id}}">{{$d->name}}(Stage {{$d->stage}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <b>Details</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea class="form-control" name="details" placeholder="Details"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="opportunity" value="{{$mainData->id}}" />

                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button onclick="submitMediaFormReloadWithInputsCrm('createNotesModal','createNoteMainForm','<?php echo url('create_crm_notes'); ?>','reload_notes_data',
                                '<?php echo url('crm_notes'); ?>','<?php echo csrf_token(); ?>','note_stage')" type="button" class="btn btn-info waves-effect">
                            SAVE
                        </button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- ACTIVITY EDIT MODAL -->
        <div class="modal fade" id="editActivityModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                    </div>
                    <div class="modal-body" id="edit_activity_content">

                    </div>
                    <div class="modal-footer">
                        <button onclick="submitMediaFormReloadWithInputsCrm('editActivityModal','editActivityMainForm','<?php echo url('edit_crm_activity'); ?>','reload_activity_data',
                                '<?php echo url('crm_activity'); ?>','<?php echo csrf_token(); ?>','activity_stage_edit')" type="button" class="btn btn-info waves-effect">
                            SAVE
                        </button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- NOTES EDIT MODAL -->
        <div class="modal fade" id="editNotesModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                    </div>
                    <div class="modal-body" id="edit_notes_content">

                    </div>
                    <div class="modal-footer">
                        <button onclick="submitMediaFormReloadWithInputsCrm('editNotesModal','editNotesMainForm','<?php echo url('edit_crm_notes'); ?>','reload_notes_data',
                                '<?php echo url('crm_notes'); ?>','<?php echo csrf_token(); ?>','note_stage_edit')" type="button" class="btn btn-info waves-effect">
                            SAVE
                        </button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Default Size Response Form-->
        <div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Activity Feedback</h4>
                    </div>
                    <div class="modal-body" id="attach_content" style="overflow-x:scroll;">


                    </div>
                    <div class="modal-footer">
                        <button type="button"  onclick="submitMediaFormEditorReloadWithInputsCrm('attachModal','attachForm','<?php echo url('crm_activity_response'); ?>','reload_activity_data',
                                '<?php echo url('crm_activity'); ?>','<?php echo csrf_token(); ?>','feedback','request_response','feedback_stage_edit')"
                                class="btn btn-info waves-effect">
                            Respond
                        </button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Basic Example | Vertical Layout -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>{{$mainData->opportunity_name}} (Activities and Notes)</h2>
                    <ul class="header-dropdown m-r--5">

                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);"></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div id="wizard_vertical">
                        @foreach($opportunityStage as $stage)
                        <h2>{{$stage->name}} (Stage {{$stage->stage}})</h2>
                        <section>

                            <!-- #END# Tabs With Only Icon Title -->
                            <!-- Tabs With Icon Title -->
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">

                                        <div class="body">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active">
                                                    <a href="#activity_tab{{$stage->stage}}" data-toggle="tab">
                                                        <i class="material-icons">home</i> ACTIVITIES
                                                    </a>
                                                </li>
                                                <li role="presentation">
                                                    <a href="#notes_tab{{$stage->stage}}" data-toggle="tab">
                                                        <i class="material-icons">face</i> NOTES
                                                    </a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane fade in active" id="activity_tab{{$stage->stage}}">
                                                    <div class="row">
                                                        <div class="col-sm-11">
                                                            <button class="btn btn-success pull-right" data-toggle="modal" data-target="#createActivityModal"><i class="fa fa-plus"></i>Add Activity</button>

                                                        </div>
                                                    </div><hr/>

                                                <div class="body" id="reload_activity_data{{$stage->id}}">
                                                    @if(!empty($stage->stageActivity))
                                                        @foreach($stage->stageActivity as $activity)
                                                            <div class="row" id="activity{{$activity->id}}">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="card">
                                                                    <div class="header">
                                                                        <h2>
                                                                            {{$activity->subject}} <small>{{$activity->type->name}}</small>
                                                                        </h2>
                                                                        <ul class="header-dropdown m-r--5">
                                                                            <li class="dropdown">
                                                                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                                                    <i class="material-icons">more_vert</i>
                                                                                </a>
                                                                                <ul class="dropdown-menu pull-right">
                                                                                    @if(Auth::user()->id == $activity->created_by)
                                                                                    <li>
                                                                                    @if($activity->response != '')
                                                                                        <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$activity->id}}','attach_content','attachModal','<?php echo url('crm_activity_response_form') ?>','<?php echo csrf_token(); ?>')">Modify Feedback</a>
                                                                                    @else
                                                                                        <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$activity->id}}','attach_content','attachModal','<?php echo url('crm_activity_response_form') ?>','<?php echo csrf_token(); ?>')">Feedback</a>
                                                                                    @endif
                                                                                    </li>

                                                                                    <li><a style="cursor: pointer;" class="btn btn-warning" onclick="fetchHtml('{{$activity->id}}','edit_activity_content','editActivityModal','<?php echo url('edit_crm_activity_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i>Edit</a></li>

                                                                                    <li><a type="button" onclick="deleteSingleItemCrm('{{$activity->id}}','<?php echo url('delete_crm_activity'); ?>','<?php echo csrf_token(); ?>','activity{{$activity->id}}');" class="btn btn-danger">
                                                                                        <i class="fa fa-trash-o"></i>Delete
                                                                                    </a>
                                                                                    </li>
                                                                                    @endif
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="body">
                                                                        <p>{{$activity->details}}</p>
                                                                        <div class="row">
                                                                            <span class="badge bg-cyan">Due date({{$activity->due_date}})</span>
                                                                            <span class="badge bg-green">Status({{\App\Helpers\Utility::defaultStatus($activity->response_status)}})</span>
                                                                            <span class="badge bg-black">Created by({{$activity->user_c->firstname}} {{$activity->user_c->lastname}})</span>
                                                                            <span class="badge bg-blue-gray">Created at({{$activity->created_at}})</span>
                                                                            <span class="badge bg-grey">({{$activity->created_at->diffForHumans()}})</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @if(!empty($activity->response))
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="card">
                                                                    <div class="header">
                                                                        <h2>
                                                                           Feedback <small>{{$activity->type->name}}</small>
                                                                        </h2>
                                                                        <ul class="header-dropdown m-r--5">
                                                                            <li class="dropdown">
                                                                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                                                    <i class="material-icons">more_vert</i>
                                                                                </a>
                                                                                <ul class="dropdown-menu pull-right">
                                                                                    @if(Auth::user()->id == $activity->created_by)
                                                                                        <li>
                                                                                            @if($activity->response != '')
                                                                                                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$activity->id}}','attach_content','attachModal','<?php echo url('crm_activity_response_form') ?>','<?php echo csrf_token(); ?>')">Modify Feedback</a>
                                                                                            @else
                                                                                                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$activity->id}}','attach_content','attachModal','<?php echo url('crm_activity_response_form') ?>','<?php echo csrf_token(); ?>')">Feedback</a>
                                                                                            @endif
                                                                                        </li>

                                                                                    @endif
                                                                                </ul>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="body">
                                                                        <p>{!!$activity->response!!}</p>
                                                                        <div class="row">
                                                                            <span class="badge bg-black">Created by({{$activity->user_u->firstname}} {{$activity->user_u->lastname}})</span>
                                                                            <span class="badge bg-blue-gray">Updated at({{$activity->updated_at}})</span>
                                                                            <span class="badge bg-grey">({{$activity->updated_at->diffForHumans()}})</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif

                                                        </div><hr/>

                                                        @endforeach
                                                    @endif

                                                </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="notes_tab{{$stage->stage}}">
                                                    <div class="row">
                                                        <div class="col-sm-11">
                                                            <button class="btn btn-success pull-right" data-toggle="modal" data-target="#createNotesModal"><i class="fa fa-plus"></i>Add Notes</button>

                                                        </div>
                                                    </div><hr/>
                                                    <div class="body" id="reload_notes_data{{$stage->id}}">
                                                        @if(!empty($stage->stageNotes))
                                                        @foreach($stage->stageNotes as $note)
                                                            <div class="row" id="notes{{$note->id}}">
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                    <div class="card">
                                                                        <div class="header">

                                                                            <ul class="header-dropdown m-r--5">
                                                                                <li class="dropdown">
                                                                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                                                        <i class="material-icons">more_vert</i>
                                                                                    </a>
                                                                                    <ul class="dropdown-menu pull-right">
                                                                                        @if(Auth::user()->id == $note->created_by)

                                                                                            <li><a style="cursor: pointer;" onclick="fetchHtml('{{$note->id}}','edit_notes_content','editNotesModal','<?php echo url('edit_crm_notes_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a></li>

                                                                                            <li><a type="button" onclick="deleteSingleItemCrm('{{$note->id}}','<?php echo url('delete_crm_notes'); ?>','<?php echo csrf_token(); ?>','notes{{$note->id}} ');" class="btn btn-danger">
                                                                                                    <i class="fa fa-trash-o"></i>Delete
                                                                                                </a>
                                                                                            </li>
                                                                                        @endif
                                                                                    </ul>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="body">
                                                                            <p>{{$note->details}}</p>
                                                                            <div class="row">
                                                                                <span class="badge bg-black">Created by({{$note->user_c->firstname}} {{$note->user_c->lastname}})</span>
                                                                                <span class="badge bg-blue-gray">Created at({{$note->created_at}})</span>
                                                                                <span class="badge bg-grey">({{$note->created_at->diffForHumans()}})</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <!-- #END# Tabs With Icon Title -->

                        </section>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Basic Example | Vertical Layout -->

        <script>

            function submitMediaFormEditorReloadWithInputsCrm(formModal,formId,submitUrl,reload_id,reloadUrl,token,editorName,editorId,stageId){

                var form = document.forms.namedItem(formId);
                var ckInput = CKEDITOR.instances[editorId].getData();

                var postVars = new FormData(form);
                postVars.append('token',token);
                postVars.append(editorName,ckInput);

                $('#loading_modal').modal('show');
                $('#'+formModal).modal('hide');

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
                        var stage = $('#'+stageId).val();
                        var realReloadId = reload_id+stage;
                        reloadContentWithInputs(realReloadId,reloadUrl,formId);
                    }
                }

            }

            function submitMediaFormReloadWithInputsCrm(formModal,formId,submitUrl,reload_id,reloadUrl,token,stageId){
                var form_get = $('#'+formId);
                var form = document.forms.namedItem(formId);
                var postVars = new FormData(form);
                postVars.append('token',token);
                $('#loading_modal').modal('show');
                $('#'+formModal).modal('hide');

                sendRequestMediaForm(submitUrl,token,postVars);
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

                        }else if(message2 == 'token_mismatch'){

                            location.reload();

                        }else {
                            var infoMessage = swalWarningError(message2);
                            swal("Warning!", infoMessage, "warning");
                        }

                        //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                        var stage = $('#'+stageId).val();
                        var realReloadId = reload_id+stage;
                        reloadContentWithInputs(realReloadId,reloadUrl,formId);
                    }
                }

            }

            function deleteSingleItemCrm(dataId,submitUrl,token,stageId) {

                swal({
                            title: "Are you sure you want to delete?",
                            text: "You will not be able to recover this data entry!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Yes, delete it!",
                            cancelButtonText: "No, cancel delete!",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                deleteSingleEntryCrm(dataId, submitUrl, token);

                                if(stageId != ''){
                                    $('#'+stageId).remove();
                                }

                            } else {
                                swal("Delete Cancelled", "Your data is safe :)", "error");
                            }
                        });

            }

            function deleteSingleEntryCrm(dataId,submitUrl,token){
                var postVars = "dataId="+dataId;
                $('#loading_modal').modal('show');
                sendRequestForm(submitUrl,token,postVars)
                ajax.onreadystatechange = function(){
                    if(ajax.readyState == 4 && ajax.status == 200) {
                        $('#loading_modal').modal('hide');
                        var rollback = JSON.parse(ajax.responseText);
                        var message2 = rollback.message2;
                        if(message2 == 'fail'){

                            //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                            var serverError = phpValidationError(rollback.message);

                            var messageError = swalDefaultError(serverError);
                            swal("Error",messageError, "error");

                        }else if(message2 == 'deleted'){

                            var successMessage = swalSuccess(rollback.message);
                            swal("Success!", successMessage, "success");

                        }else{

                            var infoMessage = swalWarningError(message2);
                            swal("Success!", infoMessage, "warning");

                        }

                        //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

                    }
                }


            }

        </script>


    @endsection