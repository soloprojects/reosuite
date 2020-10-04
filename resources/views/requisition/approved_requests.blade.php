@extends('layouts.app')

@section('content')

    <!-- Print Transact Default Size -->
    @include('includes.print_preview')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Requisition Report
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

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="from_date" name="from_date" placeholder="From e.g 2019-02-22">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="to_date" name="to_date" placeholder="To e.g 2019-04-21">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick" multiple name="request_category[]" data-selected-text-format="count">
                                                <option value="">Request Category</option>
                                                <option value="0">All Category</option>
                                                @foreach($reqCat as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->request_name}}({{$ap->department->dept_name}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick" onchange="checkProject('request_type','project_id');" id="request_type" name="request_type" data-selected-text-format="count">
                                                   <option value="0">All Types</option>
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
                                            <select  class="form-control show-tick" multiple  id="" name="project[]" data-selected-text-format="count">
                                                <option value="0">All Project</option>
                                                @foreach($project as $ap)
                                                    <option value="{{$ap->project->id}}">{{$ap->project->project_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @if(in_array(Auth::user()->role,\App\Helpers\Utility::ACCOUNT_MANAGEMENT))
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
                                    <input type="hidden" value="{{Auth::user()->id}}"  name="user" id="user" />
                                @endif


                            </div>

                            <div class="row clear-fix">
                                @if((in_array(Auth::user()->role,\App\Helpers\Utility::ACCOUNT_MANAGEMENT) && $detectHod != \App\Helpers\Utility::HOD_DETECTOR) || (in_array(Auth::user()->role,\App\Helpers\Utility::ACCOUNT_MANAGEMENT) && $detectHod == \App\Helpers\Utility::HOD_DETECTOR))
                                    <div class="col-sm-4" id="" style="">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select  class="form-control show-tick" multiple id="department" name="department[]" data-selected-text-format="count">
                                                    <option value="0">All Department</option>
                                                    @foreach($dept as $ap)
                                                        <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($detectHod == \App\Helpers\Utility::HOD_DETECTOR && !in_array(Auth::user()->role,\App\Helpers\Utility::ACCOUNT_MANAGEMENT))
                                    <input type="hidden" name="department" id="department" multiple value="{{Auth::user()->dept_id}}" />
                                @endif

                                    @if($detectHod != \App\Helpers\Utility::HOD_DETECTOR && !in_array(Auth::user()->role,\App\Helpers\Utility::ACCOUNT_MANAGEMENT))
                                        <input type="hidden" name="department" id="department" multiple value="" />
                                    @endif

                                <div class="col-sm-4" id="" style="">
                                    <div class="form-group">
                                        <button class="btn btn-info" type="button" onclick="searchReportRequest('searchMainForm','<?php echo url('table_request_report'); ?>','reload_data',
                                                '<?php echo url('approved_requests'); ?>','<?php echo csrf_token(); ?>','from_date','to_date')">Search</button>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <input type="hidden" value="table" name="report_type" />


                    </form>


                </div>
                <div class="body table-responsive tbl_scroll" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            {{--<th>Manage</th>--}}
                            <th>Preview</th>
                            <th>Description</th>
                            <th>Edited</th>
                            <th>Request Category</th>
                            <th>Request Type</th>
                            <th>Project Category</th>
                            <th>Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Requested by</th>
                            <th>Department</th>
                            <th>Approval Status</th>
                            <th>Approved by</th>
                            <th>Created by</th>
                            <th>Updated by</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)

                            @if($data->complete_status == 1)
                                @if($data->deny_reason == '')
                            <tr>
                                <td scope="row">
                                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                </td>
                                <td>
                                    @if($data->finance_status == \App\Helpers\Utility::STATUS_ACTIVE)
                                        <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('request_print_preview') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o"></i>Preview</a>
                                    @endif
                                </td>
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>{{$data->req_desc}}</td>
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
                                <td>{{Utility::numberFormat($data->amount)}}</td>
                                <td>{{$data->requestUser->firstname}} &nbsp; {{$data->requestUser->lastname}}</td>
                                <td>{{$data->department->dept_id}}</td>
                                <td>
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
                            @endif
                          @endif
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

        function searchReportRequest(formId,submitUrl,reload_id,reloadUrl,token,fromId,toId){

            var from = $('#'+fromId).val();
            var to = $('#'+toId).val();

            var inputVars = $('#'+formId).serialize();

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
                swal("warning!", "Please ensure to select start and end date, user/department.", "warning");

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