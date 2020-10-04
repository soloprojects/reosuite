@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Vendor Credit</h4>

                    <li class="dropdown pull-right">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        @include('includes/print_pdf',[$exportId = 'createMainForm', $exportDocId = 'createMainForm'])
                    </li>

                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;" id="po_main_table">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    Preferred Vendor
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_vendor" onkeyup="searchOptionListVenCust('select_vendor','myUL1','{{url('default_select')}}','search_vendor_transact','vendorCust','foreign_amount','<?php echo url('vendor_customer_currency') ?>','overall_sum','{{\App\Helpers\Utility::VENDOR}}','vendorCust','posting_date','vendor_address','curr_rate','foreign_overall_sum');" name="select_user" placeholder="Select Vendor">

                                            <input type="hidden" class="user_class" name="pref_vendor" id="vendorCust" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Posting Date
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" id="posting_date" onkeyup="exchangeRate('vendorCust','curr_rate','posting_date','<?php echo url('exchange_rate'); ?>')" name="posting_date" placeholder="Posting Date">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Vendor Address
                                        <div class="form-line">
                                            <textarea class="form-control"  id="vendor_address" name="vendor_address" placeholder="Vendor Address"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control " name="terms" >
                                                <option value="">Select Terms</option>
                                                @foreach($terms as $val)                                                
                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Include form -->
                            @include('includes.trans_sub_form',['terms' => $terms, 'transClass' => $transClass, 'transLocation' => $transLocation])
                           
                            <div class="row clearfix">
                                <h4>Account Section</h4>
                                @include('includes.account_part')
                            </div>
                            <hr/>
                            <div class="row clearfix">
                                <h4>Item Section</h4>
                                @include('includes.inventory_part')
                            </div>
                            <hr/>
                            <div class="row clearfix">
                                @include('includes.discount_part')
                            </div>
                            <hr/>
                            <div class="row clearfix">
                                @include('includes.tax_part')
                            </div>
                            <hr/>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Grand Total(Default Curr(Incl. Tax)) {{\App\Helpers\Utility::defaultCurrency()}}
                                        <div class="form-line">
                                            <input type="text" class="form-control" readonly id="foreign_overall_sum" name="grand_total" placeholder="Grand Total Default Currency">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                        Grand Total(Incl. Tax) <span class="foreign_amount"></span>
                                    <div class="form-group ">

                                        <div class="form-line">
                                            <input type="text" class="form-control" id="overall_sum" readonly name="grand_total_vendor_curr" placeholder="Grand Total Vendor Currency">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    Grand Total(Excl. Tax) <span class="foreign_amount"></span>
                                    <div class="form-group ">

                                        <div class="form-line">
                                            <input type="text" class="form-control" id="excl_overall_sum" readonly name="" placeholder="Grand Total(Excl. Tax) Vendor Currency">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row clearfix">
                                @include('includes.message_part')

                            </div>

                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaFormClass('createModal','createMainForm','<?php echo url('create_vendor_credit'); ?>','reload_data',
                            '<?php echo url('vendor_credit'); ?>','<?php echo csrf_token(); ?>',[
                            'inv_class','item_desc','quantity','unit_cost','unit_measure','tax','tax_perct','tax_amount',
                            'discount_perct','discount_amount','sub_total','acc_class','acc_desc','acct_rate',
                            'acc_tax','acc_tax_perct','acc_tax_amount','acc_discount_perct','acc_discount_amount',
                            'acc_sub_total'
                            ],'mail_message')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content" style="height:400px; overflow:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaFormClass('editModal','editMainForm','<?php echo url('edit_vendor_credit'); ?>','reload_data',
                            '<?php echo url('vendor_credit'); ?>','<?php echo csrf_token(); ?>',[
                                    'inv_class_edit','item_desc_edit','quantity_edit','unit_cost_edit','unit_measure_edit',
                            'tax_edit','tax_perct_edit','tax_amount_edit','discount_perct_edit','discount_amount_edit',
                            'sub_total_edit','acc_class_edit','acc_desc_edit','acc_rate_edit','acc_tax_edit',
                            'acc_tax_perct_edit','acc_tax_amount_edit','acc_discount_perct_edit','acc_discount_amount_edit',
                            'acc_sub_total_edit'
                            ],'mail_message_edit')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

     <!-- CONVERT PO MODAL FORM -->
     <div class="modal fade" id="convertPoModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Convert to Vendor Credit</h4>
                    <li class="dropdown pull-right">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert </i>Export
                        </a>
                        @include('includes/print_pdf',[$exportId = 'convertPoForm', $exportDocId = 'convertPoForm'])
                    </li>

                </div>
                <div class="modal-body" id="convert_po_content" style="height:400px; overflow:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaFormClass('convertPoModal','convertPoForm','<?php echo url('create_vendor_credit'); ?>','reload_data',
                            '<?php echo url('vendor_credit'); ?>','<?php echo csrf_token(); ?>',[
                            'inv_class_edit','item_desc_edit','quantity_edit','unit_cost_edit','unit_measure_edit','tax_edit',
                            'tax_perct_edit','tax_amount_edit','discount_perct_edit','discount_amount_edit','sub_total_edit',
                            'acc_class_edit','acc_desc_edit','acc_rate_edit','acc_tax_edit','acc_tax_perct_edit',
                            'acc_tax_amount_edit','acc_discount_perct_edit','acc_discount_amount_edit','acc_sub_total_edit'],
                            'mail_message_po')"
                            class="btn btn-info waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- CONVERT SALES MODAL FORM -->
    <div class="modal fade" id="convertSalesModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Convert to Vendor Credit</h4>
                    <li class="dropdown pull-right">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>Export
                        </a>
                        <ul class="dropdown-menu pull-right">
                        @include('includes/print_pdf',[$exportId = 'convertSalesForm', $exportDocId = 'convertSalesForm'])
                        </ul>
                    </li>

                </div>
                <div class="modal-body" id="convert_sales_content" style="height:400px; overflow:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaFormClass('convertSalesModal','convertSalesForm','<?php echo url('create_vendor_credit'); ?>','reload_data',
                            '<?php echo url('vendor_credit'); ?>','<?php echo csrf_token(); ?>',[
                                'inv_class_edit','item_desc_edit','quantity_edit','unit_cost_edit','unit_measure_edit','tax_edit',
                            'tax_perct_edit','tax_amount_edit','discount_perct_edit','discount_amount_edit','sub_total_edit',
                            'acc_class_edit','acc_desc_edit','acc_rate_edit','acc_tax_edit','acc_tax_perct_edit',
                            'acc_tax_amount_edit','acc_discount_perct_edit','acc_discount_amount_edit','acc_sub_total_edit'],
                            'mail_message_sales')"
                            class="btn btn-info waves-effect">
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
                        Vendor Credit
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('vendor_credit'); ?>',
                                    '<?php echo url('delete_vendor_credit'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a class="btn bg-blue-grey waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-print"></i>Print</a></li>
                                <li><a class="btn bg-red waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-file-pdf-o"></i>Pdf</a></li>
                                <li><a class="btn btn-warning" onClick ="$('#main_table').tableExport({type:'excel',escape:'false'});" ><i class="fa fa-file-excel-o"></i>Excel</a></li>
                                <li><a class="btn  bg-light-green waves-effect" onClick ="$('#main_table').tableExport({type:'csv',escape:'false'});" ><i class="fa fa-file-o"></i>CSV</a></li>
                                <li><a class="btn btn-info" onClick ="$('#main_table').tableExport({type:'doc',escape:'false'});" ><i class="fa fa-file-word-o"></i>Msword</a></li>

                            </ul>
                        </li>

                    </ul>
                </div>

                <div class="body">
                    <div class="row clearfix">
                        <div class="col-md-6 col-sm-12">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" autocomplete="off" id="select_po" onkeyup="searchOptionList('select_po','myUL10','{{url('default_select')}}','search_po_select','convertPo');" name="select_po" placeholder="Select PO">
    
                                        <input type="hidden" class="user_class" name="convertPo" id="convertPo" />
                                    </div>
                                </div>
                                <ul id="myUL10" class="myUL"></ul>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <button style="cursor: pointer;" class="btn btn-info" onclick="convertForm('convertPo','convert_po_content','<?php echo url('convert_po_vendor_credit_form') ?>','<?php echo csrf_token(); ?>','convertPoModal','convert_sales_content')"><i class="fa fa-pencil-square-o "></i>Convert PO to Vendor Credit</button>
                                </div>
                            </div>
                        </div>
    
                        <div class="col-md-6 col-sm-12">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" autocomplete="off" id="select_sales" onkeyup="searchOptionList('select_sales','myUL11','{{url('default_select')}}','search_sales_select','convertSales');" name="select_sales" placeholder="Select Sales">
    
                                        <input type="hidden" class="user_class" name="convertSales" id="convertSales" />
                                    </div>
                                </div>
                                <ul id="myUL11" class="myUL"></ul>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <button style="cursor: pointer;" class="btn btn-info" onclick="convertForm('convertSales','convert_sales_content','<?php echo url('convert_sales_vendor_credit_form') ?>','<?php echo csrf_token(); ?>','convertSalesModal','convert_po_content')"><i class="fa fa-pencil-square-o "></i>Convert Sales to Vendor Credit</button>
                                </div>
                            </div>
                        </div>
    
                    </div>

                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="search_vendor_credit" class="form-control"
                                       onkeyup="searchItem('search_vendor_credit','reload_data','<?php echo url('search_vendor_credit') ?>','{{url('vendor_credit')}}','<?php echo csrf_token(); ?>')"
                                       name="search_vendor_credit" placeholder="Search Vendor Credit" >
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="row clearfix">



                    </div>

                <div class="body table-responsive " id="reload_data">
                    <!-- Table Default Size -->
                    @include('vendor_credit.table',['mainData'=>$mainData])

                    <div class=" pagination pull-right">
                        {!! $mainData->render() !!}
                    </div>


                </div>
                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

    <script>
                

    </script>

<script>

    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getData(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getData(page);
        location.hash = page;
    });

    function getData(page){
        var searchVal = $('#search_vendor_credit').val();
        var pageData = '';
        if(searchVal == ''){
            pageData = '?page=' + page;
        }else{
            pageData = '<?php echo url('search_vendor_credit') ?>?page=' + page+'&searchVar='+searchVal;
        }

        $.ajax({
            url: pageData
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

    var pDate = $("#posting_date").val();
    var pDateEdit = $("#posting_date_edit").val();
    if(pDate != ''){
        exchangeRate('vendorCust','curr_rate','posting_date','<?php echo url('exchange_rate'); ?>')
    }

    if($('#posting_date_edit').length){
        exchangeRate('vendorCust_edit','curr_rate_edit','posting_date_edit','<?php echo url('exchange_rate'); ?>')
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