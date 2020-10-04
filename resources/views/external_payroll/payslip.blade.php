@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Payslip</h4>
                </div>
                <div class="modal-body">

                    <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="position_name" placeholder="Position Name">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitDefault('createModal','createMainForm','<?php echo url('create_position'); ?>','reload_data',
                            '<?php echo url('position'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
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
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Payslip</h4>

                    <ul class="header-dropdown m-r--5 pull-right">

                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            @include('includes/print_pdf',[$exportId = 'print_preview_data', $exportDocId = 'print_preview_data'])

                        </li>

                    </ul>

                </div>
                <div class="modal-body" id="edit_content" style="overflow:scroll; height:400px; ">

                </div>
                <div class="modal-footer">

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
                        Payroll
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <!--<li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>-->

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

                <div class="body table-responsive tbl_scroll" id="reload_data">

                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>

                            <th>User</th>
                            <th>Salary</th>
                            <th>Total/Net Amount {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Bonus/Deduction {{\App\Helpers\Utility::defaultCurrency()}}</th>
                            <th>Bonus/Deduction Desc</th>
                            <th>Payroll Status</th>
                            <th>Pay Week(s)</th>
                            <th>Pay Month</th>
                            <th>Pay Year</th>
                            <th>Process Date</th>
                            <th>Pay Date</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Manage</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                            @php $monthName = date("F", mktime(0, 0, 0, $data->month,10)); @endphp
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->userDetail->firstname}}&nbsp;{{$data->userDetail->lastname}} </td>
                            <td>{{$data->salary->salary_name}}</td>
                            <td>&nbsp;{{Utility::numberFormat($data->total_amount)}}</td>
                            <td>{{Utility::numberFormat($data->bonus_deduc)}}</td>
                            <td>{{$data->bonus_deduc_desc}}</td>
                            <td>
                                @if($data->payroll_status == \App\Helpers\Utility::PROCESSING)
                                Processing
                                @else
                                    Paid
                                @endif
                            </td>
                            <td>
                                @if(!empty($data->week))
                                    @php $decodeWeek = json_decode($data->week,true); $weeks = implode(',',$decodeWeek); @endphp
                                    {{$weeks}}
                                @else

                                @endif
                            </td>
                            <td>{{$monthName}}</td>
                            <td>{{$data->pay_year}}</td>
                            <td>{{$data->process_date}}</td>
                            <td>{{$data->pay_date}}</td>
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
                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('payslip_item') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i>|View</a>
                            </td>
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
            //page = window.location.hash.replace('#','');
            //getProducts(page);
        });

        $(document).on('click','.pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getProducts(page);
            //location.hash = page;
        });

        function getProducts(page){

            var searchVar = $('#search_user').val();
            var searchPage = document.getElementsByClassName('search_user_page');
            var targetPage = '';
            if (searchPage.length > 0) {
                targetPage = '<?php echo url('search_payroll_user'); ?>?searchVar='+searchVar+'&page='+page
                console.log(targetPage);
            }else{
                targetPage = '?page=' + page;
            }

            $.ajax({
                url: targetPage
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }

    </script>

    <script>
        /*==================== PAGINATION =========================*/

        /*$(window).on('hashchange',function(){
            //page = window.location.hash.replace('#','');
            //getSearchData(page);
        });

        $(document).on('click','.pagination a', function(event){
            event.preventDefault();

            /!* $('li').removeClass('active');

             $(this).parent('li').addClass('active');

             var myurl = $(this).attr('href');*!/

            var page=$(this).attr('href').split('page=')[1];
            getSearchData(page);
            //location.hash = page;
        });

        function getSearchData(page){
            var searchVar = $('#search_user').val();
            console.log(searchVar+'slkds');

            $.ajax({
                url: '<?php echo url('search_payroll_user'); ?>?searchVar='+searchVar+'&page='+page
            }).done(function(data){
                $('#reload_data').html(data);
            });
        }
*/
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