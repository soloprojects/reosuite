@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Create Zone</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Name*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Zone Description</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea type="text" class="form-control" name="zone_desc" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Bin Type</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="bin_type" placeholder="Bin Type" required>
                                                    <option value="">Select</option>
                                                @foreach($binType as $type)
                                                    <option value="{{$type->id}}">{{$type->type}} ({{$type->code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Special Equipment</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="special_equip" placeholder="Special Equipment" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Zone Ranking</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="zone_rank" placeholder="Zone Ranking" required>
                                        </div>
                                    </div>
                                </div>

                            </div>

                     </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_zone'); ?>','reload_data',
                            '<?php echo url('zone'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
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
            <div class=" modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                </div>
                <div class="modal-body" style="height:500px; overflow:scroll;" id="edit_content">

                </div>
                <div class="modal-footer">

                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_zone'); ?>','reload_data',
                            '<?php echo url('zone'); ?>','<?php echo csrf_token(); ?>')"
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
                        Zone
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>

                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('zone'); ?>',
                                    '<?php echo url('delete_zone'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                    <!--<li>
                            <button type="button" onclick="changeStatus('kid_checkbox','reload_data','<?php echo url('user'); ?>',
                                    '<?php echo url('change_user_status'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Enable User
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeStatus('kid_checkbox','reload_data','<?php echo url('user'); ?>',
                                    '<?php echo url('change_user_status'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Disable User
                            </button>
                        </li>-->
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

                <div class="body ">

                <div class=" table-responsive tbl_scroll" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>
                            <th>Manage</th>
                            <th>Name</th>
                            <th>Bin Type</th>
                            <th>Zone Description</th>
                            <th>Special Equipment</th>
                            <th>Zone Ranking</th>
                            <th>Created by</th>
                            <th>Updated by</th>
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
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_zone_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

                            <td>{{$data->name}}</td>
                            <td>{{$data->bin->type}}</td>
                            <td>{{$data->zone_desc}}</td>
                            <td>{{$data->special_equip}}</td>
                            <td>{{$data->zone_ranking}}</td><td>
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
    </div>

    <!-- #END# Bordered Table -->

<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        page = window.location.hash.replace('#','');
        getData(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getData(page);
        //location.hash = page;
    });

    function getData(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

</script>


    <script>
        

    </script>

@endsection