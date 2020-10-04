
<!-- Example Tab -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                   {{$testSession->session_name}}
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
            <?php $allCat = $mainData->category; $firstId = $allCat[0]->id; ?>
            <div class="body" id="main_table">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    @foreach($mainData->category as $cat)
                            <li role="presentation" class="
                            <?php
                            $active = ($cat->id == $mainData->showCat) ? 'active' : ''; echo $active;
                            $disabled = ($mainData->showCat == $cat->id ) ? '' : ($cat->resultCheck == 1) ? '' : 'disabled'; echo $disabled;
                            ?>
                                    ">
                                <a href="#cat_tab{{$cat->id}}" data-toggle="tab">{{$cat->category_name}}</a>
                            </li>
                    @endforeach
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                @foreach($mainData->category as $cat)

                        <div role="tabpanel" class="tab-pane fade <?php $active = ($cat->id == $mainData->showCat) ? 'in active' : ''; echo $active; ?>" id="cat_tab{{$cat->id}}">
                            <h4>{{$mainData->test_name}} -- ({{$cat->category_name}})</h4>
                            @if($cat->resultCheck == '0' && $mainData->showCat == $cat->id)
                            &nbsp; <h3>Time Remaining:--   &nbsp;&nbsp;<span id="timing{{$mainData->showCat}}"></span></h3><hr/>
                            @endif
                            <p>{{$mainData->test_desc}}</p><hr/>



                        @if($cat->resultCheck != '1')    <!-- IF LOGGED IN USER HAVE NOT TAKEN TEST SESSION FOR CURRENT CATEGORY, DISPLAY CATEGORY QUESTIONS  -->
                            <form name="testForm{{$cat->id}}" id="testForm{{$cat->id}}" onsubmit="false;" class="form form-horizontal container" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="session" value="{{$testSession->id}}" />
                                <input type="hidden" name="test" value="{{$testSession->test_id}}" />
                                <input type="hidden" name="test_category" value="{{$cat->id}}" />
                                <input type="hidden" name="countQuest" value="{{$cat->questCount}}" />
                                <input type="hidden" name="resultCheck" value="{{$cat->resultCheck}}" />

                                @foreach($cat->questions as $quest)
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

                                                <input type="radio" id="{{$cat->category_name}}{{$ans->id}}" class="radio-col-green with-gap" value="{{$ans->id}}|{{$ans->correct_status}}" name="answer{{$quest->quest_number}}" >
                                                <label for="{{$cat->category_name}}{{$ans->id}}" >{!!$ans->answer!!}</label>
                                                <div class="row">
                                                    <div class="col-sm-1 ">
                                                        <div class="form-group pull-right">
                                                            <div class="form-line"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 ">
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

                            @if($cat->questCount > 0)

                                <div class="row">
                                    <div class="col-sm-11">
                                        <button id="buttonId{{$cat->id}}_uid_{{\App\Helpers\Utility::checkAuth('temp_user')->id}}_{{csrf_field()}}" onclick="submitTestDefault('testForm{{$cat->id}}','<?php echo url('submit_test_form'); ?>','reload_data',
                                                '<?php echo url('test_list'); ?>','<?php echo csrf_token(); ?>','buttonId{{$cat->id}}')" type="button" class="btn btn-info waves-effect pull-right">
                                            Submit Test Category
                                        </button><hr/>
                                    </div>

                                </div>

                            @endif

                            @else   <!-- IF LOGGED IN USER HAVE TAKEN TEST SESSION FOR CURRENT CATEGORY, DO NOT DISPLAY CATEGORY QUESTIONS  -->
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-7">
                                    <p class="btn-link "> <i class="fa fa-check-circle fa-2x btn-success"></i> You have submitted your views/answers for this Test Category</p>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="row">
                                <table class="table table-responsive table-bordered table-hover table-striped">
                                    <tr>
                                        <td><h4>Percentage Score:--</h4></td>
                                        <td><h4>{{$cat->scorePerct}}% out of 100%</h4></td>
                                    </tr>
                                    <tr>
                                        <td><h4>Score:--</h4></td>
                                        <td><h4>{{$cat->scoreAns}} out of {{$cat->overallAns}}</h4></td>
                                    </tr>
                                </table>
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
    function submitTestDefault(formId,submitUrl,reload_id,reloadUrl,token,buttonId){
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

    function startTimer(duration, display,triggerB) {

        var durationSecs = parseInt(duration*60);
        var timed = durationSecs, hours, minutes, seconds;
         //window.localStorage.setItem('currTime', '0');

        var timer = (window.localStorage.getItem(triggerB) === null) ? timed : window.localStorage.getItem(triggerB);
        console.log(timer);
        setInterval(function () {
            hours = parseInt((timer / 60)/60, 10);
            minutes = parseInt(((timer/60) % 60), 10);
            seconds = parseInt(timer % 60, 10);

            hours = hours > 9 ? hours : "0" + hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = hours + "hr(s) :" +minutes + "mins :" + seconds + "secs";

            //timer--
            var trigger = $("#"+triggerB);
            if (timer < 1 && timer == 0) {
                //timer = duration;
                clearInterval(timer);
                trigger.trigger('click');
                trigger.attr("disabled", true);
                window.localStorage.removeItem(triggerB);
            }else{
                timer--;
                window.localStorage.setItem(triggerB, timer);
            }
        }, 1000);
    }

    window.onload = function () {
        var timing = '{{$mainData->showDuration}}';
        var triggerButton = 'buttonId{{$mainData->showCat}}_uid_{{\App\Helpers\Utility::checkAuth('temp_user')->id}}_{{csrf_field()}}';
        var display = document.querySelector('#timing{{$mainData->showCat}}');
        startTimer(timing, display,triggerButton);
    };

</script>