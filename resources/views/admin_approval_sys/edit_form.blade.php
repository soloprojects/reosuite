<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="approval_name" value="{{$edit->approval_name}}" placeholder="Approval Name">
                    </div>
                </div>
            </div>

        </div>

        <?php $num = 0; ?>
        @foreach($approve as $data => $value)
        <?php $num++ ?>
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$data}}" autocomplete="off" id="select_user001{{$num}}" onkeyup="searchOptionList('select_user001{{$num}}','myUL001{{$num}}','{{url('default_select')}}','default_search','user001{{$num}}');" name="select_user" placeholder="Select User">
                        @foreach($value as $da => $val)
                        <input type="hidden" class="user_class_edit" name="user" value="{{$val}}" id="user001{{$num}}" />
                        @endforeach
                    </div>
                </div>
                <ul id="myUL001{{$num}}" class="myUL"></ul>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control stage_edit" name="stage_edit" >
                            @foreach($value as $da => $val)
                            <option value="{{$da}}" selected>Stage {{$da}}</option>
                            @endforeach
                            <?php for($i=0; $i<10;$i++){ ?>
                            @if($i == 0)
                            @else
                                <option value="{{$i}}">Stage {{$i}}</option>
                            @endif

                            <?php } ?>

                        </select>
                    </div>
                </div>
            </div>
        </div>
        @endforeach


        <div class="row clearfix">


            <div class="col-sm-4" id="hide_button_edit">
                <div class="form-group">
                    <div onclick="addMore('add_more_edit','hide_button_edit','1','<?php echo URL::to('add_more'); ?>','approval_sys_edit','hide_button_edit');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

        </div>

        <div id="add_more_edit"></div>

    </div>


    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>