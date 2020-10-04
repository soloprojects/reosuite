@extends('layouts.app')

@section('content')


    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Contract</h4>
                </div>
                <div class="modal-body" style="overflow-y:scroll; height:500px;">

                    <form name="vehicleForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">
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
                                    <b>Recurring Cost {{\App\Helpers\Utility::defaultCurrency()}}</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" value="0" name="recurring_cost" placeholder="Recurring Cost" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>activation cost*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="activation_cost" placeholder="Activation Cost" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Mileage({{\App\Helpers\Utility::odometerMeasure()->name}}) before contract</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" value="0" id="" name="mileage_before_contract" placeholder="Mileage before contract" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Mileage({{\App\Helpers\Utility::odometerMeasure()->name}}) after contract</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" value="0" id="" name="mileage_after_contract" placeholder="Mileage after contract">
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
                                    <b>Vehicle Status*</b>
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

                                <div class="col-sm-4">
                                    <b>Invoice Date*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="invoice_date" placeholder="invoice_date" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <b>Attachment</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" multiple="multiple" class="form-control" name="attachment[]" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Contractor*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="contractor" placeholder="Contractor" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_vehicle_contract'); ?>','reload_data',
                            '<?php echo url('vehicle_contract'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
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
                    <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('edit_vehicle_contract_attachment'); ?>','reload_data',
                            '<?php echo url('vehicle_contract'); ?>','<?php echo csrf_token(); ?>')"
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
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_vehicle_contract'); ?>','reload_data',
                            '<?php echo url('vehicle_contract'); ?>','<?php echo csrf_token(); ?>')"
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
                        Vehicle Contract(s)
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('vehicle_contract'); ?>',
                                    '<?php echo url('delete_vehicle_contract'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                            <th>Vehicle</th>
                            <th>Contract Type</th>
                            <th>Recurring Cost {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Status</th>
                            <th>contractor</th>
                            <th>Mileage Before ({{\App\Helpers\Utility::odometerMeasure()->name}})</th>
                            <th>Mileage After({{\App\Helpers\Utility::odometerMeasure()->name}})</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Recurring Interval</th>
                            <th>Invoice Date</th>
                            <th>Activation Cost {{\App\Helpers\Utility::defaultCurrency()}}</th>
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
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_vehicle_contract_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_vehicle_contract_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->vehicle_make}} {{$data->vehicle_model}} ({{$data->vehicleDetail->license_plate}})</td>
                            <td>{{$data->contract->name}}</td>
                            <td>{{number_format($data->recurring_cost)}}</td>
                            <td>{{$data->statusType->name}}</td>
                            <td>{{$data->contractor}}</td>
                            <td>{{number_format($data->mileage_start)}}</td>
                            <td>{{number_format($data->mileage_end)}}</td>
                            <td>{{$data->start_date}}</td>
                            <td>{{$data->end_date}}</td>
                            <td>{{$data->recurring_interval}}</td>
                            <td>{{$data->invoice_date}}</td>
                            <td>{{$data->activation_cost}}</td>
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