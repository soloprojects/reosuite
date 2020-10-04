<form name="editMainForm" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Name*</b>
                <div class="form-group">
                    <div class="form-line">
                    <input type="text" value="{{$edit->name}}" class="form-control" name="name" placeholder="Name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Default Account Payable*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_acc_edit1" value="{{$edit->accountPayable->acct_name}}" onkeyup="searchOptionList('select_acc_edit1','myUL_edit1','{{url('default_select')}}','search_accounts','acc_edit1');" name="select" placeholder="Select Account">

                    <input type="hidden" class="acc_class" value="{{$edit->default_account_payable}}" name="default_account_payable" id="acc_edit1" />
                    </div>
                </div>
                <ul id="myUL_edit1" class="myUL"></ul>
            </div>
            <div class="col-sm-4">
                <b>Default Account Receivable*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" value="{{$edit->accountReceivable->acct_name}}" autocomplete="off" id="select_acc_edit2" onkeyup="searchOptionList('select_acc_edit2','myUL_edit2','{{url('default_select')}}','search_accounts','acc_edit2');" name="select" placeholder="Select Account">

                        <input type="hidden" class="acc_class" value="{{$edit->default_account_receivable}}" name="default_account_receivable" id="acc_edit2" />
                    </div>
                </div>
                <ul id="myUL_edit2" class="myUL"></ul>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Default Sales Tax*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" value="{{$edit->salesTax->acct_name}}" autocomplete="off" id="select_acc_edit3" onkeyup="searchOptionList('select_acc_edit3','myUL_edit3','{{url('default_select')}}','search_accounts','acc_edit3');" name="select" placeholder="Select Account">

                        <input type="hidden" class="acc_class" value="{{$edit->default_sales_tax}}" name="default_sales_tax" id="acc_edit3" />
                    </div>
                </div>
                <ul id="myUL_edit3" class="myUL"></ul>
            </div>

            <div class="col-sm-4">
                <b>Default Purchase Tax</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" value="{{$edit->purchaseTax->acct_name}}" autocomplete="off" id="select_acc_edit4" onkeyup="searchOptionList('select_acc_edit4','myUL_edit4','{{url('default_select')}}','search_accounts','acc_edit4');" name="select" placeholder="Select Account">

                        <input type="hidden" class="acc_class" value="{{$edit->default_purchase_tax}}" name="default_purchase_tax" id="acc_edit1" />
                    </div>
                </div>
                <ul id="myUL_edit4" class="myUL"></ul>
            </div>

            <div class="col-sm-4">
                <b>Default Discount Allowed</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" value="{{$edit->salesDiscount->acct_name}}" autocomplete="off" id="select_acc_edit5" onkeyup="searchOptionList('select_acc_edit5','myUL_edit5','{{url('default_select')}}','search_accounts','acc_edit5');" name="select" placeholder="Select Account">

                        <input type="hidden" class="acc_class" value="{{$edit->default_discount_allowed}}" name="default_discount_allowed" id="acc_edit5" />
                    </div>
                </div>
                <ul id="myUL_edit5" class="myUL"></ul>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Default Discount Received*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" value="{{$edit->purchaseDiscount->acct_name}}" autocomplete="off" id="select_acc_edit6" onkeyup="searchOptionList('select_acc_edit6','myUL_edit6','{{url('default_select')}}','search_accounts','acc_edit6');" name="select" placeholder="Select Account">

                        <input type="hidden" class="acc_class" value="{{$edit->default_discount_received}}" name="default_discount_received" id="acc6" />
                    </div>
                </div>
                <ul id="myUL_edit6" class="myUL"></ul>
            </div>
         
            <div class="col-sm-4">
                <b>Default Inventory Account*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" value="{{$edit->inventoryAcc->acct_name}}" autocomplete="off" id="select_acc_edit7" onkeyup="searchOptionList('select_acc_edit7','myUL_edit7','{{url('default_select')}}','search_accounts','acc_edit7');" name="select" placeholder="Select Account">

                        <input type="hidden" class="acc_class" value="{{$edit->default_inventory}}" name="default_inventory" id="acc_edit7" />
                    </div>
                </div>
                <ul id="myUL_edit7" class="myUL"></ul>
            </div>
            <div class="col-sm-4">
                <b>Default Payroll Tax*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" value="{{$edit->payrollTax->acct_name}}" autocomplete="off" id="select_acc_edit8" onkeyup="searchOptionListAcc('select_acc_edit8','myUL_edit8','{{url('default_select')}}','search_accounts','acc_edit8');" name="select_user" placeholder="Select Account">

                        <input type="hidden" class="acc_class" value="{{$edit->default_payroll_tax}}" name="default_payroll_tax" id="acc_edit8" />
                    </div>
                </div>
                <ul id="myUL_edit8" class="myUL"></ul>
            </div>

        </div>

        <input type="hidden" name="edit_id" value="{{$edit->id}}" >

    </div>

</form>