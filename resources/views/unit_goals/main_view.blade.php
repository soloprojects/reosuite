@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Entry</h4>
                </div>
                <div class="modal-body" style="overflow:scroll; height:500px;">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" name="goal_set" >
                                                <option value="">Goal Set</option>
                                                @foreach($unitGoalSeries as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control " name="unit_goal_category" >
                                                <option value="">Unit Goal Category</option>
                                                @foreach($unitGoalCat as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div><hr>

                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            @if($hod == App\Helpers\Utility::HOD_DETECTOR)
                                            <input type="text" class="form-control"  name="wps" placeholder="Weight Performance Score">
                                            @else
                                            <input type="text" class="form-control" disabled name="wps" placeholder="Weight Performance Score">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea rows="6" cols="80" class=""  name="program" placeholder="Program"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{--<div class="row clearfix">--}}
                            <table class="table table-responsive">
                                <thead>
                                <th>...</th>
                                <th>Strategic Objectives</th>
                                <th>Measurements</th>
                                <th>Target Q1</th>
                                <th>Target Q2</th>
                                <th>Target Q3</th>
                                <th>Target Q4</th>
                                <th>Overall Perf. Score %</th>
                                <th>...</th>
                                <th>...</th>
                                </thead>
                                <tbody id="add_more">
                                <tr>
                                    <td>
                                        @if($lowerHod == App\Helpers\Utility::HOD_DETECTOR)
                                        <div class="col-sm-4" id="hide_button">
                                            <div class="form-group">
                                                <div onclick="addMore('add_more','hide_button','1','<?php echo URL::to('add_more'); ?>','unit_goal','hide_button');">
                                                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <textarea rows="6" class=" strat_obj" name="strat_obj" placeholder="Strategic Objective"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <textarea rows="6" class=" measure" name="measure" placeholder="Measurement"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <textarea rows="6" class="q1" name="q1" placeholder="Target Q1"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <textarea rows="6" class="q2" name="q2" placeholder="Target Q2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <textarea rows="6" class="q3" name="q3" placeholder="Target Q3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <textarea rows="6" class="q4" name="q4" placeholder="Target Q4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    @if($hod == App\Helpers\Utility::HOD_DETECTOR)
                                        <td>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea rows="6" class="ops" name="over_perf_score" placeholder="over_perf_score"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @else
                                        <td>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea rows="6" class="ops" disabled name="over_perf_score" placeholder="over_perf_score">
                                                            Awaiting Score
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @endif


                                </tr>


                                </tbody>
                                </table>


                           {{-- </div>--}}



                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="saveUnitGoal('createModal','createMainForm','<?php echo url('create_unit_goal'); ?>','reload_data',
                            '<?php echo url('unit_goal'); ?>','<?php echo csrf_token(); ?>','strat_obj','measure','q1','q2','q3','q4','ops')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content" style="overflow:scroll; height:500px;">

                </div>
                <div class="modal-footer">
                    @if($lowerHod == \App\Helpers\Utility::HOD_DETECTOR || $hod == \App\Helpers\Utility::HOD_DETECTOR)
                    <button onclick="saveUnitGoal('editModal','editMainForm','<?php echo url('edit_unit_goal'); ?>','reload_data',
                            '<?php echo url('unit_goal'); ?>','<?php echo csrf_token(); ?>','strat_obj_edit','measure_edit','q1_edit','q2_edit','q3_edit','q4_edit','ops_edit')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    @endif
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Unit Goals
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        @if($lowerHod == App\Helpers\Utility::HOD_DETECTOR)
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('unit_goal'); ?>',
                                    '<?php echo url('delete_unit_goal'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        @endif
                            @if($hod == \App\Helpers\Utility::HOD_DETECTOR)
                                <li>
                                    <button type="button" onclick="changeAppraisalStatus('kid_checkbox','reload_data','<?php echo url('individual_goal'); ?>',
                                            '<?php echo url('status_unit_goal'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                        <i class="fa fa-check-o"></i>Mark as complete
                                    </button>
                                </li>
                                <li>
                                    <button type="button" onclick="changeAppraisalStatus('kid_checkbox','reload_data','<?php echo url('individual_goal'); ?>',
                                            '<?php echo url('status_unit_goal'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                        <i class="fa fa-check-o"></i>Mark as incomplete
                                    </button>
                                </li>
                            @endif
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

                <div class="body">

                    <div class="row clearfix">
                        <form name="import_excel" id="searchFrameForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select  class="form-control " name="goal_set" >
                                            <option value="">Goal Set</option>
                                            @foreach($unitGoalSeries as $ap)
                                                <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select  class="form-control " name="department" id="dept" >
                                            <option value="">Department</option>
                                            @foreach($dept as $ap)
                                                <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @else
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control " name="department" id="dept" >
                                                <option value="{{Auth::user()->dept_id}} selected">My Department</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </form>
                        <button onclick="searchReport('searchFrameForm','<?php echo url('search_unit_goal'); ?>','reload_data',
                                '<?php echo url('unit_goal'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                            Search
                        </button>
                    </div>

                <div class="body table-responsive" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Goal Set</th>
                            <th>Department</th>
                            <th>Unit Goal Category</th>
                            <th>Weight Performance Score</th>
                            <th>Appraisal Status</th>
                            <th>Created by</th>
                            <th>Updated by</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->goal_set->goal_name}}</td>
                            <td>{{$data->department->dept_name}}</td>
                            <td>{{$data->u_goal_cat->category_name}}</td>
                            <td>{{$data->weight_perf_score}}</td>
                            <td>
                                @if($data->appraisal_status != '0')
                                    {{\App\Helpers\Utility::APPRAISAL_STATUS[1]}}
                                @else
                                    {{\App\Helpers\Utility::APPRAISAL_STATUS[0]}}
                                @endif
                            </td>
                            <td>
                                @if($data->created_by != '0')
                                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                @endif
                            </td>
                            <td>
                                @if($data->updated_by != '0')
                                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                                @endif
                            </td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->updated_at}}</td>
                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>
                                @if($hod == App\Helpers\Utility::HOD_DETECTOR)
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_unit_goal_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i>|Mark Appraisal</a>
                                @else
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_unit_goal_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class=" pagination pull-right">
                        {!! $mainData->render() !!}
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    function saveUnitGoal(formModal,formId,submitUrl,reload_id,reloadUrl,token,strat_obj,measure,q1,q2,q3,q4,ops) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var strat_obj1 = classToArray2(strat_obj);
        var measure1 = classToArray2(measure);
        var q11 = classToArray2(q1);
        var q21 = classToArray2(q2);
        var q31 = classToArray2(q3);
        var q41 = classToArray2(q4);
        var ops1 = classToArray2(ops);
        var jstrat_obj = sanitizeData(strat_obj);
        var jmeasure = sanitizeData(measure);
        var jq1 = sanitizeData(q1);
        var jq2 = sanitizeData(q2);
        var jq3 = sanitizeData(q3);
        var jq4 = sanitizeData(q4);
        var jops = sanitizeData(ops);
        //alert(jcompName);

        if(arrayItemEmpty(strat_obj1) == false && arrayItemEmpty(measure1) == false){
        var postVars = inputVars + '&editor_input=' + summerNote+'&q1='+jq1+'&q2='+jq2+'&q3='+jq3+'&q4='+jq4+'&ops='+jops+'&strat_obj='+jstrat_obj+'&measure='+jmeasure;
        //alert(postVars);

        $('#'+formModal).modal('hide');
        //DISPLAY LOADING ICON
        overlayBody('block');
        
        sendRequestForm(submitUrl, token, postVars)
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4 && ajax.status == 200) {

                //HIDE LOADING ICON
				overlayBody('none');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if (message2 == 'fail') {

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error", messageError, "error");

                } else if (message2 == 'saved') {

                    //DISPLAY LOADING ICON
                    overlayBody('block');
                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", "Data saved successfully!", "success");
                    location.reload();

                } else {

                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id, reloadUrl);
            }
        }
        //END OF OTHER VALIDATION CONTINUES HERE
        }else{
            swal("Warning!","Please, fill in all required fields to continue","warning");
        }

    }

</script>

<script>
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