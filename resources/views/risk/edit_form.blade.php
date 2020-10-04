<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="risk_description" placeholder="Risk Description">{{$edit->risk_desc}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="trigger" placeholder="Trigger Event/Indicator">{{$edit->trigger}}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">

            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control"  name="probability" >
                            <option value="{{$edit->probability}}">{{$edit->probability}}</option>
                            <option value="Highly Likely">Highly Likely</option>
                            <option value="Somewhat Likely">Somewhat Likely</option>
                            <option value="Likely">Likely</option>
                            <option value="Unlikely">Unlikely</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control"  name="impact" >
                            <option value="{{$edit->impact}}">{{$edit->impact}}</option>
                            <option value="Critical">Critical</option>
                            <option value="Severe">Severe</option>
                            <option value="Moderate">Moderate</option>
                            <option value="Minimal/Minor">Minimal/Minor</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">

            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control"  name="detectability" >
                            <option value="{{$edit->detectability}}">{{$edit->detectability}}</option>
                            <option value="Determined After Impact">Determined After Impact</option>
                            <option value="Realized Upon Trigger Event">Realized Upon Trigger Event</option>
                            <option value="Immediately Prior to Trigger Event">Immediately Prior to Trigger Event</option>
                            <option value="Determined in Advance">Determined in Advance</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control"  name="category" >
                            <option value="{{$edit->category}}">{{$edit->category}}</option>
                            <option value="Technology">Technology</option>
                            <option value="Personnel">Personnel</option>
                            <option value="Equipment">Equipment</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>


        <div class="row clearfix">

            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control" name="contingency_plan" placeholder="Contingency Plan">{{$edit->contingency_plan}}</textarea>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>