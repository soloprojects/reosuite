
    <!-- Example Tab -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Accounts Report
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
                        <li role="presentation" class="active"><a href="#bar_chart" data-toggle="tab">BAR CHART</a></li>
                        <li role="presentation"><a href="#line_chart" data-toggle="tab">LINE CHART</a></li>
                        <li role="presentation"><a href="#area_chart" data-toggle="tab">AREA CHART</a></li>
                        <li role="presentation"><a href="#spline_chart" data-toggle="tab">SPLINE CHART</a></li>
                        <li role="presentation"><a href="#pie_chart" data-toggle="tab">PIE CHART</a></li>
                        <li role="presentation"><a href="#table_request" data-toggle="tab">TABLE REQUEST</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" id="main_table">
                        <div role="tabpanel" class="tab-pane fade in active" id="bar_chart">
                            <b>Bar Chart</b>
                            <p>
                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="column" style="display:none">
                                <thead>
                                <tr>
                                    <th>
                                        Month
                                    </th>
                                    <th>
                                        Amount
                                        (Department :- {{$deptN}},
                                        Category :- {{$categoryN}},
                                        Type :- {{$typeN}},
                                        Project :- {{$projectN}},
                                        User :- {{$userN}})
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($chart_data as $key => $val)
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
                                        Amount
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($chart_data as $key => $val)
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
                                        Amount
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($chart_data as $key => $val)
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
                                        Amount
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($chart_data as $key => $val)
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
                                        Amount
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($chart_data as $key => $val)
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$val}}</td>
                                    </tr>

                                @endforeach
                                </tbody>

                            </table>
                            </p>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="table_request" style="overflow-x:scroll; width:auto;">
                            <b>All Requisitions</b>

                            <table class="table table-bordered table-hover table-striped" id="main_table">
                                <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                               name="check_all" class="" />
                            
                                    </th>
                                    <th>Manage</th>
                                    <th>View Register</th>
                                    <th>Account Number</th>
                                    <th>Account Name</th>
                                    <th>Account Category</th>
                                    <th>Detail Type</th>
                                    <th>Virtual Balance {{\App\Helpers\Utility::defaultCurrency()}}</th>
                                    <th>Bank Balance {{\App\Helpers\Utility::defaultCurrency()}}</th>
                                    <th>Original Cost {{\App\Helpers\Utility::defaultCurrency()}}</th>
                                    <th>Foreign Account Balance </th>
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
                                        <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_account_chart_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                    </td>
                                    <td>
                                        <a href="account_register/{{$data->id}}"><i class="fa fa-newspaper-o fa-2x"></i></a>
                                    </td>
                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    <td>{{$data->acct_no}}</td>
                                    <td>{{$data->acct_name}}</td>
                                    <td>{{$data->category->category_name}}</td>
                                    <td>{{$data->detail->detail_type}}</td>
                                    <td>
                                        @if(in_array($data->acct_cat_id,\App\Helpers\Utility::BALANCE_SHEET_ACCOUNTS))
                                        {{Utility::numberFormat($data->virtual_balance_trans)}}
                                        @endif
                                    </td>
                                    <td>{{Utility::numberFormat($data->bank_balance)}}</td>
                                    <td>{{Utility::numberFormat($data->original_cost)}}
                                    <td>
                                        @if(in_array($data->acct_cat_id,\App\Helpers\Utility::BALANCE_SHEET_ACCOUNTS))
                                        ({{$data->chartCurr->code}}){{$data->chartCurr->symbol}} {{Utility::numberFormat($data->virtual_balance)}}
                                        @endif
                                    </td>
                                    <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                                    <td>{{$data->created_at}}</td>
                                    <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
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
    </div>
    <!-- #END# Example Tab -->

<script>
    $(document).ready(function() {
        $('table.highchart').highchartTable();
    });
</script>