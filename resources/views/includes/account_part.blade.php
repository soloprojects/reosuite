<table class="table table-bordered table-hover table-striped" id="account_main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Account</th>
        <th>Description</th>
        <th class="">Rate/Amount <span class="foreign_amount"></span></th>
        <th>Tax</th>
        <th>Tax (%)</th>
        <th class="">Tax (Amount) <span class="foreign_amount"></span></th>
        <th>Discount (%)</th>
        <th class="">Discount (Amount) <span class="foreign_amount"></span></th>
        <th class="">Sub Total <span class="foreign_amount_edit"></span></th>
        <th>Manage</th>
        <th>Add</th>
        <th>Remove</th>
    </tr>
    </thead>
    <tbody id="add_more_acc">
    <tr>

        <td scope="row">
            <input value="" type="checkbox" id="" class="" />

        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_acc" onkeyup="searchOptionListAcc('select_acc','myUL500_acc','{{url('default_select')}}','search_accounts','acc500','vendorCust','posting_date');" name="select_user" placeholder="Select Account">

                        <input type="hidden" class="acc_class" value="" name="user" id="acc500" />
                    </div>
                </div>
                <ul id="myUL500_acc" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class=" acc_desc" name="item_desc" id="item_desc_acc" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" shared_rate acct_rate" name="unit_cost" id="unit_cost_acc" placeholder="Rate/Cost Amount"
                        onkeyup="accountSum('sub_total_acc','acc500','unit_cost_acc','discount_amount_acc','tax_amount_acc','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct_acc','discount_perct_acc')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" acc_tax shared_tax" name="tax" id="tax_acc"
                        onchange="fillNextInputTaxAcc('tax_acc','tax_perct_acc','{{url('default_select')}}','get_tax','sub_total_acc','unit_cost_acc','acc500','discount_amount_acc','tax_amount_acc','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct_acc','discount_perct_acc')">
                                <option value="">Select Tax</option>
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
                        <input type="number" class=" acc_tax_perct shared_tax_perct" name="tax_perct" id="tax_perct_acc" placeholder="Tax Percentage"
                               onkeyup="percentToAmount('tax_perct_acc','tax_amount_acc','sub_total_acc','unit_cost_acc','acc500','','discount_amount_acc','tax_amount_acc','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" acc_tax_amount shared_tax_amount" name="tax_amount" id="tax_amount_acc" placeholder="Tax Amount"
                               onkeyup="accountSum('sub_total_acc','acc500','unit_cost_acc','discount_amount_acc','tax_amount_acc','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct_acc','discount_perct_acc')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" acc_discount_perct shared_discount_perct" name="discount_perct" id="discount_perct_acc" placeholder="Discount Percentage"
                               onkeyup="percentToAmount('discount_perct_acc','discount_amount_acc','sub_total_acc','unit_cost_acc','acc500','','discount_amount_acc','tax_amount_acc','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" acc_discount_amount shared_discount_amount" name="discount_amount" id="discount_amount_acc" placeholder="Discount Amount"
                               onkeyup="accountSum('sub_total_acc','acc500','unit_cost_acc','discount_amount_acc','tax_amount_acc','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct_acc','discount_perct_acc')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" acc_sub_total shared_sub_total" readonly name="sub_total" id="sub_total_acc" placeholder="Sub Total" >
                    </div>
                </div>
            </div>
        </td>
        <td></td>

        <td class="center-align" id="hide_button_acc">
            <div class="form-group center-align">
                <div onclick="addMore('add_more_acc','hide_button_acc','1','<?php echo URL::to('add_more'); ?>','acc','hide_button_acc');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td></td>

    </tr>

    </tbody>
</table>

