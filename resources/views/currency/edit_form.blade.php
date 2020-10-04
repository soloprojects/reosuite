<h3>Currency :- {{$edit->currency}}</h3><hr/>
<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Default Rate</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" name="default_rate" value="{{$edit->default_currency}}" placeholder="Default Rate">
                    </div>
                </div>
            </div>
            <?php $dbStatus = ($edit->default_curr_status == 1) ? 'Active' : 'Inactive' ?>
            <div class="col-sm-4">
                Default Rate Status
                <div class="form-group">
                    <div class="form-line">
                       <select class="form-control" name="status">
                           <option value="{{$edit->default_curr_status}}">{{$dbStatus}}</option>
                           <option value="1">Active</option>
                           <option value="0">Inactive</option>
                       </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>