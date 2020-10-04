
<div id="main_table">

    <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box-3 bg-red hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">Total Accumulated Mileage on Vehicle(s) Within Date Interval</div>
                    <div class="number">{{Utility::numberFormat($chartObject->totalDailyMileage)}} ({{\App\Helpers\Utility::odometerMeasure()->name}})</div>
                </div>
            </div>
        </div>

    </div>

    <!-- #END# Hover Zoom Effect -->

    <div class="row clearfix">
        <!-- Basic Examples -->
        <div class=" col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Total Accumulated Mileage ({{\App\Helpers\Utility::odometerMeasure()->name}}) On Vehicle By Month
                        <small></small>
                    </h2>

                </div>
                <div class="body">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                        <li role="presentation" class="active"><a href="#bar_chart_project" data-toggle="tab">Bar Chart</a></li>
                        <li role="presentation"><a href="#pie_chart_project" data-toggle="tab">Pie Chart</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="bar_chart_project">
                            <b>Bar Chart</b>
                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="column" style="display:none">
                                <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>
                                        Total Accumulated Mileage({{\App\Helpers\Utility::odometerMeasure()->name}})
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($monthlyTotalMileage as $key => $var)
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$var}}</td>
                                    </tr>
                                @endforeach

                                </tbody>

                            </table>

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="pie_chart_project">
                            <b>Pie Chart</b>
                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="pie" style="display:none">
                                <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>
                                        Total Accumulated Mileage({{\App\Helpers\Utility::odometerMeasure()->name}})
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($monthlyTotalMileage as $key => $var)
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$var}}</td>
                                    </tr>
                                @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="row clearfix">
        <!-- Basic Examples -->
        <div class=" col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Detailed Vehicle Odometer Log Report
                        <small></small>
                    </h2>

                </div>
                <div class="body table-responsive">

                    <table class="table table-bordered table-hover table-striped" id="">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Attachment</th>
                            <th>Vehicle</th>
                            <th>Driver</th>
                            <th>Mileage Before({{\App\Helpers\Utility::odometerMeasure()->name}})</th>
                            <th>Mileage After({{\App\Helpers\Utility::odometerMeasure()->name}})</th>
                            <th>Total Derived Mileage({{\App\Helpers\Utility::odometerMeasure()->name}})</th>
                            <th>Log Date</th>
                            <th>Comment</th>
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
                                    <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_vehicle_odometer_log_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>{{$data->vehicle_make}} {{$data->vehicle_model}} ({{$data->vehicleDetail->license_plate}})</td>
                                <td>{{$data->driver->firstname}} &nbsp; {{$data->driver->lastname}}</td>
                                <td>{{Utility::numberFormat($data->start_mileage)}}</td>
                                <td>{{Utility::numberFormat($data->end_mileage)}}</td>
                                <td>{{Utility::numberFormat($data->daily_mileage)}}</td>
                                <td>{{$data->log_date}}</td>
                                <td>{{$data->comment}}</td>
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

                </div>
            </div>
        </div>

    </div>

</div>
    <script>
        $(document).ready(function() {
            $('table.highchart').highchartTable();
        });
    </script>

