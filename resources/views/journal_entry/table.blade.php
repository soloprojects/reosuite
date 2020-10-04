

<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>File Number</th>
        <th>Transaction Type</th>
        <th>Payer/Receiver</th>
        <th>Post Date</th>
        <th>Status</th>
        <th>Sum Total {{\App\Helpers\Utility::defaultCurrency()}}</th>
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
            <td>
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_journal_entry_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>
                @if(!empty($data->file_no))
                {{$data->file_no}}
                @else
                {{$data->id}}
                @endif
            </td>
            <td>{{Finance::transType($data->transaction_type)}}</td>
            <td>
                @if(!empty($data->contact_type))
                {{$data->vendorCon->name}}
                @else
                {{$data->employee->fistname}} {{$data->employee->lastname}}
                @endif
            </td>
            <td>{{$data->post_date}}</td>
            <td>{{$data->dataStatus->name}}</td>
            <td>{{Utility::numberFormat($data->trans_total)}}</td>
            <td>{{$data->user_c->firstname}} &nbsp;{{$data->user_c->lastname}} </td>
            <td>{{$data->user_u->firstname}} &nbsp;{{$data->user_u->lastname}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>