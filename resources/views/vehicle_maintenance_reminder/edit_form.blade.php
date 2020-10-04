<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-6">
                <b>Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->name}}" name="name" placeholder="Name">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <b>Notification Interval(days)</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->interval}}" name="Interval" id="" placeholder="interval" required>
                    </div>
                </div>
            </div>
        </div><hr/>

        <div class="row clearfix">
            <div class="col-sm-6">
                <b>Notification Date*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->last_reminder}}" name="notification_date" placeholder="Notification Date" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <b>Mileage Interval ({{\App\Helpers\Utility::odometerMeasure()->name}})</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->mileage}}" name="mileage" id="" placeholder="Mileage" required>
                    </div>
                </div>
            </div>
        </div><hr/>

        @if(!empty($edit->services))
            @foreach($edit->services as $service)
                <div class="row clearfix" id="remove_service{{$service->id}}">
                    <div class="col-sm-8" id="">
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control service_class_edit" name="service_type"  required>
                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                    @foreach($serviceType as $data)
                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <button type="button" onclick="deleteSingleItemWithParam('{{$edit->id}}','{{$service->id}}','reload_data','<?php echo url('vehicle_maintenance_reminder'); ?>',
                                '<?php echo url('remove_vehicle_maintenance_reminder_service'); ?>','<?php echo csrf_token(); ?>','remove_service{{$service->id}}');" class="btn btn-danger">
                            <i class="fa fa-trash-o"></i>Delete
                        </button>
                    </div>

                </div>
            @endforeach
        @endif

        <div class="row clearfix">
            <div class="col-sm-4" id="hide_button_edit">

                <div class="form-group">
                    <div onclick="addMoreEditable('add_more_edit','hide_button_edit','400','<?php echo URL::to('add_more'); ?>','multiple_services','hide_button_edit','service_class_edit');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>Add more service Types to maintenance reminder
                    </div>
                </div>
            </div>
        </div>

        <div class="" id="add_more_edit">

        </div>

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