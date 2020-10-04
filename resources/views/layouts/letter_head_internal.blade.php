
<div class="body table-responsive" id="print_preview_data">
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

    <section class="">
        <div class="container-fluid">
            <div class="">
                @yield('content')
            </div>
        </div>
    </section>

</div>