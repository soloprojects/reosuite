<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker_edit" value="{{$edit->closing_date}}" name="closing_date" placeholder="Closing Date">
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
    <input type="hidden" name="prev_password" value="{{$edit->password}}" >
</form>

<script>
    $(function() {
        $( ".datepicker_edit" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>