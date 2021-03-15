<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Reset Password</title>
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

<body class="fp-page">
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
                <form name="createMainForm" id="createMainForm" class="form-horizontal" onsubmit="false" method="" action="">
                    {{ csrf_field() }}
                    <div class="msg">
                        Enter your email address that you used to register. We'll send you an email with your username and a
                        link to reset your password.
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="email" id="email" class="form-control" name="email" onkeyup="checkExistingName('email','display_email','{{url('password_reset_email_existence')}}')" placeholder="Email" required autofocus>
                        </div>
                        <span class="help-block" id="display_email"></span>
                    </div>
                   
                    
                </form>

                <button type="submit" disabled class="btn btn-block btn-lg bg-pink waves-effect" id="reset_button"
                onclick="sendPasswordResetLink('createMainForm','<?php echo url('password_reset_email'); ?>','reload_data',
            '<?php echo csrf_token(); ?>')">
                    Send Password Reset Link
                </button>
                <div class="row m-t-20 m-b--5 align-center">
                    <a href="{{url('/')}}">Sign In!</a>
                </div>

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

    <!-- App Custom Helpers -->
    <script src="{{ asset('js/app-helpers.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('js/admin.js') }}"></script>
    {{-- <script src="{{ asset('js/pages/examples/forgot-password.js') }}"></script> --}}
    
    <script>

        function sendPasswordResetLink(formId,submitUrl,reload_id,token){
    
            var inputVars = $('#'+formId).serialize();
            var postVars = inputVars;
    
            //DISPLAY LOADING ICON
            overlayBody('block');
    
            sendRequestForm(submitUrl,token,postVars);
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {
    
                    //HIDE LOADING ICON
                    overlayBody('none');
                    var rollback = JSON.parse(ajax.responseText);
                    var message2 = rollback.message2;
                    if(message2 == 'fail'){
    
                        //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                        var serverError = phpValidationError(rollback.message);
    
                        var messageError = swalFormError(serverError);
                        swal("Error",messageError, "error");
    
                    }else if(message2 == 'saved'){
    
                        //RESET FORM
                        resetForm(formId);
                        var successMessage = swalSuccess('Data saved successfully');
                        swal("Success!", "Data saved successfully!", "success");
    
                    }else if(message2 == 'token_mismatch'){
    
                        location.reload();
    
                    }else {
                        var infoMessage = swalWarningError(message2);
                        swal("Warning!", infoMessage, "warning");
                    }
    
                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                    
                }
            }
    
        }
    
    
        function checkExistingName(inputId,displayId,submitUrl,defaultUrl,token){
    
            var resetButton = $('#reset_button');
            var searchInput = $('#'+inputId).val();
            var postVars = "?searchVar="+searchInput;
    
            $.ajax({
                url: submitUrl + postVars
            }).done(function (data) {
                if(data != ''){
                    $('#' + displayId).html(data);
                    resetButton.prop("disabled",true);
                }else{
                    resetButton.prop("disabled",false);
                }
                $('#' + displayId).html(data);
            });
    
        }
    </script>

</body>

</html>