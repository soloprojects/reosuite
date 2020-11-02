@extends('layouts.app')

@section('content')

    <!-- Default Size Response Form-->
    <div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Respond to ticket</h4>
                </div>
                <div class="modal-body" id="attach_content" style="overflow-x:scroll;">


                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaFormRequest('attachModal','attachForm','<?php echo url('help_desk_ticket_response'); ?>','reload_data',
                            '<?php echo url('all_help_desk_ticket'); ?>','<?php echo csrf_token(); ?>','request_response','search_help_desk_button')"
                            class="btn btn-link waves-effect">
                        Respond
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
                        Help Desk Report
                    </h2>
                    <ul class="header-dropdown m-r--5">

                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>Export
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

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick" id="" name="ticket_category" data-selected-text-format="count">
                                                   <option value="">Select Ticket Category</option>
                                                @foreach($ticketCat as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->request_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-3" id="department" >
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick" id="" name="department" data-selected-text-format="count">
                                                <option value="">Select Department</option>
                                                @foreach($dept as $val)
                                                    <option value="{{$val->id}}">{{$val->dept_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick"  id="" name="status" data-selected-text-format="count">
                                                <option value="">Select Status</option>
                                                @foreach(\App\Helpers\Utility::TICKET_STATUS as $key => $var)
                                                    <option value="{{$key}}">{{$var}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clear-fix">

                                <div class="col-sm-12" id="" style="">
                                    <div class="form-group">
                                        <button class="btn btn-info col-sm-8" type="button" onclick="searchReportRequest('searchMainForm','<?php echo url('search_help_desk_ticket'); ?>','reload_data',
                                                '<?php echo url('help_desk_ticket'); ?>','<?php echo csrf_token(); ?>','start_date','end_date')" id="search_help_desk_button">Search</button>
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

        function searchReportRequest(formId,submitUrl,reload_id,reloadUrl,token,fromId,toId){

            var from = $('#'+fromId).val();
            var to = $('#'+toId).val();

            var inputVars = $('#'+formId).serialize();
            //alert(inputVars);
            if(from != '' && to !=''){

                var summerNote = '';
                var htmlClass = document.getElementsByClassName('t-editor');
                if (htmlClass.length > 0) {
                    summerNote = $('.summernote').eq(0).summernote('code');;
                }
                var postVars = inputVars+'&editor_input='+summerNote;
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
                swal("warning!", "Please ensure to select from, to date.", "warning");

            }




        }

        //SUBMIT FORM WITH A FILE
        function submitMediaFormRequest(formModal,formId,submitUrl,reload_id,reloadUrl,token,editorId,searchButtonId){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            var ckInput = CKEDITOR.instances[editorId].getData();

            var postVars = new FormData(form);
            postVars.append('token',token);
            postVars.append('response',ckInput);

            //$('#loading_modal').modal('show');
            $('#'+formModal).modal('hide');
            /*$('#'+formModal).on("hidden.bs.modal", function () {
             $('#edit_content').html('');
             });*/
            sendRequestMediaForm(submitUrl,token,postVars)
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
                        swal("Success!", successMessage, "success");

                        //location.reload();

                    }else{

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");
                        var butId = $('#'+searchButtonId);
                        butId.trigger('click');

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    //reloadContent(reload_id,reloadUrl);
                }
            }

        }

    </script>

    <script>
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

    <script type="text/javascript">
        /*$(document).ready(function() {
            $('#departmenta').multiselect({
                includeSelectAllOption: true,
                enableFiltering: true
            });
        });*/
    </script>

@endsection