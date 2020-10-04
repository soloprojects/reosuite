<!-- Example Tab -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Budget
                    <small>Displays the various dimensions of budget</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">

                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    <li role="presentation" class="active"><a href="#requestCategory" data-toggle="tab">Request Category Dimension</a></li>
                    <li role="presentation"><a href="#accountChart" data-toggle="tab">Chart of Accounts Dimension</a></li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="requestCategory">
                        <!-- BEGIN OF CHART OF ACCOUNT BUDGET DISPLAY -->
                        <div class="body table-responsive" id="reload_data_request_category" >
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
                                @if(!empty($budgetRequestCategoryDimension))

                                    @foreach($budgetRequestCategoryDimension as $data)
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

                                @if(!empty($budgetRequestCategoryDimension))
                                    <tr>
                                        <td scope="row">
                                            <input value="0" type="checkbox" id="0" class="kid_checkbox" />

                                        </td>
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <td>Sum Total of Month and Quarterly Amount</td>
                                        <td></td>

                                        <td>
                                            {{$budgetRequestCategoryDimension->totalJan}}
                                        </td>
                                        <td>
                                            {{$budgetRequestCategoryDimension->totalFeb}}
                                        </td>
                                        <td>
                                            {{$budgetRequestCategoryDimension->totalMarch}}
                                        </td>

                                        <td>
                                            {{$budgetRequestCategoryDimension->fiQuarter}}

                                        </td>

                                        <td>
                                            {{$budgetRequestCategoryDimension->totalApril}}
                                        </td>
                                        <td>
                                            {{$budgetRequestCategoryDimension->totalMay}}
                                        </td>
                                        <td>
                                            {{$budgetRequestCategoryDimension->totalJune}}
                                        </td>


                                        <td>
                                            {{$budgetRequestCategoryDimension->sQuarter}}
                                        </td>

                                        <td>
                                            {{$budgetRequestCategoryDimension->totalJuly}}
                                        </td>
                                        <td>
                                            {{$budgetRequestCategoryDimension->totalAugust}}
                                        </td>
                                        <td>
                                            {{$budgetRequestCategoryDimension->totalSept}}
                                        </td>


                                        <td>
                                            {{$budgetRequestCategoryDimension->tQuarter}}

                                        </td>

                                        <td>
                                            {{$budgetRequestCategoryDimension->totalOct}}
                                        </td>
                                        <td>
                                            {{$budgetRequestCategoryDimension->totalNov}}
                                        </td>
                                        <td>
                                            {{$budgetRequestCategoryDimension->totalDec}}
                                        </td>


                                        <td>
                                            {{$budgetRequestCategoryDimension->foQuarter}}

                                        </td>
                                        <td>
                                            {{$budgetRequestCategoryDimension->totalBudget}}

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
                        <!-- END OF CHART OF ACCOUNT BUDGET DISPLAY -->
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="accountChart">
                        <!-- BEGIN OF CHART OF ACCOUNT BUDGET DISPLAY -->
                        <div class="body table-responsive" id="reload_data_account_chart" >
                            <table class="table table-bordered table-hover table-striped tbl_scroll" id="main_table">
                                <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                               name="check_all" class="" />

                                    </th>
                                    <th>Department</th>
                                    <th>Account Category</th>
                                    <th>Account Name (Detail Type)</th>
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
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($budgetAccountChartDimension))

                                    @foreach($budgetAccountChartDimension as $data)

                                        <tr id="tr_{{$data->id}}">
                                            <td scope="row">
                                                <input value="{{$data->id}}" type="checkbox" id="remove_{{$data->id}}" class="kid_checkbox" />

                                            </td>
                                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                            <td>{{$data->department->dept_name}}</td>
                                            <td>{{$data->category->category_name}}</td>
                                            <td>{{$data->acct_name}} ({{$data->detail->detail_type}})</td>

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
                                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        </tr>
                                    @endforeach

                                @endif

                                <!-- MONTH AND QUARTERLY TOTAL AMOUNT -->

                                @if(!empty($budgetAccountChartDimension))
                                    <tr>
                                        <td scope="row">
                                            <input value="0" type="checkbox" id="0" class="kid_checkbox" />

                                        </td>
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <td>Sum Total of Month and Quarterly Amount</td>
                                        <td></td>

                                        <td>
                                            {{$budgetAccountChartDimension->totalJan}}
                                        </td>
                                        <td>
                                            {{$budgetAccountChartDimension->totalFeb}}
                                        </td>
                                        <td>
                                            {{$budgetAccountChartDimension->totalMarch}}
                                        </td>

                                        <td>
                                            {{$budgetAccountChartDimension->fiQuarter}}

                                        </td>

                                        <td>
                                            {{$budgetAccountChartDimension->totalApril}}
                                        </td>
                                        <td>
                                            {{$budgetAccountChartDimension->totalMay}}
                                        </td>
                                        <td>
                                            {{$budgetAccountChartDimension->totalJune}}
                                        </td>


                                        <td>
                                            {{$budgetAccountChartDimension->sQuarter}}
                                        </td>

                                        <td>
                                            {{$budgetAccountChartDimension->totalJuly}}
                                        </td>
                                        <td>
                                            {{$budgetAccountChartDimension->totalAugust}}
                                        </td>
                                        <td>
                                            {{$budgetAccountChartDimension->totalSept}}
                                        </td>


                                        <td>
                                            {{$budgetAccountChartDimension->tQuarter}}

                                        </td>

                                        <td>
                                            {{$budgetAccountChartDimension->totalOct}}
                                        </td>
                                        <td>
                                            {{$budgetAccountChartDimension->totalNov}}
                                        </td>
                                        <td>
                                            {{$budgetAccountChartDimension->totalDec}}
                                        </td>


                                        <td>
                                            {{$budgetAccountChartDimension->foQuarter}}

                                        </td>
                                        <td>
                                            {{$budgetAccountChartDimension->totalBudget}}

                                        </td>
                                    </tr>

                                @endif
                                <!-- END OF MONTH AND QUARTERLY TOTAL AMOUNT -->

                                </tbody>
                            </table>

                        </div>
                        <!-- END OF CHART OF ACCOUNT BUDGET DISPLAY -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Example Tab -->