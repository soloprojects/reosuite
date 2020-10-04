@if($type == 'error')
    No match found, please fill in all required fields
    <ul>
        @foreach($mainData as $data)
            <li>{{$data}}</li>
        @endforeach
    </ul>
@endif

@if($type == 'data')
<!-- Example Tab -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Questions and Answers
                    <small></small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another action</a></li>
                            <li><a href="javascript:void(0);">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <?php $allDept = $mainData->dept; $firstId = $allDept[0]->id; ?>
            <div class="body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                @foreach($mainData->dept as $dept)
                        <li role="presentation" class="<?php $active = ($dept->id == $firstId) ? 'active' : ''; echo $active; ?>"><a href="#dept_tab{{$dept->id}}" data-toggle="tab">{{$dept->dept_name}}</a></li>
                @endforeach
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                        @foreach($mainData->dept as $dept)

                                <div role="tabpanel" class="tab-pane fade <?php $active = ($dept->id == $firstId) ? 'in active' : ''; echo $active; ?>" id="dept_tab{{$dept->id}}">
                                    <b>{{$mainData->survey_name}}</b><hr/>
                                    <p>{{$mainData->survey_desc}}</p><hr/>

                                    <div class="row">
                                        <div class="col-sm-7">
                                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox{{$dept->id}}');" id="parent_check{{$dept->id}}"
                                                   name="check_all{{$dept->id}}" class="" />
                                        </div>
                                        <div class="col-sm-4">
                                            @if($resultCheck != 1)
                                            <button type="button" onclick="deleteItemsRemove('kid_checkbox{{$dept->id}}','reload_data','<?php echo url('survey_question'); ?>',
                                                    '<?php echo url('delete_survey_question'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger pull-right">
                                                <i class="fa fa-trash-o"></i>Delete
                                            </button>
                                            @endif
                                        </div>
                                    </div>

                                    @foreach($dept->questions as $quest)
                                        <div class="row" id="tr_{{$quest->id}}">
                                            <form name="questOptionForm{{$quest->id}}" id="questOptionForm{{$quest->id}}" onsubmit="false;" class="form form-horizontal container" method="post" enctype="multipart/form-data">

                                                <input type="hidden" name="text_type" value="{{$quest->text_type}}" />
                                                <input type="hidden" name="question_id" value="{{$quest->id}}" />
                                                <input type="hidden" name="survey" value="{{$quest->survey_id}}" />
                                                <input type="hidden" name="department" value="{{$quest->dept_id}}" />
                                                <input type="hidden" name="countExtraAns" value="{{$quest->moreAnsColumnCount}}" />
                                                <input type="hidden" name="countAns" value="{{$quest->count_ans}}" />
                                                <div class="row">
                                                    <div class="col-sm-1 ">
                                                        <div class=" pull-right">
                                                            <div class="">
                                                                <input type="checkbox" class=" kid_checkbox{{$dept->id}}" value="{{$quest->id}}" id="{{$quest->id}}" name="" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1 ">
                                                        <div class="form-group pull-right">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control " value="{{$quest->quest_number}}" disabled name="" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <textarea id="question{{$quest->id}}" name="question" class="ckeditor" placeholder="Message">{{$quest->question}}</textarea>
                                                                <script>
                                                                    CKEDITOR.replace('question{{$quest->id}}');
                                                                </script>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <hr/>
                                                <div class="row">
                                                    <div class="col-sm-2 ">
                                                        <div class="form-group pull-right">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control " value="Question Category" disabled name="" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 ">
                                                        <div class="form-group pull-right">
                                                            <div class="form-line">
                                                                <select class="form-control " name="question_category" >
                                                                    <option value="{{$quest->cat_id}}">{{$quest->questCat->category_name}}</option>
                                                                    @foreach($questCat as $cat)
                                                                        <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr/>
                                                <!-- END OF QUESTION AND QUESTION CATEGORY -->

                                                <!-- BEGIN OF ANSWERS AND ANSWER CATEGORY -->
                                                @if($quest->text_type == '0')
                                                <?php $num = 0; ?>
                                                @foreach($quest->ans as $ans)
                                                    <?php $num++; ?>
                                                        <input type="hidden" name="answer_id{{$num}}" value="{{$ans->id}}" />
                                                        <div class="row">
                                                            <div class="col-sm-2 ">
                                                                <div class="form-group pull-right">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control " value="Answer {{$num}}" disabled name="" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 ">
                                                                <div class="form-group pull-right">
                                                                    <div class="form-line">
                                                                        <select class="form-control " name="answer{{$num}}" >
                                                                            <option value="{{$ans->ans_cat_id}}">{{$ans->ansCat->category_name}}</option>
                                                                            @foreach($ansCat as $cat)
                                                                                <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                @endforeach
                                                @for($i=1;$i<=$quest->moreAnsColumnCount;$i++)

                                                        <div class="row">
                                                            <div class="col-sm-2 ">
                                                                <div class="form-group pull-right">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control " value="Answer {{$i+$num}}" disabled name="" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 ">
                                                                <div class="form-group pull-right">
                                                                    <div class="form-line">
                                                                        <select class="form-control " name="new_answer{{$i}}" >
                                                                            <option value="">Select Answer Category</option>
                                                                            @foreach($ansCat as $cat)
                                                                                <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                @endfor
                                            @endif
                                            </form><hr/>

                                            <div class="row">
                                                <div class="col-sm-11">
                                                    @if($resultCheck != 1)
                                                    <button id="dept_id_{{$dept->id}}_{{csrf_field()}}" onclick="submitQuestDefaultEdit('question{{$quest->id}}','questOptionForm{{$quest->id}}','<?php echo url('edit_survey_question'); ?>','reload_data',
                                                            '<?php echo url('survey_question'); ?>','<?php echo csrf_token(); ?>','{{csrf_field()}}')" type="button" class="btn btn-info waves-effect pull-right">
                                                        SAVE
                                                    </button><hr/>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                        @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Example Tab -->
@endif

<script>
    $(document).ready(function() {
        $('table.highchart').highchartTable();
    });
</script>