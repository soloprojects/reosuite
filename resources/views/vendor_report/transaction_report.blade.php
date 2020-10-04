
    <table class="table table-bordered table-hover table-striped" id="main_table">
        <thead>

            <tr>
                
                <th style="text-align: center; font-weight:bold;">
                    {{Utility::companyInfo()->name}}<br/>
                    TRANSACTION REPORT <br/>
                    {{$from}} - {{$to}}
                </th>
                <th></th>
            </tr>
        </thead>
    </table>
    
    <!-- Example Tab -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Transaction Report
                        <small></small>
                    </h2>
                    <ul class="header-dropdown m-r--5">
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
                <div class="body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                        <li role="presentation" class=""><a href="#bar_chart" data-toggle="tab">BAR CHART</a></li>
                        <li role="presentation"><a href="#line_chart" data-toggle="tab">LINE CHART</a></li>
                        <li role="presentation"><a href="#area_chart" data-toggle="tab">AREA CHART</a></li>
                        <li role="presentation"><a href="#spline_chart" data-toggle="tab">SPLINE CHART</a></li>
                        <li role="presentation"><a href="#pie_chart" data-toggle="tab">PIE CHART</a></li>
                        <li role="presentation" class="active"><a  href="#table_request" data-toggle="tab">TABLE</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" id="main_table">
                        <div role="tabpanel" class="tab-pane fade in " id="bar_chart">
                            <b>Bar Chart</b>
                            <p>
                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="column" style="display:none">
                                <thead>
                                <tr>
                                    <th>
                                        Month
                                    </th>
                                    <th>
                                        Amount  {{\App\Helpers\Utility::defaultCurrency()}}
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($mainData->chartData as $key => $val)
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$val}}</td>
                                    </tr>

                                @endforeach
                                </tbody>

                            </table>
                            </p>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="line_chart">
                            <b>Line Chart</b>
                            <p>
                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="line" style="display:none">
                                <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>
                                        Amount  {{\App\Helpers\Utility::defaultCurrency()}}
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($mainData->chartData as $key => $val)
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$val}}</td>
                                    </tr>

                                @endforeach
                                </tbody>

                            </table>
                            </p>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="area_chart">
                            <b>Area Chart</b>
                            <p>
                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="area" style="display:none">
                                <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>
                                        Amount  {{\App\Helpers\Utility::defaultCurrency()}}
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($mainData->chartData as $key => $val)
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$val}}</td>
                                    </tr>

                                @endforeach
                                </tbody>

                            </table>
                            </p>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="spline_chart">
                            <b>Spline Chart</b>
                            <p>
                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="spline" style="display:none">
                                <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>
                                        Amount  {{\App\Helpers\Utility::defaultCurrency()}}
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($mainData->chartData as $key => $val)
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$val}}</td>
                                    </tr>

                                @endforeach
                                </tbody>

                            </table>
                            </p>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="pie_chart">
                            <b>Pie Chart</b>
                            <p>
                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="pie" style="display:none">
                                <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>
                                        Amount  {{\App\Helpers\Utility::defaultCurrency()}}
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($mainData->chartData as $key => $val)
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$val}}</td>
                                    </tr>

                                @endforeach
                                </tbody>

                            </table>
                            </p>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in active" id="table_request" style="overflow-x:scroll; width:auto;">
                            <b>All Transactions</b>

                            
                            <table class="table table-bordered table-hover table-striped" id="main_table">
                                <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                            name="check_all" class="" />

                                    </th>
                                    <th>Customer Preview</th>
                                    <th>Default Preview</th>
                                    <th>File Number</th>
                                    <th>Customer</th>
                                    <th>Post Date</th>
                                    <th>Status</th>
                                    <th>Sum Total</th>
                                    <th>Sum Total {{\App\Helpers\Utility::defaultCurrency()}}</th>
                                    <th>Open Balance</th>
                                    <th>Open Balance {{\App\Helpers\Utility::defaultCurrency()}}</th>
                                    <th>Created by</th>
                                    <th>Updated by</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($mainData as $data)
                                    <tr>
                                        <td scope="row">
                                            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                        </td>
                                        <td>
                                            <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('invoice_print_preview') ?>','<?php echo csrf_token(); ?>','customer')"><i class="fa fa-pencil-square-o"></i>Customer Preview</a>
                                        </td>
                                        <td>
                                            <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml2('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('invoice_print_preview') ?>','<?php echo csrf_token(); ?>','default')"><i class="fa fa-pencil-square-o"></i>Default Preview</a>
                                        </td>
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <td>
                                            @if(!empty($data->file_no))
                                            {{$data->file_no}}
                                            @else
                                            {{$data->id}}
                                            @endif
                                        </td>
                                        <td>{{$data->vendorCon->name}}</td>
                                        <td>{{$data->post_date}}</td>
                                        <td>{{$data->dataStatus->name}}</td>
                                        <td>({{$data->currency->code}}){{$data->currency->symbol}}&nbsp;{{Utility::numberFormat($data->sum_total)}}</td>
                                        <td>{{Utility::numberFormat($data->trans_total)}}</td>
                                        <td>({{$data->currency->code}}){{$data->currency->symbol}}&nbsp;{{Utility::numberFormat($data->balance)}}</td>
                                        <td>{{Utility::numberFormat($data->balance_trans)}}</td>
                                        <td>{{$data->user_c->firstname}} &nbsp;{{$data->user_c->lastname}} </td>
                                        <td>{{$data->user_u->firstname}} &nbsp;{{$data->user_u->lastname}}</td>
                                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <input type="hidden" id="customerDisplay" value="{{$data->vendor_customer}}">

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-md-4 pull-right"></div>
                                <div class="col-md-4 pull-right" style="font-weight: bold;">Sum Total {{\App\Helpers\Utility::defaultCurrency()}} :  {{Utility::roundNum($mainData->totalBal)}}</div>
                                <div class="col-md-4 pull-right"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Example Tab -->

<script>
    $(document).ready(function() {
        $('table.highchart').highchartTable();
    });
</script>