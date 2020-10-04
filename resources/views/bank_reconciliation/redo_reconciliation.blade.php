@extends('layouts.app')

@section('content')
   
    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Redo Reconciliation
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
                <div class="body table-responsive" id="reload_data">
                    
                    <table>
                        <thead>
                            <th style="font-weight: bold;">{{$accountData->acct_name}} ({{$accountData->acct_no}}) Reconciliation</th>
                        </thead>
                    </table><hr>
                    
                    <div class="row clearfix">
                    
                        <div class="col-md-4">
                            <span class="text-center" style="font-weight:bold" id="ending_balance">{{Utility::numberFormat($endingBalance)}}</span><br>
                            <span class="text-center">Ending Balance {{\App\Helpers\Utility::defaultCurrency()}}</span>
                        </div>
                    
                        <div class="col-md-4">
                            <span class="text-center" style="font-weight:bold" id="cleared_balance">{{Utility::numberFormat($clearedBalance)}}</span><br>
                            <span class="text-center">---Cleared Balance {{\App\Helpers\Utility::defaultCurrency()}}</span>
                        </div>
                        <div class="col-md-4">
                            @php $signStatus = ($balanceDifference != 0) ? 'fa fa-exclamation-triangle fa-2 btn-danger' : 'fa fa-check-circle fa-2 btn-success'; @endphp
                            <span class="text-center" style="font-weight:bold" id="difference_balance">{{Utility::numberFormat($balanceDifference)}}</span>
                            <span class=""><i id="sign_status" class="{{$signStatus}}" aria-hidden="true"></i></span><br/>
                            <span class="text-center">=Difference {{\App\Helpers\Utility::defaultCurrency()}}</span>
                        </div>
                    
                    </div><hr>
                    
                    <div class="row clearfix">
                    
                        <div class="col-md-4">
                            <p class="text-center" style="font-weight:bold" id="begining_balance">{{Utility::numberFormat($beginingBalance)}}</p><br>
                            <p class="text-center">Begining Balance {{\App\Helpers\Utility::defaultCurrency()}} =</p>
                        </div>
                    
                        <div class="col-md-4">
                            <p class="text-center" style="font-weight:bold" id="deposits">{{Utility::numberFormat($edit->deposits_cleared)}}</p><br/>
                            <p class="text-center"> <span style="font-weight: bold" id="deposit_num">{{$edit->count_cleared_deposits}}</span> Deposit(s) {{\App\Helpers\Utility::defaultCurrency()}}</p>
                        </div>
                    
                        <div class="col-md-4">
                            <p class="text-center" style="font-weight:bold" id="payments">{{Utility::numberFormat($edit->payments_cleared)}}</p><br>
                            <p class="text-center">---  <span style="font-weight: bold" id="payment_num">{{$edit->count_cleared_payments}}</span> Payment(s) {{\App\Helpers\Utility::defaultCurrency()}} </p>
                        </div>
                    
                    </div>

                    <div class="row clearfix">
                    
                            <div class="col-md-6 col-lg-6 col-sm-12" style="width:50%; overflow-x:scroll;" >
                                <b>Deposit(s)</b>
                                <table class="table table-responsive table-bordered table-hover table-striped" id="">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" onclick="checkAllAmount(this,'kid_checkbox_deposit','kid_checkbox_payment','begining_balance','ending_balance','cleared_balance','deposits','difference_balance','deposit_num','1');" id="parent_check_deposit"
                                                    name="check_all_deposit" class="filled-in chk-col-blue-grey" />
                            
                                        </th>
                                        <th>Post Date</th>
                                        <th>Transaction Type</th>
                                        <th>Deposits {{\App\Helpers\Utility::defaultCurrency()}}</th>
                                        <th>Payee/Payer</th>
                                        <th>Status</th>
                            
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($deposits as $data)
                                    <tr>
                                        @php $checkData = ($data->reconcile_status == Finance::reconciled) ? 'checked' : '';  @endphp
                                        <td scope="row">
                                            <input {{$checkData}} value="{{$data->id}}" type="checkbox" id="deposit_{{$data->id}}" 
                                            data-amount="{{$data->trans_total}}" class="kid_checkbox_deposit reconciled filled-in chk-col-green"
                                            onclick="checkAmount('kid_checkbox_deposit','kid_checkbox_payment','begining_balance','ending_balance','cleared_balance','deposits','difference_balance','deposit_num','1');" />
                            
                                        </td>   
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <td>{{$data->post_date}}</td>
                                        <td>{{Finance::transType($data->transaction_type)}}</td>
                                        <td>{{Utility::numberFormat($data->trans_total)}}</td>
                                        <td>
                                            @if(!empty($data->contact_type))
                                            {{$data->vendorCon->name}}
                                            @endif
                                            @if(!empty($data->employee_id))
                                            {{$data->employee->first_name}} {{$data->employee->last_name}}
                                            @endif
                                        </td>
                                        <td>{{Finance::reconcileStatus($data->reconcile_status)}}</td>
                            
                            
                                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    </tr>
                                    @endforeach
                            
                                    </tbody>
                                </table>
                            </div>
                    
                            <div class="col-md-6 col-lg-6 col-sm-12" style="width:50%; overflow-x:scroll;">
                                <b>Payment(s)</b>
                                <table class="table table-bordered table-hover table-striped" id="">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" onclick="checkAllAmount(this,'kid_checkbox_payment','kid_checkbox_deposit','begining_balance','ending_balance','cleared_balance','payments','difference_balance','payment_num','2');" id="parent_check_payment"
                                                    name="check_all_payment" class="filled-in chk-col-blue-grey" />
                            
                                        </th>
                                        <th>Post Date</th>
                                        <th>Transaction Type</th>
                                        <th>Payments {{\App\Helpers\Utility::defaultCurrency()}}</th>
                                        <th>Payee/Payer</th>
                                        <th>Status</th>
                            
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($payments as $data)
                                    <tr>
                                        @php $checkData = ($data->reconcile_status == Finance::reconciled) ? 'checked' : '';  @endphp
                                        <td scope="row">
                                            <input {{$checkData}} value="{{$data->id}}" type="checkbox" id="payment_{{$data->id}}" 
                                            data-amount="{{$data->trans_total}}" class="kid_checkbox_payment reconciled filled-in chk-col-green"
                                            onclick="checkAmount('kid_checkbox_payment','kid_checkbox_deposit','begining_balance','ending_balance','cleared_balance','payments','difference_balance','payment_num','2');" />
                            
                                        </td>   
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <td>{{$data->post_date}}</td>
                                        <td>{{Finance::transType($data->transaction_type)}}</td>
                                        <td>{{Utility::numberFormat($data->trans_total)}}</td>
                                        <td>
                                            @if(!empty($data->contact_type))
                                            {{$data->vendorCon->name}}
                                            @endif
                                            @if(!empty($data->employee_id))
                                            {{$data->employee->first_name}} {{$data->employee->last_name}}
                                            @endif
                                        </td>
                                        <td>{{Finance::reconcileStatus($data->reconcile_status)}}</td>
                            
                            
                                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    </tr>
                                    @endforeach
                            
                                    </tbody>
                                </table>
                            </div>
                    
                        <form name="processReconciliation" id="processReconciliation" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        
                            <input type="hidden" name="begining_balance" value="{{$beginingBalance}}" id="begining_balance_hidden">
                            <input type="hidden" name="ending_balance" value="{{$endingBalance}}" id="ending_balance_hidden">
                            <input type="hidden" name="cleared_balance" value="{{$clearedBalance}}" id="cleared_balance_hidden">
                            <input type="hidden" name="payments" value="{{$edit->payments_cleared}}" id="payments_hidden">
                            <input type="hidden" name="deposits" value="{{$edit->deposits_cleared}}" id="deposits_hidden">
                            <input type="hidden" name="payment_num" value="{{$edit->count_cleared_payments}}" id="payment_num_hidden">
                            <input type="hidden" name="deposit_num" value="{{$edit->count_cleared_deposits}}" id="deposit_num_hidden">
                            <input type="hidden" name="difference_balance" value="{{$balanceDifference}}" id="difference_balance_hidden">
                            <input type="hidden" name="account_category" value="{{$accountData->acct_cat_id}}" >
                            <input type="hidden" name="account_id" value="{{$accountData->id}}" >
                            <input type="hidden" name="ending_date" value="{{$endingDate}}" >
                            <input type="hidden" name="begining_date" value="{{$beginingDate}}" >
                            <input type="hidden" name="update_status" value="1" >
                            <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                    
                        </form>
                    
                    </div>
                    
                    <div class="row">
                        <button onclick="submitReconcileForm('processReconciliation','<?php echo url('bank_reconciliation_create'); ?>','reload_data',
                            '<?php echo url('bank_reconciliation'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    </div>   

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->



    <script>
              //toggle to check/uncheck all (this.id,class)
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


    </script>

@endsection