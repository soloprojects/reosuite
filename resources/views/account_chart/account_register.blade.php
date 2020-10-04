@extends('layouts.app')

@section('content')

    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box-3 bg-pink hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">equalizer</i>
            </div>
            <div class="content">
                <div class="text">Ending Balance ({{Utility::defaultCurrency()}})</div>
                <div class="number">{{$accountData->virtual_balance_trans}}</div>
            </div>
        </div>

    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box-3 bg-purple hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">equalizer</i>
            </div>
            <div class="content">
                <div class="text">Ending Foreign Balance  ({{$accountData->chartCurr->code}}){{$accountData->chartCurr->symbol}}</div>
                <div class="number">{{$accountData->virtual_balance}}</div>
            </div>
        </div>

    </div>

    @if(in_array($accountData->acct_cat_id,Utility::BALANCE_SHEET_ACCOUNTS))
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box-3 bg-blue hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">equalizer</i>
            </div>
            <div class="content">
                <div class="text">Bank Balance ({{Utility::defaultCurrency()}})</div>
                <div class="number">{{$accountData->bank_balance}}</div>
            </div>
        </div>

    </div>
    @endif
        
    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        {{$accountData->acct_name}} ({{$accountData->acct_no}}) Register 
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        
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
                            <th>Post Date</th>
                            <th>Description</th>
                            <th>Payee</th>
                            <th>Transaction Type</th>
                            <th>Reconcile Status</th>
                            <th>Debit in Accounts ({{$debit}}) {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Credit in Accounts ({{$credit}}) {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Balance {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Created by</th>
                            <th>Created at</th>
                            <th>Updated by</th>
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
                            <td>{{$data->post_date}}</td>
                            <td>{{$data->trans_desc}}</td>
                            <td>
                                @if(!empty($data->vendor_customer))
                                {{$data->vendorCon->name}}
                                @endif
                                @if(!empty($data->employee_id))
                                {{$data->employee->firstname}} {{$data->employee->lastname}}
                                @endif
                            </td>
                            <td>{{Finance::transType($data->transaction_type)}}</td>
                            <td>{{Finance::reconcileStatus($data->reconcile_status)}}</td>
                            <td>
                                @if($data->debit_credit == Utility::DEBIT_TABLE_ID)
                                {{Utility::numberFormat($data->trans_total)}}
                                @endif
                            </td>
                            <td>
                                @if($data->debit_credit == Utility::CREDIT_TABLE_ID)
                                {{Utility::numberFormat($data->trans_total)}}
                                @endif
                            </td>
                            <td>{{Utility::numberFormat($data->balanceUpdate)}}</td>
                            
                            <td>{{$data->user_c->firstname}} {{$data->user_c->lastname}}</td>
                            <td>{{$data->parentTransaction->created_at}}</td>
                            <td>{{$data->user_u->firstname}} {{$data->user_u->lastname}}</td>
                            <td>{{$data->parentTransaction->updated_at}}</td>


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