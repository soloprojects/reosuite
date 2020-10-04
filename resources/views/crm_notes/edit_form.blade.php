<form name="" id="editNotesMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">

        <div class="row clearfix">
            <div class="col-sm-12">
                <b>Details</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="details" placeholder="Details">{{$edit->details}}</textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
    <input type="hidden" name="opportunity_stage" id="note_stage_edit" value="{{$edit->stage_id}}" >
    <input type="hidden" name="opportunity" value="{{$edit->opportunity_id}}" >
</form>