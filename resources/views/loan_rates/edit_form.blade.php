<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="loan_name" value="{{$edit->loan_name}}" placeholder="Loan Name">
                    </div>
                </div>
            </div>


            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->interest_rate}}" name="interest_rate" placeholder="Interest Rate">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="loan_description" placeholder="Description">{{$edit->loan_desc}}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->duration}}" name="duration" placeholder="Duration">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>