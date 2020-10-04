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
                <b>Fuel Station*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="fuel_station"  required>
                            <option value="{{$edit->fuel_station}}">{{$edit->fuel->name}}</option>
                            @foreach($fuelStation as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Mileage ({{\App\Helpers\Utility::odometerMeasure()->name}})</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->mileage}}" name="mileage" placeholder="Mileage" >
                    </div>
                </div>
            </div>
        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Invoice Reference*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->invoice_reference}}" name="invoice_reference" placeholder="Invoice Reference" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Price Per Liter</b>{{\App\Helpers\Utility::defaultCurrency()}}
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->price_per_liter}}" id="price_per_liter_edit" onkeyup="totalPrice('liter_edit','price_per_liter_edit','liter_price_edit')" name="price_per_liter" placeholder="Price Per Liter" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Liter</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" id="liter_edit" class="form-control" value="{{$edit->liter}}" onkeyup="totalPrice('liter_edit','price_per_liter_edit','liter_price_edit')" id="liter" name="liter" placeholder="Liter">
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Total Price</b> {{\App\Helpers\Utility::defaultCurrency()}}
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->total_price}}" name="total_price" id="liter_price_edit" placeholder="total Price" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Purchase Date*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->purchase_date}}" name="purchase_date" placeholder="Purchase Date" required>
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

