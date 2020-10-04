@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New RFQ (Request for Quote)</h4>

                    <li class="dropdown pull-right">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        @include('includes/print_pdf',[$exportId = 'createMainForm', $exportDocId = 'createMainForm'])
                    </li>

                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;" id="po_main_table">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Assign User
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user','myUL2','{{url('default_select')}}','default_search','assign_user');" name="select_user" placeholder="Select User">

                                            <input type="hidden" class="user_class" name="user" id="assign_user" />
                                        </div>
                                    </div>
                                    <ul id="myUL2" class="myUL"></ul>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        RFQ Number
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="rfq_no" placeholder="RFQ Number">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        Due Date
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" id="due_date" name="due_date" placeholder="Due Date">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <h4>Account Section</h4>
                                <table class="table table-bordered table-hover table-striped" id="account_main_table">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                                   name="check_all" class="" />

                                        </th>
                                        <th>Account</th>
                                        <th>Description</th>
                                        <th>Manage</th>
                                    </tr>
                                    </thead>
                                    <tbody id="add_more_acc_rfq">
                                    <tr>

                                        <td scope="row">
                                            <input value="" type="checkbox" id="" class="" />

                                        </td>

                                        <td>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="" autocomplete="off" id="select_acc" onkeyup="searchOptionList('select_acc','myUL500_acc','{{url('default_select')}}','search_accounts','acc500');" name="select_user" placeholder="Select Account">

                                                        <input type="hidden" class="acc_class" value="" name="user" id="acc500" />
                                                    </div>
                                                </div>
                                                <ul id="myUL500_acc" class="myUL"></ul>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea class=" acc_desc" name="item_desc" id="item_desc_acc" placeholder="Description"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="center-align" id="hide_button_acc_rfq">
                                            <div class="form-group center-align">
                                                <div onclick="addMore('add_more_acc_rfq','hide_button_acc_rfq','1','<?php echo URL::to('add_more'); ?>','acc_rfq','hide_button_acc_rfq');">
                                                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                </div>
                                            </div>
                                        </td>

                                        <td></td>

                                    </tr>

                                    </tbody>
                                </table>

                            </div>
                            <hr/>
                            <div class="row clearfix">
                                Item Section
                                <table class="table table-bordered table-hover table-striped" id="po_main_table">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                                   name="check_all" class="" />

                                        </th>


                                        <th>Inventory Item</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Unit Measure</th>
                                        <th>Manage</th>
                                    </tr>
                                    </thead>
                                    <tbody id="add_more_rfq">
                                    <tr>

                                        <td scope="row">
                                            <input value="" type="checkbox" id="" class="" />

                                        </td>

                                        <td>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="" autocomplete="off" id="select_inv" onkeyup="searchOptionList('select_inv','myUL500','{{url('default_select')}}','search_inventory','inv500');" name="select_user" placeholder="Inventory Item">

                                                        <input type="hidden" class="inv_class" value="" name="inventory" id="inv500" />
                                                    </div>
                                                </div>
                                                <ul id="myUL500" class="myUL"></ul>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea class=" item_desc" name="item_desc" id="item_desc" placeholder="Description"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="number" class=" quantity" name="quantity" id="qty" placeholder="Quantity">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <select name="unit_measure"  class="form-control unit_measure" id=""  >
                                                <option value="">Select Unit OF measurement</option>
                                            @foreach($unitMeasure as $data)
                                                        <option value="{{$data->unit_name}}">{{$data->unit_name}}</option>
                                                    @endforeach
                                            </select>
                                        </td>
                                        <td class="col-sm-4" id="hide_button_rfq">
                                            <div class="form-group">
                                                <div onclick="addMore('add_more_rfq','hide_button_rfq','1','<?php echo URL::to('add_more'); ?>','rfq','hide_button_rfq');">
                                                    <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>

                                    </tbody>
                                </table>



                            </div>
                            <hr/>
                            <div class="row clearfix">
                                @include('includes.message_part')

                            </div>

                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaFormClass('createModal','createMainForm','<?php echo url('create_rfq'); ?>','reload_data',
                            '<?php echo url('rfq'); ?>','<?php echo csrf_token(); ?>',[
                            'inv_class','item_desc','quantity','unit_measure','acc_class','acc_desc'],'mail_message')" type="button" class="btn btn-link waves-effect">
                        SAVE
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Edit Content</h4>
                    <li class="dropdown pull-right">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert Export</i>
                        </a>
                        @include('includes/print_pdf',[$exportId = 'editMainForm', $exportDocId = 'editMainForm'])
                    </li>

                </div>
                <div class="modal-body" id="edit_content" style="height:400px; overflow:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaFormClass('editModal','editMainForm','<?php echo url('edit_rfq'); ?>','reload_data',
                            '<?php echo url('rfq'); ?>','<?php echo csrf_token(); ?>',[
                                    'inv_class_edit','item_desc_edit','quantity_edit','unit_measure_edit',
                            'acc_class_edit','acc_desc_edit',
                            ],'mail_message_edit')"
                            class="btn btn-link waves-effect">
                        SAVE CHANGES
                    </button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Transact Default Size -->
    @include('includes.print_preview')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        RFQ (Request for Quote)
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('rfq'); ?>',
                                    '<?php echo url('delete_rfq'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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

                <div class="body">
                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="search_rfq" class="form-control"
                                       onkeyup="searchItem('search_rfq','reload_data','<?php echo url('search_rfq') ?>','{{url('rfq')}}','<?php echo csrf_token(); ?>')"
                                       name="search_rfq" placeholder="Search RFQ (Request for Quote)" >
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="row clearfix">



                    </div>

                <div class="body table-responsive" id="reload_data">

                    @include('rfq.table',['mainData' => $mainData])

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
        location.hash = page;
    });

    function getData(page){
        var searchVal = $('#search_rfq').val();
        var pageData = '';
        if(searchVal == ''){
            pageData = '?page=' + page;
        }else{
            pageData = '<?php echo url('search_rfq') ?>?page=' + page+'&searchVar='+searchVal;
        }

        $.ajax({
            url: pageData
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