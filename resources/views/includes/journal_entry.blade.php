<table class="table table-bordered table-hover table-striped" id="account_main_table">
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
                        <input type="text" class="" value="" autocomplete="off" id="select_acc" onkeyup="searchOptionList('select_acc','myUL500_acc','{{url('default_select')}}','search_accounts','acc500');" name="select_account" placeholder="Select Account">

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
                        <textarea class=" acc_desc" name="acc_desc " id="acc_desc" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" debit_credit" name="debit_credit" id="debit_credit" onchange="makeReadOnly('debit_credit','debit_account','credit_account','debit_account_hidden','credit_account_hidden')">
                            <option value="">Select Account Type</option>
                            
                            <option value="{{Utility::DEBIT_TABLE_ID}}">DEBIT</option>
                            
                            <option value="{{Utility::CREDIT_TABLE_ID}}">CREDIT</option>
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" onchange="reflectToHidden('debit_account','debit_account_hidden')" disabled class=" debit_account" name="debit_account" id="debit_account" placeholder="Debit">
                    </div>
                </div>
            </div>
            <input type='hidden' value="0.00" class="debit_account_hidden checkmate_debit" name="debit_account_hidden" id="debit_account_hidden">
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" onchange="reflectToHidden('credit_account','credit_account_hidden')" disabled class=" credit_account" name="credit_account" id="credit_account" placeholder="Credit">
                    </div>
                </div>
            </div>
            <input type='hidden' value="0.00" class="credit_account_hidden checkmate_credit" name="credit_account_hidden" id="credit_account_hidden">
        </td>

        <td></td>

        <td class="center-align" id="hide_button_acc">
            <div class="form-group center-align">
                <div onclick="addMore('add_more_acc','hide_button_acc','1000','<?php echo URL::to('add_more'); ?>','journal_entry','hide_button_acc');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td></td>

    </tr>

    </tbody>
</table>

