<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-4">
                <b>Test Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->test_name}}" name="test_name" placeholder="Test Name">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Test Details</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="test_details" placeholder="Test Details">{{$edit->test_desc}}</textarea>
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