<form name="editMainForm" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">
        <h3>General</h3><hr>
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Inventory Type*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="inventory_type" >
                            <option value="{{$edit->inventory_type}}">{{$edit->inv_type->name}}</option>
                            @foreach($inventoryType as $inv)
                                <option value="{{$inv->id}}">{{$inv->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Storage Type*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="storage_type" >
                            @if($edit->whse_status == 1)
                            <option value="1" selected>Warehouse</option>
                            @elseif($edit->whse_status == 0)
                            <option value="0" selected>Stock</option>
                            @endif
                            <option value="">Select</option>
                            <option value="1">Warehouse</option>
                            <option value="0">Stock</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>As of Date*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker2" value="{{$edit->as_of_date}}" name="date" placeholder="As of Date" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>item No*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="item_no" value="{{$edit->item_no}}" placeholder="Item No." required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Item Name*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="name" value="{{$edit->item_name}}" placeholder="Name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Sales Description*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="sales_desc" value="{{$edit->sales_desc}}" placeholder="Sales Descritpion" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Purchase Description*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->purchase_desc}}" name="purchase_desc" placeholder="Purchase Description" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Unit Measure</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="unit_measure" >
                            <option value="{{$edit->unit_measure}}">{{$edit->unitMeasure->unit_name}}</option>
                            @foreach($unitMeasure as $unit)
                                <option value="{{$unit->id}}">{{$unit->unit_name}} ({{$unit->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Quantity on hand*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->qty}}" name="quantity" id="quantity" placeholder="Quantity" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Item Category</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="item_category" >
                            <option value="{{$edit->category_id}}">{{$edit->category->category_name}}</option>
                            @foreach($itemCategory as $item)
                                <option value="{{$item->id}}">{{$item->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Search Keyword</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->search_key}}" name="search_keyword" placeholder="Search Keyword" >
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Re-order Level</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->re_order_level}}" name="re_order_level" placeholder="Re-order Level" >
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">

            <div class="col-sm-4">
                <b>SKU</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->sku}}" name="sku" placeholder="sku" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                Preferred Vendor
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->vendor->name}}" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','search_vendor','user');" name="select_user" placeholder="Select User">

                        <input type="hidden" value="{{$edit->pref_vendor}}" class="user_class" name="pref_vendor" id="user" />
                    </div>
                </div>
                <ul id="myUL1" class="myUL"></ul>
            </div>

            <div class="col-sm-4">
                <b>Item Photo</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="file" class="form-control" name="photo" placeholder="photo" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">

            <div class="col-sm-4">
                <b>BOM (Bill of Materials)</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="checkbox" onclick="checkBom('bom_check_edit','bom_items_edit');" id="bom_check_edit" value="{{$edit->assemble_bom}}" {{$edit->assemble_bom}} class="form-control" name="bom"  >
                    </div>
                </div>
            </div>

        </div>

        @if($edit->assemble_bom == 'checked')
        <div id="bom_items_edit" >
        @else
        <div id="bom_items_edit" style="display:none;">
        @endif
            <?php $num = 0; $countData = []; ?>
            @if($edit->assemble_bom == 'checked')

                <?php $num = 0; $countData = []; ?>
                @foreach($edit->bomData as $bo)
                <?php $num++  ?>
                 <?php $countData[] = $num;  ?>
            <div class="row clearfix" id="bomRow{{$num}}" >
                <div class="col-sm-4">
                    Inventory Item
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{$bo->inventory->item_name}}" autocomplete="off" id="select_inv_{{$num}}" onkeyup="searchOptionList('select_inv_{{$num}}','myUL500_{{$num}}','{{url('default_select')}}','search_inventory','inv500_{{$num}}');" name="select_user" placeholder="Select Inventory Item">

                            <input type="hidden" class="inv_class" value="{{$bo->item_id}}" name="item_id_edit{{$num}}" id="inv500_{{$num}}" />
                        </div>
                    </div>
                    <ul id="myUL500_{{$num}}" class="myUL"></ul>
                </div>

                <div class="col-sm-4">
                    <b>Quantity</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="number" class="form-control bom_qty_class_edit" value="{{$bo->quantity}}" name="bom_qty_edit{{$num}}" onkeyup="extendedAmount('inv500_{{$num}}','{{url('ext_amount')}}','ext_amount{{$num}}{{$bo->id}}','bom_qty{{$num}}{{$bo->id}}','bom_qty_class_edit','bom_amt_edit','unit_cost_edit')" id="bom_qty{{$num}}{{$bo->id}}" placeholder="Quantity" >
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <b>Amount</b>
                    <div class="input-group">
                        <span class="input-group-addon">{{$currSymbol}}</span>
                        <div class="form-line">
                            <input type="number" class="form-control bom_amt_edit " value="{{$bo->extended_amount}}" id="ext_amount{{$num}}{{$bo->id}}"  name="bom_amount_edit{{$num}}" placeholder="Amount" >
                        </div>
                    </div>
                </div>

                    <input type="hidden"  value="{{$bo->id}}" name="bom_id{{$num}}" id="bom_id{{$num}}">
                <div class="col-sm-4">
                    <button type="button" onclick="permInventoryDelete('bomRow{{$num}}','<?php echo url('delete_bom_item'); ?>','bom_id{{$num}}','{{$bo->extended_amount}}','unit_cost_edit');" class="btn btn-danger">
                        <i class="fa fa-close"></i>Remove
                    </button>
                </div>
            </div>
                @endforeach
            @endif
            <div class="row">
                <div class="col-sm-4" id="hide_button_inv_edit">
                    <div class="form-group">
                        <div onclick="addMore('add_more_inv_edit','hide_button_inv_edit','1','<?php echo URL::to('add_more'); ?>','bom_inv_edit','hide_button_inv_edit');">
                            <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                        </div>
                    </div>
                </div>
            </div>



            <div id="add_more_inv_edit">

            </div>

        </div>

    </div>

    <div class="body">
        <h3>Invoicing</h3><hr>
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Costing Method</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="costing_method" >
                            <option value="">Select</option>
                            @foreach(\App\Helpers\Utility::COST_METHOD as $type)
                                @if($edit->inventory_type == $type)
                                 <option value="{{$type}}" selected>{{$type}} ({{$type}})</option>
                                @endif
                                <option value="{{$type}}">{{$type}} ({{$type}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Unit Cost</b>
                <div class="input-group">
                    <span class="input-group-addon">{{$currSymbol}}</span>
                    <div class="form-line">
                        <input type="number" class="form-control" id="unit_cost_edit" value="{{$edit->unit_cost}}" name="unit_cost" placeholder="Unit Cost" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Select Expense Account</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="expense_account">
                            <option value="{{$edit->expense_account}}" selected>{{$edit->expense->acct_name}}</option>
                            @foreach($accountChart as $account)
                                <option value="{{$account->id}}">{{$account->acct_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Unit Price</b>
                <div class="input-group">
                    <span class="input-group-addon">{{$currSymbol}}</span>
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->unit_price}}" name="unit_price" placeholder="Unit Price" >
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Select Income Account</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="income_account">
                            <option value="{{$edit->income_account}}" selected>{{$edit->income->acct_name}}</option>
                            @foreach($accountChart as $account)
                                <option value="{{$account->id}}">{{$account->acct_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Select Inventory Account</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="inventory_account">
                         <option value="{{$edit->inventory_account}}" selected>{{$edit->inventory->acct_name}}</option>
                        @foreach($accountChart as $account)
                                <option value="{{$account->id}}">{{$account->acct_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Special Equipment</b>
                <div class="form-group">
                    <div class="form-line">
                        <select type="text" class="form-control"  name="special_equip" required>
                            @foreach(\App\Helpers\Utility::SPECIAL_EQUIP as $equip)
                                @if($edit->special_equip == $equip)
                                <option value="{{$equip}}" selected>{{$equip}}</option>
                                @endif
                                <option value="{{$equip}}">{{$equip}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Put-Away Template</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="put_away_temp">
                            <option value="{{$edit->put_away_template}}">{{$edit->putAwayTemp->name}} ({{$edit->putAwayTemp->put_away_desc}})</option>
                            @foreach($putAwayTemp as $put)
                                <option value="{{$put->id}}">{{$put->name}} ({{$put->put_away_desc}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Inventory Counting Period</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="inv_count" >
                            <option value="{{$edit->invt_count_period}}">{{$edit->invCount->code}} ({{$edit->invCount->code_desc}})</option>
                            @foreach($invCount as $type)
                                <option value="{{$type->id}}">{{$type->code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">

            <div class="col-sm-4">
                <b>Last Counting Period</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->last_count_period}}" name="last_count" placeholder="Last Counting Period" >
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Next Counting Start</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->next_count_start}}" name="next_count_start" placeholder="Next Counting Start" >
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Next Counting End</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->next_count_end}}" name="next_count_end" placeholder="Next Counting End" >
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">

            <div class="col-sm-4">
                <b>Use Cross Docking</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="checkbox" value="{{$edit->cross_dock}}" {{$edit->cross_dock}} class="form-control" name="cross_dock"  >
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Shelf No.</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->shelf_no}}" class="form-control" name="shelf_no"  >
                    </div>
                </div>
            </div>

        </div>

    </div>
    <input type="hidden" name="count_bom" value="<?php echo count($countData) ?>" >
        <input type="hidden" name="prev_photo" value="{{$edit->photo}}" >
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