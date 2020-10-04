<form name="import_excel" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">

            @if($edit->warehouse->whse_manager == Auth::user()->id || in_array(Auth::user()->role,\App\Helpers\Utility::SCM_MANAGEMENT))

            <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <b>Assign User</b>
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->assigned->firstname}} {{$edit->assigned->lastname}}" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','warehouse_employee','user');" name="select_user" placeholder="Select User">

                        <input type="hidden" class="user_class" name="user" id="user" />
                    </div>
                </div>
                <ul id="myUL1" class="myUL"></ul>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <b>Assigned Date/Time</b>
                    <div class="form-line">
                        <input type="text" class="datepicker form-control" value="{{$edit->assigned_date}}" name="assigned_date" placeholder="Assigned Date">
                    </div>
                </div>
            </div>

        </div>
        <hr/>
        <div class="row clearfix">

                    <div class="col-sm-4">
                        <div class="form-group">
                            Warehouse
                            <div class="form-line" >
                                <select class=" warehouse" name="warehouse" id="warehouse_id" onchange="fillNextInput('warehouse_id','zone_display_id','<?php echo url('default_select'); ?>','w_zones')" >
                                    <option value="">Select Shipment Warehouse</option>
                                    @foreach($warehouse as $inv)
                                        @if($edit->whse_id == $inv->id)
                                            <option selected value="{{$inv->id}}">{{$inv->name}} ({{$inv->code}})</option>
                                        @endif
                                        <option value="{{$inv->id}}">{{$inv->name}} ({{$inv->code}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <b>Zone</b>
                            <div class="form-line" id="zone_display_id">
                                <select class=" " id="zone_id" name="zone" onchange="fillNextInputParamGetValId('zone_id','bin_id','<?php echo url('default_select'); ?>','z_bins','warehouse_id')">
                                    <option value="{{$edit->zone_id}}">{{$edit->zone->name}}</option>
                                    @foreach($zones as $z)
                                        <option value="{{$z->id}}">{{$z->zone->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <b>Shipment Bin</b>
                            <div class="form-line" id="bin_id">
                                <select class=" " name="bin"  >
                                    <option value="{{$edit->bin_id}}">{{$edit->bin->code}}</option>

                                </select>
                            </div>
                        </div>
                    </div>

                </div>
        <hr/>
        @else

         <div class="row clearfix">
                <div class="col-sm-4">
                    <div class="form-group">
                        <b>Assign User</b>
                        <div class="form-line">
                            <input type="text" class="form-control" readonly value="{{$edit->assigned->firstname}} {{$edit->assigned->lastname}}"  name="select_user" placeholder="Assigned User">

                            <input type="hidden" class="inv_class" value="{{$edit->assigned_user}}" name="user" />
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <b>Assigned Date/Time</b>
                        <div class="form-line">
                            <input type="text" class="datepicker form-control" value="{{$edit->assigned_date}}" name="assigned_date" placeholder="Assigned Date">
                        </div>
                    </div>
                </div>

            </div>
         <hr/>
         <div class="row clearfix">

                    <div class="col-sm-4">
                        <div class="form-group">
                            Warehouse
                            <div class="form-line" id="warehouse_id">
                                <select class=" warehouse" name="warehouse" onchange="fillNextInput('warehouse_id','zone_display_id','<?php echo url('default_select'); ?>','w_zones')" >
                                    <option value="{{$edit->whse_id}}">{{$edit->warehouse->name}} ({{$edit->warehouse->code}})</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <b>Zone</b>
                            <div class="form-line" id="zone_display_id">
                                <select class=" "  name="zone" >
                                    <option value="{{$edit->zone_id}}">{{$edit->zone->name}}</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <b>Shipment Bin</b>
                            <div class="form-line" id="bin_id">
                                <select class=" " name="bin"  >
                                    <option value="{{$edit->bin_id}}">{{$edit->bin->code}}</option>

                                </select>
                            </div>
                        </div>
                    </div>

                </div>
         <hr/>
        @endif
        <div class="row clearfix">

            <div class="col-sm-4">
                <div class="form-group">
                    <b>Shipment No.</b>
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->shipment_no}}" name="shipment_no" placeholder="Shipment No.">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <b>Customer Shipment No.</b>
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->customer_ship_no}}" name="customer_shipment_no" placeholder="Customer Shipment No.">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <b>Posting Date.</b>
                    <div class="form-line">
                        <input type="text" class="form-control datepicker" value="{{$edit->posting_date}}" name="posting_date" placeholder="Posting Date">
                    </div>
                </div>
            </div>

        </div>
        <hr/>
        <div class="row clearfix">

            <table class="table table-bordered table-hover table-striped" id="account_main_table">
                <thead>
                <tr>
                    <th>
                        <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                               name="check_all" class="" />

                    </th>
                    <th>Item</th>
                    <th>Description</th>
                    <th class="">Quantity</th>
                    <th>Qty to Ship</th>
                    <th>Qty to Cross-Dock</th>
                    <th class="">Qty Shipped</th>
                    <th>Qty Outstanding</th>
                    <th class="">Unit of Measure</th>
                    <th>Due Date</th>
                </tr>
                </thead>
                <tbody id="">
                <?php $num = 0; $count = []; ?>
                @foreach($salesItems as $po)
                    <?php $num++; $count[] = $num; ?>
                <tr>

                    <td scope="row">
                        <input value="" type="checkbox" id="" class="" />

                    </td>

                    <td>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="" readonly value="{{$po->inventory->item_name}} ({{$edit->inventory->item_no}})" id="select_acc" name="select_user" placeholder="Select Account">

                                    <input type="hidden" class="acc_class" value="{{$po->inventory->item_id}}" name="item_id{{$num}}" id="acc500" />
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea class="" readonly name="item_desc{{$num}}"  id="item_desc_acc" placeholder="Description">{{$po->salesItem->po_desc}}</textarea>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="" readonly value="{{$po->salesItem->quantity}}" name="qty{{$num}}" id="unit_cost_acc" placeholder="Quantity">
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" class="" value="{{$po->qty_to_ship}}" name="qty_to_ship{{$num}}" id="tax_perct_acc" placeholder="Quantity to Ship" />
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" class="" value="{{$po->qty_to_cross_dock}}" name="qty_to_cross_dock{{$num}}" id="" placeholder="Quantity to Cross-Dock" />
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php $idealShipment = ($po->qty_shipped == '') ? $po->salesItem->shipped_quantity: $po->qty_shipped; ?>
                                    <input type="number" class="" value="{{$idealShipment}}" name="qty_shipped{{$num}}" id="" placeholder="Quantity Shipped" />
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" class="" value="{{$po->qty_outstanding}}" name="qty_outstanding{{$num}}" id="" placeholder="Quantity Outstanding" />
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class=" " readonly value="{{$po->salesItem->unit_measurement}}"  name="unit_measure{{$num}}" id="sub_total_acc" >
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="datepicker" value="{{$po->due_date}}" name="due_date{{$num}}" id="" placeholder="Due Date" />
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
                    <input value="{{$po->id}}" type="hidden" name="edit_id{{$num}}" />
                    <input value="{{$po->work_status}}" type="hidden" name="work_status{{$num}}" />
                @endforeach
                </tbody>
            </table>

        </div>

    </div>

<input value="{{$edit->id}}" type="hidden" name="edit_id" />
<input value="{{$edit->work_status}}" type="hidden" name="work_status" />
<input value="<?php echo count($count); ?>" type="hidden" name="count_po" />
</form>

<script>
    $(function() {
        $( ".datepicker" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });

</script>