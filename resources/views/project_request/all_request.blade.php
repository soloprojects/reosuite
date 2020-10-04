@extends('layouts.app')

@section('content')

    <!-- Default Size Response Form-->
    <div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Respond to request</h4>
                </div>
                <div class="modal-body" id="attach_content" style="overflow-x:scroll;">


                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaFormRequest('attachModal','attachForm','<?php echo url('project_request_response'); ?>','reload_data',
                            '<?php echo url('project/'.$item->id.'/all_request'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>','request_response')"
                            class="btn btn-link waves-effect">
                        Respond
                    </button>
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
                                                        All Project Request(s)
                                                    </h2>
                                                    <ul class="header-dropdown m-r--5">
                                                        @if(in_array(\App\Helpers\Utility::checkAuth('temp_user')->role,\App\Helpers\Utility::TOP_USERS))
                                                        <li>
                                                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('project/'.$item->id.'/all_request'.\App\Helpers\Utility::authLink('temp_user')); ?>',
                                                                    '<?php echo url('delete_project_request'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                                                <i class="fa fa-trash-o"></i>Delete
                                                            </button>
                                                        </li>
                                                        @endif
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

                                                            <th>Manage Response</th>
                                                            <th>Project</th>
                                                            <th>Requested By</th>
                                                            <th>Subject</th>
                                                            <th>Request Details</th>
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
                                                                    @if($data->response != '')
                                                                    <a style="cursor: pointer;" class="btn btn-primary" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('project_request_response_form') ?>','<?php echo csrf_token(); ?>')">Respond Again</a>
                                                                    @else
                                                                        <a style="cursor: pointer;" class="btn btn-primary" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('project_request_response_form') ?>','<?php echo csrf_token(); ?>')">Respond</a>
                                                                    @endif
                                                                </td>
                                                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                                                <td>{{$data->project->project_name}}</td>
                                                                <td>
                                                                    @if(!empty($data->assigned_user))
                                                                        {{$data->assignee->firstname}}&nbsp;{{$data->assignee->lastname}}
                                                                    @else
                                                                        {{$data->extUser->firstname}}&nbsp;{{$data->extUser->lastname}}
                                                                    @endif
                                                                </td>
                                                                <td>{{$data->subject}}</td>
                                                                <td>{!!$data->details!!}</td>
                                                                <td>
                                                                    @if($data->response == '')
                                                                        @if(($data->assigned_user != Utility::checkAuth('temp_user')->id && !empty($data->assigned_user)) || ($data->temp_user != Utility::checkAuth('temp_user')->id && !empty($data->temp_user)) )
                                                                            <a style="cursor: pointer;" class="btn btn-primary" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('project_request_response_form') ?>','<?php echo csrf_token(); ?>')">Respond</a>
                                                                        @endif
                                                                    @else
                                                                        {!!$data->response!!}
                                                                    @endif
                                                                </td>
                                                                <td class="{{\App\Helpers\Utility::statusIndicator($data->response_status)}}">
                                                                    {{\App\Helpers\Utility::defaultStatus($data->response_status)}}
                                                                </td>
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
