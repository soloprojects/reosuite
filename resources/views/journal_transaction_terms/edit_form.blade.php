<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->name}}" name="name" placeholder="Name">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" name="days_due" placeholder="Days Due" value="{{$edit->days_due}}" />
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>