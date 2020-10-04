<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->access_user->firstname}} {{$edit->access_user->lastname}}" autocomplete="off" id="select_user2" onkeyup="searchOptionList('select_user2','myUL2','{{url('default_select')}}','default_search','user2');" name="select_user" placeholder="Department Head">

                        <input type="hidden" value="{{$edit->user_id}}" class="user_class" name="user" id="user2" />
                    </div>
                </div>
                <ul id="myUL2" class="myUL"></ul>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" warehouse" name="warehouse" >
                            <option selected value="{{$edit->warehouse_id}}">{{$edit->warehouse->name}} ({{$edit->warehouse->code}})</option>
                            @foreach($warehouse as $inv)
                                <option value="{{$inv->id}}">{{$inv->name}} ({{$inv->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>