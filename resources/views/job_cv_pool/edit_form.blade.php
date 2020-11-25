<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="department" >
                            <option value="{{$edit->dept_id}}">{{$edit->department->dept_name}}</option>
                            @foreach($department as $val)
                                <option value="{{$val->id}}">{{$val->dept_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->firstname}}" class="form-control" name="firstname" placeholder="firstname">
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->lastname}}" class="form-control" name="lastname" placeholder="lastname">
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <input type="email" value="{{$edit->email}}" class="form-control" name="email" placeholder="Email">
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->phone}}" name="phone" placeholder="Phone">
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->address}}" name="address" placeholder="Address">
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="job" >
                            <option value="{{$edit->job_id}}">{{$edit->job->job_title}}</option>
                            @foreach($jobs as $val)
                                <option value="{{$val->id}}">{{$val->job_title}} ({{$val->location}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="position" >
                            <option value="{{$edit->position_id}}">{{$edit->position->position_name}}</option>
                            @foreach($position as $val)
                                <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->salary_expectation}}" name="salary_expectation" placeholder="Salary_expectation">
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="experience" >
                            <option value="{{$edit->experience}}">{{$edit->experience}} yrs</option>
                            @for($i=0;$i<30;$i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->remark}}" name="remark" placeholder="Remark">
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="cover_letter" placeholder="Cover Letter">{{$edit->cover_letter}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <b>Attach CV/Resume</b>
                    <div class="form-line">
                        <input type="file" class="form-control" name="cv_file" placeholder="Attach CV">
                    </div>
                </div>
            </div>

        </div>
        <input type="hidden" name="prev_cv" value="{{$edit->cv_file}}"/>


    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>