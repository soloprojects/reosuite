
<div class="row clear-fix">
    @if(count($mainData) >0)
        Sum of Net Salary Under Process : {{\App\Helpers\Utility::defaultCurrency()}} {{Utility::numberFormat($salarySum)}}
    @endif
</div>

<table class="table table-bordered table-hover table-striped tbl_order" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_payroll');" id="parent_check_payroll"
                   name="check_all_payroll" class="" />

        </th>

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
    @foreach($mainData as $data)
        @php $monthName = date("F", mktime(0, 0, 0, $data->month,10)); @endphp
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="payroll_{{$data->id}}" class="kid_checkbox_payroll" />

            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->userDetail->firstname}}&nbsp;{{$data->userDetail->lastname}} </td>
            <td>{{$data->salary->salary_name}}</td>
            <td>{{Utility::numberFormat($data->total_amount)}}</td>
            <td> {{Utility::numberFormat($data->bonus_deduc)}}</td>
            <td>{{$data->bonus_deduc_desc}}</td>
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
            <td>
            <!--<a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_position_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>-->
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>

<script>
    $('.tbl_order').on('scroll', function () {
        $(".tbl_order > *").width($(".tbl_order").width() + $(".tbl_order").scrollLeft());
    });
</script>
