@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Create New Report</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body container">

                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" name="report_type" >
                                                <option value="">Report Type</option>
                                                @foreach(\App\Helpers\Utility::HSE_REPORT_TYPE as $key => $var)
                                                    <option value="{{$key}}">{{$var}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" name="source_type" >
                                                <option value="">Source Type</option>
                                                @foreach($sourceType as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->source_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="location" placeholder="Location">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="occurrence_date" placeholder="Date of occurrence">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea type="text" id="details" class="form-control " name="details" placeholder="Details">Enter report details</textarea>
                                            <script>
                                                CKEDITOR.replace('details');
                                            </script>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaFormRequest('createModal','createMainForm','<?php echo url('create_hse_report'); ?>','reload_data',
                            '<?php echo url('hse_report'); ?>','<?php echo csrf_token(); ?>','details')" type="button" class="btn btn-link waves-effect">
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
                <div class="modal-body" id="edit_content" style="overflow-x:scroll;">

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaFormRequest('editModal','editMainForm','<?php echo url('edit_hse_report'); ?>','reload_data',
                            '<?php echo url('hse_report'); ?>','<?php echo csrf_token(); ?>','details_edit')" type="button" class="btn btn-link waves-effect">
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
                    <h4 class="modal-title" id="defaultModalLabel">Respond to Report</h4>
                </div>
                <div class="modal-body" id="attach_content">


                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaFormRequest('attachModal','attachForm','<?php echo url('hse_report_response'); ?>','reload_data',
                            '<?php echo url('hse_report'); ?>','<?php echo csrf_token(); ?>','hse_response')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="detail_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Report</h4>
                    @include('includes/print_pdf',[$exportId = 'print_preview_data', $exportDocId = 'print_preview_data'])

                </div>
                <div class="modal-body" id="detail_id" style="height:450px; overflow:scroll;">


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
                        Incident/Hazard Report
                    </h2>
                    <ul class="header-dropdown m-r--5">

                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('hse_report'); ?>',
                                    '<?php echo url('delete_hse_report'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                <div class="body table-responsive tbl_scroll" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Manage</th>
                            <th>View Report</th>
                            <th>Source Type</th>
                            <th>Full Name</th>
                            <th>Report Type</th>
                            <th>Location</th>
                            <th>Date of Occurrence</th>
                            <th>Report Detail</th>
                            <th>Response</th>
                            <th>Response Status</th>
                            <th>Response from</th>
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
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_hse_report_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                <td>
                                    <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','detail_id','detail_modal','<?php echo url('fetch_hse_report') ?>','{{csrf_token()}}')">View/Export</a>
                                </td>

                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>{{$data->source->source_name}}</td>
                                <td>
                                    {{$data->user_c->firstname}}&nbsp;{{$data->user_c->lastname}}

                                </td>
                                <td>{{\App\Helpers\Utility::hseReportType($data->report_type)}}</td>
                                <td>{{$data->location}}</td>
                                <td>{{$data->report_date}}</td>
                                <td>{!!$data->report_details!!}</td>
                                <td>{!!$data->response!!}</td>
                                <td class="{{\App\Helpers\Utility::statusIndicator($data->response_status)}}">{{\App\Helpers\Utility::defaultStatus($data->response_status)}}</td>
                                <td>{{$data->user_u->updated_by}}</td>
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



    <script>

        //SUBMIT FORM WITH A FILE
        function submitMediaFormRequest(formModal,formId,submitUrl,reload_id,reloadUrl,token,editorId){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            var ckInput = CKEDITOR.instances[editorId].getData();

            var postVars = new FormData(form);
            postVars.append('token',token);
            postVars.append('detail',ckInput);

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

        /*==================== PAGINATION =========================*/

        $(window).on('hashchange',function(){
            //page = window.location.hash.replace('#','');
            //getProducts(page);
        });

        /*$(document).on('click','#task .pagination a', function(e){
         e.preventDefault();
         var page = $(this).attr('href').split('page=')[1];
         getProducts(page);
         location.hash = page;
         });*/

        function getProducts(page){

            $.ajax({
                url: '?page=' + page
            }).done(function(data){
                $('#reload_data').html(data);
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