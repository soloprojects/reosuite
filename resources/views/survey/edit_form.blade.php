<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-6">
                <b>Survey Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->survey_name}}" name="survey_name" placeholder="Survey Name">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <b>Survey Details</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="survey_details" placeholder="Survey Details">{{$edit->survey_desc}}</textarea>
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
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>