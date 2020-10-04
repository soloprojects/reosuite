@extends('layouts.app')

@section('content')

   

    <!-- EDIT MODAL -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xlg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Receive Payment</h4>
                </div>
                <div class="modal-body" id="edit_content" style="height:400px; overflow:scroll;">

                </div>
                <div class="modal-footer">
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('create_payment_receipt'); ?>','reload_data',
                        '<?php echo url('payment_receipt'); ?>','<?php echo csrf_token(); ?>')" class="btn btn-info waves-effect">
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
                        Receive Payment
                    </h2>
                    <ul class="header-dropdown m-r--5">
                       
                        <li>
                            <button type="button" onclick="fetchMultipleData('kid_checkbox','edit_content','editModal','<?php echo url('edit_payment_receipt_form') ?>','<?php echo csrf_token(); ?>');" class="btn btn-success">
                                <i class="fa fa-plus"></i>Receive Payment
                            </button>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a class="btn bg-blue-grey waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-print"></i>Print</a></li>
                                <li><a class="btn bg-red waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-file-pdf-o"></i>Pdf</a></li>
                                <li><a class="btn btn-warning" onClick ="$('#main_table').tableExport({type:'excel',escape:'false'});" ><i class="fa fa-file-excel-o"></i>Excel</a></li>
                                <li><a class="btn  bg-light-green waves-effect" onClick ="$('#main_table').tableExport({type:'csv',escape:'false'});" ><i class="fa fa-file-o"></i>CSV</a></li>
                                <li><a class="btn btn-info" onClick ="$('#main_table').tableExport({type:'doc',escape:'false'});" ><i class="fa fa-file-word-o"></i>Msword</a></li>

                            </ul>
                        </li>

                    </ul>
                </div>

                <div class="body">
                    
                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" id="search_payment_receipt" class="form-control"
                                       onkeyup="searchItem('search_payment_receipt','reload_data','<?php echo url('search_payment_receipt') ?>','{{url('payment_receipt')}}','<?php echo csrf_token(); ?>')"
                                       name="search_payment_receipt" placeholder="Search Open Invoice" >
                            </div>
                        </div>
                    </div>
                </div>               

                <div class="body table-responsive " id="reload_data">
                    <!-- Print Transact Default Size -->
                    @include('invoice_payment_receipt.table',['mainData'=>$mainData])
                    
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
        
        function switchPayerReceiver(switcherId,customerId,vendorId,employeeId){
            var switcher = $('#'+switcherId);
            var customer = $('#'+customerId);
            var vendor = $('#'+vendorId);
            var employee = $('#'+employeeId);

            if(switcher.val() == @php echo Utility::CUSTOMER; @endphp ){
            customer.show();
            vendor.hide();
            employee.hide();
            }
            if(switcher.val() == @php echo Utility::VENDOR; @endphp){
                customer.hide();
                vendor.show();
                employee.hide();
            }
            if(switcher.val() == @php echo Utility::EMPLOYEE; @endphp){
                customer.hide();
                vendor.hide();
                employee.show();
            }
            if(switcher.val() == ''){
                customer.hide();
                vendor.hide();
                employee.hide();
            }

        }

        //MAKES THE INPUT BESIDE FOCUSED INPUT DISABLED, EMPTY VALUE AND GIVE ITS RELATED HIDDEN INPUT VALUE OF 0.00
        function makeReadOnly(determinerId,debitId,creditId,debitHiddenId,creditHiddenId){
        var determiner = $('#'+determinerId);
        var debit = $('#'+debitId);
        var credit = $('#'+creditId);
        var debitHidden = $('#'+debitHiddenId);
        var creditHidden = $('#'+creditHiddenId);

            if(determiner.val() == @php echo Utility::DEBIT_TABLE_ID; @endphp ){
                credit.val('');
                creditHidden.val('0.00');
                credit.prop('disabled','true');

                if(debit.prop("disabled") == true){
                debit.prop("disabled", false);
                }
                
            }
            if(determiner.val() == @php echo Utility::CREDIT_TABLE_ID; @endphp ){
                debit.val('');
                debitHidden.val('0.00');
                debit.prop('disabled','true');

                if(credit.prop("disabled") == true){
                credit.prop("disabled", false);
                }
                
            }
        }

        function reflectToHidden(inputId,hiddenId){
            var inputVal = $('#'+inputId).val();
            var hidden = $('#'+hiddenId);
            hidden.val(inputVal);

        }

    </script>

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
        var searchVal = $('#search_payment_receipt').val();
        var pageData = '';
        if(searchVal == ''){
            pageData = '?page=' + page;
        }else{
            pageData = '<?php echo url('search_payment_receipt') ?>?page=' + page+'&searchVar='+searchVal;
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