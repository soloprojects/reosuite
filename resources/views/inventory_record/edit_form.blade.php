<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                Inventory Item
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->inventory->item_name}}" autocomplete="off" id="select_inv{{$edit->id}}" onkeyup="searchOptionList('select_inv{{$edit->id}}','myUL500{{$edit->id}}','{{url('default_select')}}','search_inventory','inv500{{$edit->id}}');" name="select_user" placeholder="Inventory Item">

                        <input type="hidden" class="inv_class" value="{{$edit->item_id}}" name="item" id="inv500{{$edit->id}}" />
                    </div>
                </div>
                <ul id="myUL500{{$edit->id}}" class="myUL"></ul>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="department" >
                            <option value="{{$edit->dept_id}}">{{$edit->department->dept_name}}</option>
                            @foreach($dept as $d)
                                <option value="{{$d->id}}">{{$d->dept_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control " value="{{$edit->item_desc}}" name="item_description" placeholder="Description">
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->serial_no}}" name="serial_no" placeholder="Serial Number">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker2" value="{{$edit->warranty_expiry_date}}" name="warranty_expiry" placeholder="Warranty/Expiry_date">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="item_condition" >
                            <option value="{{$edit->item_condition}}">{{$edit->item_condition}}</option>
                            <option value="Brand New">Brand New</option>
                            <option value="Fairly Used">Fairly Used</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
        $( ".datepicker2" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>