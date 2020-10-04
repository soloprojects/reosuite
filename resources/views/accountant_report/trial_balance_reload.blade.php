

<table class="table table-bordered table-hover table-striped" id="main_table">
        <thead>
        <tr>
            <th></th>
            <th style="text-align: center; font-weight:bold;">
                {{Utility::companyInfo()->name}}<br/>
                TRIAL BALANCE REPORT <br/>
                {{$from}} - {{$to}}
            </th>
            <th></th>
        </tr> 
        
        <tr><th></th><th></th><th></th></tr>  

        <tr>
    
            <th>Account</th>
            <th>Total DEBIT {{Utility::defaultCurrency()}}</th>
            <th>Total CREDIT {{Utility::defaultCurrency()}}</th>
        </tr>
        </thead>
        <tbody>
        <tr style="font-weight:bold;">
            <td>Asset Accounts</td>
            <td></td>
         </tr>
        @foreach($assets as $data)
            <tr>
                <td>{{$data->acct_name}}</td>
                <td>{{$data->reportBal}}</td>
                <td></td>
            </tr>
        @endforeach
            <tr style="font-weight:bold;">
                <td>Total Assets</td>
                <td>{{$assets->totalBal}}</td>
                <td></td>
            </tr>
            <tr><td></td><td></td><td></td></tr>

        
        <tr style="font-weight:bold;">
            <td>Other Debit Accounts</td>
            <td></td>
        </tr>
        @foreach($otherDebitAccounts as $data)
        <tr>
            <td>{{$data->acct_name}}</td>
            <td>{{$data->reportBal}}</td>
            <td></td>
        </tr>
        @endforeach
        <tr style="font-weight:bold;">
            <td>Total </td>
            <td>{{$otherDebitAccounts->totalBal}}</td>
            <td></td>
        </tr>
        <tr><td></td><td></td><td></td></tr>    

        <!-- DEBIT ACCOUNTS ENDS HERE -->

        <!-- CREDIT ACCOUNTS BEGINS HERE -->

        <tr style="font-weight:bold;">
            <td>Liability Accounts</td>
            <td></td>
            <td></td>
         </tr>
        @foreach($liability as $data)
            <tr>
                <td>{{$data->acct_name}}</td>
                <td></td>
                <td>{{$data->reportBal}}</td>
            </tr>
        @endforeach
        <tr style="font-weight:bold;">
            <td>Total Liability</td>
            <td></td>
            <td>{{$liability->totalBal}}</td>
        </tr>
        <tr><td></td><td></td><td></td></tr>


        <tr style="font-weight:bold;">
            <td>Equity Accounts</td>
            <td></td>
            <td></td>
        </tr>
        @foreach($equity as $data)
        <tr>
            <td>{{$data->acct_name}}</td>
            <td></td>
            <td>{{$data->reportBal}}</td>
        </tr>
        @endforeach
        <tr style="font-weight:bold;">
            <td>Total Equity</td>
            <td></td>
            <td>{{$equity->totalBal}}</td>
        </tr>
        <tr><td></td><td></td><td></td></tr>


        <tr style="font-weight:bold;">
            <td>Other Credit Accounts</td>
            <td></td>
            <td></td>
            </tr>
        @foreach($otherCreditAccounts as $data)
            <tr>
                <td>{{$data->acct_name}}</td>
                <td></td>
                <td>{{$data->reportBal}}</td>
            </tr>
        @endforeach
            <tr style="font-weight:bold;">
                <td>Total </td>
                <td></td>
                <td>{{$otherCreditAccounts->totalBal}}</td>
            </tr>
            <tr><td></td><td></td><td></td></tr>  

            
        <tr style="font-weight:bold;">
            <td>Total Debits and Credits</td>
            <td>{{$debitSideSum}}</td>
            <td>{{$creditSideSum}}</td>
        </tr>        

        </tbody>
</table>

