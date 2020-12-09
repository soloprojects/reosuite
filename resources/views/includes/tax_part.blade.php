<div class="row clearfix">

    <div class="col-sm-4">
        <b>Select Tax Type</b>
        <div class="form-group">
            <div class="form-line">
                <select class="form-control" name="tax_type" >
                        <option selected value="{{\App\Helpers\Utility::LINE_ITEM_TAX}}">Line Item Tax</option>
                        <option value="{{\App\Helpers\Utility::ONE_TIME_TAX}}">One time tax excluding line item tax(es)</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-4 ">
        <b>Total Tax Amount <span class="foreign_amount"></span></b>
        <div class="form-group">
            <div class="form-line">
                <input type="number" class="form-control" readonly name="one_time_tax_amount" id="total_tax_amount" placeholder="Tax Amount" >
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <b>Total Tax Percentage</b>
        <div class="form-group">
            <div class="form-line">
                <input type="number" class="form-control" id="total_tax_perct" 
                onkeyup="genPercentageTax('total_tax_perct','total_tax_amount','overall_sum','shared_sub_total','vendorCust','total_discount_amount','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','vendorCust','posting_date')"
                onchange="genPercentageTax('total_tax_perct','total_tax_amount','overall_sum','shared_sub_total','vendorCust','total_discount_amount','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','vendorCust','posting_date')"
                name="one_time_tax_perct" placeholder="Percentage" >
            </div>
        </div>
    </div>

</div>