@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="letterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Cover Letter</h4>
                </div>
                <div class="modal-body" id="letter_content">

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
                        Filter Job Applicants
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button type="button" onclick="deleteSearchItems('kid_checkbox','reload_data','',
                                    '<?php echo url('delete_applicants'); ?>','<?php echo csrf_token(); ?>','search_applicants');" class="btn btn-danger">
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

                <div class="container body">
                    <form name="import_excel" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

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
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-3" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick"   name="job" data-selected-text-format="count">
                                                <option value="">Select Job</option>
                                                @foreach($mainData as $job)
                                                    <option value="{{$job->id}}">{{$job->job_title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick"   name="department" data-selected-text-format="count">
                                                <option value="">Select Department (not compulsory)</option>
                                                @foreach($department as $de)
                                                    <option value="{{$de->id}}">{{$de->dept_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="experience" >
                                                <option value="">Select Experience</option>
                                                {{-- <option value="00">All Experience</option> --}}
                                                @for($i=0;$i<30;$i++)
                                                    <option value="{{$i}}">{{$i}} yr(s)</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clear-fix">

                                <div class="col-sm-12" id="" style="">
                                    <div class="form-group">
                                        <button id="search_applicants" class="btn btn-info col-sm-8" type="button" onclick="searchJobReport('searchMainForm','<?php echo url('search_job_applicants'); ?>','reload_data',
                                                '<?php echo url('applicants') ?>','<?php echo csrf_token(); ?>','start_date','end_date')">Search</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>


                </div>

                <div class="body table-responsive tbl_scroll" id="reload_data">

                </div>


            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    function deleteSearchItems(klass,reloadId,reloadUrl,submitUrl,token,searchButtonId) {
        var items = group_val(klass);
        if (items.length > 0){
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
                            deleteSearchEntry(klass, reloadId, reloadUrl, submitUrl, token,searchButtonId);

                            //swal("Deleted!", "Your item(s) has been deleted.", "success");

                            //butId.trigger('click');
                        } else {
                            swal("Delete Cancelled", "Your data is safe :)", "error");
                        }
                    });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function deleteSearchEntry(klass,reloadId,reloadUrl,submitUrl,token,searchButtonId){
        var data_string = group_val(klass);
        var all_data = JSON.stringify(data_string);
        var postVars = "all_data="+all_data;
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

                    var messageError = swalDefaultError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'deleted'){
                    var successMessage = swalSuccess(rollback.message);
                    swal("Success!", successMessage, "success");
                    var butId = $('#'+searchButtonId);

                    butId.trigger('click');

                }else{

                    var infoMessage = swalWarningError(message2);
                    swal("Success!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                if(reloadUrl != '') {
                    reloadContent(reloadId, reloadUrl);
                }
            }
        }


    }

    function viewLetter(modalId,divId,letter){
        $('#'+modalId).modal('show');
        $('#'+divId).html(letter);
    }

    function searchJobReport(formId,submitUrl,reload_id,reloadUrl,token,fromId,toId){

        var from = $('#'+fromId).val();
        var to = $('#'+toId).val();

        var inputVars = $('#'+formId).serialize();

        if(from != '' && to !=''){

            var postVars = inputVars;
            $('#loading_modal').modal('show');
            sendRequestForm(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {

                    $('#loading_modal').modal('hide');
                    var result = ajax.responseText;
                    $('#'+reload_id).html(result);

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

                }
            }

        }else{
            swal("warning!", "Please ensure to select start and end date.", "warning");

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