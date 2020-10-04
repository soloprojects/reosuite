<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    @php
    $startDatetimeToArray = explode(' ',$edit->start_event);
    $endDatetimeToArray = explode(' ',$edit->end_event);
    @endphp
    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <b>Start Date</b>
                    <div class="form-line">
                        <input type="text" value="{{$startDatetimeToArray[0]}}" class="form-control datepicker1" name="start_date" placeholder="Start Date">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <b>Start Time</b>
                    <div class="form-line">
                        <input type="text" value="{{$startDatetimeToArray[1]}}" class="form-control timepicker" name="start_time" placeholder="Start Time">
                    </div>
                </div>
            </div>
        </div><hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <b>End Date</b>
                    <div class="form-line">
                        <input type="text" value="{{$endDatetimeToArray[0]}}" class="form-control datepicker1" name="end_date" placeholder="end Date">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <b>End Time</b>
                    <div class="form-line">
                        <input type="text" value="{{$endDatetimeToArray[1]}}" class="form-control timepicker" name="end_time" placeholder="end Time">
                    </div>
                </div>
            </div>
        </div><hr/>

        <div class="row clearfix">
            <div class="col-sm-8">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->event_title}}" name="event_title" placeholder="Event Title">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="schedule_type" >
                            <option value="{{$edit->event_type}}">{{\App\Helpers\Utility::eventType($edit->event_type)}}</option>
                            @foreach(\App\Helpers\Utility::EVENT_TYPE as $key => $var)
                                <option value="{{$key}}">{{$var}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" id="edit_details" class="form-control " name="details" placeholder="Details">{{$edit->event_desc}}</textarea>
                        <script>
                            CKEDITOR.replace('edit_details');
                        </script>
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
            changeMonth: true,
             changeYear: true,
            dateFormat: "yy-mm-dd"
            /*yearRange: "-90:+00"*/

        });
    });
</script>