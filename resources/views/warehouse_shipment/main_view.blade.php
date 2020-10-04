@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Warehouse Shipment(s)</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Warehouse Shipment</h4>
                    <ul>
                        <li class="dropdown pull-right">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            @include('includes/print_pdf',[$exportId = 'editMainForm', $exportDocId = 'editMainForm'])
                        </li>
                    </ul>
                </div>
                <div class="modal-body" id="edit_content" style="height:400px; overflow:scroll;">

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_warehouse_shipment'); ?>','reload_data',
                            '<?php echo url('warehouse_shipment'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                        SAVE
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
                        Warehouse Shipment(s)
                    </h2>
                    <ul class="header-dropdown m-r--5">

                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('warehouse_shipment'); ?>',
                                    '<?php echo url('delete_warehouse_shipment'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="warehousePost('kid_checkbox','reload_data','<?php echo url('warehouse_shipment'); ?>',
                                        '<?php echo url('post_shipment'); ?>','<?php echo csrf_token(); ?>','{{\App\Helpers\Utility::POST_SHIPMENT}}','Post shipment');" class="btn btn-success waves-effect" ><i class="fa fa-check"></i>Post shipment</button>

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
                <div class="container">
                    <div class=" row">
                        <div class="col-sm-6 ">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="search_shipment" class="form-control"
                                           onkeyup="searchItem('search_shipment','reload_data','<?php echo url('search_warehouse_shipment') ?>','{{url('warehouse_shipment')}}','<?php echo csrf_token(); ?>')"
                                           name="search_shipment" placeholder="Search Warehouse shipments" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="body table-responsive tbl_scroll" id="reload_data">

                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Manage</th>
                            <th>Warehouse</th>
                            <th>Inventory Item</th>
                            <th>Item Desc</th>
                            <th>Quantity</th>
                            <th>Quantity to ship</th>
                            <th>Quantity to Cross-Dock</th>
                            <th>Quantity shipped</th>
                            <th>Quantity Outstanding</th>
                            <th>Unit of Measurement</th>
                            <th>Created by</th>
                            <th>Created at</th>
                            <th>Updated by</th>
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
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_warehouse_shipment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->warehouse->name}}</td>
                            <td>{{$data->inventory->item_name}}</td>
                            <td>{{$data->salesItem->sales_desc}}</td>
                            <td>{{$data->qty}}</td>
                            <td>{{$data->qty_to_ship}}</td>
                            <td>{{$data->qty_to_cross_dock}}</td>
                            <td>{{$data->qty_shipped}}</td>
                            <td>{{$data->qty_outstanding}}</td>
                            <td>{{$data->unit_measurement}}</td>
                            <td>
                                @if($data->created_by != '0')
                                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                @endif
                            </td>
                            <td>{{$data->created_at}}</td>
                            <td>
                                @if($data->updated_by != '0')
                                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                                @endif
                            </td>
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

    <!-- #END# Bordered Table -->

<script>

    function saveInventoryAssign(formModal,formId,submitUrl,reload_id,reloadUrl,token,item,user,qty,location,desc) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var itemId = classToArray(item);
        var username = classToArray(user);
        var quantity = classToArray(qty);
        var loc = classToArray(location);
        var description = classToArray(desc)
        var jUsername = JSON.stringify(username);
        var jItemId = JSON.stringify(itemId);
        var jQuantity = JSON.stringify(quantity);
        var jDesc = JSON.stringify(description);
        var jLoc = JSON.stringify(loc);
        //alert(jdesc);

        if(arrayItemEmpty(itemId) == false){
        var postVars = inputVars + '&editor_input=' + summerNote+'&item='+jItemId+'&user='+jUsername+'&location='+jLoc+'&qty='+jQuantity;

            
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

                } else {

                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id, reloadUrl);
                location.reload();
            }
        }
        //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

</script>

<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getProducts(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });

    function getProducts(page){

        var searchVal = $('#search_shipment').val();
        var pageData = '';
        if(searchVal == ''){
            pageData = '?page=' + page;
        }else{
            pageData = '<?php echo url('search_warehouse_shipment') ?>?page=' + page+'&searchVar='+searchVal;
        }

        $.ajax({
            url: pageData
        }).done(function(data){
            $('#reload_data').html(data);
        });

    }

</script>

    <script>
        /*$(function() {
            $( ".datepicker" ).datepicker({
                /!*changeMonth: true,
                changeYear: true*!/
            });
        });*/
    </script>

@endsection