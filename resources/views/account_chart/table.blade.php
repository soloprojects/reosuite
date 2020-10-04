
<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>View Register</th>
        <th>Account Number</th>
        <th>Account Name</th>
        <th>Account Category</th>
        <th>Detail Type</th>
        <th>Virtual Balance {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Bank Balance {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Original Cost {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Foreign Account Balance </th>
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
            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_account_chart_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
        </td>
        <td>
            <a href="account_register/{{$data->id}}"><i class="fa fa-newspaper-o fa-2x"></i></a>
        </td>
        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
        <td>{{$data->acct_no}}</td>
        <td>{{$data->acct_name}}</td>
        <td>{{$data->category->category_name}}</td>
        <td>{{$data->detail->detail_type}}</td>
        <td>
            @if(in_array($data->acct_cat_id,\App\Helpers\Utility::BALANCE_SHEET_ACCOUNTS))
            {{Utility::numberFormat($data->virtual_balance_trans)}}
            @endif
        </td>
        <td>{{Utility::numberFormat($data->bank_balance)}}</td>
        <td>{{Utility::numberFormat($data->original_cost)}}
        <td>
            @if(in_array($data->acct_cat_id,\App\Helpers\Utility::BALANCE_SHEET_ACCOUNTS))
            ({{$data->chartCurr->code}}){{$data->chartCurr->symbol}} {{Utility::numberFormat($data->virtual_balance)}}
            @endif
        </td>
        <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
        <td>{{$data->created_at}}</td>
        <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
        <td>{{$data->updated_at}}</td>


        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
    </tr>
    @endforeach
    </tbody>
</table>