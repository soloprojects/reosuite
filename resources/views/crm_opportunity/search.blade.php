<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Pipeline</th>
        <th>Lead</th>
        <th>Opportunity</th>
        <th>Sales Cycle</th>
        <th>Stage/Phase</th>
        <th>Status</th>
        <th>Lost Reason</th>
        <th>Probability (%)</th>
        <th>Amount ({{\App\Helpers\Utility::defaultCurrency()}})</th>
        <th>Closing Date</th>
        <th>Expected Revenue ({{\App\Helpers\Utility::defaultCurrency()}})</th>
        <th>Sales Team</th>
        <th>Created by</th>
        <th>Created at</th>
        <th>Updated by</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)

        @php
            $salesTeamUserIds = json_decode($data->sales->users);
        @endphp
        @if(in_array(Auth::user()->id,$salesTeamUserIds) || $data->created_by == Auth::user()->id || in_array(Auth::user()->id,\App\Helpers\Utility::TOP_USERS))
            <tr>
                <td scope="row">
                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                </td>
                <td>
                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_crm_opportunity_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                </td>
                <td>
                    <a href="<?php echo url('crm_opportunity/id/'.$data->id) ?>">Pipeline Activities/Notes</a>
                </td>

                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                <td>{{$data->lead->name}}</td>
                <td>{{$data->opportunity_name}}</td>
                <td>{{$data->salesCycle->name}}</td>
                <td>{{$data->phase->name}} (Stage{{$data->phase->stage}})</td>
                <td style="color:black;" class="{{\App\Helpers\Utility::opportunityStatusIndicator($data->opportunity_status)}}">{{\App\Helpers\Utility::opportunityStatus($data->opportunity_status)}}</td>
                <td>{{$data->lost_reason}}</td>
                <td>{{$data->phase->probability}}</td>
                <td>{{Utility::numberFormat($data->amount)}}</td>
                <td>{{$data->closing_date}}</td>
                <td>{{Utility::numberFormat($data->expected_revenue)}}</td>
                <td>{{$data->sales->name}}</td>
                <td>
                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                </td>
                <td>{{$data->created_at}}</td>
                <td>
                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                </td>
                <td>{{$data->updated_at}}</td>


                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

            </tr>
        @else
        @endif
    @endforeach
    </tbody>
</table>

