
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>ERP|Page not found</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="{{ asset('plugins/node-waves/waves.css') }}" rel="stylesheet">
    <!-- Custom Css -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

   <style>

        body {
        font: normal medium/1.4 sans-serif;
        }
        table {
        border-collapse: collapse;
        width: 100%;
        }
        th, td {
        padding: 0.25rem;
        text-align: left;
        border: 1px solid #ccc;
        }
        tbody tr:nth-child(odd) {
        background: #eee;
        }
        .hover {
        background: gray;
        }

   </style>
   
   <script>
       var allCells = $("td, th");

        allCells
        .on("mouseover", function() {
            var el = $(this),
                pos = el.index();
            el.parent().find("th, td").addClass("hover");
            allCells.filter(":nth-child(" + (pos+1) + ")").addClass("hover");
        })
        .on("mouseout", function() {
            allCells.removeClass("hover");
        });
   </script>

</head>

<body class="four-zero-four">
<div class="body table-responsive" id="reload_data">
    <table class="table table-bordered table-hover table-striped" id="payslip_table">
        <thead>
        </thead>
        <tbody>
        <tr>
            <?php $companyInfo = \App\Helpers\Utility::companyInfo(); ?>
            @if(!empty($companyInfo))
                    <td>
                        <table>
                            <tbody>
                            <tr>
                                <td>{{$companyInfo->name}}</td>
                            </tr>
                            <tr>
                                <td>{{$companyInfo->address}}</td>
                            </tr>
                            <tr>
                                <td>{{$companyInfo->phone1}}&nbsp; {{$companyInfo->phone2}}</td>
                            </tr>
                            <tr>
                                <td>{{$companyInfo->email}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <?php $imgUrl = \App\Helpers\Utility::IMG_URL(); ?>
                    <td><img class="pull-right" src="{{ asset('images/'.$companyInfo->logo)}}"> </td>
            @else
                <td>
                    <table>
                        <tbody>
                        <tr>
                            <td>Company Name</td>
                        </tr>
                        <tr>
                            <td>Company Address</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                        </tr>
                        </tbody>
                    </table>
                </td>

                <td><img class="pull-right" src="{{ asset('images/'.\App\Helpers\Utility::DEFAULT_LOGO) }}"></td>
            @endif
        </tr>
        </tbody>
    </table>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                @yield('content')
            </div>
        </div>
    </section>

</div>

<script>
    function idDisplayClass(getClass){
        $('.'+getClass).toggle();
    }
</script>

<!-- Jquery Core Js -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap Core Js -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>
<!-- Waves Effect Plugin Js -->
<script src="{{ asset('plugins/node-waves/waves.js') }}"></script>
</body>

</html>