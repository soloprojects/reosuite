<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->model_name}}" name="name" placeholder="Name">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="make" placeholder="Vehicle Make" required>
                            <option value="{{$edit->make_id}}">{{$edit->make->make_name}}</option>
                            @foreach($vehicleMake as $make)
                                <option value="{{$make->id}}">{{$make->make_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>