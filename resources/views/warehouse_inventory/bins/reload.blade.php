

<div class=" table-responsive" id="reload_data_bin">

<table class="table table-bordered table-hover table-striped" id="main_table_bin">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_bin');" id="parent_check__bin"
                   name="check_all" class="" />

        </th>
        <th>View Inventory</th>
        <th>Zone</th>
        <th>Bin</th>
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
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox_bin" />

            </td>
            <td>
                <a style="cursor: pointer;" onclick="fetchHtml3('{{$data->bin_id}}','{{$zoneId}}','binContent','binContentModal','<?php echo url('warehouse_inventory_bin_content') ?>','<?php echo csrf_token(); ?>','{{$warehouseId}}')"><i class="fa fa-eye fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

            <td>{{$data->zone->name}}</td>
            <td>{{$data->bin->code}}</td>
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