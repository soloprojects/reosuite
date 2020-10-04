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
                                    <td>{{$data->acctCat->category_name}}</td>
                                    <td>{{$data->account->acct_name}} ({{$data->acctDetail->detail_type}})</td>

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

