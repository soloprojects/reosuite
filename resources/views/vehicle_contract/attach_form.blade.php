<p>
    {{$edit->vehicleDetail->license_plate}}
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
        <td>File{{$num}}</td>
        <td><a target="_blank" href="<?php echo URL::to('download_vehicle_contract_attachment?file='); ?>{{$at}}">
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

            <button type="button"  onclick="submitMediaForm('attachModal','removeAttachForm','<?php echo url('remove_vehicle_contract_attachment'); ?>','reload_data',
                    '<?php echo url('vehicle_contract'); ?>','<?php echo csrf_token(); ?>')"
                    class="btn btn-info waves-effect">
                Remove
            </button>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endif