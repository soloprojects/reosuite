<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Loan Name</th>
        <th>Interest Rate(%)</th>
        <th>Duration(months)</th>
        <th>Description</th>
        <th>Manage</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            @if($data->loan_status == 1)
                <td class="alert-success" style="color:white;">{{$data->loan_name}}</td>
                <td class="alert-success" style="color:white;">{{$data->interest_rate}}%</td>
                <td class="alert-success" style="color:white;">{{$data->duration}}</td>
                <td class="alert-success" style="color:white;">{{$data->loan_desc}}</td>
            @else
                <td>{{$data->loan_name}}</td>
                <td>{{$data->interest_rate}}%</td>
                <td>{{$data->duration}}</td>
                <td>{{$data->loan_desc}}</td>
        @endif
        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>
                @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_loan_rate_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>