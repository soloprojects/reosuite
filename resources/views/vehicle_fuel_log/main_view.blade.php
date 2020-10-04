@extends('layouts.app')

@section('content')


    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Fuel Log</h4>
                </div>
                <div class="modal-body" style="overflow-y:scroll; height:500px;">

                    <form name="vehicleForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

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
                                            <select class="form-control" name="vehicle"  required>
                                                <option value="">Select Select Vehicle</option>
                                                @foreach(\App\Helpers\Utility::driverVehicles() as $data)
                                                    <option value="{{$data->id}}">{{$data->make->make_name}} {{$data->model->model_name}} ({{$data->license_plate}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @endif

                                <div class="col-sm-4">
                                    <b>Fuel Station*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="fuel_station"  required>
                                                <option value="">Select Fuel Station</option>
                                                @foreach($fuelStation as $data)
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
                                    <b>Invoice Reference*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="invoice_reference" placeholder="Invoice Reference" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Price Per Liter</b>{{\App\Helpers\Utility::defaultCurrency()}}
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" value="0" id="price_per_liter" onkeyup="totalPrice('liter','price_per_liter','liter_price')" name="price_per_liter" placeholder="Price Per Liter" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Liter</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" value="0" onkeyup="totalPrice('liter','price_per_liter','liter_price')" id="liter" name="liter" placeholder="Liter">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Total Price</b> {{\App\Helpers\Utility::defaultCurrency()}}
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" value="0" name="total_price" id="liter_price" placeholder="total Price" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Purchase Date*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="purchase_date" placeholder="Purchase Date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Attachment</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" multiple="multiple" class="form-control" name="attachment[]" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <b>Comment</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control" name="comment" placeholder="Comment" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>

                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_vehicle_fuel_log'); ?>','reload_data',
                            '<?php echo url('vehicle_fuel_log'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
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
                    <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('edit_vehicle_fuel_log_attachment'); ?>','reload_data',
                            '<?php echo url('vehicle_fuel_log'); ?>','<?php echo csrf_token(); ?>')"
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
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_vehicle_fuel_log'); ?>','reload_data',
                            '<?php echo url('vehicle_fuel_log'); ?>','<?php echo csrf_token(); ?>')"
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
                        Fuel Log
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('vehicle_fuel_log'); ?>',
                                    '<?php echo url('delete_vehicle_fuel_log'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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

                <div class="body table-responsive" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Manage</th>
                            <th>Attachment</th>
                            <th>Vehicle</th>
                            <th>Fuel Station</th>
                            <th>Purchase Price {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Driver</th>
                            <th>Price Per Liter {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>liter</th>
                            <th>Mileage ({{\App\Helpers\Utility::odometerMeasure()->name}})</th>
                            <th>Purchase Date</th>
                            <th>Comment</th>
                            <th>Invoice Reference</th>
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
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_vehicle_fuel_log_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_vehicle_fuel_log_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->vehicle_make}} {{$data->vehicle_model}} ({{$data->vehicleDetail->license_plate}})</td>
                            <td>{{$data->fuel->name}}</td>
                            <td>{{Utility::numberFormat($data->total_price)}}</td>
                            <td>{{$data->driver->firstname}} &nbsp; {{$data->driver->lastname}}</td>
                            <td>{{Utility::numberFormat($data->price_per_liter)}}</td>
                            <td>{{Utility::numberFormat($data->liter)}}</td>
                            <td>{{Utility::numberFormat($data->mileage)}}</td>
                            <td>{{$data->purchase_date}}</td>
                            <td>{{$data->comment}}</td>
                            <td>{{$data->invoice_reference}}</td>
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

    function totalPrice(literId,perLiterId,priceId){
        var liter = $('#'+literId).val();
        var perLiter = $('#'+perLiterId).val();
        var totalPrice = liter*perLiter;
        $('#'+priceId).val(totalPrice);

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