<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Change Password</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('images/'.Utility::companyInfo()->logo) }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="{{ asset('plugins/node-waves/waves.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Animation Css -->
    <link href="{{ asset('plugins/animate-css/animate.css') }}" rel="stylesheet">

    <!-- Sweet Alert Css -->
    <link rel="stylesheet" href="{{ asset('sweetalert/dist/sweetalert.css') }}">
    
    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body class="signup-page">
    <div class="signup-box">
        <div class="fp-box">
            @if(!empty(\App\Helpers\Utility::companyInfo()))
        <div class="logo">
            <a href="javascript:void(0);"><b>{{\App\Helpers\Utility::companyInfo()->name}}</b></a>
            <small>{{\App\Helpers\Utility::companyInfo()->address}}</small>
        </div>
        @else
            <div class="logo">
                <a href="javascript:void(0);"><b>Enter Company Name</b></a>
                <small>Enter Company Address</small>
            </div>
        @endif
        <div class="card">
            <div class="body">
                <form class="form-horizontal" method="POST" action="{{ url('password_reset_login') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="msg">Change Password</div>
                                        
                    <div class="input-group form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="email" value="{{ $email}}" id="email" placeholder="Email Address" required>
                        </div>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" minlength="6" placeholder="Password" required>
                        </div>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="input-group form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password_confirmation" minlength="6" placeholder="Confirm Password" required>
                        </div>

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-block btn-lg bg-pink waves-effect">
                                Reset Password
                            </button>
                        </div>
                    </div>

                    <div class="m-t-25 m-b--5 align-center">
                        <a href="{{url('/')}}">Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('plugins/node-waves/waves.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('sweetalert/dist/sweetalert.js') }}"></script>

    <!-- Validation Plugin Js -->
    {{-- <script src="../../plugins/jquery-validation/jquery.validate.js"></script> --}}

    <!-- Custom Js -->
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="{{ asset('js/pages/examples/sign-up.js') }}"></script>
</body>

</html>