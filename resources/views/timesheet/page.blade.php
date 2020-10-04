<!-- Default Size -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Task(s)</h4>
            </div>
            <div class="modal-body" style="height:400px; overflow:scroll;">

                <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="body">

                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control" name="task">
                                        <option value="">Select Task</option>
                                        @foreach($task as $data)
                                            <option value="{{$data->id}}">{{$data->task}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control " name="timesheet_title" placeholder="Timesheet title">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea type="text" class="form-control" name="timesheet_details" placeholder="Timesheet Details"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr/>

                    <div class="row clearfix">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" class="form-control" name="work_hours" placeholder="Number of Work Hours ">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control datepicker" autocomplete="off" name="work_date" placeholder="Work Date">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="file" class="form-control" multiple="multiple" name="attachment[]" placeholder="Attachment">
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr/>

                    </div>

                    <input type="hidden" value="{{$item->id}}" name="project_id" />
                </form>

            </div>
            <div class="modal-footer">
                <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_timesheet'); ?>','reload_data',
                        '<?php echo url('project/'.$item->id.'/timesheet'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
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
                <button onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_timesheet'); ?>','reload_data',
                        '<?php echo url('project/'.$item->id.'/timesheet'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                    SAVE
                </button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Default Size Attachment-->
<div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Attachment</h4>
            </div>
            <div class="modal-body" id="attach_content">


            </div>
            <div class="modal-footer">
                <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('edit_timesheet_attachment'); ?>','reload_data',
                        '<?php echo url('project/'.$item->id.'/timesheet'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>')"
                        class="btn btn-link waves-effect">
                    SAVE CHANGES
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
                                                    Timesheet
                                                </h2>
                                                <ul class="header-dropdown m-r--5">

                                                    <li>
                                                        <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                                                    </li>
                                                    <li>
                                                        <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('project/'.$item->id.'/timesheet'.\App\Helpers\Utility::authLink('temp_user')); ?>',
                                                                '<?php echo url('delete_timesheet'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                                            <div class="body table-responsive tbl_scroll" id="reload_data">
                                                <table class="table table-bordered table-hover table-striped" id="main_table">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                                                   name="check_all" class="" />

                                                        </th>

                                                        <th>Manage</th>
                                                        <th>Attachment</th>
                                                        <th>Project</th>
                                                        <th>Task</th>
                                                        <th>Timesheet Title</th>
                                                        <th>Task Details</th>
                                                        <th>Timesheet Details</th>
                                                        <th>Full Name</th>
                                                        <th>Work Hours (Time Log)</th>
                                                        <th>Work Date</th>
                                                        <th>Approval</th>
                                                        <th>Approval Status</th>
                                                        <th>Created at</th>
                                                        <th>Updated at</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($mainData as $data)
                                                        <tr>
                                                            <td scope="row">
                                                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                                            </td>
                                                            <td>
                                                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_timesheet_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                                            </td>
                                                            <td>
                                                                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_timesheet_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                                            </td>
                                                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                                            <td>{{$data->project->project_name}}</td>
                                                            <td>{{$data->taskName->task}}</td>
                                                            <td>{{$data->timesheet_title}}</td>
                                                            <td>{{$data->taskName->task_desc}}</td>
                                                            <td>{{$data->timesheet_desc}}</td>
                                                            <td>
                                                                @if(!empty($data->assigned_user))
                                                                    {{$data->assignee->firstname}}&nbsp;{{$data->assignee->lastname}}
                                                                @else
                                                                    {{$data->extUser->firstname}}&nbsp;{{$data->extUser->lastname}}
                                                                @endif
                                                            </td>
                                                            <td>{{$data->work_hours}}</td>
                                                            <td>{{$data->work_date}}</td>
                                                            <td>{{$data->approveName->firstname}} {{$data->approveName->lastname}}</td>
                                                            <td>{{\App\Helpers\Utility::approveStatus($data->approval_status)}}</td>
                                                            <td>{{$data->created_at}}</td>
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
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        //page = window.location.hash.replace('#','');
        //getProducts(page);
    });

    /*$(document).on('click','#task .pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });*/

    function getProducts(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_task').html(data);
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
