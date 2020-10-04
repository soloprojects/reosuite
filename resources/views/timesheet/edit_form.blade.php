<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Task</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->taskName->task}}" name="timesheet_title" disabled>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Timesheet Title</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->timesheet_title}}" name="timesheet_title" placeholder="Timesheet title">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Timesheet Details</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="timesheet_details" placeholder="Timesheet Details">{{$edit->timesheet_desc}}</textarea>
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">

            <div class="col-sm-4">
                <b>Work Hours</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" value="{{$edit->work_hours}}" class="form-control" name="work_hours" placeholder="Number of Work Hours ">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Work Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->work_date}}" class="form-control datepicker1" autocomplete="off" name="work_date" placeholder="Work Date">
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
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>