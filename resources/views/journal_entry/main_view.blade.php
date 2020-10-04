@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Jornal Entry</h4>

                    <li class="dropdown pull-right">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        @include('includes/print_pdf',[$exportId = 'createMainForm', $exportDocId = 'createMainForm'])
                    </li>

                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;" id="po_main_table">

                    <form name="import_excel" autocomplete="off" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    Payer/Receiver
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control " name="payer_receiver" id="payer_receiver" onchange="switchPayerReceiver('payer_receiver','switch_customer','switch_vendor','switch_employee')" >
                                                <option value="">Select Payer/Receiver</option>
                                                <option value="{{Utility::VENDOR}}">Vendor</option>       
                                                <option value="{{Utility::CUSTOMER}}">Customer</option>
                                                <option value="{{Utility::EMPLOYEE}}">Employee</option>                                            
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- BEGIN SWITCH OF CUSTOMER, VENDOR OR EMPLOYEE -->
                                <div class="col-sm-4" id="switch_customer" style="display:none;">
                                    Preferred Customer
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_customer" onkeyup="searchOptionListVenCust('select_customer','myULCustomer','{{url('default_select')}}','search_customer','customer');" name="select_customer" placeholder="Select Customer">

                                            <input type="hidden" class="" name="pref_customer" id="customer" />
                                        </div>
                                    </div>
                                    <ul id="myULCustomer" class="myUL"></ul>
                                </div>

                                <div class="col-sm-4" id="switch_vendor" style="display:none;">
                                    Preferred Vendor
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_vendor" onkeyup="searchOptionListVenCust('select_vendor','myULVendor','{{url('default_select')}}','search_vendor','vendor');" name="select_vendor" placeholder="Select Vendor">

                                            <input type="hidden" class="" name="pref_vendor" id="vendor" />
                                        </div>
                                    </div>
                                    <ul id="myULVendor" class="myUL"></ul>
                                </div>


                                <div class="col-sm-4" id="switch_employee" style="display:none;">
                                    <b>Employee</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_employee" onkeyup="searchOptionList('select_employee','myUL1','{{url('default_select')}}','default_search','employee');" name="select_employee" placeholder="Employee">
    
                                            <input type="hidden" class="" name="employee" id="employee" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>

                                <!-- END SWITCH OF CUSTOMER, VENDOR OR EMPLOYEE -->

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Posting Date
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" id="posting_date" onkeyup="exchangeRate('vendorCust','curr_rate','posting_date','<?php echo url('exchange_rate'); ?>')" name="posting_date" placeholder="Posting Date">
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                                                        
                            <!-- Include form -->
                            @include('includes.trans_sub_form',['transClass' => $transClass, 'transLocation' => $transLocation])
                           
                            <div class="row clearfix">
                                <span class="pull-right"><b>Cash Transaction (Absence of AP/AR)</b>
                                <input name="cash_transaction_status" type="radio" id="radio_30" value="1" class="with-gap radio-col-green" />
                                <label for="radio_30">YES</label>

                                <input name="cash_transaction_status" type="radio" id="radio_31" value="0" class="with-gap radio-col-red" />
                                <label for="radio_31">NO</label>
                                </span>
                            </div>

                            <div class="row clearfix">
                                <h4>Account Section</h4>
                                @include('includes.journal_entry')
                            </div>
                            <hr/>                                                       

                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaFormClass('createModal','createMainForm','<?php echo url('create_journal_entry'); ?>','reload_data',
                            '<?php echo url('journal_entry'); ?>','<?php echo csrf_token(); ?>',[
                            'acc_class','acc_desc','debit_credit','debit_account_hidden','credit_account_hidden',
                            'checkmate_debit','checkmate_credit'])" type="button" class="btn btn-link waves-effect">
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
                        Journal Entry
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('journal_entry'); ?>',
                                    '<?php echo url('delete_journal_entry'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                    
                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="search_journal_entry" class="form-control"
                                       onkeyup="searchItem('search_journal_entry','reload_data','<?php echo url('search_journal_entry') ?>','{{url('journal_entry')}}','<?php echo csrf_token(); ?>')"
                                       name="search_journal_entry" placeholder="Search journal_entry" >
                            </div>
                        </div>
                    </div>
                </div>               

                <div class="body table-responsive " id="reload_data">
                    
                    @include('journal_entry.table',['mainData' => $mainData])

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
        //SUBMIT FORM WITH A FILE
        function submitMediaFormClass(formModal,formId,submitUrl,reload_id,reloadUrl,token,classList){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            
            var postVars = new FormData(form);
            postVars.append('token',token);
            appendClassToPost(classList,postVars);
            
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
                        
                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id,reloadUrl);
                }
            }
            $('#loading_modal').modal('hide');

        }

        function switchPayerReceiver(switcherId,customerId,vendorId,employeeId){
            var switcher = $('#'+switcherId);
            var customer = $('#'+customerId);
            var vendor = $('#'+vendorId);
            var employee = $('#'+employeeId);

            if(switcher.val() == @php echo Utility::CUSTOMER; @endphp ){
            customer.show();
            vendor.hide();
            employee.hide();
            }
            if(switcher.val() == @php echo Utility::VENDOR; @endphp){
                customer.hide();
                vendor.show();
                employee.hide();
            }
            if(switcher.val() == @php echo Utility::EMPLOYEE; @endphp){
                customer.hide();
                vendor.hide();
                employee.show();
            }
            if(switcher.val() == ''){
                customer.hide();
                vendor.hide();
                employee.hide();
            }

        }

        //MAKES THE INPUT BESIDE FOCUSED INPUT DISABLED, EMPTY VALUE AND GIVE ITS RELATED HIDDEN INPUT VALUE OF 0.00
        function makeReadOnly(determinerId,debitId,creditId,debitHiddenId,creditHiddenId){
        var determiner = $('#'+determinerId);
        var debit = $('#'+debitId);
        var credit = $('#'+creditId);
        var debitHidden = $('#'+debitHiddenId);
        var creditHidden = $('#'+creditHiddenId);

            if(determiner.val() == @php echo Utility::DEBIT_TABLE_ID; @endphp ){
                credit.val('');
                creditHidden.val('0.00');
                credit.prop('disabled','true');

                if(debit.prop("disabled") == true){
                debit.prop("disabled", false);
                }
                
            }
            if(determiner.val() == @php echo Utility::CREDIT_TABLE_ID; @endphp ){
                debit.val('');
                debitHidden.val('0.00');
                debit.prop('disabled','true');

                if(credit.prop("disabled") == true){
                credit.prop("disabled", false);
                }
                
            }
        }

        function reflectToHidden(inputId,hiddenId){
            var inputVal = $('#'+inputId).val();
            var hidden = $('#'+hiddenId);
            hidden.val(inputVal);

        }

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
        var searchVal = $('#search_journal_entry').val();
        var pageData = '';
        if(searchVal == ''){
            pageData = '?page=' + page;
        }else{
            pageData = '<?php echo url('search_journal_entry') ?>?page=' + page+'&searchVar='+searchVal;
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