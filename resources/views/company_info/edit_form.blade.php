<form name="editMainForm" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">
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
                <b>Email*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="email" class="form-control" value="{{$edit->email}}" name="email" placeholder="Email" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Address*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="address" value="{{$edit->address}}" placeholder="Address" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Phone1*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="phone1" placeholder="phone2" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Phone2</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="phone2" placeholder="phone2" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Photo</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="file" class="form-control" name="photo" >
                    </div>
                </div>
            </div>

        </div>

        <input type="hidden" name="prev_photo" value="{{$edit->logo}}" >
        <input type="hidden" name="edit_id" value="{{$edit->id}}" >

    </div>

</form>