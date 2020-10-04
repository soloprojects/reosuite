<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-10">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="deliverable" placeholder="Deliverable">{{$edit->del_desc}}</textarea>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>