@extends('layouts.app')

@section('content')


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Birthdays (Today to next 7 days)
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

                <div class="body ">

                <div class=" table-responsive" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Job Role</th>
                            <th>Date of Birth</th>
                            <th>Address</th>
                            <th>Photo</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)

                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>

                                {{$data->title}}&nbsp;{{$data->firstname}}&nbsp;{{$data->othername}}&nbsp;{{$data->lastname}}

                            </td>
                            <td>{{$data->email}}</td>
                            <td>{{$data->sex}}</td>
                            <td>{{$data->phone}}</td>
                            <td>{{$data->job_role}}</td>
                            <td>{{$data->dob}}</td>
                            <td>{{$data->address}}</td>
                            <td><img src="{{ asset('images/'.$data->photo) }}" width="72" height="60" alt="User" /></td>

                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

                        </tr>
                        @endforeach
                        </tbody>
                    </table>

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
            var searchVar = $('#search_user').val();

            $.ajax({
                url: '<?php echo url('search_user'); ?>?page=' + page +'&searchVar='+ searchVar
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