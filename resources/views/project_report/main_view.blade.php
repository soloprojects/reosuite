@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Project Report
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
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="start_date" name="start_date" placeholder="From e.g 2019-02-22">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="end_date" name="end_date" placeholder="To e.g 2019-04-21">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick" id="project_id" name="project" data-selected-text-format="count">
                                                   <option value="0">Select Project</option>
                                                @foreach($mainData as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->project_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-3" id="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick"  onchange="checkPriority('report_type','priority');" id="report_type" name="report_type" data-selected-text-format="count">
                                                <option value="">Select Type</option>
                                                <option value="milestone">Milestone</option>
                                                {{--<option value="task_list">Task List</option>--}}
                                                <option value="task">Task</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3" id="priority" style="display:none;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick" id="" name="priority" data-selected-text-format="count">
                                                <option value="">Select Priority</option>
                                                @foreach(\App\Helpers\Utility::TASK_PRIORITY as $task)
                                                    <option value="{{$task}}">{{$task}}</option>
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
                                                @foreach(\App\Helpers\Utility::TASK_STATUS as $key => $var)
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
                                        <button class="btn btn-info col-sm-8" type="button" onclick="searchReportRequest('searchMainForm','<?php echo url('search_project_report'); ?>','reload_data',
                                                '<?php echo url('project_report'); ?>','<?php echo csrf_token(); ?>','start_date','end_date','project_id')">Search</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>


                </div>
                <div class="body table-responsive" id="reload_data">

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

    <script>

        function checkPriority(reqType_id,priority){
            var projId = $('#'+priority);
            var reqValue = $('#'+reqType_id).val();
            if(reqValue == 'milestone'){
                projId.hide();
            }
            if(reqValue == 'task_list'){
                projId.hide();
            }
            if(reqValue == 'task'){
                projId.show();
            }
            if(reqValue == ''){
                projId.hide();
            }

        }

        function searchReportRequest(formId,submitUrl,reload_id,reloadUrl,token,fromId,toId,projId){

            var from = $('#'+fromId).val();
            var to = $('#'+toId).val();
            var proj = $('#'+projId).val();

            var inputVars = $('#'+formId).serialize();
            //alert(inputVars);
            if(from != '' && to !='' && proj !=''){

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
                swal("warning!", "Please ensure to select start, end date and project.", "warning");

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