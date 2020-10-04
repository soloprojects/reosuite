<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="priority" >
                            <option value="{{$edit->priority}}">{{$edit->priority}}</option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="change_description" placeholder="Change Description">{{$edit->change_desc}}</textarea>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>