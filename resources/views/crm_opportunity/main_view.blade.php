@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Add Opportunity</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Lead</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" autocomplete="off" id="select_inv" onkeyup="searchOptionList('select_inv','myUL500','{{url('default_select')}}','search_crm_lead','inv500');" name="select_user" placeholder="Search Lead">

                                            <input type="hidden" class="inv_class" value="" name="lead" id="inv500" />
                                        </div>
                                    </div>
                                    <ul id="myUL500" class="myUL"></ul>
                                </div>

                                <div class="col-sm-4">
                                    <b>Opportunity Name</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="opportunity_name" placeholder="Opportunity Name">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Amount ({{\App\Helpers\Utility::defaultCurrency()}})</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" value="0.00" id="amount" name="amount" placeholder="Amount">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Sales Team</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="sales_team" >
                                                <option value="">Select Sales Team</option>
                                                @foreach($salesTeam as $d)
                                                    <option value="{{$d->id}}">{{$d->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Revenue ({{\App\Helpers\Utility::defaultCurrency()}})</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" id="revenue" name="expected_revenue" placeholder="Expected Revenue">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control datepicker" name="closing_date" placeholder="Closing Date">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Sales Cycle</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="sales_cycle" id="sales_cycle" onchange="fillNextInput('sales_cycle','stages_display','{{url('default_select')}}','get_crm_stages');" >
                                                <option value="">Select Sales Cycle</option>
                                                @foreach($salesCycle as $d)
                                                    <option value="{{$d->id}}">{{$d->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Opportunity Stage</b>
                                    <div class="form-group">
                                        <div class="form-line" id="stages_display">
                                            <select class="form-control" name="opportunity_stage" id="stage" onchange="getRevenue('amount','stage','revenue','{{url('fetch_crm_possibility')}}');" >
                                                <option value="">Select Opportunity Stage</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_crm_opportunity'); ?>','reload_data',
                            '<?php echo url('crm_opportunity'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
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
                    <button onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_crm_opportunity'); ?>','reload_data',
                            '<?php echo url('crm_opportunity'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
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
                        Opportunities
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="statusChangeWithReason('kid_checkbox','reload_data','<?php echo url('crm_opportunity'); ?>',
                                    '<?php echo url('crm_opportunity_status'); ?>','<?php echo csrf_token(); ?>','{{\App\Helpers\Utility::WON}}');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Mark as Won
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="statusChangeWithReason('kid_checkbox','reload_data','<?php echo url('crm_opportunity'); ?>',
                                    '<?php echo url('crm_opportunity_status'); ?>','<?php echo csrf_token(); ?>','{{\App\Helpers\Utility::ONGOING}}');" class="btn btn-info">
                                <i class="fa fa-check-square-o"></i>Mark as Ongoing
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="statusChangeWithReason('kid_checkbox','reload_data','<?php echo url('crm_opportunity'); ?>',
                                    '<?php echo url('crm_opportunity_status'); ?>','<?php echo csrf_token(); ?>','{{\App\Helpers\Utility::LOST}}');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Mark as Lost
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('crm_opportunity'); ?>',
                                    '<?php echo url('delete_crm_opportunity'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                        <div class="col-sm-12 pull-right">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="search_crm_opportunity" class="form-control"
                                           onkeyup="searchItem('search_crm_opportunity','reload_data','<?php echo url('search_crm_opportunity') ?>','{{url('crm_opportunity')}}','<?php echo csrf_token(); ?>')"
                                           name="search_inventory" placeholder="Search Opportunity" >
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <th>Pipeline</th>
                            <th>Lead</th>
                            <th>Opportunity</th>
                            <th>Sales Cycle</th>
                            <th>Stage/Phase</th>
                            <th>Status</th>
                            <th>Lost Reason</th>
                            <th>Probability (%)</th>
                            <th>Amount ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                            <th>Closing Date</th>
                            <th>Expected Revenue ({{\App\Helpers\Utility::defaultCurrency()}})</th>
                            <th>Sales Team</th>
                            <th>Created by</th>
                            <th>Created at</th>
                            <th>Updated by</th>
                            <th>Updated at</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)

                            @php
                                $salesTeamUserIds = json_decode($data->sales->users);
                            @endphp
                            @if(in_array(Auth::user()->id,$salesTeamUserIds) || $data->created_by == Auth::user()->id || in_array(Auth::user()->id,\App\Helpers\Utility::TOP_USERS))
                                <tr>
                                    <td scope="row">
                                        <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                                    </td>
                                    <td>
                                        <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_crm_opportunity_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                    </td>
                                    <td>
                                        <a href="<?php echo url('crm_opportunity/id/'.$data->id) ?>">Pipeline Activities/Notes</a>
                                    </td>

                                    <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                                    <td>{{$data->lead->name}}</td>
                                    <td>{{$data->opportunity_name}}</td>
                                    <td>{{$data->salesCycle->name}}</td>
                                    <td>{{$data->phase->name}} (Stage{{$data->phase->stage}})</td>
                                    <td style="color:black;" class="{{\App\Helpers\Utility::opportunityStatusIndicator($data->opportunity_status)}}">{{\App\Helpers\Utility::opportunityStatus($data->opportunity_status)}}</td>
                                    <td>{{$data->lost_reason}}</td>
                                    <td>{{$data->phase->probability}}</td>
                                    <td>{{Utility::numberFormat($data->amount)}}</td>
                                    <td>{{$data->closing_date}}</td>
                                    <td>{{Utility::numberFormat($data->expected_revenue)}}</td>
                                    <td>{{$data->sales->name}}</td>
                                    <td>
                                        {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                                    </td>
                                    <td>{{$data->created_at}}</td>
                                    <td>
                                        {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                                    </td>
                                    <td>{{$data->updated_at}}</td>


                                    <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

                                </tr>
                            @else
                            @endif
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

    function getRevenue(amount_id,stage_id,revenue_id,page) {

        var amount = $('#'+amount_id).val();
        var stage = $('#'+stage_id).val();
        console.log(stage);
         $.ajax({url: page+'?dataId='+stage, success: function(result){
         var possibility = (amount*result)/100;
         $('#'+revenue_id).val(possibility);
         }});

    }

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

        var searchVal = $('#search_crm_opportunity').val();
        var pageData = '';
        if(searchVal == ''){
            pageData = '?page=' + page;
        }else{
            pageData = '<?php echo url('search_crm_opportunity') ?>?page=' + page+'&searchVar='+searchVal;
        }

        $.ajax({
            url: pageData
        }).done(function(data){
            $('#reload_data').html(data);
        });

    }


        /*$(function() {
            $( ".datepicker" ).datepicker({
                /!*changeMonth: true,
                changeYear: true*!/
            });
        });*/
    </script>

@endsection