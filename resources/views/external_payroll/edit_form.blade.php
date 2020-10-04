@extends('layouts.letter_head_internal')

@section('content')

<table class="table table-bordered table-hover table-striped" id="">
    <tbody>
    <tr>
        <td>Employee Name</td><td>{{Auth::user()->title}} {{Auth::user()->firstname}} {{Auth::user()->lastname}}</td>
    </tr>
    <tr>
        <td>Department</td><td>{{$edit->department->dept_name}}</td>
    </tr>
    <tr>
        <td>Position</td><td>{{$edit->position->position_name}}</td>
    </tr>
    <tr>
        <td>Salary Structure</td><td>{{$edit->salary->salary_name}}</td>
    </tr>
    @php $monthName = date("F", mktime(0, 0, 0, $edit->month,10)); @endphp
    <tr>
        <td> Payment Period </td>
        <td>
            @if(!empty($edit->week))
                @php $decodeWeek = json_decode($edit->week,true); $weeks = implode(',',$decodeWeek); @endphp
                {{$weeks}}/
            @else

            @endif

            {{$monthName}}/{{$edit->pay_year}}
        </td>
    </tr>

    </tbody>
</table>

<?php $payRoll = json_decode($edit->salary->component,true); ?>
<table class="table table-bordered table-hover table-striped" id="">
    <tbody>
    <tr>

      <td>
          @if($payRoll != '')
              Allowances/Earnings
              <table class="table table-bordered table-hover">
                  <thead>
                  <th>Component</th>
                  <th>Amount</th>
                  </thead>
                  <tbody>
                  @foreach($payRoll as $comp)
                      @if($comp['component_type'] == \App\Helpers\Utility::COMPONENT_TYPE[1])
                      <tr>
                          <td>{{$comp['component']}}</td>
                          <td>{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($comp['amount'])}}</td>
                      </tr>
                      @endif
                  @endforeach
                        @if($edit->bonus_deduc_type == \App\Helpers\Utility::PAYROLL_BONUS)
                            <tr>
                                <td>{{$edit->bonus_deduc_desc}}</td>
                                <td>{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($edit->bonus_deduc)}}</td>
                            </tr>
                        @endif


                  </tbody>
              </table>
          @endif
      </td>

        <td>
            @if($payRoll != '')
                Deductions
                <table class="table table-bordered table-hover">
                    <thead>
                    <th>Component</th>
                    <th>Amount</th>
                    </thead>
                    <tbody>
                    @foreach($payRoll as $comp)
                        @if($comp['component_type'] == \App\Helpers\Utility::COMPONENT_TYPE[2])
                            <tr>
                                <td>{{$comp['component']}}</td>
                                <td>{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($comp['amount'])}}</td>
                            </tr>
                        @endif
                    @endforeach
                    @if($edit->bonus_deduc_type == \App\Helpers\Utility::PAYROLL_DEDUCTION)
                        <tr>
                            <td>{{$edit->bonus_deduc_desc}}</td>
                            <td>{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($edit->bonus_deduc)}}</td>
                        </tr>
                    @endif
                    @if(!empty($edit->sal_adv_deduct) || $edit->sal_adv_deduct != 0)
                        <tr>
                            <td>Salary Advance Deduction</td>
                            <td>{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($edit->sal_adv_deduct)}}</td>
                        </tr>
                    @endif
                    @if(!empty($edit->loan_deduct)  || $edit->loan_deduct != 0)
                        <tr>
                            <td>Loan Deduction</td>
                            <td>{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($edit->loan_deduct)}}</td>
                        </tr>
                    @endif
                    <tr>
                        <td>PAYE</td>
                        <td>{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($taxAmount)}}</td>
                    </tr>

                    </tbody>
                </table>
            @endif
        </td>
    </tr>
    </tbody>
</table>

<table class="table table-bordered table-hover">
    <tbody>
    <tr>
        <td>Gross Salary</td>
        <td style="font-size:15px;">{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($edit->gross_pay)}}</td>
    </tr>
    <tr>
        <td>Total Deductions</td>
        <td style="font-size:15px;">{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($totalDeduction)}}</td>
    </tr>
    <tr>
        <td>Net Salary</td>
        <td style="font-size:15px;">{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($edit->total_amount)}}</td>
    </tr>
    </tbody>
</table>

</div>


@endsection