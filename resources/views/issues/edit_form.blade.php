<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="issue_description" placeholder="Issue Description">{{$edit->issue_desc}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="impact" placeholder="Impact">{{$edit->impact}}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">

            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="resolution" placeholder="resolution">{{$edit->resolution}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control"  name="importance" >
                            <option value="{{$edit->importance}}">{{$edit->importance}}</option>
                            <option value="High">High</option>
                            <option value="Medium High">Medium High</option>
                            <option value="Medium Low">Medium Low</option>
                            <option value="Low">Low</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>