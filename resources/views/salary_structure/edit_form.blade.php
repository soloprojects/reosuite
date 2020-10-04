<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->salary_name}}" name="salary_name" placeholder="Salary Name">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control"  name="salary_desc"  placeholder="Salary Description">{{$edit->desc}}</textarea>
                    </div>
                </div>
            </div>

        </div>
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->gross_pay}}" id="gross_pay_edit" name="gross_pay" placeholder="Gross Pay">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->net_pay}}" id="net_pay_edit" name="net_pay" placeholder="Net Pay">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" id="tax_id_edit" onchange="taxCtrl('{{url('fetch_tax_data')}}','gross_pay_edit','net_pay_edit','tax_id_edit');" name="tax_system" >
                            <option value="">select</option>
                            @foreach($taxSystem as $comp)
                                @if($comp->tax_name == $edit->tax->tax_name)
                                    <option value="{{$comp->id}}" selected>{{$comp->tax_name}}</option>
                                @else
                                    <option value="{{$comp->id}}">{{$comp->tax_name}}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>
                </div>
            </div>

        </div>

        <?php $components = json_decode($edit->component,true); $num = 1; ?>
        @if($edit->component != '')
        @foreach($components as $compa)
            @php $num++ @endphp
            <div class="row clearfix">
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control comp_name_edit" name="salary_comp" >

                                @foreach($salaryComp as $comp)
                                    @if($comp->comp_name == $compa['component'])
                                        <option value="{{$comp->comp_name}}" selected>{{$comp->comp_name}}</option>
                                    @else
                                        <option value="{{$comp->comp_name}}">{{$comp->comp_name}}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="number" class="form-control amount_edit" id="amount_edit{{$num}}" value="{{$compa['amount']}}" name="percentage1" placeholder="Percentage Deduction">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control comp_type_edit" id="comp_edit{{$num}}" onchange="composeSalary('net_pay_edit','amount_edit{{$num}}','comp_edit{{$num}}');" name="comp_type" >

                                @foreach(\App\Helpers\Utility::COMPONENT_TYPE as $val)
                                    @if($val == $compa['component_type'])
                                        <option value="{{$val}}" selected>{{$val}}</option>
                                    @else
                                        <option value="{{$val}}">{{$val}}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>

            </div>
        @endforeach
        @endif
        <div class="row clearfix">


            <div class="col-sm-4" id="hide_button_edit">
                <div class="form-group">
                    <div onclick="addMore('add_more_edit','hide_button_edit','1','<?php echo URL::to('add_more'); ?>','salary_struct_edit','hide_button_edit');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

        </div>

        <div id="add_more_edit"></div>

    </div>


    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>