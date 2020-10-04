@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Create New Ticket</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body container">

                            <div class="row clearfix">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control " name="subject" placeholder="Subject ">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" name="ticket_category" >
                                                <option value="">Ticket Category</option>
                                                @foreach($ticketCat as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->request_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">

                                <div class="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea type="text" id="details" class="form-control " name="details" placeholder="Details">Enter ticket details</textarea>
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
                    <button onclick="submitMediaFormRequest('createModal','createMainForm','<?php echo url('create_help_desk_ticket'); ?>','reload_data',
                            '<?php echo url('help_desk_ticket'); ?>','<?php echo csrf_token(); ?>','details')" type="button" class="btn btn-link waves-effect">
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
                    <button onclick="submitMediaFormRequest('editModal','editMainForm','<?php echo url('edit_help_desk_ticket'); ?>','reload_data',
                            '<?php echo url('help_desk_ticket'); ?>','<?php echo csrf_token(); ?>','request_details_edit')" type="button" class="btn btn-link waves-effect">
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
                    <h4 class="modal-title" id="defaultModalLabel">Respond to ticket</h4>
                </div>
                <div class="modal-body" id="attach_content">


                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaFormRequest('attachModal','attachForm','<?php echo url('help_desk_ticket_response'); ?>','reload_data',
                            '<?php echo url('help_desk_ticket'); ?>','<?php echo csrf_token(); ?>','request_response')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Feedback</h4>
                </div>
                <div class="modal-body" id="feedback">
                    <form name="feed_form" id="feedbackForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control" name="feedback" placeholder="Enter your feedback"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <input type="hidden" name="request_id" id="request_id" value="" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('feedbackModal','feedbackForm','<?php echo url('feedback_ticket'); ?>','reload_data',
                            '<?php echo url('help_desk_ticket'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
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
                        My Ticket(s)
                    </h2>
                    <ul class="header-dropdown m-r--5">

                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Open Ticket</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('help_desk_ticket'); ?>',
                                    '<?php echo url('delete_help_desk_ticket'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                            <th>Feedback</th>
                            <th>Ticket Category</th>
                            <th>Full Name</th>
                            <th>Department</th>
                            <th>Response Rate</th>
                            <th>subject</th>
                            <th>Details</th>
                            <th>Response</th>
                            <th>Response Status</th>
                            <th>Response Dates</th>
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
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_help_desk_ticket_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                <td>
                                    @if(empty($data->feedback) && $data->response_status == 1)
                                        <a style="cursor: pointer;" class="btn btn-info" onclick="fetchModal('{{$data->id}}','request_id','feedbackModal')"><i class="fa fa-pencil-square-o"></i>Feedback</a>
                                    @else
                                        {{$data->feedback}}
                                    @endif
                                </td>
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>{{$data->ticketCategory->request_name}}</td>
                                <td>
                                    {{$data->reqUser->firstname}}&nbsp;{{$data->reqUser->lastname}}

                                </td>
                                <td>{{$data->department->dept_name}}</td>
                                <td>{{$data->response_rate}}</td>
                                <td>{{$data->subject}}</td>
                                <td>{!!$data->details!!}</td>
                                <td>{!!$data->response!!}</td>
                                <td class="{{\App\Helpers\Utility::statusIndicator($data->response_status)}}">{{\App\Helpers\Utility::defaultStatus($data->response_status)}}</td>
                                <td>{{$data->response_dates}}</td>
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
            postVars.append('ckInput',ckInput);

           
            $('#'+formModal).modal('hide');
            //DISPLAY LOADING ICON
            overlayBody('block');
            
            sendRequestMediaForm(submitUrl,token,postVars)
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