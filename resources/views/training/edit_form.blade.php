<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text"  class="form-control" name="training_name" value="{{$edit->training_name}}" placeholder="Training Name">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="training_desc" placeholder="Training Description">{{$edit->training_desc}}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="training_type" >
                            <option value="{{$edit->type}}" selected>{{$edit->type}}</option>
                            @foreach(\App\Helpers\Utility::TRAINING_TYPE as $key => $val)
                                <option value="{{$val}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clear-fix">

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->user_detail->firstname}} {{$edit->user_detail->lastname}}" autocomplete="off" id="select_user2" onkeyup="searchOptionList('select_user2','myUL2','{{url('default_select')}}','default_search','user2');" name="select_user" placeholder="Select User">

                        <input type="hidden" class="user_class" name="user" value="{{$edit->user_id}}" id="user2" />
                    </div>
                </div>
                <ul id="myUL2" class="myUL"></ul>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->from_date}}" class="form-control datepicker2" name="start_date" placeholder="Start Date">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->to_date}}" class="form-control datepicker2" name="end_date" placeholder="End Date">
                    </div>
                </div>
            </div>

        </div>

        <div class="row clear-fix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->vendor}}" class="form-control" name="vendor" placeholder="Vendor">
                    </div>
                </div>
            </div>
        </div>

    </div>


    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
     $( ".datepicker2" ).datepicker({
     /*changeMonth: true,
     changeYear: true*/
     });
     });
</script>