
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jobs | Available Positions</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.css') }}">
    <!-- Waves Effect Css -->
    <link href="{{ asset('plugins/node-waves/waves.css') }}" rel="stylesheet">

    <!-- Sweet Alert Css -->
    <link rel="stylesheet" href="{{ asset('sweetalert/dist/sweetalert.css') }}">

    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Jquery Core Js -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <script type="text/javascript">
        var csrfToken = $('[name="csrf_token"]').attr('content');

        //setInterval(refreshToken, 3600000); // 1 hour

        function refreshToken(){
            $.get('refresh-csrf').done(function(data){
                csrfToken = data; // the new token
            });
        }

        setInterval(refreshToken, 3600000); // 1 hour

    </script>

</head>

<body class="theme-red">
<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="{{url('OByxRFDeOtxHYxnTTfJmSukkJZ7aCY/positions/2y101HS5A2C30Nex/available')}}">{{\App\Helpers\Utility::companyInfo()->name}}</a>
        </div>
    </div>
</nav>
<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user_info">
            <div class="image">
                <img src="{{ asset('images/'.\App\Helpers\Utility::companyInfo()->logo) }}" width="300" height="200" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><h6>{{\App\Helpers\Utility::companyInfo()->address}}</h6></div>
                <div class="email"><h6>{{\App\Helpers\Utility::companyInfo()->email}}</h6></div>
                <div class="email"><h6>{{\App\Helpers\Utility::companyInfo()->phone1}},{{\App\Helpers\Utility::companyInfo()->phone2}}</h6></div>
            </div>

        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">MAIN NAVIGATION</li>
                <li>
                    <a href="{{url('OByxRFDeOtxHYxnTTfJmSukkJZ7aCY/positions/2y101HS5A2C30Nex/available')}}">
                        <i class="material-icons">home</i>
                        <span>Available Jobs</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Changelogs -->
        <div class="block-header">
            <h2>Available Position</h2>
        </div>

            <div class="row clearfix">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header" style="cursor:pointer;" onclick="navigatePage('<?php echo url('OByxRFDeOtxHYxnTTfJmSukkJZ7aCY/positions/2y101HS5A2C30Nex/available/job/'.$data->id); ?>')">
                            <h2>
                                {{$data->job_title}}
                                <small>Posted {{$data->created_at->diffForHumans()}}</small>
                            </h2>
                        </div>
                        <div class="body">
                            <h5>{{$data->location}} | {{$data->job_type}} | {{$data->salary_range}} | {{$data->experience}} yrs experience</h5>
                            <hr/>
                            <h5>Job Purpose</h5>
                            <p>{!!$data->job_purpose!!}</p>
                            <hr/>
                            <h5>Job Description</h5>
                            <p>{!!$data->job_desc!!}</p>
                            <hr/>
                            <h5>Job Specification</h5>
                            <p>{!!$data->job_spec!!}</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header" style="cursor:pointer;" >
                            <h2>
                                APPLY HERE
                                <small></small>
                            </h2>
                        </div>
                        <div class="body">
                            <form name="import_excel" id="createMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="body">
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="firstname" placeholder="firstname">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="lastname" placeholder="lastname">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="email" class="form-control" name="email" placeholder="Email">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="phone" placeholder="Phone">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="address" placeholder="Address">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select class="form-control" name="experience" >
                                                        <option value="0">Select Experience</option>
                                                        @for($i=0;$i<30;$i++)
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <textarea class="form-control" name="cover_letter" placeholder="Cover Letter"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <b>Attach CV/Resume</b>
                                                <div class="form-line">
                                                    <input type="file" class="form-control" name="cv_file" placeholder="Attach CV">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <input type="hidden" name="job" value="{{$data->id}}"/>


                                </div>


                            </form>
                        </div>
                        <button onclick="applyJob('createModal','createMainForm','<?php echo url('apply_job'); ?>','reload_data',
                                '<?php echo url('jobs'); ?>','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info col-sm-12 waves-effect">
                            Apply
                        </button>
                    </div>
                </div>
            </div>




    </div>
</section>

<!-- Bootstrap Core Js -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('plugins/node-waves/waves.js') }}"></script>

<!-- App Custom Helpers -->
<script src="{{ asset('js/app-helpers.js') }}"></script>

<!-- Sweet Alert -->
<script src="{{ asset('sweetalert/dist/sweetalert.js') }}"></script>

</body>

<script>

    function applyJob(formModal,formId,submitUrl,reload_id,reloadUrl,token){
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);
        var postVars = new FormData(form);
        postVars.append('token',token);
        $('#loading_modal').modal('show');
        $('#'+formModal).modal('hide');

        sendRequestMediaForm(submitUrl,token,postVars);
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

                    var successMessage = swalSuccess('Your application was successful, we will get back to you');
                    swal("Success!", successMessage, "success");

                }else if(message2 == 'token_mismatch'){

                    //location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                //reloadContent(reload_id,reloadUrl);
            }
        }

    }

    function navigatePage(pageUrl){
        window.location.replace(pageUrl);
    }
</script>

</html>