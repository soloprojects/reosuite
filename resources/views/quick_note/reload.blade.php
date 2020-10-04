<div class="row clearfix" id="notes_main_table">
    <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
        <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check" name="check_all" class="" />
        <b>Mark All</b>

        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne_1">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseOne_1" aria-expanded="true" aria-controls="collapseOne_1">
                            New Note
                        </a>
                    </h4>
                </div>
                <div id="collapseOne_1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_1">
                    <div class="panel-body">

                        <form name="quickNoteForm" id="createMainFormQuickNote" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control" rows="4" name="details" placeholder="Details"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="modal-footer">
                            <button onclick="submitDefaultNoFormModal('createMainFormQuickNote','<?php echo url('create_quick_note'); ?>','reload_data_quick_notes',
                                    '<?php echo url('quick_note'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect pull-right">
                                SAVE
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            @foreach($mainData as $data)
                <div class="panel panel-primary">
                    <input value="{{$data->id}}" type="checkbox" id="quick_notes_{{$data->id}}" class="kid_checkbox" />

                    <div class="panel-heading" role="tab" id="headingNote_{{$data->id}}">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapse_{{$data->id}}" aria-expanded="false"
                               aria-controls="collapseTwo_1">
                                {{substr($data->details,0,80)}}
                            </a>
                        </h4>
                    </div>
                    <div id="collapse_{{$data->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNote_{{$data->id}}">
                        <div class="panel-body">
                            <p>Created at {{$data->created_at}} ({{$data->created_at->diffForHumans()}})</p>
                            <form name="" id="editMainFormQuickNote" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea class="form-control" rows="4" name="details" placeholder="Details">{{$data->details}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="edit_id" value="{{$data->id}}" >
                            </form>

                            <div class="modal-footer">
                                <button type="button"  onclick="submitDefaultNoFormModal('editMainFormQuickNote','<?php echo url('edit_quick_note'); ?>','reload_data_quick_notes',
                                        '<?php echo url('quick_note'); ?>','<?php echo csrf_token(); ?>')"
                                        class="btn btn-info waves-effect pull-right">
                                    SAVE CHANGES
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>





