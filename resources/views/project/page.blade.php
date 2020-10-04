<!-- Default Size -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">New Project</h4>
            </div>
            <div class="modal-body">

                <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <b>Project Name</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="project_name" placeholder="Project Name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <b>Project Description</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea class="form-control" name="project_description" placeholder="Project Description"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <b>Start Date</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control datepicker1" name="start_date" placeholder="Start Date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <b>End Date</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control datepicker1" name="end_date" placeholder="End Date">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <b>Budget</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="budget" placeholder="Budget">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-4">
                                Customer/Client
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" autocomplete="off" id="select_customer" onkeyup="searchOptionList('select_customer','myUL2','{{url('default_select')}}','search_customer','customer');" name="select_customer" placeholder="Select Customer">

                                        <input type="hidden" class="user_class" name="customer" id="customer" />
                                    </div>
                                </div>
                                <ul id="myUL2" class="myUL"></ul>
                            </div>

                            <div class="col-sm-4">
                                <b>Project Head</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL1','{{url('default_select')}}','default_search','user');" name="select_user" placeholder="Department Head">

                                        <input type="hidden" class="user_class" name="project_head" id="user" />
                                    </div>
                                </div>
                                <ul id="myUL1" class="myUL"></ul>
                            </div>

                            <div class="col-sm-4">
                                <b>Billing Method</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control" name="bill_method" >
                                            <option value="">Select Billing Method</option>
                                            @foreach($billMethod as $bill)
                                                <option value="{{$bill->id}}">{{$bill->bill_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control project_status" name="project_status" >
                                            <option value="">Select Status</option>
                                            @foreach(\App\Helpers\Utility::TASK_STATUS as $key => $task)
                                                <option value="{{$key}}">{{$task}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </form>

            </div>
            <div class="modal-footer">
                <button onclick="submitDefault('createModal','createMainForm','<?php echo url('create_project'); ?>','reload_data',
                        '<?php echo url('project'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
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
                <button type="button"  onclick="submitDefault('editModal','editMainForm','<?php echo url('edit_project'); ?>','reload_data',
                        '<?php echo url('project'); ?>','<?php echo csrf_token(); ?>')"
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
                    Projects
                </h2>
                <ul class="header-dropdown m-r--5">
                    @if(\App\Helpers\Utility::authColumn('temp_user') != 'temp_user')
                    <li>
                        <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                    </li>
                    <li>
                        <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('project'); ?>',
                                '<?php echo url('delete_project'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                            <i class="fa fa-trash-o"></i>Delete
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
            <div class="body table-responsive" id="reload_data">
                <table class="table table-bordered table-hover table-striped" id="main_table">
                    <thead>
                    <tr>
                        <th>
                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                   name="check_all" class="" />

                        </th>

                        <th>Project</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Project Status</th>
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
                            <td><a href="{{url('project_item/'.$data->id.\App\Helpers\Utility::authLink('temp_user'))}}">{{$data->project_name}}</a></td>
                            <td>{{$data->start_date}}</td>
                            <td>{{$data->end_date}}</td>
                            <td class="{{\App\Helpers\Utility::taskColor($data->project_status)}}">{{\App\Helpers\Utility::taskVal($data->project_status)}}</td>
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
                            @if(\App\Helpers\Utility::authColumn('temp_user') != 'temp_user')
                            @if(in_array(\App\Helpers\Utility::checkAuth('temp_user')->role,\App\Helpers\Utility::HR_MANAGEMENT) || $data->project_head == \App\Helpers\Utility::checkAuth('temp_user')->id)
                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_project_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            @endif
                            @else
                                <td></td>
                            @endif
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
