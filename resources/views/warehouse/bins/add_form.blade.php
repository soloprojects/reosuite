<form name="addBinMainForm" id="addBinMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">
        <h3>{{$edit->name}}</h3><hr>
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Bin</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control zone_bin" name="bin" >
                            <option value="">Select</option>
                            @foreach($bin as $type)
                                <option value="{{$type->id}}">{{$type->code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4" id="hide_button_bin">
                <div class="form-group">
                    <div onclick="addMore('add_more_bin','hide_button_bin','1','<?php echo URL::to('add_more'); ?>','zone_bin','hide_button_bin');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

        </div>

        <div id="add_more_bin"></div>

    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
    <input type="hidden" value="{{$warehouseId}}" name="warehouse" />

    </div>

</form><br>

<button type="button"  onclick="saveMethod('addBinModal','addBinMainForm','<?php echo url('create_warehouse_bin'); ?>','manageBin',
        '<?php echo url('warehouse_bin'); ?>','<?php echo csrf_token(); ?>','zone_bin','{{$edit->id}}')"
        class="btn btn-info waves-effect pull-right">
    SAVE
</button>