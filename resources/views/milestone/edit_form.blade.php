<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control " value="{{$edit->milestone_name}}" name="milestone_title" placeholder="Task List title">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control " name="milestone_desc" placeholder="Milestone Details">{{$edit->milestone_desc}}</textarea>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" autocomplete="off" value="{{$edit->start_date}}" name="milestone_start_date" placeholder="Milestone Start Date">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" autocomplete="off" value="{{$edit->end_date}}" name="milestone_end_date" placeholder="Milestone End Date">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control milestone_status" name="milestone_status" >

                            @foreach(\App\Helpers\Utility::TASK_STATUS as $key => $task)
                                @if($edit->milestone_status == $key)
                                    <option selected value="{{$key}}">{{$task}}</option>
                                @endif
                                <option value="{{$key}}">{{$task}}</option>
                            @endforeach
                        </select>
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
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
            /*yearRange: "-90:+00"*/

        });
    });
</script>