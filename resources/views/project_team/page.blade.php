<!-- Default Size -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Add Team Member(s)</h4>
            </div>
            <div class="modal-body" style="height:400px; overflow:scroll;">

                <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="body">

                        <div class="row clearfix">

                            <div class="col-sm-4" id="normal_user">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Select User">

                                        <input type="hidden" class="user_class" name="user" id="user" />
                                    </div>
                                </div>
                                <ul id="myUL1" class="myUL"></ul>
                            </div>

                            <div class="col-sm-4" id="temp_user" style="display:none;">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" autocomplete="off" id="select_users" onkeyup="searchOptionList('select_users','myUL','{{url('default_select')}}','default_search_temp_dept','users');" name="select_user" placeholder="Select External/Contract User">

                                        <input type="hidden" class="" name="user" id="users" />
                                    </div>
                                </div>
                                <ul id="myUL" class="myUL"></ul>
                            </div>

                            <div class="col-sm-4" id="hide_button">
                                <div class="form-group">
                                    <div onclick="addMore('add_more','hide_button','1','<?php echo URL::to('add_more'); ?>','team_member','hide_button');">
                                        <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <input type="checkbox" class="change_user" value="1" onclick="changeUserT('normal_user','temp_user','change_user','user','users');" id="change_user" />Check to select contract/external user
                        <hr/>

                    </div>

                    <div id="add_more"></div>

                    <input type="hidden" value="{{$item->id}}" name="project_id" />
                </form>

            </div>
            <div class="modal-footer">
                <button onclick="submitMediaFormClass('createModal','createMainForm','<?php echo url('create_project_team'); ?>','reload_data',
                        '<?php echo url('project/'.$item->id.'/project_team'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>',['user_class','change_user'])" type="button" class="btn btn-link waves-effect">
                    SAVE
                </button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Default Size -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
            </div>
            <div class="modal-body" id="edit_content">

            </div>
            <div class="modal-footer">
                <button onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_project_team'); ?>','reload_data',
                        '<?php echo url('project/'.$item->id.'/project_team'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                    SAVE
                </button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<div class=""> <!-- style="overflow:hidden" -->

    <div class="clearfix"></div>
    <div class="row ">
        <div class="col-md-12" style="">
            <div id="MyAccountsTab" class="tabbable tabs-left">
                <!-- Account selection for desktop - I -->
                @include('includes.project_menu',['item',$item])

                <div class="tab-content col-md-10" style="">
                    <div class="tab-pane active" id="overview"><!--style="padding-left: 60px; padding-right:100px"-->
                        <div class="col-md-offset-1">
                            <div class="row" style="line-height: 14px; margin-bottom: 34.5px;">


                                <!-- Bordered Table -->
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="card">
                                            <div class="header">
                                                <h2>
                                                    Team Members
                                                </h2>
                                                <ul class="header-dropdown m-r--5">
                                                    @if(\App\Helpers\Utility::authColumn('temp_user') != 'temp_user')
                                                    @if($item->project_head == \App\Helpers\Utility::checkAuth('temp_user')->id )
                                                    <li>
                                                        <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                                                    </li>
                                                    <li>
                                                        <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('project/'.$item->id.'/project_team'.\App\Helpers\Utility::authLink('temp_user')); ?>',
                                                                '<?php echo url('delete_project_team'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                                            <i class="fa fa-trash-o"></i>Delete
                                                        </button>
                                                    </li>
                                                    @endif
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
                                            <div class="body table-responsive" id="reload_data">
                                                <table class="table table-bordered table-hover table-striped" id="main_table">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                                                   name="check_all" class="" />

                                                        </th>

                                                        <th>Manage</th>
                                                        <th>Project</th>
                                                        <th>Assigned User</th>
                                                        <th>Created by</th>
                                                        <th>Created at</th>
                                                        <th>Updated by</th>
                                                        <th>Updated at</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($mainData as $data)
                                                        <tr>
                                                            <td scope="row">
                                                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                                            </td>
                                                            @if(\App\Helpers\Utility::authColumn('temp_user') != 'temp_user')
                                                            @if($item->project_head != \App\Helpers\Utility::checkAuth('temp_user')->id || in_array(\App\Helpers\Utility::checkAuth('temp_user')->role,\App\Helpers\Utility::TOP_USERS))
                                                            <td>
                                                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_project_team_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                                            </td>
                                                            @endif
                                                            @else
                                                             <td></td>
                                                            @endif
                                                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                                            <td>{{$data->project->project_name}}</td>
                                                            <td>
                                                                @if(!empty($data->user_id))
                                                                    {{$data->member->firstname}}&nbsp;{{$data->member->lastname}}
                                                                @else
                                                                    {{$data->extUser->firstname}}&nbsp;{{$data->extUser->lastname}}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($data->created_by != '0')
                                                                    {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                                                @endif
                                                            </td>
                                                            <td>{{$data->created_at}}</td>
                                                            <td>
                                                                @if($data->updated_by != '0')
                                                                    {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                                                                @endif
                                                            </td>
                                                            <td>{{$data->updated_at}}</td>


                                                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                                <div class="task pagination pull-left">
                                                    {!! $mainData->render() !!}
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <!-- #END# Bordered Table -->

                            </div>
                        </div>
                    </div>

                </div>
                <!-- Account selection for desktop - F -->
            </div>
        </div>
    </div>
</div>

<!-- END OF TABS -->

<script>

    //SUBMIT FORM WITH A FILE
    function submitMediaFormClass(formModal,formId,submitUrl,reload_id,reloadUrl,token,classList){
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);

        var postVars = new FormData(form);
        postVars.append('token',token);
        appendClassToPost(classList,postVars);
        
        $('#'+formModal).modal('hide');
        //DISPLAY LOADING ICON
        overlayBody('block');
        sendRequestMediaForm(submitUrl,token,postVars)
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
					resetForm(formId);
                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", successMessage, "success");
                    //location.reload();

                }else{

                    //alert(message2);

                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id,reloadUrl);
            }
        }

    }


</script>

<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        //page = window.location.hash.replace('#','');
        //getProducts(page);
    });

    $(document).on('click','#task .pagination a', function(e){
        e.preventDefault();
        /*var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;*/
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
    $(function() {
        $( ".datepicker2" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>
