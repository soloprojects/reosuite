@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Job Post</h4>
                </div>
                <div class="modal-body" style="height:500px; overflow:scroll;">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="job_title" placeholder="Job Title">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="job_type" >
                                                <option value="Temporary">Temporary</option>
                                                <option value="Permanent">Permanent</option>
                                                <option value="Contract">Contract</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="job_status" >
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control ckeditor" id="job_purpose" name="job_purpose" placeholder="Job Purpose">Job Purpose</textarea>
                                            <script>
                                                CKEDITOR.replace('job_purpose');
                                                CKEDITOR.config.height = 70;     // 500 pixels tall.
                                            </script>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control ckeditor" id="job_desc" name="job_desc" placeholder="Job Description" >Job Description</textarea>
                                            <script>
                                                CKEDITOR.replace('job_desc');
                                                CKEDITOR.config.height = 70;     // 500 pixels tall.
                                            </script>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control ckeditor" id="job_spec" name="job_spec" placeholder="Job Specification">Job Specification</textarea>
                                            <script>
                                                CKEDITOR.replace('job_spec');
                                                CKEDITOR.config.height = 70;     // 500 pixels tall.
                                            </script>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control" name="location" placeholder="Job Location"></textarea>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="salary_range" placeholder="Salary Range">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="experience" >
                                                <option value="0">Select Experience</option>
                                                @for($i=0;$i<30;$i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaFormJob('createModal','createMainForm','<?php echo url('create_jobs'); ?>','reload_data',
                            '<?php echo url('jobs'); ?>','<?php echo csrf_token(); ?>','job_purpose','job_desc','job_spec')"
                            type="button" class="btn btn-info waves-effect">
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
                <div class="modal-body" id="edit_content" style="height:500px; overflow:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaFormJob('editModal','editMainForm','<?php echo url('edit_jobs'); ?>','reload_data',
                            '<?php echo url('jobs'); ?>','<?php echo csrf_token(); ?>','job_purpose_edit','job_desc_edit','job_spec_edit')"
                            class="btn btn-info waves-effect">
                        SAVE CHANGES
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
                        Jobs
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="changeItemStatus('kid_checkbox','reload_data','<?php echo url('jobs'); ?>',
                                    '<?php echo url('change_jobs_status'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Activate Job
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeItemStatus('kid_checkbox','reload_data','<?php echo url('jobs'); ?>',
                                    '<?php echo url('change_jobs_status'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Deactivate Job
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('jobs'); ?>',
                                    '<?php echo url('delete_jobs'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                <div class="body table-responsive" id="reload_data">
                    <h5>Job Application Page Url -- {{url('OByxRFDeOtxHYxnTTfJmSukkJZ7aCY/positions/2y101HS5A2C30Nex/available')}}</h5>
                    <hr/>
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Job Title</th>
                            <th>Applicants</th>
                            <th>Job Type</th>
                            <th>Job Status</th>
                            <th>Location</th>
                            <th>Salary Range</th>
                            <th>Experience</th>
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
                            <td>{{$data->job_title}}</td>
                            <td><a href="{{url('job_item/'.$data->id)}}">View Applicants</a></td>
                            <td>{{$data->job_type}}</td>
                            <td class="{{\App\Helpers\Utility::statusDisplayIndicator($data->job_status)}}">{{\App\Helpers\Utility::statusDisplay($data->job_status)}}</td>
                            <td>{{$data->location}}</td>
                            <td>{{$data->salary_range}}</td>
                            <td>{{$data->experience}} yrs</td>

                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_jobs_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
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
    /*==================== PAGINATION =========================*/
    function submitMediaFormJob(formModal,formId,submitUrl,reload_id,reloadUrl,token,purpose,desc,spec){
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);
        var postVars = new FormData(form);
        var purposeVal = encodeURIComponent(CKEDITOR.instances[purpose].getData());
        var descVal = encodeURIComponent(CKEDITOR.instances[desc].getData());
        var specVal = encodeURIComponent(CKEDITOR.instances[spec].getData());
        postVars.append('job_purpose',purposeVal);
        postVars.append('job_desc',descVal);
        postVars.append('job_spec',specVal);
        postVars.append('token',token);
        
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