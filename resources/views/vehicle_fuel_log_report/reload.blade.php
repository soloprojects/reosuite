
<div id="main_table">

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box-3 bg-deep-orange hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">Total Purchase Price {{\App\Helpers\Utility::defaultCurrency()}}</div>
                    <div class="number">{{Utility::numberFormat($chartObject->totalPurchasePrice)}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box-3 bg-green hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">Total Purchased Liter(s)</div>
                    <div class="number">{{Utility::numberFormat($chartObject->totalLiters)}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box-3 bg-red hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">Total {{\App\Helpers\Utility::odometerMeasure()->name}} Accrued With Total Liters</div>
                    <div class="number">{{Utility::numberFormat($chartObject->totalMileage)}}</div>
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
                        Total Purchase Price by Month
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
                                        Total Purchase Price
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($monthlyTotalPrice as $key => $var)
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
                                        Total Purchase Price
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($monthlyTotalPrice as $key => $var)
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
                        Detailed Fuel Log Report
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

