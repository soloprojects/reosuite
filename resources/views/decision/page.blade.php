
    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Decision</h4>
                </div>
                <div class="modal-body">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea type="text" class="form-control" name="decision" placeholder="Decision"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <input type="hidden" value="{{$item->id}}" name="project" />

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitDefault('createModal','createMainForm','<?php echo url('create_decision'); ?>','reload_data',
                            '<?php echo url('project/'.$item->id.'/decision'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
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
                    <button type="button"  onclick="submitDefault('editModal','editMainForm','<?php echo url('edit_decision'); ?>','reload_data',
                            '<?php echo url('project/'.$item->id.'/decision'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>')"
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
                                                Decision(s)
                                            </h2>
                                            <ul class="header-dropdown m-r--5">
                                                @if($item->project_head == \App\Helpers\Utility::checkAuth('temp_user')->id)
                                                <li>
                                                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                                                </li>
                                                <li>
                                                    <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('project/'.$item->id.'/decision'.\App\Helpers\Utility::authLink('temp_user')); ?>',
                                                            '<?php echo url('delete_decision'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                                                    <th>Decision</th>
                                                    <th>Comment</th>
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
                                                    <td>{{$data->project->project_name}}</td>
                                                    <td>{{$data->decision_desc}}</td>
                                                    <td>
                                                        <a href="<?php echo url('project/'.$item->id.'/decision/'.$data->id.\App\Helpers\Utility::authLink('temp_user')) ?>">View/Comment on Decision</a>
                                                    </td>
                                                    <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                                    @if($item->project_head == \App\Helpers\Utility::checkAuth('temp_user')->id)
                                                    <td>
                                                        <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_decision_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                                    </td>
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


