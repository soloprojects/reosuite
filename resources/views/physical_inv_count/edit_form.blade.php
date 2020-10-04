<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->code}}" name="code" placeholder="Code">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="description" placeholder="Description">{{$edit->code_desc}} </textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->value}}" name="value" placeholder="Value">
                    </div>
                </div>
            </div>


        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>