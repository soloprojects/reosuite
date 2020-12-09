<table class="table table-bordered table-hover table-striped" id="inv_main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>


        <th>Inventory Item</th>
        <th>Description</th>
        <th>Quantity</th>
        <th class="">Rate <span class="foreign_amount"></span></th>
        <th>Unit Measure</th>
        <th>Tax</th>
        <th>Tax (%)</th>
        <th class="">Tax (Amount) <span class="foreign_amount"></span></th>
        <th>Discount (%)</th>
        <th class="">Discount (Amount) <span class="foreign_amount_edit"></span></th>
        <th class="">Sub Total <span class="foreign_amount_edit"></span></th>
        <th>Manage</th>
        <th>Add</th>
        <th>Remove</th>
    </tr>
    </thead>
    <tbody id="add_more_inv">
    <tr>

        <td scope="row">
            <input value="" type="checkbox" id="" class="" />

        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_inv" onkeyup="searchOptionListInventory('select_inv','myUL500','{{url('default_select')}}','search_inventory_transact','inv500','item_desc','unit_cost','unit_measure','sub_total','shared_sub_total','overall_sum','foreign_overall_sum','qty','vendorCust','posting_date','total_tax_amount','{{\App\Helpers\Utility::SALES_DESC}}');" name="select_user" placeholder="Inventory Item">

                        <input type="hidden" class="inv_class" value="" name="inventory" id="inv500" />
                    </div>
                </div>
                <ul id="myUL500" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class=" item_desc" name="item_desc" id="item_desc" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" quantity" name="quantity" id="qty" placeholder="Quantity"
                               onkeyup="itemSum('sub_total','unit_cost','inv500','qty','discount_amount','tax_amount','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct','discount_perct')"
                               onchange="itemSum('sub_total','unit_cost','inv500','qty','discount_amount','tax_amount','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct','discount_perct')">
                            </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" unit_cost shared_rate"  name="unit_cost" id="unit_cost" placeholder="Unit Cost/Rate"
                               onkeyup="itemSum('sub_total','unit_cost','inv500','qty','discount_amount','tax_amount','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct','discount_perct')"
                               onchange="itemSum('sub_total','unit_cost','inv500','qty','discount_amount','tax_amount','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct','discount_perct')">
                            </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" unit_measure" readonly name="unit_measure" id="unit_measure" placeholder="Unit Measure" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" tax shared_tax" name="tax" id="tax"
                                onchange="fillNextInputTax('tax','tax_perct','{{url('default_select')}}','get_tax','sub_total','unit_cost','inv500','qty','discount_amount','tax_amount','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct','discount_perct')">
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
                        <input type="number" class=" tax_perct shared_tax_perct" name="tax_perct" id="tax_perct" placeholder="Tax Percentage"
                               onkeyup="percentToAmount('tax_perct','tax_amount','sub_total','unit_cost','inv500','qty','discount_amount','tax_amount','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')"
                               onchange="percentToAmount('tax_perct','tax_amount','sub_total','unit_cost','inv500','qty','discount_amount','tax_amount','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')">
                            </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" tax_amount shared_tax_amount" name="tax_amount" id="tax_amount" placeholder="Tax Amount"
                               onkeyup="itemSum('sub_total','unit_cost','inv500','qty','discount_amount','tax_amount','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct','discount_perct')"
                               onchange="itemSum('sub_total','unit_cost','inv500','qty','discount_amount','tax_amount','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct','discount_perct')">
                            </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" discount_perct shared_discount_perct" name="discount_perct" id="discount_perct" placeholder="Discount Percentage"
                               onkeyup="percentToAmount('discount_perct','discount_amount','sub_total','unit_cost','inv500','qty','discount_amount','tax_amount','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')"
                               onchange="percentToAmount('discount_perct','discount_amount','sub_total','unit_cost','inv500','qty','discount_amount','tax_amount','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')">
                            </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" discount_amount shared_discount_amount" name="discount_amount" id="discount_amount" placeholder="Discount Amount"
                               onkeyup="itemSum('sub_total','unit_cost','inv500','qty','discount_amount','tax_amount','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct','discount_perct')"
                               onchange="itemSum('sub_total','unit_cost','inv500','qty','discount_amount','tax_amount','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct','discount_perct')">
                            </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" sub_total shared_sub_total" readonly name="sub_total" id="sub_total" placeholder="Sub Total" >
                    </div>
                </div>
            </div>
        </td>

        <td></td>
        <td class="col-sm-4" id="hide_button_inv">
            <div class="form-group">
                <div onclick="addMore('add_more_inv','hide_button_inv','1','<?php echo URL::to('add_more'); ?>','get_inv_sales','hide_button_inv');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>

    </tbody>
</table>

