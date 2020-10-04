

<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Redo</th>
        <th>View</th>
        <th>Account</th>
        <th>Ending Date</th>
        <th>Begining Balance</th>
        <th>Ending Balance</th>
        <th>Cleared Balance {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Difference</th>
        <th>Changes</th>
        <th>Created by</th>
        <th>Updated by</th>

    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
                       
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>
                <a href="redo_bank_reconciliation/{{$data->id}}"><i class="fa fa-refresh fa-4" aria-hidden="true"></i></a>
            </td>
            <td>
                <a href="bank_reconciliation_report/{{$data->id}}"><i class="fa fa-eye fa-4" aria-hidden="true"></i></a>
            </td>
            <td>{{$data->account->acct_name}} ({{$data->account->acct_no}})</td>
            <td>{{$data->ending_date}}</td>
            <td>{{Utility::numberFormat($data->begining_balance)}}</td>
            <td>{{Utility::numberFormat($data->ending_balance)}}</td>
            <td>{{Utility::numberFormat($data->cleared_balance)}}</td>
            <td>{{Utility::numberFormat($data->difference)}}</td>
            <td>{{Utility::numberFormat($data->balanceChanges)}}</td>
            <td>{{$data->user_c->firstname}} &nbsp;{{$data->user_c->lastname}} </td>
            <td>{{$data->user_u->firstname}} &nbsp;{{$data->user_u->lastname}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>