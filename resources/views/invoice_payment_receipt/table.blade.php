
<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>File/Ref Number</th>
        <th>Customer</th>
        <th>Post Date</th>
        <th>Status</th>
        <th>Sum Total {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Sum Total</th>
        <th>Open Balance {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Open Balance</th>
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
                @if(!empty($data->file_no))
                {{$data->file_no}}
                @else
                {{$data->id}}
                @endif
            </td>
            <td>
                {{$data->vendorCon->name}}
            </td>
            <td>{{$data->post_date}}</td>
            <td>{{$data->dataStatus->name}}</td>
            <td>{{Utility::numberFormat($data->trans_total)}}</td>
            <td>({{$data->currency->code}}){{$data->currency->symbol}}&nbsp;{{Utility::numberFormat($data->sum_total)}}</td>
            <td>{{Utility::numberFormat($data->balance_trans)}}</td>
            <td>({{$data->currency->code}}){{$data->currency->symbol}}&nbsp;{{Utility::numberFormat($data->balance)}}</td>
            <td>{{$data->user_c->firstname}} &nbsp;{{$data->user_c->lastname}} </td>
            <td>{{$data->user_u->firstname}} &nbsp;{{$data->user_u->lastname}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>