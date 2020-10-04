<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="type" >
                            <option value="{{$edit->type}}">{{$edit->type}}</option>
                            <option value="Assumption">Assumption</option>
                            <option value="Constraint">Constraint</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="details" placeholder="Details">{{$edit->assump_desc}}</textarea>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>