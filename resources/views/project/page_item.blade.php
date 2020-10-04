<div class=""> <!-- style="overflow:hidden" -->

    <div class="clearfix"></div>
    <div class="row ">
        <div class="col-md-12" style="overflow:auto">
            <div id="MyAccountsTab" class="tabbable tabs-left">
                <!-- Account selection for desktop - I -->
                @include('includes.project_menu',['item',$item])

                <div class="tab-content col-md-10" style="overflow-x:scroll;">
                    <div class="tab-pane active" id="overview"><!--style="padding-left: 60px; padding-right:100px"-->
                        <div class="col-md-offset-1">
                            <div class="row" style="line-height: 14px; margin-bottom: 34.5px">
                                <h3>Project Overview</h3>
                                <table class="table table-responsive table-bordered table-hover table-striped">
                                    <thead>
                                    <th></th>
                                    <th></th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Project Name</td>
                                        <td>{{$item->project_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Project Leader</td>
                                        <td>{{$item->pro_head->title}} {{$item->pro_head->firstname}} {{$item->pro_head->lastname}}</td>
                                    </tr>
                                    <tr>
                                        <td>Start Date</td>
                                        <td>{{$item->start_date}}</td>
                                    </tr>
                                    <tr>
                                        <td>End Date</td>
                                        <td>{{$item->end_date}}</td>
                                    </tr>
                                    <tr>
                                        <td>Customer/Client</td>
                                        <td>{{$item->customer->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Budget</td>
                                        <td>{{\App\Helpers\Utility::defaultCurrency()}} {{number_format($item->budget)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Billing Method</td>
                                        <td>{{$item->billing->bill_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Project Status</td>
                                        <td class="{{\App\Helpers\Utility::taskColor($item->project_status)}}">{{\App\Helpers\Utility::taskVal($item->project_status)}}</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <p>{{$item->project_desc}}</p>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- Account selection for desktop - F -->
            </div>
        </div>
    </div>
</div>

<!-- END OF TABS -->

<script>
    /*==================== PAGINATION =========================*/

    $(window).on('hashchange',function(){
        //page = window.location.hash.replace('#','');
        //getProducts(page);
    });

    $(document).on('click','#task .pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });

    function getProducts(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_task').html(data);
        });
    }

</script>

<script>
    $(function() {
        $( ".datepicker2" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>