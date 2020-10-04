<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-6">
                <div class="form-group">
                    <b>Session Name</b>
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->session_name}}" name="session_name" placeholder="Session Name">
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-6">
                <div class="form-group">
                    <b>Visibility to Internal Participants</b>
                    <div class="form-line">
                        <select  class="form-control" name="internal_participant" >
                            <option value="{{$edit->user_status}}" selected>{{\App\Helpers\Utility::sessionStatusDisplay($edit->user_status)}}</option>
                            <option value="2">Invisible to Internal Participants</option>
                            <option value="1">Visible to Internal Participants</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <b>Visibility to External Participants</b>
                    <div class="form-line">
                        <select  class="form-control" name="external_participant" >
                            <option value="{{$edit->temp_user_status}}" selected>{{\App\Helpers\Utility::sessionStatusDisplay($edit->temp_user_status)}}</option>
                            <option value="2">Invisible to External Participants</option>
                            <option value="1">Visible to External Participants</option>
                        </select>
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