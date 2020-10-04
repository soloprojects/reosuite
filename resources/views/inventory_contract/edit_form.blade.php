<form name="editMainForm" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                Customer/Client
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" autocomplete="off" value="{{$edit->customer->name}}" id="select_customer_edit" onkeyup="searchOptionList('select_customer_edit','myUL2_edit','{{url('default_select')}}','search_customer','customer_edit');" name="select_user" placeholder="Select Customer">

                        <input type="hidden" class="user_class" value="{{$edit->customer_id}}" name="customer" id="customer_edit" />
                    </div>
                </div>
                <ul id="myUL2_edit" class="myUL"></ul>
            </div>
            <div class="col-sm-4">
                <b>Contract Title*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->name}}" name="title" placeholder="Contract Title" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Contract Type*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="contract_type"  required>
                            <option value="{{$edit->contract_type}}">{{$edit->contract->name}}</option>
                            @foreach($contractType as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Recurring Bill {{\App\Helpers\Utility::defaultCurrency()}}</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->recurring_cost}}" name="recurring_bill" placeholder="Recurring Bill" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Total Bill*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" id="unit_cost_edit" value="{{$edit->total_amount}}" name="total_bill" placeholder="Total Bill" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Invoice Number</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->invoice_id}}" id="" name="invoice_no" placeholder="Invoice Number" >
                    </div>
                </div>
            </div>
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Invoice Date*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->invoice_date}}" name="invoice_date" placeholder="invoice_date" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Start Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->start_date}}" name="start_date" id="" placeholder="start_date" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>End Date*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->end_date}}" name="end_date" placeholder="End Date" required>
                    </div>
                </div>
            </div>
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Contract Status*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="contract_status"  required>
                            <option value="{{$edit->contract_status}}">{{$edit->StatusType->name}}</option>
                            @foreach($contractStatus as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Recurring Interval(days)</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->recurring_interval}}" name="recurring_interval" id="" placeholder="recurring_interval" required>
                    </div>
                </div>
            </div>


        </div>
        <hr/>

        </div>

        <div id="bom_items_edit" >
            <?php $num = 0; $countData = []; ?>
            @if(!empty($edit->bomData))

                <?php $num = 0; $countData = []; ?>
                @foreach($edit->bomData as $bo)
                <?php $num++  ?>
                 <?php $countData[] = $num;  ?>
            <div class="row clearfix" id="bomRow{{$num}}" >
                <div class="col-sm-3">
                    Inventory Item
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{$bo->inventory->item_name}}" autocomplete="off" id="select_inv_{{$num}}" onkeyup="searchOptionList('select_inv_{{$num}}','myUL500_{{$num}}','{{url('default_select')}}','search_inventory','inv500_{{$num}}');" name="select_user" placeholder="Select Inventory Item">

                            <input type="hidden" class="inv_class" value="{{$bo->item_id}}" name="item_id_edit{{$num}}" id="inv500_{{$num}}" />
                        </div>
                    </div>
                    <ul id="myUL500_{{$num}}" class="myUL"></ul>
                </div>

                <div class="col-sm-2">
                    <b>Quantity</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="number" class="form-control bom_qty_class_edit" value="{{$bo->quantity}}" name="bom_qty_edit{{$num}}" onkeyup="extendedAmount('inv500_{{$num}}','{{url('ext_amount')}}','ext_amount{{$num}}{{$bo->id}}','bom_qty{{$num}}{{$bo->id}}','bom_qty_class_edit','bom_amt_edit','unit_cost_edit')" id="bom_qty{{$num}}{{$bo->id}}" placeholder="Quantity" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <b>Amount</b>
                    <div class="input-group">
                        <span class="input-group-addon">{{\App\Helpers\Utility::defaultCurrency()}}</span>
                        <div class="form-line">
                            <input type="number" class="form-control bom_amt_edit" value="{{$bo->extended_amount}}" id="ext_amount{{$num}}{{$bo->id}}"  name="bom_amount_edit{{$num}}" placeholder="Amount" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <b>Servicing Interval(Days)</b>
                    <div class="input-group">
                        <div class="form-line">
                            <input type="number" value="{{$bo->servicing_interval}}" class="form-control bom_servicing_class" id=""  name="bom_servicing_edit{{$num}}" placeholder="Servicing Interval" >
                        </div>
                    </div>
                </div>

                    <input type="hidden"  value="{{$bo->id}}" name="bom_id{{$num}}" id="bom_id{{$num}}">
                <div class="col-sm-2">
                    <button type="button" onclick="permInventoryDelete('bomRow{{$num}}','<?php echo url('delete_inventory_contract_item'); ?>','bom_id{{$num}}','{{$bo->extended_amount}}','unit_cost_edit');" class="btn btn-danger">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
            </div>
                @endforeach
            @endif
            <div class="row">
                <div class="col-sm-4" id="hide_button_inv_edit">
                    <div class="form-group">
                        <div onclick="addMore('add_more_inv_edit','hide_button_inv_edit','350','<?php echo URL::to('add_more'); ?>','contract_item_edit','hide_button_inv_edit');">
                            <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                        </div>
                    </div>
                </div>
            </div>



            <div id="add_more_inv_edit">

            </div>

        </div>

    </div>


    <input type="hidden" name="count_bom" value="<?php echo count($countData) ?>" >
        <input type="hidden" name="edit_id" value="{{$edit->id}}" >

    </div>

</form>

<script>
    $(function() {
        $( ".datepicker1" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
            /*yearRange: "-90:+00"*/

        });
    });
</script>