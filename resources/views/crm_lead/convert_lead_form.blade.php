<form name="" id="convertLeadForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

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
                <b>Zip Code*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="zip_code" placeholder="Zip Code" required>
                    </div>
                </div>
            </div>
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

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Contact Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->contact_name}}" name="contact_name" placeholder="Contact Name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Search Key</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="search_key" placeholder="Search Key" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Company Description</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control"  name="company_desc" placeholder="Company Description" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Website</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="website" placeholder="website" required>
                    </div>
                </div>
            </div>
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


        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Company/RC. No.</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control " name="company_no" placeholder="company_no" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Payment Terms</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="pay_terms" placeholder="Payment Terms" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Tax Identification No</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="tax_no" placeholder="Tax Identification No" >
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Bank Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="bank_name"  placeholder="bank_name">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Account Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="account_name" placeholder="account name" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Account No</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control"  name="account_no" placeholder="Account No" >
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Logo</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="file" class="form-control" name="logo" >
                    </div>
                </div>
            </div>

        </div>

    </div>
    <input type="hidden" class="form-control" name="contact_type" value="{{\App\Helpers\Utility::CUSTOMER}}" />

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