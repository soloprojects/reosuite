@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Info
                    </h2>
                    <ul class="header-dropdown m-r--5">

                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'reload_data', $exportDocId = 'reload_data'])
                            </ul>
                        </li>

                    </ul>
                </div>

                <div class="body ">

                    <div class=" table-responsive" id="reload_data">

                        <div class="image pull-right">
                            <img src="{{ asset('images/'.$edit->photo) }}" class=""  alt="User" />

                        </div><br>
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
                                    <div class="col-sm-4">
                                        <b>Other Email</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="email" class="form-control" value="{{$edit->other_email}}" name="other_email" placeholder="Other Email" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>

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
                                        <b>Employment Type*</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                                                <select class="form-control" name="employ_type"  required>
                                                    <option value="{{$edit->employ_type}}">{{$edit->employ_type}}</option>
                                                    <option value="Permanent">Permanent</option>
                                                    <option value="Temporary">Temporary</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                                @else
                                                <select class="form-control" name="employ_type"  required>
                                                    <option value="{{$edit->employ_type}}" selected>{{$edit->employ_type}}</option>
                                                </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Department*</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                                                <select class="form-control" name="department"  required>
                                                    @foreach($department as $data)
                                                        @if($data->id == $edit->dept_id)
                                                            <option value="{{$data->id}}" selected>{{$data->dept_name}}</option>
                                                        @else
                                                            <option value="{{$data->id}}">{{$data->dept_name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @else
                                                <select class="form-control" name="department"  required>
                                                            <option value="{{$edit->dept_id}}" selected>{{$edit->department->dept_name}}</option>
                                                 </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-sm-4">
                                            <b>Position*</b>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                                                    <select class="form-control" name="position"  required>
                                                        @foreach($position as $data)
                                                            @if($data->id == $edit->position_id)
                                                                <option value="{{$data->id}}" selected>{{$data->position_name}}</option>
                                                            @else
                                                                <option value="{{$data->id}}">{{$data->position_name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @else
                                                    <select class="form-control" name="position"  required>
                                                        <option value="{{$edit->position_id}}" selected>{{$edit->position->position_name}}</option>
                                                    </select>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <b>Salary Structure*</b>
                                            <div class="form-group">
                                                <div class="form-line">
                                                    @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                                                    <select class="form-control" name="salary"  required>
                                                        <option value="">Select</option>
                                                        @foreach($salary as $data)
                                                            @if($data->id == $edit->salary_id)
                                                                <option value="{{$data->id}}" selected>{{$data->salary_name}}</option>
                                                            @else
                                                                <option value="{{$data->id}}">{{$data->salary_name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @else
                                                    <select class="form-control" name="salary"  required>
                                                        <option value="{{$edit->salary_id}}" selected>{{$edit->salary->salary_name}}</option>
                                                    </select>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <b>Permission Role*</b>
                                            <div class="form-group">
                                                <div class="form-line">

                                                    <select type="text" class="form-control" name="role"  required>
                                                        <option value="{{$edit->role}}" selected>{{$edit->roles->role_name}}</option>
                                                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                                                            @foreach($roles as $role)
                                                                @if($role->id != 1)

                                                                    <option value="{{$role->id}}">{{$role->role_name}}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Date of Birth</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" value="{{$edit->dob}}" name="birthdate" placeholder="Date of Birth" >
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
                                        <b>State</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control " value="{{$edit->state}}" name="state" placeholder="State" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Local Govt.</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" value="{{$edit->local_govt}}" name="local_govt" placeholder="Local Govt." >
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Marital Status</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" name="marital_status"  >
                                                    <option value="{{$edit->marital}}" selected>{{$edit->marital}}</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Divorced">Divorced</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Blood Group</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" value="{{$edit->blood_group}}" name="blood_group" placeholder="Blood Group">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Next of Kin</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control " value="{{$edit->next_kin}}" name="next_of_kin" placeholder="Next of Kin" >
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Kin Phone</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="number" class="form-control" value="{{$edit->next_kin_phone}}" name="next_of_kin_phone" placeholder="Kin phone" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Name of Emergency Contact</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" value="{{$edit->emergency_name}}" name="emergency" placeholder="Name of emergency contact" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Emergency Phone</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" value="{{$edit->emergency_phone}}" name="emergency_phone" placeholder="Emergency Phone">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Job Role</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control " disabled value="{{$edit->job_role}}" name="job_role" placeholder="Job Role" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Date of Employment</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control datepicker" disabled value="{{$edit->employ_date}}" name="employ_date" placeholder="Date of Employment" >
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
                                </div>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Photo</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="file" class="form-control" name="photo" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Signature</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="file" class="form-control" name="sign" >
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

                                </div>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Password Confirm</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="password" class="form-control " value="" name="password_confirmation" placeholder="Confirm Password" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Emergency Contact Address</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" value="{{$edit->emergency_contact}}" name="emergency_contact" placeholder="Emergency Contact Address" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Religion</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" name="religion"  >
                                                    <option value="{{$edit->religion}}" selected>{{$edit->religion}}</option>
                                                    <option value="Chrisitianity">Chrisitianity</option>
                                                    <option value="Islam">Islam</option>
                                                    <option value="Buddhism">Buddhism</option>
                                                    <option value="Hinduism">Hinduism</option>
                                                    <option value="Folk-Religion">Folk Religion</option>
                                                    <option value="Unaffiliated">Unaffiliated</option>
                                                    <option value="Other">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <input type="hidden" name="prev_password" value="{{$edit->password}}" >
                            <input type="hidden" name="prev_photo" value="{{$edit->photo}}" >
                            <input type="hidden" name="prev_sign" value="{{$edit->sign}}" >
                            <input type="hidden" name="edit_id" value="{{$edit->id}}" >

                            <button type="button"  onclick="submitMediaForm1('editModal','editMainForm','<?php echo url('edit_user'); ?>','reload_data',
                                    '<?php echo url('user'); ?>','<?php echo csrf_token(); ?>')"
                                    class="pull-right btn btn-success waves-effect">
                                SAVE CHANGES
                            </button>
                        </form>


                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->
    <script>
        //SUBMIT FORM WITH A FILE
        function submitMediaForm1(formModal,formId,submitUrl,reload_id,reloadUrl,token){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            var postVars = new FormData(form);
            postVars.append('token',token);
            $('#loading_modal').modal('show');
            $('#'+formModal).modal('hide');
            sendRequestMediaForm(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {
                    $('#loading_modal').modal('hide');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if(message2 == 'fail'){

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error",messageError, "error");

                    }else if(message2 == 'saved'){

                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", successMessage, "success");
                        location.reload();

                    }else{

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    //reloadContent(reload_id,reloadUrl);
                }
            }

        }
    </script>

@endsection