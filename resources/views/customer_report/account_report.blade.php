

    <table class="table table-bordered table-hover table-striped" id="main_table">
        <thead>

            <tr>
                
                <th style="text-align: center; font-weight:bold;">
                    {{Utility::companyInfo()->name}}<br/>
                    ACCOUNT REPORT <br/>
                    {{$from}} - {{$to}}
                </th>
                <th></th>
            </tr>
        </thead>
    </table>

    <table class="table table-bordered table-hover table-striped" id="main_table">
        <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                        name="check_all" class="" />

            </th>
            <th>View Register</th>
            <th>Account Name</th>
            <th>Account Category</th>
            <th>Transaction Type</th>
            <th>Debit {{\App\Helpers\Utility::defaultCurrency()}}</th>
            <th>Credit {{\App\Helpers\Utility::defaultCurrency()}}</th>
            <th>Post Date</th>
            <th>Created by</th>
            <th>Created at</th>
            <th>Updated by</th>
            <th>Updated at</th>

        </tr>
        </thead>
        <tbody>
        @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>                                   
            <td>
                <a href="account_register/{{$data->chart_id}}"><i class="fa fa-newspaper-o fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->chartData->acct_name}} ({{$data->chartData->acct_no}})</td>
            <td>{{$data->category->category_name}}</td>
            <td>{{Finance::transType($data->transaction_type)}}</td>
            <td>
                @if($data->debit_credit == Utility::DEBIT_TABLE_ID)
                {{Utility::numberFormat($data->trans_total)}}
                @endif
            </td>
            <td>
                @if($data->debit_credit == Utility::CREDIT_TABLE_ID)
                {{Utility::numberFormat($data->trans_total)}}
                @endif
            </td>
            <td>{{$data->post_date}}</td>
            <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
            <td>{{$data->updated_at}}</td>


            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
        </tr>
        @endforeach

        </tbody>
    </table>

    <div class="row">
        <div class="col-md-4 pull-right"></div>
        <div class="col-md-4 pull-right" style="font-weight: bold;">Total Balance {{\App\Helpers\Utility::defaultCurrency()}} :  {{Utility::roundNum($mainData->totalBal)}}</div>
        <div class="col-md-4 pull-right"></div>
    </div>
