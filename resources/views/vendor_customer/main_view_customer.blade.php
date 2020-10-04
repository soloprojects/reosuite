@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Create Customer</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Contact Type*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="contact_type" placeholder="Contact Type" required>
                                                <option value="{{\App\Helpers\Utility::CUSTOMER}}" selected>Customer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Currency*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="currency" placeholder="currency" required>
                                                <option value="">Select Currency</option>
                                                @foreach($currency as $curr)
                                                    <option value="{{$curr->id}}">{{$curr->code}} ({{$curr->symbol}}) ({{$curr->currency}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

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
                                    <b>Address</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="address" placeholder="Address" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>City</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="city" placeholder="City" required>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Zip Code*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="zip_code" placeholder="Zip Code" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Phone</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="phone" placeholder="Phone" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Contact No</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="contact_no" placeholder="Contact No" required>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Contact Name</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="contact_name" placeholder="Contact Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Search Key</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="search_key" placeholder="Search Key" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Company Description</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="company_desc" placeholder="Company Description" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <b>Website</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="website" placeholder="website" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Email 1</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="email1" placeholder="Email 1" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <b>Email 2</b>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="email2" placeholder="Email 2" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Company/RC. No.</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="company_no" placeholder="company_no" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Payment Terms</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="pay_terms" placeholder="Payment Terms" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Tax Identification No</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="tax_no" placeholder="Tax Identification No" >
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Bank Name</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="bank_name" placeholder="bank_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Account Name</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control " name="account_name" placeholder="account name" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Account No</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="account_no" placeholder="Account No" >
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Logo</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" class="form-control" name="logo" >
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_vendor_customer'); ?>','reload_data',
                            '<?php echo url('customer'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
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
                <div class="modal-body" style="height:500px; overflow:scroll;" id="edit_content">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_vendor_customer'); ?>','reload_data',
                            '<?php echo url('customer'); ?>','<?php echo csrf_token(); ?>')"
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
                        Customers
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('customer'); ?>',
                                    '<?php echo url('delete_vendor_customer'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeItemStatus('kid_checkbox','reload_data','<?php echo url('customer'); ?>',
                                    '<?php echo url('change_vendor_customer_status'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Enable Customer
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeItemStatus('kid_checkbox','reload_data','<?php echo url('customer'); ?>',
                                    '<?php echo url('change_vendor_customer_status'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Disable Customer
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

                <div class="body ">
                    <div class="row">
                        <div class="col-sm-12 pull-right">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="search_customer" class="form-control"
                                           onkeyup="searchItem('search_customer','reload_data','<?php echo url('search_customer') ?>','{{url('vendor')}}','<?php echo csrf_token(); ?>')"
                                           name="search_user" placeholder="Search Customer" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" table-responsive" id="reload_data">
                        <table class="table table-bordered table-hover table-striped" id="main_table">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                           name="check_all" class="" />

                                </th>
                                <th>Manage</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Contact Name</th>
                                <th>Contact No</th>
                                <th>Email</th>
                                <th>Created by</th>
                                <th>Updated by</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th>Logo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($mainData as $data)

                                    <tr>
                                        <td scope="row">
                                            <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                        </td>
                                        <td>
                                            <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_vendor_customer_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                        </td>
                                        <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                        <td>
                                            @if($data->active_status == 1)
                                                {{$data->name}}
                                            @else
                                                <span class="alert-warning">{{$data->name}}</span>
                                            @endif
                                        </td>

                                        <td>{{$data->address}}</td>
                                        <td>{{$data->contact_name}}</td>
                                        <td>{{$data->contact_no}}</td>
                                        <td>{{$data->contact_no}}</td>
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
                                        <td><img src="{{ asset('images/'.$data->logo) }}" width="72" height="60" alt="Logo" /></td>

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
        /*==================== PAGINATION =========================*/

        $(window).on('hashchange',function(){
            //page = window.location.hash.replace('#','');
            //getSearchData(page);
        });

        $(document).on('click','.search .pagination a', function(event){
            event.preventDefault();

            /* $('li').removeClass('active');

             $(this).parent('li').addClass('active');

             var myurl = $(this).attr('href');*/

            var page=$(this).attr('href').split('page=')[1];
            getSearchData(page);
            //location.hash = page;
        });

        function getSearchData(page){
            var searchVar = $('#search_customer').val();

            $.ajax({
                url: '<?php echo url('search_customer'); ?>?page=' + page +'&searchVar='+ searchVar
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