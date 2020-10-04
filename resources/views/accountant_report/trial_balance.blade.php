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
                        Trial Balance Report
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
                                            <select  class="form-control show-tick" name="financial_year[]" multiple id="fin_year" data-selected-text-format="count">
                                                <option value="">Financial/Fiscal Year</option>
                                                @foreach($finYear as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->fin_name}}({{$ap->fin_year}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick" name="class" data-selected-text-format="count">
                                                   <option value="">Class</option>
                                                @foreach($transClass as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->class_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clear-fix">
                               
                                <div class="col-sm-4" id="" style="">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control show-tick" name="location" data-selected-text-format="count">
                                                <option value="">Location</option>
                                                @foreach($transLocation as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->location}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4" id="" style="">
                                    <div class="form-group">
                                        <button class="btn btn-info" type="button" onclick="searchReportRequest('searchMainForm','<?php echo url('trial_balance_report'); ?>','reload_data',
                                                '<?php echo url('trial_balance'); ?>','<?php echo csrf_token(); ?>','from_date','to_date','fin_year')">Run Report</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <input type="hidden" value="table" name="report_type" />


                    </form>


                </div>
                <div class="body table-responsive " id="reload_data">
                    
                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

    <script>
       
        function searchReportRequest(formId,submitUrl,reload_id,reloadUrl,token,fromId,toId,finYearId){

            var from = $('#'+fromId).val();
            var to = $('#'+toId).val();
            var finYear = $('#'+finYearId).val();

            var inputVars = $('#'+formId).serialize();

            if(from != '' && to !='' && finYear !=''){

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
                swal("warning!", "Please ensure to select start/end date and financial/Fiscal Year.", "warning");

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