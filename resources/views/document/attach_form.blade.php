<p>
    {{$edit->doc_name}}
</p>

<form name="" id="attachForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="file" multiple="multiple" class="form-control" name="attachment[]" >
                    </div>
                </div>
            </div>

        </div>
    </div>

    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>
<?php $attach = json_decode($edit->docs,true); $num=0; ?>
@if(count($attach) < 1)
    No Document
@else

<table class="table table-responsive">
    <thead>
    <th> Attachment</th>
    <th>Download/Open</th>
    <th>Remove Attachment</th>
    </thead>
    <tbody>
    @foreach($attach as $at)
        <?php $num++; ?>
    <tr>
        <td>{{$at}}</td>
        <td><a target="_blank" href="<?php echo URL::to('download_document_attachment?file='); ?>{{$at}}">
                <i class="fa fa-files-o fa-2x"></i>
            </a></td>
        <td>

            <form name="" id="removeAttachForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                <div class="body">
                    <div class="row clearfix">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="hidden" value="{{$at}}"  class="form-control" name="attachment" >
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <input type="hidden" name="edit_id" value="{{$edit->id}}" >
            </form>

            @if($edit->created_by == Auth::user()->id || in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
            <button type="button"  onclick="submitMediaForm('attachModal','removeAttachForm','<?php echo url('remove_document_attachment'); ?>','reload_data',
                    '<?php echo url('document'); ?>','<?php echo csrf_token(); ?>')"
                    class="btn btn-link waves-effect">
                Remove
            </button>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table><hr/>

@endif

@if($edit->created_by == Auth::user()->id || in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
    <div class="row clearfix">
        <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('edit_document_attachment'); ?>','reload_data',
                '<?php echo url('document'); ?>','<?php echo csrf_token(); ?>')"
                class="btn btn-info waves-effect pull-right">
            SAVE CHANGES
        </button>
    </div>
@endif



