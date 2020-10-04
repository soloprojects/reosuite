<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="tax_name" value="{{$edit->tax_name}}" placeholder="Tax Name">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control"  value="{{$edit->sum_percentage}}" name="percentage_sum" placeholder="Sum Percentage">
                    </div>
                </div>
            </div>

        </div>

        <?php $components = json_decode($edit->component,TRUE); ?>
        @foreach($components as $comp)
            <div class="row clearfix">
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control comp_name_edit" name="component_name1" value="{{$comp['component']}}" placeholder="Component Name">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control tax_agent_edit" value="{{$comp['tax_agent']}}" name="tax_agent1" placeholder="Tax Agent">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="number" class="form-control percentage_edit" value="{{$comp['percentage']}}" name="percentage1" placeholder="Percentage Deduction">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="row clearfix">


            <div class="col-sm-4" id="hide_button_edit">
                <div class="form-group">
                    <div onclick="addMore('add_more_edit','hide_button_edit','1','<?php echo URL::to('add_more'); ?>','tax','hide_button_edit');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

        </div>

        <div id="add_more_edit"></div>

    </div>


    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>