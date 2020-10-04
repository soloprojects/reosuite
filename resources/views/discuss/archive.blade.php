@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Archived Discuss(s)
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button type="button" onclick="restoreDeletedItems('kid_checkbox','reload_data','<?php echo url('discuss_archive'); ?>',
                                    '<?php echo url('restore_discuss_archive'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-success">
                                <i class="fa fa-check"></i>Restore
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('discuss_archive'); ?>',
                                    '<?php echo url('delete_discuss_archive'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete from archive
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

                <!-- BEGIN OF SEARCH WITH DATE INTERVALS -->
                <div class="container">
                    <form name="import_excel" id="searchMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="start_date" name="from_date" placeholder="From e.g 2019-02-22">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" autocomplete="off" id="end_date" name="to_date" placeholder="To e.g 2019-04-21">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="0" name="param"/>

                                <div class="col-sm-4" id="" style="">
                                    <div class="form-group">
                                        <button class="btn btn-info col-sm-8" type="button" onclick="searchUsingDate('searchMainForm','<?php echo url('search_discuss_using_date'); ?>','reload_data',
                                                '<?php echo url('discuss_archive'); ?>','<?php echo csrf_token(); ?>','start_date','end_date')" id="search_hse_button">Search</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>

                </div><hr/>
                <!-- END OF SEARCH WITH DATE INTERVALS -->

                <!-- BEGIN OF SEARCH WITH DISCUSSION TITLE -->
                <div class="container">
                    <div class="col-sm-6 ">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="search_discuss" class="form-control"
                                       onkeyup="searchItemParam('search_discuss','reload_data','<?php echo url('search_discuss') ?>','{{url('discuss_archive')}}','<?php echo csrf_token(); ?>','type_id')"
                                       name="search_discuss" placeholder="Search Discussions" >
                            </div>
                        </div>
                        <input type="hidden" id="type_id" value="0" name="type"/>
                    </div>
                </div><hr/>
                <!-- BEGIN OF SEARCH WITH DISCUSSION TITLE -->


                <div class="body table-responsive" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>Title</th>
                            <th>Department Access</th>
                            <th>User(s) Access</th>
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
                                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>{{$data->title}}</td>
                                <td>
                                    @if(!empty($data->deptAccess))
                                        <table>
                                            <tbody>
                                            @foreach($data->deptAccess as $dept)
                                                <tr><td>{{$dept->dept_name}}</td></tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($data->userAccess))
                                        <table>
                                            <tbody>
                                            @foreach($data->userAccess as $user)
                                                <tr><td>{{$user->firstname}} {{$user->lastname}}</td></tr>
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