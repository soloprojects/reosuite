<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="department" >
                            <option value="{{$edit->dept}}">{{$edit->department->dept_name}}</option>
                            @foreach($dept as $de)
                                <option value="{{$de->id}}">{{$de->dept_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="approval_system" >
                            <option value="{{$edit->approval_id}}">{{$edit->approval->approval_name}}</option>
                            @foreach($approval as $ap)
                                <option value="{{$ap->id}}">{{$ap->approval_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>