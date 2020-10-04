@extends('layouts.app')

@section('content')


    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">New Budget</h4>
                </div>
                <div class="modal-body" style="overflow-y:scroll; height:400px;">

                    <form name="vehicleForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Budget Name</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" id="" name="name" placeholder="Budget Name" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Financial Year*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="financial_year"  required>
                                                <option value="">Select Financial Year</option>
                                                @foreach($finYear as $data)
                                                    <option value="{{$data->id}}">{{$data->fin_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Copy Budget*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="copy_budget"  required>
                                                <option value="">Select Budget to Copy</option>
                                                @foreach($budgetCopy as $data)
                                                    <option value="{{$data->id}}">{{$data->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <b>Total Budget Amount {{\App\Helpers\Utility::defaultCurrency()}}*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="total_budget_amount" placeholder="Total Budget Amount" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Budget Status*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="budget_status"  required>
                                                <option value="">Select Budget Status</option>
                                                    <option value="{{\App\Helpers\Utility::NOT_READY_FOR_APPROVAL}}">{{\App\Helpers\Utility::budgetStatusReadyDisplay(\App\Helpers\Utility::NOT_READY_FOR_APPROVAL)}}</option>
                                                    <option value="{{\App\Helpers\Utility::READY_FOR_APPROVAL}}">{{\App\Helpers\Utility::budgetStatusReadyDisplay(\App\Helpers\Utility::READY_FOR_APPROVAL)}}</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <b>Attachment</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" multiple="multiple" class="form-control" name="attachment[]" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <b>Comment</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class="form-control" name="comment" placeholder="Comment" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr/>

                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    @if($detectHod == \App\Helpers\Utility::HOD_DETECTOR || in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_budget_summary'); ?>','reload_data',
                            '<?php echo url('budget_summary'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                        SAVE
                    </button>
                    @endif
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Default Size Attachment-->
    <div class="modal fade" id="attachModal" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Attachment</h4>
                </div>
                <div class="modal-body" id="attach_content" style="overflow-y:scroll; height:400px;">


                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('attachModal','attachForm','<?php echo url('edit_budget_summary_attachment'); ?>','reload_data',
                            '<?php echo url('budget_summary'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-info waves-effect">
                        SAVE CHANGES
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
                <div class="modal-body" id="edit_content" style="overflow-y:scroll; height:400px;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_budget_summary'); ?>','reload_data',
                            '<?php echo url('budget_summary'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-info waves-effect">
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
                        Budget
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        @if($detectHod == \App\Helpers\Utility::HOD_DETECTOR || in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('budget_summary'); ?>',
                                    '<?php echo url('delete_budget_summary'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
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
                            <th>Manage Docs</th>
                            <th>View/Add to Budget (Request Category)</th>
                            <th>View/Add to Budget (Chart of Accounts)</th>
                            <th>Name</th>
                            <th>Financial Year</th>
                            <th>Department</th>
                            <th>Total Budget Amount ({{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Approval Status</th>
                            <th>Last Date Approved</th>
                            <th>Approved By</th>
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

                            @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS) || $detectHod == \App\Helpers\Utility::HOD_DETECTOR)
                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_budget_summary_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            @else
                            <td></td>
                            @endif

                            <td>
                                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_budget_summary_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <td>
                                <a class="fa fa-eye pull-left" href="<?php echo url('budget_item/view/'.$data->id) ?>">View</a><br/>
                                @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS) || $detectHod == \App\Helpers\Utility::HOD_DETECTOR)
                                <a class="fa fa-plus-circle pull-left" href="<?php echo url('budget_item/modify/'.$data->id) ?>">Add</a>
                                @endif
                               </td>

                            <td>
                                <a class="fa fa-eye pull-left" href="<?php echo url('budget_item/account_chart_dimension/view/'.$data->id) ?>">View</a><br/>
                                @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS) || $detectHod == \App\Helpers\Utility::HOD_DETECTOR)
                                <a class="fa fa-plus-circle pull-left" href="<?php echo url('budget_item/account_chart_dimension/modify/'.$data->id) ?>">Add</a>
                                @endif
                            </td>

                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->name}} </td>
                            <td>{{$data->financialYear->fin_name}}</td>
                            <td>{{$data->department->dept_name}}</td>
                            <td>{{Utility::numberFormat($data->budget_amount)}}</td>
                            <td class="{{\App\Helpers\Utility::statusIndicator($data->approval_status)}}">{{\App\Helpers\Utility::approveStatus($data->approval_status)}}</td>
                            <td>{{$data->approval_date}}</td>
                            <td>{{$data->approval->firstname}} &nbsp; {{$data->approval->lastname}}</td>
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