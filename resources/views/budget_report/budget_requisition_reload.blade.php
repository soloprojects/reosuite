
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
                    <li role="presentation"><a href="#table_request" data-toggle="tab">REQUEST TABLE</a></li>
                    <li role="presentation"><a href="#table_budget" data-toggle="tab">BUDGET TABLE</a></li>
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
                                    Requisition {{\App\Helpers\Utility::defaultCurrency()}}
                                    (Department :- {{$deptN}},
                                    Category :- {{$categoryN}},
                                    Type :- {{$typeN}},
                                    Project :- {{$projectN}},
                                    User :- {{$userN}})
                                </th>
                                <th>Budget {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($chart_data as $key => $val)
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
                    <div role="tabpanel" class="tab-pane fade" id="line_chart">
                        <b>Line Chart</b>
                        <p>
                        <table class="highchart" id="" data-graph-container-before="1" data-graph-type="line" style="display:none">
                            <thead>
                            <tr>
                                <th>Month</th>
                                <th>
                                    Requisition {{\App\Helpers\Utility::defaultCurrency()}}
                                    (Department :- {{$deptN}},
                                    Category :- {{$categoryN}},
                                    Type :- {{$typeN}},
                                    Project :- {{$projectN}},
                                    User :- {{$userN}})
                                </th>
                                <th>Budget {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($chart_data as $key => $val)
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
                    <div role="tabpanel" class="tab-pane fade" id="area_chart">
                        <b>Area Chart</b>
                        <p>
                        <table class="highchart" id="" data-graph-container-before="1" data-graph-type="area" style="display:none">
                            <thead>
                            <tr>
                                <th>Month</th>
                                <th>
                                    Requisition {{\App\Helpers\Utility::defaultCurrency()}}
                                    (Department :- {{$deptN}},
                                    Category :- {{$categoryN}},
                                    Type :- {{$typeN}},
                                    Project :- {{$projectN}},
                                    User :- {{$userN}})
                                </th>
                                <th>Budget {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($chart_data as $key => $val)
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
                    <div role="tabpanel" class="tab-pane fade" id="spline_chart">
                        <b>Spline Chart</b>
                        <p>
                        <table class="highchart" id="" data-graph-container-before="1" data-graph-type="spline" style="display:none">
                            <thead>
                            <tr>
                                <th>Month</th>
                                <th>
                                    Requisition {{\App\Helpers\Utility::defaultCurrency()}}
                                    (Department :- {{$deptN}},
                                    Category :- {{$categoryN}},
                                    Type :- {{$typeN}},
                                    Project :- {{$projectN}},
                                    User :- {{$userN}})
                                </th>
                                <th>Budget {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($chart_data as $key => $val)
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

                    <div role="tabpanel" class="tab-pane fade" id="table_request" style="overflow-x:scroll; width:auto;">
                        <b>All Requisitions</b>

                        <table class="table table-bordered table-hover table-striped" id="main_table" >
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                           name="check_all" class="" />

                                </th>

                                <th>Preview</th>
                                <th>Description</th>
                                <th>Edited</th>
                                <th>Request Category</th>
                                <th>Request Type</th>
                                <th>Project Category</th>
                                <th>Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
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
                            @foreach($mainData as $data)

                                @if($data->complete_status == 1)
                                    @if($data->deny_reason == '')
                                        <tr>
                                            <td scope="row">
                                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                            </td>
                                            <td>
                                                @if($data->finance_status == \App\Helpers\Utility::STATUS_ACTIVE)
                                                    <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$data->id}}','print_preview','printPreviewModal','<?php echo url('request_print_preview') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o"></i>Preview</a>
                                                @endif
                                            </td>
                                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                            <td>{{$data->req_desc}}</td>
                                            <td>
                                                @if($data->edit_request != '')
                                                    <?php $edited = json_decode($data->edit_request,true); ?>
                                                    @foreach($edited as $key => $val)
                                                        {{$key}} : {{$val}}<br>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>{{$data->requestCat->request_name}}</td>
                                            <td>{{$data->requestType->request_type}}</td>
                                            <td>
                                                @if($data->proj_id != 0)
                                                    {{$data->project->project_name}}
                                                @endif
                                            </td>
                                            <td>{{Utility::numberFormat($data->amount)}}</td>
                                            <td>{{$data->requestUser->firstname}} &nbsp; {{$data->requestUser->lastname}}</td>
                                            <td>{{$data->department->dept_id}}</td>
                                            <td>
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
                                                @else
                                                    @if($data->approval_status === 1)
                                                        Management
                                                    @endif
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
                                    @endif
                                @endif
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="table_budget" style="overflow-x:scroll; width:auto;">
                        <b>Budget</b>

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
                            @if(!empty($budget))

                                @foreach($budget as $data)
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

                            @if(!empty($budget))
                                <tr>
                                    <td scope="row">
                                        <input value="0" type="checkbox" id="0" class="kid_checkbox" />

                                    </td>
                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    <td></td>
                                    <td>Sum Total of Month and Quarterly Amount</td>
                                    <td></td>

                                    <td>
                                        {{$budget->totalJan}}
                                    </td>
                                    <td>
                                        {{$budget->totalFeb}}
                                    </td>
                                    <td>
                                        {{$budget->totalMarch}}
                                    </td>

                                    <td>
                                        {{$budget->fiQuarter}}

                                    </td>

                                    <td>
                                        {{$budget->totalApril}}
                                    </td>
                                    <td>
                                        {{$budget->totalMay}}
                                    </td>
                                    <td>
                                        {{$budget->totalJune}}
                                    </td>


                                    <td>
                                        {{$budget->sQuarter}}
                                    </td>

                                    <td>
                                        {{$budget->totalJuly}}
                                    </td>
                                    <td>
                                        {{$budget->totalAugust}}
                                    </td>
                                    <td>
                                        {{$budget->totalSept}}
                                    </td>


                                    <td>
                                        {{$budget->tQuarter}}

                                    </td>

                                    <td>
                                        {{$budget->totalOct}}
                                    </td>
                                    <td>
                                        {{$budget->totalNov}}
                                    </td>
                                    <td>
                                        {{$budget->totalDec}}
                                    </td>


                                    <td>
                                        {{$budget->foQuarter}}

                                    </td>
                                    <td>
                                        {{$budget->totalBudget}}

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