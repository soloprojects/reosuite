
<!-- Example Tab -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                   {{$surveySession->session_name}}
                    <small></small>
                </h2>
                <ul class="header-dropdown m-r--5">
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
            <?php $allDept = $mainData->dept; $firstId = $allDept[0]->id; ?>
            <div class="body" id="main_table">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    @foreach($mainData->dept as $dept)
                        @if(\App\Helpers\Utility::authColumn('temp_user') != 'temp_user')
                            <li role="presentation" class="<?php $active = ($dept->id == $firstId) ? 'active' : ''; echo $active; ?>"><a href="#dept_tab{{$dept->id}}" data-toggle="tab">{{$dept->dept_name}}</a></li>
                        @else
                            @if(\App\Helpers\Utility::checkAuth('temp_user')->dept_id == $dept->id)
                                <li role="presentation" class="<?php $active = ($dept->id == $firstId) ? 'active' : ''; echo $active; ?> btn-link"><a href="#dept_tab{{$dept->id}}" data-toggle="tab">{{$dept->dept_name}}</a></li>
                            @else

                            @endif

                        @endif
                    @endforeach
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                @foreach($mainData->dept as $dept)

                        <div role="tabpanel" class="tab-pane fade <?php $active = ($dept->id == $firstId) ? 'in active' : ''; echo $active; ?>" id="dept_tab{{$dept->id}}">
                            <b>{{$mainData->survey_name}}</b><hr/>
                            <p>{{$mainData->survey_desc}}</p><hr/>



                        @if($dept->resultCheck != '1')    <!-- IF LOGGED IN USER HAVE NOT TAKEN SURVEY SESSION FOR CURRENT DEPT, DISPLAY DEPT QUESTIONS  -->
                            <form name="surveyForm{{$dept->id}}" id="surveyForm{{$dept->id}}" onsubmit="false;" class="form form-horizontal container" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="session" value="{{$surveySession->id}}" />
                                <input type="hidden" name="survey" value="{{$surveySession->survey_id}}" />
                                <input type="hidden" name="department" value="{{$dept->id}}" />
                                <input type="hidden" name="countQuest" value="{{$dept->questCount}}" />
                                <input type="hidden" name="resultCheck" value="{{$dept->resultCheck}}" />

                                @foreach($dept->questions as $quest)
                                    <div class="row" id="tr_{{$quest->id}}">

                                        <input type="hidden" name="text_type{{$quest->quest_number}}" value="{{$quest->text_type}}" />
                                        <input type="hidden" name="question_cat{{$quest->quest_number}}" value="{{$quest->cat_id}}" />

                                        <div class="row">

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
                                                        <input id="question{{$quest->id}}" name="question{{$quest->quest_number}}" value="{{$quest->id}}" type="hidden">

                                                    </div>
                                                </div>
                                                <p>{!!$quest->question!!}</p>
                                            </div>

                                        </div>
                                        <hr/>

                                        <!-- END OF QUESTION -->

                                        <!-- BEGIN OF ANSWERS -->
                                        @if($quest->text_type == '0')
                                            <?php $num = 0; ?>
                                            @foreach($quest->ans as $ans)
                                                <?php $num++; ?>

                                                <input type="radio" id="{{$dept->dept_name}}{{$ans->id}}" class="radio-col-green with-gap" value="{{$ans->id}}|{{$ans->ans_cat_id}}" name="answer{{$quest->quest_number}}" >
                                                <label for="{{$dept->dept_name}}{{$ans->id}}" >{{$ans->ansCat->category_name}}</label>
                                                <div class="row">
                                                    <div class="col-sm-1 ">
                                                        <div class="form-group pull-right">
                                                            <div class="form-line"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 ">
                                                        <div class="form-group pull-right">
                                                            <div class="form-line"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endforeach

                                        @else

                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <div class="form-group pull-right">
                                                        <div class="form-line">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <div class="form-group pull-right">
                                                        <div class="form-line">
                                                            <textarea id="question{{$quest->id}}" class="form-control" name="answer{{$quest->quest_number}}" placeholder="Click here to enter response to the question no. {{$quest->quest_number}} above..." ></textarea>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endif




                                    </div>
                                @endforeach
                            </form><hr/>

                            @if($dept->questCount > 0)
                                @if(\App\Helpers\Utility::authColumn('temp_user') != 'temp_user')   <!-- IF LOGGED IN USER IS NOT EXTERNAL USER -->
                                @if($dept->id == \App\Helpers\Utility::checkAuth('temp_user')->dept_id) <!-- IF DEPT IS SAME AS LOGGED IN USER'S DEPT, DO NOT DISPLAY SUBMIT BUTTON -->

                                @else   <!-- IF DEPT IS NOT SAME AS LOGGED IN USER'S DEPT DISPLAY SUBMIT BUTTON -->
                                <div class="row">
                                    <div class="col-sm-11">
                                        <button onclick="submitSurveyDefault('surveyForm{{$dept->id}}','<?php echo url('submit_survey_form'); ?>','reload_data',
                                                '<?php echo url('survey_list'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect pull-right">
                                            SAVE
                                        </button><hr/>
                                    </div>

                                </div>
                                @endif
                                @else   <!-- IF LOGGED IN USER IS AN EXTERNAL USER DISPLAY SUBMIT BUTTON -->

                                <div class="row">
                                    <div class="col-sm-11">
                                        <button id="buttonId{{$dept->id}}" onclick="submitSurveyDefault('surveyForm{{$dept->id}}','<?php echo url('submit_survey_form'); ?>','reload_data',
                                                '<?php echo url('survey_list'); ?>','<?php echo csrf_token(); ?>','buttonId{{$dept->id}}')" type="button" class="btn btn-info waves-effect pull-right">
                                            SAVE
                                        </button><hr/>
                                    </div>

                                </div>

                                @endif
                            @endif

                            @else   <!-- IF LOGGED IN USER HAVE TAKEN SURVEY SESSION FOR CURRENT DEPT, DO NOT DISPLAY DEPT QUESTIONS  -->
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-7">
                                    <p class="btn-link "> <i class="fa fa-check-circle fa-2x btn-success"></i> You have submitted your views/answers for this Department/Unit</p>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                        @endif


                        </div>


                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Example Tab -->

<script>
    function submitSurveyDefault(formId,submitUrl,reload_id,reloadUrl,token,buttonId){
        var inputVars = $('#'+formId).serialize();
        var postVars = inputVars+'';

        $("#"+buttonId).attr("disabled", true);

        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                //$('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){
                    $('#'+buttonId).removeAttr("disabled");
                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){

                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", "Data saved successfully!", "success");
                    location.reload();

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    $('#'+buttonId).removeAttr("disabled");
                    //var infoMessage = swalWarningError(message2);
                    swal("Warning!", message2, "warning");
                    //console.log(message2);
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

            }
        }

    }

    $(document).ready(function() {
        $('table.highchart').highchartTable();
    });
</script>