<p>
    {!!$edit->details!!}
</p>

<form name="" id="attachForm" onsubmit="false;" class="form form-horizontal container" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" id="request_response" class="form-control " name="response" placeholder="Details">{{$edit->response}}</textarea>
                        <script>
                            CKEDITOR.replace('request_response');
                        </script>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
    <input type="hidden" name="opportunity" value="{{$edit->opportunity_id}}" >
    <input type="hidden" name="opportunity_stage" id="feedback_stage_edit" value="{{$edit->stage_id}}" >
</form>


