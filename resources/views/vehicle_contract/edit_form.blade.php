<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">

        <div class="row clearfix">
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
            <div class="col-sm-4">
                <b>Contract Title*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->name}}" name="title" placeholder="Contract Title" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Contract Type*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="contract_type"  required>
                            <option value="{{$edit->contract_type}}">{{$edit->contract->name}}</option>
                            @foreach($contractType as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Recurring Cost {{\App\Helpers\Utility::defaultCurrency()}}</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->recurring_cost}}" name="recurring_cost" placeholder="Recurring Cost" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>activation cost*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->activation_cost}}" name="activation_cost" placeholder="Activation Cost" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Mileage({{\App\Helpers\Utility::odometerMeasure()->name}}) before contract</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->mileage_start}}" id="" name="mileage_before_contract" placeholder="Mileage before contract" >
                    </div>
                </div>
            </div>
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Mileage({{\App\Helpers\Utility::odometerMeasure()->name}}) after contract</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->mileage_end}}" id="" name="mileage_after_contract" placeholder="Mileage after contract">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Start Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->start_date}}" name="start_date" id="" placeholder="start_date" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>End Date*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->end_date}}" name="end_date" placeholder="End Date" required>
                    </div>
                </div>
            </div>
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Vehicle Status*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="contract_status"  required>
                            <option value="{{$edit->contract_status}}">{{$edit->StatusType->name}}</option>
                            @foreach($contractStatus as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Recurring Interval(days)</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->recurring_interval}}" name="recurring_interval" id="" placeholder="recurring_interval" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Invoice Date*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->invoice_date}}" name="invoice_date" placeholder="invoice_date" required>
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Contractor*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->contractor}}" name="contractor" placeholder="Contractor" required>
                    </div>
                </div>
            </div>

        </div>

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

