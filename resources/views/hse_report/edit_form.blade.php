<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal container" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="report_type" >
                            <option value="{{$edit->report_type}}">{{\App\Helpers\Utility::hseReportType($edit->report_type)}}</option>
                            @foreach(\App\Helpers\Utility::HSE_REPORT_TYPE as $key => $var)
                                <option value="{{$key}}">{{$var}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="source_type" >
                            <option value="{{$edit->source_id}}">{{$edit->source->source_name}}</option>
                            @foreach($sourceType as $ap)
                                <option value="{{$ap->id}}">{{$ap->source_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="location" value="{{$edit->location}}" placeholder="Location">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker1" value="{{$edit->report_date}}" name="occurrence_date" placeholder="Date of occurrence">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">

            <div class="col-md-8">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" id="details_edit" class="form-control " name="details" placeholder="Details">{{$edit->report_details}}</textarea>
                        <script>
                            CKEDITOR.replace('details_edit');
                        </script>
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
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>