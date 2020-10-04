<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Title*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->title}}" name="title" placeholder="Title" required>
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
                <b>First Name*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control"value="{{$edit->firstname}}" name="firstname" placeholder="First name" required>
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Last Name*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control"value="{{$edit->lastname}}" name="lastname" placeholder="Last name" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Other Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control"value="{{$edit->othername}}" name="othername" placeholder="Other name" required>
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Gender*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="gender"  required>
                            <option value="{{$edit->sex}}">{{$edit->sex}}</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Department*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="department"  required>
                            <option value="">Select</option>
                            @foreach($department as $data)
                                @if($data->id == $edit->dept_id)
                                <option value="{{$data->id}}" selected>{{$data->dept_name}}</option>
                                @else
                                    <option value="{{$data->id}}">{{$data->dept_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Permission Role*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select type="text" class="form-control" name="role"  required>
                            <option value="{{$edit->role}}" selected>{{$edit->roles->role_name}}</option>

                                @foreach($roles as $role)

                                        <option value="{{$role->id}}">{{$role->role_name}}</option>

                                @endforeach

                        </select>
                    </div>
                </div>
            </div>
           </div>
            <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Date of Birth</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->dob}}" name="birthdate" placeholder="Date of Birth" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Phone</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->phone}}" name="phone" placeholder="Phone" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Address</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->address}}" name="home_address" placeholder="Home Address" >
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Nationality</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->nationality}}" name="nationality" placeholder="Nationality">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Discipline</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control " value="{{$edit->discipline}}" name="discipline" placeholder="Discipline" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Rate</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->rate}}" name="rate" placeholder="Rate" >
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Rate Type</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="rate_type"  >
                            <option value="{{$edit->rate_type}}">{{$edit->rate_type}}</option>
                            <option value="Rate Per Hour">Rate Per Hour</option>
                            <option value="Rate Per Day">Rate Per Day</option>
                            <option value="Rate Per Month">Rate Per Month</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Experience</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="experience" value="{{$edit->experience}}" placeholder="Experience">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Certification</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control " name="cert" value="{{$edit->cert}}" placeholder="Certification" >
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Certificate Expiry Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" name="cert_expiry_date" value="{{$edit->cert_expiry_date}}" placeholder="Certificate Expiry Date" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Certificate Issue Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" name="cert_issue_date" value="{{$edit->cert_issue_date}}" placeholder="Certificate Issue Date" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>BUPA/HMO Expiry Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" name="bupa_hmo_expiry_date" value="{{$edit->bupa_hmo_expiry_date}}" placeholder="BUPA/HMO Expiry Date">
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Green Card Expiry Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->green_card_expiry_date}}" name="green_card_expiry_date" placeholder="Green Card Expiry Date" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Qualifications</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->qualification}}" name="qualification" placeholder="qualification" >
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
        <hr/>

        <div class="row clearfix">

            <div class="col-sm-4">
                <b>CV (Curriculum Vitae)</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="file" class="form-control" name="cv" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Password</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="password" class="form-control " value="" name="password" placeholder="Password" >
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Password Confirm</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="password" class="form-control " value="" name="password_confirmation" placeholder="Confirm Password" >
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Salary Structure*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="salary" >
                            <option value="">Select</option>
                            <option value="">None</option>
                            @foreach($salary as $data)
                                @if($data->id == $edit->salary_id)
                                    <option value="{{$data->id}}" selected>{{$data->salary_name}}</option>
                                @else
                                    <option value="{{$data->id}}">{{$data->salary_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <input type="hidden" name="prev_password" value="{{$edit->password}}" >
    <input type="hidden" name="prev_photo" value="{{$edit->photo}}" >
    <input type="hidden" name="prev_sign" value="{{$edit->cv}}" >
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