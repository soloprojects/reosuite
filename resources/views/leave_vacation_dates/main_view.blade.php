@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Leave Vacation Date(s)</h4>
                </div>
                <div class="modal-body">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix" >
                                @if(in_array(Auth::user()->role,Utility::HR_MANAGEMENT))
                                <div class="col-sm-8" id="all_users">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select User">

                                            <input type="hidden" class="user_class" name="user" id="user" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>
                                <div class="col-sm-3" id="">
                                    <b>Check to add for self</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="checkbox" class="form-control" autocomplete="off" id="switch_user" onclick="switchUser('switch_user','all_users');" name="change_user" value="1" placeholder="Change User">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else

                            <input type="hidden" name="user" value="{{Auth::user()->id}}">

                            @endif

                            @for($i=1;$i<=4;$i++)
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select type="text" class="form-control" name="week{{$i}}" placeholder="Week {{$i}}">
                                                <option value="">Select Week</option>    
                                                @for($j=1;$j<=4;$j++)
                                                    <option value="{{$j}}">Week {{$j}}</option>
                                                @endfor
                                            </select>    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select type="text" class="form-control" name="month{{$i}}" placeholder="Month {{$i}}">
                                                <option value="">Select Month</option>    
                                                @for($k=1;$k<=12;$k++)
                                                    <option value="{{$k}}">{{date("F", mktime(0, 0, 0, $k, 10))}}</option>
                                                @endfor
                                            </select>    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select type="text" class="form-control" name="year{{$i}}" placeholder="Year {{$i}}">
                                                <option value="">Select Year</option>    
                                                @for($l=date('Y')+5;1980 <= $l;$l--)
                                                    <option value="{{$l}}">{{$l}}</option>
                                                @endfor
                                            </select>    
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endfor
                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitDefaultModified('createModal','createMainForm','<?php echo url('create_leave_vacation_dates'); ?>','reload_data',
                            '<?php echo url('leave_vacation_dates'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitDefault('editModal','editMainForm','<?php echo url('edit_leave_vacation_dates'); ?>','reload_data',
                            '<?php echo url('leave_vacation_dates'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
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
                        Leave Vacation Dates
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('leave_vacation_dates'); ?>',
                                    '<?php echo url('delete_leave_vacation_dates'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
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
                <div class="body table-responsive" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>User</th>
                            <th>Week</th>
                            <th>Month</th>
                            <th>Year</th>
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
                            <td>{{$data->user->firstname}} {{$data->user->lastname}}</td>
                            <td>Week {{$data->week}}</td>
                            <td>{{date("F", mktime(0, 0, 0, $data->month, 10)) }}</td>
                            <td>{{$data->year}}</td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->updated_at}}</td>
                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_leave_vacation_dates_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
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

function submitDefaultModified(formModal,formId,submitUrl,reload_id,reloadUrl,token){
        var inputVars = $('#'+formId).serialize();
        
        var postVars = inputVars;
        $('#'+formModal).modal('hide');
        //DISPLAY LOADING ICON
        overlayBody('block');

        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                //HIDE LOADING ICON
                overlayBody('none');
               
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){
                    //RESET FORM
                    //resetForm(formId);
                   var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", "Data saved successfully!", "success");

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id,reloadUrl);
            }
        }

    }

    function switchUser(checkboxId,allUsersId){
        var checkId = _(checkboxId);
        var allUsers = getId(allUsersId);
        if(checkId.checked){
            allUsers.hide();
        }else{
            allUsers.show();
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