<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            
            <div class="col-sm-4">
                Payment Account
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" autocomplete="off" id="select_acc" onkeyup="searchOptionList('select_acc','myUL500_acc','{{url('default_select')}}','search_accounts','acc500');" name="select_account" placeholder="Select Account">

                        <input type="hidden" value="" class=""  name="receipt_account" id="acc500" />
                    </div>
                </div>
                <ul id="myUL500_acc" class="myUL"></ul>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    Posting Date
                    <div class="form-line">
                        <input type="text" class="form-control datepicker4" value="" id="" name="posting_date" placeholder="Posting Date">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    Amount Received/Total Amount
                    <div class="form-line">
                        <input type="text" disabled class="form-control" value="" id="sum_total" name="payment_amount" placeholder="Payment Amount">
                    
                        <input type="hidden" value="0.00" id="sum_total_hidden" name="total_amount" placeholder="Payment Amount">
                    </div>
                </div>
                
            </div>
                        
        </div>
        <div class="row clearfix">
            <div class="col-sm-4">
                Payment Method
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="payment_method" >
                            <option value="">Select Payment Method</option>
                            @foreach($paymentMethod as $val)                                                
                            <option value="{{$val->id}}">{{$val->name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    File/Ref No
                    <div class="form-line">
                        <input type="text" class="form-control " value="" id="" name="file_no" placeholder="File/Ref No">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                File
                <div class="form-group">
                    <div class="form-line">
                        <input type="file" multiple="multiple" class="form-control" name="file[]" >
                    </div>
                </div>
            </div>
        </div>
                
        <!-- Include edit form -->
        
      
        <div class="row clearfix">
            <h4>Account Section</h4>
            <!-- TABLE FOR THE ACCOUNT SECTION -->
            <table class="table table-bordered table-hover table-striped" id="account_main_table_edit">
                <thead>
                <tr>
                    <th>
                        <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                               name="check_all" class="" />

                    </th>
                    <th>Customer</th>                    
                    <th class="">Open Balance {{Utility::defaultCurrency()}}</th>
                    <th class="">Credit {{Utility::defaultCurrency()}}</th>
                    <th class="">Credit Applied {{Utility::defaultCurrency()}}</th>
                    <th class="">Payment {{Utility::defaultCurrency()}}</th>
                    <th class="">Total Amount {{Utility::defaultCurrency()}}</th>
                    <th>File/Ref No.</th>
                    <th class="">Due Date</th>
                    <th class="">Original Amount {{Utility::defaultCurrency()}}</th>
                </tr>
                </thead>
                <tbody id="">

                <?php $num = 1000; $num2 = 0; $num1 = 0; $countDataAcc = []; $countDataPo = []; ?>
                @foreach($journalEntry as $po)

                    @if(!empty($po->vendor_customer) )
                        <?php $num++; $num1++; $countDataAcc[] = $num2; ?>
                        <tr id="itemId{{$po->id}}">

                            <td scope="row">
                                <input value="{{$po->id}}" type="checkbox" id="po_id{{$po->id}}" class="" />

                            </td>

                            <td>
                                <div class="col-sm-4">                                    
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="" disabled value="{{$po->vendorCon->name}}" autocomplete="off" >
                    
                                            <input type="hidden" class="" value="{{$po->vendor_customer}}" name="contact{{$num1}}" id="customer{{$po->id}}" />
                                        </div>
                                    </div>
                                    <ul id="myULCustomer{{$po->id}}" class="myUL"></ul>
                                </div>                    
                            </td>
                            
                            <td>         
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" disabled  id="" value="{{$po->balance_trans}}" />
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="default_total{{$num1}}" value="{{$po->balance_trans}}" id="default_total{{$po->id}}" />
                            </td>
                            <td>         
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" disabled value="{{$po->creditBalance}}" class="curr_credit{{$po->vendor_customer}}" />
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="{{$po->vendor_customer}}contact_curr_credit_bal{{$num1}}" value="{{$po->creditBalance}}" class="curr_credit{{$po->vendor_customer}}" />
                                
                                <input type="hidden" name="{{$po->vendor_customer}}contact_default_credit_bal{{$num1}}" value="{{$po->creditBalance}}" class="default_credit{{$po->vendor_customer}}" />
                                                
                            </td>
                            <td>         
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" name="credit_applied{{$num1}}" id="credit_applied{{$po->id}}" class="credit_applied_class"
                                            onkeyup="DebitCreditMemoApply('credit_applied{{$po->id}}','credit_applied_class','default_credit{{$po->vendor_customer}}','curr_credit{{$po->vendor_customer}}','payment{{$po->id}}','default_total{{$po->id}}','curr_total{{$po->id}}','curr_total_hidden{{$po->id}}','sum_total','sum_total_hidden','total_amount')" />
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>         
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" name="payment{{$num1}}" id="payment{{$po->id}}"
                                            onkeyup="financePaymentOrReceipt('credit_applied{{$po->id}}','payment{{$po->id}}','curr_total{{$po->id}}','default_total{{$po->id}}','curr_total_hidden{{$po->id}}','sum_total','sum_total_hidden','total_amount')" />
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <td>         
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" disabled id="curr_total{{$po->id}}" />
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="total_amount" name="curr_total{{$num1}}" id="curr_total_hidden{{$po->id}}" />
                            </td>
                            
                            <td>
                                <div class="col-sm-3">
                                    @php $fileNo = (!empty($po->file_no)) ? $po->file_no : $po->id  @endphp
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" disabled name="file_no{{$num1}}" id="" value="{{$fileNo}}" />
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>         
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" disabled name="due_date{{$num1}}" id="" value="{{$po->transTerms->days_due}}" />
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>         
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" disabled name="original_amount{{$num1}}" id="" value="{{$po->trans_total}}" />
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>

                        <input type="hidden" name="journal_id{{$num1}}" value="{{$po->id}}" >
                    @endif
                @endforeach
               
                <input type="hidden" name="count_ext" value="<?php echo count($countDataAcc); ?>" >
                </tbody>
            </table>

        </div>
        <hr/>
        
    </div>
    <input type="hidden" name="edit_id" value="{{$po->id}}" >
    <input type="hidden" name="edit_uid" value="{{$po->uid}}" >
    <input type="hidden" name="transaction_type" value="{{Finance::existingBillCashPayment}}" >
    <input type="hidden" name="credit_transaction_type" value="{{Finance::vendorCredit}}" >
</form>

<script>
    $(function() {
        $( ".datepicker4" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
            /*yearRange: "-90:+00"*/

        });
    });

</script>