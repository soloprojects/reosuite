
@php
$subscription = Utility::subscription(); 
$appArr = $subscription->appArray;
$userApps = $subscription->userApps;

@endphp

@php $month = date('F'); $year = date('Y'); @endphp

@if(!empty($budgetRequisitionReport))

    <!-- BUDGET REPORTING -->
    @if(in_array($appArr[13],$userApps))
        <!-- BUDGET VS REQUISITION REPORT -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{$month}} Budget vs Requisitions Report
                            <small></small>
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    @include('includes/export',[$exportId = 'main_table_budget_requisition', $exportDocId = 'main_table_budget_requisition'])
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs tab-nav-right" role="tablist">
                            <li role="presentation" class="active"><a href="#bar_chart_budget_requisition" data-toggle="tab">BAR CHART</a></li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content" id="main_table_budget_requisition">
                            <div role="tabpanel" class="tab-pane fade in active" id="bar_chart_budget_requisition">
                                <b>Bar Chart</b>
                                <p>
                                <table class="highchart" id="" data-graph-container-before="1" data-graph-type="column" style="display:none">
                                    <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Requisition {{\App\Helpers\Utility::defaultCurrency()}}</th>
                                        <th>Budget {{\App\Helpers\Utility::defaultCurrency()}}</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($budgetRequisitionReport as $key => $val)
                                        @php $explode = explode('|',$val); $requisitionAmount = $explode[0]; $budgetAmount = $explode[1];  @endphp
                                        <tr>
                                            <td>{{$key}}</td>
                                            <td>{{$requisitionAmount}}</td>
                                            <td>{{$budgetAmount}}</td>
                                        </tr>

                                    @endforeach
                                    </tbody>

                                </table>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# BUDGET VS REQUISITION REPORT -->
    @endif
@else

    <!-- REQUISITION REPORTING -->
    @if(in_array($appArr[0],$userApps))
        @if(!empty($requisitionReport))

            <!-- REQUISITION CATEGORY REPORT -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                {{$month}} Requisition Report
                                <small></small>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        @include('includes/export',[$exportId = 'main_table_requisition', $exportDocId = 'main_table_requisition'])
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <li role="presentation" class="active"><a href="#bar_chart_user_requisition" data-toggle="tab">BAR CHART</a></li>

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content" id="main_table_requisition">
                                <div role="tabpanel" class="tab-pane fade in active" id="bar_chart_user_requisition">
                                    <b>Bar Chart</b>
                                    <p>
                                    <table class="highchart" id="" data-graph-container-before="1" data-graph-type="column" style="display:none">
                                        <thead>
                                        <tr>
                                            <th>
                                                Month
                                            </th>
                                            <th>Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($requisitionReport as $key => $val)
                                            <tr>
                                                <td>{{$key}}</td>
                                                <td>{{$val}}</td>
                                            </tr>

                                        @endforeach
                                        </tbody>

                                    </table>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# REQUISITION CATEGORY REPORT -->

        @endif
    @endif

@endif


<!-- PROJECT REPORT -->

<div class="row clearfix">

    <!-- NEWS REPORTING -->
    @if(in_array($appArr[9],$userApps))
        <!-- NEWS UPDATE/NOTICE TIPS -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Latest News Updates/Notice Tips
                        <small></small>
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table_news', $exportDocId = 'reload_data_news'])
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="body table-responsive" id="reload_data_news">
                        <table class="table table-bordered table-hover table-striped" id="main_table_news">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check_new"
                                        name="check_all" class="" />

                                </th>

                                <th>View</th>
                                <th>News Title</th>
                                <th>Created by</th>
                                <th>Updated by</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lastNews as $data)
                                <tr>

                                    <td scope="row">
                                        <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                    </td>
                                    <td>
                                        <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','display_news','news_modal','<?php echo url('fetch_news') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-eye fa-2x"></i></a>

                                    </td>
                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    <td>{{$data->news_title}}</td>
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

                    </div>
                </div>
            </div>
        </div>
        <!-- #END# NEWS UPDATE/NOTICE TIPS -->
    @endif

    <!-- PROJECT REPORTING -->
    @if(in_array($appArr[15],$userApps))
        @if(!empty($projectReport))
        <!-- OPEN/CLOSED PROJECT -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Project (Open/Closed/Total)
                            <small></small>
                        </h2>

                    </div>
                    <div class="body">
                        <h2>Total Project -- {{$projectReport->totalProject}}</h2>
                        <div class="row clearfix">

                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="pie" style="display:none">
                                <thead>
                                <tr>
                                    <th>Project (Open/Closed/Total)</th>
                                    <th>
                                        Number
                                    </th>
                                </tr>
                                </thead>

                                <tbody>

                                <tr>
                                    <td>Open</td>
                                    <td>{{$projectReport->openProject}}</td>
                                </tr>
                                <tr>
                                    <td>Closed</td>
                                    <td>{{$projectReport->closedProject}}</td>
                                </tr>

                                </tbody>

                            </table>


                        </div>

                    </div>
                </div>
            </div>
            <!-- #END# OPEN/CLOSED PROJECT -->
        @endif
    @endif

</div>

<!-- PROJECT REPORTING -->
@if(in_array($appArr[15],$userApps))
    @if(!empty($projectReport))
        <div class="row clearfix">
            <!-- Basic Examples -->
            <div class=" col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Project Status
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
                                        <th>Project Status</th>
                                        <th>
                                            Number
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($projectReport->projectStatus as $key => $var)
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
                                        <th>Project(s)</th>
                                        <th>
                                            Number
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($projectReport->projectStatus as $key => $var)
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
        <!-- #END# PROJECT REPORT -->
    @endif
@endif

<!-- CRM REPORTING -->
@if(in_array($appArr[1],$userApps))
    @if(!empty($crmReport))

        <!-- CRM REPORT -->
        <div class="row clearfix">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="info-box-3 bg-indigo hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">equalizer</i>
                    </div>
                    <div class="content">
                        <div class="text">{{$year}} Ongoing Opportunity(ies)</div>
                        <div class="number">{{Utility::numberFormat($crmReport->ongoingOpport)}}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="info-box-3 bg-green hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">equalizer</i>
                    </div>
                    <div class="content">
                        <div class="text">{{$year}} Won Opportunities</div>
                        <div class="number">{{Utility::numberFormat($crmReport->wonOpport)}}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="info-box-3 bg-red hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">equalizer</i>
                    </div>
                    <div class="content">
                        <div class="text">{{$year}} Lost Opportunities</div>
                        <div class="number">{{Utility::numberFormat($crmReport->lostOpport)}}</div>
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
                        <div class="text">{{$year}} Overdue Opportunity(ies)</div>
                        <div class="number">{{Utility::numberFormat($crmReport->overdueOpport)}}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                <div class="info-box-3 bg-pink hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">equalizer</i>
                    </div>
                    <div class="content">
                        <div class="text">{{$year}} Opportunities due today</div>
                        <div class="number">{{Utility::numberFormat($crmReport->opportClosingToday)}}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <!-- With Icons -->
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{$year}} Number of CRM Opportunities(Ongoing/Won/Lost)
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
                                    <td>{{$crmReport->ongoingOpport}}</td>
                                </tr>
                                <tr>
                                    <td>Won Opportunities</td>
                                    <td>{{$crmReport->wonOpport}}</td>
                                </tr>
                                <tr>
                                    <td>Lost Opportunities</td>
                                    <td>{{$crmReport->lostOpport}}</td>
                                </tr>

                                </tbody>

                            </table>


                        </div>

                    </div>
                </div>
            </div>
            <!-- #END# With Icons -->
            <!-- Basic Examples -->
            @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                {{$year}} Expected Revenue from CRM Opportunities
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
                                        <td>{{$crmReport->ongoingOpportAmount}}</td>
                                    </tr>
                                    <tr>
                                        <td>Won Opportunities</td>
                                        <td>{{$crmReport->wonOpportAmount}}</td>
                                    </tr>
                                    <tr>
                                        <td>Lost Opportunities</td>
                                        <td>{{$crmReport->lostOpportAmount}}</td>
                                    </tr>

                                    </tbody>

                                </table>


                            </div>

                        </div>
                    </div>
                </div>
        @endif
        <!-- #END# Basic Examples -->
        </div>

        <!-- #END# CRM REPORT -->

    @endif
@endif

<!-- FLEET MANAGEMENT REPORTING -->
@if(in_array($appArr[14],$userApps))
    @if(!empty($vehicleServiceLogReport))

        <!-- VEHICLE SERVICE LOG REPORT -->
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="info-box-3 bg-deep-orange hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">equalizer</i>
                    </div>
                    <div class="content">
                        <div class="text">{{$month}} Total Vehicle Service Bill {{\App\Helpers\Utility::defaultCurrency()}}</div>
                        <div class="number">{{Utility::numberFormat($vehicleServiceLogReport->totalBill)}}</div>
                        
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="info-box-3 bg-red hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">equalizer</i>
                    </div>
                    <div class="content">
                        <div class="text">{{$month}} Total  Spent in Workshop(s)</div>
                        <div class="number">{{Utility::numberFormat($vehicleServiceLogReport->workshopMileage)}}</div>
                    </div>
                </div>
            </div>

        </div>
        <!-- #END# VEHICLE SERVICE LOG REPORT -->

    @endif

    @if(!empty($vehicleFuelLogReport))

        <!-- VEHICLE FUEL LOG REPORT -->
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="info-box-3 bg-deep-orange hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">equalizer</i>
                    </div>
                    <div class="content">
                        <div class="text">{{$month}} Total Vehicle Fuel Purchase Price {{\App\Helpers\Utility::defaultCurrency()}}</div>
                        <div class="number">{{Utility::numberFormat($vehicleFuelLogReport->totalPurchasePrice)}}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="info-box-3 bg-green hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">equalizer</i>
                    </div>
                    <div class="content">
                        <div class="text">{{$month}} Total Vehicle Fuel (Liters) Purchased</div>
                        <div class="number">{{Utility::numberFormat($vehicleFuelLogReport->totalLiters)}}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="info-box-3 bg-red hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">equalizer</i>
                    </div>
                    <div class="content">
                        <div class="text">{{$month}} Total Vehicle {{Utility::odometerMeasure()->name}} Accrued With Purchased Fuel</div>
                        <div class="number">{{Utility::numberFormat($vehicleFuelLogReport->totalMileage)}}</div>
                    </div>
                </div>
            </div>

        </div>
        <!-- #END# VEHICLE FUEL LOG REPORT -->

    @endif
@endif

@if(!empty($lastRequisition))

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Latest Requisitions
                    </h2>
                    <ul class="header-dropdown m-r--5">

                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table_last_requisition', $exportDocId = 'reload_data_last_requisition'])
                            </ul>
                        </li>

                    </ul>
                </div>
                <div class="body table-responsive" id="reload_data_last_requisition">
                    <table class="table table-bordered table-hover table-striped" id="main_table_last_requisition">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check_req"
                                       name="check_all" class="" />

                            </th>

                            <th>Description</th>
                            <th>Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Approval Status</th>
                            <th>Finance Status</th>
                            <th>Approved by</th>
                            <th>Request Category</th>
                            <th>Request Type</th>
                            <th>Project Category</th>
                            <th>Requested by</th>
                            <th>Department</th>
                            <th>Created by</th>
                            <th>Updated by</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lastRequisition as $data)
                            <tr>
                                <td scope="row">
                                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                </td>

                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>{{$data->req_desc}}</td>
                                <td>{{Utility::numberFormat($data->amount)}}</td>
                                <td class="{{\App\Helpers\Utility::statusIndicator($data->approval_status)}}">
                                    @if($data->approval_status === 1)
                                        Request Approved
                                    @endif
                                    @if($data->approval_status === 0)
                                        Processing Request
                                    @endif
                                    @if($data->approval_status === 2)
                                        Request Denied
                                    @endif
                                </td>
                                <td>
                                    @if($data->finance_status === 0)
                                        Processing
                                    @endif
                                    @if($data->finance_status === 1)
                                        Complete and Ready for Print
                                    @endif
                                </td>
                                <td>
                                    @if($data->approved_users != '')
                                        <table class="table table-bordered table-responsive">
                                            <thead>
                                            <th>Name</th>
                                            <th>Reason</th>
                                            </thead>
                                            <tbody>
                                            @foreach($data->approved_by as $users)
                                                <tr>
                                                    <td>{{$users->firstname}} &nbsp; {{$users->lastname}}</td>
                                                    <td>Approved</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                @if($data->deny_reason != '')
                                                    <td>{{$data->denyUser->firstname}} &nbsp; {{$data->denyUser->lastname}}</td>
                                                    <td>Denied: {{$data->deny_reason}}</td>
                                                @endif
                                            </tr>
                                            </tbody>
                                        </table>
                                    @else
                                        @if($data->approval_status === 1)
                                            Management
                                        @endif
                                    @endif
                                </td>
                                <td>{{$data->requestCat->request_name}}</td>
                                <td>{{$data->requestType->request_type}}</td>
                                <td>
                                    @if($data->proj_id != 0)
                                        {{$data->project->project_name}}
                                    @endif
                                </td>
                                <td>{{$data->requestUser->firstname}} &nbsp; {{$data->requestUser->lastname}}</td>
                                <td>{{$data->department->dept_name}}</td>
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

@endif

<!-- PAYROLLS SYESTEM,LEAVE MANAGEMENT REPORTING -->
@if(in_array($appArr[17],$userApps))
    @if(!empty($lastLeave))

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Latest Leave Requests
                        </h2>
                        <ul class="header-dropdown m-r--5">

                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    @include('includes/export',[$exportId = 'main_table_last_leave', $exportDocId = 'reload_data_last_leave'])
                                </ul>
                            </li>

                        </ul>
                    </div>
                    <div class="body table-responsive" id="reload_data_last_leave">
                        <table class="table table-bordered table-hover table-striped" id="main_table_last_leave">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                        name="check_all" class="" />

                                </th>

                                <th>Leave Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Number of Days</th>
                                <th>Requested by</th>
                                <th>Department</th>
                                <th>Approval Status</th>
                                <th>Approved by</th>
                                <th>Created by</th>
                                <th>Updated by</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lastLeave as $data)
                                <tr>
                                    <td scope="row">
                                        <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                    </td>

                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    <td>{{$data->leaveType->leave_type}}</td>
                                    <td>{{$data->start_date}}</td>
                                    <td>{{$data->end_date}}</td>
                                    <td>{{$data->duration}} &nbsp; day(s)</td>
                                    <td>{{$data->requestUser->firstname}} &nbsp; {{$data->requestUser->lastname}}</td>
                                    <td>{{$data->department->dept_name}}</td>
                                    <td class="{{\App\Helpers\Utility::statusIndicator($data->approval_status)}}">
                                        @if($data->approval_status === 1)
                                            Request Approved
                                        @endif
                                        @if($data->approval_status === 0)
                                            Processing Request
                                        @endif
                                        @if($data->approval_status === 2)
                                            Request Denied
                                        @endif
                                    </td>
                                    <td>
                                        @if($data->approved_users != '')
                                            <table class="table table-bordered table-responsive">
                                                <thead>
                                                <th>Name</th>
                                                <th>Reason</th>
                                                </thead>
                                                <tbody>
                                                @foreach($data->approved_by as $users)
                                                    <tr>
                                                        <td>{{$users->firstname}} &nbsp; {{$users->lastname}}</td>
                                                        <td>Approved</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    @if($data->deny_reason != '')
                                                        <td>{{$data->denyUser->firstname}} &nbsp; {{$data->denyUser->lastname}}</td>
                                                        <td>Denied: {{$data->deny_reason}}</td>
                                                    @endif
                                                </tr>
                                                </tbody>
                                            </table>
                                        @endif
                                    </td>
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

    @endif
@endif

<!-- HELP DESK REPORTING -->
@if(in_array($appArr[6],$userApps))
    @if(!empty($lastHelpDesk))

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Latest Help Desk Ticket(s)
                        </h2>
                        <ul class="header-dropdown m-r--5">

                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    @include('includes/export',[$exportId = 'main_table_last_help_desk', $exportDocId = 'reload_data_last_help_desk'])
                                </ul>
                            </li>

                        </ul>
                    </div>
                    <div class="body table-responsive" id="reload_data_last_help_desk">
                        <table class="table table-bordered table-hover table-striped" id="main_table_last_help_desk">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                        name="check_all" class="" />

                                </th>

                                <th>Ticket Category</th>
                                <th>Full Name</th>
                                <th>Department</th>
                                <th>Response Rate</th>
                                <th>subject</th>
                                <th>Details</th>
                                <th>Response</th>
                                <th>Response Status</th>
                                <th>Response Dates</th>
                                <th>Response from</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lastHelpDesk as $data)
                                <tr>
                                    <td scope="row">
                                        <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                    </td>

                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    <td>{{$data->ticketCategory->request_name}}</td>
                                    <td>
                                        {{$data->reqUser->firstname}}&nbsp;{{$data->reqUser->lastname}}

                                    </td>
                                    <td>{{$data->department->dept_name}}</td>
                                    <td>{{$data->response_rate}}</td>
                                    <td>{{$data->subject}}</td>
                                    <td>{!!$data->details!!}</td>
                                    <td>{!!$data->response!!}</td>
                                    <td class="{{\App\Helpers\Utility::statusIndicator($data->response_status)}}">{{\App\Helpers\Utility::defaultStatus($data->response_status)}}</td>
                                    <td>{{$data->response_dates}}</td>
                                    <td>{{$data->user_u->updated_by}}</td>
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


    @endif
@endif

<script>

    $(document).ready(function() {
        $('table.highchart').highchartTable();
    });

</script>