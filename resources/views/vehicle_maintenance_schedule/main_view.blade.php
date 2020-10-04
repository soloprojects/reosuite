@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Vehicle Maintenance Schedule</h4>
                </div>
                <div class="modal-body" style="height: 400px; overflow-y:scroll;">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <b>Maintenance Reminder</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control service_class" name="reminder"  required>
                                                <option value="">Select Maintenance Reminder</option>
                                                @foreach($maintenanceReminder as $data)
                                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div><hr/>

                            <div class="row clearfix">

                                @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT) || \App\Helpers\Utility::moduleAccessCheck('vehicle_fleet_access'))
                                    <div class="col-sm-4">
                                        <b>Vehicle*</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" autocomplete="off" id="select_vehicle" onkeyup="searchOptionList('select_vehicle','myUL1','{{url('default_select')}}','search_vehicle','vehicle');" name="select_vehicle" placeholder="Select Vehicle">

                                                <input type="hidden" class="vehicle_class" name="vehicle" id="vehicle" />
                                            </div>
                                        </div>
                                        <ul id="myUL1" class="myUL"></ul>
                                    </div>
                                @else

                                    <div class="col-sm-4">
                                        <b>Vehicle*</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control vehicle_class" name="vehicle"  required>
                                                    <option value="">Select Select Vehicle</option>
                                                    @foreach(\App\Helpers\Utility::driverVehicles() as $data)
                                                        <option value="{{$data->id}}">{{$data->make->make_name}} {{$data->model->model_name}} ({{$data->license_plate}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                @endif

                                <div class="col-sm-5">
                                    <b>Vehicle Current Mileage({{\App\Helpers\Utility::odometerMeasure()->name}})</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control mileage_class" value="0" name="mileage" id="" placeholder="Mileage" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-1" id="hide_button">
                                    <div class="form-group">
                                        <div onclick="addMoreEditable('add_more','hide_button','1','<?php echo URL::to('add_more'); ?>','multiple_vehicles','hide_button','vehicle_class');">
                                            <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="" id="add_more">

                            </div>

                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitData('createModal','createMainForm','<?php echo url('create_vehicle_maintenance_schedule'); ?>','reload_data',
                            '<?php echo url('vehicle_maintenance_schedule'); ?>','<?php echo csrf_token(); ?>','vehicle_class','mileage_class')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content" style="height: 400px; overflow-y:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitDefault('editModal','editMainForm','<?php echo url('edit_vehicle_maintenance_schedule'); ?>','reload_data',
                            '<?php echo url('vehicle_maintenance_schedule'); ?>','<?php echo csrf_token(); ?>')"
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
                        Vehicle Maintenance Schedule
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('vehicle_maintenance_schedule'); ?>',
                                    '<?php echo url('delete_vehicle_maintenance_schedule'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
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

                <!-- BEGIN OF SEARCH WITH DOCUMENT NAME -->
                <div class="container">
                    <div class="col-sm-8 ">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="search_maintenance_schedule" class="form-control"
                                       onkeyup="searchItem('search_maintenance_schedule','reload_data','<?php echo url('search_vehicle_maintenance_schedule') ?>','{{url('vehicle_maintenance_schedule')}}','<?php echo csrf_token(); ?>')"
                                       name="search_maintenance_schedule" placeholder="Search with maintenance reminder name" >
                            </div>
                        </div>
                    </div>
                </div><hr/>
                <!-- BEGIN OF SEARCH WITH DOCUMENT NAME -->

                <div class="body table-responsive" id="reload_data">

                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Manage</th>
                            <th>Vehicle</th>
                            <th>Maintenance Reminder</th>
                            <th>Vehicle Mileage During Schedule({{\App\Helpers\Utility::odometerMeasure()->name}})</th>
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
                                @if($data->created_by == Auth::user()->id || in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                                <td>
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_vehicle_maintenance_schedule_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                @else
                                <td></td>
                                @endif
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>{{$data->vehicle_make}} {{$data->vehicle_model}} ({{$data->vehicleDetail->license_plate}})</td>
                                <td>{{$data->reminder->name}}</td>
                                <td>{{$data->mileage}}</td>
                                <td>
                                   {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                </td>
                                <td>
                                   {{$data->user_u->firstname}} {{$data->user_u->lastname}}
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

    <!-- #END# Bordered Table -->

    <script>

        //SUBMIT FORM WITH A FILE
        function submitData(formModal,formId,submitUrl,reload_id,reloadUrl,token,vehicleClass,mileageClass){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            var postVars = new FormData(form);
            postVars.append('token',token);
            postVars.append('vehicle',sanitizeDataWithoutEncode(vehicleClass));
            postVars.append('mileage',sanitizeDataWithoutEncode(mileageClass));
            
            $('#'+formModal).modal('hide');
            //DISPLAY LOADING ICON
            overlayBody('block');
            sendRequestMediaForm(submitUrl,token,postVars);
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

                        var successMessage = swalSuccess('Data saved successfully');
                        //RESET FORM
						resetForm(formId);

                    }else if(message2 == 'token_mismatch'){

                        location.reload();

                    }else {
                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");
                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id,reloadUrl);
                }
            }

        }

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

            $.ajax({
                url: '?page=' + page
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