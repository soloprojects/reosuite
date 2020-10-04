<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->job_title}}" class="form-control" name="job_title" placeholder="Job Title">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="job_type" >
                            <option value="{{$edit->job_type}}">{{$edit->job_type}}</option>
                            <option value="Temporary">Temporary</option>
                            <option value="Permanent">Permanent</option>
                            <option value="Contract">Contract</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="job_status" >
                            <option value="{{$edit->job_status}}">{{\App\Helpers\Utility::statusDisplay($edit->job_status)}}</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control ckeditor" id="job_purpose_edit" name="job_purpose" placeholder="Job Purpose">{{$edit->job_purpose}}</textarea>
                        <script>
                            CKEDITOR.replace('job_purpose_edit');
                            CKEDITOR.config.height = 70;     // 500 pixels tall.
                        </script>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control ckeditor" id="job_desc_edit" name="job_desc" placeholder="Job Description">{{$edit->job_desc}}</textarea>
                        <script>
                            CKEDITOR.replace('job_desc_edit');
                            CKEDITOR.config.height = 70;     // 500 pixels tall.
                        </script>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control ckeditor" id="job_spec_edit" name="job_spec" placeholder="Job Specification">{{$edit->job_spec}}</textarea>
                        <script>
                            CKEDITOR.replace('job_spec_edit');
                            CKEDITOR.config.height = 70;     // 500 pixels tall.
                        </script>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="location" placeholder="Job Location">{{$edit->location}}</textarea>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->salary_range}}" name="salary_range" placeholder="Salary Range">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="experience" >
                            <option value="{{$edit->experience}}">{{$edit->experience}}</option>
                            @for($i=0;$i<30;$i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>