    <!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{--<title>{{ config('app.name', 'ERP Software') }}</title>--}}
    <title>ERP SOFTWARE</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('images/'.Utility::companyInfo()->logo) }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.css') }}">
    <!-- Waves Effect Css -->
    <link href="{{ asset('plugins/node-waves/waves.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Animation Css -->
    <link href="{{ asset('plugins/animate-css/animate.css') }}" rel="stylesheet">

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />


    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/my_style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tabs.css') }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('css/themes/all-themes.css') }}" rel="stylesheet">
    <!-- Sweet Alert Css -->
    <link rel="stylesheet" href="{{ asset('sweetalert/dist/sweetalert.css') }}">
    <!-- SummerNote Css -->
    <link rel="stylesheet" href="{{ asset('summernote/dist/summernote.css') }}">
    <!-- Multiselect Css -->
    <link rel="stylesheet" href="{{ asset('multiselect/dist/css/bootstrap-multiselect.css') }}">

    <!-- Full Event Calendar !-->
    <link rel="stylesheet" href="{{ asset('full_calendar/packages/core/main.css') }}">
    <link rel="stylesheet" href="{{ asset('full_calendar/packages/daygrid/main.css') }}">
    <link rel="stylesheet" href="{{ asset('full_calendar/packages/timegrid/main.css') }}">
    <link rel="stylesheet" href="{{ asset('full_calendar/packages/list/main.css') }}">

    <!-- Calculator Styling Sheets !-->
    <link rel="stylesheet" href="{{ asset('calculator/jsRapCalculator.css') }}">

    <!-- Jquery Core Js -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('templateEditor/ckeditor/ckeditor.js') }}"></script>

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
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->
<!-- Search Bar -->
<div class="search-bar">
    <div class="search-icon">
        <i class="material-icons">search</i>
    </div>
    <input type="text" placeholder="START TYPING...">
    <div class="close-search">
        <i class="material-icons">close</i>
    </div>
</div>
<!-- #END# Search Bar -->

<div id="overlay_app_body" onclick="overlayBody('none');" >
    <div  >        
        <img id="overlay_loading_icon" src="{{asset('icons/loading_icon.gif')}}" /><br>
        <span id="overlay_loading_text">PROCESSING......</span>
    </div>
</div>

<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);"  class="bars"></a>
            @if(!empty(\App\Helpers\Utility::companyInfo()))
            <a class="navbar-brand" href="{{ url('/dashboard') }}">{{\App\Helpers\Utility::companyInfo()->name}}</a>
            @else
            <a class="navbar-brand" href="{{ url('/dashboard') }}">Name of Organisation</a>
            @endif
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->
                {{-- <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li> --}}
                <!-- #END# Call Search -->
                <!-- Notifications -->
                {{-- <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">notifications</i>
                        <span class="label-count">7</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">NOTIFICATIONS</li>
                        <li class="body">
                            <ul class="menu">
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-light-green">
                                            <i class="material-icons">person_add</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4>12 new members joined</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 14 mins ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-cyan">
                                            <i class="material-icons">add_shopping_cart</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4>4 sales made</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 22 mins ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-red">
                                            <i class="material-icons">delete_forever</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><b>Nancy Doe</b> deleted account</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 3 hours ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-orange">
                                            <i class="material-icons">mode_edit</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><b>Nancy</b> changed name</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 2 hours ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-blue-grey">
                                            <i class="material-icons">comment</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><b>John</b> commented your post</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 4 hours ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-light-green">
                                            <i class="material-icons">cached</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4><b>John</b> updated status</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> 3 hours ago
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="icon-circle bg-purple">
                                            <i class="material-icons">settings</i>
                                        </div>
                                        <div class="menu-info">
                                            <h4>Settings updated</h4>
                                            <p>
                                                <i class="material-icons">access_time</i> Yesterday
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="javascript:void(0);">View All Notifications</a>
                        </li>
                    </ul>
                </li> --}}
                <!-- #END# Notifications -->
                <!-- Tasks -->
                <li class="dropdown">
                    {{-- <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="material-icons">flag</i>
                        <span class="label-count">9</span>
                    </a> --}}
                    <ul class="dropdown-menu">
                        <li class="header">TASKS</li>
                        <li class="body">
                            <ul class="menu tasks">
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Footer display issue
                                            <small>32%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Make new buttons
                                            <small>45%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Create new dashboard
                                            <small>54%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 54%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Solve transition issue
                                            <small>65%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <h4>
                                            Answer GitHub questions
                                            <small>92%</small>
                                        </h4>
                                        <div class="progress">
                                            <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="javascript:void(0);">View All Tasks</a>
                        </li>
                    </ul>
                </li>
                <!-- #END# Tasks -->
                <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- #Top Bar -->
<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="{{ asset('images/'.Auth::user()->photo) }}" width="62" height="50" alt="User" />

            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->firstname}} &nbsp {{Auth::user()->lastname}}</div>
                <div class="email">{{Auth::user()->email}}</div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{route('profile', ['uid' => Auth::user()->uid])}}"><i class="material-icons">person</i>Profile</a></li>
                        <li role="seperator" class="divider"></li>
                        <li><a href="javascript:void(0);"><i class="material-icons">language</i>Language</a></li>
                        <li>
                            <a class="" data-toggle="modal" data-target="#quickNoteModal"><i class="material-icons">note_add</i>Quick Notes</a>
                        </li>
                        <li>
                            <a class="" data-toggle="modal" data-target="#quickCalculatorModal"><i class="material-icons">keyboard</i>Calculator</a>
                        </li>
                        <li role="seperator" class="divider"></li>
                        <li><a href="{{url('logout')}}"><i class="material-icons">input</i>Sign Out</a></li>

                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">MAIN NAVIGATION</li>
                <li class="active">
                    <a  href="{{ url('/dashboard') }}">
                        <i class="material-icons">home</i>
                        <span>Home</span>
                    </a>
                </li>
                @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">settings</i>
                        <span>Configuration</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{url('company')}}">Set Company Info</a>
                        </li>
                        <li>
                            <a href="{{url('department')}}">Department</a>
                        </li>
                        <li>
                            <a href="{{url('position')}}">Position</a>
                        </li>
                        <li>
                            <a href="{{url('currencies')}}">Set Currency</a>
                        </li>
                        <li>
                            <a href="{{url('salary_component')}}">Salary Components</a>
                        </li>
                        <li>
                            <a href="{{url('tax_system')}}">Tax System</a>
                        </li>
                        <li>
                            <a href="{{url('salary_structure')}}">Salary Structure</a>
                        </li>
                        <li>
                            <a href="{{url('loan_interest_rate')}}">Loan Interest Rate Config</a>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <span>Module Access Grant</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a href="{{url('request_access')}}">Config User Fund Request Access for Other Users</a>
                                </li>
                                <li>
                                    <a href="{{url('inventory_access')}}">Config Inventory System Access</a>
                                </li>
                                <li>
                                    <a href="{{url('survey_access')}}">Config Individual Survey Access</a>
                                </li>

                                <li>
                                    <a href="{{url('vehicle_fleet_access')}}">Config Fleet Management Access</a>
                                </li>
                                <li>
                                    <a href="{{url('jobs_access')}}">Config Jobs/Talent Access</a>
                                </li>
                                <li>
                                    <a href="{{url('hse_access')}}">Config HSE Administrators</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <span>Approval Configuration</span>
                            </a>
                            <ul class="ml-menu"><hr/>
                                <li>
                                    <a href="{{url('approval_system')}}">Requisition Approval System</a>
                                </li>
                                <li>
                                    <a href="{{url('approval_dept')}}">Departmental Approval</a>
                                </li><hr/>
                                <li>
                                    <a href="{{url('leave_approval_system')}}">HRIS Leave Approval System</a>
                                </li>
                                <li>
                                    <a href="{{url('leave_approval')}}">HRIS Leave Departmental Approval</a>
                                </li><hr/>
                                <li>
                                    <a href="{{url('admin_approval_system')}}">Admin Approval System</a>
                                </li>
                                <li>
                                    <a href="{{url('admin_approval_dept')}}">Admin Departmental Approval</a>
                                </li><hr/>
                            </ul>
                        </li>
                    </ul>
                </li>
                @endif

                @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                    <li>
                        <a href="{{url('user')}}">
                            <i class="material-icons">account_box</i>
                            <span class="icon-name">Manage Users/Employee(s)</span>
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{url('vendor')}}">
                        <i class="material-icons">people</i>
                        <span class="icon-name">Manage Vendors</span>
                    </a>
                </li>

                <li>
                    <a href="{{url('customer')}}">
                        <i class="material-icons">people</i>
                        <span class="icon-name">Manage Customers</span>
                    </a>
                </li>

                @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT) || \App\Helpers\Utility::moduleAccessCheck('survey_access'))
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">spellcheck</i>
                        <span>Survey System</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{url('survey_ans_category')}}">Answer Category</a>
                        </li>
                        <li>
                            <a href="{{url('survey_quest_category')}}">Question Category</a>
                        </li>
                        <li>
                            <a href="{{url('survey')}}">Survey Config</a>
                        </li>
                        <li>
                            <a href="{{url('survey_session')}}">Survey Session</a>
                        </li>
                        <li>
                            <a href="{{url('survey_question')}}">Survey Question(s)</a>
                        </li>
                        <li>
                            <a href="{{url('survey_result')}}">Survey Result</a>
                        </li>
                        <li>
                            <a href="{{url('survey_list')}}">Participate in Survey</a>
                        </li>

                    </ul>
                </li>
                    @else
                <li>
                    <a href="{{url('survey_list')}}">
                        <i class="material-icons">people</i>
                        <span class="icon-name">Participate in Survey</span>
                    </a>
                </li>
                @endif

                @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">dvr</i>
                            <span>CBT System</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="{{url('test_category')}}">Test Category</a>
                            </li>
                            <li>
                                <a href="{{url('test')}}">Test Config</a>
                            </li>
                            <li>
                                <a href="{{url('test_session')}}">Test Session</a>
                            </li>
                            <li>
                                <a href="{{url('test_question')}}">Test Question(s)</a>
                            </li>
                            <li>
                                <a href="{{url('test_result')}}">Test Result</a>
                            </li>
                            <li>
                                <a href="{{url('test_list')}}">Take a Test</a>
                            </li>

                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{url('test_list')}}">
                            <i class="material-icons">border_color</i>
                            <span class="icon-name">Take a test</span>
                        </a>
                    </li>
                @endif

                @if(in_array(Auth::user()->role,\App\Helpers\Utility::SCM_MANAGEMENT))
                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">view_quilt</i>
                        <span>Warehouse Management</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{url('bin_type')}}">Bin Type</a>
                        </li>
                        <li>
                            <a href="{{url('bin')}}">Bin</a>
                        </li>
                        <li>
                            <a href="{{url('zone')}}">Zones</a>
                        </li>
                        <li>
                            <a href="{{url('put_away_template')}}">Put-Away Templates</a>
                        </li>
                        <li>
                            <a href="{{url('warehouse')}}">Warehouse Locations</a>
                        </li>
                        <li>
                            <a href="{{url('warehouse_employee')}}">Warehouse Employee(s)</a>
                        </li>
                        <li>
                            <a href="{{url('warehouse_receipt')}}">Warehouse Receipt(s)</a>
                        </li>
                        <li>
                            <a href="{{url('warehouse_shipment')}}">Warehouse Shipment(s)</a>
                        </li>
                        <li>
                            <a href="{{url('put_away')}}">Put-Away(s)</a>
                        </li>
                        <li>
                            <a href="{{url('picks')}}">Pick(s)</a>
                        </li>
                        <li>
                            <a href="{{url('warehouse_inventory')}}">Warehouse Inventory/Items</a>
                        </li>
                    </ul>
                </li>
                @endif


                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">domain</i>
                        <span>Inventory System</span>
                    </a>
                    <ul class="ml-menu">
                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::ACCOUNT_SCM_WHSE_MANAGEMENT)  || \App\Helpers\Utility::moduleAccessCheck('inventory_access'))
                        <li>
                            <a href="{{url('physical_inv_count')}}">Physical Inventory Count Setup </a>
                        </li>
                        <li>
                            <a href="{{url('unit_measure')}}">Unit of Measure Setup</a>
                        </li>
                        <li>
                            <a href="{{url('inventory_category')}}">Inventory Category</a>
                        </li>
                        <li>
                            <a href="{{url('inventory')}}">Inventory System</a>
                        </li>
                        <li>
                            <a href="{{url('inventory_assign')}}">Inventory Assignment</a>
                        </li>
                        <li>
                            <a href="{{url('inventory_record')}}">Register Inventory Items</a>
                        </li>
                        <li>
                            <a href="{{url('warehouse_inventory')}}">Warehouse And Inventory</a>
                        </li>
                        <li>
                            <a href="{{url('inventory_contract_type')}}">Facility Contract Type</a>
                        </li>
                        <li>
                            <a href="{{url('inventory_contract_status')}}">Facility Contract Status</a>
                        </li>
                        <li>
                            <a href="{{url('inventory_contract')}}">Facility/Asset Management</a>
                        </li>
                        @else
                            <li>
                                <a href="{{url('inventory_assign')}}">Inventory Assignment</a>
                            </li>
                            <li>
                                <a href="{{url('inventory_record')}}">Record Inventory Items</a>
                            </li>

                        @endif
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">help</i>
                        <span>Help Desk</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{url('help_desk_ticket')}}">My Tickets</a>
                        </li>
                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                        <li>
                            <a href="{{url('ticket_category')}}">Tickets Category</a>
                        </li>
                        <li>
                            <a href="{{url('all_help_desk_ticket')}}">Process Ticket Requests</a>
                        </li>
                        <li>
                            <a href="{{url('help_desk_report')}}">Help Desk Report</a>
                        </li>
                        @endif
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">accessibility</i>
                        <span>HSE (Health Safety Environment)</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{url('hse_report')}}">HSE Report</a>
                        </li>
                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS) || \App\Helpers\Utility::moduleAccessCheck('hse_access'))
                            <li>
                                <a href="{{url('hse_report_filter')}}">Manage Reports</a>
                            </li>
                            <li>
                                <a href="{{url('hse_source_type')}}">HSE Source Types</a>
                            </li>
                        @endif
                    </ul>
                </li>

                <li>
                    <a href="{{url('news')}}">
                        <i class="material-icons">record_voice_over</i>
                        <span class="icon-name">News/Notice/Tips</span>
                    </a>
                </li>

                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">event</i>
                        <span>Events/Appointments/Tasks</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{url('events')}}">Manage Events/Appointments/Tasks</a>
                        </li>
                        <li>
                            <a href="{{url('my_events_calendar')}}">My Calendar</a>
                        </li>
                        <li>
                            <a href="{{url('general_events_calendar')}}">General Calendar</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">folder</i>
                        <span>Document Management System</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{url('document')}}">Documents</a>
                        </li>
                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                            <li>
                                <a href="{{url('document_category')}}">Document Category</a>
                            </li>
                            <li>
                                <a href="{{url('document_archive')}}">Document Archives</a>
                            </li>

                        @endif
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">device_hub</i>
                        <span>CRM</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{url('crm_activity_type')}}">Activity Type</a>
                        </li>
                        <li>
                            <a href="{{url('crm_opportunity_stage')}}">Opportunity Stages</a>
                        </li>
                        <li>
                            <a href="{{url('crm_sales_cycle')}}">Sales Cycle</a>
                        </li>
                        <li>
                            <a href="{{url('crm_sales_team')}}">Sales Team</a>
                        </li>
                        <li>
                            <a href="{{url('crm_lead')}}">Manage Lead</a>
                        </li>
                        <li>
                            <a href="{{url('crm_opportunity')}}">Opportunities</a>
                        </li>
                        <li>
                            <a href="{{url('crm_report')}}">Report</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">business_center</i>
                        <span>PO/RFQ/Quotes/Sales</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{url('rfq')}}">Request for Quote (RFQ)</a>
                        </li>
                        <li>
                            <a href="{{url('quote')}}">Create Quote for Customer</a>
                        </li>
                        <li>
                            <a href="{{url('sales_order')}}">Sales Order</a>
                        </li>
                        <li>
                            <a href="{{url('purchase_order')}}">Purchase Order</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">chat</i>
                        <span>Discuss/Forum</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{url('discuss')}}">Discuss</a>
                        </li>
                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                            <li>
                                <a href="{{url('discuss_archive')}}">Discuss Archives</a>
                            </li>

                        @endif
                    </ul>
                </li>

                @if(in_array(Auth::user()->role,\App\Helpers\Utility::ACCOUNT_MANAGEMENT))
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">account_balance</i>
                            <span>Finance Management System </span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="{{url('financial_year')}}">Fiscal/Financial Year </a>
                            </li>
                            <li>
                                <a href="{{url('closing_books')}}">Closing The Books</a>
                            </li>
                            <li>
                                <a href="{{url('trans_class')}}">Create Transaction Class </a>
                            </li>
                            <li>
                                <a href="{{url('trans_location')}}">Create Transaction Location</a>
                            </li>
                            <li>
                                <a href="{{url('transaction_method')}}">Transaction Method</a>
                            </li>
                            <li>
                                <a href="{{url('transaction_terms')}}">Transaction Terms </a>
                            </li>
                            <li>
                                <a href="{{url('account_chart')}}">Chart of Accounts</a>
                            </li>
                            <li>
                                <a href="{{url('journal_default_transaction_account')}}">Default Transaction Accounts</a>
                            </li>

                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Customer Transactions</span>
                                </a>
                                <ul class="ml-menu">

                                    <li>
                                        <a href="{{url('invoice')}}">
                                            <span>Invoice</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('cash_receipt')}}">
                                            <span>Cash Receipt</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('payment_receipt')}}">
                                            <span>Receive Payment</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('invoice_payment_receipt')}}">
                                            <span>Payment Receipts</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('credit_memo')}}">
                                            <span>Credit Memo</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('refund_receipt')}}">
                                            <span>Refund Receipt</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Vendor Transactions</span>
                                </a>
                                <ul class="ml-menu">

                                    <li>
                                        <a href="{{url('expense')}}">
                                            <span>Create Expense</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{url('bill')}}">
                                            <span>Bills</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{url('bill_payment')}}">
                                            <span>Pay Bills</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('bill_payments')}}">
                                            <span>Bill Payments</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('vendor_credit')}}">
                                            <span>Vendor Credit</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Other</span>
                                </a>
                                <ul class="ml-menu">

                                    <li>
                                        <a href="{{url('journal_entry')}}">
                                            <span>Journal Entry</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('bank_reconciliation')}}">
                                            <span>Bank Reconciliation</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Reporting</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="javascript:void(0);" class="menu-toggle">
                                            <span>Accountant Report</span>
                                        </a>
                                        <ul class="ml-menu">

                                            <li>
                                                <a href="{{url('trial_balance')}}">
                                                    <span>Trial Balance</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{url('balance_sheet')}}">
                                                    <span>Balance Sheet</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{url('income_statement')}}">
                                                    <span>Income Statement</span>
                                                </a>
                                            </li>
                                            
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="{{url('customer_report')}}">
                                            <span>Customer Report</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('vendor_report')}}">
                                            <span>Vendor Report</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('payroll_report')}}">
                                            <span>Payroll Report</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </li>
                @endif

                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">import_contacts</i>
                        <span class="icon-name">Budget</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{url('budget_summary')}}">Budget</a>
                        </li>
                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))
                        <li>
                            <a href="{{url('budget_approval')}}">Budget Approval</a>
                        </li>
                        <li>
                            <a href="{{url('budget_budget_compare')}}">Budget/Budget Comparison</a>
                        </li>
                        <li>
                            <a href="{{url('budget_request_tracking')}}">Track Requisition witn Budget</a>
                        </li>
                        @endif
                        <li>
                            <a href="{{url('budget_archive')}}">Budget Archive</a>
                        </li>
                        <li>
                            <a href="{{url('budget_request_compare')}}">Requisition/Budget Comparison</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">library_books</i>
                        <span class="icon-name">Admin Request</span>
                    </a>
                    <ul class="ml-menu">
                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS))                        
                        <li>
                            <a href="{{url('admin_category')}}">Admin Request Category</a>
                        </li>
                        @endif
                        <li>
                            <a href="{{url('admin_requisition')}}">My Requests</a>
                        </li>
                        <li>
                            <a href="{{url('my_admin_requests')}}">Request Approval</a>
                        </li>
                        <li>
                            <a href="{{url('approved_admin_requests')}}">Request Reports</a>
                        </li>
                        <li>
                            <a href="{{url('chart_approved_admin_requests')}}">Request Chart Reports</a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">local_shipping</i>
                        <span>Fleet Management System</span>
                    </a>
                    <ul class="ml-menu">
                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT) || \App\Helpers\Utility::moduleAccessCheck('vehicle_fleet_access'))
                        <li>
                            <a href="{{url('vehicle_make')}}">Vehicle Make</a>
                        </li>
                        <li>
                            <a href="{{url('vehicle_model')}}">Vehicle Model</a>
                        </li>
                        <li>
                            <a href="{{url('vehicle_category')}}">Vehicle Category</a>
                        </li>
                        <li>
                            <a href="{{url('vehicle_contract_type')}}">Vehicle Contract Type</a>
                        <li>
                            <a href="{{url('vehicle_service_type')}}">Vehicle Service Type(s)</a>
                        </li>
                        <li>
                            <a href="{{url('vehicle_status')}}">Vehicle Contract Status</a>
                        </li>
                        <li>
                            <a href="{{url('vehicle')}}">Vehicle(s)</a>
                        </li>
                        <li>
                            <a href="{{url('vehicle_fuel_log_report')}}">Fuel Log Report</a>
                        </li>
                        <li>
                            <a href="{{url('vehicle_service_log_report')}}">Service Log Report</a>
                        </li>
                        <li>
                            <a href="{{url('vehicle_odometer_log_report')}}">Vehicle Odometer Report</a>
                        </li>
                        <li>
                            <a href="{{url('vehicle_contract')}}">Vehicle Contract(s)</a>
                        </li>
                        @endif
                        <li>
                            <a href="{{url('vehicle_fuel_station')}}">Fuel Station</a>
                        </li>
                        <li>
                            <a href="{{url('vehicle_workshop')}}">Vehicle Workshop(s)</a>
                        </li>
                            <li>
                                <a href="{{url('vehicle_odometer_measure')}}">Vehicle Odometer Measure</a>
                            </li>
                        <li>
                            <a href="{{url('vehicle_odometer_log')}}">Vehicle Odometer Log</a>
                        </li>
                        <li>
                            <a href="{{url('vehicle_fuel_log')}}">Fuel Log</a>
                        </li>
                        <li>
                            <a href="{{url('vehicle_service_log')}}">Service Log</a>
                        </li>
                        <li>
                            <a href="{{url('vehicle_maintenance_reminder')}}">Vehicle Maintenance Reminder</a>
                        </li>
                        <li>
                            <a href="{{url('vehicle_maintenance_schedule')}}">Vehicle Maintenance Scheduling</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">next_week</i>
                        <span class="icon-name">Fund Requisition</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{url('request_category')}}">Request Category</a>
                        </li>
                        <li>
                            <a href="{{url('requisition')}}">My Requisition</a>
                        </li>
                        <li>
                            <a href="{{url('my_requests')}}">Requisition Approval</a>
                        </li>
                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::ACCOUNT_MANAGEMENT))
                            <li>
                                <a href="{{url('finance_requests')}}">Finance Request Approval</a>
                            </li>

                        @endif
                        <li>
                            <a href="{{url('approved_requests')}}">Requisition Reports</a>
                        </li>
                        <li>
                            <a href="{{url('chart_approved_requests')}}">Requisition Chart Reports</a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">view_carousel</i>
                        <span class="icon-name">Project Management</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="{{url('project')}}">Projects</a>
                        </li>
                        <li>
                            <a href="{{url('contract/staff/birthday')}}">Birthday(Temporary/Contract Staff)</a>
                        </li>
                        <li>
                            <a href="{{url('project_status')}}">Status Report Dashboard</a>
                        </li>
                        <li>
                            <a href="{{url('project_report')}}">Custom Report</a>
                        </li>
                        <li>
                            <a href="{{url('temp_user')}}">Contract/External Users</a>
                        </li>
                        <li>
                            <a href="{{url('user_pin_code')}}">External Signup Pin code</a>
                        </li>

                    </ul>
                </li>

                @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT) || \App\Helpers\Utility::moduleAccessCheck('jobs_access'))
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">accessible</i>
                            <span>Jobs/Recruitment Management </span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="{{url('jobs')}}">Manage Jobs</a>
                            </li>
                            <li>
                                <a href="{{url('filter_job_applicants')}}">Filter Job Applicants</a>
                            </li>

                        </ul>
                    </li>
                @endif

                <li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">trending_down</i>
                        <span>HRIS(HR)</span>
                    </a>
                    <ul class="ml-menu">
                            <li>
                                <a href="{{url('temp_user')}}">Contract/External Users</a>
                            </li>
                            <li>
                                <a href="{{url('user_pin_code')}}">External Signup Pin code</a>
                            </li>
                            <li>
                                <a href="{{url('idp')}}">Individual Development Plan</a>
                            </li>
                            <li>
                                <a href="{{url('birthday')}}">Birthdays</a>
                            </li>
                            <li>
                                <a href="{{url('salary_advance_requests')}}">Salary Advance Requests</a>
                            </li>
                            <li>
                                <a href="{{url('training')}}">Training Schedule</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Payroll System</span>
                                </a>
                                <ul class="ml-menu">
                                    @if(in_array(Auth::user()->role,\App\Helpers\Utility::ACCOUNT_HR_MANAGEMENT))
                                    <li>
                                        <a href="{{url('payroll')}}">
                                            <span>Process/Pay Salary</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('payroll_report')}}">
                                            <span>Payroll Report</span>
                                        </a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href="{{url('payslip')}}">
                                            <span>Payroll Slip</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>External Payroll System</span>
                                </a>
                                <ul class="ml-menu">
                                    @if(in_array(Auth::user()->role,\App\Helpers\Utility::ACCOUNT_HR_MANPOWER_MANAGEMENT))
                                    <li>
                                        <a href="{{url('external_payroll')}}">
                                            <span>Process/Pay Salary</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('external_payroll_report')}}">
                                            <span>Payroll Report</span>
                                        </a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href="{{url('external_payslip')}}">
                                            <span>Payroll Slip</span>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        <li>
                            <a href="{{url('loan_requests')}}">Loan Requests</a>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <span>Leave System</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a href="{{url('leave_type')}}">
                                        <span>Leave Types</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('leave_log')}}">
                                        <span>Leave Request</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('my_leave_requests')}}">
                                        <span>Leave Approval</span>
                                    </a>
                                </li>
                                @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                                    <li>
                                        <a href="{{url('leave_history')}}">
                                            <span>Leave History</span>
                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <span>Appraisal System</span>
                            </a>
                            <ul class="ml-menu">
                                @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                                <li>
                                    <a href="{{url('appraisal_supervision')}}">Appraisal Supervision Config</a>
                                </li>
                                <li>
                                    <a href="{{url('appraisal_goal_set')}}">
                                        <span>Appraisal Goal Set</span>
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{url('unit_goal')}}">
                                        <span>Unit Goal</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('individual_goal')}}">
                                        <span>Individual Goal</span>
                                    </a>
                                </li>
                                @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))
                                    <li>
                                        <a href="{{url('view_unit_head_comments')}}">
                                            <span>View Unit Head Comments on Individual Goal</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        @if(in_array(Auth::user()->role,\App\Helpers\Utility::HR_MANAGEMENT))

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <span>Competency Framework</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a href="{{url('competency_category')}}">
                                        <span>Framework Category</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('competency_framework')}}">
                                        <span>Framework Config</span>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <span>Competency Map</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a href="{{url('competency_map')}}">
                                        <span>Map</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        @endif
                    </ul>
                </li>

                <li>
                    {{--<a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">widgets</i>
                        <span>Widgets</span>
                    </a>--}}
                    <ul class="ml-menu">
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <span>Cards</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a href="../../pages/widgets/cards/basic.html">Basic</a>
                                </li>
                                <li>
                                    <a href="../../pages/widgets/cards/colored.html">Colored</a>
                                </li>
                                <li>
                                    <a href="../../pages/widgets/cards/no-header.html">No Header</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            {{--<a href="javascript:void(0);" class="menu-toggle">
                                <span>Infobox</span>
                            </a>--}}
                            <ul class="ml-menu">
                                <li>
                                    <a href="../../pages/widgets/infobox/infobox-1.html">Infobox-1</a>
                                </li>
                                <li>
                                    <a href="../../pages/widgets/infobox/infobox-2.html">Infobox-2</a>
                                </li>
                                <li>
                                    <a href="../../pages/widgets/infobox/infobox-3.html">Infobox-3</a>
                                </li>
                                <li>
                                    <a href="../../pages/widgets/infobox/infobox-4.html">Infobox-4</a>
                                </li>
                                <li>
                                    <a href="../../pages/widgets/infobox/infobox-5.html">Infobox-5</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    {{--<a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">swap_calls</i>
                        <span>User Interface (UI)</span>
                    </a>--}}
                    <ul class="ml-menu">
                        {{--<li>
                            <a href="../../pages/ui/alerts.html">Alerts</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/animations.html">Animations</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/badges.html">Badges</a>
                        </li>

                        <li>
                            <a href="../../pages/ui/breadcrumbs.html">Breadcrumbs</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/buttons.html">Buttons</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/collapse.html">Collapse</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/colors.html">Colors</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/dialogs.html">Dialogs</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/icons.html">Icons</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/labels.html">Labels</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/list-group.html">List Group</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/media-object.html">Media Object</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/modals.html">Modals</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/notifications.html">Notifications</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/pagination.html">Pagination</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/preloaders.html">Preloaders</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/progressbars.html">Progress Bars</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/range-sliders.html">Range Sliders</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/sortable-nestable.html">Sortable & Nestable</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/tabs.html">Tabs</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/thumbnails.html">Thumbnails</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/tooltips-popovers.html">Tooltips & Popovers</a>
                        </li>
                        <li>
                            <a href="../../pages/ui/waves.html">Waves</a>
                        </li>--}}
                    </ul>
                </li>
                <li>
                    {{--<a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">assignment</i>
                        <span>Forms</span>
                    </a>--}}
                    <ul class="ml-menu">
                        {{--<li>
                            <a href="../../pages/forms/basic-form-elements.html">Basic Form Elements</a>
                        </li>
                        <li>
                            <a href="../../pages/forms/advanced-form-elements.html">Advanced Form Elements</a>
                        </li>
                        <li>
                            <a href="../../pages/forms/form-examples.html">Form Examples</a>
                        </li>
                        <li>
                            <a href="../../pages/forms/form-validation.html">Form Validation</a>
                        </li>
                        <li>
                            <a href="../../pages/forms/form-wizard.html">Form Wizard</a>
                        </li>
                        <li>
                            <a href="../../pages/forms/editors.html">Editors</a>
                        </li>--}}
                    </ul>
                </li>
                <li>
                    {{--<a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">view_list</i>
                        <span>Tables</span>
                    </a>--}}
                    <ul class="ml-menu">
                        {{--<li>
                            <a href="../../pages/tables/normal-tables.html">Normal Tables</a>
                        </li>
                        <li>
                            <a href="../../pages/tables/jquery-datatable.html">Jquery Datatables</a>
                        </li>
                        <li>
                            <a href="../../pages/tables/editable-table.html">Editable Tables</a>
                        </li>--}}
                    </ul>
                </li>
                <li>
                    {{--<a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">perm_media</i>
                        <span>Medias</span>
                    </a>--}}
                    <ul class="ml-menu">
                        {{--<li>
                            <a href="../../pages/medias/image-gallery.html">Image Gallery</a>
                        </li>
                        <li>
                            <a href="../../pages/medias/carousel.html">Carousel</a>
                        </li>--}}
                    </ul>
                </li>
                <li>
                    {{--<a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">pie_chart</i>
                        <span>Charts</span>
                    </a>--}}
                    <ul class="ml-menu">
                        {{--<li>
                            <a href="../../pages/charts/morris.html">Morris</a>
                        </li>
                        <li>
                            <a href="../../pages/charts/flot.html">Flot</a>
                        </li>
                        <li>
                            <a href="../../pages/charts/chartjs.html">ChartJS</a>
                        </li>
                        <li>
                            <a href="../../pages/charts/sparkline.html">Sparkline</a>
                        </li>
                        <li>
                            <a href="../../pages/charts/jquery-knob.html">Jquery Knob</a>
                        </li>--}}
                    </ul>
                </li>
                <li>
                    {{--<a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">content_copy</i>
                        <span>Example Pages</span>
                    </a>--}}
                    <ul class="ml-menu">
                        {{--<li>
                            <a href="../../pages/examples/sign-in.html">Sign In</a>
                        </li>
                        <li>
                            <a href="../../pages/examples/sign-up.html">Sign Up</a>
                        </li>
                        <li>
                            <a href="../../pages/examples/forgot-password.html">Forgot Password</a>
                        </li>
                        <li class="">
                            <a href="../../pages/examples/blank.html">Blank Page</a>
                        </li>
                        <li>
                            <a href="../../pages/examples/404.html">404 - Not Found</a>
                        </li>
                        <li>
                            <a href="../../pages/examples/500.html">500 - Server Error</a>
                        </li>--}}
                    </ul>
                </li>
                <li>
                    {{--<a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">map</i>
                        <span>Maps</span>
                    </a>--}}
                    <ul class="ml-menu">
                        {{--<li>
                            <a href="../../pages/maps/google.html">Google Map</a>
                        </li>
                        <li>
                            <a href="../../pages/maps/yandex.html">YandexMap</a>
                        </li>
                        <li>
                            <a href="../../pages/maps/jvectormap.html">jVectorMap</a>
                        </li>--}}
                    </ul>
                </li>
                <li>
                    {{--<a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">trending_down</i>
                        <span>Multi Level Menu</span>
                    </a>--}}
                    <ul class="ml-menu">
                        <li>
                            <a href="javascript:void(0);">
                                <span>Menu Item</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <span>Menu Item - 2</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <span>Level - 2</span>
                            </a>
                            <ul class="ml-menu">
                                <li>
                                    <a href="javascript:void(0);">
                                        <span>Menu Item</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <span>Level - 3</span>
                                    </a>
                                    <ul class="ml-menu">
                                        <li>
                                            <a href="javascript:void(0);">
                                                <span>Level - 4</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    {{--<a href="../changelogs.html">
                        <i class="material-icons">update</i>
                        <span>Changelogs</span>
                    </a>--}}
                </li>
                <li class="header">LABELS</li>
                <li>
                    <a href="javascript:void(0);">
                        <i class="material-icons col-red">donut_large</i>
                        <span>Important</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);">
                        <i class="material-icons col-amber">donut_large</i>
                        <span>Warning</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);">
                        <i class="material-icons col-light-blue">donut_large</i>
                        <span>Information</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                @if(!empty(\App\Helpers\Utility::companyInfo()))
                 {{date('Y')}} <a href="javascript:void(0);">{{\App\Helpers\Utility::companyInfo()->name}}</a>.
                @else
                &copy; Copyright Name of Organisation
                @endif
            </div>
            <div class="version">
                <!--<b>Version: </b> 1.0.5 -->
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
    <!-- Right Sidebar -->
    <aside id="rightsidebar" class="right-sidebar">
        <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
            <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                <ul class="demo-choose-skin">
                    <li data-theme="red" class="active">
                        <div class="red"></div>
                        <span>Red</span>
                    </li>
                    <li data-theme="pink">
                        <div class="pink"></div>
                        <span>Pink</span>
                    </li>
                    <li data-theme="purple">
                        <div class="purple"></div>
                        <span>Purple</span>
                    </li>
                    <li data-theme="deep-purple">
                        <div class="deep-purple"></div>
                        <span>Deep Purple</span>
                    </li>
                    <li data-theme="indigo">
                        <div class="indigo"></div>
                        <span>Indigo</span>
                    </li>
                    <li data-theme="blue">
                        <div class="blue"></div>
                        <span>Blue</span>
                    </li>
                    <li data-theme="light-blue">
                        <div class="light-blue"></div>
                        <span>Light Blue</span>
                    </li>
                    <li data-theme="cyan">
                        <div class="cyan"></div>
                        <span>Cyan</span>
                    </li>
                    <li data-theme="teal">
                        <div class="teal"></div>
                        <span>Teal</span>
                    </li>
                    <li data-theme="green">
                        <div class="green"></div>
                        <span>Green</span>
                    </li>
                    <li data-theme="light-green">
                        <div class="light-green"></div>
                        <span>Light Green</span>
                    </li>
                    <li data-theme="lime">
                        <div class="lime"></div>
                        <span>Lime</span>
                    </li>
                    <li data-theme="yellow">
                        <div class="yellow"></div>
                        <span>Yellow</span>
                    </li>
                    <li data-theme="amber">
                        <div class="amber"></div>
                        <span>Amber</span>
                    </li>
                    <li data-theme="orange">
                        <div class="orange"></div>
                        <span>Orange</span>
                    </li>
                    <li data-theme="deep-orange">
                        <div class="deep-orange"></div>
                        <span>Deep Orange</span>
                    </li>
                    <li data-theme="brown">
                        <div class="brown"></div>
                        <span>Brown</span>
                    </li>
                    <li data-theme="grey">
                        <div class="grey"></div>
                        <span>Grey</span>
                    </li>
                    <li data-theme="blue-grey">
                        <div class="blue-grey"></div>
                        <span>Blue Grey</span>
                    </li>
                    <li data-theme="black">
                        <div class="black"></div>
                        <span>Black</span>
                    </li>
                </ul>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="settings">
                <div class="demo-settings">
                    <p>GENERAL SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Report Panel Usage</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Email Redirect</span>
                            <div class="switch">
                                <label><input type="checkbox"><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                    <p>SYSTEM SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Notifications</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Auto Updates</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                    <p>ACCOUNT SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Offline</span>
                            <div class="switch">
                                <label><input type="checkbox"><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Location Permission</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
    <!-- #END# Right Sidebar -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">

            <!-- QUICK NOTES MODAL -->
            <div class="modal fade" id="quickCalculatorModal" tabindex="-1" role="dialog">
                <div class="modal-dialog " role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Calculator</h4>
                        </div>
                        <div class="modal-body" id="" style="height:500px; overflow:scroll;">
                            <div class="row">
                                <div class="card">
                                    <div id="quick_calculator"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- QUICK NOTES MODAL -->
            <div class="modal fade" id="quickNoteModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel"></h4>
                        </div>
                        <div class="modal-body" id="quick_notes" style="height:500px; overflow:scroll;">
                            @include('quick_note.main_view',['mainData' => \App\Helpers\Utility::quickNotes()])
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>

             <!-- LOADING MODAL -->
             <div class="modal fade" id="loading_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel"></h4>
                        </div>
                        <div class="modal-body" id="loading_icon">
                         LOADING......
                        <img src="{{asset('icons/loading_icon.gif')}}" />
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>


            @yield('content')

           

        </div>
    </div>
</section>


<!-- Bootstrap Core Js -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>
<!-- Select Plugin Js -->
<script src="{{ asset('jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

<!-- Slimscroll Plugin Js -->
<script src="{{ asset('plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/jquery.validate.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('plugins/node-waves/waves.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('js/admin.js') }}"></script>
<script src="{{ asset('js/pages/forms/form-validation.js') }}"></script>
<script src="{{ asset('js/pages/forms/basic-form-elements.js') }}"></script>
{{--<script src="{{ asset('js/pages/tables/jquery-datatable.js') }}"></script>--}}
<!-- Autosize Plugin Js -->
<script src="{{ asset('plugins/autosize/autosize.js') }}"></script>

<!-- Moment Plugin Js -->
<script src="{{ asset('plugins/momentjs/moment.js') }}"></script>
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{ asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

<!-- Demo Js -->
<script src="{{ asset('js/demo.js') }}"></script>

<!-- High Chart Js -->
<script src="{{ asset('js/high_chart.js') }}"></script>
<script src="{{ asset('js/highchartTable.js') }}"></script>

<!-- TAB JS -->
<script src="{{ asset('js/tabs2.js') }}"></script>

<!-- Sweet Alert -->
<script src="{{ asset('sweetalert/dist/sweetalert.js') }}"></script>

<script src="{{ asset('summernote/dist/summernote.js') }}"></script>
<script src="{{ asset('multiselect/dist/js/bootstrap-multiselect.js') }}"></script>
<!-- Waves Effect Plugin Js -->
<script src="{{ asset('plugins/node-waves/waves.js') }}"></script>
<!-- App Custom Helpers -->
<script src="{{ asset('js/app-helpers.js') }}"></script>

<!-- FORM WIZARD -->
<script src="{{ asset('js/pages/forms/form-wizard.js') }}"></script>

<!-- JQuery Steps Plugin Js -->
<script src="{{ asset('/plugins/jquery-steps/jquery.steps.js') }}"></script>

<!-- Full Event Calendar -->
<script src="{{ asset('full_calendar/packages/core/main.js') }}"></script>
<script src="{{ asset('full_calendar/packages/interaction/main.js') }}"></script>
<script src="{{ asset('full_calendar/packages/daygrid/main.js') }}"></script>
<script src="{{ asset('full_calendar/packages/timegrid/main.js') }}"></script>
<script src="{{ asset('full_calendar/packages/list/main.js') }}"></script>

<!-- Export to DOCS,PDF,EXCEL,MSWORD,CSV -->
<script src="{{ asset('export/tableExport.js') }}"></script>
<script src="{{ asset('export/jquery.base64.js') }}"></script>
<script src="{{ asset('export/html2canvas.js') }}"></script>
<script src="{{ asset('export/jspdf/libs/sprintf.js') }}"></script>
<script src="{{ asset('export/jspdf/jspdf.js') }}"></script>
<script src="{{ asset('export/jspdf/libs/base64.js') }}"></script>

<!-- Calculator JS-->
<script src="{{ asset('calculator/jsRapCalculator.js') }}"></script>

<!-- EXPORT HTML TO WORD JS-->
<script src="{{ asset('export-html-to-word/FileSaver.js') }}"></script>
<script src="{{ asset('export-html-to-word/jquery.wordexport.js') }}"></script>

<!-- App Custom Helpers -->
<script src="{{ asset('js/custom.js') }}"></script>
<script>


    getCurrency('{{url('get_currency')}}','{{csrf_token()}}');

    //exchangeRate('vendorCust','curr_rate','posting_date','<?php echo url('exchange_rate'); ?>')

    $(function() {
        $( ".datepicker1" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
    });
</script>

</body>

</html>