@extends('layouts.app')

@section('content')


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
                            '<?php echo url('budget_summary_approval'); ?>','<?php echo csrf_token(); ?>')"
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
                            '<?php echo url('budget_approval'); ?>','<?php echo csrf_token(); ?>')"
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
                        Budget Approval
                    </h2>
                    <ul class="header-dropdown m-r--5">

                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                        <li>
                            <button type="button" onclick="dynamicStatusEffect('kid_checkbox','reload_data','<?php echo url('budget_summary'); ?>',
                                    '<?php echo url('change_budget_status'); ?>','<?php echo csrf_token(); ?>','{{\App\Helpers\Utility::APPROVED}}','approve this budget');" class="btn btn-success waves-effect" ><i class="fa fa-check"></i>Approve</button>

                        </li>
                        <li>
                            <button type="button" onclick="dynamicStatusEffect('kid_checkbox','reload_data','<?php echo url('budget_summary'); ?>',
                                    '<?php echo url('change_budget_status'); ?>','<?php echo csrf_token(); ?>','{{\App\Helpers\Utility::PROCESSING}}','reverse this budget approval');" class="btn btn-danger waves-effect" ><i class="fa fa-close"></i>Reverse Approval</button>

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
                            <th>View</th>
                            <th>Add to Budget</th>
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
                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_budget_summary_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="fetchHtml('{{$data->id}}','attach_content','attachModal','<?php echo url('edit_budget_summary_attachment_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <td>
                                <a class="fa fa-eye pull-right" href="<?php echo url('budget_item/view/'.$data->id) ?>">View</a>
                            </td>
                            @if($data->created_by == Auth::user()->id)
                            <td>
                                <a class="fa fa-plus-circle pull-left" href="<?php echo url('budget_item/modify/'.$data->id) ?>">Add</a>
                            </td>
                            @else
                                <td></td>
                            @endif
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