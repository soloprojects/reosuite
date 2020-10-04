<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-5">
                <b>Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->name}}" name="name" placeholder="Name">
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>Probability</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->probability}}" name="probability" placeholder="Probability (%)">
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <b>Stage</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="stage">
                            <option value="{{$edit->stage}}">Stage {{$edit->stage}}</option>
                            @for($i=1;$i<=10;$i++)
                                <option value="{{$i}}">Stage {{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>