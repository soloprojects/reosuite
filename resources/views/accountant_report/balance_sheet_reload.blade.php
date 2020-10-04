

<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>

        <tr>
            
            <th style="text-align: center; font-weight:bold;">
                {{Utility::companyInfo()->name}}<br/>
                BALANCE SHEET REPORT <br/>
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
            <td>Asset Accounts</td>
            <td></td>
         </tr>
        @foreach($assets as $data)
            <tr>
                <td>{{$data->acct_name}}</td>
                <td>{{$data->reportBal}}</td>
            </tr>
        @endforeach
            <tr style="font-weight:bold;">
                <td>Total Assets</td>
                <td>{{$assets->totalBal}}</td>
            </tr>
            <tr><td></td><td></td></tr>


        <tr style="font-weight:bold;">
            <td>Liability Accounts</td>
            <td></td>
         </tr>
        @foreach($liability as $data)
            <tr>
                <td>{{$data->acct_name}}</td>
                <td>{{$data->reportBal}}</td>
            </tr>
        @endforeach
            <tr style="font-weight:bold;">
                <td>Total Liability</td>
                <td>{{$liability->totalBal}}</td>
            </tr>
            <tr><td></td><td></td></tr>


            <tr style="font-weight:bold;">
                <td>Equity Accounts</td>
                <td></td>
            </tr>
            @foreach($equity as $data)
            <tr>
                <td>{{$data->acct_name}}</td>
                <td>{{$data->reportBal}}</td>
            </tr>
            @endforeach
                <tr style="font-weight:bold;">
                    <td>Total Equity</td>
                    <td>{{$equity->totalBal}}</td>
                </tr>

        </tbody>
</table>
