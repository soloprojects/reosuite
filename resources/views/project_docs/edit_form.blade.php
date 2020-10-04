<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-6">
                <div class="form-group">
                    <b>File(s) Title</b>
                    <div class="form-line">
                        <input type="text" class="form-control" name="title" value="{{$edit->doc_name}}" placeholder="Title">
                    </div>
                </div>
            </div>
        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>