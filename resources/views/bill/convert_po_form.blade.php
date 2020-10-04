<form name="" id="convertPoForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            
            <div class="col-sm-4">
                Preferred Vendor
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->vendorCon->name}}" autocomplete="off" id="select_vendor_edit" onkeyup="searchOptionListVenCust('select_vendor_edit','myUL1_edit','{{url('default_select')}}','search_vendor_transact','vendorCust_edit','foreign_amount','<?php echo url('vendor_customer_currency') ?>','overall_sum_edit','{{\App\Helpers\Utility::VENDOR}}','vendorCust_edit','posting_date_edit','vendor_address_edit','curr_rate_edit','foreign_overall_sum_edit');" name="select_user" placeholder="Select Vendor">

                        <input type="hidden" class="user_class" value="{{$edit->vendor}}" name="pref_vendor" id="vendorCust_edit" />
                    </div>
                </div>
                <ul id="myUL1_edit" class="myUL"></ul>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    Posting Date
                    <div class="form-line">
                        <input type="text" class="form-control datepicker4" value="{{$edit->post_date}}" id="posting_date_edit" onkeyup="exchangeRate('vendorCust_edit','curr_rate_edit','posting_date','<?php echo url('exchange_rate'); ?>')" name="posting_date" placeholder="Posting Date">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    Vendor Address
                    <div class="form-line">
                        <textarea class="form-control" readonly id="vendor_address_edit" name="vendor_address" placeholder="Vendor Address">{{$edit->vendorCon->address}}</textarea>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    Terms
                    <div class="form-line">
                        <select class="form-control " name="terms" >                        
                            @foreach($terms as $val)                                                
                            <option value="{{$val->id}}">{{$val->name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Include form -->
        @include('includes.trans_sub_form',['transClass' => $transClass, 'transLocation' => $transLocation])
                 
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
                    <th class="">Rate/Amount <span class="foreign_amount_edit"></span></th>
                    <th>Tax</th>
                    <th>Tax (%)</th>
                    <th class="">Tax (Amount) <span class="foreign_amount_edit"></span></th>
                    <th>Discount (%)</th>
                    <th class="">Discount (Amount) <span class="foreign_amount_edit"></span></th>
                    <th class="">Sub Total <span class="foreign_amount_edit"></span></th>
                    <th>Remove</th>
                </tr>
                </thead>
                <tbody id="add_more_acc_edit">

                <?php $num = 1000; $num2 = 0; $num1 = 0; $countDataAcc = []; $countDataPo = []; ?>
                @foreach($poData as $po)

                    @if($po->account_id != '')
                        <?php $num++; $num1++; $countDataAcc[] = $num2; ?>
                        <tr id="itemId{{$po->id}}">

                            <td scope="row">
                                <input value="{{$po->id}}" type="checkbox" id="po_id{{$po->id}}" class="" />

                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="" value="{{$po->account->acct_name}}" autocomplete="off" id="select_acc{{$num}}" onkeyup="searchOptionListAcc('select_acc{{$num}}','myUL500_acc{{$num}}','{{url('default_select')}}','search_accounts','acc500{{$num}}','vendorCust_edit','posting_date_edit');" name="select_user" placeholder="Select Account">

                                            <input type="hidden" value="{{$po->account_id}}" class=""  name="acc_class{{$num1}}" id="acc500{{$num}}" />
                                        </div>
                                    </div>
                                    <ul id="myUL500_acc{{$num}}" class="myUL"></ul>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class=" " name="item_desc_acc{{$num1}}" id="item_desc_acc{{$num}}" placeholder="Description">{{$po->po_desc}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" value="{{$po->unit_cost_trans}}" class=" shared_rate_edit " name="unit_cost_acc{{$num1}}" id="unit_cost_acc{{$num}}" placeholder="Rate/Cost Amount"
                                                   onkeyup="accountSum('sub_total_acc{{$num}}','acc500{{$num}}','unit_cost_acc{{$num}}','discount_amount_acc{{$num}}','tax_amount_acc{{$num}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct_acc{{$num}}','discount_perct_acc{{$num}}')">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class=" shared_tax_edit" name="tax_acc{{$num1}}" id="tax_acc{{$num}}"
                                                    onchange="fillNextInputTaxAcc('tax_acc{{$num}}','tax_perct_acc{{$num}}','{{url('default_select')}}','get_tax','sub_total_acc{{$num}}','unit_cost_acc{{$num}}','acc500{{$num}}','discount_amount_acc{{$num}}','tax_amount_acc{{$num}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct_acc{{$num}}','discount_perct_acc{{$num}}')">
                                                <option value="">Enter tax Manually</option>
                                                @foreach(\App\Helpers\Utility::taxData() as $inv)
                                                    <option value="{{$inv->id}}">{{$inv->tax_name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" value="{{$po->tax_perct}}" class=" shared_tax_perct_edit" name="tax_perct_acc{{$num1}}" id="tax_perct_acc{{$num}}" placeholder="Tax Percentage"
                                                   onkeyup="percentToAmount('tax_perct_acc{{$num}}','tax_amount_acc{{$num}}','sub_total_acc{{$num}}','unit_cost_acc{{$num}}','acc500{{$num}}','','discount_amount_acc{{$num}}','tax_amount_acc{{$num}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit')">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" value="{{$po->tax_amount_trans}}" class="  shared_tax_amount_edit" name="tax_amount_acc{{$num1}}" id="tax_amount_acc{{$num}}" placeholder="Tax Amount"
                                                   onkeyup="accountSum('sub_total_acc{{$num}}','acc500{{$num}}','unit_cost_acc{{$num}}','discount_amount_acc{{$num}}','tax_amount_acc{{$num}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct_acc{{$num}}','discount_perct_acc{{$num}}')">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" value="{{$po->discount_perct}}" class=" shared_discount_perct_edit" name="discount_perct_acc{{$num1}}" id="discount_perct_acc{{$num}}" placeholder="Discount Percentage"
                                                   onkeyup="percentToAmount('discount_perct_acc{{$num}}','discount_amount_acc{{$num}}','sub_total_acc{{$num}}','unit_cost_acc{{$num}}','acc500{{$num}}','','discount_amount_acc{{$num}}','tax_amount_acc{{$num}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit')">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" value="{{$po->discount_amount_trans}}" class=" shared_discount_amount_edit" name="discount_amount_acc{{$num1}}" id="discount_amount_acc{{$num}}" placeholder="Discount Amount"
                                                   onkeyup="accountSum('sub_total_acc{{$num}}','acc500{{$num}}','unit_cost_acc{{$num}}','discount_amount_acc{{$num}}','tax_amount_acc{{$num}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct_acc{{$num}}','discount_perct_acc{{$num}}')">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" value="{{$po->extended_amount_trans}}" class=" shared_sub_total_edit" readonly name="sub_total_acc{{$num1}}" id="sub_total_acc{{$num}}" placeholder="Sub Total" >
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td></td>

                            <td class="center-align" id="{{$po->unit_cost_trans}}">
                                <div class="form-group">
                                    <div style="cursor: pointer;" id="" onclick="tempItemDeleteConvert('itemId{{$po->id}}','<?php echo url('delete_bill_item_convert') ?>','{{$po->id}}','{{$po->extended_amount_trans}}','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','tax_amount_acc{{$num}}','discount_amount_acc{{$num}}','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','{{$po->po_id}}','<?php echo url('update_sum') ?>','reload_data','{{url('bill')}}','journal_extention')">
                                        <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                                    </div>
                                </div>
                            </td>

                        </tr>

                        <input type="hidden" name="accId{{$num1}}" value="{{$po->id}}" >
                    @endif
                @endforeach

                <tr>
                    <td class="center-align" id="hide_button_acc_edit">
                        <div class="form-group center-align">
                            <div onclick="addMore('add_more_acc_edit','hide_button_acc_edit','100','<?php echo URL::to('add_more'); ?>','acc_edit','hide_button_acc_edit');">
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

        <!-- ITEM SECTION BEGINS HERE -->
        <div class="row clearfix">
            <h4>Item Section</h4>

            <table class="table table-bordered table-hover table-striped" id="po_main_table_edit">
                <thead>
                <tr>
                    <th>
                        <input type="checkbox" onclick="toggleme(this,'kid_checkbox_po_edit');" id="parent_check_po_edit"
                               name="check_all_po_edit" class="" />

                    </th>


                    <th>Inventory Item</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th class="">Rate <span class="foreign_amount_edit"></span></th>
                    <th>Unit Measure</th>
                    <th>Tax</th>
                    <th>Tax (%)</th>
                    <th class="">Tax (Amount) <span class="foreign_amount_edit"></span></th>
                    <th>Discount (%)</th>
                    <th class="">Discount (Amount) <span class="foreign_amount_edit"></span></th>
                    <th class="">Sub Total <span class="foreign_amount_edit"></span></th>
                    <th>Manage</th>
                    <th>Add</th>
                    <th>Remove</th>
                </tr>
                </thead>
                <tbody id="add_more_po_edit">

                @foreach($poData as $po)

                    @if(!empty($po->item_id))
                        <?php $num++; $num2++; $countDataPo[] = $num2; ?>
                        <tr id="itemId{{$po->id}}">

                            <td scope="row">
                                <input value="{{$po->id}}" type="checkbox" id="po_id{{$po->id}}"  class="kid_checkbox_po_edit" />

                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="" value="{{$po->inventory->item_name}}" autocomplete="off" id="select_inv{{$num}}" onkeyup="searchOptionListInventory('select_inv{{$num}}','myUL500{{$num}}','{{url('default_select')}}','search_inventory_transact','inv500{{$num}}','item_desc{{$num}}','unit_cost{{$num}}','unit_measure{{$num}}','sub_total{{$num}}','shared_sub_tota_edit','overall_sum_edit','foreign_overall_sum_edit','qty{{$num}}','vendorCust_edit','posting_date_edit','total_tax_amount_edit','{{\App\Helpers\Utility::SALES_DESC}}');" name="select_user" placeholder="Inventory Item">

                                            <input type="hidden" class="inv_class" value="{{$po->item_id}}" name="inv_class{{$num2}}" id="inv500{{$num}}" />
                                        </div>
                                    </div>
                                    <ul id="myUL500{{$num}}" class="myUL"></ul>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class=" " name="item_desc{{$num2}}" id="item_desc{{$num}}" placeholder="Description">{{$po->quote_desc}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class=" " value="{{$po->quantity}}" name="quantity{{$num2}}" id="qty{{$num}}" placeholder="Quantity"
                                                   onkeyup="itemSum('sub_total{{$num}}','unit_cost{{$num}}','inv500{{$num}}','qty{{$num}}','discount_amount{{$num}}','tax_amount{{$num}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num}}','discount_perct{{$num}}')">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" value="{{$po->unit_cost_trans}}" class=" shared_rate_edit " name="unit_cost{{$num2}}" id="unit_cost{{$num}}" placeholder="Rate/Cost Amount"
                                                   onkeyup="itemSum('sub_total{{$num}}','unit_cost{{$num}}','inv500{{$num}}','qty{{$num}}','discount_amount{{$num}}','tax_amount{{$num}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num}}','discount_perct{{$num}}')">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class=" " readonly value="{{$po->unit_measurement}}" name="unit_measure{{$num2}}" id="unit_measure{{$num}}" placeholder="Unit Measure" >
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class=" shared_tax_edit" name="tax{{$num2}}" id="tax{{$num}}"
                                                    onchange="fillNextInputTaxAcc('tax{{$num}}','tax_perct{{$num}}','{{url('default_select')}}','get_tax','sub_total{{$num}}','unit_cost{{$num}}','inv500{{$num}}','discount_amount{{$num}}','tax_amount{{$num}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num}}','discount_perct{{$num}}')">
                                                <option selected value="{{$po->tax_id}}">{{$po->taxVal->tax_name}}</option>
                                                @foreach(\App\Helpers\Utility::taxData() as $inv)
                                                    <option value="{{$inv->id}}">{{$inv->tax_name}}</option>
                                                @endforeach
                                                <option value="">Enter tax Manually</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" value="{{$po->tax_perct}}" class=" shared_tax_perct_edit" name="tax_perct{{$num2}}" id="tax_perct{{$num}}" placeholder="Tax Percentage"
                                                   onkeyup="percentToAmount('tax_perct{{$num}}','tax_amount{{$num}}','sub_total{{$num}}','unit_cost{{$num}}','inv500{{$num}}','qty{{$num}}','discount_amount{{$num}}','tax_amount{{$num}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit')">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" value="{{$po->tax_amount_trans}}" class="  shared_tax_amount_edit" name="tax_amount{{$num2}}" id="tax_amount{{$num}}" placeholder="Tax Amount"
                                                   onkeyup="itemSum('sub_total{{$num}}','unit_cost{{$num}}','inv500{{$num}}','qty{{$num}}','discount_amount{{$num}}','tax_amount{{$num}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','posting_date_edit','tax_perct{{$num}}','discount_perct{{$num}}')">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" value="{{$po->discount_perct}}" class="  shared_discount_perct_edit" name="discount_perct{{$num2}}" id="discount_perct{{$num}}" placeholder="Discount Percentage"
                                                   onkeyup="percentToAmount('discount_perct{{$num}}','discount_amount{{$num}}','sub_total{{$num}}','unit_cost{{$num}}','inv500{{$num}}','qty{{$num}}','discount_amount{{$num}}','tax_amount{{$num}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit')">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" value="{{$po->discount_amount_trans}}" class=" shared_discount_amount_edit" name="discount_amount{{$num2}}" id="discount_amount{{$num}}" placeholder="Discount Amount"
                                                   onkeyup="itemSum('sub_total{{$num}}','unit_cost{{$num}}','inv500{{$num}}','qty{{$num}}','discount_amount{{$num}}','tax_amount{{$num}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','posting_date_edit','tax_perct{{$num}}','discount_perct{{$num}}')">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" value="{{$po->extended_amount_trans}}" class=" shared_sub_total_edit" readonly name="sub_total{{$num2}}" id="sub_total{{$num}}" placeholder="Sub Total" >
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td></td>
                            <td class="center-align" id="{{$po->unit_cost_trans}}">
                                <div class="form-group">
                                    <div style="cursor: pointer;" id="" onclick="tempItemDeleteConvert('itemId{{$po->id}}','<?php echo url('delete_bill_item_convert') ?>','{{$po->id}}','{{$po->extended_amount_trans}}','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','tax_amount{{$num}}','discount_amount{{$num}}','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','{{$po->po_id}}','<?php echo url('update_sum') ?>','reload_data','{{url('bill')}}','journal_extention')">
                                        <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                                    </div>
                                </div>
                            </td>

                        </tr>

                        <input type="hidden" name="poId{{$num2}}" value="{{$po->id}}" >
                    @endif
                @endforeach

                <tr>
                    <td class="col-sm-4" id="hide_button_po_edit">
                        <div class="form-group">
                            <div onclick="addMore('add_more_po_edit','hide_button_po_edit','100','<?php echo URL::to('add_more'); ?>','get_inv_edit','hide_button_po_edit');">
                                <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                            </div>
                        </div>
                    </td>

                </tr>

                <input type="hidden" name="count_ext_po" value="<?php echo count($countDataPo) ?>" >

                </tbody>
            </table>

        </div>
        <hr/>
        <div class="row clearfix">

            <div class="row clearfix">

                <div class="col-sm-4">
                    <b>Select Discount Type</b>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control" name="discount_type" >
                                @if($edit->discount_type == \App\Helpers\Utility::LINE_ITEM_DISCOUNT)

                                    <option selected value="{{\App\Helpers\Utility::LINE_ITEM_DISCOUNT}}">Line Item Discount</option>
                                @else
                                    <option value="{{\App\Helpers\Utility::ONE_TIME_DISCOUNT}}">One time discount excluding line item discount(s)</option>
                                @endif
                                <option selected value="{{\App\Helpers\Utility::LINE_ITEM_DISCOUNT}}">Line Item Discount</option>
                                <option value="{{\App\Helpers\Utility::ONE_TIME_DISCOUNT}}">One time discount excluding line item discount(s)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 ">
                    <b>Total Discount Amount <span class="foreign_amount_edit"></span></b>
                    <div class="form-group ">
                        <div class="form-line">
                            <input type="number" class="form-control" value="{{$edit->discount_trans}}" readonly name="one_time_discount_amount_edit" id="total_discount_amount_edit" placeholder="Discount Amount" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <b>Total Discount Percentage</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="number" class="form-control" value="{{$edit->discount_perct}}" id="total_discount_perct_edit" onkeyup="genPercentage('total_discount_perct_edit','total_discount_amount_edit','overall_sum_edit','shared_sub_total_edit','vendorCust_edit','total_tax_amount_edit','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','vendorCust_edit','posting_date_edit','shared_discount_amount_edit','shared_rate')" name="one_time_discount_perct_edit" placeholder="Percentage" >
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <hr/>
        <div class="row clearfix">

            <div class="row clearfix">

                <div class="col-sm-4">
                    <b>Select Tax Type</b>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control" name="tax_type" >
                                @if($edit->tax_type == \App\Helpers\Utility::LINE_ITEM_TAX)

                                    <option selected value="{{\App\Helpers\Utility::LINE_ITEM_TAX}}">Line Item tax</option>
                                @else
                                    <option value="{{\App\Helpers\Utility::ONE_TIME_TAX}}">One time tax excluding line item tax(es)</option>
                                @endif
                                <option selected value="{{\App\Helpers\Utility::LINE_ITEM_TAX}}">Line Item Tax</option>
                                <option value="{{\App\Helpers\Utility::ONE_TIME_TAX}}">One time tax excluding line item tax(es)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php $exclTax = $edit->trans_total - $edit->tax_trans; ?>
                <div class="col-sm-4 ">
                    <b>Total Tax Amount <span class="foreign_amount_edit"></span></b>
                    <div class="form-group ">
                        <div class="form-line">
                            <input type="number" class="form-control" value="{{$edit->tax_trans}}" readonly name="one_time_tax_amount_edit" id="total_tax_amount_edit" placeholder="Tax Amount" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <b>Total Tax Percentage</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="number" class="form-control" value="{{$edit->tax_perct}}" id="total_tax_perct_edit" onkeyup="genPercentageTax('total_tax_perct_edit','total_tax_amount_edit','overall_sum_edit','shared_sub_total_edit','vendorCust_edit','total_discount_amount_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','vendorCust_edit','posting_date_edit')" name="one_time_discount_perct_edit" placeholder="Percentage" >
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <hr/>
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    Grand Total {{\App\Helpers\Utility::defaultCurrency()}}
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->sum_total}}" readonly id="foreign_overall_sum_edit" name="grand_total" placeholder="Grand Total Default Currency">
                    </div>
                </div>
            </div>
            <div class="col-sm-4 ">
                Grand Total(Incl. Tax) <span class="foreign_amount_edit"></span>
                <div class="form-group ">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->trans_total}}" id="overall_sum_edit" readonly name="grand_total_vendor_curr" placeholder="Grand Total Vendor Currency">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                Grand Total(Excl. Tax) <span class="foreign_amount"></span>
                <div class="form-group ">

                    <div class="form-line">
                        <input type="text" class="form-control" id="excl_overall_sum_edit" value="{{$exclTax}}" readonly name="" placeholder="Grand Total(Excl. Tax) Vendor Currency">
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row clearfix container">

            <div class="row clearfix">

                <div class="col-sm-4">
                    <b>Mail Option</b>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control" name="mail_option" >
                                <option selected value="1">Send Mail</option>
                                <option value="0">Do not send mail</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <b>Send Mail To</b>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea class="form-control" name="emails" id="emails" placeholder="Enter Email(s), use a comma to separate them" >{{$edit->mails}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <b>Attachment</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="file" class="form-control" multiple="multiple" name="file[]" >
                        </div>
                    </div>
                </div>

            </div>

            <div class="row clearfix">

                <div class="col-sm-4">
                    <b>Copy (cc)</b>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea class="form-control" name="mail_copy" id="copy_mails" placeholder="Enter Email(s), use a comma to separate them" >{{$edit->mail_copy}}</textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row clearfix">

                <textarea id="mail_message_po" name="message" class="ckeditor" placeholder="Message">{{$edit->message}}</textarea>
                <script>
                    CKEDITOR.replace('mail_message_po');
                </script>
                <script src="{{ asset('templateEditor/ckeditor/ckeditor.js') }}"></script>
            </div>

        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
    <input type="hidden" name="update_status" value="1" >
    <input type="hidden" name="convert_status" value="1" >
</form>

<?php $attach = json_decode($edit->attachment,true); $num=0; ?>
@if(count($attach) < 1)
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
                <td><a target="_blank" href="<?php echo URL::to('sales_download_attachment?file='); ?>{{$at}}">
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
                        <input type="hidden" name="update_status" value="1" >
                    </form>

                    <button type="button"  onclick="removeMediaForm('removeAttach{{$num}}','removeAttachForm','<?php echo url('sales_remove_attachment'); ?>','reload_data',
                            '<?php echo url('sales_order'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-danger waves-effect">
                        Remove
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
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