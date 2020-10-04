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

                    <!-- Tabs With Icon Title -->

                                    <form name="import_excel" id="createMainForm2" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                                        <div class="container body">
                                            <div class="row clearfix">
                                                <div class="row clearfix">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select User">

                                                                <input type="hidden" class="user_class" name="user" id="user" />
                                                            </div>
                                                        </div>
                                                        <ul id="myUL1" class="myUL"></ul>
                                                    </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <textarea rows="6" cols="30" class="" name="short_term" placeholder="Short Term Goals"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <textarea rows="6" cols="30" class="" name="long_term" placeholder="Long Term Goals"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div><hr>

                                            <div class="row clearfix">

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <textarea  class="" name="dev_obj" placeholder="Development Objectives (KSAs) needed to reach goal."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <textarea  class="" name="dev_assign" placeholder="Developmental Assignments, etc., including target completion dates."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <textarea  class="" name="other_activities" placeholder="other_activities"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div><hr>


                                            {{--<div class="row clearfix">--}}
                                            <table class="table table-responsive">
                                                <thead>
                                                <th>...</th>
                                                <th>Core Competencies</th>
                                                <th>Capabilities</th>
                                                <th>Individual Ratings</th>
                                                <th>...</th>
                                                <th>...</th>
                                                </thead>
                                                <tbody id="add_more_comp">
                                                <tr>
                                                    <td>
                                                            <div class="col-sm-4" id="hide_button_comp">
                                                                <div class="form-group">
                                                                    <div onclick="addMore('add_more_comp','hide_button_comp','1','<?php echo URL::to('add_more'); ?>','idp_comp_assess','hide_button_comp');">
                                                                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                    </td>

                                                        <td>
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <div class="form-line">
                                                                        <select class=" core_comp" name="core_comp" id="core_comp" onchange="fillNextInput('core_comp','capable','<?php echo url('default_select'); ?>','core_tech_comp')">
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
                                                                    <div class="form-line capable" id="capable" >
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
                                                                        <select  class="form-control comp_level" name="comp_level" >
                                                                            <option value="" selected>Level</option>
                                                                            @foreach(APP\Helpers\Utility::REVIEW_LEVEL as $key => $val)
                                                                                <option value="{{$val}}">{{$val}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                </tr>


                                                </tbody>
                                            </table>
                                            {{-- </div>--}}
                                            <div class="row clearfix">

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <textarea rows="6" cols="30" disabled class="" name="remarks" placeholder="Remarks"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <textarea rows="6" cols="30" disabled class="" name="formal_training" placeholder="Formal Training"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input type="text" disabled class="datepicker" name="target_completed_date" placeholder="Target Completed Date">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input class="datepicker" disabled name="actual_completed_date" placeholder="Actual Completed Date">
                                                            </div>
                                                        </div>
                                                    </div>


                                            </div>


                                        </div>
                                     </div>

                                    </form>

                                    <br><br>
                                    <button onclick="save2('createModal','createMainForm2','<?php echo url('create_idp'); ?>','reload_data',
                                            '<?php echo url('idp'); ?>','<?php echo csrf_token(); ?>','core_comp','capable','comp_level')" type="button" class="pull-right btn btn-info waves-effect">
                                        SAVE
                                    </button>
                                    <button type="button" class="pull-right btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>


                    </div>
                    <!-- #END# Tabs With Icon Title -->

                    <!--    -->

                </div>
                {{--<div class="modal-footer">

                </div>--}}
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
                {{--<div class="modal-footer">

                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>--}}
            </div>
        </div>
    </div>


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Individual Development Plan
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        {{--@if($lowerHodId == Auth::user()->id && $hodId != Auth::user()->id)--}}
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('idp'); ?>',
                                    '<?php echo url('delete_idp'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>

                        {{--@endif--}}
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
                                        <input type="text" class="form-control" autocomplete="off" id="select_user_search" onkeyup="searchOptionList('select_user_search','myUL','{{url('default_select')}}','default_search','user_search');" name="select_user" placeholder="Select User">

                                        <input type="hidden" class="user_class" name="user" id="user_search" />
                                    </div>
                                </div>
                                <ul id="myUL" class="myUL"></ul>
                            </div>

                        </form>
                    </div>

                    <button onclick="searchReport('searchFrameForm','<?php echo url('search_idp'); ?>','reload_data',
                            '<?php echo url('idp'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        Search
                    </button>

                </div>


                <div class="body table-responsive tbl_scroll" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Full name</th>
                            <th>Coach Name</th>
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
                            <td>{{$data->user_detail->firstname}} {{$data->user_detail->lastname}}</td>
                            <td>{{$data->coach->firstname}} {{$data->coach->lastname}}</td>

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
                               <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_idp_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>

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

    function save2(formModal,formId,submitUrl,reload_id,reloadUrl,token,core_comp,capable,level) {
        var inputVars = $('#' + formId).serialize();
        var summerNote = '';
        var htmlClass = document.getElementsByClassName('t-editor');
        if (htmlClass.length > 0) {
            summerNote = $('.summernote').eq(0).summernote('code');
            ;
        }

        var core_comp1 = classToArray2(core_comp);
        var capable1 = classToArray2(capable);
        var level1 = classToArray2(level);
        var jcore_comp = JSON.stringify(core_comp1);
        var jcapable = JSON.stringify(capable1);
        var jlevel = JSON.stringify(level1);

        if(arrayItemEmpty(core_comp1) == false && arrayItemEmpty(level1) == false){
            var postVars = inputVars + '&editor_input=' + summerNote+'&core_comp='+jcore_comp+'&capable='+jcapable+'&level='+jlevel;
            //alert(postVars);
            
            $('#' + formModal).modal('hide');
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

                        //RESET FORM
						resetForm(formId);
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