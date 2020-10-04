
@if($type == 'default_search')
@foreach($optionArray as $data)

<li>
    <a  onclick="dropdownItem('{{$searchId}}','{{$data->firstname}} {{$data->lastname}}','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->firstname}} &nbsp; {{$data->lastname}}({{$data->email}})</a>
</li>

@endforeach
@endif

@if($type == 'default_search_temp')
    @foreach($optionArray as $data)

        <li>
            <a  onclick="dropdownItem('{{$searchId}}','{{$data->firstname}} {{$data->lastname}}','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->firstname}} &nbsp; {{$data->lastname}}({{$data->email}})</a>
        </li>

    @endforeach
@endif

@if($type == 'default_search_temp_dept')
    @foreach($optionArray as $data)

        <li>
            <a  onclick="dropdownItem('{{$searchId}}','{{$data->firstname}} {{$data->lastname}}','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->firstname}} &nbsp; {{$data->lastname}}({{$data->email}})</a>
        </li>

    @endforeach
@endif

@if($type == 'default_search_temp_param')
    @foreach($optionArray as $data)

        <li>
            <a  onclick="dropdownItem('{{$searchId}}','{{$data->extUser->firstname}} {{$data->extUser->lastname}}','{{$hiddenId}}','{{$data->temp_user}}','{{$listId}}');">{{$data->extUser->firstname}} &nbsp; {{$data->extUser->lastname}} ({{$data->extUser->email}})</a>
        </li>

    @endforeach
@endif

@if($type == 'default_search_temp_param_check')
    @foreach($optionArray as $data)

        <li>
            <a  onclick="dropdownItemRepParam('{{$searchId}}','{{$data->extUser->firstname}} {{$data->extUser->lastname}}','{{$hiddenId}}','{{$data->temp_user}}','{{$listId}}','{{$newInputId}}','{{$moduleType2}}','{{$newInputPage}}','{{$projectId}}');">{{$data->extUser->firstname}} &nbsp; {{$data->extUser->lastname}} ({{$data->extUser->email}})</a>
        </li>

    @endforeach
@endif

@if($type == 'fetch_user_temp_tasks')

    <select name="task"  class="form-control " id=""  >
        @if(count($optionArray) > 0)
            <option value="">Select Task</option>
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->task}}</option>
            @endforeach

        @else
            <option value="">No Task found</option>
        @endif
    </select>
@endif

@if($type == 'default_search_param')
    @foreach($optionArray as $data)

        <li>
            <a  onclick="dropdownItem('{{$searchId}}','{{$data->member->firstname}} {{$data->member->lastname}}','{{$hiddenId}}','{{$data->user_id}}','{{$listId}}');">{{$data->member->firstname}} &nbsp; {{$data->member->lastname}} ({{$data->member->email}})</a>
        </li>

    @endforeach
@endif

@if($type == 'default_search_param_check')
    @foreach($optionArray as $data)

        <li>
            <a  onclick="dropdownItemRepParam('{{$searchId}}','{{$data->member->firstname}} {{$data->member->lastname}}','{{$hiddenId}}','{{$data->user_id}}','{{$listId}}','{{$newInputId}}','{{$moduleType2}}','{{$newInputPage}}','{{$projectId}}');">{{$data->member->firstname}} &nbsp; {{$data->member->lastname}} ({{$data->member->email}})</a>
        </li>

    @endforeach
@endif

@if($type == 'fetch_user_tasks')

    <select name="task"  class="form-control " id=""  >
        @if(count($optionArray) > 0)
            <option value="">Select Task</option>
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->task}}</option>
            @endforeach

        @else
            <option value="">No Task found</option>
        @endif
    </select>
@endif


@if($type == 'warehouse_employee')
    @foreach($optionArray as $data)

        <li>
            <a  onclick="dropdownItem('{{$searchId}}','{{$data->access_user->firstname}} {{$data->access_user->lastname}}','{{$hiddenId}}','{{$data->access_user->id}}','{{$listId}}');">{{$data->access_user->firstname}} &nbsp; {{$data->access_user->lastname}} ({{$data->warehouse->name}})</a>
        </li>

    @endforeach
@endif


@if($type == 'search_vendor' || $type == 'search_customer')
    @foreach($optionArray as $data)

        <li>
            <a   onclick="dropdownItem('{{$searchId}}','{{$data->name}} ({{$data->email1}})','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->name}} ({{$data->email1}})</a>
        </li>

    @endforeach
@endif

@if($type == 'search_vendor_transact' || $type == 'search_customer_transact')
    @foreach($optionArray as $data)

        <li>
            <a  onclick="dropdownItemTransact('{{$searchId}}','{{$data->name}} ({{$data->email1}})','{{$hiddenId}}','{{$data->id}}','{{$listId}}','{{$overallSumId}}','<?php echo url('vendor_customer_currency') ?>','{{$currencyClass}}','{{$vendorCustId}}','{{$postDateId}}','<?php echo url('amount_to_default_curr') ?>','{{$billAddress}}','{{$currRate}}','{{$foreignOverallSum}}');">{{$data->name}} ({{$data->email1}})</a>
        </li>

    @endforeach
@endif

@if($type == 'search_inventory')
    @foreach($optionArray as $data)

        <li>
            <a  onclick="dropdownItem('{{$searchId}}','{{$data->item_name}}','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->item_name}}</a>
        </li>

    @endforeach
@endif

@if($type == 'search_inventory_transact')
    @foreach($optionArray as $data)

        <li>
            <a  onclick="dropdownItemInv('{{$searchId}}','{{$data->item_name}}','{{$hiddenId}}','{{$data->id}}','{{$listId}}','{{$billInvoice}}','<?php echo url('inventory_details') ?>','{{$descId}}','{{$rateId}}','{{$unitMId}}','{{$subTotalId}}','{{$sharedSubTotal}}','{{$overallSum}}','{{$foreignOverallSum}}','<?php echo url('amount_to_default_curr') ?>','{{$qtyId}}','{{$vendCustId}}','{{$postDateId}}','{{$totalTaxId}}');">{{$data->item_name}}</a>
        </li>

    @endforeach
@endif

@if($type == 'search_accounts')
    @foreach($optionArray as $data)

        <li>
            <a  onclick="dropdownItem('{{$searchId}}','{{ $data->acct_name.' ('.$data->acct_no.')' }}','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{ $data->acct_name.' ('.$data->acct_no.')' }}</a>
        </li>

    @endforeach
@endif

@if($type == 'reconcile_accounts')
    @foreach($optionArray as $data)

        <li>
            <a  onclick="dropdownItemRepParam2('{{$searchId}}','{{ $data->acct_name.' ('.$data->acct_no.')' }}','{{$hiddenId}}','{{$data->id}}','{{$listId}}','begining_balance','','<?php echo url('fetch_begining_balance') ?>','{{$searchId}}');">{{ $data->acct_name.' ('.$data->acct_no.')' }}</a>
        </li>

    @endforeach
@endif



@if($type == 'search_comp_cat')

        <select name="competency_category"  class="form-control" id="ccompetency_cat"  >
            @if(count($optionArray) > 0)
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->category_name}}</option>
            @endforeach

            @else
                <option value="">Competency Category</option>
            @endif
        </select>
@endif

@if($type == 'dept_users')
    @if(count($optionArray) > 0)
        <select name="user"  class="form-control" id=""  >
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->firstname}}&nbsp;{{$data->lastname}}</option>
            @endforeach
        </select>
    @else
        <select name="user"  class="form-control" id=""  >
        <option value="">No User found</option>
        </select>
    @endif
@endif

@if($type == 'core_behav_comp')

        <select name="element"  class="form-control element element_edit" id=""  >
            @if(count($optionArray) > 0)
            @foreach($optionArray as $data)
                <option value="{{$data->item_desc}}">{{$data->item_desc}}</option>
            @endforeach

            @else
                <option value="">Element of Behavioural Competency</option>
            @endif
        </select>
@endif

@if($type == 'core_tech_comp')

        <select name="capable"  class="form-control capable capable_edit" id=""  >
            @if(count($optionArray) > 0)
            @foreach($optionArray as $data)
                <option value="{{$data->item_desc}}">{{$data->item_desc}}</option>
            @endforeach

            @else
                <option value="">Capabilities</option>
            @endif
        </select>
@endif

@if($type == 'dept_frame_tech')

    <select name="competency_category"  class="form-control competency_cat_tech competency_cat_tech_edit" id="ccompetency_cat"  >
        @if(count($optionArray) > 0)
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->category_name}}</option>
            @endforeach

        @else
            <option value="">Competency Category</option>
        @endif
    </select>
@endif

@if($type == 'dept_frame_behav')

    <select name="competency_category"  class="form-control competency_cat" id="ccompetency_cat"  >
        @if(count($optionArray) > 0)
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->category_name}}</option>
            @endforeach

        @else
            <option value="">Competency Category</option>
        @endif
    </select>
@endif

@if($type == 'account_chart')

    <select name="detail_type"  class="form-control " id=""  >
        @if(count($optionArray) > 0)
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->detail_type}}</option>
            @endforeach

        @else
            <option value="">Detail Type</option>
        @endif
    </select>
@endif

@if($type == 'w_zones')

    <select name="zone"  class="form-control " id="zone_id" onchange="fillNextInputParamGetVal('zone_id','bin_id','<?php echo url('default_select'); ?>','z_bins','{{$warehouseId}}')" >
        @if(count($optionArray) > 0)
            <option value="">Select</option>
            @foreach($optionArray as $data)
                <option value="{{$data->zone_id}}">{{$data->zone->name}}</option>
            @endforeach

        @else
            <option value="">No Zones found</option>
        @endif
    </select>
@endif

@if($type == 'z_bins')

    <select name="bin"  class="form-control " id=""  >
        @if(count($optionArray) > 0)
            <option value="">Select</option>
            @foreach($optionArray as $data)
                <option value="{{$data->bin_id}}">{{$data->bin->code}}</option>
            @endforeach

        @else
            <option value="">No Bins found</option>
        @endif
    </select>
@endif

@if($type == 'z_bins_param')

    <select name="bin{{$param}}"  class=" " id=""  >
        @if(count($optionArray) > 0)
            <option value="">Select</option>
            @foreach($optionArray as $data)
                <option value="{{$data->bin_id}}">{{$data->bin->code}}</option>
            @endforeach

        @else
            <option value="">No Bins found</option>
        @endif
    </select>
@endif

@if($type == 'w_zones_search')

    <select name="zone"  class="form-control " id="zone_id_search" onchange="fillNextInputParamGetVal('zone_id_search','bin_id_search','<?php echo url('default_select'); ?>','z_bins','{{$warehouseId}}')" >
        @if(count($optionArray) > 0)
            <option value="">Select</option>
            @foreach($optionArray as $data)
                <option value="{{$data->zone_id}}">{{$data->zone->name}}</option>
            @endforeach

        @else
            <option value="">No Zones found</option>
        @endif
    </select>
@endif


@if($type == 'search_rfq_select')
    @foreach($optionArray as $data)

        <li>
            <a href="#" onclick="dropdownItem('{{$searchId}}','{{$data->rfq_no}}','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->rfq_no}}</a>
        </li>

    @endforeach
@endif

@if($type == 'search_po_select')
    @foreach($optionArray as $data)

        <li>
            <a href="#" onclick="dropdownItem('{{$searchId}}','{{$data->po_number}}','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->po_number}}</a>
        </li>

    @endforeach
@endif

@if($type == 'search_quote_select')
    @foreach($optionArray as $data)

        <li>
            <a href="#" onclick="dropdownItem('{{$searchId}}','{{$data->quote_number}} ({{$data->vendorCon->name}})','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->quote_number}} ({{$data->vendorCon->name}})</a>
        </li>

    @endforeach
@endif

@if($type == 'search_sales_select')
    @foreach($optionArray as $data)

        <li>
            <a href="#" onclick="dropdownItem('{{$searchId}}','{{$data->sales_number}} ({{$data->vendorCon->name}})','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->sales_number}} ({{$data->vendorCon->name}})</a>
        </li>

    @endforeach
@endif

@if($type == 'survey_dept')

    <select name="department"  class="form-control " id=""  >
        @if(count($optionArray) > 0)
            <option value="">Select Department</option>
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->dept_name}}</option>
            @endforeach

        @else
            <option value="">No Department found</option>
        @endif
    </select>
@endif

@if($type == 'test_cat')

    <select name="test_category"  class="form-control " id=""  >
        @if(count($optionArray) > 0)
            <option value="">Select Test Category</option>
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->category_name}}</option>
            @endforeach

        @else
            <option value="">No Test Category found</option>
        @endif
    </select>
@endif

@if($type == 'search_crm_lead')
    @foreach($optionArray as $data)

        <li>
            <a   onclick="dropdownItem('{{$searchId}}','{{$data->name}} ({{$data->email1}})','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->name}} ({{$data->email1}})</a>
        </li>

    @endforeach
@endif

@if($type == 'crm_stage_search')
    @foreach($optionArray as $data)

        <li>
            <a  onclick="dropdownItem('{{$searchId}}','{{$data->name}}','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->name}}</a>
        </li>

    @endforeach
@endif

@if($type == 'get_crm_stages')
    <select class="form-control" name="opportunity_stage" id="stage" onchange="getRevenue('amount','stage','revenue','{{url('fetch_crm_possibility')}}');" >
        <option value="">Select Opportunity Stage</option>
        @foreach($optionArray as $d)
            <option value="{{$d->id}}">{{$d->name}}(Stage {{$d->stage}})</option>
        @endforeach
    </select>
@endif

@if($type == 'fetch_vehicle_model')

    <select name="model"  class="form-control " id=""  >
        @if(count($optionArray) > 0)
            <option value="">Select Vehicle Model</option>
            @foreach($optionArray as $data)
                <option value="{{$data->id}}">{{$data->model_name}}</option>
            @endforeach

        @else
            <option value="">No Vehicle Model Found</option>
        @endif
    </select>
@endif

@if($type == 'search_vehicle')
    @foreach($optionArray as $data)

        <li>
            <a  onclick="dropdownItem('{{$searchId}}','{{$data->make->make_name}} {{$data->model->model_name}} ({{$data->license_plate}})','{{$hiddenId}}','{{$data->id}}','{{$listId}}');">{{$data->make->make_name}} {{$data->model->model_name}} ({{$data->license_plate}})</a>
        </li>

    @endforeach
@endif


