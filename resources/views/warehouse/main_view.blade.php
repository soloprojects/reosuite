@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Create Warehouse Location</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <h3>General</h3><hr>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Code*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="code" placeholder="Code" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Name*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Address*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="address" placeholder="Address" required>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Address2*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="address2" placeholder="Address2" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>country</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="country" placeholder="Country" required>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Post Code*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="post_code" placeholder="Post Code" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Contact</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="contact" placeholder="Contact Name" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Contact Phone</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="phone" placeholder="Phone" required>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <b>Contact Email</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="email" placeholder="email" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Contact Fax</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="fax" placeholder="Fax" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Warehouse Manager</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select User">

                                            <input type="hidden" class="user_class" name="warehouse_manager" id="user" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>

                            </div>

                     </div>

                        <div class="body">
                            <h3>Warehouse</h3><hr>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Default Receipt Bin Code</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="receipt_bin" >
                                                <option value="">Select</option>
                                                @foreach($binType as $type)
                                                    <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Default Shipment bin code</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="shipment_bin" >
                                                <option value="">Select</option>
                                                @foreach($binType as $type)
                                                    <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Open Shop Floor Bin Code (Production)</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="open_shop_floor_bin">
                                                <option value="">Select</option>
                                                @foreach($binType as $type)
                                                    <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>To Production Bin Code (Production)</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="to_prod_bin" >
                                                <option value="">Select</option>
                                                @foreach($binType as $type)
                                                    <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>From Production Bin Code (Production)</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="from_prod_bin">
                                                <option value="">Select</option>
                                                @foreach($binType as $type)
                                                    <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Adjustment Bin Code (Adjustment)</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="adjust_code">
                                                <option value="">Select</option>
                                                @foreach($binType as $type)
                                                    <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Cross-Dock Bin Code (Cross-Dock)</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="cross_dock_bin" >
                                                <option value="">Select</option>
                                                @foreach($binType as $type)
                                                    <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>To Assembly Bin Code (Assembly)</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="to_assemb_bin">
                                                <option value="">Select</option>
                                                @foreach($binType as $type)
                                                    <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>From Assembly Bin Code (Assembly)</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="from_assemb_code" >
                                                <option value="">Select</option>
                                                @foreach($binType as $type)
                                                    <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <b>Assm To Order Shipt Bin Code (Assembly)</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="Ass_to_ord_ship_bin">
                                                <option value="">Select</option>
                                                @foreach($binType as $type)
                                                    <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="body">
                            <h3>Bin Policies</h3><hr>
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
                                    <b>Bin Capacity Policy</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select type="text" class="form-control"  name="bin_cap_policy" required>
                                                <option value="">Select</option>
                                                @foreach(\App\Helpers\Utility::CAPACITY_POLICY as $policy)
                                                    <option value="{{$policy}}">{{$policy}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Allow Breakbulk</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="checkbox" class="form-control" value="checked" name="break_bulk" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Put Away Template Code</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="put_away_temp_code" >
                                                <option value="" selected>Select</option>
                                                @foreach($putAwayTemp as $temp)
                                                    <option value="{{$temp->id}}">{{$temp->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Always Create Put-Away Pick Line</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="checkbox" class="form-control" value="checked" name="put_away_pick_line">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Always Create Pick Line</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="checkbox" class="form-control" value="checked" name="pick_line" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Pick According to FEFO*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="checkbox" class="form-control" value="checked" name="pick_feffo" >
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_warehouse'); ?>','reload_data',
                            '<?php echo url('warehouse'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
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

                    <button type="button"  onclick="submitMediaFormCompany('editModal','editMainForm','<?php echo url('edit_warehouse'); ?>','reload_data',
                            '<?php echo url('warehouse'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
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
                    <h4 class="modal-title" id="defaultModalLabel">Manage Warehouse Zone(s)</h4>
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
                <div class="modal-body" style="height:400px; overflow:scroll;" id="manageZone">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Warehouse Zones Content -->
    <div class="modal fade" id="addZoneModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add Zone to Warehouse</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;" id="addZone">

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
                    <h4 class="modal-title" id="defaultModalLabel">Manage Bin</h4>

                    <li class="dropdown pull-right">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>Export
                        </a>
                        <ul class="dropdown-menu pull-right">
                            @include('includes/export',[$exportId = 'main_table_', $exportDocId = 'reload_data'])
                        </ul>
                    </li>

                </div>
                <div class="modal-body" style="height:500px; overflow:scroll;" id="manageBin">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Warehouse Bin Content -->
    <div class="modal fade" id="addBinModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add Bin to Zone</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;" id="addBin">

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
                        Warehouse Locations
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('warehouse'); ?>',
                                    '<?php echo url('delete_warehouse'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <!--<li>
                            <button type="button" onclick="changeStatus('kid_checkbox','reload_data','<?php echo url('user'); ?>',
                                    '<?php echo url('change_user_status'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Enable User
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeStatus('kid_checkbox','reload_data','<?php echo url('user'); ?>',
                                    '<?php echo url('change_user_status'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Disable User
                            </button>
                        </li>-->
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

                <div class=" table-responsive" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>
                            <th>Manage</th>
                            <th>Manage Zones</th>
                            <th>Name</th>

                            <th>Code</th>
                            <th>Address</th>
                            <th>Country</th>
                            <th>Contact</th>
                            <th>Contact Phone</th>
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
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_warehouse_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="newWindow('{{$data->id}}','manageZone','<?php echo url('warehouse_zone') ?>','<?php echo csrf_token(); ?>','manageZoneModal')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

                            <td>{{$data->name}}</td>
                            <td>{{$data->code}}</td>
                            <td>{{$data->address}}</td>
                            <td>{{$data->country}}</td>
                            <td>{{$data->contact}}</td>
                            <td>{{$data->phone}}</td>
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
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getData(page);
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
        function submitMediaFormCompany(formModal,formId,submitUrl,reload_id,reloadUrl,token){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            var postVars = new FormData(form);
            postVars.append('token',token);
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

        function saveMethod(formModal,formId,submitUrl,reload_id,reloadUrl,token,inputClass,dataId) {
            var inputVars = $('#' + formId).serialize();
            var summerNote = '';
            var htmlClass = document.getElementsByClassName('t-editor');
            if (htmlClass.length > 0) {
                summerNote = $('.summernote').eq(0).summernote('code');

            }

            var inputClass1 = classToArray2(inputClass);
            var jinputClass = JSON.stringify(inputClass1);
            //alert(jinputClass);
            if(arrayItemEmpty(inputClass1) == false){
                var postVars = inputVars + '&editor_input=' + summerNote+'&input_class='+jinputClass;
                //alert(postVars);
                $('#loading_modal').modal('show');
                $('#' + formModal).modal('hide');
                sendRequestForm(submitUrl, token, postVars)
                ajax.onreadystatechange = function () {
                    if (ajax.readyState == 4 && ajax.status == 200) {

                        $('#loading_modal').modal('hide');
                        var rollback = JSON.parse(ajax.responseText);
                        var message2 = rollback.message2;
                        if (message2 == 'fail') {

                            //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                            var serverError = phpValidationError(rollback.message);

                            var messageError = swalFormError(serverError);
                            swal("Error", messageError, "error");

                        } else if (message2 == 'saved') {

                            var successMessage = swalSuccess('Data saved successfully');
                            swal("Success!", "Data saved successfully!", "success");
                            //location.reload();

                        } else {

                            var infoMessage = swalWarningError(message2);
                            swal("Warning!", infoMessage, "warning");

                        }

                        //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                        reloadContentId(reload_id,dataId,reloadUrl);
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