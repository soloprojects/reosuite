<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-12">
                <b>Maintenance Reminder</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control " name="reminder"  required>
                            <option value="{{$edit->reminder_id}}">{{$edit->reminder->name}}</option>
                            @foreach($maintenanceReminder as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT) || \App\Helpers\Utility::moduleAccessCheck('vehicle_fleet_access'))
                <div class="col-sm-4">
                    <b>Vehicle*</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{$edit->vehicleDetail->license_plate}}" autocomplete="off" id="select_vehicle_edit" onkeyup="searchOptionList('select_vehicle_edit','myUL1_edit','{{url('default_select')}}','search_vehicle','vehicle_edit');" name="select_vehicle" placeholder="Select Vehicle">

                            <input type="hidden" value="{{$edit->vehicle_id}}" class="vehicle_class" name="vehicle" id="vehicle_edit" />
                        </div>
                    </div>
                    <ul id="myUL1_edit" class="myUL"></ul>
                </div>
            @else

                <div class="col-sm-4">
                    <b>Vehicle*</b>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control" name="vehicle"  required>
                                <option value="{{$edit->vehicle_id}}">{{$edit->vehicleDetail->license_plate}}</option>
                                @foreach(\App\Helpers\Utility::driverVehicles() as $data)
                                    <option value="{{$data->id}}">{{$data->make->make_name}} {{$data->model->model_name}} ({{$data->license_plate}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            @endif
            <div class="col-sm-6">
                <b>Current Mileage ({{\App\Helpers\Utility::odometerMeasure()->name}})</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->mileage}}" name="mileage" id="" placeholder="Mileage" required>
                    </div>
                </div>
            </div>
        </div><hr/>


    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
        $( ".datepicker1" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>