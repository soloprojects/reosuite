
<!-- Example Tab -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Report
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
                    <li role="presentation"><a href="#budget1" data-toggle="tab">{{$budgetDetail1->name}}</a></li>
                    <li role="presentation"><a href="#budget2" data-toggle="tab">{{$budgetDetail2->name}}</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content" id="main_table">
                    <div role="tabpanel" class="tab-pane fade in active" id="bar_chart">
                        <b>Bar Chart</b>
                        <p>
                        <table class="highchart" id="" data-graph-container-before="1" data-graph-type="column" style="display:none">
                            <thead>
                            <tr>
                                <th>Month</th>
                                <th>
                                    {{$budgetDetail1->name}}
                                </th>
                                <th>{{$budgetDetail2->name}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($chart_data as $key => $val)
                                @php $explode = explode('|',$val); $budgetAmount1 = $explode[0]; $budgetAmount2 = $explode[1];  @endphp
                                <tr>
                                    <td>{{$key}}</td>
                                    <td>{{$budgetAmount1}}</td>
                                    <td>{{$budgetAmount2}}</td>
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
                                    {{$budgetDetail1->name}}
                                </th>
                                <th>{{$budgetDetail2->name}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($chart_data as $key => $val)
                                @php $explode = explode('|',$val); $budgetAmount1 = $explode[0]; $budgetAmount2 = $explode[1];  @endphp
                                <tr>
                                    <td>{{$key}}</td>
                                    <td>{{$budgetAmount1}}</td>
                                    <td>{{$budgetAmount2}}</td>
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
                                    {{$budgetDetail1->name}}
                                </th>
                                <th>{{$budgetDetail2->name}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($chart_data as $key => $val)
                                @php $explode = explode('|',$val); $budgetAmount1 = $explode[0]; $budgetAmount2 = $explode[1];  @endphp
                                <tr>
                                    <td>{{$key}}</td>
                                    <td>{{$budgetAmount1}}</td>
                                    <td>{{$budgetAmount2}}</td>
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
                                    {{$budgetDetail1->name}}
                                </th>
                                <th>{{$budgetDetail2->name}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($chart_data as $key => $val)
                                @php $explode = explode('|',$val); $budgetAmount1 = $explode[0]; $budgetAmount2 = $explode[1];  @endphp
                                <tr>
                                    <td>{{$key}}</td>
                                    <td>{{$budgetAmount1}}</td>
                                    <td>{{$budgetAmount2}}</td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table>
                        </p>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="budget1" style="overflow-x:scroll; width:auto;">
                        <b>{{$budgetDetail1->name}}</b>

                        <table class="table table-bordered table-hover table-striped tbl_scroll" id="main_table">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                           name="check_all" class="" />

                                </th>

                                <th>Department</th>
                                <th>Request Name</th>
                                <th>Account Category</th>
                                <th>January ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>February ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>March ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>1st Quarter ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>April ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>May ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>June ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>2nd Quarter ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>July ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>August ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>September ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>3rd Quarter ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>October ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>November ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>December ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>4th Quarter ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>Annual Category Total ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>Created by</th>
                                <th>Updated by</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($budget1))

                                @foreach($budget1 as $data)
                                    <tr id="tr_{{$data->id}}">
                                        <td scope="row">
                                            <input value="{{$data->id}}" type="checkbox" id="remove_{{$data->id}}" class="kid_checkbox" />

                                        </td>
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <td>{{$data->department->dept_name}}</td>
                                        <td>{{$data->requestCategory->request_name}}</td>
                                        <td>
                                            {{$data->account->acct_name}}
                                        </td>


                                        <td>
                                            {{$data->jan}}
                                        </td>
                                        <td>
                                            {{$data->feb}}
                                        </td>
                                        <td>
                                            {{$data->march}}
                                        </td>


                                        <td>
                                            {{$data->first_quarter}}

                                        </td>

                                        <td>
                                            {{$data->april}}
                                        </td>
                                        <td>
                                            {{$data->may}}
                                        </td>
                                        <td>
                                            {{$data->june}}
                                        </td>


                                        <td>
                                            {{$data->second_quarter}}

                                        </td>

                                        <td>
                                            {{$data->july}}
                                        </td>
                                        <td>
                                            {{$data->august}}
                                        </td>
                                        <td>
                                            {{$data->sept}}
                                        </td>


                                        <td>
                                            {{$data->third_quarter}}
                                        </td>

                                        <td>
                                            {{$data->oct}}
                                        </td>
                                        <td>
                                            {{$data->nov}}
                                        </td>
                                        <td>
                                            {{$data->dec}}
                                        </td>

                                        <td>
                                            {{$data->fourth_quarter}}
                                        </td>
                                        <td>
                                            {{$data->total_cat_amount}}

                                        </td>
                                        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                                        <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
                                        <td>{{$data->created_at}}</td>
                                        <td>{{$data->created_at}}</td>
                                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    </tr>
                                @endforeach

                            @endif

                            <!-- MONTH AND QUARTERLY TOTAL AMOUNT -->

                            @if(!empty($budget1))
                                <tr>
                                    <td scope="row">
                                        <input value="0" type="checkbox" id="0" class="kid_checkbox" />

                                    </td>
                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    <td></td>
                                    <td>Sum Total of Month and Quarterly Amount</td>
                                    <td></td>

                                    <td>
                                        {{$budget1->totalJan}}
                                    </td>
                                    <td>
                                        {{$budget1->totalFeb}}
                                    </td>
                                    <td>
                                        {{$budget1->totalMarch}}
                                    </td>

                                    <td>
                                        {{$budget1->fiQuarter}}

                                    </td>

                                    <td>
                                        {{$budget1->totalApril}}
                                    </td>
                                    <td>
                                        {{$budget1->totalMay}}
                                    </td>
                                    <td>
                                        {{$budget1->totalJune}}
                                    </td>


                                    <td>
                                        {{$budget1->sQuarter}}
                                    </td>

                                    <td>
                                        {{$budget1->totalJuly}}
                                    </td>
                                    <td>
                                        {{$budget1->totalAugust}}
                                    </td>
                                    <td>
                                        {{$budget1->totalSept}}
                                    </td>


                                    <td>
                                        {{$budget1->tQuarter}}

                                    </td>

                                    <td>
                                        {{$budget1->totalOct}}
                                    </td>
                                    <td>
                                        {{$budget1->totalNov}}
                                    </td>
                                    <td>
                                        {{$budget1->totalDec}}
                                    </td>


                                    <td>
                                        {{$budget1->foQuarter}}

                                    </td>
                                    <td>
                                        {{$budget1->totalBudget}}

                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif
                            <!-- END OF MONTH AND QUARTERLY TOTAL AMOUNT -->

                            </tbody>
                        </table>

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="budget2" style="overflow-x:scroll; width:auto;">
                        <b>{{$budgetDetail2->name}}</b>

                        <table class="table table-bordered table-hover table-striped tbl_scroll" id="main_table">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                           name="check_all" class="" />

                                </th>

                                <th>Department</th>
                                <th>Request Name</th>
                                <th>Account Category</th>
                                <th>January ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>February ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>March ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>1st Quarter ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>April ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>May ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>June ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>2nd Quarter ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>July ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>August ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>September ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>3rd Quarter ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>October ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>November ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>December ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>4th Quarter ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>Annual Category Total ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                                <th>Created by</th>
                                <th>Updated by</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($budget2))

                                @foreach($budget2 as $data)
                                    <tr id="tr_{{$data->id}}">
                                        <td scope="row">
                                            <input value="{{$data->id}}" type="checkbox" id="remove_{{$data->id}}" class="kid_checkbox" />

                                        </td>
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <td>{{$data->department->dept_name}}</td>
                                        <td>{{$data->requestCategory->request_name}}</td>
                                        <td>
                                            {{$data->account->acct_name}}
                                        </td>


                                        <td>
                                            {{$data->jan}}
                                        </td>
                                        <td>
                                            {{$data->feb}}
                                        </td>
                                        <td>
                                            {{$data->march}}
                                        </td>


                                        <td>
                                            {{$data->first_quarter}}

                                        </td>

                                        <td>
                                            {{$data->april}}
                                        </td>
                                        <td>
                                            {{$data->may}}
                                        </td>
                                        <td>
                                            {{$data->june}}
                                        </td>


                                        <td>
                                            {{$data->second_quarter}}

                                        </td>

                                        <td>
                                            {{$data->july}}
                                        </td>
                                        <td>
                                            {{$data->august}}
                                        </td>
                                        <td>
                                            {{$data->sept}}
                                        </td>


                                        <td>
                                            {{$data->third_quarter}}
                                        </td>

                                        <td>
                                            {{$data->oct}}
                                        </td>
                                        <td>
                                            {{$data->nov}}
                                        </td>
                                        <td>
                                            {{$data->dec}}
                                        </td>

                                        <td>
                                            {{$data->fourth_quarter}}
                                        </td>
                                        <td>
                                            {{$data->total_cat_amount}}

                                        </td>
                                        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                                        <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
                                        <td>{{$data->created_at}}</td>
                                        <td>{{$data->created_at}}</td>
                                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    </tr>
                                @endforeach

                            @endif

                            <!-- MONTH AND QUARTERLY TOTAL AMOUNT -->

                            @if(!empty($budget2))
                                <tr>
                                    <td scope="row">
                                        <input value="0" type="checkbox" id="0" class="kid_checkbox" />

                                    </td>
                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    <td></td>
                                    <td>Sum Total of Month and Quarterly Amount</td>
                                    <td></td>

                                    <td>
                                        {{$budget2->totalJan}}
                                    </td>
                                    <td>
                                        {{$budget2->totalFeb}}
                                    </td>
                                    <td>
                                        {{$budget2->totalMarch}}
                                    </td>

                                    <td>
                                        {{$budget2->fiQuarter}}

                                    </td>

                                    <td>
                                        {{$budget2->totalApril}}
                                    </td>
                                    <td>
                                        {{$budget2->totalMay}}
                                    </td>
                                    <td>
                                        {{$budget2->totalJune}}
                                    </td>


                                    <td>
                                        {{$budget2->sQuarter}}
                                    </td>

                                    <td>
                                        {{$budget2->totalJuly}}
                                    </td>
                                    <td>
                                        {{$budget2->totalAugust}}
                                    </td>
                                    <td>
                                        {{$budget2->totalSept}}
                                    </td>


                                    <td>
                                        {{$budget2->tQuarter}}

                                    </td>

                                    <td>
                                        {{$budget2->totalOct}}
                                    </td>
                                    <td>
                                        {{$budget2->totalNov}}
                                    </td>
                                    <td>
                                        {{$budget2->totalDec}}
                                    </td>


                                    <td>
                                        {{$budget2->foQuarter}}

                                    </td>
                                    <td>
                                        {{$budget2->totalBudget}}

                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endif
                            <!-- END OF MONTH AND QUARTERLY TOTAL AMOUNT -->

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