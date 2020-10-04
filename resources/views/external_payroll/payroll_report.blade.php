@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="payrollModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Payslip</h4>
                    @include('includes/print_pdf',[$exportId = 'reload_data', $exportDocId = 'reload_data'])

                </div>
                <div class="modal-body" id="payroll_content" style="overflow:scroll; height:400px; ">

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>


<!-- Bordered Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Payroll Report
                </h2>
                <ul class="header-dropdown m-r--5">
                    <!--<li>
                        <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                    </li>-->

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


            <form name="payrollForm" id="payrollForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="body">
                        <div class="row clearfix">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control" name="month" >
                                            <option value="">Select Month</option>
                                            @foreach(\App\Helpers\Utility::PAY_INTERVAL as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control" name="year" >
                                            <option value="">Select Year</option>
                                            @for($i=date('Y');$i>=1970;$i--)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row clearfix">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control" name="payroll_status" >
                                            <option value="">All</option>
                                            <option value="0">Processing</option>
                                            <option value="1">Paid</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4" id="" style="">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select  class="form-control show-tick" name="department" data-selected-text-format="count">
                                            <option value="">All Department</option>
                                            @foreach($department as $ap)
                                                <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="button" onclick="searchPayroll('payrollForm','<?php echo url('search_external_payroll'); ?>','reload_data',
                                    '','<?php echo csrf_token(); ?>')" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Search Payroll
                            </button>

                        </div>
                    </div>
                </form>


            <div class="body table-responsive tbl_scroll" id="reload_data">

                <table class="table table-bordered table-hover table-striped" id="main_table">
                    <thead>
                    <tr>
                        <th>
                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                   name="check_all" class="" />

                        </th>

                        <th>View</th>
                        <th>User</th>
                        <th>Salary</th>
                        <th>Total/Net Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
                        <th>Bonus/Deduction {{\App\Helpers\Utility::defaultCurrency()}}</th>
                        <th>Bonus/Deduction Desc</th>
                        <th>Payroll Status</th>
                        <th>Pay Week(s)</th>
                        <th>Pay Month</th>
                        <th>Pay Year</th>
                        <th>Process Date</th>
                        <th>Pay Date</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>

        </div>

    </div>
</div>


    <script>

        function searchPayroll(formId,submitUrl,reload_id,reloadUrl,token){

            var inputVars = $('#'+formId).serialize();

                var postVars = inputVars;
                $('#loading_modal').modal('show');
                sendRequestForm(submitUrl,token,postVars)
                ajax.onreadystatechange = function(){
                    if(ajax.readyState == 4 && ajax.status == 200) {

                        $('#loading_modal').modal('hide');
                        var result = ajax.responseText;
                        $('#'+reload_id).html(result);

                        //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

                    }
                }


        }

    </script>

@endsection



