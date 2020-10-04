<form name="import_excel" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">

            <div class="row clearfix">
                <div class="col-sm-4">
                    <div class="form-group">
                        <b>Assigned User</b>
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

                <div class="col-sm-4">
                    <div class="form-group">
                        Warehouse
                        <div class="form-line" id="warehouse_id">
                            <select class=" warehouse" name="warehouse" onchange="fillNextInput('warehouse_id','zone_display_id','<?php echo url('default_select'); ?>','w_zones')" >
                                <option value="{{$edit->to_whse}}">{{$edit->warehouse->name}} ({{$edit->warehouse->code}})</option>

                            </select>
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
                    <th>Action Type</th>
                    <th>Source Document</th>
                    <th>Item</th>
                    <th>Description</th>
                    <th >Zone Code</th>
                    <th >Bin Code</th>
                    <th class="">Quantity</th>
                    <th>Qty to Handle</th>
                    <th>Qty to Handled</th>
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

                        <td>Take</td>
                        <td>Sales Order</td>
                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="" readonly value="{{$po->inventory->item_name}} ({{$edit->inventory->item_no}})" id="select_acc" name="select_user" placeholder="Select Account">

                                        <input type="hidden" class="acc_class" value="{{$po->inventory->item_id}}" name="item_id" id="acc500" />
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea class="" readonly name="item_desc"  id="item_desc_acc" placeholder="Description">{{$po->description}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line" >
                                        <select class=" " disabled id=""  name="zone" >
                                            <option value="{{$po->to_zone}}">{{$po->zone->name}}</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td >
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line" >
                                        <select class=" " disabled name="bin"  >
                                            <option value="{{$po->to_bin}}">{{$po->bin->code}}</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="" readonly value="{{$po->salesItem->quantity}}" name="qty" id="" placeholder="Quantity">
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" class="" readonly value="{{$po->qty_to_handle}}" name="qty_to_handle" id="" placeholder="qty_to_handle" />
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" class="" readonly value="{{$po->qty_to_cross_dock}}" name="qty_handled" id="" placeholder="Quantity handled" />
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" class="" readonly value="{{$po->qty_outstanding}}" name="qty_outstanding" id="" placeholder="Quantity Outstanding" />
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class=" " readonly value="{{$po->salesItem->unit_measurement}}"  name="unit_measure" id="sub_total_acc" >
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="" readonly value="{{$po->due_date}}" name="due_date" id="" placeholder="Due Date" />
                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>

                <!-- PLACE STARTS FROM HERE -->
                <tr>

                    <td scope="row">
                        <input value="" type="checkbox" id="" class="" />

                    </td>

                    <td>Place</td>
                    <td>Sales Order</td>
                    <td>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="" readonly value="{{$po->inventory->item_name}} ({{$edit->inventory->item_no}})" id="select_acc" name="select_user" placeholder="Select Account">

                                    <input type="hidden" class="acc_class" value="{{$po->inventory->id}}" name="item_id{{$num}}" id="acc500" />
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea class=""  name="item_desc{{$num}}"  id="item_desc_acc" placeholder="Description">{{$po->description}}</textarea>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line" >
                                    <select class=" " id="zone_display_id"  name="zone{{$num}}" onchange="fillNextInputParamId('zone_display_id','bin_display_id','<?php echo url('default_select'); ?>','z_bins_param','{{$edit->to_whse}}','{{$num}}')" >
                                        <option value="{{$edit->to_zone}}">{{$edit->zone->name}}</option>
                                        @foreach($zone as $z)
                                            <option value="{{$z->zone->id}}">{{$z->zone->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line" id="bin_display_id">
                                    <select class=" " name="bin{{$num}}"  >
                                        <option value="{{$edit->to_bin}}">{{$edit->bin->code}}</option>

                                    </select>
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
                                    <input type="number" class="" value="{{$po->qty_to_handle}}" name="qty_to_handle{{$num}}" id="" placeholder="qty_to_handle" />
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" class="" value="{{$po->qty_to_cross_dock}}" name="qty_handled{{$num}}" id="" placeholder="Quantity handled" />
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
                                    <input type="text" class="" readonly value="{{$po->due_date}}" name="due_date{{$num}}" id="" placeholder="Due Date" />
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
                <!-- PLACE ENDS HERE -->

                    <input value="{{$po->id}}" type="hidden" name="edit_id{{$num}}" />
                    <input value="{{$po->pick_put_status}}" type="hidden" name="pick_put_status{{$num}}" />
                @endforeach
                </tbody>
            </table>

        </div>

    </div>

<input value="{{$edit->id}}" type="hidden" name="edit_id" />
<input value="{{$edit->pick_put_status}}" type="hidden" name="pick_put_status" />
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