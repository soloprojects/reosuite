<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-4">
                <b>Currency*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="currency" placeholder="currency" required>
                            <option value="{{$edit->currency_id}}" selected>{{$edit->currency->currency}} ({{$edit->currency->code}})</option>
                            @foreach($currency as $curr)
                                <option value="{{$curr->id}}">{{$curr->code}} ({{$curr->symbol}}) ({{$curr->currency}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Name*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->name}}" name="name" placeholder="Name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Address</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->address}}" name="address" placeholder="Address" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>City</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->city}}" name="city" placeholder="City" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Phone</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->phone}}" name="phone" placeholder="Phone" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Contact No</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="contact_no" value="{{$edit->contact_no}}" placeholder="Contact No" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Contact Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->contact_name}}" name="contact_name" placeholder="Contact Name" required>
                    </div>
                </div>
            </div>
        </div>


        <div class="row clearfix">
                <div class="col-sm-4">
                    <b>Email 1</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{$edit->email1}}" name="email1" placeholder="Email 1" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <b>Email 2</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{$edit->email2}}" name="email2" placeholder="Email 2" required>
                        </div>
                    </div>
                </div>

            </div>

    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
        $( ".datepicker1" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
            /*yearRange: "-90:+00"*/

        });
    });
</script>