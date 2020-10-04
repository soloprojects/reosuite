<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Warehouse</th>
        <th>Inventory Item</th>
        <th>Item Desc</th>
        <th>Quantity</th>
        <th>Quantity to receive</th>
        <th>Quantity to Cross-Dock</th>
        <th>Quantity Received</th>
        <th>Quantity Outstanding</th>
        <th>Unit of Measurement</th>
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
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_warehouse_receipt_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->warehouse->name}}</td>
            <td>{{$data->inventory->item_name}}</td>
            <td>{{$data->poItem->po_desc}}</td>
            <td>{{$data->qty}}</td>
            <td>{{$data->qty_to_receive}}</td>
            <td>{{$data->qty_to_cross_dock}}</td>
            <td>{{$data->qty_received}}</td>
            <td>{{$data->qty_outstanding}}</td>
            <td>{{$data->unit_measurement}}</td>
            <td>
                @if($data->created_by != '0')
                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                @endif
            </td>
            <td>{{$data->created_at}}</td>
            <td>
                @if($data->updated_by != '0')
                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                @endif
            </td>
            <td>{{$data->updated_at}}</td>


            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>
