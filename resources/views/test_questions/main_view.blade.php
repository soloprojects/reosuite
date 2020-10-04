@extends('layouts.app')

@section('content')



    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Test Questions and Answers
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>

                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @include('includes/export',[$exportId = 'main_table', $exportDocId = 'reload_data'])
                            </ul>
                        </li>

                    </ul>
                </div>
                <div class="body row">
                    <form name="import_excel" id="searchTestForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control" id="test_id" name="test" onchange="fillNextInput('test_id','test_category','<?php echo url('default_select'); ?>','test_cat')">
                                        <option value="">Select Test</option>
                                        @foreach($mainData as $cat)
                                            <option value="{{$cat->id}}">{{$cat->test_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4" >
                            <div class="form-group">
                                <div class="form-line" id="test_category">
                                    <select class="form-control " name="test_category" >
                                        <option value="">Select Test Category</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </form>

                    <button onclick="searchReport('searchTestForm','<?php echo url('search_test_question'); ?>','reload_data',
                            '<?php echo url('test_question'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        Search Test Questions
                    </button>
                </div>
                <div class="body row">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                        <li role="presentation" class="active"><a href="#answer_option" data-toggle="tab">Question and Answer Options</a></li>
                        <li role="presentation"><a href="#text_answer" data-toggle="tab">Question and Text Answer</a></li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content ">
                        <div role="tabpanel" class="tab-pane fade in active" id="answer_option">
                            <b>Question and Answer Options</b>

                            <form name="questOptionForm" id="questOptionForm" onsubmit="false;" class="form form-horizontal container" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" id="test_options" name="test" onchange="fillNextInput('test_options','category_options','<?php echo url('default_select'); ?>','test_cat')">
                                                    <option value="">Select Test</option>
                                                    @foreach($mainData as $cat)
                                                        <option value="{{$cat->id}}">{{$cat->test_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4" >
                                        <div class="form-group">
                                            <div class="form-line" id="category_options">
                                                <select class="form-control " name="test_category" >
                                                    <option value="">Select Test Category</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea id="question_option" name="question" class="ckeditor" placeholder="Message">Question Here...</textarea>
                                                <script>
                                                    CKEDITOR.replace('question_option');
                                                </script>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr/>

                                @for($i=1; $i<=5;$i++)
                                    <div class="row">
                                        <input type="radio" id="radio_id{{$i}}" class="radio-col-green with-gap" value="answer{{$i}}" name="correct_answer" >
                                        <label for="radio_id{{$i}}" >Correct Answer</label>
                                        <div class="col-sm-1 ">
                                            <div class="form-group pull-right">
                                                <div class="form-line">
                                                    <input type="text" class="form-control " value="{{$i}}" disabled name="radio{{$i}}" >
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" value="answer{{$i}}" name="answer_type{{$i}}" />
                                        <div class="col-sm-7 ">
                                            <div class="form-group pull-right">
                                                <div class="form-line">
                                                    <textarea id="answer{{$i}}" name="answers{{$i}}" class="ckeditor" placeholder="Answer Here..."></textarea>
                                                    <script>
                                                        CKEDITOR.replace('answer{{$i}}');
                                                        CKEDITOR.config.height = 70;     // 500 pixels wide.
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                @endfor
                                <hr/>
                                <input type="hidden" value="0" name="text_type"/>
                            </form>
                            <div class="row">
                                <div class="col-sm-11">
                                    <button onclick="submitQuestDefault('question_option','questOptionForm','<?php echo url('create_test_question'); ?>','reload_data',
                                            '<?php echo url('test_question'); ?>','<?php echo csrf_token(); ?>','answer1','answer2','answer3','answer4','answer5')" type="button" class="btn btn-info waves-effect pull-right">
                                        SAVE
                                    </button>
                                </div>

                            </div>

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="text_answer">
                            <b>Question and Text Answer</b>
                            <form name="questTextForm" id="questTextForm" onsubmit="false;" class="form form-horizontal container" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select class="form-control" id="test_text" name="test" onchange="fillNextInput('test_text','category_text','<?php echo url('default_select'); ?>','test_cat')">
                                                    <option value="">Select Test</option>
                                                    @foreach($mainData as $cat)
                                                        <option value="{{$cat->id}}">{{$cat->test_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4" >
                                        <div class="form-group">
                                            <div class="form-line" id="category_text">
                                                <select class="form-control " name="test_category" >
                                                    <option value="">Select Test Category</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea id="question_text" name="question" class="ckeditor" placeholder="Message">Question Here...</textarea>
                                                <script>
                                                    CKEDITOR.replace('question_text');
                                                </script>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr/>
                                @for($i=1; $i<=5;$i++)
                                    <input type="hidden" id="answer{{$i}}" name="answers{{$i}}"/>
                                @endfor

                                <input type="hidden" value="1" name="text_type"/>
                            </form>
                            <div class="row">
                                <div class="col-sm-11 ">
                                    <button onclick="submitQuestDefault('question_text','questTextForm','<?php echo url('create_test_question'); ?>','reload_data',
                                            '<?php echo url('test_question'); ?>','<?php echo csrf_token(); ?>','answer1','answer2','answer3','answer4','answer5')" type="button" class="btn btn-info waves-effect pull-right">
                                        SAVE
                                    </button>
                                </div>
                            </div>

                        </div>


                    </div>

                </div>
                <div class="body table-responsive" id="reload_data">



                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    function submitQuestDefault(questId,formId,submitUrl,reload_id,reloadUrl,token,id1,id2,id3,id4,id5){
        var inputVars = $('#'+formId).serialize();
        var quest = encodeURIComponent(CKEDITOR.instances[questId].getData());
        var ans1 = encodeURIComponent(CKEDITOR.instances[id1].getData());
        var ans2 = encodeURIComponent(CKEDITOR.instances[id2].getData());
        var ans3 = encodeURIComponent(CKEDITOR.instances[id3].getData());
        var ans4 = encodeURIComponent(CKEDITOR.instances[id4].getData());
        var ans5 = encodeURIComponent(CKEDITOR.instances[id5].getData());

        var postVars = inputVars+'&question='+quest+'&answer1='+ans1+'&answer2='+ans2+'&answer3='+ans3+'&answer4='+ans4+'&answer5='+ans5;
        //alert(postVars);
        //$('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                //$('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){

                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", "Data saved successfully!", "success");

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                //searchReport(formId,'<?php echo url('search_test_question'); ?>','reload_data','<?php echo url('test_question'); ?>','<?php echo csrf_token(); ?>');
            }
        }

    }

    function submitQuestDefaultEdit(questId,formId,submitUrl,reload_id,reloadUrl,token,id1,id2,id3,id4,id5,type){
        var inputVars = $('#'+formId).serialize();
        var getType = $('#'+type).val();
        var postVars = '';
        var quest = encodeURIComponent(CKEDITOR.instances[questId].getData());
        if(getType == 0){
            var ans1 = encodeURIComponent(CKEDITOR.instances[id1].getData());
            var ans2 = encodeURIComponent(CKEDITOR.instances[id2].getData());
            var ans3 = encodeURIComponent(CKEDITOR.instances[id3].getData());
            var ans4 = encodeURIComponent(CKEDITOR.instances[id4].getData());
            var ans5 = encodeURIComponent(CKEDITOR.instances[id5].getData());
             postVars = inputVars+'&question='+quest+'&answer1='+ans1+'&answer2='+ans2+'&answer3='+ans3+'&answer4='+ans4+'&answer5='+ans5;

        }else{
             postVars = inputVars+'&question='+quest;
        }

        //$('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                //$('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){

                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", "Data saved successfully!", "success");

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

            }
        }

    }

    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getProducts(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });

    function getProducts(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

</script>

    <script>
        /*$(function() {
            $( ".datepicker" ).datepicker({
                /!*changeMonth: true,
                changeYear: true*!/
            });
        });*/
    </script>

@endsection