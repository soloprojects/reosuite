<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Manage</th>
        <th>Attachment</th>
        <th>Make</th>
        <th>Model</th>
        <th>Category</th>
        <th>Driver</th>
        <th>License Plate</th>
        <th>Model Year</th>
        <th>Mileage ({{\App\Helpers\Utility::odometerMeasure()->name}})</th>
        <th>Transmission</th>
        <th>Fuel Type</th>
        <th>Registration Date</th>
        <th>Registration Due Date</th>
        <th>Purchase Price {{\App\Helpers\Utility::defaultCurrency()}}</th>
        <th>Seat Number</th>
        <th>Doors</th>
        <th>Chasis Number</th>
        <th>Colour</th>
        <th>Horse Power</th>
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
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_vehicle_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <td>
                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_vehicle_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->make->make_name}}</td>
            <td>{{$data->model->model_name}}</td>
            <td>{{$data->category->name}}</td>
            <td>{{$data->driver->firstname}} &nbsp; {{$data->driver->lastname}}</td>
            <td>{{$data->license_plate}}</td>
            <td>{{$data->model_year}}</td>
            <td>{{$data->mileage}}</td>
            <td>{{$data->transmission}}</td>
            <td>{{$data->fuel_type}}</td>
            <td>{{$data->registration_date}}</td>
            <td>{{$data->registration_due_date}}</td>
            <td>{{number_format($data->purchase_price)}}</td>
            <td>{{$data->seat_number}}</td>
            <td>{{$data->doors}}</td>
            <td>{{$data->chasis_no}}</td>
            <td>{{$data->colour}}</td>
            <td>{{$data->horsepower}}</td>
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