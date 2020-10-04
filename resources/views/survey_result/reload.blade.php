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
                   Survey Result
                    <small></small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            @include('includes/export',[$exportId = 'reload_data', $exportDocId = 'reload_data'])
                        </ul>
                    </li>
                </ul>
            </div>
            <?php $allDept = $mainData->dept; $firstId = $allDept[0]->id; ?>
            <div class="body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    <li role="presentation" class="active"><a href="#report" data-toggle="tab">Report</a></li>
                @foreach($mainData->dept as $dept)
                        <li role="presentation" class=""><a href="#dept_tab{{$dept->id}}" data-toggle="tab">{{$dept->dept_name}}</a></li>
                @endforeach
                    <li role="presentation" class=""><a href="#participants" data-toggle="tab">Participants</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="report">

                        <ul class="nav nav-tabs tab-nav-right" role="tablist">
                            <li role="presentation" class="active"><a href="#report1" data-toggle="tab">Report 1(Option Score)</a></li>
                            <li role="presentation" class=""><a href="#report2" data-toggle="tab">Report 2(Category Score)</a></li>
                            <li role="presentation" class=""><a href="#report3" data-toggle="tab">Report 3(Total Score)</a></li>

                        </ul>

                        <div class="tab-content" id="report-tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="report1">
                                <b>{{$mainData->survey_name}}</b><hr/>
                                <p>{{$mainData->survey_desc}}</p><hr/>
                                @foreach($mainData->dept2 as $dept2)
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <h3>

                                                <span class=" label bg-black">{{$dept2->dept_name}}</span>
                                            </h3>
                                        </div>
                                        <div class="col-sm-4">
                                        </div>
                                    </div>
                                    @foreach($dept2->questionCategory as $category)
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <h5>

                                                    <span class=" lable bg-black">{{$category->category_name}} </span>
                                                </h5>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="btn-link">{{$category->questCatNumOption}} out of {{$category->questCatNum}} questions has options  </p>
                                            </div>
                                        </div>
                                        <?php $num = 0; ?>
                                        @foreach($category->answerCategory as $ans)
                                            <div class="row" id="tr_{{$ans->id}}">
                                                <form name="questOptionForm{{$ans->id}}" id="questOptionForm{{$ans->id}}" onsubmit="false;" class="form form-horizontal container" method="post" enctype="multipart/form-data">


                                                    <!-- BEGIN OF ANSWERS AND ANSWER CATEGORY -->
                                                    <?php $num++; ?>
                                                    <input type="hidden" name="answer_id{{$num}}" value="{{$ans->id}}" />
                                                    <div class="row">
                                                        <div class="col-sm-1">
                                                            <div class="form-group pull-right">
                                                                <div class="form-line">
                                                                    <p>{{$num}} </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3 ">
                                                            <div class="form-group ">
                                                                <div class="form-line">
                                                                    <p >{{$ans->category_name}} </p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="progress ">
                                                                <div class="progress-bar {{\App\Helpers\Utility::surveyPercentClass($ans->ansCatPerct)}} progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                                     aria-valuemax="100" style="width: {{$ans->ansCatPerct}}%">
                                                                    <span >{{$ans->ansCatPerct}}% </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1 ">
                                                            <div class="form-group pull-right">
                                                                <div class="form-line">

                                                                    <p >{{$ans->countQuestCatAnsCat}}/{{$category->countQuestCatAns}}</p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </form><hr/>


                                            </div>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </div><!-- END OF REPORT 1 TAB CONTENT -->

                            <div role="tabpanel" class="tab-pane fade in" id="report2">
                                <b>{{$mainData->survey_name}}</b><hr/>
                                <p>{{$mainData->survey_desc}}</p><hr/>

                                @foreach($mainData->dept as $dept)
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <h3>
                                                <span class=" label bg-black">{{$dept->dept_name}}</span>
                                            </h3>
                                        </div>
                                        <div class="col-sm-4">
                                        </div>
                                    </div>
                                    @foreach($dept->questionCategory as $category)
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <h5>

                                                    <span class=" label bg-black">{{$category->category_name}}</span>
                                                </h5>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="progress ">
                                                    <div class="progress-bar {{\App\Helpers\Utility::surveyPercentClass($category->catScore)}} progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                         aria-valuemax="100" style="width: {{$category->catScore}}%">
                                                        <span >{{$category->catScore}}% </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                @endforeach

                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="report3">
                                <b>{{$mainData->survey_name}}</b><hr/>
                                <p>{{$mainData->survey_desc}}</p><hr/>

                                @foreach($mainData->dept as $dept)
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h4 class="">
                                                <span class=" label bg-black">{{$dept->dept_name}}</span>
                                            </h4>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="progress ">
                                                <div class="progress-bar {{\App\Helpers\Utility::surveyPercentClass($dept->totalScore)}} progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                     aria-valuemax="100" style="width: {{$dept->totalScore}}%">
                                                    <span >{{$dept->totalScore}}% </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">

                                        </div>
                                    </div><hr/>
                                @endforeach
                            </div>

                        </div>  <!-- END OF REPORT TAB CONTENT -->

                    </div>

                    @foreach($mainData->dept as $dept)

                        <div role="tabpanel" class="tab-pane fade " id="dept_tab{{$dept->id}}">
                            <b>{{$mainData->survey_name}}</b><hr/>
                            <p>{{$mainData->survey_desc}}</p><hr/>




                            @foreach($dept->questionCategory as $category)
                                <div class="row">
                                    <div class="col-sm-7">
                                        <h3>

                                            <span class=" label bg-black">{{$category->category_name}}</span>
                                        </h3>
                                    </div>
                                    <div class="col-sm-4">
                                    </div>
                                </div>
                                @foreach($category->question as $quest)
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
                                                    <div class="form-group pull-right">
                                                        <div class="form-line">
                                                            <p class="btn-link">{{$quest->quest_number}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <p  class="btn-link" >{!!$quest->question!!}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2 ">
                                                    <div class=" pull-right">
                                                        <div class="">
                                                            <a onclick="fetchStatement('{{$quest->id}}','text_preview','textModal','<?php echo url('survey_participants') ?>','<?php echo csrf_token(); ?>','{{$mainData->sessionId}}','{{$mainData->participantType}}');"><span class="btn-link" >Total Participants -- {{$quest->countPeople}}</span></a>
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
                                                        <div class="col-sm-1">
                                                            <div class="form-group pull-right">
                                                                <div class="form-line">
                                                                    <p>{{$num}} </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3 ">
                                                            <div class="form-group ">
                                                                <div class="form-line">
                                                                    <p >{{$ans->ansCat->category_name}}</p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="progress ">
                                                                <div class="progress-bar {{\App\Helpers\Utility::surveyPercentClass($ans->userAnsPerct)}} progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                                     aria-valuemax="100" style="width: {{$ans->userAnsPerct}}%">
                                                                    <span >{{$ans->userAnsPerct}}% </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1 ">
                                                            <div class="form-group pull-right">
                                                                <div class="form-line">

                                                                    <p value="">{{$ans->userAnsRatioToPeople}} </p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @endforeach
                                            @else
                                                <div class="row">
                                                    <div class="col-md-2">

                                                    </div>
                                                    <div class="col-md-8">
                                                        <span></span>
                                                        <a style="cursor: pointer;" class="btn btn-info" onclick="fetchStatement('{{$quest->id}}','text_preview','textModal','<?php echo url('survey_statements') ?>','<?php echo csrf_token(); ?>','{{$mainData->sessionId}}','{{$mainData->participantType}}');">Click Here to View Participant statements</a>

                                                    </div>

                                                </div>
                                            @endif
                                        </form><hr/>


                                    </div>
                                @endforeach
                            @endforeach

                        </div>
                    @endforeach

                    <div role="tabpanel" class="tab-pane fade in " id="participants">

                        <table class="table table-bordered table-hover table-striped" id="main_table">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                           name="check_all" class="" />

                                </th>
                                <th>FullName</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mainData->participants as $data)

                                    <tr>
                                        <td scope="row">
                                            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />
                                        </td>
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <td>
                                             {{$data->title}}&nbsp;{{$data->firstname}}&nbsp;{{$data->othername}}&nbsp;{{$data->lastname}}
                                        </td>
                                        <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Example Tab -->

<script>

    function fetchStatement(dataId,displayId,modalId,submitUrl,token,param1,param2){

        var postVars = "dataId="+dataId+"&param1="+param1+"&param2="+param2;
        $('#'+modalId).modal('show');
        sendRequest(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                var ajaxData = ajax.responseText;
                $('#'+displayId).html(ajaxData);

            }
        }
        $('#'+displayId).html('LOADING DATA');

    }

    $(document).ready(function() {
        $('table.highchart').highchartTable();
    });
</script>

@endif

