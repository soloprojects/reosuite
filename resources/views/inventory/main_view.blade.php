@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Create Inventory Item</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <h3>General</h3><hr>
                            <div class="row clearfix">
                            <div class="col-sm-4">
                                <b>Inventory Type*</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control" name="inventory_type" >
                                            <option value="">Select</option>
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
                                            <input type="text" class="form-control datepicker" name="date" placeholder="As of Date" required>
                                        </div>
                                    </div>
                                </div>

                        </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>item No*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="item_no" placeholder="Item No." required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Item Name*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Sales Description*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="sales_desc" placeholder="Sales Descritpion" required>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Purchase Description*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="purchase_desc" placeholder="Purchase Description" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Unit Measure</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="unit_measure" >
                                                <option value="">Select</option>
                                                @foreach($unitMeasure as $unit)
                                                    <option value="{{$unit->id}}">{{$unit->unit_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Quantity on hand*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="quantity" id="quantity" placeholder="Quantity" required>
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
                                                <option value="">Select</option>
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
                                            <input type="text" class="form-control" name="search_keyword" placeholder="Search Keyword" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Re-order Level</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="re_order_level" placeholder="Re-order Level" >
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <b>SKU</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="sku" placeholder="sku" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    Preferred Vendor
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','search_vendor','user');" name="select_user" placeholder="Preferred Vendor">

                                            <input type="hidden" class="user_class" name="pref_vendor" id="user" />
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
                                            <input type="checkbox" onclick="checkBom('bom_check','bom_items');" id="bom_check" class="form-control" name="bom" value="checked" >
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div id="bom_items" style="display: none;">
                                <div class="row clearfix"  >

                                    <div class="col-sm-4">
                                        Inventory Item
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" autocomplete="off" id="select_inv" onkeyup="searchOptionList('select_inv','myUL500','{{url('default_select')}}','search_inventory','inv500');" name="select_user" placeholder="Select Inventory Item">

                                                <input type="hidden" class="inv_class" value="" name="user" id="inv500" />
                                            </div>
                                        </div>
                                        <ul id="myUL500" class="myUL"></ul>
                                    </div>

                                    <div class="col-sm-4">
                                        <b>Quantity</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="form-control bom_qty bom_qty_class" name="bom_qty" onkeyup="extendedAmount('inv500','{{url('ext_amount')}}','ext_amount','bom_qty','bom_qty_class','bom_amt','unit_cost')" id="bom_qty" placeholder="Quantity" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <b>Amount</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">{{\App\Helpers\Utility::defaultCurrency()}}</span>
                                            <div class="form-line">
                                                <input type="text"  class="form-control bom_amount bom_amt" id="ext_amount"  name="bom_amount" placeholder="Amount" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4" id="hide_button_inv">
                                        <div class="form-group">
                                            <div onclick="addMore('add_more_inv','hide_button_inv','1','<?php echo URL::to('add_more'); ?>','bom_inv','hide_button_inv');">
                                                <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div id="add_more_inv">

                                </div>
                            </div>

                     </div>

                        <div class="body">
                            <h3>Invoicing</h3><hr><br>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Costing Method</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="costing_method" >
                                                <option value="">Select</option>
                                                @foreach(\App\Helpers\Utility::COST_METHOD as $type)
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
                                            <input type="number" class="form-control " id="unit_cost" name="unit_cost" placeholder="Unit Cost" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Select Expense Account</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="expense_account">
                                                <option value="">Select</option>
                                                @foreach($accountChart as $account)
                                                    <option value="{{$account->id}}">{{$account->acct_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-md-4">
                                    <b>Unit Price</b>
                                    <div class="input-group">
                                        <span class="input-group-addon">{{\App\Helpers\Utility::defaultCurrency()}}</span>
                                        <div class="form-line">
                                            <input type="number" class="form-control " name="unit_price" placeholder="Unit Price" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Select Income Account</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="income_account">
                                                <option value="">Select</option>
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
                                                <option value="">Select</option>
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
                                                <option value="">Select</option>
                                                @foreach(\App\Helpers\Utility::SPECIAL_EQUIP as $equip)
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
                                                <option value="">Select</option>
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
                                                <option value="">Select</option>
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
                                            <input type="text" class="form-control" name="last_count" placeholder="Last Counting Period" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Next Counting Start</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="next_count_start" placeholder="Next Counting Start" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Next Counting End</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="next_count_end" placeholder="Next Counting End" >
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <b>Use Cross Docking</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="checkbox" value="checked" class="form-control" name="cross_dock"  >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Shelf No.</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" value="" class="form-control" name="shelf_no"  >
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="saveInventory('createModal','createMainForm','<?php echo url('create_inventory'); ?>','reload_data',
                            '<?php echo url('inventory'); ?>','<?php echo csrf_token(); ?>','inv_class','bom_qty','bom_amount')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Warehouse Content -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" style="height:500px; overflow:scroll;" id="edit_content">

                </div>
                <div class="modal-footer">

                    <button type="button"  onclick="saveInventory('editModal','editMainForm','<?php echo url('edit_inventory'); ?>','reload_data',
                            '<?php echo url('inventory'); ?>','<?php echo csrf_token(); ?>','inv_class_edit','bom_qty_edit','bom_amount_edit')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Manage Warehouse Inventory Items Content -->
    <div class="modal fade" id="manageWhseModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header">
                    <h4 class="modal-title" id="defaultModalLabel">Warehouse Inventory Items</h4>
                    <ul class="header-dropdown m-r--5 pull-right" style="display:inline;">

                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>Export
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;" id="manageWhse">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Manage Stock Inventory Items Content -->
    <div class="modal fade" id="manageStockModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header">
                    <h4 class="modal-title" id="defaultModalLabel">Manage Stock Inventory Items</h4>
                    <ul class="header-dropdown m-r--5 pull-right" style="display:inline;">

                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>Export
                            </a>
                            @include('includes/print_pdf',[$exportId = 'main_table_zone', $exportDocId = 'main_table_zone'])
                        </li>
                    </ul>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;" id="manageStock">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Inventory Items
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('inventory'); ?>',
                                    '<?php echo url('delete_inventory'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeItemStatus('kid_checkbox','reload_data','<?php echo url('inventory'); ?>',
                                    '<?php echo url('change_inventory_status'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Enable Inventory Item
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeItemStatus('kid_checkbox','reload_data','<?php echo url('inventory'); ?>',
                                    '<?php echo url('change_inventory_status'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Disable Inventory Item
                            </button>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
                            </ul>
                        </li>

                    </ul>
                </div>

                <div class="body ">
                    <div class="row">
                        <div class="col-sm-12 pull-right">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="search_inventory" class="form-control"
                                           onkeyup="searchItem('search_inventory','reload_data','<?php echo url('search_inventory') ?>','{{url('inventory')}}','<?php echo csrf_token(); ?>')"
                                           name="search_inventory" placeholder="Search Inventory" >
                                </div>
                            </div>
                        </div>
                    </div>

                <div class=" table-responsive tbl_scroll" id="reload_data" style="height:500px; overflow:scroll;">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>
                            <th>Manage</th>
                            <th>Manage Warehouse/Stock Items</th>
                            <th>Item No</th>
                            <th>Item Name</th>
                            <th>Unit Cost</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Inventory Category</th>
                            <th>Inventory Type</th>
                            <th>Photo</th>
                            <th>Created by</th>
                            <th>Updated by</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>

                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_inventory_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>

                            <td>
                                @if($data->whse_status == 1)
                                    <a style="cursor: pointer;" onclick="newWindow('{{$data->id}}','manageWhse','<?php echo url('warehouse_item_inventory') ?>','<?php echo csrf_token(); ?>','manageWhseModal')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                @else
                                    <a style="cursor: pointer;" onclick="newWindow('{{$data->id}}','manageStock','<?php echo url('stock_inventory') ?>','<?php echo csrf_token(); ?>','manageStockModal')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                @endif
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

                            <td>
                                @if($data->active_status == 1)
                                    {{$data->item_no}}
                                @else
                                        <span class="alert-warning">{{$data->item_no}}</span>
                                @endif
                            </td>
                            <td>
                                @if($data->active_status == 1)
                                    {{$data->item_name}}&nbsp;
                                @else
                                    <span class="alert-warning">{{$data->item_name}}</span>
                                @endif
                            </td>
                            <td>{{$data->currency->symbol}} {{Utility::numberFormat($data->unit_cost)}}</td>
                            <td>{{$data->currency->symbol}} {{Utility::numberFormat($data->unit_price)}}</td>
                            <td>{{$data->qty}}</td>
                            <td>{{$data->category->category_name}}</td>
                            <td>{{$data->inv_type->name}}</td>
                            <td><img src="{{ asset('images/'.$data->photo) }}" width="72" height="60" alt="photo" /></td>
                            <td>
                                @if($data->created_by != '0')
                                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                @endif
                            </td>
                            <td>
                                @if($data->updated_by != '0')
                                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                                @endif
                            </td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->updated_at}}</td>
                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class=" pagination pull-right">
                        {!! $mainData->render() !!}
                    </div>

                </div>
              </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

    <script>
        var li_class = document.getElementsByClassName("myUL");
        $(window).click(function() {
            for (var i = 0; i < li_class.length; i++){
                li_class[i].style.display = 'none';
            }

        });

        function checkBom(bomCheckboxId,bomId){
            var bom = $('#'+bomId);
            var bomCheckbox = $('#'+bomCheckboxId).is(':checked');
            if(bomCheckbox){
                bom.show();
            }else{
                bom.hide();
            }

        }


        function extendedAmount(inventoryId,page,extAmtId,qty,qty_class,cost,unitCostId){
            var invId = $('#'+inventoryId).val();

            if(invId == ''){
                $('#'+qty).val('');
                swal("Warning!", 'Please select an inventory Item before entering quantity', "warning");
            }else{
                var quantity =  $('#'+qty).val();
                //alert(quantity);
                $.ajax({
                    url: page+'?invId='+invId+'&qty='+quantity
                }).done(function(data){

                    //$('#'+extAmtId).val(data);
                    $('#'+extAmtId).attr('value', data);
                    var dArray = classToArray(qty_class);
                    var cArray = classToArray(cost);
                    var dArraySum = sumArrayItems(dArray);
                    var cArraySum = sumArrayItems(cArray);

                    $('#'+unitCostId).attr('value', decPoints(cArraySum,2));
                    //$('#'+unitCostId).val(cArraySum);
                    $('#quantity').val(decPoints(dArraySum,2));

                });

            }

        }

        function permInventoryDelete(bomId,page,bomIdVal,amtVal,totalValId){
            var bomVal = $('#'+bomIdVal).val();
            var totalVal = $('#'+totalValId).val();

            $.ajax({
                url: page+'?dataId='+bomVal
            }).done(function(data){
                $('#'+bomId).hide();
                var newTotal = totalVal - amtVal;
                $('#'+totalValId).val(decPoints(newTotal,2));
                swal("Warning!", 'Item removed successfully', "success");

            });


        }

        function removeInputInv(show_id,ghost_class,addUrl,type,all_new_fields_class,unique_num,addButtonId,hideButtonId,amtId,unitCostId) {

            var amt = $('#'+amtId).val();


            if(amt != ''){
                var newAmt = $('#'+unitCostId).val() - amt;

                $('#'+unitCostId).val(decPoints(newAmt,2));
            }else{
                $('#'+unitCostId).val(0.00);
            }

            var get_class = document.getElementsByClassName(all_new_fields_class);
            var addButtons = document.getElementsByClassName('addButtons');
            if(addButtons.length < 1 ) {

                if (addButtons.length < 1) {
                    prevAddId.style.display = 'block';
                }
            }
            $('.' + ghost_class).remove();
            var show_all = document.getElementById(hideButtonId);
            var show_button = '';

            show_button += '<tr><td></td><td></td><td></td><td>';
            show_button += '<div style="cursor: pointer;" onclick="addMore(';

            show_button += "'"+addButtonId+"','"+hideButtonId+"','1','" + addUrl + "','"+type+"','"+hideButtonId+"');";
            show_button += '">';
            show_button += '<i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i></div>';
            show_button += '</tr>';
            if (get_class.length === 0) {

                show_all.innerHTML =show_button;
                show_all.style.display = 'block';
            }
        }

    </script>


    <script>
        /*==================== PAGINATION =========================*/

        $(window).on('hashchange',function(){
            //page = window.location.hash.replace('#','');
            //getData(page);
        });

        $(document).on('click','.pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getData(page);
            //location.hash = page;
        });

        $(document).on('click','.warehouse_pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getDataWarehouseItems(page);
            //location.hash = page;
        });

        $(document).on('click','.stock_pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getDataStockItems(page);
            //location.hash = page;
        });

        function getData(page){
           var searchVal = $('#search_inventory').val();
            var pageData = '';
            if(searchVal == ''){
                pageData = '?page=' + page;
            }else{
                pageData = '<?php echo url('search_inventory') ?>?page=' + page+'&searchVar='+searchVal;
            }

            $.ajax({
                url: pageData
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }

        function getDataWarehouseItems(page){
            var whseId = $('whseId').val();
            $.ajax({
                url: '<?php echo url('warehouse_inventory') ?>?page=' + page +'&dataId='+whseId
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }

        function getDataStockItems(page){
            var stockId = $('stockId').val();
            $.ajax({
                url: '<?php echo url('stock_inventory') ?>?page=' + page +'&dataId='+stockId
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }

    </script>


    <script>
        //SUBMIT FORM WITH A FILE
        function saveInventory(formModal,formId,submitUrl,reload_id,reloadUrl,token,itemId,Qty,Amt){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            var postVars = new FormData(form);
            postVars.append('token',token);

            var itemId1 = classToArray(itemId);
            var Qty1 = classToArray(Qty);
            var Amt1 = classToArray(Amt);
            var jItem = JSON.stringify(itemId1);
            var jQty = JSON.stringify(Qty1);
            var jAmt = JSON.stringify(Amt1);

            postVars.append('item_id',jItem);
            postVars.append('bom_qty',jQty);
            postVars.append('bom_amt',jAmt);
           
            $('#'+formModal).modal('hide');
            //DISPLAY LOADING ICON
            overlayBody('block');
            sendRequestMediaForm(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {
                    //HIDE LOADING ICON
					overlayBody('none');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if(message2 == 'fail'){

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error",messageError, "error");

                    }else if(message2 == 'saved'){

                        //RESET FORM
					    resetForm(formId);
                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", successMessage, "success");
                        //location.reload();

                    }else{

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id,reloadUrl);
                }
            }

        }

    </script>

    <script>

        function saveMethod(formModal,formId,submitUrl,reload_id,reloadUrl,token,itemId,Qty,Amt) {
            var inputVars = $('#' + formId).serialize();
            var summerNote = '';
            var htmlClass = document.getElementsByClassName('t-editor');
            if (htmlClass.length > 0) {
                summerNote = $('.summernote').eq(0).summernote('code');

            }

            var itemId1 = classToArray2(itemId);
            var jItem = sanitizeData(itemId);
            var jQty = sanitizeData(Qty);
            var jAmt = sanitizeData(Amt);
            //alert(jinputClass);
            if(arrayItemEmpty(itemId1) == false){
                var postVars = inputVars + '&editor_input=' + summerNote+'&item_id='+jItem+'&bom_qty='+jQty+'&bom_amt='+jAmt;
                
                $('#' + formModal).modal('hide');
                //DISPLAY LOADING ICON
                overlayBody('block');
                sendRequestForm(submitUrl, token, postVars)
                ajax.onreadystatechange = function () {
                    if (ajax.readyState == 4 && ajax.status == 200) {

                        //HIDE LOADING ICON
                        overlayBody('none');
                        var rollback = JSON.parse(ajax.responseText);
                        var message2 = rollback.message2;
                        if (message2 == 'fail') {

                            //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                            var serverError = phpValidationError(rollback.message);

                            var messageError = swalFormError(serverError);
                            swal("Error", messageError, "error");

                        } else if (message2 == 'saved') {

                            //RESET FORM
					        resetForm(formId);
                            var successMessage = swalSuccess('Data saved successfully');
                            swal("Success!", "Data saved successfully!", "success");
                            //location.reload();

                        } else {

                            var infoMessage = swalWarningError(message2);
                            swal("Warning!", infoMessage, "warning");

                        }

                        //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                        reloadContent(reload_id,reloadUrl);
                    }
                }
                //END OF OTHER VALIDATION CONTINUES HERE
            }else{
                swal("Warning!","Please, fill in all required fields to continue","warning");
            }

        }


        function newWindow(dataId,displayId,submitUrl,token,modalId){
            //alert(dataId);
            var postVars = "dataId="+dataId;
            $('#'+modalId).modal('show');
            sendRequest(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {

                    var ajaxData = ajax.responseText;
                    $('#'+displayId).html(ajaxData);

                }
            }
            $('#'+displayId).html('LOADING DATA');

        }

        function reloadContentId(id,intId,page){


            $.ajax({
                url: page+'?dataId='+intId
            }).done(function(data){
                $('#'+id).html(data);
            });

        }

    </script>

@endsection