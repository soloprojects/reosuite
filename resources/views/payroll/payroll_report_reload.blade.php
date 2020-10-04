
<div id="main_table">
<table class="table table-bordered table-hover table-striped" id="main_table1">
    <thead>
    <tr>
        <th>Total Gross Amount  {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Total/Net Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Total Extra Earnings/Deductions/(Total) {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Total Payroll Tax  {{\App\Helpers\Utility::defaultCurrency()}}</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{Utility::numberFormat($totalGross)}}</td>
            <td>{{Utility::numberFormat($totalNet)}}</td>
            <td>{{Utility::numberFormat($earnings)}} / {{Utility::numberFormat($deductions)}} / ({{Utility::numberFormat($earningDeductions)}})</td>
            <td>{{Utility::numberFormat($totalTax)}}</td>
            
        </tr>

    </tbody>
    
</table>    

<table class="table table-bordered table-hover table-striped" id="main_table2">
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
        <th>Type</th>
        <th>Salary Advance Deduction</th>
        <th>Loan Deduction</th>
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
    @foreach($mainData as $data)
        @php $monthName = date("F", mktime(0, 0, 0, $data->month,10)); @endphp
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <td>
                @if($data->payroll_status == 1)
                    <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','payroll_content','payrollModal','<?php echo url('payslip_item') ?>','<?php echo csrf_token(); ?>')">View</a>
                @endif
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->userDetail->firstname}}&nbsp;{{$data->userDetail->lastname}} </td>
            <td>{{$data->salary->salary_name}}</td>
            <td>&nbsp;{{Utility::numberFormat($data->total_amount)}}</td>
            <td>{{Utility::numberFormat($data->bonus_deduc)}}</td>
            <td>{{$data->bonus_deduc_desc}}</td>
            <td>
                @if($data->bonus_deduc_type == \App\Helpers\Utility::PAYROLL_BONUS)
                    Extra Earning
                @elseif($data->bonus_deduc_type == \App\Helpers\Utility::PAYROLL_DEDUCTION)
                    Deduction
                @else
                    None
                @endif
            </td>
            <td>
                @if($data->salary_adv_deduct > 0)
                    {{Utility::numberFormat($data->salary_adv_deduct)}}                    
                @else
                    0.00
                @endif
            </td>
            <td>
                @if($data->loan_deduct > 0)
                    {{Utility::numberFormat($data->loan_deduct)}}                    
                @else
                    0.00
                @endif
            </td>
            <td>
                @if($data->payroll_status == \App\Helpers\Utility::PROCESSING)
                    Processing
                @else
                    Paid
                @endif
            </td>
            <td>
                @if(!empty($data->week))
                    @php $decodeWeek = json_decode($data->week,true); $weeks = implode(',',$decodeWeek); @endphp
                    {{$weeks}}
                @else

                @endif
            </td>
            <td>{{$monthName}}</td>
            <td>{{$data->pay_year}}</td>
            <td>{{$data->process_date}}</td>
            <td>{{$data->pay_date}}</td>
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


