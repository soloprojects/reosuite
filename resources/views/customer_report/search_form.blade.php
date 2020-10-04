
 <form name="import_excel" id="{{$searchFormId}}" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">

        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" autocomplete="off" id="select_customer{{$attachToId}}" onkeyup="searchOptionList('select_customer{{$attachToId}}','myUL{{$attachToId}}','{{url('default_select')}}','search_customer','customer{{$attachToId}}');" name="select_customer" placeholder="Select Customer">

                        <input type="hidden" class="user_class" name="contact" id="customer{{$attachToId}}" />
                    </div>
                </div>
                <ul id="myUL{{$attachToId}}" class="myUL"></ul>
            </div>

            @if($searchFormId == 'searchOverdueInvoiceForm')

            <input type="hidden" id="{{$from}}" value="2020-10-10" />
            <input type="hidden" id="{{$to}}" value="2020-11-10" />

            @else
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker" autocomplete="off" id="{{$from}}" name="from_date" placeholder="From e.g 2019-02-22">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker" autocomplete="off" id="{{$to}}" name="to_date" placeholder="To e.g 2019-04-21">
                    </div>
                </div>
            </div>
            @endif

        </div>

        <div class="row clearfix">

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control show-tick" multiple name="financial_year[]" id="{{$finYearId}}" data-selected-text-format="count">
                            <option selected value="">Financial/Fiscal Year</option>
                            @foreach($finYear as $ap)
                                <option value="{{$ap->id}}">{{$ap->fin_name}}({{$ap->fin_year}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control show-tick" name="class" data-selected-text-format="count">
                               <option value="">Class</option>
                            @foreach($transClass as $ap)
                                <option value="{{$ap->id}}">{{$ap->class_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4" id="" style="">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control show-tick" name="location" data-selected-text-format="count">
                            <option value="">Location</option>
                            @foreach($transLocation as $ap)
                                <option value="{{$ap->id}}">{{$ap->location}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clear-fix">
           
            
            @if($searchFormId == 'searchAccountsForm')
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="" autocomplete="off" id="select_acc" onkeyup="searchOptionList('select_acc','myUL500_acc','{{url('default_select')}}','search_accounts','acc500');" name="select_account" placeholder="Select Account">

                        <input type="hidden" class="acc_class" value="" name="account" id="acc500" />
                    </div>
                </div>
                <ul id="myUL500_acc" class="myUL"></ul>
            </div>

            <div class="col-sm-4">
                <span class="pull-right">
                    <input name="account_basis" type="radio" id="radio_30" value="1" class="with-gap radio-col-blue" />
                    <label for="radio_30">Cash Basis</label>

                    <input name="account_basis" type="radio" checked id="radio_31" value="0" class="with-gap radio-col-green" />
                    <label for="radio_31">Accrual Basis</label>
                </span>
            </div>
            <input type="hidden" name="report_type" value="{{Finance::accountReport}}" />
            @endif

            @if($searchFormId == 'searchInventoryForm')
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" autocomplete="off" id="select_inv" onkeyup="searchOptionList('select_inv','myUL500','{{url('default_select')}}','search_inventory','inv500');" name="select_user" placeholder="Inventory Item">

                        <input type="hidden" class="inv_class" value="" name="inventory" id="inv500" />
                    </div>
                </div>
                <ul id="myUL500" class="myUL"></ul>
            </div>

            <div class="col-sm-4">
                <span class="pull-right">
                    <input name="account_basis" type="radio" id="radio_32" value="1" class="with-gap radio-col-blue" />
                    <label for="radio_32">Cash Basis</label>

                    <input name="account_basis" type="radio" checked id="radio_33" value="0" class="with-gap radio-col-green" />
                    <label for="radio_33">Accrual Basis</label>
                </span>
            </div>
            <input type="hidden" name="report_type" value="{{Finance::inventoryReport}}" />
            @endif

            @if($searchFormId == 'searchTransactionForm')

            <div class="col-sm-4" id="" style="">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control show-tick" name="transaction_type" data-selected-text-format="count">
                            <option value="">Transaction Type</option>
                            @foreach(Finance::customerTransactions as $ap)
                                <option value="{{$ap}}">{{Finance::transType($ap)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <input type="hidden" name="report_type" value="{{Finance::transactionReport}}" />
            @endif

            
           
        </div>

    </div>


</form>
