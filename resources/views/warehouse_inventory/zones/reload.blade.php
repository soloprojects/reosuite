

<div class=" table-responsive" id="reload_data_zone">

<table class="table table-bordered table-hover table-striped" id="main_table_zone">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_zone');" id="parent_check_zone"
                   name="check_all" class="" />

        </th>
        <th>View Bin(s)</th>
        <th>Warehouse</th>
        <th>Zone</th>
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
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox_zone" />

            </td>

            <td>
                <a style="cursor: pointer;" onclick="fetchHtml2('{{$data->zone_id}}','manageBin','manageBinModal','<?php echo url('warehouse_inventory_bin') ?>','<?php echo csrf_token(); ?>','{{$warehouseId}}')"><i class="fa fa-eye fa-2x"></i></a>
            </td>

            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

            <td>{{$data->warehouse->name}} ({{$data->warehouse->code}})</td>
            <td>{{$data->zone->name}}</td>
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
</table>

</div>

