<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="request_description" placeholder="Request Description">{{$edit->req_desc}}
                        </textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        @if($edit->hr_accesible == \App\Helpers\Utility::LOAN_REQUEST || $edit->hr_accessible == \App\Helpers\Utility::SALARY_ADVANCE_REQUEST)
                        <select  class="form-control" name="request_category" >
                            <option value="{{$edit->req_cat}}" selected>{{$edit->requestCat->request_name}}</option>
                            @foreach($reqCat as $ap)
                                <option value="{{$ap->id}}">{{$ap->request_name}}</option>
                            @endforeach
                        </select>
                        @else
                            <select  class="form-control" name="request_category" >
                                <option value="{{$edit->req_cat}}" selected>{{$edit->requestCat->request_name}}</option>
                            </select>
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" onchange="checkProject('request_type','project_id');" id="request_type" name="request_type" >
                            <option value="{{$edit->req_type}}" selected>{{$edit->requestType->request_type}}</option>
                            @foreach($reqType as $ap)
                                <option value="{{$ap->id}}">{{$ap->request_type}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>



        </div>

        <div class="row clear-fix">
            @if($edit->proj_id != 0)
            <div class="col-sm-4" id="project_id" style="display:none;">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control"  id="" name="project" >
                            <option value="{{$edit->proj_id}}" selected>{{$edit->project->project_name}}</option>
                            @foreach($project as $ap)
                                <option value="{{$ap->project->id}}">{{$ap->project->project_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" value="{{$edit->amount}}" class="form-control" name="amount" placeholder="Amount">
                    </div>
                </div>
            </div>

        </div>
    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>