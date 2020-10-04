@extends('layouts.app')

@section('content')


    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Vehicle</h4>
                </div>
                <div class="modal-body" style="overflow-y:scroll; height:500px;">

                    <form name="vehicleForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Vehicle Make*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="make" id="vehicle_make_id" required onchange="fillNextInput('vehicle_make_id','vehicle_model_id','{{url('default_select')}}','fetch_vehicle_model')">
                                                <option value="">Select Vehicle Make</option>
                                                @foreach($vehicleMake as $data)
                                                    <option value="{{$data->id}}">{{$data->make_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Vehicle Model*</b>
                                    <div class="form-group">
                                        <div class="form-line" id="vehicle_model_id">
                                            <select class="form-control" name="model"  required>
                                                <option value="">Select Vehicle Model</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>License Plate*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="license_plate" placeholder="License Plate" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select Driver">

                                            <input type="hidden" class="user_class" name="driver" id="user" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>

                                <div class="col-sm-4">
                                    <b>Vehicle Category*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="category"  required>
                                                <option value="">Select Vehicle Category</option>
                                                @foreach($vehicleCategory as $data)
                                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Mileage ({{\App\Helpers\Utility::odometerMeasure()->name}})</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="mileage" placeholder="Mileage" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Transmission</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="Transmission"  required>
                                                <option value="Automatic">Automatic</option>
                                                <option value="Manual">Manual</option>
                                                <option value="Self Driving">Self Driving</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Registration Date*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="registration_date" placeholder="Registration Date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Registration Due Date</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="registration_due_date" placeholder="Registration Due Date" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>location*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="location" placeholder="Location" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Model Year</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control " name="model_year" placeholder="Model Year" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Fuel Type</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="fuel_type" placeholder="Fuel Type">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Purchase Price</b> {{\App\Helpers\Utility::defaultCurrency()}}
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="purchase_price" placeholder="Purchase Price" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Colour</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="colour" placeholder="Colour" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Horse Power</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="horse_power" placeholder="Horse Power" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Seat Number</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control " name="seat_no" placeholder="Seat Number" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Doors</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="doors" placeholder="doors" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Chasis Number*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="chasis_no" placeholder="Chasis Number" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <b>Attachment</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" multiple="multiple" class="form-control" name="attachment[]" >
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_vehicle'); ?>','reload_data',
                            '<?php echo url('vehicle'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                        SAVE
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
                    <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('edit_vehicle_attachment'); ?>','reload_data',
                            '<?php echo url('vehicle'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content" style="overflow-y:scroll; height:500px;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_vehicle'); ?>','reload_data',
                            '<?php echo url('vehicle'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Transact Default Size -->
    @include('includes.print_preview')


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Vehicle
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('vehicle'); ?>',
                                    '<?php echo url('delete_vehicle'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                <div class="row container">
                    <div class="col-sm-10 ">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="search_vehicle" class="form-control"
                                       onkeyup="searchItem('search_vehicle','reload_data','<?php echo url('search_vehicle') ?>','{{url('vehicle')}}','<?php echo csrf_token(); ?>')"
                                       name="search_vehicle" placeholder="Search Vehicle" >
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
                            <th>Attachment</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Category</th>
                            <th>Driver</th>
                            <th>License Plate</th>
                            <th>Model Year</th>
                            <th>Mileage ({{\App\Helpers\Utility::odometerMeasure()->name}})</th>
                            <th>Transmission</th>
                            <th>Fuel Type</th>
                            <th>Registration Date</th>
                            <th>Registration Due Date</th>
                            <th>Purchase Price {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Seat Number</th>
                            <th>Doors</th>
                            <th>Chasis Number</th>
                            <th>Colour</th>
                            <th>Horse Power</th>
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
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_vehicle_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_vehicle_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->make->make_name}}</td>
                            <td>{{$data->model->model_name}}</td>
                            <td>{{$data->category->name}}</td>
                            <td>{{$data->driver->firstname}} &nbsp; {{$data->driver->lastname}}</td>
                            <td>{{$data->license_plate}}</td>
                            <td>{{$data->model_year}}</td>
                            <td>{{$data->mileage}}</td>
                            <td>{{$data->transmission}}</td>
                            <td>{{$data->fuel_type}}</td>
                            <td>{{$data->registration_date}}</td>
                            <td>{{$data->registration_due_date}}</td>
                            <td>{{number_format($data->purchase_price)}}</td>
                            <td>{{$data->seat_number}}</td>
                            <td>{{$data->doors}}</td>
                            <td>{{$data->chasis_no}}</td>
                            <td>{{$data->colour}}</td>
                            <td>{{$data->horsepower}}</td>
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

    <!-- #END# Bordered Table -->

<script>

    function checkProject(reqType_id,project_id){
        var projId = $('#'+project_id);
        var reqValue = $('#'+reqType_id).val();
        if(reqValue == 1){
            projId.hide();
        }
        if(reqValue == 2){
            projId.show();
        }
        if(reqValue == ''){
            projId.hide();
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

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

    $(document).on('click','.search .pagination a', function(event){
        event.preventDefault();

        var page=$(this).attr('href').split('page=')[1];
        getSearchData(page);
        //location.hash = page;
    });

    function getSearchData(page){
        var searchVar = $('#search_vehicle').val();

        $.ajax({
            url: '<?php echo url('search_vehicle'); ?>?page=' + page +'&searchVar='+ searchVar
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