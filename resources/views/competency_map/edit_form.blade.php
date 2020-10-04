@if($edit->comp_category == App\Helpers\Utility::PRO_QUAL)
<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control department_pro" name="department" >
                            @foreach($dept as $ap)
                                @if($edit->dept_id == $ap->id)
                                <option value="{{$ap->id}}" selected>{{$ap->dept_name}}</option>
                                @else
                                    <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control position_pro" name="position" >
                            @foreach($position as $ap)
                                @if($edit->position_id == $ap->id)
                                <option value="{{$ap->id}}" selected>{{$ap->position_name}}</option>
                                @else
                                <option value="{{$ap->id}}" selected>{{$ap->position_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control min_aca_qual" value="{{$edit->min_aca_qual}}" name="min_aca_qual" placeholder="Minimum Academic Qualification">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control cog_exp" name="cog_exp" >
                            <option value="">Cognate Experience</option>
                            @for($i=0; $i<51; $i++)
                                @if($edit->cog_exp == $i)
                                <option value="{{$i}}" selected>{{$i}}</option>
                                @else
                                    <option value="{{$i}}">{{$i}}</option>
                                @endif
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control pro_qual" value="{{$edit->pro_qual}}" name="pro_qual" placeholder="Professional Qualification">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control yr_post_cert" name="yr_post_cert" >
                            <option value="">Years Post Certification</option>
                            @for($i=0; $i<51; $i++)
                                @if($edit->yr_post_cert == $i)
                                    <option value="{{$i}}" selected>{{$i}}</option>
                                @else
                                    <option value="{{$i}}">{{$i}}</option>
                                @endif
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

    </div>
   </div>
    <input type="hidden" name="comp_type" value="{{$edit->comp_category}}" >
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>
@endif

@if($edit->comp_category == App\Helpers\Utility::TECH_COMP)
    <form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

        <div class="body">
            <div class="row clearfix">
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <select  class="form-control" name="department" id="dept_tech_edit" onchange="fillNextInput('dept_tech_edit','comp_cat','<?php echo url('default_select'); ?>','dept_frame_tech')" >
                                @foreach($dept as $ap)
                                    @if($edit->dept_id == $ap->id)
                                        <option value="{{$ap->id}}" selected>{{$ap->dept_name}}</option>
                                    @else
                                        <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <select  class="form-control" name="position" >
                                @foreach($position as $ap)
                                    @if($edit->position_id == $ap->id)
                                        <option value="{{$ap->id}}" selected>{{$ap->position_name}}</option>
                                    @else
                                        <option value="{{$ap->id}}" selected>{{$ap->position_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line" id="comp_cat">
                            <select  class="form-control" name="competency_category" >

                                @foreach($techCompCat as $ap)
                                    @if($edit->sub_comp_cat == $ap->id)
                                    <option value="{{$ap->id}}" selected>{{$ap->category_name}}</option>
                                    @endif
                                @endforeach
                                    <option value="">Competency Category</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="form-group">
                        <div class="form-line">
                            <textarea class="form-control " name="cat_desc" placeholder="Item Description">{{$edit->item_desc}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <select  class="form-control" name="tech_level" >
                                <option value="">Level</option>
                                @for($i=0; $i<6; $i++)
                                    @if($edit->comp_level == $i)
                                    <option value="{{$i}}" selected>{{$i}}</option>
                                    @else
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <input type="hidden" name="comp_type" value="{{$edit->comp_category}}" >
        <input type="hidden" name="edit_id" value="{{$edit->id}}" >
    </form>
@endif

@if($edit->comp_category == App\Helpers\Utility::BEHAV_COMP)
    <form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

        <div class="body">
            <div class="row clearfix">
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <select  class="form-control department" name="department" id="dept_behav_edit" onchange="fillNextInput('dept_behav_edit','comp_cat','<?php echo url('default_select'); ?>','dept_frame_behav')">
                                @foreach($dept as $ap)
                                    @if($edit->dept_id == $ap->id)
                                        <option value="{{$ap->id}}" selected>{{$ap->dept_name}}</option>
                                    @else
                                        <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <select  class="form-control position" name="position" >
                                @foreach($position as $ap)
                                    @if($edit->position_id == $ap->id)
                                        <option value="{{$ap->id}}" selected>{{$ap->position_name}}</option>
                                    @else
                                        <option value="{{$ap->id}}" selected>{{$ap->position_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line" id="comp_cat">
                            <select  class="form-control"  name="competency_category" >
                                @foreach($behavCompCat as $ap)
                                    @if($edit->sub_comp_cat == $ap->id)
                                        <option value="{{$ap->id}}" selected>{{$ap->category_name}}</option>
                                    @endif
                                @endforeach
                                    <option value="">SELECT CATEGORY</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control cat_desc" value="{{$edit->item_desc}}" name="category_desc" placeholder="Item Description">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="form-line">
                            <select  class="form-control behav_level" name="behav_level" >
                                <option value="">Level</option>
                                @for($i=0; $i<6; $i++)
                                    @if($edit->comp_level == $i)
                                        <option value="{{$i}}" selected>{{$i}}</option>
                                    @else
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <input type="hidden" name="comp_type" value="{{$edit->comp_category}}" >
        <input type="hidden" name="edit_id" value="{{$edit->id}}" >
    </form>
@endif