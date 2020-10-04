@extends('layouts.app')

@section('content')

    <!-- Default Size -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Create User</h4>
                </div>
                <div class="modal-body" style="height:400px; overflow:scroll;">

                    <form name="createMainForm" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Title*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="title" placeholder="Title" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Email*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>First Name*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="firstname" placeholder="First name" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr/>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Last Name*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="lastname" placeholder="Last name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <b>Other Name</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="othername" placeholder="Other name" required>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr/>
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <b>Gender*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="gender"  required>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <b>Department*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control" name="department"  required>
                                                <option value="">Select</option>
                                                @foreach($department as $data)
                                                    <option value="{{$data->id}}">{{$data->dept_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <b>Permission Role*</b>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select type="text" class="form-control" name="role"  required>
                                                <option value="" selected>Select</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{$role->id}}">{{$role->role_name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                            <hr/>
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <b>Date of Birth</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control datepicker" name="birthdate" placeholder="Date of Birth" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <b>Phone</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="phone" placeholder="Phone" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <b>Address</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="home_address" placeholder="Home Address" >
                                    </div>
                                </div>
                            </div>

                        </div>

                            <hr/>
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <b>Nationality</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="nationality" placeholder="Nationality">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <b>Discipline</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control " name="discipline" placeholder="Discipline" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <b>Rate</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" class="form-control" name="rate" placeholder="Rate" >
                                    </div>
                                </div>
                            </div>

                        </div>

                            <hr/>
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <b>Rate Type</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control" name="rate_type"  >
                                            <option value="Rate Per Hour">Rate Per Hour</option>
                                            <option value="Rate Per Day">Rate Per Day</option>
                                            <option value="Rate Per Month">Rate Per Month</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <b>Experience</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="experience" placeholder="Experience">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <b>Certification</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control " name="cert" placeholder="Certification" >
                                    </div>
                                </div>
                            </div>

                        </div>

                            <hr/>
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <b>Certificate Expiry Date</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control datepicker" name="cert_expiry_date" placeholder="Certificate Expiry Date" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <b>Certificate Issue Date</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control datepicker" name="cert_issue_date" placeholder="Certificate Issue Date" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <b>BUPA/HMO Expiry Date</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control datepicker" name="bupa_hmo_expiry_date" placeholder="BUPA/HMO Expiry Date">
                                    </div>
                                </div>
                            </div>

                        </div>

                            <hr/>
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <b>Green Card Expiry Date</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control datepicker" name="green_card_expiry_date" placeholder="Green Card Expiry Date" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <b>Qualifications</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="qualification" placeholder="qualification" >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <b>Salary Structure</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control" name="salary"  >
                                            <option value="">Select</option>
                                            <option value="">None</option>
                                            @foreach($salary as $data)
                                                <option value="{{$data->id}}">{{$data->salary_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <b>Photo</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="file" class="form-control" name="photo" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <b>CV (Curriculum Vitae)</b>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="file" class="form-control" name="cv" >
                                    </div>
                                </div>
                            </div>

                        </div>

                     </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button onclick="submitMediaForm('createModal','createMainForm','<?php echo url('create_temp_user'); ?>','reload_data',
                            '<?php echo url('temp_user'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-link waves-effect">
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
                    <button type="button"  onclick="submitMediaForm('editModal','editMainForm','<?php echo url('edit_temp_user'); ?>','reload_data',
                            '<?php echo url('temp_user'); ?>','<?php echo csrf_token(); ?>')"
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
                        Temporary Users
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>Add</button>
                        </li>
                        <li>
                            <button type="button" onclick="deleteItems('kid_checkbox','reload_data','<?php echo url('temp_user'); ?>',
                                    '<?php echo url('delete_temp_user'); ?>','<?php echo csrf_token(); ?>');" class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>Delete
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeStatus('kid_checkbox','reload_data','<?php echo url('temp_user'); ?>',
                                    '<?php echo url('change_temp_user_status'); ?>','<?php echo csrf_token(); ?>','1');" class="btn btn-success">
                                <i class="fa fa-check-square-o"></i>Enable User
                            </button>
                        </li>
                        <li>
                            <button type="button" onclick="changeStatus('kid_checkbox','reload_data','<?php echo url('temp_user'); ?>',
                                    '<?php echo url('change_temp_user_status'); ?>','<?php echo csrf_token(); ?>','0');" class="btn btn-danger">
                                <i class="fa fa-close"></i>Disable User
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
                    <table class="table">
                        <thead>
                        <th></th><th></th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>External Staff Signup Link</td>
                            <td class="btn-link">{{url('external/signup')}}</td>
                        </tr>
                        <tr>
                            <td>Job Candidates Signup Link</td>
                            <td class="btn-link">{{url('external/candidate')}}</td>
                        </tr>
                        <tr>
                            <td>Clients (survey) Signup Link</td>
                            <td class="btn-link">{{url('client/survey/signup')}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="body ">
                    <div class="row">
                        <div class="col-sm-12 pull-right">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="search_user" class="form-control"
                                           onkeyup="searchItem('search_user','reload_data','<?php echo url('search_temp_user') ?>','{{url('temp_user')}}','<?php echo csrf_token(); ?>')"
                                           name="search_user" placeholder="Search Users" >
                                </div>
                            </div>
                        </div>
                    </div>
                <div class=" table-responsive tbl_scroll" id="reload_data">
                    <table class="table table-bordered table-hover table-striped" id="main_table">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                       name="check_all" class="" />

                            </th>
                            <th>Manage</th>
                            <th>CV</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Date of Birth</th>
                            <th>Address</th>
                            <th>Nationality</th>
                            <th>Qualifications</th>
                            <th>Role</th>
                            <th>Salary Structure</th>
                            <th>Created by</th>
                            <th>Updated by</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Photo</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mainData as $data)
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <td>
                                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_temp_user_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                            </td>
                            <td>
                            @if($data->cv != '')
                                <a target="_blank" href="<?php echo URL::to('temp_user_cv?file='); ?>{{$data->cv}}">
                                    <i class="fa fa-files-o fa-2x"></i>
                                </a>
                            @else
                                No CV to display
                            @endif
                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>
                                @if($data->active_status == 1)
                                <a href="{{route('temp_profile', ['uid' => $data->uid])}}">{{$data->title}}&nbsp;{{$data->firstname}}&nbsp;{{$data->othername}}&nbsp;{{$data->lastname}}</a>
                                @else
                                    <a href="{{route('temp_profile', ['uid' => $data->uid])}}">
                                        <span class="alert-warning">{{$data->title}}&nbsp;{{$data->firstname}}&nbsp;{{$data->othername}}&nbsp;{{$data->lastname}}</span>
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($data->dept_id == '' || $data->dept_id == 0)
                                @else
                                    {{$data->department->dept_name}}
                                @endif
                            </td>
                            <td>{{$data->email}}</td>
                            <td>{{$data->sex}}</td>
                            <td>{{$data->phone}}</td>

                            <td>{{$data->dob}}</td>
                            <td>{{$data->address}}</td>
                            <td>{{$data->nationality}}</td>
                            <td>{{$data->qualification}}</td>
                            <td>{{$data->roles->role_name}}</td>
                            <td>{{$data->salary->salary_name}}</td>
                            <td>{{$data->created_by}}</td>
                            <td>{{$data->updated_by}}</td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->updated_at}}</td>

                            <td><img src="{{ asset('images/'.$data->photo) }}" width="72" height="60" alt="User" /></td>

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

    <!-- #END# Bordered Table end -->

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