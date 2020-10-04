<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>
        <th>View Zones</th>
        <th>Name</th>
        <th>Code</th>
        <th>Address</th>
        <th>Country</th>
        <th>Contact</th>
        <th>Contact Phone</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <td>
                <a style="cursor: pointer;" onclick="newWindow('{{$data->id}}','manageZone','<?php echo url('warehouse_inventory_zone') ?>','<?php echo csrf_token(); ?>','manageZoneModal')"><i class="fa fa-eye fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

            <td>{{$data->name}}</td>
            <td>{{$data->code}}</td>
            <td>{{$data->address}}</td>
            <td>{{$data->country}}</td>
            <td>{{$data->contact}}</td>
            <td>{{$data->phone}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>