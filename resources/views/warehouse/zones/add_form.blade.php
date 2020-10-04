<form name="addZoneMainForm" id="addZoneMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">
        <h3>{{$edit->name}} ({{$edit->code}})</h3><hr>
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Zone</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control warehouse_zone" name="zone" >
                            <option value="">Select</option>
                            @foreach($zone as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4" id="hide_button_zone">
                <div class="form-group">
                    <div onclick="addMore('add_more_zone','hide_button_zone','1','<?php echo URL::to('add_more'); ?>','warehouse_zone','hide_button_zone');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

        </div>
        <div id="add_more_zone"></div>

    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >

    </div>

</form><br>

<button type="button"  onclick="saveMethod('addZoneModal','addZoneMainForm','<?php echo url('create_warehouse_zone'); ?>','manageZone',
        '<?php echo url('warehouse_zone'); ?>','<?php echo csrf_token(); ?>','warehouse_zone','{{$edit->id}}')"
        class="btn btn-info waves-effect pull-right">
    SAVE
</button>