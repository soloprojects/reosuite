<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            @if($edit->contact_type == Utility::CUSTOMER && !empty($edit->vendor_customer))
            <div class="col-sm-4">
                Preferred Customer/Client
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->vendorCon->name}}" autocomplete="off" id="select_customer_edit" onkeyup="searchOptionListVenCust('select_customer_edit','myULCustomer_edit','{{url('default_select')}}','search_customer','customer');" name="select_user" placeholder="Select Customer">

                        <input type="hidden" class="" value="{{$edit->vendor_customer}}" name="pref_customer" id="customer_edit" />
                    </div>
                </div>
                <ul id="myULCustomer_edit" class="myUL"></ul>
            </div>
            @endif

            @if($edit->contact_type == Utility::VENDOR && !empty($edit->vendor_customer))
            <div class="col-sm-4">
                Preferred Vendor
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->vendorCon->name}}" autocomplete="off" id="select_vendor_edit" onkeyup="searchOptionListVenCust('select_vendor_edit','myULVendor_edit','{{url('default_select')}}','search_vendor','vendor');" name="select_vendor" placeholder="Select Vendor">

                        <input type="hidden" class="" value="{{$edit->vendor_customer}}" name="vendor" id="vendor_edit" />
                    </div>
                </div>
                <ul id="myULVendor_edit" class="myUL"></ul>
            </div>
            @endif

            @if(!empty($edit->employee_id) && empty($edit->contact_type))
            <div class="col-sm-4">
                <b>Employee</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" autocomplete="off" value="{{$edit->employee->firstname}} {{$edit->employee->lastname}}" id="select_user_edit" onkeyup="searchOptionList('select_user_edit','myUL1_edit','{{url('default_select')}}','default_search','user_edit');" name="select_user" placeholder="Department Head">

                        <input type="hidden" value="{{$edit->employee_id}}" name="employee" id="user_edit" />
                    </div>
                </div>
                <ul id="myUL1_edit" class="myUL"></ul>
            </div>
            @endif

            <div class="col-sm-4">
                <div class="form-group">
                    Posting Date
                    <div class="form-line">
                        <input type="text" class="form-control datepicker4" value="{{$edit->post_date}}" id="posting_date_edit" name="posting_date" placeholder="Posting Date">
                    </div>
                </div>
            </div>
                        
        </div>
                
        <!-- Include edit form -->
        @include('includes.trans_sub_form_edit',['transClass' => $transClass, 'transLocation' => $transLocation])
        
        @if($edit->transaction_type == Finance::journalEntry)
        <div class="row clearfix">
            @php $checkStatus = ($edit->cash_status == 1) ? 'checked' : ''  @endphp
            <span class="pull-right"><b>Cash Transaction (Absence of AP/AR)</b>
            <input name="cash_transaction_status" type="radio" id="edit_radio_30" {{$checkStatus}} value="1" class="with-gap radio-col-green" />
            <label for="edit_radio_30">YES</label>

            <input name="cash_transaction_status" type="radio" id="edit_radio_31" {{$checkStatus}} value="0" class="with-gap radio-col-red" />
            <label for="edit_radio_31">NO</label>
            </span>
        </div>
        @endif

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
                    <th>Account</th>
                    <th>Description</th>
                    <th class="">Account Type</th>
                    <th class="">Debit {{Utility::defaultCurrency()}}</th>
                    <th class="">Credit {{Utility::defaultCurrency()}}</th>
                    <th>Remove</th>
                </tr>
                </thead>
                <tbody id="add_more_acc_edit">

                <?php $num = 1000; $num2 = 0; $num1 = 0; $countDataAcc = []; $countDataPo = []; ?>
                @foreach($journalEntryData as $po)

                    @if($po->chart_id != '' )
                        <?php $num++; $num1++; $countDataAcc[] = $num2; ?>
                        <tr id="itemId{{$po->id}}">

                            <td scope="row">
                                <input value="{{$po->id}}" type="checkbox" id="po_id{{$po->id}}" class="" />

                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="" value="{{$po->chartData->acct_name}}" autocomplete="off" id="select_acc{{$num}}" onkeyup="searchOptionList('select_acc{{$num}}','myUL500_acc{{$num}}','{{url('default_select')}}','search_accounts','acc500{{$num}}');" name="select_user" placeholder="Select Account">

                                            <input type="hidden" value="{{$po->chart_id}}" class=""  name="acc_class{{$num1}}" id="acc500{{$num}}" />
                                        </div>
                                    </div>
                                    <ul id="myUL500_acc{{$num}}" class="myUL"></ul>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class=" " name="acc_desc{{$num1}}" id="acc_desc{{$num}}" placeholder="Description">{{$po->trans_desc}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>         
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="" name="debit_credit{{$num1}}" id="debit_credit{{$num}}" onchange="makeReadOnly('debit_credit{{$num}}','debit_account{{$num}}','credit_account{{$num}}','debit_account_hidden{{$num}}','credit_account_hidden{{$num}}')">
                                                <option selected value="{{$po->debit_credit}}">{{$po->accountType->trans_name}}</option>
                                                <option value="">Select Account Type</option>                            
                                                <option value="{{Utility::DEBIT_TABLE_ID}}">DEBIT</option>                                                
                                                <option value="{{Utility::CREDIT_TABLE_ID}}">CREDIT</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                @php $debitDisplay = ($po->debit_credit == Utility::DEBIT_TABLE_ID ) ? '':'disabled'; @endphp
                                @php $debitAmount = ($po->debit_credit == Utility::DEBIT_TABLE_ID ) ? $po->trans_total:''; @endphp
                                @php $debitHidden = ($po->debit_credit == Utility::DEBIT_TABLE_ID ) ? $po->trans_total:'0.00'; @endphp
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" onchange="reflectToHidden('debit_account{{$num}}','debit_account_hidden{{$num}}')" value="{{$debitAmount}}" {{$debitDisplay}} class="" name="debit_acount{{$num1}}" id="debit_account{{$num}}" placeholder="Debit">
                                        </div>
                                    </div>
                                </div>
                                <input type='hidden' value='{{$debitHidden}}' class="checkmate_debit_edit" name="debit_account_hidden{{$num1}}" id="debit_account_hidden{{$num}}">
                            </td>

                            <td>
                                @php $creditDisplay = ($po->debit_credit == Utility::CREDIT_TABLE_ID ) ? '':'disabled'; @endphp
                                @php $creditAmount = ($po->debit_credit == Utility::CREDIT_TABLE_ID ) ? $po->trans_total:''; @endphp
                                @php $creditHidden = ($po->debit_credit == Utility::CREDIT_TABLE_ID ) ? $po->trans_total:'0.00'; @endphp
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" onchange="reflectToHidden('credit_account{{$num}}','credit_account_hidden{{$num}}')" value="{{$creditAmount}}" {{$creditDisplay}} class="" name="credit_account{{$num1}}" id="credit_account{{$num}}" placeholder="Credit">
                                        </div>
                                    </div>
                                </div>
                                <input type='hidden' value="{{$creditHidden}}" class="checkmate_credit_edit" name="credit_account_hidden{{$num1}}" id="credit_account_hidden{{$num}}">
                            </td>
                           
                            <td></td>

                            <td class="center-align" id="">
                                <div class="form-group">
                                    <div style="cursor: pointer;" id="" onclick="uiItemDelete('itemId{{$po->id}}')">
                                        <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                                    </div>
                                </div>
                            </td>

                        </tr>

                        <input type="hidden" name="acc_id{{$num1}}" value="{{$po->id}}" >
                    @endif
                @endforeach

                <tr>
                    <td class="center-align" id="hide_button_acc_edit">
                        <div class="form-group center-align">
                            <div onclick="addMore('add_more_acc_edit','hide_button_acc_edit','10000','<?php echo URL::to('add_more'); ?>','journal_entry_edit','hide_button_acc_edit');">
                                <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                            </div>
                        </div>
                    </td>


                </tr>

                <input type="hidden" name="count_ext_acc" value="<?php echo count($countDataAcc); ?>" >
                </tbody>
            </table>

        </div>
        <hr/>
        
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
    <input type="hidden" name="edit_uid" value="{{$edit->uid}}" >
    <input type="hidden" name="update_status" value="1" >
</form>

<?php $attach = json_decode($edit->attachment,true); $num=0; ?>
@if(empty($attach))
    No Document
@else

    <table class="table table-responsive">
        <thead>
        <th> Attachment</th>
        <th>Download/Open</th>
        <th>Remove Attachment</th>
        </thead>
        <tbody>
        @foreach($attach as $at)
            <?php $num++; ?>
            <tr id="removeAttach{{$num}}">
                <td>File{{$num}}</td>
                <td><a target="_blank" href="<?php echo URL::to('po_download_attachment?file='); ?>{{$at}}">
                        <i class="fa fa-files-o fa-2x"></i>
                    </a></td>
                <td>

                    <form name="" id="removeAttachForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="hidden" value="{{$at}}"  class="form-control" name="attachment" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                    </form>

                    <button type="button"  onclick="removeMediaForm('removeAttach{{$num}}','removeAttachForm','<?php echo url('journal_entry_remove_attachment'); ?>','reload_data',
                            '<?php echo url('journal_entry'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-danger waves-effect">
                        Remove
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

@if($edit->transaction_type == Finance::journalEntry)
<div class="modal-footer">
<button type="button"  onclick="submitMediaFormClass('editModal','editMainForm','<?php echo url('edit_journal_entry'); ?>','reload_data',
    '<?php echo url('journal_entry'); ?>','<?php echo csrf_token(); ?>',['acc_class_edit','acc_desc_edit',
    'debit_account_hidden_edit','credit_account_hidden_edit','debit_credit_edit','checkmate_debit_edit',
    'checkmate_credit_edit'])" class="btn btn-info waves-effect">
SAVE CHANGES
</button>
</div>
@endif


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