<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">

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

            <div class="col-sm-4">
                <b>Mileage Before ({{\App\Helpers\Utility::odometerMeasure()->name}})</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->start_mileage}}" id="" name="mileage_before" placeholder="Mileage Before" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Mileage After ({{\App\Helpers\Utility::odometerMeasure()->name}})</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" id="" class="form-control" value="{{$edit->end_mileage}}" id="" name="mileage_after" placeholder="Mileage After">
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Log Date*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->log_date}}" name="log_date" placeholder="Log Date" required>
                    </div>
                </div>
            </div>
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-12">
                <b>Comment</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="comment" placeholder="Comment" >{{$edit->comment}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <hr/>

    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
        $( ".datepicker1" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
            /*yearRange: "-90:+00"*/

        });
    });
</script>

