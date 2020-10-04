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
                        Admin Request Report (Chart Representation)
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
                                        <button class="btn btn-info" type="button" onclick="searchReportRequest('searchMainForm','<?php echo url('table_admin_request_report'); ?>','reload_data',
                                                '<?php echo url('admin_approved_requests'); ?>','<?php echo csrf_token(); ?>','from_date','to_date')">Search</button>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <input type="hidden" value="chart" name="report_type" />


                    </form>


                </div>

                <div class="" id="reload_data">

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

    <script>
        $(document).ready(function() {
            $('table.highchart').highchartTable();
        });
    </script>

@endsection