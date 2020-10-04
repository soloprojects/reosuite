<form name="editMainForm" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="container body">
        <div class="row clearfix">
            <div class="row clearfix">
                <div class="col-sm-4">
                    <b>Name*</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" name="name" value="{{$edit->name}}" placeholder="Name" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <b>Zone Description</b>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea type="text" class="form-control" name="zone_desc" placeholder="Description">{{$edit->zone_desc}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <b>Bin Type</b>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control" name="bin_type"  required>
                                <option value="{{$edit->bin->id}}" selected>{{$edit->bin->type}} ({{$edit->bin->code}})</option>
                                @foreach($binType as $type)
                                    <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row clearfix">
                <div class="col-sm-4">
                    <b>Special Equipment</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" name="special_equip" value="{{$edit->special_equip}}" placeholder="Special Equipment" required>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <b>Zone Ranking</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" name="zone_rank" value="{{$edit->zone_ranking}}" placeholder="Zone Ranking" required>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <input type="hidden" name="prev_photo" value="{{$edit->logo}}" >
        <input type="hidden" name="edit_id" value="{{$edit->id}}" >

    </div>

</form>