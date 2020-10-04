@extends('layouts.app')

@section('content')

    <div class="modal fade" id="textModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Print Preview</h4>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown pull-right">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>Export
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'print_text_data', $exportDocId = 'print_text_data'])
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="modal-body" id="text_preview" style="height:450px; overflow-y:scroll;">

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
                        Test Result
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>

                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a class="btn bg-blue-grey waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-print"></i>Print</a></li>
                                <li><a class="btn bg-red waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-file-pdf-o"></i>Pdf</a></li>
                                <li><a class="btn btn-warning" onClick ="$('#main_table').tableExport({type:'excel',escape:'false'});" ><i class="fa fa-file-excel-o"></i>Excel</a></li>
                                <li><a class="btn  bg-light-green waves-effect" onClick ="$('#main_table').tableExport({type:'csv',escape:'false'});" ><i class="fa fa-file-o"></i>CSV</a></li>
                                <li><a class="btn btn-info" onClick ="$('#main_table').tableExport({type:'doc',escape:'false'});" ><i class="fa fa-file-word-o"></i>Msword</a></li>

                            </ul>
                        </li>

                    </ul>
                </div>
                <div class="body row">
                    <form name="import_excel" id="searchTestForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control" id="" name="session">
                                        <option value="">Select Session</option>
                                        @foreach($mainData as $cat)
                                            <option value="{{$cat->id}}">{{$cat->session_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3" >
                            <div class="form-group">
                                <div class="form-line" >
                                    <select class="form-control " name="participant" >
                                        <option value="">Select Participants</option>
                                        <option value="internal">Internal Participants</option>
                                        <option value="external">External Participants</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control datepicker" autocomplete="off" id="from_date" name="from_date" placeholder="From e.g 2019-02-22">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control datepicker" autocomplete="off" id="to_date" name="to_date" placeholder="To e.g 2019-04-21">
                                </div>
                            </div>
                        </div>


                    </form>

                    <button onclick="searchReport('searchTestForm','<?php echo url('search_test_result'); ?>','reload_data',
                            '<?php echo url('test_result'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        Search Test Session
                    </button>
                </div>

                <div class="body table-responsive" id="reload_data">



                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    function submitQuestDefault(questId,formId,submitUrl,reload_id,reloadUrl,token){
        var inputVars = $('#'+formId).serialize();
        var quest = CKEDITOR.instances[questId].getData();
        var postVars = inputVars+'&question='+quest;
        //alert(postVars);
        //$('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                //$('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){

                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", "Data saved successfully!", "success");

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                searchReport(formId,'<?php echo url('search_survey_question'); ?>','reload_data','<?php echo url('survey_question'); ?>','<?php echo csrf_token(); ?>');
            }
        }

    }

    function submitQuestDefaultEdit(questId,formId,submitUrl,reload_id,reloadUrl,token){
        var inputVars = $('#'+formId).serialize();
        var quest = CKEDITOR.instances[questId].getData();
        var postVars = inputVars+'&question='+quest;
        //alert(postVars);
        //$('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                //$('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){

                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", "Data saved successfully!", "success");

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

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