
    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Document(s)</h4>
                </div>
                <div class="modal-body">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>File(s) Title</b>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="title" placeholder="Title">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <b>Files(You can select multiple files)</b>
                                        <div class="form-line">
                                            <input type="file" multiple class="form-control" name="attachment[]" placeholder="Files">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <input type="hidden" value="{{$item->id}}" name="project" />

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_project_docs'); ?>','reload_data',
                            '<?php echo url('project/'.$item->id.'/project_docs'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
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
                    <button type="button"  onclick="submitDefault('editModal','editMainForm','<?php echo url('edit_project_docs'); ?>','reload_data',
                            '<?php echo url('project/'.$item->id.'/project_docs'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
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
                    <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('edit_project_docs_attachment'); ?>','reload_data',
                            '<?php echo url('project/'.$item->id.'/project_docs'.\App\Helpers\Utility::authLink('temp_user')); ?>','<?php echo csrf_token(); ?>')"
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
                            <!-- Bordered Table -->
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="header">
                                            <h2>
                                                Project Document(s)
                                            </h2>
                                            <ul class="header-dropdown m-r--5">
                                                @if($item->project_head == \App\Helpers\Utility::checkAuth('temp_user')->id && $active == 1)
                                                <li>
                                                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                                                </li>
                                                <li>
                                                    <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('project/'.$item->id.'/project_docs'.\App\Helpers\Utility::authLink('temp_user')); ?>',
                                                            '<?php echo url('delete_project_docs'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                                                    <th>Manage</th>
                                                    <th>Manage/View Docs</th>
                                                    <th>Project</th>
                                                    <th>Title</th>
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
                                                    @if($item->project_head == \App\Helpers\Utility::checkAuth('temp_user')->id && $active == 1)
                                                        <td>
                                                            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_project_docs_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                                        </td>
                                                        <td>
                                                            <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_project_docs_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                                        </td>
                                                    @else
                                                        <td></td>
                                                        <td></td>
                                                    @endif

                                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                                    <td>{{$data->project->project_name}}</td>
                                                    <td>{{$data->doc_name}}</td>
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


