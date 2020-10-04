@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Account</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" id="account_cat" onchange="displayOpeningBalance({{json_encode(\App\Helpers\Utility::NO_DEPRECIATION_ACCOUNT_CAT_DB_ID)}},'{{\App\Helpers\Utility::FIXED_ASSET_DB_ID}}','open_balance','depreciation_checkbox','account_cat');" name="account_category" >
                                                <option value="">Account Category</option>
                                                @foreach($accountCat as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line" id="detail_type">
                                            <select  class="form-control" name="detail_type" >
                                                <option value="">Detail Type</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select  class="form-control" id="" name="currency" >
                                                <option value="">Currency</option>
                                                @foreach($currency as $ap)
                                                    <option value="{{$ap->id}}">{{$ap->currency}}({{$ap->code}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>
                            <div class="row clear-fix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>Account Name</b>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="account_name" placeholder="Account Name">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>Description</b>
                                        <div class="form-line">
                                            <textarea type="text" class="form-control" name="account_description" placeholder="Account Description"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>Account Number</b>
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="account_number" placeholder="Account Number">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>
                            <div class="row clear-fix" id="open_balance" style="display:none;">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>Balance/Original Cost ({{\App\Helpers\Utility::defaultCurrency()}})</b>
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="original_cost" placeholder="Original Cost">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>as of</b>
                                        <div class="form-line">
                                            <textarea type="text" class="form-control datepicker" name="cost_date" placeholder="Cost Date"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4" id="depreciation_checkbox" style="display:none;">
                                    <div class="form-group">
                                        <b>Track depreciation of this asset</b>
                                        <div class="form-line">
                                            <input type="checkbox" id="dep_check" onchange="checkDepreciation('dep_check','depreciation');" value="checked" class="form-control" name="track_depreciation" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>
                            <div class="row clear-fix" style="display:none" id="depreciation">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>Depreciation Cost ({{\App\Helpers\Utility::defaultCurrency()}})</b>
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="depreciation" placeholder="Depreciation">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <b>as of</b>
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="depreciation_date" placeholder="Depreciation Date">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            @include('includes.closing_books_password')


                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitDefault('createModal','createMainForm','<?php echo url('create_account_chart'); ?>','reload_data',
                            '<?php echo url('account_chart'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
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
                    <button onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_account_chart'); ?>','reload_data',
                            '<?php echo url('account_chart'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
                        SAVE
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
                        Chart of Accounts
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteChartAccount('kid_checkbox','reload_data','<?php echo url('account_chart'); ?>',
                                    '<?php echo url('delete_account_chart'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Delete
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeItemStatus('kid_checkbox','reload_data','<?php echo url('account_chart'); ?>',
                                    '<?php echo url('change_account_chart_status'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Enable Account
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeItemStatus('kid_checkbox','reload_data','<?php echo url('account_chart'); ?>',
                                    '<?php echo url('change_account_chart_status'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Disable Account
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
                <div class="body row clearfix">
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="search_account_chart" class="form-control"
                                       onkeyup="searchItem('search_account_chart','reload_data','<?php echo url('search_account_chart') ?>','{{url('account_chart')}}','<?php echo csrf_token(); ?>')"
                                       name="search_account_chart" placeholder="Search Account" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="body table-responsive" id="reload_data">
                    @include('account_chart.table',['mainData' => $mainData])

                    <div class=" pagination pull-right">
                        {!! $mainData->render() !!}
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    function checkDepreciation(reqType_id,project_id){
        var projId = $('#'+project_id);
        var reqValue = $('#'+reqType_id).val();
        var reqValue = $('#'+reqType_id).is(':checked');
        if(reqValue){
            projId.show();
        }else{
            projId.hide();
        }

    }

    function displayOpeningBalance(jsonArr,numb,open_bal_id,dep_checkbox_id,select_val_id){
        var openBal = $('#'+open_bal_id);
        var depId = $('#'+dep_checkbox_id);
        var selVal = $('#'+select_val_id).val();
        //alert(selVal+'okay'+'loopjsonval='+checkArrItem(jsonArr,selVal)+'json='+jsonArr);
        if(checkArrItem(jsonArr,selVal) != ''){
            $('#depreciation_checkbox').hide();
            openBal.show();
        }

        if(selVal == numb){
            openBal.show();
            depId.show();
            $('#depreciation_checkbox').show();
        }

        if(selVal != numb && checkArrItem(jsonArr,selVal) == ''){
            $('#depreciation_checkbox').hide();
            openBal.hide();
            depId.hide();
        }

        fillNextInput(select_val_id,'detail_type','<?php echo url('default_select'); ?>','account_chart')

    }



</script>

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