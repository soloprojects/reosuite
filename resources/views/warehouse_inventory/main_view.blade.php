@extends('layouts.app')

@section('content')

    <!-- ADD FORM MODAL -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Create Inventory Item</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Warehouse
                                        <div class="form-line" >
                                            <select class=" warehouse" name="warehouse" id="warehouse_id" onchange="fillNextInput('warehouse_id','zone_display_id','<?php echo url('default_select'); ?>','w_zones')" >
                                                <option value="">Select Receipt Warehouse</option>
                                                @foreach($warehouse as $inv)
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
                                            <select class=" " id="zone_id" name="zone" onchange="fillNextInput('zone_id','bin_id','<?php echo url('default_select'); ?>','z_bins')">

                                                    <option value="">Select Zone</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>Receipt Bin</b>
                                        <div class="form-line" id="bin_id">
                                            <select class=" " name="bin"  >
                                                <option value="">Select Bin</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div id="bom_items" >
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
                                                <input type="number" class="form-control bom_qty bom_qty_class" name="bom_qty" id="bom_qty" placeholder="Quantity" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4" id="hide_button_inv">
                                        <div class="form-group">
                                            <div onclick="addMore('add_more_inv','hide_button_inv','1','<?php echo URL::to('add_more'); ?>','warehouse_items','hide_button_inv');">
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
                    <button onclick="saveInventory('createModal','createMainForm','<?php echo url('create_warehouse_inventory'); ?>','reload_data',
                            '<?php echo url('warehouse_inventory'); ?>','<?php echo csrf_token(); ?>','inv_class','bom_qty','bom_amount')" type="button" class="btn btn-success waves-effect">
                        Add Inventory to Warehouse
                    </button>
                    <button onclick="saveInventory('createModal','createMainForm','<?php echo url('remove_warehouse_inventory'); ?>','reload_data',
                            '<?php echo url('warehouse_inventory'); ?>','<?php echo csrf_token(); ?>','inv_class','bom_qty','bom_amount')" type="button" class="btn btn-danger waves-effect">
                        Remove Inventory from Warehouse
                    </button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
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
                            @include('includes/print_pdf',[$exportId = 'main_table_whse_items', $exportDocId = 'reload_data_whse_items'])
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

    <!-- Manage Warehouse Zones Content -->
    <div class="modal fade" id="manageZoneModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header">
                    <h4 class="modal-title" id="defaultModalLabel">Warehouse Zone(s)</h4>
                    <ul class="header-dropdown m-r--5 pull-right" style="display:inline;">


                    </ul>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;" id="manageZone">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Manage Warehouse Bin Content -->
    <div class="modal fade" id="manageBinModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Zone Contents (Bin)</h4>

                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;" id="manageBin">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!--Warehouse Bin Inventory Content -->
    <div class="modal fade" id="binContentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Bin Contents</h4>
                    @include('includes/print_pdf',[$exportId = 'bin_content_export', $exportDocId = 'bin_content_export'])
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;" id="binContent">

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
                        Warehouse Inventory
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-info" data-toggle="modal" data-target="#createModal"><i class="fa fa-pencil-square-o fa-2x"></i>Update Warehouse Inventory</button>
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
                        <form name="InventorySearchForm" id="InventorySearchForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control" autocomplete="off" id="select_inventory" onkeyup="searchOptionList('select_inventory','myUL','{{url('default_select')}}','search_inventory','inventory_item');" name="select_user" placeholder="Select Inventory Item">

                                    <input type="hidden" class="inv_class" value="" name="inventory_item" id="inventory_item" />
                                </div>
                            </div>
                            <ul id="myUL" class="myUL"></ul>
                        </div>
                        </form>
                        <div class="col-sm-4 ">
                            <div class="form-group">
                                <button type="text" id="" class="form-control btn btn-info"
                                        onclick="searchReport('InventorySearchForm','<?php echo url('search_warehouse_inventory_items') ?>','reload_data','','<?php echo csrf_token(); ?>')"
                                        name="search_button">Search</button>
                            </div>

                        </div>
                    </div>
                    <hr/>
                    <div class="row clearfix">
                        <form name="warehouseSearchForm" id="warehouseSearchForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="col-sm-4">
                                <div class="form-group">
                                    <b>Warehouse</b>
                                    <div class="form-line" >
                                        <select class=" warehouse" name="warehouse" id="warehouse_id_search" onchange="fillNextInput('warehouse_id_search','zone_display_id_search','<?php echo url('default_select'); ?>','w_zones_search')" >
                                            <option value="">Select Receipt Warehouse</option>
                                            @foreach($warehouse as $inv)
                                                <option value="{{$inv->id}}">{{$inv->name}} ({{$inv->code}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>Zone</b>
                                    <div class="form-line" id="zone_display_id_search">
                                        <select class=" " id="zone_id_search" name="zone">
                                            <option value="">Select Zone</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <b>Receipt Bin</b>
                                    <div class="form-line" id="bin_id_search">
                                        <select class=" " name="bin"  >
                                            <option value="">Select Bin</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>

                        </div>

                        <div class="row clearfix">
                            <button onclick="searchReport('warehouseSearchForm','<?php echo url('search_warehouse_inventory'); ?>','reload_data',
                                    '','<?php echo csrf_token(); ?>')" type="button" class="col-sm-10  btn btn-info waves-effect">
                                Search for Inventory Items
                            </button>
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
                            <th>View Zones</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Address</th>
                            <th>Country</th>
                            <th>Contact</th>
                            <th>Contact Phone</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                            <tr>
                                <td scope="row">
                                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                </td>
                                <td>
                                    <a style="cursor: pointer;" onclick="newWindow('{{$data->id}}','manageZone','<?php echo url('warehouse_inventory_zone') ?>','<?php echo csrf_token(); ?>','manageZoneModal')"><i class="fa fa-eye fa-2x"></i></a>
                                </td>
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

                                <td>{{$data->name}}</td>
                                <td>{{$data->code}}</td>
                                <td>{{$data->address}}</td>
                                <td>{{$data->country}}</td>
                                <td>{{$data->contact}}</td>
                                <td>{{$data->phone}}</td>
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

            $.ajax({
                url: '?page=' + page
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
            $('#loading_modal').modal('show');
            $('#'+formModal).modal('hide');
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


    </script>

@endsection