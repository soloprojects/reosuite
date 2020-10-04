<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-8">
                <b>Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->name}}" name="name" placeholder="Name">
                    </div>
                </div>
            </div>

        </div>

        @if(!empty($edit->stageAccess))
            @foreach($edit->stageAccess as $stage)
                <div class="row clearfix" id="remove_stage{{$stage->id}}">
                    <div class="col-sm-8" id="">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" value="{{$stage->name}}" autocomplete="off" id="select_stage_edit" onkeyup="searchOptionList('select_stage_edit','myUL_edit','{{url('default_select')}}','crm_stage_search','stage_edit');" name="select_stage" placeholder="Select Stage">

                                <input type="hidden" value="{{$stage->id}}" class="stage_class_edit" name="stages" id="stage_edit" />
                            </div>
                        </div>
                        <ul id="myUL_edit" class="myUL"></ul>
                    </div>

                    <div class="col-sm-3">
                        <button type="button" onclick="deleteSingleItemWithParam('{{$edit->id}}','{{$stage->id}}','reload_data','<?php echo url('crm_sales_cycle'); ?>',
                                '<?php echo url('remove_crm_sales_cycle_stage'); ?>','<?php echo csrf_token(); ?>','remove_stage{{$stage->id}}');" class="btn btn-danger">
                            <i class="fa fa-trash-o"></i>Delete
                        </button>
                    </div>

                </div>
            @endforeach
        @endif

        <div class="row clearfix">
            <div class="col-sm-4" id="hide_button_edit">

                <div class="form-group">
                    <div onclick="addMoreEditable('add_more_edit','hide_button_edit','400','<?php echo URL::to('add_more'); ?>','multiple_stages','hide_button_edit','stage_class_edit');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>Add more Stages to access document(s)
                    </div>
                </div>
            </div>
        </div>

        <div class="" id="add_more_edit">

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