<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->request_name}}" name="request_name" placeholder="Request Name">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="account_type" >
                            <option value="{{$edit->acct_id}}">{{$edit->account_cat->category_name}}</option>
                            @foreach($acct_cat as $ap)
                                <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="department" >

                            @foreach($dept as $ap)
                                @if($edit->dept_id == $ap->id)
                                <option value="{{$edit->dept_id}}" selected>{{$ap->dept_name}}</option>
                                @else
                                <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>