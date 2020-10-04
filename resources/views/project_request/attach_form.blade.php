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
                            CKEDITOR.replace('response');
                        </script>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>


