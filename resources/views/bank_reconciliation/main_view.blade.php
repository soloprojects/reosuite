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
                        Bank Reconciliation
                    </h2>
                    <ul class="header-dropdown m-r--5">

                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>Export
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_report'])
                            </ul>
                        </li>

                    </ul>
                </div>
               
                <div class=" body " id="">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs tab-nav-right" role="tablist">
                            <li role="presentation" class="active"><a href="#reconcile_account" data-toggle="tab">Reconcile Account</a></li>
                            <li role="presentation"><a href="#report" data-toggle="tab">Report</a></li>
                        </ul>

                     <!-- Tab panes -->
                    <div class="tab-content" id="main_table">
                        <div role="tabpanel" class="tab-pane fade in active body" id="reconcile_account">
                            <b>Reconcile Account</b>
                            
                            <form name="reconcileForm" id="reconcileForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="body">
        
                                    <div class="row clearfix">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" value="" autocomplete="off" id="select_acc500" onkeyup="searchOptionList('select_acc500','myUL500_acc','{{url('default_select')}}','reconcile_accounts','acc500');" name="select_account" placeholder="Select Account">
                            
                                                    <input type="hidden" class="acc_class" value="" name="account" id="acc500" />
                                                </div>
                                            </div>
                                            <ul id="myUL500_acc" class="myUL"></ul>
                                        </div>           
        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="form-control " readonly="readonly" autocomplete="off" id="begining_balance" name="begining_balance" placeholder="Begining Balance">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="form-control " autocomplete="off" id="" name="ending_balance" placeholder="Ending Balance">
                                                </div>
                                            </div>
                                        </div> 
        
                                    </div>
        
                                    <div class="row clearfix">
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control datepicker" autocomplete="off" id="" name="ending_date" placeholder="Ending Date">
                                                </div>
                                            </div>
                                        </div>   
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select  class="form-control " name="financial_year" id="" data-selected-text-format="count">
                                                        @foreach($finYear as $ap)
                                                            @if($ap->active_status == Utility::STATUS_ACTIVE)
                                                            <option value="{{$ap->id}}" selected>{{$ap->fin_name}}({{$ap->fin_year}})</option>
                                                            @else
                                                            <option value="{{$ap->id}}">{{$ap->fin_name}}({{$ap->fin_year}})</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                                                   
                                        <div class="col-sm-4" id="" style="">
                                            <div class="form-group">
                                                <button class="btn btn-info" type="button" onclick="searchReport('reconcileForm','<?php echo url('bank_reconciliation_reconcile'); ?>','reload_reconcile_account',
                                                        '<?php echo url('bank_reconciliation'); ?>','<?php echo csrf_token(); ?>')">Start Reconciliation</button>
                                            </div>
                                        </div>
                                    </div>
        
                                </div><hr/>
        
        
                            </form>

                            <div class="body table-responsive " id="reload_reconcile_account">
                    
                            </div>

                        </div>

                        <div role="tabpanel" class="tab-pane fade in body" id="report">
                            <b>Report</b>
                            <span>
                                <button type="button" onclick="deleteItems('kid_checkbox','reload_report','<?php echo url('bank_reconciliation'); ?>',
                                        '<?php echo url('delete_bank_reconciliation'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger pull-right">
                                    <i class="fa fa-trash-o"></i>Delete
                                </button>
                            </span>
                            <form name="searchMainForm" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="body">
        
                                    <div class="row clearfix">
        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control datepicker" autocomplete="off" id="" name="from_date" placeholder="From e.g 2019-02-22">
                                                </div>
                                            </div>
                                        </div>
                            
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control datepicker" autocomplete="off" id="" name="to_date" placeholder="To e.g 2019-04-21">
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" value="" autocomplete="off" id="select_acc" onkeyup="searchOptionList('select_acc','myUL_acc','{{url('default_select')}}','search_accounts','acc');" name="select_account" placeholder="Select Account">
                            
                                                    <input type="hidden" class="acc_class" value="" name="account" id="acc" />
                                                </div>
                                            </div>
                                            <ul id="myUL_acc" class="myUL"></ul>
                                        </div>   
        
                                    </div>
        
                                    <div class="row clearfix">
                                        
                                                                  
                                                                   
                                        <div class="col-sm-4" id="" style="">
                                            <div class="form-group">
                                                <button class="btn btn-info" type="button" onclick="searchReportRequest('searchMainForm','<?php echo url('bank_reconciliation_search'); ?>','reload_report',
                                                        '<?php echo url('bank_reconciliation'); ?>','<?php echo csrf_token(); ?>','from_date','to_date','acc')">Search</button>
                                            </div>
                                        </div>
                                    </div>
        
                                </div>
        
        
                            </form>

                            <div class="body table-responsive " id="reload_report">
                    
                                @include('bank_reconciliation.table',['mainData' => $mainData])

                                <div class=" pagination pull-right">
                                    {!! $mainData->render() !!}
                                </div>

                            </div>

                        </div>
                    
                    </div>


                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

    <script>

    function checkAllAmount(master,idClass,sisterClass,begBalId,endBalId,clearedBalId,paymentDepositId,differenceId,countId,amountType){
        
        var depositType = 1;
        var paymentType = 2;

        var clearedBal = getId(clearedBalId);
        var paymentDeposit = getId(paymentDepositId);
        var difference = getId(differenceId);
        var endBal = getId(endBalId);
        var begBal = getId(begBalId);
        var count = getId(countId);


        var clearedBalHidden = getId(clearedBalId+'_hidden');
        var paymentDepositHidden = getId(paymentDepositId+'_hidden');
        var differenceHidden = getId(differenceId+'_hidden');
        var endBalHidden = getId(endBalId+'_hidden');
        var begBalHidden = getId(begBalId+'_hidden');
        var countHidden = getId(countId+'_hidden');

        var goodStatus = 'fa fa-check-circle fa-2 btn-success';
        var badStatus = 'fa fa-exclamation-triangle fa-2 btn-danger';
        var signStatus = $('#sign_status');
        
        var all = document.getElementsByClassName(idClass); //CLASS OF ALL ID's TO BE CHECKED
        var totalAmount = 0.00;
        var countData = 0;
        for(var i=0; i < all.length; i++){
            var getIdd = document.getElementById(all[i].id);
            getIdd.checked = master.checked;
            if(master.checked){
                var getAmount = parseFloat(getIdd.dataset.amount);
                
                totalAmount+=getAmount;
                countData+=1
            }
        }

        var sisterArr = amountArrayChecked(sisterClass);
        var sisterVal = (sisterArr.length > 0) ? sumArrayItems(sisterArr) : 0.00;


        //SUBTRACT PAYMENT FROM DEPOSIT TO GET SUM
        var sumTotal = (amountType == depositType) ? decPoints(totalAmount,2) - sisterVal : sisterVal - totalAmount;

        //CLEARED BALANCE EQUALS BEGINING BALANCE PLUS SUMTOTAL
        var newClearedBal = parseFloat(begBalHidden.val())+sumTotal;

        //DIFFERENCE IS SUBTRACTION OF CLEARED BALANCE FROM ENDING BALANCE
        var newDiff = decPoints(endBalHidden.val(),2) - decPoints(newClearedBal,2);
        
        paymentDeposit.html(decPoints(totalAmount,2));    //CHANGE IN THE DISPLAYED AMOUNT OF DEPOSIT/PAYMENT
        difference.html(decPoints(newDiff,2));    //CHANGE IN THE DISPLAYED AMOUNT OF BALANCE DIFFERENCE
        clearedBal.html(decPoints(newClearedBal,2));    //CHANGE IN THE DISPLAYED AMOUNT OF  CLEARED BALANCE
        count.html(countData);

        //HIDDEN
        paymentDepositHidden.val(decPoints(totalAmount,2));    //CHANGE IN THE HIDDEN AMOUNT OF DEPOSIT/PAYMENT
        differenceHidden.val(decPoints(newDiff,2));    //CHANGE IN THE HIDDEN AMOUNT OF BALANCE DIFFERENCE
        clearedBalHidden.val(decPoints(newClearedBal,2));    //CHANGE IN THE HIDDEN AMOUNT OF  CLEARED BALANCE
        countHidden.val(countData);

        //DISPLAY IF THE STATUS IS GOOD/BAD FOR A STANDARD RECONCILIATION
        if(newDiff == 0 || newDiff == 0.00){
            signStatus.removeClass();
            signStatus.addClass(goodStatus);
        }else{
            signStatus.removeClass();
            signStatus.addClass(badStatus);
        }

    }

       
    function checkAmount(idClass,sisterClass,begBalId,endBalId,clearedBalId,paymentDepositId,differenceId,countId,amountType){
    
        var depositType = 1;
        var paymentType = 2;
       
        var clearedBal = getId(clearedBalId);
        var paymentDeposit = getId(paymentDepositId);
        var difference = getId(differenceId);
        var endBal = getId(endBalId);
        var begBal = getId(begBalId);
        var count = getId(countId);


        var clearedBalHidden = getId(clearedBalId+'_hidden');
        var paymentDepositHidden = getId(paymentDepositId+'_hidden');
        var differenceHidden = getId(differenceId+'_hidden');
        var endBalHidden = getId(endBalId+'_hidden');
        var begBalHidden = getId(begBalId+'_hidden');
        var countHidden = getId(countId+'_hidden');

        var goodStatus = 'fa fa-check-circle fa-2 btn-success';
        var badStatus = 'fa fa-exclamation-triangle fa-2 btn-danger';
        var signStatus = $('#sign_status');

        var paymentDepositArr = amountArrayChecked(idClass);
        var sisterArr = amountArrayChecked(sisterClass);
        var newPaymentDepositVal = (paymentDepositArr.length > 0) ? sumArrayItems(paymentDepositArr) : 0.00;
        var sisterVal = (sisterArr.length > 0) ? sumArrayItems(sisterArr) : 0.00;
        var countData = paymentDepositArr.length;
       
        //SUBTRACT PAYMENT FROM DEPOSIT TO GET SUM
        var sumTotal = (amountType == depositType) ? newPaymentDepositVal - sisterVal : sisterVal - newPaymentDepositVal;

        //CLEARED BALANCE EQUALS BEGINING BALANCE PLUS SUMTOTAL
        var newClearedBal = begBalHidden.val() + sumTotal;

        //DIFFERENCE IS SUBTRACTION OF CLEARED BALANCE FROM ENDING BALANCE
        var newDiff = parseFloat(endBalHidden.val()) - newClearedBal;

        paymentDeposit.html(decPoints(newPaymentDepositVal,2));    //CHANGE IN THE DISPLAYED AMOUNT OF DEPOSIT/PAYMENT
        difference.html(decPoints(newDiff,2));    //CHANGE IN THE DISPLAYED AMOUNT OF BALANCE DIFFERENCE
        clearedBal.html(decPoints(newClearedBal,2));    //CHANGE IN THE DISPLAYED AMOUNT OF  CLEARED BALANCE
        count.html(countData);

        //HIDDEN
        paymentDepositHidden.val(decPoints(newPaymentDepositVal,2));    //CHANGE IN THE HIDDEN AMOUNT OF DEPOSIT/PAYMENT
        differenceHidden.val(decPoints(newDiff,2));    //CHANGE IN THE HIDDEN AMOUNT OF BALANCE DIFFERENCE
        clearedBalHidden.val(decPoints(newClearedBal,2));    //CHANGE IN THE HIDDEN AMOUNT OF  CLEARED BALANCE
        countHidden.val(countData);

        //DISPLAY IF THE STATUS IS GOOD/BAD FOR A STANDARD RECONCILIATION
        if(newDiff == 0){
            signStatus.removeClass();
            signStatus.addClass(goodStatus);
        }else{
            signStatus.removeClass();
            signStatus.addClass(badStatus);
        }




    }

    //SUBMIT FORM WITH A FILE
    function submitReconcileForm(formId,submitUrl,reload_id,reloadUrl,token){
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);
        var postVars = new FormData(form);

        var allCheckedId = group_val('reconciled');
        var unClearedDeposits = amountArrayUnchecked('kid_checkbox_deposit'); //ARRAY OF ALL DEPOSITS UNCLEARED
        var unClearedPayments = amountArrayUnchecked('kid_checkbox_payment'); //ARRAY OF ALL PAYMENTS UNCLEARED
        var countUnclearedDeposits = unClearedDeposits.length;
        var countUnclearedPayments = unClearedPayments.length;

        postVars.append('token',token);
        postVars.append('dataId',JSON.stringify(allCheckedId));
        postVars.append('unclearedDeposits',JSON.stringify(unClearedDeposits));
        postVars.append('unclearedPayments',JSON.stringify(unClearedPayments));
        postVars.append('countUnclearedDeposits',countUnclearedDeposits);
        postVars.append('countUnclearedPayments',countUnclearedPayments);

        $('#loading_modal').modal('show');
        console.log(allCheckedId);
        sendRequestMediaForm(submitUrl,token,postVars);
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                $('#loading_modal').modal('hide');
                
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    var messageError = rollback.message;
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){

                   var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", "Data saved successfully!", "success");
                    location.reload();

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

            }
        }

    }

    //ADD GROUP OF UNCHECKED INPUT CHECKBOX INTO AN ARRAY
    function amountArrayUnchecked(klass){

        var approve = document.getElementsByClassName(klass);
        var values = [];
        for(var i=0; i < approve.length; i++){
            if(approve[i].checked){                
            }else{

                values.push(approve[i].getAttribute('data-amount'));
            }
        }
        return values;
    }

     //ADD GROUP OF UNCHECKED INPUT CHECKBOX INTO AN ARRAY
    function amountArrayChecked(klass){

        var approve = document.getElementsByClassName(klass);
        var values = [];
        for(var i=0; i < approve.length; i++){
            if(approve[i].checked){     
                values.push(approve[i].getAttribute('data-amount'));           
            }
        }
        return values;
    }
          
    function searchReportRequest(formId,submitUrl,reload_id,reloadUrl,token,fromId,toId,accId){

        var from = $('#'+fromId).val();
        var to = $('#'+toId).val();
        var account = $('#'+accId).val();

        var inputVars = $('#'+formId).serialize();

        if(from != '' && to !='' && account !=''){

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
            swal("warning!", "Please ensure to select start/end date and account.", "warning");

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
                $('#reload_report').html(data);
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