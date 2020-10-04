@extends('layouts.app')

@section('content')


    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Requisition</h4>
                </div>
                <div class="modal-body">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea type="text" class="form-control" name="request_description" placeholder="Request Description"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" name="request_category" >
                                                <option value="">Request Category</option>
                                                @foreach($reqCat as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->request_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" onchange="checkProject('request_type','project_id');" id="request_type" name="request_type" >
                                                <option value="">Request Type</option>
                                                @foreach($reqType as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->request_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>



                            </div>

                            <div class="row clear-fix">

                                <div class="col-sm-4" id="project_id" style="display:none;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control"  id="" name="project" >
                                                <option value="">Select Project</option>
                                                @foreach($project as $ap)
                                                    <option value="{{$ap->project->id}}">{{$ap->project->project_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="amount" placeholder="Amount">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" multiple="multiple" class="form-control" name="attachment[]" placeholder="Attachment">
                                        </div>
                                    </div>
                                </div>
                                @if($access == \App\Helpers\Utility::DETECT)
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select User">

                                                <input type="hidden" class="user_class" name="user" id="user" />
                                            </div>
                                        </div>
                                        <ul id="myUL1" class="myUL"></ul>
                                    </div>
                                @else
                                    <input type="hidden"  name="user" />
                                @endif


                            </div>

                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_requisition'); ?>','reload_data',
                            '<?php echo url('requisition'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
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
                    <h4 class="modal-title" id="defaultModalLabel">Attachment</h4>
                </div>
                <div class="modal-body" id="attach_content">


                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('edit_attachment'); ?>','reload_data',
                            '<?php echo url('requisition'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_requisition'); ?>','reload_data',
                            '<?php echo url('requisition'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Transact Default Size -->
    @include('includes.print_preview')


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Requisition
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('requisition'); ?>',
                                    '<?php echo url('delete_requisition'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Manage</th>
                            <th>Attachment</th>
                            <th>Preview</th>
                            <th>Description</th>
                            <th>Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Approval Status</th>
                            <th>Finance Status</th>
                            <th>Approved by</th>
                            <th>Edited</th>
                            <th>Request Category</th>
                            <th>Request Type</th>
                            <th>Project Category</th>
                            <th>Requested by</th>
                            <th>Department</th>
                            <th>Created by</th>
                            <th>Updated by</th>
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
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_requisition_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <td>
                                @if($data->finance_status == \App\Helpers\Utility::STATUS_ACTIVE)
                                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('request_print_preview') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o"></i>Preview</a>
                                @endif
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->req_desc}}</td>
                            <td>{{Utility::numberFormat($data->amount)}}</td>
                            <td class="{{\App\Helpers\Utility::statusIndicator($data->approval_status)}}">
                                @if($data->approval_status === 1)
                                    Request Approved
                                @endif
                                @if($data->approval_status === 0)
                                    Processing Request
                                @endif
                                @if($data->approval_status === 2)
                                    Request Denied
                                @endif
                            </td>
                            <td>
                                @if($data->finance_status === 0)
                                    Processing
                                @endif
                                @if($data->finance_status === 1)
                                    Complete and Ready for Print
                                @endif
                            </td>
                            <td>
                                @if($data->approved_users != '')
                                    <table class="table table-bordered table-responsive">
                                        <thead>
                                        <th>Name</th>
                                        <th>Reason</th>
                                        </thead>
                                        <tbody>
                                        @foreach($data->approved_by as $users)
                                            <tr>
                                                <td>{{$users->firstname}} &nbsp; {{$users->lastname}}</td>
                                                <td>Approved</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            @if($data->deny_reason != '')
                                                <td>{{$data->denyUser->firstname}} &nbsp; {{$data->denyUser->lastname}}</td>
                                                <td>Denied: {{$data->deny_reason}}</td>
                                            @endif
                                        </tr>
                                        </tbody>
                                    </table>
                                @else
                                    @if($data->approval_status === 1)
                                        Management
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($data->edit_request != '')
                                    <?php $edited = json_decode($data->edit_request,true); ?>
                                    @foreach($edited as $key => $val)
                                        {{$key}} : {{$val}}<br>
                                    @endforeach
                                @endif
                            </td>
                            <td>{{$data->requestCat->request_name}}</td>
                            <td>{{$data->requestType->request_type}}</td>
                            <td>
                                @if($data->proj_id != 0)
                                {{$data->project->project_name}}
                                @endif
                            </td>
                            <td>{{$data->requestUser->firstname}} &nbsp; {{$data->requestUser->lastname}}</td>
                            <td>{{$data->department->dept_name}}</td>
                            <td>
                                @if($data->created_by != '0')
                                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                @endif
                            </td>
                            <td>
                                @if($data->updated_by != '0')
                                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                                @endif
                            </td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->updated_at}}</td>
                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

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

    function checkProject(reqType_id,project_id){
        var projId = $('#'+project_id);
        var reqValue = $('#'+reqType_id).val();
        if(reqValue == 1){
            projId.hide();
        }
        if(reqValue == 2){
            projId.show();
        }
        if(reqValue == ''){
            projId.hide();
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

@endsection