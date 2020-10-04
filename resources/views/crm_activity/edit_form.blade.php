<form name="" id="editActivityMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-6">
                <b>Subject</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->subject}}" class="form-control" name="subject" placeholder="Subject">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <b>Activity Type</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="activity_type" >
                            <option value="{{$edit->activity_type}}">{{$edit->type->name}}</option>
                            @foreach($activityType as $d)
                                <option value="{{$d->id}}">{{$d->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-6">
                <b>Due Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->due_date}}" class="form-control datepicker2" name="due_date" placeholder="Due Date">
                    </div>
                </div>
            </div>
        </div>

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
    <input type="hidden" name="opportunity_stage" id="activity_stage_edit" value="{{$edit->stage_id}}" >
    <input type="hidden" name="opportunity" value="{{$edit->opportunity_id}}" >
</form>

<script>
    $(function() {
        $( ".datepicker2" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
            /*yearRange: "-90:+00"*/

        });
    });
</script>