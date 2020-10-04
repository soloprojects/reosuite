@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Create Default Transaction Accounts</h4>
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
                                    <b>Default Account Payable*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="" autocomplete="off" id="select_acc1" onkeyup="searchOptionList('select_acc1','myUL1','{{url('default_select')}}','search_accounts','acc1');" name="select" placeholder="Select Account">
                    
                                            <input type="hidden" class="acc_class" value="" name="default_account_payable" id="acc1" />
                                        </div>
                                    </div>
                                    <ul id="myUL1" class="myUL"></ul>
                                </div>
                                <div class="col-sm-4">
                                    <b>Default Account Receivable*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="" autocomplete="off" id="select_acc2" onkeyup="searchOptionList('select_acc2','myUL2','{{url('default_select')}}','search_accounts','acc2');" name="select" placeholder="Select Account">
                    
                                            <input type="hidden" class="acc_class" value="" name="default_account_receivable" id="acc2" />
                                        </div>
                                    </div>
                                    <ul id="myUL2" class="myUL"></ul>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Default Sales Tax*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="" autocomplete="off" id="select_acc3" onkeyup="searchOptionList('select_acc3','myUL3','{{url('default_select')}}','search_accounts','acc3');" name="select" placeholder="Select Account">
                    
                                            <input type="hidden" class="acc_class" value="" name="default_sales_tax" id="acc3" />
                                        </div>
                                    </div>
                                    <ul id="myUL3" class="myUL"></ul>
                                </div>

                                <div class="col-sm-4">
                                    <b>Default Purchase Tax</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="" autocomplete="off" id="select_acc4" onkeyup="searchOptionList('select_acc4','myUL4','{{url('default_select')}}','search_accounts','acc4');" name="select" placeholder="Select Account">
                    
                                            <input type="hidden" class="acc_class" value="" name="default_purchase_tax" id="acc4" />
                                        </div>
                                    </div>
                                    <ul id="myUL4" class="myUL"></ul>
                                </div>

                                <div class="col-sm-4">
                                    <b>Default Discount Allowed</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="" autocomplete="off" id="select_acc5" onkeyup="searchOptionList('select_acc5','myUL5','{{url('default_select')}}','search_accounts','acc5');" name="select" placeholder="Select Account">
                    
                                            <input type="hidden" class="acc_class" value="" name="default_discount_allowed" id="acc5" />
                                        </div>
                                    </div>
                                    <ul id="myUL5" class="myUL"></ul>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Default Discount Received*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="" autocomplete="off" id="select_acc6" onkeyup="searchOptionList('select_acc6','myUL6','{{url('default_select')}}','search_accounts','acc6');" name="select" placeholder="Select Account">
                    
                                            <input type="hidden" class="acc_class" value="" name="default_discount_received" id="acc6" />
                                        </div>
                                    </div>
                                    <ul id="myUL6" class="myUL"></ul>
                                </div>
                             
                                <div class="col-sm-4">
                                    <b>Default Inventory Account*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="" autocomplete="off" id="select_acc7" onkeyup="searchOptionList('select_acc7','myUL7','{{url('default_select')}}','search_accounts','acc7');" name="select" placeholder="Select Account">
                    
                                            <input type="hidden" class="acc_class" value="" name="default_inventory" id="acc7" />
                                        </div>
                                    </div>
                                    <ul id="myUL7" class="myUL"></ul>
                                </div>
                                <div class="col-sm-4">
                                    <b>Default Payroll Tax*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="" autocomplete="off" id="select_acc8" onkeyup="searchOptionListAcc('select_acc8','myUL8','{{url('default_select')}}','search_accounts','acc8');" name="select_user" placeholder="Select Account">
                    
                                            <input type="hidden" class="acc_class" value="" name="default_payroll_tax" id="acc8" />
                                        </div>
                                    </div>
                                    <ul id="myUL8" class="myUL"></ul>
                                </div>

                            </div>

                     </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_journal_default_transaction_account'); ?>','reload_data',
                            '<?php echo url('journal_default_transaction_account'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
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

                    <button type="button"  onclick="submitMediaFormCompany('editModal','editMainForm','<?php echo url('edit_journal_default_transaction_account'); ?>','reload_data',
                            '<?php echo url('journal_default_transaction_account'); ?>','<?php echo csrf_token(); ?>')"
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
                        Default Auto Transaction Accounts
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('journal_default_transaction_account'); ?>',
                                    '<?php echo url('delete_journal_default_transaction_account'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeItemStatus('kid_checkbox','reload_data','<?php echo url('journal_default_transaction_account'); ?>',
                                    '<?php echo url('change_journal_default_transaction_account_status'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Activate
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeItemStatus('kid_checkbox','reload_data','<?php echo url('journal_default_transaction_account'); ?>',
                                    '<?php echo url('change_journal_default_transaction_account_status'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Deactivate
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

                            <th>Default Account Payable</th>
                            <th>Default Account Receivable</th>
                            <th>Default Sales Tax</th>
                            <th>Default Purchase Tax</th>
                            <th>Default Discount Allowed</th>
                            <th>Default Discount Received</th>
                            <th>Default Inventory</th>
                            <th>Default Payroll Tax</th>
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
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_journal_default_transaction_account_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

                            <td>
                                @if($data->active_status == \App\Helpers\Utility::STATUS_ACTIVE)
                                    <span class="alert-success" style="color:white">{{$data->name}}</span>
                                @else
                                    {{$data->name}}
                                @endif
                            </td>
                            <td>{{$data->accountPayable->acct_name}}</td>
                            <td>{{$data->accountReceivable->acct_name}}</td>
                            <td>{{$data->salesTax->acct_name}}</td>
                            <td>{{$data->purchaseTax->acct_name}}</td>
                            <td>{{$data->salesDiscount->acct_name}}</td>
                            <td>{{$data->purchaseDiscount->acct_name}}</td>
                            <td>{{$data->inventoryAcc->acct_name}}</td>
                            <td>{{$data->payrollTax->acct_name}}</td>
                            <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                            <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
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
        //SUBMIT FORM WITH A FILE
        function submitMediaFormCompany(formModal,formId,submitUrl,reload_id,reloadUrl,token){
            var form_get = $('#'+formId);
            var form = document.forms.namedItem(formId);
            var postVars = new FormData(form);
            postVars.append('token',token);
            $('#loading_modal').modal('show');
            $('#'+formModal).modal('hide');
            sendRequestMediaForm(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {
                    $('#loading_modal').modal('hide');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if(message2 == 'fail'){

                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);

                        var messageError = swalFormError(serverError);
                        swal("Error",messageError, "error");

                    }else if(message2 == 'saved'){

                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", successMessage, "success");
                        location.reload();

                    }else{

                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");

                    }

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    reloadContent(reload_id,reloadUrl);
                }
            }

        }

    </script>

@endsection