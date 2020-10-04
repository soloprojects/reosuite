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
        <p class="text-center" style="font-weight:bold" id="deposits">0.00</p><br/>
        <p class="text-center"> <span style="font-weight: bold" id="deposit_num">0</span> Deposit(s) {{\App\Helpers\Utility::defaultCurrency()}}</p>
    </div>

    <div class="col-md-4">
        <p class="text-center" style="font-weight:bold" id="payments">0.00</p><br>
        <p class="text-center">---  <span style="font-weight: bold" id="payment_num">0</span> Payment(s) {{\App\Helpers\Utility::defaultCurrency()}} </p>
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
                    <th>Ref No.</th>
        
                </tr>
                </thead>
                <tbody>
                @foreach($deposits as $data)
                <tr>
                    <td scope="row">
                        <input value="{{$data->id}}" type="checkbox" id="deposit_{{$data->id}}" 
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
                    <td>
                        @if(!empty($data->file_no))
                        {{$data->file_no}}
                        @else
                        {{$data->id}}
                        @endif
                    </td>
        
        
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
                    <th>Ref No.</th>
        
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $data)
                <tr>
                    <td scope="row">
                        <input value="{{$data->id}}" type="checkbox" id="payment_{{$data->id}}" 
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
                    <td>
                        @if(!empty($data->file_no))
                        {{$data->file_no}}
                        @else
                        {{$data->id}}
                        @endif
                    </td>
        
        
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
        <input type="hidden" name="payments" value="0.00" id="payments_hidden">
        <input type="hidden" name="deposits" value="0.00" id="deposits_hidden">
        <input type="hidden" name="payment_num" value="0" id="payment_num_hidden">
        <input type="hidden" name="deposit_num" value="0" id="deposit_num_hidden">
        <input type="hidden" name="difference_balance" value="{{$balanceDifference}}" id="difference_balance_hidden">
        <input type="hidden" name="account_category" value="{{$accountData->acct_cat_id}}" >
        <input type="hidden" name="account_id" value="{{$accountData->id}}" >
        <input type="hidden" name="ending_date" value="{{$endingDate}}" >
        <input type="hidden" name="begining_date" value="{{$beginingDate}}" >
        <input type="hidden" name="update_status" value="0" >

    </form>

</div>

<div class="row">
    <button onclick="submitReconcileForm('processReconciliation','<?php echo url('bank_reconciliation_create'); ?>','reload_data',
        '<?php echo url('bank_reconciliation'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
    SAVE
</button>
</div>



