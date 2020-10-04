
<!-- TAX SYSTEM -->
@if($type == 'tax')

    <div class="row clearfix remove_tax{{$more}} new_taxes">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control comp_name_edit comp_name" name="component_name{{$num2}}" placeholder="Component Name">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control tax_agent_edit tax_agent" name="tax_agent{{$num2}}" placeholder="Tax Agent">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class="form-control percentage_edit percentage" name="percentage{{$num2}}" placeholder="Percentage Deduction">
                </div>
            </div>
        </div>

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','tax','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_tax{{$more}}','{{url('add_more')}}','tax','new_taxes','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

@endif

<!-- SALARY STRUCTURE -->
@if($type == 'salary_struct')

    <div class="row clearfix remove_sal{{$more}} new_sal">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select class="form-control comp_name"  name="salary_comp" >
                        @foreach($salaryComp as $comp)
                            <option value="{{$comp->comp_name}}">{{$comp->comp_name}}</option>
                        @endforeach

                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class="form-control amount" id="amount{{$num2}}" name="amount" placeholder="Amount">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select class="form-control comp_type " id="comp{{$num2}}" onchange="composeSalary('net_pay','amount{{$num2}}','comp{{$num2}}');" name="comp_type" >
                        <option value="">Select Type</option>
                        @foreach(\App\Helpers\Utility::COMPONENT_TYPE as $comp)
                            <option value="{{$comp}}">{{$comp}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','salary_struct','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputSalStr('{{$add_id}}','remove_sal{{$more}}','{{url('add_more')}}','salary_struct','new_sal','{{$more}}','{{$add_id}}','{{$hide_id}}','net_pay','amount{{$num2}}','comp{{$num2}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

    <div id="add_more"></div>

@endif

<!-- SALARY STRUCTURE EDIT -->
@if($type == 'salary_struct_edit')

    <div class="row clearfix remove_sal{{$more}} new_sal">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select class="form-control comp_name_edit "  name="salary_comp" >
                        @foreach($salaryComp as $comp)
                            <option value="{{$comp->comp_name}}">{{$comp->comp_name}}</option>
                        @endforeach

                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class="form-control amount_edit " id="amount_edit{{$num2}}" name="amount" placeholder="Amount">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select class="form-control comp_type_edit" id="comp_edit{{$num2}}" onchange="composeSalary('net_pay_edit','amount_edit{{$num2}}','comp_edit{{$num2}}');" name="comp_type" >
                        <option value="">Select Type</option>
                        @foreach(\App\Helpers\Utility::COMPONENT_TYPE as $comp)
                            <option value="{{$comp}}">{{$comp}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','salary_struct_edit','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputSalStr('{{$add_id}}','remove_sal{{$more}}','{{url('add_more')}}','salary_struct_edit','new_sal','{{$more}}','{{$add_id}}','{{$hide_id}}','net_pay_edit','amount_edit{{$num2}}','comp_edit{{$num2}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

    <div id="add_more"></div>

@endif

<!-- APPROVAL SYSTEM -->
@if($type == 'approval_sys')

    <div class="row clearfix remove_sal{{$more}} new_sal">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">

                    <input type="text" class="form-control " autocomplete="off" id="select_user{{$num2}}" onkeyup="searchOptionList('select_user{{$num2}}','myUL{{$num2}}','{{url('default_select')}}','default_search','user{{$num2}}');" name="select_user" placeholder="Select User">
                    <input type="hidden" class="user_class_edit user_class" name="user" id="user{{$num2}}" />
                </div>
            </div>
            <ul id="myUL{{$num2}}" class="myUL"></ul>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select class="form-control stage_edit stage"  name="stage" >
                        <option value="">select</option>
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

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','approval_sys','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_sal{{$more}}','{{url('add_more')}}','approval_sys','new_sal','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

    <div id="add_more"></div>


@endif

<!-- COMPETENCY CATEGORY -->
@if($type == 'competency_cat')

    <div class="row clearfix remove_competency{{$more}} new_competency">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control department department_edit" name="department{{$num2}}" >
                        <option value="">Department</option>
                        @foreach($dept as $ap)
                            <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control competency competency_edit" name="competency_type{{$num2}}" >
                        <option value="">Competency Type</option>
                        @foreach($compType as $ap)
                            <option value="{{$ap->id}}">{{$ap->skill_comp}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control category category_edit" name="category_name{{$num2}}" placeholder="Category Name">

                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control desc desc_edit" name="description{{$num2}}" placeholder="Description">
                </div>
            </div>
        </div>

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','competency_cat','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_competency{{$more}}','{{url('add_more')}}','competency_cat','new_competency','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

@endif

<!-- COMPETENCY FRAMEWORK -->
@if($type == 'behav_comp')

    <div class="row clearfix remove_behav_comp{{$more}} new_behav_comp">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control department" name="department{{$num2}}" id="dept_behav{{$num2}}" onchange="fillNextInput('dept_behav{{$num2}}','behav_compet{{$num2}}','<?php echo url('default_select'); ?>','dept_frame_behav')">
                        <option value="">Department</option>
                        @foreach($dept as $ap)
                            <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control position" name="position{{$num2}}" >
                        <option value="">Position</option>
                        @foreach($position as $ap)
                            <option value="{{$ap->id}}">{{$ap->position_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line" id="behav_compet{{$num2}}">
                    <select  class="form-control competency_cat"  name="competency_category{{$num2}}" >
                        <option value="">Competency Category</option>

                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control cat_desc" name="cat_desc{{$num2}}" placeholder="Item Description">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control behav_level" name="behav_level{{$num2}}" >
                        <option value="">Level</option>
                        @for($i=0; $i<6; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','behav_comp','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_behav_comp{{$more}}','{{url('add_more')}}','behav_comp','new_behav_comp','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

@endif

@if($type == 'tech_comp')

    <div class="row clearfix remove_tech_comp{{$more}} new_tech_comp">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control department_tech department_tech_edit" name="department{{$num2}}" id="dept_tech{{$num2}}" onchange="fillNextInput('dept_tech{{$num2}}','tech_compet{{$num2}}','<?php echo url('default_select'); ?>','dept_frame_tech')" >
                        <option value="">Department</option>
                        @foreach($dept as $ap)
                            <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control position_tech position_tech_edit" name="position{{$num2}}" >
                        <option value="">Position</option>
                        @foreach($position as $ap)
                            <option value="{{$ap->id}}">{{$ap->position_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line" id="tech_compet{{$num2}}">
                    <select  class="form-control competency_cat_tech competency_cat_tech_edit" name="competency_category{{$num2}}" >
                        <option value="">Competency Category</option>

                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <textarea  class="form-control cat_desc_tech cat_desc_tech_edit" name="cat_desc1{{$num2}}" placeholder="Item Description"></textarea>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control tech_level tech_level_edit" name="tech_level{{$num2}}" >
                        <option value="">Level</option>
                        @for($i=0; $i<6; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','tech_comp','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_tech_comp{{$more}}','{{url('add_more')}}','tech_comp','new_tech_comp','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

@endif

@if($type == 'pro_qual')

    <div class="row clearfix remove_pro_qual{{$more}} new_pro_qual">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control department_pro" name="department{{$num2}}" >
                        <option value="">Department</option>
                        @foreach($dept as $ap)
                            <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control position_pro" name="position{{$num2}}" >
                        <option value="">Position</option>
                        @foreach($position as $ap)
                            <option value="{{$ap->id}}">{{$ap->position_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control min_aca_qual" name="min_aca_qual{{$num2}}" placeholder="Minimum Academic Qualification">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control cog_exp" name="cog_exp{{$num2}}" >
                        <option value="">Cognate Experience</option>
                        @for($i=0; $i<51; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control pro_qual" name="pro_qual{{$num2}}" placeholder="Professional Qualification">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select  class="form-control yr_post_cert" name="yr_post_cert{{$num2}}" >
                        <option value="">Years Post Certification</option>
                        @for($i=0; $i<51; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','pro_qual','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_pro_qual{{$more}}','{{url('add_more')}}','pro_qual','new_pro_qual','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>

@endif

<!-- UNIT GOAL -->
@if($type == 'unit_goal')

    <tr class="row clearfix remove_unit_goal{{$more}} new_unit_goal">
        <td>
            <div class="col-md-10">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" strat_obj strat_obj_edit" name="strat_obj" placeholder="Strategic Objective"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" measure measure_edit" name="measure" placeholder="Measurement"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" q1 q1_edit" name="q1 " placeholder="Target Q1"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" q2 q2_edit" name="q2 " placeholder="Target Q2"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" q3 q3_edit" name="q3" placeholder="Target Q3"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" q4 q4_edit" name="q4" placeholder="Target Q4"></textarea>
                    </div>
                </div>
            </div>
        </td>

        @if($hod == App\Helpers\Utility::HOD_DETECTOR)
        <td>
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" ops ops_edit" name="over_perf_score" placeholder="over_perf_score"></textarea>
                    </div>
                </div>
            </div>
        </td>
        @else
        <td>
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <textarea rows="6" class=" ops ops_edit" disabled name="over_perf_score" placeholder="over_perf_score">
                            Awaiting Score
                        </textarea>
                    </div>
                </div>
            </div>
        </td>
        @endif

        <td class="col-sm-4 addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','unit_goal','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="col-sm-4" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_unit_goal{{$more}}','{{url('add_more')}}','unit_goal','new_unit_goal','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>

@endif

<!-- APP OBJ GOAL -->
@if($type == 'app_obj_goal')

    <tr class="row clearfix remove_app_obj_goal{{$more}} new_app_obj_goal">

                <td>
                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="form-line">
                                <textarea rows="6" cols="40" class=" obj obj_edit" name="obj" placeholder="Objectives"></textarea>
                            </div>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="">
                        <div class="form-group">
                            <div class="form-line">
                                <select  class="form-control obj_level obj_level_edit" name="obj_level" >
                                    <option value="" selected>Level</option>
                                    @foreach(APP\Helpers\Utility::REVIEW_RATE as $key => $val)
                                        <option value="{{$val}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="">
                        <div class="form-group">
                            <div class="form-line">
                                <select  class="form-control rev_rate rev_rate_edit" disabled name="rev_rate" >
                                    <option value="" selected>Reviewer Ratings</option>
                                    @foreach(APP\Helpers\Utility::REVIEW_RATE as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </td>

        <td class=" addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','app_obj_goal','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_app_obj_goal{{$more}}','{{url('add_more')}}','app_obj_goal','new_app_obj_goal','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>

@endif

<!-- COMP ASSESS -->
@if($type == 'comp_assess')

    <tr class="row clearfix remove_comp_assess{{$more}} new_comp_assess">

            <td>
                <div class="col-md-10">
                    <div class="form-group">
                        <div class="form-line">
                            <select class=" core_comp core_comp_edit" name="core_comp" id="core_comp{{$num2}}" onchange="fillNextInput('core_comp{{$num2}}','capable{{$num2}}','<?php echo url('default_select'); ?>','core_tech_comp')">
                                <option value="">Core Technical Competency</option>
                                @foreach($techComp as $ap)
                                    <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </td>

            <td>
                <div class="col-md-10">
                    <div class="form-group">
                        <div class="form-line capable capable_edit" id="capable{{$num2}}" >
                            <select  class="form-control" name="capable"  >
                                <option value="">Capabilities</option>
                            </select>
                        </div>
                    </div>
                </div>
            </td>

                <td>
                    <div class="">
                        <div class="form-group">
                            <div class="form-line">
                                <select  class="form-control comp_level comp_level_edit" name="comp_level" >
                                    <option value="" selected>Level</option>
                                    @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                        <option value="{{$val}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="">
                        <div class="form-group">
                            <div class="form-line">
                                <select  class="form-control comp_rev_rate comp_rev_rate_edit" disabled name="rev_rate" >
                                    <option value="" selected>Reviewer Ratings</option>
                                    @foreach(APP\Helpers\Utility::REVIEW_RATE as $key => $val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </td>


        <td class=" addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','comp_assess','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_comp_assess{{$more}}','{{url('add_more')}}','comp_assess','new_comp_assess','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>

@endif

<!-- COMP ASSESS -->
@if($type == 'behav_comp2')

    <tr class="row clearfix remove_behav_comp2{{$more}} new_behav_comp2">

                <td>
                    <div class="">
                        <div class="form-group">
                            <div class="form-line">
                                <select  class="form-control core_behav_comp core_behav_comp_edit" name="core_behav_comp" id="core_behav_comp{{$num2}}" onchange="fillNextInput('core_behav_comp{{$num2}}','element{{$num2}}','<?php echo url('default_select'); ?>','core_behav_comp')" >
                                    <option value="">Core Behavioural Competency</option>
                                    @foreach($behavComp as $ap)
                                        <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="form-line element element_edit" id="element{{$num2}}" >
                                <select  class="form-control" name="element"  >
                                    <option value="">Elements of behavioural competency</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="">
                        <div class="form-group">
                            <div class="form-line">
                                <select  class="form-control behav_level behav_level_edit" name="behav_level" >
                                    <option value="" selected>Level</option>
                                    @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                        <option value="{{$val}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="">
                        <div class="form-group">
                            <div class="form-line">
                                <select  class="form-control behav_rev_rate behav_rev_rate_edit" disabled name="behav_rev_rate" >
                                    <option value="" selected>Reviewer Ratings</option>
                                    @foreach(APP\Helpers\Utility::REVIEW_RATE2 as $key => $val)
                                        <option value="{{$val}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </td>

        <td class=" addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','behav_comp2','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_behav_comp2{{$more}}','{{url('add_more')}}','behav_comp2','new_behav_comp2','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>

@endif

<!-- IDP COMP ASSESS -->
@if($type == 'idp_comp_assess')

    <tr class="row clearfix remove_comp_assess{{$more}} new_comp_assess">

        <td>
            <div class="col-md-10">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" core_comp core_comp_edit" name="core_comp" id="core_comp{{$num2}}" onchange="fillNextInput('core_comp{{$num2}}','capable{{$num2}}','<?php echo url('default_select'); ?>','core_tech_comp')">
                            <option value="">Core Technical Competency</option>
                            @foreach($techComp as $ap)
                                <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-md-10">
                <div class="form-group">
                    <div class="form-line capable capable_edit" id="capable{{$num2}}" >
                        <select  class="form-control" name="capable"  >
                            <option value="">Capabilities</option>
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control comp_level comp_level_edit" name="comp_level" >
                            <option value="" selected>Level</option>
                            @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                <option value="{{$val}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>


        <td class=" addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','idp_comp_assess','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_comp_assess{{$more}}','{{url('add_more')}}','idp_comp_assess','new_comp_assess','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>

@endif

<!-- START OF ADDING ZONES TO WAREHOUSE -->
@if($type == 'warehouse_zone')
    <div class="row clearfix new_warehouse_zone remove_warehouse_zone{{$more}}"  >
        <div class="col-sm-4">
            <b>Zone</b>
            <div class="form-group">
                <div class="form-line">
                    <select class="form-control warehouse_zone" name="zone{{$num2}}" >
                        <option value="">Select</option>
                        @foreach($zone as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class=" addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','warehouse_zone','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_warehouse_zone{{$more}}','{{url('add_more')}}','warehouse_zone','new_warehouse_zone','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>
    </div>

@endif
<!-- END OF ADDING END OF ADDING ZONES TO WAREHOUSE -->

<!-- START OF ADDING BIN TO WAREHOUSE ZONES -->
@if($type == 'zone_bin')
    <div class="row clearfix new_zone_bin remove_zone_bin{{$more}}"  >
        <div class="col-sm-4">
            <b>Zone</b>
            <div class="form-group">
                <div class="form-line">
                    <select class="form-control zone_bin" name="bin{{$num2}}" >
                        <option value="">Select</option>
                        @foreach($bin as $type)
                            <option value="{{$type->id}}">{{$type->code}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class=" addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','zone_bin','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_zone_bin{{$more}}','{{url('add_more')}}','zone_bin','new_zone_bin','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>
@endif
<!-- END OF ADDING BIN TO WAREHOUSE ZONES -->

<!-- START OF ADDING BILL OF MATERIALS -->
@if($type == 'bom_inv')
<div class="row clearfix new_inv_bom remove_inv_bom{{$more}}"  >

    <div class="col-sm-4">
        Inventory Item
        <div class="form-group">
            <div class="form-line">
                <input type="text" class="form-control" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionList('select_inv{{$num2}}','myUL{{$num2}}','{{url('default_select')}}','search_inventory','inv{{$num2}}');" name="select_inventory" placeholder="Select Inventory Item">

                <input type="hidden" class="inv_class " name="inventory" id="inv{{$num2}}" />
            </div>
        </div>
        <ul id="myUL{{$num2}}" class="myUL"></ul>
    </div>

    <div class="col-sm-4">
        <b>Quantity</b>
        <div class="form-group">
            <div class="form-line">
                <input type="number" class="form-control bom_qty  bom_qty_class" name="bom_qty" id="bom_qty{{$num2}}" onkeyup="extendedAmount('inv{{$num2}}','{{url('ext_amount')}}','ext_amount{{$num2}}','bom_qty{{$num2}}','bom_qty_class','bom_amt','unit_cost')" placeholder="Quantity" >
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <b>Amount</b>
        <div class="input-group">
            <span class="input-group-addon">{{Utility::defaultCurrency()}}</span>
            <div class="form-line">
                <input type="text" class="form-control bom_amount  bom_amt" id="ext_amount{{$num2}}"  name="bom_amount" placeholder="Amount" >
            </div>
        </div>
    </div>

    <div class=" addButtons" id="{{$hide_id}}{{$more}}">
        <div class="form-group">
            <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','bom_inv','{{$hide_id}}');">
                <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
            </div>
        </div>
    </div>

    <div class="" id="">
        <div class="form-group">
            <div style="cursor: pointer;" onclick="removeInputInv('{{$add_id}}','remove_inv_bom{{$more}}','{{url('add_more')}}','bom_inv','new_inv_bom','{{$more}}','{{$add_id}}','{{$hide_id}}','ext_amount{{$num2}}','unit_cost');">
                <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
            </div>
        </div>
    </div>

</div>
@endif

<!-- ADD MORE BOM IN EDIT FORM -->
@if($type == 'bom_inv_edit')
    <div class="row clearfix new_inv_bom remove_inv_bom{{$more}}"  >

        <div class="col-sm-4">
            Inventory Item
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionList('select_inv{{$num2}}','myUL{{$num2}}','{{url('default_select')}}','search_inventory','inv{{$num2}}');" name="select_user" placeholder="Select User">

                    <input type="hidden" class="inv_class inv_class_edit" name="user" id="inv{{$num2}}" />
                </div>
            </div>
            <ul id="myUL{{$num2}}" class="myUL"></ul>
        </div>

        <div class="col-sm-4">
            <b>Quantity</b>
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class="form-control bom_qty_edit bom_qty_class_edit" name="bom_qty" id="bom_qty{{$num2}}" onkeyup="extendedAmount('inv{{$num2}}','{{url('ext_amount')}}','ext_amount{{$num2}}','bom_qty{{$num2}}','bom_qty_class_edit','bom_amt_edit','unit_cost_edit')" placeholder="Quantity" >
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <b>Amount</b>
            <div class="input-group">
                <span class="input-group-addon">{{$currSymbol}}</span>
                <div class="form-line">
                    <input type="text" class="form-control bom_amount_edit bom_amt_edit" id="ext_amount{{$num2}}"  name="bom_amount" placeholder="Amount" >
                </div>
            </div>
        </div>

        <div class=" addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','bom_inv_edit','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputInv('{{$add_id}}','remove_inv_bom{{$more}}','{{url('add_more')}}','bom_inv_edit','new_inv_bom','{{$more}}','{{$add_id}}','{{$hide_id}}','ext_amount{{$num2}}','unit_cost_edit');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>
@endif
<!-- END OF ADDING BILL OF MATERIALS -->

<!-- START OF ADDING ITEMS TO CONTRACT -->
@if($type == 'contract_item')
    <div class="row clearfix new_inv_bom remove_inv_bom{{$more}}"  >

        <div class="col-sm-4">
            Inventory Item
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionList('select_inv{{$num2}}','myUL{{$num2}}','{{url('default_select')}}','search_inventory','inv{{$num2}}');" name="select_inventory" placeholder="Select Inventory Item">

                    <input type="hidden" class="inv_class" name="inventory" id="inv{{$num2}}" />
                </div>
            </div>
            <ul id="myUL{{$num2}}" class="myUL"></ul>
        </div>

        <div class="col-sm-2">
            <b>Quantity</b>
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class="form-control bom_qty bom_qty_class" name="bom_qty" id="bom_qty{{$num2}}" onkeyup="extendedAmount('inv{{$num2}}','{{url('ext_amount')}}','ext_amount{{$num2}}','bom_qty{{$num2}}','bom_qty_class','bom_amt','unit_cost')" placeholder="Quantity" >
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <b>Amount</b>
            <div class="input-group">
                <span class="input-group-addon">{{$currSymbol}}</span>
                <div class="form-line">
                    <input type="text" class="form-control bom_amount bom_amt" id="ext_amount{{$num2}}"  name="bom_amount" placeholder="Amount" >
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <b>Servicing Interval(Days)</b>
            <div class="input-group">
                <div class="form-line">
                    <input type="text" class="form-control bom_servicing bom_servicing_class" id=""  name="bom_servicing" placeholder="Servicing Interval" >
                </div>
            </div>
        </div>

        <div class=" addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','contract_item','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputInv('{{$add_id}}','remove_inv_bom{{$more}}','{{url('add_more')}}','contract_item','new_inv_bom','{{$more}}','{{$add_id}}','{{$hide_id}}','ext_amount{{$num2}}','unit_cost');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>
@endif

<!-- START OF ADDING ITEMS TO CONTRACT -->
@if($type == 'contract_item_edit')
    <div class="row clearfix new_inv_bom remove_inv_bom{{$more}}"  >

        <div class="col-sm-4">
            Inventory Item
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionList('select_inv{{$num2}}','myUL{{$num2}}','{{url('default_select')}}','search_inventory','inv{{$num2}}');" name="select_inventory" placeholder="Select Inventory Item">

                    <input type="hidden" class=" inv_class_edit" name="inventory" id="inv{{$num2}}" />
                </div>
            </div>
            <ul id="myUL{{$num2}}" class="myUL"></ul>
        </div>

        <div class="col-sm-2">
            <b>Quantity</b>
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class="form-control bom_qty_edit bom_qty_class_edit" name="bom_qty" id="bom_qty{{$num2}}" onkeyup="extendedAmount('inv{{$num2}}','{{url('ext_amount')}}','ext_amount{{$num2}}','bom_qty{{$num2}}','bom_qty_class_edit','bom_amt_edit','unit_cost_edit')" placeholder="Quantity" >
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <b>Amount</b>
            <div class="input-group">
                <span class="input-group-addon">{{$currSymbol}}</span>
                <div class="form-line">
                    <input type="text" class="form-control bom_amount_edit bom_amt_edit" id="ext_amount{{$num2}}"  name="bom_amount" placeholder="Amount" >
                </div>
            </div>
        </div>

        <div class="col-sm-2">
            <b>Servicing Interval(Days)</b>
            <div class="input-group">
                <div class="form-line">
                    <input type="text" class="form-control bom_servicing_edit bom_servicing_class_edit" id=""  name="bom_servicing" placeholder="Servicing Interval" >
                </div>
            </div>
        </div>

        <div class=" addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','contract_item','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputInv('{{$add_id}}','remove_inv_bom{{$more}}','{{url('add_more')}}','contract_item','new_inv_bom','{{$more}}','{{$add_id}}','{{$hide_id}}','ext_amount{{$num2}}','unit_cost');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>
@endif


<!-- BEGIN OF ASSIGNING INVENTORY -->
@if($type == 'assign_inv')

    <div class="row clearfix new_inv_assign remove_inv_assign{{$more}}">
    <div class="row clearfix ">
        <div class="col-sm-4">
            Inventory Item
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionList('select_inv{{$num2}}','myUL500{{$num2}}','{{url('default_select')}}','search_inventory','inv500{{$num2}}');" name="select_user" placeholder="Inventory Item">

                    <input type="hidden" class="inv_class" value="" name="user" id="inv500{{$num2}}" />
                </div>
            </div>
            <ul id="myUL500{{$num2}}" class="myUL"></ul>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control" autocomplete="off" id="select_user{{$num2}}" onkeyup="searchOptionList('select_user{{$num2}}','myUL1{{$num2}}','{{url('default_select')}}','default_search','user{{$num2}}');" name="select_user" placeholder="Select User">

                    <input type="hidden" class="user_class" name="user" id="user{{$num2}}" />
                </div>
            </div>
            <ul id="myUL1{{$num2}}" class="myUL"></ul>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control qty" name="quantity" placeholder="Quantity">
                </div>
            </div>
        </div>

    </div>

    <div class="row clearfix">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control location" name="location" placeholder="Location">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control assign_desc" name="assign_desc" placeholder="Description">
                </div>
            </div>
        </div>

        <div class=" addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','assign_inv','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_inv_assign{{$more}}','{{url('add_more')}}','assign_inv','new_inv_assign','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>
    <hr/>
</div>

@endif
<!-- END OF ASSIGNING INVENTORY -->

<!-- BEGIN OF PURCHASE ORDER -->
@if($type == 'po')
<tr class="row clearfix new_po remove_po{{$more}}">

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionListInventory('select_inv{{$num2}}','myUL500{{$num2}}','{{url('default_select')}}','search_inventory_transact','inv500{{$num2}}','item_desc{{$num2}}','unit_cost{{$num2}}','unit_measure{{$num2}}','sub_total{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','qty{{$num2}}','vendorCust','posting_date','total_tax_amount','{{\App\Helpers\Utility::PURCHASE_DESC}}');" name="select_user" placeholder="Inventory Item">

                    <input type="hidden" class="inv_class " value="" name="user" id="inv500{{$num2}}" />
                </div>
            </div>
            <ul id="myUL500{{$num2}}" class="myUL"></ul>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <textarea class=" item_desc " name="item_desc" id="item_desc{{$num2}}" placeholder="Description"></textarea>
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select class=" warehouse " name="warehouse" >
                        <option value="">Select Receipt Warehouse</option>
                        @foreach($warehouse as $inv)
                            <option value="{{$inv->id}}">{{$inv->name}} ({{$inv->code}})</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class=" quantity " name="quantity" id="qty{{$num2}}" placeholder="Quantity"
                           onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class=" unit_cost " name="unit_cost" id="unit_cost{{$num2}}" placeholder="Unit Cost/Rate"
                           onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class=" unit_measure " readonly name="unit_measure" id="unit_measure{{$num2}}" placeholder="Unit Measure" >
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class=" quantity_reserved " name="quantity_reserved" id="qty_res{{$num2}}" placeholder="Quantity" >
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class=" quantity_received" name="quantity_received" id="qty_rec" placeholder="Quantity" >
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class=" datepicker2 planned " name="planned_date" placeholder="Planned Date" >
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class=" datepicker2 expected " name="expected_date" placeholder="Expected Date" >
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class=" datepicker2 promised " name="promised_date" placeholder="Promised Date" required>
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class=" b_order_no " name="blanket_order_no" id="" placeholder="Blanket Order Number" >
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class=" b_order_line_no " name="blanket_order_line_no" id="" placeholder="Blanket Order Line No" >
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select class=" ship_status " name="ship_status" >
                        <option value="">Select</option>
                        @foreach(\App\Helpers\Utility::SHIP_STATUS as $key => $val)
                            <option value="{{$key}}">{{$val}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class=" status_comment " name="status_comment" id="" placeholder="Comment on ship status" >
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <select class=" tax " name="tax" id="tax{{$num2}}"
                            onchange="fillNextInputTax('tax{{$num2}}','tax_perct{{$num2}}','{{url('default_select')}}','get_tax','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                        <option value="">Select</option>
                        @foreach($tax as $inv)
                            <option value="{{$inv->id}}">{{$inv->tax_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class=" tax_perct " name="tax_perct" id="tax_perct{{$num2}}" placeholder="Tax Percentage"
                           onkeyup="percentToAmount('tax_perct{{$num2}}','tax_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')">
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class="tax_amount shared_tax_amount " name="tax_amount" id="tax_amount{{$num2}}" placeholder="Tax Amount"
                           onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class=" discount_perct " name="discount_perct" id="discount_perct{{$num2}}" placeholder="Discount Percentage"
                           onkeyup="percentToAmount('discount_perct{{$num2}}','discount_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')">
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class=" discount_amount  shared_discount_amount " name="discount_amount" id="discount_amount{{$num2}}" placeholder="Discount Amount"
                           onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                </div>
            </div>
        </div>
    </td>

    <td>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class=" sub_total  shared_sub_total " readonly name="sub_total" id="sub_total{{$num2}}" placeholder="Sub Total" >
                </div>
            </div>
        </div>
    </td>

    <td></td>

    <td class=" addButtons center-align" id="{{$hide_id}}{{$more}}">
        <div class="form-group">
            <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','po','{{$hide_id}}');">
                <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
            </div>
        </div>
    </td>

    <td class="center-align" id="">
        <div class="form-group">
            <div style="cursor: pointer;" onclick="removeInputCalc('{{$add_id}}','remove_po{{$more}}','{{url('add_more')}}','po','new_po','{{$more}}','{{$add_id}}','{{$hide_id}}','sub_total{{$num2}}','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date');">
                <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
            </div>
        </div>
    </td>

</tr>
@endif
<!-- END OF PURCHASE ORDER -->

<!-- BEGIN OF SALES ORDER -->
@if($type == 'sales')
    <tr class="row clearfix new_sales remove_sales{{$more}}">

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionListInventory('select_inv{{$num2}}','myUL500{{$num2}}','{{url('default_select')}}','search_inventory_transact','inv500{{$num2}}','item_desc{{$num2}}','unit_cost{{$num2}}','unit_measure{{$num2}}','sub_total{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','qty{{$num2}}','vendorCust','posting_date','total_tax_amount','{{\App\Helpers\Utility::PURCHASE_DESC}}');" name="select_user" placeholder="Inventory Item">

                        <input type="hidden" class="inv_class " value="" name="user" id="inv500{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL500{{$num2}}" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class=" item_desc " name="item_desc" id="item_desc{{$num2}}" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" warehouse " name="warehouse" >
                            <option value="">Ship From Warehouse</option>
                            @foreach($warehouse as $inv)
                                <option value="{{$inv->id}}">{{$inv->name}} ({{$inv->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" quantity " name="quantity" id="qty{{$num2}}" placeholder="Quantity"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" unit_cost " name="unit_cost" id="unit_cost{{$num2}}" placeholder="Unit Cost/Rate"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" unit_measure " readonly name="unit_measure" id="unit_measure{{$num2}}" placeholder="Unit Measure" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" quantity_reserved " name="quantity_reserved" id="qty_res{{$num2}}" placeholder="Quantity" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" quantity_shipped" name="quantity_shipped" id="qty_rec" placeholder="Quantity" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" datepicker2 planned " name="planned_date" placeholder="Planned Date" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" datepicker2 expected " name="expected_date" placeholder="Expected Date" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" datepicker2 promised " name="promised_date" placeholder="Promised Date" required>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" b_order_no " name="blanket_order_no" id="" placeholder="Blanket Order Number" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" b_order_line_no " name="blanket_order_line_no" id="" placeholder="Blanket Order Line No" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" ship_status " name="ship_status" >
                            <option value="">Select</option>
                            @foreach(\App\Helpers\Utility::SHIP_STATUS as $key => $val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" status_comment " name="status_comment" id="" placeholder="Comment on ship status" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" tax " name="tax" id="tax{{$num2}}"
                                onchange="fillNextInputTax('tax{{$num2}}','tax_perct{{$num2}}','{{url('default_select')}}','get_tax','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                            <option value="">Select</option>
                            @foreach($tax as $inv)
                                <option value="{{$inv->id}}">{{$inv->tax_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" tax_perct " name="tax_perct" id="tax_perct{{$num2}}" placeholder="Tax Percentage"
                               onkeyup="percentToAmount('tax_perct{{$num2}}','tax_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="tax_amount shared_tax_amount " name="tax_amount" id="tax_amount{{$num2}}" placeholder="Tax Amount"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" discount_perct " name="discount_perct" id="discount_perct{{$num2}}" placeholder="Discount Percentage"
                               onkeyup="percentToAmount('discount_perct{{$num2}}','discount_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" discount_amount  shared_discount_amount " name="discount_amount" id="discount_amount{{$num2}}" placeholder="Discount Amount"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" sub_total  shared_sub_total " readonly name="sub_total" id="sub_total{{$num2}}" placeholder="Sub Total" >
                    </div>
                </div>
            </div>
        </td>

        <td></td>

        <td class=" addButtons center-align" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','sales','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="center-align" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputCalc('{{$add_id}}','remove_sales{{$more}}','{{url('add_more')}}','sales','new_sales','{{$more}}','{{$add_id}}','{{$hide_id}}','sub_total{{$num2}}','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>
@endif
<!-- END OF SALES ORDER -->

<!-- BEGIN OF ACCOUNT PART -->
@if($type == 'acc')
    <tr class="row clearfix new_acc remove_acc{{$more}}">

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_acc{{$num2}}" onkeyup="searchOptionListAcc('select_acc{{$num2}}','myUL500_acc{{$num2}}','{{url('default_select')}}','search_accounts','acc500{{$num2}}','vendorCust_edit','posting_date');" name="select_user" placeholder="Select Account">

                        <input type="hidden" class="acc_class " value="" name="user" id="acc500{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL500_acc{{$num2}}" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class=" acc_desc " name="item_desc" id="item_desc_acc{{$num2}}" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" shared_rate acct_rate " name="unit_cost" id="unit_cost_acc{{$num2}}" placeholder="Rate/Cost Amount"
                               onkeyup="accountSum('sub_total_acc{{$num2}}','acc500{{$num2}}','unit_cost_acc{{$num2}}','discount_amount_acc{{$num2}}','tax_amount_acc{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct_acc{{$num2}}','discount_perct_acc{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" acc_tax shared_tax " name="tax" id="tax_acc{{$num2}}"
                                onchange="fillNextInputTaxAcc('tax_acc{{$num2}}','tax_perct_acc{{$num2}}','{{url('default_select')}}','get_tax','sub_total_acc{{$num2}}','unit_cost_acc{{$num2}}','acc500{{$num2}}','discount_amount_acc{{$num2}}','tax_amount_acc{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct_acc{{$num2}}','discount_perct_acc{{$num2}}')">
                            <option value="">Select Tax</option>
                            @foreach($tax as $inv)
                                <option value="{{$inv->id}}">{{$inv->tax_name}}</option>
                            @endforeach
                            <option value="">Enter tax Manually</option>
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" acc_tax_perct shared_tax_perct " name="tax_perct" id="tax_perct_acc{{$num2}}" placeholder="Tax Percentage"
                               onkeyup="percentToAmount('tax_perct_acc{{$num2}}','tax_amount_acc{{$num2}}','sub_total_acc{{$num2}}','unit_cost_acc{{$num2}}','acc500{{$num2}}','','discount_amount_acc{{$num2}}','tax_amount_acc{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" acc_tax_amount shared_tax_amount  " name="tax_amount" id="tax_amount_acc{{$num2}}" placeholder="Tax Amount"
                               onkeyup="accountSum('sub_total_acc{{$num2}}','acc500{{$num2}}','unit_cost_acc{{$num2}}','discount_amount_acc{{$num2}}','tax_amount_acc{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct_acc{{$num2}}','discount_perct_acc{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" acc_discount_perct shared_discount_perct " name="discount_perct" id="discount_perct_acc{{$num2}}" placeholder="Discount Percentage"
                               onkeyup="percentToAmount('discount_perct_acc{{$num2}}','discount_amount_acc{{$num2}}','sub_total_acc{{$num2}}','unit_cost_acc{{$num2}}','acc500{{$num2}}','','discount_amount_acc{{$num2}}','tax_amount_acc{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" acc_discount_amount shared_discount_amount " name="discount_amount" id="discount_amount_acc{{$num2}}" placeholder="Discount Amount"
                               onkeyup="accountSum('sub_total_acc{{$num2}}','acc500{{$num2}}','unit_cost_acc{{$num2}}','discount_amount_acc{{$num2}}','tax_amount_acc{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct_acc{{$num2}}','discount_perct_acc{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" acc_sub_total shared_sub_total" readonly name="sub_total" id="sub_total_acc{{$num2}}" placeholder="Sub Total" >
                    </div>
                </div>
            </div>
        </td>
        <td></td>

        <td class=" addButtons center-align" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','acc','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="center-align" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputCalc('{{$add_id}}','remove_acc{{$more}}','{{url('add_more')}}','acc','new_acc','{{$more}}','{{$add_id}}','{{$hide_id}}','sub_total_acc{{$num2}}','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>
@endif
<!-- END OF ACCOUNT PART -->

<!-- BEGIN OF ACCOUNT PART EDIT -->
@if($type == 'acc_edit')
    <tr class="row clearfix new_acc_edit remove_acc_edit{{$more}}">

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_acc{{$num2}}" onkeyup="searchOptionListAcc('select_acc{{$num2}}','myUL500_acc{{$num2}}','{{url('default_select')}}','search_accounts','acc500{{$num2}}','vendorCust_edit','posting_date_edit');" name="select_user" placeholder="Select Account">

                        <input type="hidden" class=" acc_class_edit" value="" name="user" id="acc500{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL500_acc{{$num2}}" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class=" acc_desc_edit" name="acc_desc" id="item_desc_acc{{$num2}}" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="  acc_rate_edit" name="unit_cost" id="unit_cost_acc{{$num2}}" placeholder="Rate/Cost Amount"
                               onkeyup="accountSum('sub_total_acc{{$num2}}','acc500{{$num2}}','unit_cost_acc{{$num2}}','discount_amount_acc{{$num2}}','tax_amount_acc{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_amount_acc{{$num2}}','discount_amount_acc{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" acc_tax shared_tax acc_tax_edit" name="tax" id="tax_acc{{$num2}}"
                                onchange="fillNextInputTaxAcc('tax_acc{{$num2}}','tax_perct_acc{{$num2}}','{{url('default_select')}}','get_tax','sub_total_acc{{$num2}}','unit_cost_acc{{$num2}}','acc500{{$num2}}','discount_amount_acc{{$num2}}','tax_amount_acc{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct_acc{{$num2}}','discount_perct_acc{{$num2}}')">
                           <option value="">Select Tax</option>
                            @foreach($tax as $inv)
                                <option value="{{$inv->id}}">{{$inv->tax_name}}</option>
                            @endforeach
                            <option value="">Enter tax Manually</option>
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" acc_tax_perct shared_tax_perct acc_tax_perct_edit" name="tax_perct" id="tax_perct_acc{{$num2}}" placeholder="Tax Percentage"
                               onkeyup="percentToAmount('tax_perct_acc{{$num2}}','tax_amount_acc{{$num2}}','sub_total_acc{{$num2}}','unit_cost_acc{{$num2}}','acc500{{$num2}}','','discount_amount_acc{{$num2}}','tax_amount_acc{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" acc_tax_amount shared_tax_amount shared_tax_amount_edit acc_tax_amount_edit" name="tax_amount" id="tax_amount_acc{{$num2}}" placeholder="Tax Amount"
                               onkeyup="accountSum('sub_total_acc{{$num2}}','acc500{{$num2}}','unit_cost_acc{{$num2}}','discount_amount_acc{{$num2}}','tax_amount_acc{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_amount_acc{{$num2}}','discount_amount_acc{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" acc_discount_perct shared_discount_perct acc_discount_perct_edit" name="discount_perct" id="discount_perct_acc{{$num2}}" placeholder="Discount Percentage"
                               onkeyup="percentToAmount('discount_perct_acc{{$num2}}','discount_amount_acc{{$num2}}','sub_total_acc{{$num2}}','unit_cost_acc{{$num2}}','acc500{{$num2}}','','discount_amount_acc{{$num2}}','tax_amount_acc{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" acc_discount_amount shared_discount_amount shared_discount_amount_edit acc_discount_amount_edit" name="discount_amount" id="discount_amount_acc{{$num2}}" placeholder="Discount Amount"
                               onkeyup="accountSum('sub_total_acc{{$num2}}','acc500{{$num2}}','unit_cost_acc{{$num2}}','discount_amount_acc{{$num2}}','tax_amount_acc{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_amount_acc{{$num2}}','discount_amount_acc{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" acc_sub_total_edit shared_sub_total_edit" readonly name="sub_total" id="sub_total_acc{{$num2}}" placeholder="Sub Total" >
                    </div>
                </div>
            </div>
        </td>
        <td></td>

        <td class=" addButtons center-align" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','acc_edit','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="center-align" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputCalc('{{$add_id}}','remove_acc_edit{{$more}}','{{url('add_more')}}','acc_edit','new_acc_edit','{{$more}}','{{$add_id}}','{{$hide_id}}','sub_total_acc{{$num2}}','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>
@endif
<!-- END OF ACCOUNT PART EDIT  -->

<!-- BEGIN OF PURCHASE ORDER EDIT -->
@if($type == 'po_edit')
    <tr class="row clearfix new_po_edit remove_po_edit{{$more}}">

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionListInventory('select_inv{{$num2}}','myUL500{{$num2}}','{{url('default_select')}}','search_inventory_transact','inv500{{$num2}}','item_desc{{$num2}}','unit_cost{{$num2}}','unit_measure{{$num2}}','sub_total{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','qty{{$num2}}','vendorCust_edit','posting_date_edit','total_tax_amount_edit','{{\App\Helpers\Utility::PURCHASE_DESC}}');" name="select_user" placeholder="Inventory Item">

                        <input type="hidden" class="inv_class inv_class_edit" value="" name="user" id="inv500{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL500{{$num2}}" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class=" item_desc item_desc_edit" name="item_desc" id="item_desc{{$num2}}" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" warehouse warehouse_edit" name="warehouse" >
                            <option value="">Select Receipt Warehouse</option>
                            @foreach($warehouse as $inv)
                                <option value="{{$inv->id}}">{{$inv->name}} ({{$inv->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" quantity quantity_edit" name="quantity" id="qty{{$num2}}" placeholder="Quantity"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" unit_cost unit_cost_edit"  name="unit_cost" id="unit_cost{{$num2}}" placeholder="Unit Cost/Rate"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" unit_measure unit_measure_edit" readonly name="unit_measure" id="unit_measure{{$num2}}" placeholder="Unit Measure" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" quantity_reserved quantity_reserved_edit" name="quantity_reserved" id="qty_res{{$num2}}" placeholder="Quantity" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" quantity_received" name="quantity_received" id="qty_rec" placeholder="Quantity" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" datepicker2 planned planned_edit" name="planned_date" placeholder="Planned Date" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" datepicker2 expected expected_edit" name="expected_date" placeholder="Expected Date" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" datepicker2 promised promised_edit" name="promised_date" placeholder="Promised Date" required>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" b_order_no b_order_no_edit" name="blanket_order_no" id="" placeholder="Blanket Order Number" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" b_order_line_no b_order_line_no_edit" name="blanket_order_line_no" id="" placeholder="Blanket Order Line No" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" ship_status ship_status_edit" name="ship_status" >
                            <option value="">Select Ship Status</option>
                            @foreach(\App\Helpers\Utility::SHIP_STATUS as $key => $val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" status_comment status_comment_edit" name="status_comment" id="" placeholder="Comment on ship status" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" tax tax_edit" name="tax" id="tax{{$num2}}"
                                onchange="fillNextInputTax('tax{{$num2}}','tax_perct{{$num2}}','{{url('default_select')}}','get_tax','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                            <option value="">Select Tax</option>
                            @foreach($tax as $inv)
                                <option value="{{$inv->id}}">{{$inv->tax_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" tax_perct tax_perct_edit" name="tax_perct" id="tax_perct{{$num2}}" placeholder="Tax Percentage"
                               onkeyup="percentToAmount('tax_perct{{$num2}}','tax_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="tax_amount tax_amount_edit shared_tax_amount shared_tax_amount_edit" name="tax_amount" id="tax_amount{{$num2}}" placeholder="Tax Amount"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" discount_perct discount_perct_edit" name="discount_perct" id="discount_perct{{$num2}}" placeholder="Discount Percentage"
                               onkeyup="percentToAmount('discount_perct{{$num2}}','discount_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" discount_amount discount_amount_edit shared_discount_amount shared_discount_amount_edit" name="discount_amount" id="discount_amount{{$num2}}" placeholder="Discount Amount"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="sub_total_edit  shared_sub_total_edit" readonly name="sub_total" id="sub_total{{$num2}}" placeholder="Sub Total" >
                    </div>
                </div>
            </div>
        </td>

        <td></td>

        <td class=" addButtons center-align" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','po_edit','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="center-align" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputCalc('{{$add_id}}','remove_po_edit{{$more}}','{{url('add_more')}}','po_edit','new_po_edit','{{$more}}','{{$add_id}}','{{$hide_id}}','sub_total{{$num2}}','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>
@endif
<!-- END OF PURCHASE ORDER EDIT -->

<!-- BEGIN OF SALES ORDER EDIT -->
@if($type == 'sales_edit')
    <tr class="row clearfix new_sales_edit remove_sales_edit{{$more}}">

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionListInventory('select_inv{{$num2}}','myUL500{{$num2}}','{{url('default_select')}}','search_inventory_transact','inv500{{$num2}}','item_desc{{$num2}}','unit_cost{{$num2}}','unit_measure{{$num2}}','sub_total{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','qty{{$num2}}','vendorCust_edit','posting_date_edit','total_tax_amount_edit','{{\App\Helpers\Utility::PURCHASE_DESC}}');" name="select_user" placeholder="Inventory Item">

                        <input type="hidden" class=" inv_class_edit" value="" name="user" id="inv500{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL500{{$num2}}" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="  item_desc_edit" name="item_desc" id="item_desc{{$num2}}" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="  warehouse_edit" name="warehouse" >
                            <option value="">Ship From Warehouse</option>
                            @foreach($warehouse as $inv)
                                <option value="{{$inv->id}}">{{$inv->name}} ({{$inv->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="  quantity_edit" name="quantity" id="qty{{$num2}}" placeholder="Quantity"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="  unit_cost_edit"  name="unit_cost" id="unit_cost{{$num2}}" placeholder="Unit Cost/Rate"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="  unit_measure_edit" readonly name="unit_measure" id="unit_measure{{$num2}}" placeholder="Unit Measure" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="  quantity_reserved_edit" name="quantity_reserved" id="qty_res{{$num2}}" placeholder="Quantity" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" quantity_shipped_edit" name="quantity_shipped" id="qty_rec" placeholder="Quantity" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" datepicker2  planned_edit" name="planned_date" placeholder="Planned Date" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" datepicker2  expected_edit" name="expected_date" placeholder="Expected Date" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" datepicker2  promised_edit" name="promised_date" placeholder="Promised Date" required>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="  b_order_no_edit" name="blanket_order_no" id="" placeholder="Blanket Order Number" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="  b_order_line_no_edit" name="blanket_order_line_no" id="" placeholder="Blanket Order Line No" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="  ship_status_edit" name="ship_status" >
                            <option value="">Select Ship Status</option>
                            @foreach(\App\Helpers\Utility::SHIP_STATUS as $key => $val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="  status_comment_edit" name="status_comment" id="" placeholder="Comment on ship status" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" tax_edit" name="tax" id="tax{{$num2}}"
                                onchange="fillNextInputTax('tax{{$num2}}','tax_perct{{$num2}}','{{url('default_select')}}','get_tax','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                            <option value="">Select Tax</option>
                            @foreach($tax as $inv)
                                <option value="{{$inv->id}}">{{$inv->tax_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="  tax_perct_edit" name="tax_perct" id="tax_perct{{$num2}}" placeholder="Tax Percentage"
                               onkeyup="percentToAmount('tax_perct{{$num2}}','tax_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" tax_amount_edit shared_tax_amount shared_tax_amount_edit" name="tax_amount" id="tax_amount{{$num2}}" placeholder="Tax Amount"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="  discount_perct_edit" name="discount_perct" id="discount_perct{{$num2}}" placeholder="Discount Percentage"
                               onkeyup="percentToAmount('discount_perct{{$num2}}','discount_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="  discount_amount_edit shared_discount_amount shared_discount_amount_edit" name="discount_amount" id="discount_amount{{$num2}}" placeholder="Discount Amount"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="sub_total_edit  shared_sub_total_edit" readonly name="sub_total" id="sub_total{{$num2}}" placeholder="Sub Total" >
                    </div>
                </div>
            </div>
        </td>

        <td></td>

        <td class=" addButtons center-align" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','sales_edit','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="center-align" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputCalc('{{$add_id}}','remove_sales_edit{{$more}}','{{url('add_more')}}','sales_edit','new_sales_edit','{{$more}}','{{$add_id}}','{{$hide_id}}','sub_total{{$num2}}','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>
@endif
<!-- END OF SALES ORDER EDIT -->

<!-- BEGIN OF RFQ ACCOUNT PART EDIT -->
@if($type == 'acc_rfq')
    <tr class="row clearfix new_acc_rfq remove_acc_rfq{{$more}}">

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_acc{{$num2}}" onkeyup="searchOptionListAcc('select_acc{{$num2}}','myUL500_acc{{$num2}}','{{url('default_select')}}','search_accounts','acc500{{$num2}}');" name="select_user" placeholder="Select Account">

                        <input type="hidden" class="acc_class acc_class_edit" value="" name="user" id="acc500{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL500_acc{{$num2}}" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="acc_desc acc_desc_edit" name="acc_desc" id="item_desc{{$num2}}" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td class=" addButtons center-align" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','acc_rfq','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="center-align" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_acc_rfq{{$more}}','{{url('add_more')}}','acc_rfq','new_acc_rfq','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>
@endif
<!-- END OF ACCOUNT PART -->

<!-- BEGIN OF RFQ -->
@if($type == 'rfq')
    <tr class="row clearfix new_rfq remove_rfq{{$more}}">

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionList('select_inv{{$num2}}','myUL500{{$num2}}','{{url('default_select')}}','search_inventory','inv500{{$num2}}');" name="select_user" placeholder="Inventory Item">

                        <input type="hidden" class="inv_class inv_class_edit" value="" name="user" id="inv500{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL500{{$num2}}" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class=" item_desc " name="item_desc item_desc_edit" id="item_desc{{$num2}}" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" quantity quantity_edit" name="quantity" id="qty{{$num2}}" placeholder="Quantity" />
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select name="unit_measure"  class="unit_measure unit_measure_edit" id="" id="unit_measure{{$num2}}" >
                            <option value="">Select Unit OF measurement</option>
                            @foreach($unitMeasure as $data)
                                <option value="{{$data->unit_name}}">{{$data->unit_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td class=" addButtons center-align" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','rfq','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="center-align" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputCalc('{{$add_id}}','remove_rfq{{$more}}','{{url('add_more')}}','rfq','new_rfq','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>
@endif
<!-- END OF RFQ -->


<!-- BEGIN OF INVENTORY ITEM TEMPLATE FOR PURCHASE -->
@if($type == 'get_inv')
    <tr class="row clearfix new_inv remove_inv{{$more}}">

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionListInventory('select_inv{{$num2}}','myUL500{{$num2}}','{{url('default_select')}}','search_inventory_transact','inv500{{$num2}}','item_desc{{$num2}}','unit_cost{{$num2}}','unit_measure{{$num2}}','sub_total{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','qty{{$num2}}','vendorCust','posting_date','total_tax_amount','{{\App\Helpers\Utility::PURCHASE_DESC}}');" name="select_user" placeholder="Inventory Item">

                        <input type="hidden" class="inv_class " value="" name="user" id="inv500{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL500{{$num2}}" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class=" item_desc " name="item_desc" id="item_desc{{$num2}}" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" quantity " name="quantity" id="qty{{$num2}}" placeholder="Quantity"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" unit_cost " name="unit_cost" id="unit_cost{{$num2}}" placeholder="Unit Cost/Rate"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" unit_measure " readonly name="unit_measure" id="unit_measure{{$num2}}" placeholder="Unit Measure" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" tax " name="tax" id="tax{{$num2}}"
                                onchange="fillNextInputTax('tax{{$num2}}','tax_perct{{$num2}}','{{url('default_select')}}','get_tax','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                            <option value="">Select</option>
                            @foreach($tax as $inv)
                                <option value="{{$inv->id}}">{{$inv->tax_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" tax_perct " name="tax_perct" id="tax_perct{{$num2}}" placeholder="Tax Percentage"
                               onkeyup="percentToAmount('tax_perct{{$num2}}','tax_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="tax_amount shared_tax_amount " name="tax_amount" id="tax_amount{{$num2}}" placeholder="Tax Amount"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" discount_perct " name="discount_perct" id="discount_perct{{$num2}}" placeholder="Discount Percentage"
                               onkeyup="percentToAmount('discount_perct{{$num2}}','discount_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" discount_amount  shared_discount_amount " name="discount_amount" id="discount_amount{{$num2}}" placeholder="Discount Amount"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" sub_total  shared_sub_total " readonly name="sub_total" id="sub_total{{$num2}}" placeholder="Sub Total" >
                    </div>
                </div>
            </div>
        </td>

        <td></td>

        <td class=" addButtons center-align" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','get_inv','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="center-align" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputCalc('{{$add_id}}','remove_inv{{$more}}','{{url('add_more')}}','get_inv','new_inv','{{$more}}','{{$add_id}}','{{$hide_id}}','sub_total{{$num2}}','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>
@endif
<!-- END OF INVENTORY ITEM TEMPLATE PURCHASE -->

<!-- BEGIN OF INVENTORY ITEM TEMPLATE EDIT -->
@if($type == 'get_inv_edit')
    <tr class="row clearfix new_inv_edit remove_inv_edit{{$more}}">

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionListInventory('select_inv{{$num2}}','myUL500{{$num2}}','{{url('default_select')}}','search_inventory_transact','inv500{{$num2}}','item_desc{{$num2}}','unit_cost{{$num2}}','unit_measure{{$num2}}','sub_total{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','qty{{$num2}}','vendorCust_edit','posting_date_edit','total_tax_amount_edit','{{\App\Helpers\Utility::PURCHASE_DESC}}');" name="select_user" placeholder="Inventory Item">

                        <input type="hidden" class="inv_class inv_class_edit" value="" name="user" id="inv500{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL500{{$num2}}" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class=" item_desc item_desc_edit" name="item_desc" id="item_desc{{$num2}}" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" quantity quantity_edit" name="quantity" id="qty{{$num2}}" placeholder="Quantity"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" unit_cost unit_cost_edit"  name="unit_cost" id="unit_cost{{$num2}}" placeholder="Unit Cost/Rate"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" unit_measure unit_measure_edit" readonly name="unit_measure" id="unit_measure{{$num2}}" placeholder="Unit Measure" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" tax tax_edit" name="tax" id="tax{{$num2}}"
                                onchange="fillNextInputTax('tax{{$num2}}','tax_perct{{$num2}}','{{url('default_select')}}','get_tax','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                            <option value="">Select Tax</option>
                            @foreach($tax as $inv)
                                <option value="{{$inv->id}}">{{$inv->tax_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" tax_perct tax_perct_edit" name="tax_perct" id="tax_perct{{$num2}}" placeholder="Tax Percentage"
                               onkeyup="percentToAmount('tax_perct{{$num2}}','tax_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="tax_amount tax_amount_edit shared_tax_amount shared_tax_amount_edit" name="tax_amount" id="tax_amount{{$num2}}" placeholder="Tax Amount"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" discount_perct discount_perct_edit" name="discount_perct" id="discount_perct{{$num2}}" placeholder="Discount Percentage"
                               onkeyup="percentToAmount('discount_perct{{$num2}}','discount_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" discount_amount discount_amount_edit shared_discount_amount shared_discount_amount_edit" name="discount_amount" id="discount_amount{{$num2}}" placeholder="Discount Amount"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="sub_total_edit  shared_sub_total_edit" readonly name="sub_total" id="sub_total{{$num2}}" placeholder="Sub Total" >
                    </div>
                </div>
            </div>
        </td>

        <td></td>

        <td class=" addButtons center-align" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','get_inv_edit','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="center-align" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputCalc('{{$add_id}}','remove_inv_edit{{$more}}','{{url('add_more')}}','get_inv_edit','new_inv_edit','{{$more}}','{{$add_id}}','{{$hide_id}}','sub_total{{$num2}}','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>
@endif
<!-- END OF INVENTORY ITEM TEMPLATE EDIT -->


<!-- BEGIN OF INVENTORY ITEM TEMPLATE FOR SALES -->
@if($type == 'get_inv_sales')
    <tr class="row clearfix new_inv remove_inv{{$more}}">

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionListInventory('select_inv{{$num2}}','myUL500{{$num2}}','{{url('default_select')}}','search_inventory_transact','inv500{{$num2}}','item_desc{{$num2}}','unit_cost{{$num2}}','unit_measure{{$num2}}','sub_total{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','qty{{$num2}}','vendorCust','posting_date','total_tax_amount','{{\App\Helpers\Utility::SALES_DESC}}');" name="select_user" placeholder="Inventory Item">

                        <input type="hidden" class="inv_class " value="" name="user" id="inv500{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL500{{$num2}}" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class=" item_desc " name="item_desc" id="item_desc{{$num2}}" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" quantity " name="quantity" id="qty{{$num2}}" placeholder="Quantity"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" unit_cost " name="unit_cost" id="unit_cost{{$num2}}" placeholder="Unit Cost/Rate"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" unit_measure " readonly name="unit_measure" id="unit_measure{{$num2}}" placeholder="Unit Measure" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" tax " name="tax" id="tax{{$num2}}"
                                onchange="fillNextInputTax('tax{{$num2}}','tax_perct{{$num2}}','{{url('default_select')}}','get_tax','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                            <option value="">Select</option>
                            @foreach($tax as $inv)
                                <option value="{{$inv->id}}">{{$inv->tax_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" tax_perct " name="tax_perct" id="tax_perct{{$num2}}" placeholder="Tax Percentage"
                               onkeyup="percentToAmount('tax_perct{{$num2}}','tax_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="tax_amount shared_tax_amount " name="tax_amount" id="tax_amount{{$num2}}" placeholder="Tax Amount"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" discount_perct " name="discount_perct" id="discount_perct{{$num2}}" placeholder="Discount Percentage"
                               onkeyup="percentToAmount('discount_perct{{$num2}}','discount_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" discount_amount  shared_discount_amount " name="discount_amount" id="discount_amount{{$num2}}" placeholder="Discount Amount"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" sub_total  shared_sub_total " readonly name="sub_total" id="sub_total{{$num2}}" placeholder="Sub Total" >
                    </div>
                </div>
            </div>
        </td>

        <td></td>

        <td class=" addButtons center-align" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','get_inv_sales','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="center-align" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputCalc('{{$add_id}}','remove_inv{{$more}}','{{url('add_more')}}','get_inv_sales','new_inv','{{$more}}','{{$add_id}}','{{$hide_id}}','sub_total{{$num2}}','overall_sum','foreign_overall_sum','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount','shared_discount_amount','total_tax_amount','total_discount_amount','vendorCust','posting_date');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>
@endif
<!-- END OF INVENTORY ITEM TEMPLATE SALES -->

<!-- BEGIN OF INVENTORY ITEM TEMPLATE SALES EDIT -->
@if($type == 'get_inv_sales_edit')
    <tr class="row clearfix new_inv_edit remove_inv_edit{{$more}}">

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionListInventory('select_inv{{$num2}}','myUL500{{$num2}}','{{url('default_select')}}','search_inventory_transact','inv500{{$num2}}','item_desc{{$num2}}','unit_cost{{$num2}}','unit_measure{{$num2}}','sub_total{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','qty{{$num2}}','vendorCust_edit','posting_date_edit','total_tax_amount_edit','{{\App\Helpers\Utility::SALES_DESC}}');" name="select_user" placeholder="Inventory Item">

                        <input type="hidden" class="inv_class inv_class_edit" value="" name="user" id="inv500{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL500{{$num2}}" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class=" item_desc item_desc_edit" name="item_desc" id="item_desc{{$num2}}" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" quantity quantity_edit" name="quantity" id="qty{{$num2}}" placeholder="Quantity"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" unit_cost unit_cost_edit"  name="unit_cost" id="unit_cost{{$num2}}" placeholder="Unit Cost/Rate"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class=" unit_measure unit_measure_edit" readonly name="unit_measure" id="unit_measure{{$num2}}" placeholder="Unit Measure" >
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class=" tax tax_edit" name="tax" id="tax{{$num2}}"
                                onchange="fillNextInputTax('tax{{$num2}}','tax_perct{{$num2}}','{{url('default_select')}}','get_tax','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                            <option value="">Select Tax</option>
                            @foreach($tax as $inv)
                                <option value="{{$inv->id}}">{{$inv->tax_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" tax_perct tax_perct_edit" name="tax_perct" id="tax_perct{{$num2}}" placeholder="Tax Percentage"
                               onkeyup="percentToAmount('tax_perct{{$num2}}','tax_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="tax_amount tax_amount_edit shared_tax_amount shared_tax_amount_edit" name="tax_amount" id="tax_amount{{$num2}}" placeholder="Tax Amount"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" discount_perct discount_perct_edit" name="discount_perct" id="discount_perct{{$num2}}" placeholder="Discount Percentage"
                               onkeyup="percentToAmount('discount_perct{{$num2}}','discount_amount{{$num2}}','sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class=" discount_amount discount_amount_edit shared_discount_amount shared_discount_amount_edit" name="discount_amount" id="discount_amount{{$num2}}" placeholder="Discount Amount"
                               onkeyup="itemSum('sub_total{{$num2}}','unit_cost{{$num2}}','inv500{{$num2}}','qty{{$num2}}','discount_amount{{$num2}}','tax_amount{{$num2}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num2}}','discount_perct{{$num2}}')">
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="sub_total_edit  shared_sub_total_edit" readonly name="sub_total" id="sub_total{{$num2}}" placeholder="Sub Total" >
                    </div>
                </div>
            </div>
        </td>

        <td></td>

        <td class=" addButtons center-align" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','get_inv_sales_edit','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="center-align" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInputCalc('{{$add_id}}','remove_inv_edit{{$more}}','{{url('add_more')}}','get_inv_sales_edit','new_inv_edit','{{$more}}','{{$add_id}}','{{$hide_id}}','sub_total{{$num2}}','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>
@endif
<!-- END OF INVENTORY ITEM TEMPLATE SALES EDIT -->



<!-- BEGIN OF TASK -->
@if($type == 'task')

    <div class="row clearfix new_task remove_task{{$more}}" style="margin-left:5px;">

        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control task_title" name="task_title" placeholder="Task title">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" class="form-control task_details" name="task" placeholder="Task Details"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-4" id="normal_user{{$num2}}">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" autocomplete="off" id="select_user{{$num2}}" onkeyup="searchOptionListParam('select_user{{$num2}}','myUL1{{$num2}}','{{url('default_select')}}','default_search_param','user{{$num2}}','{{$projectId}}');" name="select_user" placeholder="Select User">

                        <input type="hidden" class="user_class" name="user" id="user{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL1{{$num2}}" class="myUL"></ul>
            </div>
            <div class="col-sm-4" id="temp_user{{$num2}}" style="display:none;">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" autocomplete="off" id="select_users{{$num2}}" onkeyup="searchOptionListParam('select_users{{$num2}}','myUL{{$num2}}','{{url('default_select')}}','default_search_temp_param','users{{$num2}}','{{$projectId}}');" name="select_user" placeholder="Select External/Contract User">

                        <input type="hidden" class="" name="user_temp" id="users{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL{{$num2}}" class="myUL"></ul>
            </div>
        </div>
        <input type="checkbox" value="1" class="change_user" onclick="changeUserT('normal_user{{$num2}}','temp_user{{$num2}}','change_user{{$num2}}','user{{$num2}}','users{{$num2}}');" id="change_user{{$num2}}" />Check to select contract/external user
        <hr/>

        <div class="row clearfix">

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control task_status" name="task_status" placeholder="Task Status">
                            <option value="">Select Status</option>
                            @foreach(\App\Helpers\Utility::TASK_STATUS as $key => $task)
                                <option value="{{$key}}">{{$task}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control task_priority" name="task_priority" >
                            <option value="">Select Priority</option>
                            @foreach(\App\Helpers\Utility::TASK_PRIORITY as $task)
                                <option value="{{$task}}">{{$task}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control time_planned" name="time_planned" placeholder="Time(hrs) Planned">
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control start_date datepicker2" autocomplete="off" name="start_date" placeholder="Start Date">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control end_date datepicker2" autocomplete="off" name="end_date" placeholder="End Date">
                    </div>
                </div>
            </div>

            <div class=" addButtons" id="{{$hide_id}}{{$more}}">
                <div class="form-group">
                    <div onclick="addMoreParam('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','task','{{$hide_id}}','{{$projectId}}');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

            <div class="" id="">
                <div class="form-group">
                    <div style="cursor: pointer;" onclick="removeInputParam('{{$add_id}}','remove_task{{$more}}','{{url('add_more')}}','task','new_task','{{$more}}','{{$add_id}}','{{$hide_id}}','{{$projectId}}');">
                        <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

        </div>
        <hr/>
    </div>

@endif
<!-- END OF TASK -->

<!-- BEGIN OF TASK LIST -->
@if($type == 'task_list')

    <div class="row clearfix new_task_list remove_task_list{{$more}}" style="margin-left:5px;">

        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control task_list" id="" name="task_list" >
                            <option value="">Select Task List</option>
                            @foreach($taskList as $task)
                                <option value="{{$task->id}}">{{$task->list_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>


            <div class=" addButtons" id="{{$hide_id}}{{$more}}">
                <div class="form-group">
                    <div onclick="addMoreParam('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','task_list','{{$hide_id}}','{{$projectId}}');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

            <div class="" id="">
                <div class="form-group">
                    <div style="cursor: pointer;" onclick="removeInputParam('{{$add_id}}','remove_task_list{{$more}}','{{url('add_more')}}','task_list','new_task_list','{{$more}}','{{$add_id}}','{{$hide_id}}','{{$projectId}}');">
                        <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

        </div>
        <hr/>
    </div>

@endif
<!-- END OF TASK LIST -->


<!-- BEGIN OF TEAM MEMBER -->
@if($type == 'team_member')

    <div class="row clearfix new_team_member remove_team_member{{$more}}" style="margin-left:5px;">

        <div class="row clearfix">
            <div class="col-sm-4" id="normal_user{{$num2}}">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" autocomplete="off" id="select_user{{$num2}}" onkeyup="searchOptionList('select_user{{$num2}}','myUL1{{$num2}}','{{url('default_select')}}','default_search','user{{$num2}}');" name="select_user" placeholder="Select User">

                        <input type="hidden" class="user_class" name="user" id="user{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL1{{$num2}}" class="myUL"></ul>
            </div>

            <div class="col-sm-4" id="temp_user{{$num2}}" style="display:none;">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" autocomplete="off" id="select_users{{$num2}}" onkeyup="searchOptionList('select_users{{$num2}}','myUL{{$num2}}','{{url('default_select')}}','default_search_temp_dept','users{{$num2}}');" name="select_user" placeholder="Select External/Contract User">

                        <input type="hidden" class="" name="user" id="users{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL{{$num2}}" class="myUL"></ul>
            </div>

            <input type="checkbox" class="change_user" value="1" onclick="changeUserT('normal_user{{$num2}}','temp_user{{$num2}}','change_user{{$num2}}','user{{$num2}}','users{{$num2}}');" id="change_user{{$num2}}" />Check to select contract/external user

            <div class=" addButtons" id="{{$hide_id}}{{$more}}">
                <div class="form-group">
                    <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','team_member','{{$hide_id}}');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

            <div class="" id="">
                <div class="form-group">
                    <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_team_member{{$more}}','{{url('add_more')}}','team_member','new_team_member','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                        <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

        </div>
        <hr/>
    </div>

@endif
<!-- END OF TEAM MEMBER -->

<!-- BEGIN OF MULTIPLE USERS -->
@if($type == 'multiple_users')

    <div class="row clearfix new_multiple_users remove_multiple_users{{$more}}" style="margin-left:5px;">

        <div class="row clearfix">
            <div class="col-sm-8" id="">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" autocomplete="off" id="select_user{{$num2}}" onkeyup="searchOptionList('select_user{{$num2}}','myUL1{{$num2}}','{{url('default_select')}}','default_search','user{{$num2}}');" name="select_user" placeholder="Select User">

                        <input type="hidden" class="{{$editClassOrId}}" name="user" id="user{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL1{{$num2}}" class="myUL"></ul>
            </div>

            <div class="col-sm-1 addButtons" id="{{$hide_id}}{{$more}}">
                <div class="form-group">
                    <div onclick="addMoreEditable('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','multiple_users','{{$hide_id}}','{{$editClassOrId}}');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

            <div class="col-sm-1" id="">
                <div class="form-group">
                    <div style="cursor: pointer;" onclick="removeInputEditable('{{$add_id}}','remove_multiple_users{{$more}}','{{url('add_more')}}','multiple_users','new_multiple_users','{{$more}}','{{$add_id}}','{{$hide_id}}','{{$editClassOrId}}');">
                        <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

        </div>
        <hr/>
    </div>

@endif
<!-- END OF MULTIPLE USERS -->

<!-- BEGIN OF MULTIPLE STAGES -->
@if($type == 'multiple_stages')

    <div class="row clearfix new_multiple_stages remove_multiple_stages{{$more}}" style="margin-left:5px;">

        <div class="row clearfix">
            <div class="col-sm-8" id="">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" autocomplete="off" id="select_stage{{$num2}}" onkeyup="searchOptionList('select_stage{{$num2}}','myUL1{{$num2}}','{{url('default_select')}}','crm_stage_search','stage{{$num2}}');" name="select_stage" placeholder="Select Stage">

                        <input type="hidden" class="{{$editClassOrId}}" name="stage" id="stage{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL1{{$num2}}" class="myUL"></ul>
            </div>

            <div class="col-sm-1 addButtons" id="{{$hide_id}}{{$more}}">
                <div class="form-group">
                    <div onclick="addMoreEditable('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','multiple_stages','{{$hide_id}}','{{$editClassOrId}}');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

            <div class="col-sm-1" id="">
                <div class="form-group">
                    <div style="cursor: pointer;" onclick="removeInputEditable('{{$add_id}}','remove_multiple_stages{{$more}}','{{url('add_more')}}','multiple_stages','new_multiple_stages','{{$more}}','{{$add_id}}','{{$hide_id}}','{{$editClassOrId}}');">
                        <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

        </div>
        <hr/>
    </div>

@endif
<!-- END OF MULTIPLE STAGES -->

<!-- BEGIN OF MULTIPLE SERVICES -->
@if($type == 'multiple_services')

    <div class="row clearfix new_multiple_services remove_multiple_services{{$more}}" style="margin-left:5px;">

        <div class="row clearfix">
            <div class="col-sm-8" id="">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control {{$editClassOrId}}" name="service_type"  required>
                            <option value="">Select Service Type</option>
                            @foreach($serviceType as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-1 addButtons" id="{{$hide_id}}{{$more}}">
                <div class="form-group">
                    <div onclick="addMoreEditable('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','multiple_services','{{$hide_id}}','{{$editClassOrId}}');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

            <div class="col-sm-1" id="">
                <div class="form-group">
                    <div style="cursor: pointer;" onclick="removeInputEditable('{{$add_id}}','remove_multiple_services{{$more}}','{{url('add_more')}}','multiple_services','new_multiple_services','{{$more}}','{{$add_id}}','{{$hide_id}}','{{$editClassOrId}}');">
                        <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

        </div>
        <hr/>
    </div>

@endif
<!-- END OF MULTIPLE SERVICES -->

<!-- BEGIN OF MULTIPLE VEHICLES -->
@if($type == 'multiple_vehicles')

    <div class="row clearfix new_multiple_vehicles remove_multiple_vehicles{{$more}}" style="margin-left:5px;">

        <div class="row clearfix">
            @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT) || \App\Helpers\Utility::moduleAccessCheck('vehicle_fleet_access'))
                <div class="col-sm-4">
                    <b>Vehicle*</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control " autocomplete="off" id="select_vehicle{{$num2}}" onkeyup="searchOptionList('select_vehicle{{$num2}}','myUL1{{$num2}}','{{url('default_select')}}','search_vehicle','vehicle{{$num2}}');" name="select_vehicle" placeholder="Select Vehicle">

                            <input type="hidden" class="{{$editClassOrId}}" name="vehicle" id="vehicle{{$num2}}" />
                        </div>
                    </div>
                    <ul id="myUL1{{$num2}}" class="myUL"></ul>
                </div>
            @else

                <div class="col-sm-4">
                    <b>Vehicle*</b>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control {{$editClassOrId}}" name="vehicle"  required>
                                <option value="">Select Select Vehicle</option>
                                @foreach(\App\Helpers\Utility::driverVehicles() as $data)
                                    <option value="{{$data->id}}">{{$data->make->make_name}} {{$data->model->model_name}} ({{$data->license_plate}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            @endif

                <div class="col-sm-5">
                    <b>Vehicle Current Mileage(Miles)</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="number" class="form-control mileage_class" value="0" name="mileage" id="" placeholder="Mileage" required>
                        </div>
                    </div>
                </div>

            <div class="col-sm-1 addButtons" id="{{$hide_id}}{{$more}}">
                <div class="form-group">
                    <div onclick="addMoreEditable('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','multiple_vehicles','{{$hide_id}}','{{$editClassOrId}}');">
                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

            <div class="col-sm-1" id="">
                <div class="form-group">
                    <div style="cursor: pointer;" onclick="removeInputEditable('{{$add_id}}','remove_multiple_vehicles{{$more}}','{{url('add_more')}}','multiple_vehicles','new_multiple_vehicles','{{$more}}','{{$add_id}}','{{$hide_id}}','{{$editClassOrId}}');">
                        <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                    </div>
                </div>
            </div>

        </div>
        <hr/>
    </div>

@endif
<!-- END OF MULTIPLE VEHICLES -->

<!-- START OF ADDING BILL OF MATERIALS -->
@if($type == 'warehouse_items')
    <div class="row clearfix new_inv_bom remove_inv_bom{{$more}}"  >

        <div class="col-sm-4">
            Inventory Item
            <div class="form-group">
                <div class="form-line">
                    <input type="text" class="form-control" autocomplete="off" id="select_inv{{$num2}}" onkeyup="searchOptionList('select_inv{{$num2}}','myUL{{$num2}}','{{url('default_select')}}','search_inventory','inv{{$num2}}');" name="select_inventory" placeholder="Select Inventory Item">

                    <input type="hidden" class="inv_class inv_class_edit" name="inventory" id="inv{{$num2}}" />
                </div>
            </div>
            <ul id="myUL{{$num2}}" class="myUL"></ul>
        </div>

        <div class="col-sm-4">
            <b>Quantity</b>
            <div class="form-group">
                <div class="form-line">
                    <input type="number" class="form-control bom_qty bom_qty_edit bom_qty_class" name="bom_qty" id="bom_qty{{$num2}}" onkeyup="extendedAmount('inv{{$num2}}','{{url('ext_amount')}}','ext_amount{{$num2}}','bom_qty{{$num2}}','bom_qty_class','bom_amt','unit_cost')" placeholder="Quantity" >
                </div>
            </div>
        </div>

        <div class=" addButtons" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','warehouse_items','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

        <div class="" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_inv_bom{{$more}}','{{url('add_more')}}','warehouse_items','new_inv_bom','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </div>

    </div>
@endif

<!-- BEGIN OF JOURNAL ENTRY -->
@if($type == 'journal_entry')
    <tr class="row clearfix new_acc remove_acc{{$more}}">

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_acc{{$num2}}" onkeyup="searchOptionList('select_acc{{$num2}}','myUL500_acc{{$num2}}','{{url('default_select')}}','search_accounts','acc500{{$num2}}');" name="select_user" placeholder="Select Account">

                        <input type="hidden" class="acc_class " value="" name="user" id="acc500{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL500_acc{{$num2}}" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class=" acc_desc " name="acc_desc" id="acc_desc{{$num2}}" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="debit_credit " name="debit_credit" id="debit_credit{{$num2}}" onchange="makeReadOnly('debit_credit{{$num2}}','debit_account{{$num2}}','credit_account{{$num2}}','debit_account_hidden{{$num2}}','credit_account_hidden{{$num2}}')">
                            <option value="">Select Account Type</option>                            
                            <option value="{{Utility::DEBIT_TABLE_ID}}">DEBIT</option>                            
                            <option value="{{Utility::CREDIT_TABLE_ID}}">CREDIT</option>
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" onchange="reflectToHidden('debit_account{{$num2}}','debit_account_hidden{{$num2}}')" disabled class="debit_account" name="debit_account" id="debit_account{{$num2}}" placeholder="Debit">
                    </div>
                </div>
            </div>
            <input type='hidden' value="0.00" class="debit_account_hidden checkmate_debit" name="debit_account_hidden" id="debit_account_hidden{{$num2}}">
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" onchange="reflectToHidden('credit_account{{$num2}}','credit_account_hidden{{$num2}}')" disabled class="credit_account " name="credit_account" id="credit_account{{$num2}}" placeholder="Credit">
                    </div>
                </div>
            </div>
            <input type='hidden' value="0.00" class="credit_account_hidden checkmate_credit" name="credit_account_hidden" id="credit_account_hidden{{$num2}}">
        </td>

        <td></td>

        <td class=" addButtons center-align" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','journal_entry','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="center-align" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_acc{{$more}}','{{url('add_more')}}','journal_entry','new_acc','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>
@endif
<!-- END OF JOURNAL ENTRY -->

<!-- BEGIN OF JOURNAL ENTRY EDIT -->
@if($type == 'journal_entry_edit')
    <tr class="row clearfix new_acc_edit remove_acc_edit{{$more}}">

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="" autocomplete="off" id="select_acc{{$num2}}" onkeyup="searchOptionList('select_acc{{$num2}}','myUL500_acc{{$num2}}','{{url('default_select')}}','search_accounts','acc500{{$num2}}');" name="select_user" placeholder="Select Account">

                        <input type="hidden" class=" acc_class_edit" value="" name="user" id="acc500{{$num2}}" />
                    </div>
                </div>
                <ul id="myUL500_acc{{$num2}}" class="myUL"></ul>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class=" acc_desc_edit " name="acc_desc_edit" id="acc_desc_edit{{$num2}}" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="debit_credit_edit " name="debit_credit" id="debit_credit_edit{{$num2}}" onchange="makeReadOnly('debit_credit_edit{{$num2}}','debit_account_edit{{$num2}}','credit_account_edit{{$num2}}','debit_account_hidden_edit{{$num2}}','credit_account_hidden_edit{{$num2}}')">
                            <option value="">Select Account Type</option>                            
                            <option value="{{Utility::DEBIT_TABLE_ID}}">DEBIT</option>                            
                            <option value="{{Utility::CREDIT_TABLE_ID}}">CREDIT</option>
                        </select>
                    </div>
                </div>
            </div>
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" onchange="reflectToHidden('debit_account_edit{{$num2}}','debit_account_hidden_edit{{$num2}}')" disabled class="debit_account_edit " name="debit_account_edit" id="debit_account_edit{{$num2}}" placeholder="Debit">
                    </div>
                </div>
            </div>
            <input type='hidden' value="0.00" class="debit_account_hidden_edit checkmate_debit_edit" name="debit_account_hidden_edit" id="debit_account_hidden_edit{{$num2}}">
        </td>

        <td>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" onchange="reflectToHidden('credit_account_edit{{$num2}}','credit_account_hidden_edit{{$num2}}')" disabled class="credit_account_edit " name="credit_account_edit" id="credit_account_edit{{$num2}}" placeholder="Credit">
                    </div>
                </div>
            </div>
            <input type='hidden' value="0.00" class="credit_account_hidden_edit checkmate_credit_edit" name="credit_account_hidden_edit" id="credit_account_hidden_edit{{$num2}}">
        </td>
        <td></td>

        <td class=" addButtons center-align" id="{{$hide_id}}{{$more}}">
            <div class="form-group">
                <div onclick="addMore('{{$add_id}}','{{$hide_id}}{{$more}}','{{$num2}}','<?php echo URL::to('add_more'); ?>','journal_entry_edit','{{$hide_id}}');">
                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

        <td class="center-align" id="">
            <div class="form-group">
                <div style="cursor: pointer;" onclick="removeInput('{{$add_id}}','remove_acc_edit{{$more}}','{{url('add_more')}}','journal_entry_edit','new_acc_edit','{{$more}}','{{$add_id}}','{{$hide_id}}');">
                    <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                </div>
            </div>
        </td>

    </tr>
@endif
<!-- END OF JOURNAL ENTRY EDIT  -->


<script>
    $(function() {
        $( ".datepicker2" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
            /*yearRange: "-90:+00"*/

        });
    });
</script>