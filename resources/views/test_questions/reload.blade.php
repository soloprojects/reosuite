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
            <?php $allCat = $mainData->category; $firstId = $allCat[0]->id; ?>
            <div class="body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                @foreach($mainData->category as $cat)
                        <li role="presentation" class="<?php $active = ($cat->id == $firstId) ? 'active' : ''; echo $active; ?>"><a href="#cat_tab{{$cat->id}}" data-toggle="tab">{{$cat->category_name}}</a></li>
                @endforeach
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                        @foreach($mainData->category as $cat)

                                <div role="tabpanel" class="tab-pane fade <?php $active = ($cat->id == $firstId) ? 'in active' : ''; echo $active; ?>" id="cat_tab{{$cat->id}}">
                                    <b>{{$mainData->test_name}}</b><hr/>
                                    <p>{{$mainData->test_desc}}</p><hr/>

                                    <div class="row">
                                        <div class="col-sm-7">
                                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox{{$cat->id}}');" id="parent_check{{$cat->id}}"
                                                   name="check_all{{$cat->id}}" class="" />
                                        </div>
                                        <div class="col-sm-4">
                                            <button type="button" onclick="deleteItemsRemove('kid_checkbox{{$cat->id}}','reload_data','<?php echo url('test_question'); ?>',
                                                    '<?php echo url('delete_test_question'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger pull-right">
                                                <i class="fa fa-trash-o"></i>Delete
                                            </button>

                                        </div>
                                    </div>

                                    @foreach($cat->questions as $quest)
                                        <div class="row" id="tr_{{$quest->id}}">
                                            <form name="questOptionForm{{$quest->id}}" id="questOptionForm{{$quest->id}}" onsubmit="false;" class="form form-horizontal container" method="post" enctype="multipart/form-data">

                                                <input type="hidden" id="text_type{{$quest->id}}" name="text_type" value="{{$quest->text_type}}" />
                                                <input type="hidden" name="question_id" value="{{$quest->id}}" />
                                                <input type="hidden" name="test" value="{{$quest->test_id}}" />
                                                <input type="hidden" name="test_category" value="{{$quest->cat_id}}" />
                                                <input type="hidden" name="countExtraAns" value="{{$quest->moreAnsColumnCount}}" />
                                                <input type="hidden" name="countAns" value="{{$quest->count_ans}}" />
                                                <div class="row">
                                                    <div class="col-sm-1 ">
                                                        <div class=" pull-right">
                                                            <div class="">
                                                                <input type="checkbox" class=" kid_checkbox{{$cat->id}}" value="{{$quest->id}}" id="{{$quest->id}}" name="" >
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
                                                                <textarea id="question_edit{{$quest->id}}" name="question" class="ckeditor" placeholder="Message">{{$quest->question}}</textarea>
                                                                <script>
                                                                    CKEDITOR.replace('question_edit{{$quest->id}}');
                                                                </script>
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
                                                            @if($ans->correct_status == '1')
                                                                <input type="radio" id="rad{{$ans->id}}" class="radio-col-green with-gap" checked value="answer{{$num}}" name="correct_answer" >
                                                                <label for="rad{{$ans->id}}" ></label>
                                                            @else
                                                                <input type="radio" id="rad{{$ans->id}}" class="radio-col-green with-gap" value="answer{{$num}}" name="correct_answer" >
                                                                <label for="rad{{$ans->id}}" ></label>
                                                            @endif

                                                            <div class="col-sm-2 ">
                                                                <div class="form-group pull-right">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control " value="Answer {{$num}}" disabled name="" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" value="answer{{$num}}" name="answer_type{{$num}}" />
                                                            <div class="col-sm-7 ">
                                                                <div class="form-group pull-right">
                                                                    <div class="form-line">
                                                                        <textarea id="answer_edit{{$num}}{{$quest->id}}" name="answers{{$num}}" class="ckeditor" placeholder="">{{$ans->answer}}</textarea>
                                                                        <script>
                                                                            CKEDITOR.replace('answer_edit{{$num}}{{$quest->id}}');
                                                                            CKEDITOR.config.height = 70;     // 500 pixels tall.
                                                                        </script>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                @endforeach
                                                @for($i=1;$i<=$quest->moreAnsColumnCount;$i++)

                                                        <div class="row">
                                                            <input type="radio" id="rad{{$quest->id}}{{$i}}{{$quest->created_at}}" class="radio-col-green with-gap" value="answer{{$num+$i}}" name="correct_answer" >
                                                            <label for="rad{{$quest->id}}{{$i}}{{$quest->created_at}}" ></label>

                                                            <div class="col-sm-2 ">
                                                                <div class="form-group pull-right">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control " value="Answer {{$i+$num}}" disabled name="" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" value="answer{{$i+$num}}" name="answer_type{{$i+$num}}" />
                                                            <div class="col-sm-7 ">
                                                                <div class="form-group pull-right">
                                                                    <div class="form-line">
                                                                        <textarea id="answer_edit{{$i+$num}}{{$quest->id}}" name="answers{{$i+$num}}" class="ckeditor" placeholder=""></textarea>
                                                                        <script>
                                                                            CKEDITOR.replace('answer_edit{{$i+$num}}{{$quest->id}}');
                                                                        </script>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                @endfor
                                             @else
                                                    <input type="hidden" name="correct_answer" value="0"/>
                                             @endif
                                            </form><hr/>

                                            <div class="row">
                                                <div class="col-sm-11">
                                                    <button onclick="submitQuestDefaultEdit('question_edit{{$quest->id}}','questOptionForm{{$quest->id}}','<?php echo url('edit_test_question'); ?>','reload_data',
                                                            '<?php echo url('test_question'); ?>','<?php echo csrf_token(); ?>','answer_edit1{{$quest->id}}','answer_edit2{{$quest->id}}','answer_edit3{{$quest->id}}','answer_edit4{{$quest->id}}','answer_edit5{{$quest->id}}','text_type{{$quest->id}}')" type="button" class="btn btn-info waves-effect pull-right">
                                                        SAVE
                                                    </button><hr/>
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