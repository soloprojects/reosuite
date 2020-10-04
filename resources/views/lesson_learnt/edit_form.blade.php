<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">

        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="subject" value="{{$edit->subject}}" placeholder="Subject">
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="situation" placeholder="Situation">{{$edit->situation}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="recommendation" placeholder="Recommendation">{{$edit->recommendation}}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">

            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="need" placeholder="Need">{{$edit->need}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="follow_up" placeholder="Need">{{$edit->follow_up}}</textarea>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>