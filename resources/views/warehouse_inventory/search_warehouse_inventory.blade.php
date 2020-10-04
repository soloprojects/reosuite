
@if($mainData->count() > 0)
<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>Inventory Item</th>
        <th>Warehouse</th>
        <th>Zone</th>
        <th>Bin</th>
        <th>Quantity</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

            <td>{{$data->item->item_name}} ({{$data->item->item_no}})</td>
            <td>{{$data->warehouse->name}} ({{$data->warehouse->code}})</td>
            <td>{{$data->zone->name}}</td>
            <td>{{$data->bin->code}}</td>
            <td>{{$data->qty}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>

@else

<h3>No inventory items found</h3>

@endif


