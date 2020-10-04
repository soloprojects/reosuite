@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Test</h4>
                </div>
                <div class="modal-body">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Test Name
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="test_name" placeholder="Test Name">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Test Details
                                        <div class="form-line">
                                            <textarea class="form-control" name="test_details" placeholder="Test Details"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Select Department(s)
                                        <div class="form-line">
                                            <select  class="form-control" multiple name="department[]" >
                                                <option value="">Department(s)</option>
                                                @foreach($dept as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Select Test Category(ies)
                                        <div class="form-line">
                                            <select  class="form-control" multiple name="test_category[]" >
                                                <option value="">Category(ies)</option>
                                                @foreach($testCategory as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->category_name}}</option>
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
                    <button onclick="submitDefault('createModal','createMainForm','<?php echo url('create_test'); ?>','reload_data',
                            '<?php echo url('test'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
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
                    <button type="button"  onclick="submitDefault('editModal','editMainForm','<?php echo url('edit_test'); ?>','reload_data',
                            '<?php echo url('test'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-info waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size Edit Department Form -->
    <div class="modal fade" id="editDeptModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Modify Department(s)</h4>
                </div>
                <ul class="header-dropdown m-r--5 " style="list-style-type: none;">
                    <li class="pull-right">
                            <button type="button" onclick="removeAddItem('kid_checkbox_add','reload_data','<?php echo url('test'); ?>',
                                    '<?php echo url('modify_test_dept'); ?>','<?php echo csrf_token(); ?>','1','add selected Item(s)','dept_test_id','editDeptModal');" class="btn btn-success">
                                <i class="fa fa-plus"></i>Add
                            </button>
                    </li>
                    <li>
                        <button type="button" onclick="removeAddItem('kid_checkbox_remove','reload_data','<?php echo url('test'); ?>',
                                '<?php echo url('modify_test_dept'); ?>','<?php echo csrf_token(); ?>','0','remove selected Item(s)','dept_test_id','editDeptModal');" class="btn btn-danger">
                            <i class="fa fa-trash-o"></i>Remove
                        </button>
                    </li>
                </ul>
                <div class="modal-body" id="edit_dept_content" style="height: 400px; overflow-y:scroll;">

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size Edit Category Form -->
    <div class="modal fade" id="editCatModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Modify Category(ies)</h4>
                </div>
                <ul class="header-dropdown m-r--5 " style="list-style-type: none;">
                    <li class="pull-right">
                        <button type="button" onclick="removeAddItem('kid_checkbox_add_cat','reload_data','<?php echo url('test'); ?>',
                                '<?php echo url('modify_test_cat'); ?>','<?php echo csrf_token(); ?>','1','add selected Item(s)','cat_test_id','editCatModal');" class="btn btn-success">
                            <i class="fa fa-plus"></i>Add
                        </button>
                    </li>
                    <li>
                        <button type="button" onclick="removeAddItem('kid_checkbox_remove_cat','reload_data','<?php echo url('test'); ?>',
                                '<?php echo url('modify_test_cat'); ?>','<?php echo csrf_token(); ?>','0','remove selected Item(s)','cat_test_id','editCatModal');" class="btn btn-danger">
                            <i class="fa fa-trash-o"></i>Remove
                        </button>
                    </li>
                </ul>
                <div class="modal-body" id="edit_cat_content" style="height: 400px; overflow-y:scroll;">

                </div>
                <div class="modal-footer">

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
                        Test(s)
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('test'); ?>',
                                    '<?php echo url('delete_test'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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

                            <th>Manage</th>
                            <th>Manage Department(s)</th>
                            <th>Manage Test Category(ies)</th>
                            <th>Test Name</th>
                            <th>Test Details</th>
                            <th>Department(s)</th>
                            <th>Test Category(ies)</th>
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
                                    <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_test_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                <td>
                                    <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','edit_dept_content','editDeptModal','<?php echo url('edit_test_dept_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                <td>
                                    <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','edit_cat_content','editCatModal','<?php echo url('edit_test_category_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                </td>
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>{{$data->test_name}}</td>
                                <td>{{$data->test_desc}}</td>
                                <td>
                                    @if(!empty($data->dept))
                                        <table>
                                            <tbody>
                                        @foreach($data->dept as $dept)
                                            <tr><td>{{$dept->dept_name}}</td></tr>

                                        @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($data->testCategory))
                                        <table>
                                            <tbody>
                                            @foreach($data->testCategory as $dept)
                                                <tr><td>{{$dept->category_name}}</td></tr>

                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </td>
                                <td>
                                   {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                </td>
                                <td>
                                   {{$data->user_u->firstname}} {{$data->user_u->lastname}}
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

@endsection