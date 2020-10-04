<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">

        <div class="row clear-fix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control"  disabled >
                            <option value="{{$edit->leave_type}}" selected>{{$edit->leaveType->leave_type}}</option>
                            @foreach($leaveType as $ap)
                                <option value="{{$ap->id}}">{{$ap->leave_type}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->start_date}}" class="form-control datepickerEdit" name="start_date" placeholder="Start Date">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->end_date}}" class="form-control datepickerEdit" name="end_date" placeholder="End Date">
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="leave_type" value="{{$edit->leave_type}}" >
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