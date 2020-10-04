<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Manage</th>
        <th>Manage Warehouse/Stock Items</th>
        <th>Item No</th>
        <th>Item Name</th>
        <th>Unit Cost</th>
        <th>Unit Price</th>
        <th>Quantity</th>
        <th>Inventory Category</th>
        <th>Inventory Type</th>
        <th>Photo</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
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
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_inventory_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>

            <td>
                @if($data->whse_status == 1)
                    <a style="cursor: pointer;" onclick="newWindow('{{$data->id}}','manageWhse','<?php echo url('warehouse_item_inventory') ?>','<?php echo csrf_token(); ?>','manageWhseModal')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                @else
                    <a style="cursor: pointer;" onclick="newWindow('{{$data->id}}','manageStock','<?php echo url('stock_inventory') ?>','<?php echo csrf_token(); ?>','manageStockModal')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                @endif
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

            <td>
                @if($data->active_status == 1)
                    {{$data->item_no}}
                @else
                    <span class="alert-warning">{{$data->item_no}}</span>
                @endif
            </td>
            <td>
                @if($data->active_status == 1)
                    {{$data->item_name}}&nbsp;
                @else
                    <span class="alert-warning">{{$data->item_name}}</span>
                @endif
            </td>
            <td>{{Utility::numberFormat($data->unit_cost)}}</td>
            <td>{{Utility::numberFormat($data->unit_price)}}</td>
            <td>{{$data->qty}}</td>
            <td>{{$data->category->category_name}}</td>
            <td>{{$data->inv_type->name}}</td>
            <td><img src="{{ asset('images/'.$data->photo) }}" width="72" height="60" alt="Logo" /></td>
            <td>
                @if($data->created_by != '0')
                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                @endif
            </td>
            <td>
                @if($data->updated_by != '0')
                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                @endif
            </td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table><div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>


