<form name="editMainForm" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
    <div class="body">
        <h3>General</h3><hr>
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Code*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->code}}" name="code" placeholder="Code" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Name*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="Name" class="form-control" value="{{$edit->name}}" name="name" placeholder="Email" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Address*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->address}}" name="address" placeholder="Address" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Address2*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="address2" value="{{$edit->address2}}" placeholder="Address2" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>country</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="country" value="{{$edit->country}}" placeholder="Country" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Post Code*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->post_code}}" name="post_code" placeholder="Post Code" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Contact</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->contact}}" name="contact" placeholder="Contact Name" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Contact Phone</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->phone}}" name="phone" placeholder="Phone" required>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">

            <div class="col-sm-4">
                <b>Contact Email</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="email" value="{{$edit->email}}" placeholder="email" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Contact Fax</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="fax" value="{{$edit->fax}}" placeholder="Fax" required>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Warehouse Manager</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->whseManager->firstname}} {{$edit->whseManager->lastname}}" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select User">

                        <input type="hidden" class="user_class" name="warehouse_manager" id="user" />
                    </div>
                </div>
                <ul id="myUL1" class="myUL"></ul>
            </div>

        </div>

    </div>

    <div class="body">
        <h3>Warehouse</h3><hr>
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Default Receipt Bin Code</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="receipt_bin" >
                            @foreach($binType as $type)
                                @if($edit->receipt_bin_code == $type->id)
                                    <option value="{{$type->id}}" selected>{{$type->type}} ({{$type->code}})</option>

                                @endif
                                <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Default Shipment bin code</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="shipment_bin" >
                            @foreach($binType as $type)
                                @if($edit->ship_bin_code == $type->id)
                                    <option value="{{$type->id}}" selected>{{$type->type}} ({{$type->code}})</option>

                                @endif
                                <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Open Shop Floor Bin Code (Production)</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="open_shop_floor_bin">
                            @foreach($binType as $type)
                                @if($edit->open_shop_floor_bin_code == $type->id)
                                    <option value="{{$type->id}}" selected>{{$type->type}} ({{$type->code}})</option>

                                @endif
                                <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>To Production Bin Code (Production)</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="to_prod_bin" >
                            @foreach($binType as $type)
                                @if($edit->to_prod_bin_code == $type->id)
                                    <option value="{{$type->id}}" selected>{{$type->type}} ({{$type->code}})</option>

                                @endif
                                <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>From Production Bin Code (Production)</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="from_prod_bin">
                                @foreach($binType as $type)
                                @if($edit->from_prod_bin_code == $type->id)
                                    <option value="{{$type->id}}" selected>{{$type->type}} ({{$type->code}})</option>

                                @endif
                                <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Adjustment Bin Code (Adjustment)</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="adjust_code">
                            @foreach($binType as $type)
                                @if($edit->adjust_bin_code == $type->id)
                                    <option value="{{$type->id}}" selected>{{$type->type}} ({{$type->code}})</option>

                                @endif
                                <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Cross-Dock Bin Code (Cross-Dock)</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="cross_dock_bin" >
                                @foreach($binType as $type)
                                @if($edit->cross_dock_bin_code == $type->id)
                                    <option value="{{$type->id}}" selected>{{$type->type}} ({{$type->code}})</option>

                                @endif
                                <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>To Assembly Bin Code (Assembly)</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="to_assemb_bin">
                            @foreach($binType as $type)
                                @if($edit->to_assembly_bin_code == $type->id)
                                    <option value="{{$type->id}}" selected>{{$type->type}} ({{$type->code}})</option>

                                @endif
                                <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>From Assembly Bin Code (Assembly)</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="from_assemb_code" >
                            @foreach($binType as $type)
                                @if($edit->from_assembly_bin_code == $type->id)
                                <option value="{{$type->id}}" selected>{{$type->type}} ({{$type->code}})</option>

                                @endif
                                <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">

            <div class="col-sm-4">
                <b>Assm To Order Shipt Bin Code (Assembly)</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="Ass_to_ord_ship_bin">
                            @foreach($binType as $type)
                                @if($edit->assembly_to_order_ship_bin_code == $type->id)
                                 <option value="{{$type->id}}" selected>{{$type->type}} ({{$type->code}})</option>

                                @endif
                                <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="body">
        <h3>Bin Policies</h3><hr>
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Special Equipment</b>
                <div class="form-group">
                    <div class="form-line">
                        <select type="text" class="form-control"  name="special_equip" required>
                            <option value="{{$edit->special_equip}}">{{$edit->special_equip}}</option>
                            @foreach(\App\Helpers\Utility::SPECIAL_EQUIP as $equip)
                                <option value="{{$equip}}">{{$equip}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Bin Capacity Policy</b>
                <div class="form-group">
                    <div class="form-line">
                        <select type="text" class="form-control"  name="bin_cap_policy" required>
                            <option value="{{$edit->bin_capacity_policy}}">{{$edit->bin_capacity_policy}}</option>
                            @foreach(\App\Helpers\Utility::CAPACITY_POLICY as $policy)
                                <option value="{{$policy}}">{{$policy}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class ="col-sm-4">
                <b>Allow Breakbulk</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="checkbox" class="form-control" value="checked" {{$edit->allow_break_bulk}} name="break_bulk" placeholder="Email" required>
                    </div>
                </div>
            </div>


        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Put Away Template Code</b>
                <div class="form-group">
                    <div class="form-line">
                        <select type="text" class="form-control" name="put_away_temp_code" >
                            @foreach($putAwayTemp as $temp)
                                @if($edit->put_away_template_code == $temp->id)
                                <option value="{{$temp->id}}" selected>{{$temp->name}}</option>

                                @endif
                                <option value="{{$temp->id}}">{{$temp->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Always Create Put-Away Pick Line</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="checkbox" class="form-control" value="checked" {{$edit->put_away_line}} name="put_away_pick_line">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Always Create Pick Line</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="checkbox" class="form-control" value="checked" {{$edit->pick_line}} name="pick_line">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Pick According to FEFO*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="checkbox" class="form-control" value="checked" {{$edit->pick_feffo}}  name="pick_feffo" placeholder="phone2" required>
                    </div>
                </div>
            </div>

        </div>

    </div>

        <input type="hidden" name="prev_photo" value="{{$edit->logo}}" >
        <input type="hidden" name="edit_id" value="{{$edit->id}}" >

    </div>

</form>