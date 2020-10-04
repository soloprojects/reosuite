<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Attachment</th>
        <th>Vehicle</th>
        <th>Fuel Station</th>
        <th>Purchase Price {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Driver</th>
        <th>Price Per Liter {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>liter</th>
        <th>Mileage ({{\App\Helpers\Utility::odometerMeasure()->name}})</th>
        <th>Purchase Date</th>
        <th>Comment</th>
        <th>Invoice Reference</th>
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
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_vehicle_fuel_log_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <td>
                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_vehicle_fuel_log_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->vehicle_make}} {{$data->vehicle_model}} ({{$data->vehicleDetail->license_plate}})</td>
            <td>{{$data->fuel->name}}</td>
            <td>{{Utility::numberFormat($data->total_price)}}</td>
            <td>{{$data->driver->firstname}} &nbsp; {{$data->driver->lastname}}</td>
            <td>{{Utility::numberFormat($data->price_per_liter)}}</td>
            <td>{{Utility::numberFormat($data->liter)}}</td>
            <td>{{Utility::numberFormat($data->mileage)}}</td>
            <td>{{$data->purchase_date}}</td>
            <td>{{$data->comment}}</td>
            <td>{{$data->invoice_reference}}</td>
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

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>