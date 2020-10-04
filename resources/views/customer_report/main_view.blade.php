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
                        Customer Report
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
                <div class=" body">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                        <li role="presentation" class="active"><a href="#transactions" data-toggle="tab">Transactions</a></li>
                        <li role="presentation"><a href="#overdue_invoice" data-toggle="tab">Overdue Invoices</a></li>
                        <li role="presentation"><a href="#open_invoice" data-toggle="tab">Open Invoices</a></li>
                        <li role="presentation"><a href="#accounts" data-toggle="tab">Accounts</a></li>
                        <li role="presentation"><a href="#inventory" data-toggle="tab">Inventory</a></li>
                    </ul>


                    <!-- Tab panes -->
                    <div class="tab-content" id="main_table">
                        <div role="tabpanel" class="tab-pane fade in active body" id="transactions">
                            <b>Transaction Report</b>
                            
                            @include('customer_report.search_form',['finYear' => $finYear, 'transClass' => $transClass, 'transLocation' => $transLocation, 'searchFormId' => 'searchTransactionForm', 'finYearId' => 'fin_year', 'from' => 'from_date', 'to' => 'to_date', 'attachToId' => ''])

                            <div class="row clearfix">
                                                                                
                                <div class="col-sm-4 pull-right" id="" style="">
                                    <div class="form-group">
                                        <button class="btn btn-info" type="button" onclick="searchReportRequest('searchTransactionForm','<?php echo url('customer_transaction_report'); ?>','reload_transaction',
                                                '','<?php echo csrf_token(); ?>','from_date','to_date','fin_year')">Run Report</button>
                                    </div>
                                </div>
                            </div>

                            <div class="body table-responsive " id="reload_transaction">
                    
                            </div>

                        </div>

                        <div role="tabpanel" class="tab-pane fade in body" id="overdue_invoice">
                            <b>Overdue Invoices</b>
                            
                            @include('customer_report.search_form',['finYear' => $finYear, 'transClass' => $transClass, 'transLocation' => $transLocation, 'searchFormId' => 'searchOverdueInvoiceForm', 'finYearId' => 'fin_year2', 'from' => 'from_date2', 'to' => 'to_date2', 'attachToId' => '2'])

                            <div class="row clearfix">
                                                                                
                                <div class="col-sm-4 pull-right" id="" style="">
                                    <div class="form-group">
                                        <button class="btn btn-info" type="button" onclick="searchReportRequest('searchOverdueInvoiceForm','<?php echo url('overdue_invoice_report'); ?>','reload_overdue_invoice',
                                                '','<?php echo csrf_token(); ?>','from_date2','to_date2','fin_year2')">Run Report</button>
                                    </div>
                                </div>
                            </div>

                            <div class="body table-responsive " id="reload_overdue_invoice">
                    
                            </div>

                        </div>

                        <div role="tabpanel" class="tab-pane fade in body" id="open_invoice">
                            <b>Open Invoices</b>
                            
                            @include('customer_report.search_form',['finYear' => $finYear, 'transClass' => $transClass, 'transLocation' => $transLocation, 'searchFormId' => 'searchOpenInvoiceForm', 'finYearId' => 'fin_year3', 'from' => 'from_date3', 'to' => 'to_date3', 'attachToId' => '3'])

                            <div class="row clearfix">
                                                                                
                                <div class="col-sm-4 pull-right" id="" style="">
                                    <div class="form-group">
                                        <button class="btn btn-info" type="button" onclick="searchReportRequest('searchOpenInvoiceForm','<?php echo url('open_invoice_report'); ?>','reload_open_invoice',
                                                '','<?php echo csrf_token(); ?>','from_date3','to_date3','fin_year3')">Run Report</button>
                                    </div>
                                </div>
                            </div>

                            <div class="body table-responsive " id="reload_open_invoice">
                    
                            </div>


                        </div>

                        <div role="tabpanel" class="tab-pane fade in body" id="accounts">
                            <b>Accounts Report</b>
                            
                            @include('customer_report.search_form',['finYear' => $finYear, 'transClass' => $transClass, 'transLocation' => $transLocation, 'searchFormId' => 'searchAccountsForm', 'finYearId' => 'fin_year4', 'from' => 'from_date4', 'to' => 'to_date4', 'attachToId' => '4'])

                            <div class="row clearfix">                                
                                                
                                <div class="col-sm-4 pull-right" id="" style="">
                                    <div class="form-group">
                                        <button class="btn btn-info" type="button" onclick="searchReportRequest('searchAccountsForm','<?php echo url('customer_accounts_report'); ?>','reload_accounts',
                                                '','<?php echo csrf_token(); ?>','from_date4','to_date4','fin_year4')">Run Report</button>
                                    </div>
                                </div>
                            </div>

                            <div class="body table-responsive " id="reload_accounts">
                    
                            </div>

                        </div>

                        <div role="tabpanel" class="tab-pane fade in body" id="inventory">
                            <b>Inventory Report</b>

                            @include('customer_report.search_form',['finYear' => $finYear, 'transClass' => $transClass, 'transLocation' => $transLocation, 'searchFormId' => 'searchInventoryForm', 'finYearId' => 'fin_year5', 'from' => 'from_date5', 'to' => 'to_date5', 'attachToId' => '5'])

                            <div class="row clearfix">
                                                                                
                                <div class="col-sm-4 pull-right" id="" style="">
                                    <div class="form-group">
                                        <button class="btn btn-info" type="button" onclick="searchReportRequest('searchInventoryForm','<?php echo url('customer_inventory_report'); ?>','reload_inventory',
                                                '','<?php echo csrf_token(); ?>','from_date5','to_date5','fin_year5')">Run Report</button>
                                    </div>
                                </div>
                            </div>

                            <div class="body table-responsive " id="reload_inventory">
                    
                            </div>

                        </div>

                    </div>              

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