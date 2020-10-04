
    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Risk</h4>
                </div>
                <div class="modal-body">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea type="text" class="form-control" name="risk_description" placeholder="Risk Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea type="text" class="form-control" name="trigger" placeholder="Trigger Event/Indicator"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control"  name="probability" >
                                                <option value="">Select Probability</option>
                                                <option value="Highly Likely">Highly Likely</option>
                                                <option value="Somewhat Likely">Somewhat Likely</option>
                                                <option value="Likely">Likely</option>
                                                <option value="Unlikely">Unlikely</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control"  name="impact" >
                                                <option value="">Select Impact</option>
                                                <option value="Critical">Critical</option>
                                                <option value="Severe">Severe</option>
                                                <option value="Moderate">Moderate</option>
                                                <option value="Minimal/Minor">Minimal/Minor</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control"  name="detectability" >
                                                <option value="">Select Detectability</option>
                                                <option value="Determined After Impact">Determined After Impact</option>
                                                <option value="Realized Upon Trigger Event">Realized Upon Trigger Event</option>
                                                <option value="Immediately Prior to Trigger Event">Immediately Prior to Trigger Event</option>
                                                <option value="Determined in Advance">Determined in Advance</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control"  name="category" >
                                                <option value="">Select Category</option>
                                                <option value="Technology">Technology</option>
                                                <option value="Personnel">Personnel</option>
                                                <option value="Equipment">Equipment</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="row clearfix">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea type="text" class="form-control" name="contingency_plan" placeholder="Contingency Plan"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <input type="hidden" value="{{$item->id}}" name="project" />

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitDefault('createModal','createMainForm','<?php echo url('create_risk'); ?>','reload_data',
                            '<?php echo url('project/'.$item->id.'/risk'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
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
                    <button type="button"  onclick="submitDefault('editModal','editMainForm','<?php echo url('edit_risk'); ?>','reload_data',
                            '<?php echo url('project/'.$item->id.'/risk'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>')"
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
            <div class="col-md-12" style="overflow:auto">
                <div id="MyAccountsTab" class="tabbable tabs-left">
                    <!-- Account selection for desktop - I -->
                    @include('includes.project_menu',['item',$item])

                    <div class="tab-content col-md-10" style="overflow-x:auto;">
                        <div class="tab-pane active" id="overview"><!--style="padding-left: 60px; padding-right:100px"-->
                            <div class="col-md-offset-1">
                            <!-- Bordered Table -->
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <h2>
                                                Risk(s)
                                            </h2>
                                            <ul class="header-dropdown m-r--5">
                                                @if($item->project_head == \App\Helpers\Utility::checkAuth('temp_user')->id)
                                                <li>
                                                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                                                </li>
                                                <li>
                                                    <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('project/'.$item->id.'/risk'.\App\Helpers\Utility::authLink('temp_user')); ?>',
                                                            '<?php echo url('delete_risk'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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



                                        <div class="body table-responsive tbl_scroll" id="reload_data">
                                            <table class="table table-bordered table-hover table-striped" id="main_table">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                                               name="check_all" class="" />

                                                    </th>
                                                    <th>Manage</th>
                                                    <th>Project</th>
                                                    <th>Risk Description</th>
                                                    <th>Probability</th>
                                                    <th>Impact</th>
                                                    <th>Detectability</th>
                                                    <th>Category</th>
                                                    <th>Trigger</th>
                                                    <th>Contingency Plan</th>
                                                    <th>Created by</th>
                                                    <th>Updated by</th>
                                                    <th>Created at</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($mainData as $data)
                                                <tr>
                                                    <td scope="row">
                                                        <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                                    </td>
                                                    @if($item->project_head == \App\Helpers\Utility::checkAuth('temp_user')->id)
                                                        <td>
                                                            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_risk_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                                        </td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                                    <td>{{$data->project->project_name}}</td>
                                                    <td>{{$data->risk_desc}}</td>
                                                    <td>{{$data->probability}}</td>
                                                    <td>{{$data->impact}}</td>
                                                    <td>{{$data->detectability}}</td>
                                                    <td>{{$data->category}}</td>
                                                    <td>{{$data->trigger}}</td>
                                                    <td>{{$data->contingency_plan}}</td>
                                                    <td>
                                                       {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                                    </td>
                                                    <td>
                                                       {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                                                    </td>
                                                    <td>{{$data->created_at}}</td>
                                                    <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

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


