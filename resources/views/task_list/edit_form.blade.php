<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control " value="{{$edit->list_name}}" name="list_title" placeholder="Task List title">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control list_status" name="list_status" >

                            @foreach(\App\Helpers\Utility::TASK_STATUS as $key => $task)
                                @if($edit->list_status == $key)
                                    <option selected value="{{$key}}">{{$task}}</option>
                                @endif
                                <option value="{{$key}}">{{$task}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control " name="list_desc" placeholder="Task List Details">{{$edit->list_desc}}</textarea>
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