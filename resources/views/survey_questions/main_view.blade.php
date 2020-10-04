@extends('layouts.app')

@section('content')



    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Survey Questions and Answers
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
                    <form name="import_excel" id="searchSurveyForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control" id="survey_id" name="survey" onchange="fillNextInput('survey_id','department','<?php echo url('default_select'); ?>','survey_dept')">
                                        <option value="">Select Survey</option>
                                        @foreach($mainData as $cat)
                                            <option value="{{$cat->id}}">{{$cat->survey_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4" >
                            <div class="form-group">
                                <div class="form-line" id="department">
                                    <select class="form-control " name="department" >
                                        <option value="">Select Department</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </form>

                    <button onclick="searchReport('searchSurveyForm','<?php echo url('search_survey_question'); ?>','reload_data',
                            '<?php echo url('survey_question'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        Search Survey
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
                                                <select class="form-control" id="survey_options" name="survey" onchange="fillNextInput('survey_options','department_options','<?php echo url('default_select'); ?>','survey_dept')">
                                                    <option value="">Select Survey</option>
                                                    @foreach($mainData as $cat)
                                                        <option value="{{$cat->id}}">{{$cat->survey_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4" >
                                        <div class="form-group">
                                            <div class="form-line" id="department_options">
                                                <select class="form-control " name="department" >
                                                    <option value="">Select Department</option>
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
                                                    CKEDITOR.config.height = 100;     // 500 pixels tall.
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
                                                    <option value="">Select Question Category</option>
                                                    @foreach($questCat as $cat)
                                                        <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>

                                @for($i=1; $i<=5;$i++)
                                    <div class="row">
                                        <div class="col-sm-2 ">
                                            <div class="form-group pull-right">
                                                <div class="form-line">
                                                    <input type="text" class="form-control " value="Answer {{$i}}" disabled name="" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 ">
                                            <div class="form-group pull-right">
                                                <div class="form-line">
                                                    <select class="form-control " name="answer{{$i}}" >
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
                                <hr/>
                                <input type="hidden" value="0" name="text_type"/>
                            </form>
                            <div class="row">
                                <div class="col-sm-11">
                                    <button onclick="submitQuestDefault('question_option','questOptionForm','<?php echo url('create_survey_question'); ?>','reload_data',
                                            '<?php echo url('survey_question'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect pull-right">
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
                                                <select class="form-control" id="survey_text" name="survey" onchange="fillNextInput('survey_text','department_text','<?php echo url('default_select'); ?>','survey_dept')">
                                                    <option value="">Select Survey</option>
                                                    @foreach($mainData as $cat)
                                                        <option value="{{$cat->id}}">{{$cat->survey_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4" >
                                        <div class="form-group">
                                            <div class="form-line" id="department_text">
                                                <select class="form-control " name="department" >
                                                    <option value="">Select Department</option>
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
                                                    <option value="">Select Question Category</option>
                                                    @foreach($questCat as $cat)
                                                        <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <input type="hidden" value="1" name="text_type"/>
                            </form>
                            <div class="row">
                                <div class="col-sm-11 ">
                                    <button onclick="submitQuestDefault('question_text','questTextForm','<?php echo url('create_survey_question'); ?>','reload_data',
                                            '<?php echo url('survey_question'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect pull-right">
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

    function submitQuestDefault(questId,formId,submitUrl,reload_id,reloadUrl,token){
        var inputVars = $('#'+formId).serialize();
        var quest = encodeURIComponent(CKEDITOR.instances[questId].getData());
        var postVars = inputVars+'&question='+quest;
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
                //searchReport(formId,'<?php echo url('search_survey_question'); ?>','reload_data','<?php echo url('survey_question'); ?>','<?php echo csrf_token(); ?>');
            }
        }

    }

    function submitQuestDefaultEdit(questId,formId,submitUrl,reload_id,reloadUrl,token){
        var inputVars = $('#'+formId).serialize();
        var quest = encodeURIComponent(CKEDITOR.instances[questId].getData());
        var postVars = inputVars+'&question='+quest;
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