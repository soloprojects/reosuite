@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Add to budget (Chart of Account Dimension)
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS) || $detectHod == \App\Helpers\Utility::HOD_DETECTOR)

                        @endif
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
                <div class="body table-responsive" id="reload_data" >
                    <table class="table table-bordered table-hover table-striped tbl_order" id="main_table">
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
                            <th>Remove</th>
                            <th>Created by</th>
                            <th>Updated by</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($budget))
                            @php $enum = 0; $num = 0;  @endphp
                            @foreach($budget as $data)
                                @php $enum++ @endphp
                                <tr id="tr_{{$data->id}}">
                                    <td scope="row">
                                        <input value="{{$data->id}}" type="checkbox" id="remove_{{$data->id}}" class="kid_checkbox" />

                                    </td>
                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    <td>{{$data->department->dept_name}}</td>
                                    <td>{{$data->acctCat->category_name}}</td>
                                    <td>{{$data->account->acct_name}} ({{$data->acctDetail->detail_type}})</td>

                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_1 cat_{{$enum}}_{{$data->acct_id}} first_quarter_{{$enum}}_{{$data->acct_id}}"  id="month_1_cat_{{$enum}}_{{$data->acct_id}}"
                                                           onkeyup="saveBudget('month_1_cat_{{$enum}}_{{$data->acct_id}}','first_quarter_{{$enum}}_{{$data->acct_id}}','cat_{{$enum}}_{{$data->acct_id}}',
                                                                   'first_quarter','month_1','total_cat','first_quarter_view_{{$enum}}_{{$data->acct_id}}',
                                                                   'total_cat_view_{{$enum}}_{{$data->acct_id}}','total_first_quarter_view','month_total_1',
                                                                   'annual_total_budget_view','month_1','first_quarter','{{$budgetDetail->id}}',
                                                                   '{{$budgetDetail->fin_year_id}}','{{$data->acct_id}}','{{$budgetDetail->dept_id}}','{{$data->id}}')" value="{{$data->jan}}" name="amount" placeholder="Budget Amount">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_2 cat_{{$enum}}_{{$data->acct_id}} first_quarter_{{$enum}}_{{$data->acct_id}}"  id="month_2_cat_{{$enum}}_{{$data->acct_id}}"
                                                           onkeyup="saveBudget('month_2_cat_{{$enum}}_{{$data->acct_id}}','first_quarter_{{$enum}}_{{$data->acct_id}}','cat_{{$enum}}_{{$data->acct_id}}',
                                                                   'first_quarter','month_2','total_cat','first_quarter_view_{{$enum}}_{{$data->acct_id}}',
                                                                   'total_cat_view_{{$enum}}_{{$data->acct_id}}','total_first_quarter_view','month_total_2',
                                                                   'annual_total_budget_view','month_2','first_quarter','{{$budgetDetail->id}}',
                                                                   '{{$budgetDetail->fin_year_id}}','{{$data->acct_id}}','{{$budgetDetail->dept_id}}','{{$data->id}}')" value="{{$data->feb}}" name="amount" placeholder="Budget Amount">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_3 cat_{{$enum}}_{{$data->acct_id}} first_quarter_{{$enum}}_{{$data->acct_id}}"  id="month_3_cat_{{$enum}}_{{$data->acct_id}}"
                                                           onkeyup="saveBudget('month_3_cat_{{$enum}}_{{$data->acct_id}}','first_quarter_{{$enum}}_{{$data->acct_id}}','cat_{{$enum}}_{{$data->acct_id}}',
                                                                   'first_quarter','month_3','total_cat','first_quarter_view_{{$enum}}_{{$data->acct_id}}',
                                                                   'total_cat_view_{{$enum}}_{{$data->acct_id}}','total_first_quarter_view','month_total_3',
                                                                   'annual_total_budget_view','month_3','first_quarter','{{$budgetDetail->id}}',
                                                                   '{{$budgetDetail->fin_year_id}}','{{$data->acct_id}}','{{$budgetDetail->dept_id}}','{{$data->id}}')" value="{{$data->march}}" name="amount" placeholder="Budget Amount">
                                                </div>
                                            </div>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="first_quarter" disabled id="first_quarter_view_{{$enum}}_{{$data->acct_id}}" value="{{$data->first_quarter}}" name="first_quarter" placeholder="First Quarter Total">
                                                </div>
                                            </div>
                                        </div>

                                    </td>

                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_4 cat_{{$enum}}_{{$data->acct_id}} second_quarter_{{$enum}}_{{$data->acct_id}}"  id="month_4_cat_{{$enum}}_{{$data->acct_id}}"
                                                           onkeyup="saveBudget('month_4_cat_{{$enum}}_{{$data->acct_id}}','second_quarter_{{$enum}}_{{$data->acct_id}}','cat_{{$enum}}_{{$data->acct_id}}',
                                                                   'second_quarter','month_4','total_cat','second_quarter_view_{{$enum}}_{{$data->acct_id}}',
                                                                   'total_cat_view_{{$enum}}_{{$data->acct_id}}','total_second_quarter_view','month_total_4',
                                                                   'annual_total_budget_view','month_4','second_quarter','{{$budgetDetail->id}}',
                                                                   '{{$budgetDetail->fin_year_id}}','{{$data->acct_id}}','{{$budgetDetail->dept_id}}','{{$data->id}}')" value="{{$data->april}}" name="amount" placeholder="Budget Amount">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_5 cat_{{$enum}}_{{$data->acct_id}} second_quarter_{{$enum}}_{{$data->acct_id}}"  id="month_5_cat_{{$enum}}_{{$data->acct_id}}"
                                                           onkeyup="saveBudget('month_5_cat_{{$enum}}_{{$data->acct_id}}','second_quarter_{{$enum}}_{{$data->acct_id}}','cat_{{$enum}}_{{$data->acct_id}}',
                                                                   'second_quarter','month_5','total_cat','second_quarter_view_{{$enum}}_{{$data->acct_id}}',
                                                                   'total_cat_view_{{$enum}}_{{$data->acct_id}}','total_second_quarter_view','month_total_5',
                                                                   'annual_total_budget_view','month_5','second_quarter','{{$budgetDetail->id}}',
                                                                   '{{$budgetDetail->fin_year_id}}','{{$data->acct_id}}','{{$budgetDetail->dept_id}}','{{$data->id}}')" value="{{$data->may}}" name="amount" placeholder="Budget Amount">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_6 cat_{{$enum}}_{{$data->acct_id}} second_quarter_{{$enum}}_{{$data->acct_id}}"  id="month_6_cat_{{$enum}}_{{$data->acct_id}}"
                                                           onkeyup="saveBudget('month_6_cat_{{$enum}}_{{$data->acct_id}}','second_quarter_{{$enum}}_{{$data->acct_id}}','cat_{{$enum}}_{{$data->acct_id}}',
                                                                   'second_quarter','month_6','total_cat','second_quarter_view_{{$enum}}_{{$data->acct_id}}',
                                                                   'total_cat_view_{{$enum}}_{{$data->acct_id}}','total_second_quarter_view','month_total_6',
                                                                   'annual_total_budget_view','month_6','second_quarter','{{$budgetDetail->id}}',
                                                                   '{{$budgetDetail->fin_year_id}}','{{$data->acct_id}}','{{$budgetDetail->dept_id}}','{{$data->id}}')" value="{{$data->june}}" name="amount" placeholder="Budget Amount">
                                                </div>
                                            </div>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="second_quarter " disabled id="second_quarter_view_{{$enum}}_{{$data->acct_id}}" value="{{$data->second_quarter}}" name="second_quarter" placeholder="Second Quarter Total">
                                                </div>
                                            </div>
                                        </div>

                                    </td>

                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_7 cat_{{$enum}}_{{$data->acct_id}} third_quarter_{{$enum}}_{{$data->acct_id}}"  id="month_7_cat_{{$enum}}_{{$data->acct_id}}"
                                                           onkeyup="saveBudget('month_7_cat_{{$enum}}_{{$data->acct_id}}','third_quarter_{{$enum}}_{{$data->acct_id}}','cat_{{$enum}}_{{$data->acct_id}}',
                                                                   'third_quarter','month_7','total_cat','third_quarter_view_{{$enum}}_{{$data->acct_id}}',
                                                                   'total_cat_view_{{$enum}}_{{$data->acct_id}}','total_third_quarter_view','month_total_7',
                                                                   'annual_total_budget_view','month_7','third_quarter','{{$budgetDetail->id}}',
                                                                   '{{$budgetDetail->fin_year_id}}','{{$data->acct_id}}','{{$budgetDetail->dept_id}}','{{$data->id}}')" value="{{$data->july}}" name="amount" placeholder="Budget Amount">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_8 cat_{{$enum}}_{{$data->acct_id}} third_quarter_{{$enum}}_{{$data->acct_id}}"  id="month_8_cat_{{$enum}}_{{$data->acct_id}}"
                                                           onkeyup="saveBudget('month_8_cat_{{$enum}}_{{$data->acct_id}}','third_quarter_{{$enum}}_{{$data->acct_id}}','cat_{{$enum}}_{{$data->acct_id}}',
                                                                   'third_quarter','month_8','total_cat','third_quarter_view_{{$enum}}_{{$data->acct_id}}',
                                                                   'total_cat_view_{{$enum}}_{{$data->acct_id}}','total_third_quarter_view','month_total_8',
                                                                   'annual_total_budget_view','month_8','third_quarter','{{$budgetDetail->id}}',
                                                                   '{{$budgetDetail->fin_year_id}}','{{$data->acct_id}}','{{$budgetDetail->dept_id}}','{{$data->id}}')" value="{{$data->august}}" name="amount" placeholder="Budget Amount">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_9 cat_{{$enum}}_{{$data->acct_id}} third_quarter_{{$enum}}_{{$data->acct_id}}"  id="month_9_cat_{{$enum}}_{{$data->acct_id}}"
                                                           onkeyup="saveBudget('month_9_cat_{{$enum}}_{{$data->acct_id}}','third_quarter_{{$enum}}_{{$data->acct_id}}','cat_{{$enum}}_{{$data->acct_id}}',
                                                                   'third_quarter','month_9','total_cat','third_quarter_view_{{$enum}}_{{$data->acct_id}}',
                                                                   'total_cat_view_{{$enum}}_{{$data->acct_id}}','total_third_quarter_view','month_total_9',
                                                                   'annual_total_budget_view','month_9','third_quarter','{{$budgetDetail->id}}',
                                                                   '{{$budgetDetail->fin_year_id}}','{{$data->acct_id}}','{{$budgetDetail->dept_id}}','{{$data->id}}')" value="{{$data->sept}}" name="amount" placeholder="Budget Amount">
                                                </div>
                                            </div>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="third_quarter " disabled id="third_quarter_view_{{$enum}}_{{$data->acct_id}}" value="{{$data->third_quarter}}" name="third_quarter" placeholder="Third Quarter Total">
                                                </div>
                                            </div>
                                        </div>

                                    </td>

                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_10 cat_{{$enum}}_{{$data->acct_id}} fourth_quarter_{{$enum}}_{{$data->acct_id}}"  id="month_10_cat_{{$enum}}_{{$data->acct_id}}"
                                                           onkeyup="saveBudget('month_10_cat_{{$enum}}_{{$data->acct_id}}','fourth_quarter_{{$enum}}_{{$data->acct_id}}','cat_{{$enum}}_{{$data->acct_id}}',
                                                                   'fourth_quarter','month_10','total_cat','fourth_quarter_view_{{$enum}}_{{$data->acct_id}}',
                                                                   'total_cat_view_{{$enum}}_{{$data->acct_id}}','total_fourth_quarter_view','month_total_10',
                                                                   'annual_total_budget_view','month_10','fourth_quarter','{{$budgetDetail->id}}',
                                                                   '{{$budgetDetail->fin_year_id}}','{{$data->acct_id}}','{{$budgetDetail->dept_id}}','{{$data->id}}')" value="{{$data->oct}}" name="amount" placeholder="Budget Amount">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_11 cat_{{$enum}}_{{$data->acct_id}} fourth_quarter_{{$enum}}_{{$data->acct_id}}"  id="month_11_cat_{{$enum}}_{{$data->acct_id}}"
                                                           onkeyup="saveBudget('month_11_cat_{{$enum}}_{{$data->acct_id}}','fourth_quarter_{{$enum}}_{{$data->acct_id}}','cat_{{$enum}}_{{$data->acct_id}}',
                                                                   'fourth_quarter','month_11','total_cat','fourth_quarter_view_{{$enum}}_{{$data->acct_id}}',
                                                                   'total_cat_view_{{$enum}}_{{$data->acct_id}}','total_fourth_quarter_view','month_total_11',
                                                                   'annual_total_budget_view','month_11','fourth_quarter','{{$budgetDetail->id}}',
                                                                   '{{$budgetDetail->fin_year_id}}','{{$data->acct_id}}','{{$budgetDetail->dept_id}}','{{$data->id}}')" value="{{$data->nov}}" name="amount" placeholder="Budget Amount">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_12 cat_{{$enum}}_{{$data->acct_id}} fourth_quarter_{{$enum}}_{{$data->acct_id}}"  id="month_12_cat_{{$enum}}_{{$data->acct_id}}"
                                                           onkeyup="saveBudget('month_12_cat_{{$enum}}_{{$data->acct_id}}','fourth_quarter_{{$enum}}_{{$data->acct_id}}','cat_{{$enum}}_{{$data->acct_id}}',
                                                                   'fourth_quarter','month_12','total_cat','fourth_quarter_view_{{$enum}}_{{$data->acct_id}}',
                                                                   'total_cat_view_{{$enum}}_{{$data->acct_id}}','total_fourth_quarter_view','month_total_12',
                                                                   'annual_total_budget_view','month_12','fourth_quarter','{{$budgetDetail->id}}',
                                                                   '{{$budgetDetail->fin_year_id}}','{{$data->acct_id}}','{{$budgetDetail->dept_id}}','{{$data->id}}')" value="{{$data->dec}}" name="amount" placeholder="Budget Amount">
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="fourth_quarter " disabled id="fourth_quarter_view_{{$enum}}_{{$data->acct_id}}" value="{{$data->fourth_quarter}}" name="fourth_quarter" placeholder="Fourth Quarter Total">
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="total_cat total_cat_{{$enum}}_{{$data->acct_id}} " disabled id="total_cat_view_{{$enum}}_{{$data->acct_id}}" value="{{$data->total_cat_amount}}" name="total_cat" placeholder="Annual Category Total">
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS) || $detectHod == \App\Helpers\Utility::HOD_DETECTOR)
                                            <a style="cursor: pointer;" onclick="deleteSingleItemWithParamBudget('remove_{{$data->id}}','{{$budgetDetail->id}}','','','<?php echo url('delete_budget_item') ?>','<?php echo csrf_token(); ?>','tr_{{$data->id}}')"> <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i></a>
                                        @endif
                                    </td>
                                    <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                                    <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
                                    <td>{{$data->created_at}}</td>
                                    <td>{{$data->created_at}}</td>
                                    <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                </tr>
                            @endforeach

                        @endif

                        @if(!empty($mainData))
                            @foreach($mainData as $data)
                                @php $enum++ @endphp
                                <tr>
                                    <td scope="row">
                                        <input value="{{$data->id}}" type="checkbox" id="" class="kid_checkbox" />

                                    </td>
                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    <td></td>
                                    <td>{{$data->category->category_name}}</td>
                                    <td>{{$data->acct_name}} ({{$data->detail->detail_type}})</td>

                                    @for($i=1;$i<=3;$i++)
                                        <td>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="number" class="month_{{$i}} cat_{{$enum}}_{{$data->id}} first_quarter_{{$enum}}_{{$data->id}}"  id="month_{{$i}}_cat_{{$enum}}_{{$data->id}}"
                                                               onkeyup="saveBudget('month_{{$i}}_cat_{{$enum}}_{{$data->id}}','first_quarter_{{$enum}}_{{$data->id}}','cat_{{$enum}}_{{$data->id}}',
                                                                       'first_quarter','month_{{$i}}','total_cat','first_quarter_view_{{$enum}}_{{$data->id}}',
                                                                       'total_cat_view_{{$enum}}_{{$data->id}}','total_first_quarter_view','month_total_{{$i}}',
                                                                       'annual_total_budget_view','month_{{$i}}','first_quarter','{{$budgetDetail->id}}',
                                                                       '{{$budgetDetail->fin_year_id}}','{{$data->id}}','{{$budgetDetail->dept_id}}','')" name="amount" placeholder="Budget Amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @endfor

                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="first_quarter" disabled id="first_quarter_view_{{$enum}}_{{$data->id}}" name="first_quarter" placeholder="First Quarter Total">
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    @for($i=4;$i<=6;$i++)
                                        <td>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="number" class="month_{{$i}} cat_{{$enum}}_{{$data->id}} second_quarter_{{$enum}}_{{$data->id}}"  id="month_{{$i}}_cat_{{$enum}}_{{$data->id}}"
                                                               onkeyup="saveBudget('month_{{$i}}_cat_{{$enum}}_{{$data->id}}','second_quarter_{{$enum}}_{{$data->id}}','cat_{{$enum}}_{{$data->id}}',
                                                                       'second_quarter','month_{{$i}}','total_cat','second_quarter_view_{{$enum}}_{{$data->id}}',
                                                                       'total_cat_view_{{$enum}}_{{$data->id}}','total_second_quarter_view','month_total_{{$i}}',
                                                                       'annual_total_budget_view','month_{{$i}}','second_quarter','{{$budgetDetail->id}}',
                                                                       '{{$budgetDetail->fin_year_id}}','{{$data->id}}','{{$budgetDetail->dept_id}}','')" name="amount" placeholder="Budget Amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @endfor

                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="second_quarter " disabled id="second_quarter_view_{{$enum}}_{{$data->id}}" name="second_quarter" placeholder="Second Quarter Total">
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    @for($i=7;$i<=9;$i++)
                                        <td>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="number" class="month_{{$i}} cat_{{$enum}}_{{$data->id}} third_quarter_{{$enum}}_{{$data->id}}"  id="month_{{$i}}_cat_{{$enum}}_{{$data->id}}"
                                                               onkeyup="saveBudget('month_{{$i}}_cat_{{$enum}}_{{$data->id}}','third_quarter_{{$enum}}_{{$data->id}}','cat_{{$enum}}_{{$data->id}}',
                                                                       'third_quarter','month_{{$i}}','total_cat','third_quarter_view_{{$enum}}_{{$data->id}}',
                                                                       'total_cat_view_{{$enum}}_{{$data->id}}','total_third_quarter_view','month_total_{{$i}}',
                                                                       'annual_total_budget_view','month_{{$i}}','third_quarter','{{$budgetDetail->id}}',
                                                                       '{{$budgetDetail->fin_year_id}}','{{$data->id}}','{{$budgetDetail->dept_id}}','')" name="amount" placeholder="Budget Amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @endfor

                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="third_quarter " disabled id="third_quarter_view_{{$enum}}_{{$data->id}}" name="third_quarter" placeholder="Third Quarter Total">
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    @for($i=10;$i<=12;$i++)
                                        <td>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="number" class="month_{{$i}} cat_{{$enum}}_{{$data->id}} fourth_quarter_{{$enum}}_{{$data->id}}"  id="month_{{$i}}_cat_{{$enum}}_{{$data->id}}"
                                                               onkeyup="saveBudget('month_{{$i}}_cat_{{$enum}}_{{$data->id}}','fourth_quarter_{{$enum}}_{{$data->id}}','cat_{{$enum}}_{{$data->id}}',
                                                                       'fourth_quarter','month_{{$i}}','total_cat','fourth_quarter_view_{{$enum}}_{{$data->id}}',
                                                                       'total_cat_view_{{$enum}}_{{$data->id}}','total_fourth_quarter_view','month_total_{{$i}}',
                                                                       'annual_total_budget_view','month_{{$i}}','fourth_quarter','{{$budgetDetail->id}}',
                                                                       '{{$budgetDetail->fin_year_id}}','{{$data->id}}','{{$budgetDetail->dept_id}}','')" name="amount" placeholder="Budget Amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @endfor

                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="fourth_quarter " disabled id="fourth_quarter_view_{{$enum}}_{{$data->id}}" name="fourth_quarter" placeholder="Fourth Quarter Total">
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="total_cat total_cat_{{$enum}}_{{$data->id}} " disabled id="total_cat_view_{{$enum}}_{{$data->id}}" name="total_cat" placeholder="Annual Category Total">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>

                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="month_total " value="{{$budget->totalJan}}" disabled id="month_total_1" name="amount" placeholder="Sum Total of Month">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="month_total " value="{{$budget->totalFeb}}" disabled id="month_total_2" name="amount" placeholder="Sum Total of Month">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="month_total " value="{{$budget->totalMarch}}" disabled id="month_total_3" name="amount" placeholder="Sum Total of Month">
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="total_first_quarter " value="{{$budget->fiQuarter}}" disabled id="total_first_quarter_view" name="total_first_quarter" placeholder="Sum Total of First Quarter">
                                            </div>
                                        </div>
                                    </div>

                                </td>

                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="month_total " value="{{$budget->totalApril}}" disabled id="month_total_4" name="amount" placeholder="Sum Total of Month">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="month_total " value="{{$budget->totalMay}}" disabled id="month_total_5" name="amount" placeholder="Sum Total of Month">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="month_total " value="{{$budget->totalJune}}" disabled id="month_total_6" name="amount" placeholder="Sum Total of Month">
                                            </div>
                                        </div>
                                    </div>
                                </td>


                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="total_second_quarter  "  value="{{$budget->sQuarter}}" disabled id="total_second_quarter_view" name="total_second_quarter" placeholder="Sum Total of Second Quarter">
                                            </div>
                                        </div>
                                    </div>

                                </td>

                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="month_total " value="{{$budget->totalJuly}}" disabled id="month_total_7" name="amount" placeholder="Sum Total of Month">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="month_total " value="{{$budget->totalAugust}}" disabled id="month_total_8" name="amount" placeholder="Sum Total of Month">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="month_total " value="{{$budget->totalSept}}" disabled id="month_total_9" name="amount" placeholder="Sum Total of Month">
                                            </div>
                                        </div>
                                    </div>
                                </td>


                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="total_third_quarter " value="{{$budget->tQuarter}}" disabled id="total_third_quarter_view" name="total_third_quarter" placeholder="Sum Total of Third Quarter">
                                            </div>
                                        </div>
                                    </div>

                                </td>

                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="month_total " value="{{$budget->totalOct}}" disabled  id="month_total_10" name="amount" placeholder="Sum Total of Month">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="month_total " value="{{$budget->totalNov}}" disabled  id="month_total_11" name="amount" placeholder="Sum Total of Month">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="month_total " value="{{$budget->totalDec}}" disabled  id="month_total_12" name="amount" placeholder="Sum Total of Month">
                                            </div>
                                        </div>
                                    </div>
                                </td>


                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="total_fourth_quarter " disabled value="{{$budget->foQuarter}}" id="total_fourth_quarter_view" name="total_fourth_quarter" placeholder="Sum Total of Fourth Quarter">
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class=" " value="{{$budget->totalBudget}}" disabled id="annual_total_budget_view" name="annual_total_budget" placeholder="Overall Annual Total Budget">
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                        @else

                            <tr>
                                <td scope="row">
                                    <input value="0" type="checkbox" id="0" class="kid_checkbox" />

                                </td>
                                <td></td>
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>Sum Total of Month and Quarterly Amount</td>
                                <td></td>

                                @for($i=1;$i<=3;$i++)
                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_total " disabled id="month_total_{{$i}}" name="amount" placeholder="Sum Total of Month">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @endfor

                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="total_first_quarter " disabled id="total_first_quarter_view" name="total_first_quarter" placeholder="Sum Total of First Quarter">
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                @for($i=4;$i<=6;$i++)
                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_total " disabled id="month_total_{{$i}}" name="amount" placeholder="Sum Total of Month">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @endfor

                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="total_second_quarter  " disabled id="total_second_quarter_view" name="total_second_quarter" placeholder="Sum Total of Second Quarter">
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                @for($i=7;$i<=9;$i++)
                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_total " disabled id="month_total_{{$i}}" name="amount" placeholder="Sum Total of Month">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @endfor

                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="total_third_quarter " disabled id="total_third_quarter_view" name="total_third_quarter" placeholder="Sum Total of Third Quarter">
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                @for($i=10;$i<=12;$i++)
                                    <td>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" class="month_total " disabled  id="month_total_{{$i}}" name="amount" placeholder="Sum Total of Month">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @endfor

                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="total_fourth_quarter " disabled id="total_fourth_quarter_view" name="total_fourth_quarter" placeholder="Sum Total of Fourth Quarter">
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class=" " disabled id="annual_total_budget_view" name="annual_total_budget" placeholder="Overall Annual Total Budget">
                                            </div>
                                        </div>
                                    </div>

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

    <!-- #END# Bordered Table -->

    <script>
        /*==================== PAGINATION =========================*/

        function saveBudget(thisInputId,quarterClass,totalCatClass,totalQuarterClass,monthClass,totalSumCatClass,quarterViewId,totalCatViewId,totalQuarterViewId,monthTotalSumId,totalSumViewId,realMonth,realQuarter,budgetId,finYear,acctId,deptId,dbDataId){

            replaceInputWithClassArraySum(quarterClass,quarterViewId);
            replaceInputWithClassArraySum(totalCatClass,totalCatViewId);
            replaceInputWithClassArraySum(totalQuarterClass,totalQuarterViewId);
            replaceInputWithClassArraySum(monthClass,monthTotalSumId);
            replaceInputWithClassArraySum(totalSumCatClass,totalSumViewId);

            var thisInput = getId(thisInputId).val(); var quarter = getId(quarterViewId).val();
            var totalCat = getId(totalCatViewId).val();
            var postVars = 'monthCatAmount='+thisInput+'&quarterAmount='+quarter+'&totalCatAmount='+totalCat+'&dbDataId='+dbDataId+'&monthName='+realMonth+'&quarterName='+realQuarter+'&finYear='+finYear+'&budget='+budgetId+'&deptId='+deptId+'&accountId='+acctId

            sendRequestForm("{{url('create_modify_budget_item_account_chart')}}",CSRF_TOKEN,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {

                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if(message2 == 'fail'){

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error",messageError, "error");

                    }else if(message2 == 'saved'){

                        var successMessage = swalSuccess('Data saved successfully');
                        //swal("Success!", "Data saved successfully!", "success");

                    }else if(message2 == 'token_mismatch'){

                        location.reload();

                    }else {
                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");
                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

                }
            }

        }

        function changeAccount(inputId,budgetId,finYear,requestCat,deptId,dbDataId){

            var getInput = getId(inputId).val();
            var postVars = 'dbDataId='+dbDataId+'&accountId='+getInput+'&finYear='+finYear+'&budget='+budgetId+'&requestCat='+requestCat+'&deptId='+deptId

            sendRequestForm("{{url('create_modify_budget_account')}}",CSRF_TOKEN,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {

                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if(message2 == 'fail'){

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error",messageError, "error");

                    }else if(message2 == 'saved'){

                        var successMessage = swalSuccess('Data saved successfully');
                        //swal("Success!", "Data saved successfully!", "success");

                    }else if(message2 == 'token_mismatch'){

                        location.reload();

                    }else {
                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");
                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

                }
            }


        }

        function deleteSingleItemWithParamBudget(dataHtmlId,param,reloadId,reloadUrl,submitUrl,token,divDataIdOnModalForRemoval) {

            swal({
                        title: "Are you sure you want to delete?",
                        text: "You will not be able to recover this data entry!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel delete!",
                        closeOnConfirm: true,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            deleteSingleEntryWithParamBudget(dataHtmlId, param, reloadId, reloadUrl, submitUrl, token,divDataIdOnModalForRemoval);


                            //swal("Deleted!", "Your item(s) has been deleted.", "success");
                        } else {
                            swal("Delete Cancelled", "Your data is safe :)", "error");
                        }
                    });

        }


        function deleteSingleEntryWithParamBudget(dataHtmlId,param,reloadId,reloadUrl,submitUrl,token,divDataIdOnModalForRemoval){
            var dataVal = $('#'+dataHtmlId).val();
            var postVars = "dataId="+dataVal+"&param="+param;
            $('#loading_modal').modal('show');
            sendRequestForm(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {
                    $('#loading_modal').modal('hide');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if(message2 == 'fail'){

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalDefaultError(serverError);
                        swal("Error",messageError, "error");

                    }else if(message2 == 'deleted'){

                        var successMessage = swalSuccess(rollback.message);
                        swal("Success!", successMessage, "success");

                        if(divDataIdOnModalForRemoval != ''){
                            $('#'+divDataIdOnModalForRemoval).remove();

                            for(var i = 1; i<=12;i++){
                                replaceInputWithClassArraySum('month_'+i,'month_total_'+i);

                            }

                            replaceInputWithClassArraySum('first_quarter','total_first_quarter');
                            replaceInputWithClassArraySum('second_quarter','total_second_quarter');
                            replaceInputWithClassArraySum('third_quarter','total_third_quarter');
                            replaceInputWithClassArraySum('fourth_quarter','total_fourth_quarter');
                            replaceInputWithClassArraySum('total_cat','annual_total_budget_view');

                        }

                    }else{

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    if(reloadUrl != '') {
                        reloadContent(reloadId, reloadUrl);
                    }
                }
            }


        }
    </script>

    <script>

        /*$('table').on('scroll', function () {
         $("table > *").width($("table").width() + $("table").scrollLeft());
         });*/

        /*$(function() {
         $( ".datepicker" ).datepicker({
         /!*changeMonth: true,
         changeYear: true*!/
         });
         });*/
    </script>

@endsection

