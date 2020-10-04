@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Create Contract</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    Customer/Client
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_customer" onkeyup="searchOptionList('select_customer','myUL2','{{url('default_select')}}','search_customer','customer');" name="select_customer" placeholder="Select Customer">

                                            <input type="hidden" class="user_class" name="customer" id="customer" />
                                        </div>
                                    </div>
                                    <ul id="myUL2" class="myUL"></ul>
                                </div>

                                <div class="col-sm-4">
                                    <b>Contract Title*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="title" placeholder="Contract Title" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Contract Type*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="contract_type"  required>
                                                <option value="">Select Contract Type</option>
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
                                            <input type="number" class="form-control" value="0" name="recurring_bill" placeholder="Recurring Bill" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Total Bill*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" id="unit_cost" name="total_bill" placeholder="Total Bill" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Invoice Number</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" value="0" id="" name="invoice_no" placeholder="Invoice Number">
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
                                            <input type="text" class="form-control datepicker" name="invoice_date" placeholder="invoice_date" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Start Date</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="start_date" id="" placeholder="start_date" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>End Date*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="end_date" placeholder="End Date" required>
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
                                                <option value="">Select Contract Status</option>
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
                                            <input type="number" class="form-control" value="0" name="recurring_interval" id="" placeholder="recurring_interval" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <b>Attachment</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" multiple="multiple" class="form-control" name="attachment[]" >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <b>Add Items to Contract</b>
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
                                                <input type="number" class="form-control bom_qty bom_qty_class" name="bom_qty" onkeyup="extendedAmount('inv500','{{url('inventory_contract_ext_amount')}}','ext_amount','bom_qty','bom_qty_class','bom_amt','unit_cost')" id="bom_qty" placeholder="Quantity" >
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

                                    </div>

                                <div class="row clearfix">

                                    <div class="col-sm-4">
                                        <b>Servicing Interval(Days)</b>
                                        <div class="input-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control bom_servicing bom_servicing_class" id=""  name="bom_servicing" placeholder="Servicing Interval" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2" id="hide_button_inv">
                                        <div class="form-group">
                                            <div onclick="addMore('add_more_inv','hide_button_inv','12','<?php echo URL::to('add_more'); ?>','contract_item','hide_button_inv');">
                                                <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div id="add_more_inv">

                                </div>
                            </div>

                     </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="saveInventory('createModal','createMainForm','<?php echo url('create_inventory_contract'); ?>','reload_data',
                            '<?php echo url('inventory_contract'); ?>','<?php echo csrf_token(); ?>','inv_class','bom_qty','bom_amount','bom_servicing')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit  Content -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" style="height:500px; overflow:scroll;" id="edit_content">

                </div>
                <div class="modal-footer">

                    <button type="button"  onclick="saveInventory('editModal','editMainForm','<?php echo url('edit_inventory_contract'); ?>','reload_data',
                            '<?php echo url('inventory_contract'); ?>','<?php echo csrf_token(); ?>','inv_class_edit','bom_qty_edit','bom_amount_edit','bom_servicing_edit ')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Default Size Attachment-->
    <div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Attachment</h4>
                </div>
                <div class="modal-body" id="attach_content" style="overflow-y:scroll; height:400px;">


                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('edit_inventory_contract_attachment'); ?>','reload_data',
                            '<?php echo url('inventory_contract'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
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
                        inventory and Contract
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('inventory_contract'); ?>',
                                    '<?php echo url('delete_inventory_contract'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeItemStatus('kid_checkbox','reload_data','<?php echo url('inventory_contract'); ?>',
                                    '<?php echo url('change_inventory_contract_status'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Activate
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeItemStatus('kid_checkbox','reload_data','<?php echo url('inventory_contract'); ?>',
                                    '<?php echo url('change_inventory_contract_status'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Deactivate
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
                                           onkeyup="searchItem('search_inventory','reload_data','<?php echo url('search_inventory_contract') ?>','{{url('inventory_contract')}}','<?php echo csrf_token(); ?>')"
                                           name="search_inventory" placeholder="Search Inventory and Contract" >
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
                            <th>Attachment</th>
                            <th>Name</th>
                            <th>Contract Type</th>
                            <th>Recurring Bill {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Recurring Interval(Days)</th>
                            <th>Status</th>
                            <th>Customer</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Invoice No.</th>
                            <th>Invoice Date</th>
                            <th>Total Bill {{\App\Helpers\Utility::defaultCurrency()}}</th>
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
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_inventory_contract_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                <td>
                                    <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_inventory_contract_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>
                                    @if($data->active_status == 1)
                                        {{$data->name}}
                                    @else
                                        <span class="alert-warning">{{$data->name}}</span>
                                    @endif
                                </td>
                                <td>{{$data->contract->name}}</td>
                                <td>{{Utility::numberFormat($data->recurring_cost)}}</td>
                                <td>{{$data->recurring_interval}}</td>
                                <td>{{$data->statusType->name}}</td>
                                <td>{{$data->customer->name}}</td>
                                <td>{{$data->start_date}}</td>
                                <td>{{$data->end_date}}</td>
                                <td>{{$data->invoice_id}}</td>
                                <td>{{$data->invoice_date}}</td>
                                <td>{{$data->total_amount}}</td>
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

        function getData(page){
           var searchVal = $('#search_inventory').val();
            var pageData = '';
            if(searchVal == ''){
                pageData = '?page=' + page;
            }else{
                pageData = '<?php echo url('search_inventory_contract') ?>?page=' + page+'&searchVar='+searchVal;
            }

            $.ajax({
                url: pageData
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }

    </script>


    <script>
        //SUBMIT FORM WITH A FILE
        function saveInventory(formModal,formId,submitUrl,reload_id,reloadUrl,token,itemId,Qty,Amt,servicing){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            var postVars = new FormData(form);
            postVars.append('token',token);

            var itemId1 = classToArray(itemId);
            var Qty1 = classToArray(Qty);
            var Amt1 = classToArray(Amt);
            var Serv1 = classToArray(servicing);
            var jItem = JSON.stringify(itemId1);
            var jQty = JSON.stringify(Qty1);
            var jAmt = JSON.stringify(Amt1);
            var jServ = JSON.stringify(Serv1);

            postVars.append('item_id',jItem);
            postVars.append('bom_qty',jQty);
            postVars.append('bom_amt',jAmt);
            postVars.append('servicing_interval',jServ);
            
            $('#'+formModal).modal('hide');
            $('#'+formModal).on('hidden.bs.modal', function () {
                $('#loading_modal').modal('show');
            });

            sendRequestMediaForm(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {
                    $('#loading_modal').modal('hide');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if(message2 == 'fail'){

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error",messageError, "error");

                    }else if(message2 == 'saved'){

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
                //alert(postVars);
                //$('#loading_modal').modal('show');
                $('#' + formModal).modal('hide');
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