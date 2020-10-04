

<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>

        <tr>
            
            <th style="text-align: center; font-weight:bold;">
                {{Utility::companyInfo()->name}}<br/>
                Income Statement (Profit AND Loss) REPORT <br/>
                {{$from}} - {{$to}}
            </th>
            <th></th>
        </tr> 
        
        <tr><th></th><th></th><th></th></tr>  

        <tr>
    
            <th>Account</th>
            <th>Total {{Utility::defaultCurrency()}}</th>
        </tr>
        </thead>
        <tbody>
        <tr style="font-weight:bold;">
            <td>Income</td>
            <td></td>
         </tr>
        @foreach($income as $data)
            <tr>
                <td>{{$data->acct_name}}</td>
                <td>{{$data->reportBal}}</td>
            </tr>
        @endforeach
            <tr style="font-weight:bold;">
                <td>Total Income</td>
                <td>{{$income->totalBal}}</td>
            </tr>
            <tr><td></td><td></td></tr>


        <tr style="font-weight:bold;">
            <td>Cost of Goods Sold Accounts</td>
            <td></td>
         </tr>
        @foreach($COG as $data)
            <tr>
                <td>{{$data->acct_name}}</td>
                <td>{{$data->reportBal}}</td>
            </tr>
        @endforeach
            <tr style="font-weight:bold;">
                <td>Total Cost of Goods Sold</td>
                <td>{{$COG->totalBal}}</td>
            </tr>
            <tr><td></td><td></td></tr>

            <tr style="font-weight:bold;">
                <td>Gross Profit</td>
                <td>{{$grossProfit}}</td>
            </tr>
            <tr><td></td><td></td></tr>


            <tr style="font-weight:bold;">
                <td>Expenses</td>
                <td></td>
            </tr>
            @foreach($expenses as $data)
            <tr>
                <td>{{$data->acct_name}}</td>
                <td>{{$data->reportBal}}</td>
            </tr>
            @endforeach
            <tr style="font-weight:bold;">
                <td>Total Expenses</td>
                <td>{{$expenses->totalBal}}</td>
            </tr>
            <tr><td></td><td></td></tr>

            <tr style="font-weight:bold;">
                <td>Net Operating Income</td>
                <td>{{$netOperatingIncome}}</td>
            </tr>
            <tr><td></td><td></td></tr>


            <tr style="font-weight:bold;">
                <td>Other Expenses</td>
                <td></td>
            </tr>
            @foreach($otherExpenses as $data)
            <tr>
                <td>{{$data->acct_name}}</td>
                <td>{{$data->reportBal}}</td>
            </tr>
            @endforeach
            <tr style="font-weight:bold;">
                <td>Total Other Expenses</td>
                <td>{{$otherExpenses->totalBal}}</td>
            </tr>
            <tr><td></td><td></td></tr>


            <tr style="font-weight:bold;">
                <td>Other Income</td>
                <td></td>
            </tr>
            @foreach($otherIncome as $data)
            <tr>
                <td>{{$data->acct_name}}</td>
                <td>{{$data->reportBal}}</td>
            </tr>
            @endforeach
            <tr style="font-weight:bold;">
                <td>Total Other Income</td>
                <td>{{$otherIncome->totalBal}}</td>
            </tr>
            <tr><td></td><td></td></tr>

            <tr style="font-weight:bold;">
                <td>Net Other Income</td>
                <td>{{$netOtherIncome}}</td>
            </tr>
            <tr><td></td><td></td></tr>

            <tr style="font-weight:bold;">
                <td>Net Income</td>
                <td>{{$netIncome}}</td>
            </tr>
            <tr><td></td><td></td></tr>

        </tbody>
</table>
