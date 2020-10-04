
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box-3 bg-indigo hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">Ongoing Opportunity(ies)</div>
                    <div class="number">{{Utility::numberFormat($chartObject->ongoingOpport)}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box-3 bg-green hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">Won Opportunities</div>
                    <div class="number">{{Utility::numberFormat($chartObject->wonOpport)}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box-3 bg-red hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">Lost Opportunities</div>
                    <div class="number">{{Utility::numberFormat($chartObject->lostOpport)}}</div>
                </div>
            </div>
        </div>

    </div>

    <div class="row clearfix">
        <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box-3 bg-deep-orange hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">Overdue Opportunity(ies)</div>
                    <div class="number">{{Utility::numberFormat($chartObject->overdueOpport)}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
            <div class="info-box-3 bg-pink hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">Opportunities due today</div>
                    <div class="number">{{Utility::numberFormat($chartObject->opportClosingToday)}}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box-3 bg-red hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">Ongoing (Expected Revenue)</div>
                    <div class="number">{{\App\Helpers\Utility::defaultCurrency()}}{{Utility::numberFormat($chartObject->ongoingOpportAmount)}}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box-3 bg-green hover-zoom-effect">
                <div class="icon">
                    <i class="material-icons">equalizer</i>
                </div>
                <div class="content">
                    <div class="text">Won (Expected Revenue)</div>
                    <div class="number">{{\App\Helpers\Utility::defaultCurrency()}}{{Utility::numberFormat($chartObject->wonOpportAmount)}}</div>
                </div>
            </div>
        </div>

    </div>
    <!-- #END# Hover Zoom Effect -->

    <div class="row clearfix">
        <!-- With Icons -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Number of Opportunities(Ongoing/Won/Lost)
                        <small></small>
                    </h2>

                </div>
                <div class="body">
                    <h2>Opportunities(Ongoing/Won/Lost)</h2>
                    <div class="row clearfix">

                        <table class="highchart" id="" data-graph-container-before="1" data-graph-type="column" style="display:none">
                            <thead>
                            <tr>
                                <th>Opportunity (Ongoing/Won/Lost)</th>
                                <th>
                                    Number
                                </th>
                            </tr>
                            </thead>

                            <tbody>

                            <tr>
                                <td>Ongoing Opportunities</td>
                                <td>{{$chartObject->ongoingOpport}}</td>
                            </tr>
                            <tr>
                                <td>Won Opportunities</td>
                                <td>{{$chartObject->wonOpport}}</td>
                            </tr>
                            <tr>
                                <td>Lost Opportunities</td>
                                <td>{{$chartObject->lostOpport}}</td>
                            </tr>

                            </tbody>

                        </table>


                    </div>

                </div>
            </div>
        </div>
        <!-- #END# With Icons -->
        <!-- Basic Examples -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Expected Revenue
                        <small></small>
                    </h2>

                </div>
                <div class="body">
                    <h2>Opportunities(Ongoing/Won/Lost) and Expected Revenue</h2>
                    <div class="row clearfix">

                        <table class="highchart" id="" data-graph-container-before="1" data-graph-type="column" style="display:none">
                            <thead>
                            <tr>
                                <th>Opportunities (Ongoing/Won/Lost)</th>
                                <th>
                                    Expected Amount {{\App\Helpers\Utility::defaultCurrency()}}
                                </th>
                            </tr>
                            </thead>

                            <tbody>

                            <tr>
                                <td>Ongoing Opportunities</td>
                                <td>{{$chartObject->ongoingOpportAmount}}</td>
                            </tr>
                            <tr>
                                <td>Won Opportunities</td>
                                <td>{{$chartObject->wonOpportAmount}}</td>
                            </tr>
                            <tr>
                                <td>Lost Opportunities</td>
                                <td>{{$chartObject->lostOpportAmount}}</td>
                            </tr>

                            </tbody>

                        </table>


                    </div>

                </div>
            </div>
        </div>
        <!-- #END# Basic Examples -->
    </div>

    <div class="row clearfix">
        <!-- Basic Examples -->
        <div class=" col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Number of opportunities in stages
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
                                    <th>Stage(s)</th>
                                    <th>
                                        Number of opportunities
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($chartObject->stageOpportCount as $key => $var)
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
                                    <th>Stage(s)</th>
                                    <th>
                                        Number of opportunities
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($chartObject->stageOpportCount as $key => $var)
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
                        Opportunities
                        <small></small>
                    </h2>

                </div>
                <div class="body table-responsive">

                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Pipeline</th>
                            <th>Lead</th>
                            <th>Opportunity</th>
                            <th>Sales Cycle</th>
                            <th>Stage/Phase</th>
                            <th>Status</th>
                            <th>Lost Reason</th>
                            <th>Probability (%)</th>
                            <th>Amount ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                            <th>Closing Date</th>
                            <th>Expected Revenue ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                            <th>Sales Team</th>
                            <th>Created by</th>
                            <th>Created at</th>
                            <th>Updated by</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)

                            @php
                                $salesTeamUserIds = json_decode($data->sales->users);
                            @endphp
                            @if(in_array(Auth::user()->id,$salesTeamUserIds) || $data->created_by == Auth::user()->id || in_array(Auth::user()->id,\App\Helpers\Utility::TOP_USERS))
                                <tr>
                                    <td scope="row">
                                        <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                    </td>
                                    <td>
                                        <a href="<?php echo url('crm_opportunity/id/'.$data->id) ?>">Pipeline Activities/Notes</a>
                                    </td>

                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    <td>{{$data->lead->name}}</td>
                                    <td>{{$data->opportunity_name}}</td>
                                    <td>{{$data->salesCycle->name}}</td>
                                    <td>{{$data->phase->name}} (Stage{{$data->phase->stage}})</td>
                                    <td style="color:black;" class="{{\App\Helpers\Utility::opportunityStatusIndicator($data->opportunity_status)}}">{{\App\Helpers\Utility::opportunityStatus($data->opportunity_status)}}</td>
                                    <td>{{$data->lost_reason}}</td>
                                    <td>{{$data->phase->probability}}</td>
                                    <td>{{Utility::numberFormat($data->amount)}}</td>
                                    <td>{{$data->closing_date}}</td>
                                    <td>{{Utility::numberFormat($data->expected_revenue)}}</td>
                                    <td>{{$data->sales->name}}</td>
                                    <td>
                                        {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                    </td>
                                    <td>{{$data->created_at}}</td>
                                    <td>
                                        {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                                    </td>
                                    <td>{{$data->updated_at}}</td>


                                    <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

                                </tr>
                            @else
                            @endif
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('table.highchart').highchartTable();
        });
    </script>

