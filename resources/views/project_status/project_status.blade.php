@extends('layouts.app')

@section('content')


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Project Report Dashboard
                    </h2>

                </div>
                <div class="body table-responsive" id="reload_data">

                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box-3 bg-cyan hover-zoom-effect">
                                <div class="icon">
                                    <i class="material-icons">equalizer</i>
                                </div>
                                <div class="content">
                                    <div class="text">Overdue Project(s)</div>
                                    <div class="number">{{$item->overdueProject}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box-3 bg-light-blue hover-zoom-effect">
                                <div class="icon">
                                    <i class="material-icons">equalizer</i>
                                </div>
                                <div class="content">
                                    <div class="text">Overdue Milestone</div>
                                    <div class="number">{{$item->overdueMilestone}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box-3 bg-blue hover-zoom-effect">
                                <div class="icon">
                                    <i class="material-icons">equalizer</i>
                                </div>
                                <div class="content">
                                    <div class="text">Overdue Task List</div>
                                    <div class="number">{{$item->overdueList}}</div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="info-box-3 bg-pink hover-zoom-effect">
                                <div class="icon">
                                    <i class="material-icons">equalizer</i>
                                </div>
                                <div class="content">
                                    <div class="text">Overdue Task(s)</div>
                                    <div class="number">{{$item->overdueTask}}</div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="info-box-3 bg-cyan hover-zoom-effect">
                                <div class="icon">
                                    <i class="material-icons">equalizer</i>
                                </div>
                                <div class="content">
                                    <div class="text">My Overdue Task</div>
                                    <div class="number">{{$item->overdueUserTask}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Hover Zoom Effect -->

                    <div class="row clearfix">
                        <!-- With Icons -->
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        Project (Open/Closed/Total)
                                        <small></small>
                                    </h2>

                                </div>
                                <div class="body">
                                    <h2>Total Project -- {{$item->totalProject}}</h2>
                                    <div class="row clearfix">

                                        <table class="highchart" id="" data-graph-container-before="1" data-graph-type="pie" style="display:none">
                                            <thead>
                                            <tr>
                                                <th>Project (Open/Closed/Total)</th>
                                                <th>
                                                    Number
                                                </th>
                                            </tr>
                                            </thead>

                                            <tbody>

                                            <tr>
                                                <td>Open</td>
                                                <td>{{$item->openProject}}</td>
                                            </tr>
                                            <tr>
                                                <td>Closed</td>
                                                <td>{{$item->closedProject}}</td>
                                            </tr>

                                            </tbody>

                                        </table>


                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- #END# With Icons -->
                        <!-- Basic Examples -->
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        Milestone (Open/Closed/Total)
                                        <small></small>
                                    </h2>

                                </div>
                                <div class="body">
                                    <h2>Total Milestone -- {{$item->totalMilestone}}</h2>
                                    <div class="row clearfix">

                                        <table class="highchart" id="" data-graph-container-before="1" data-graph-type="pie" style="display:none">
                                            <thead>
                                            <tr>
                                                <th>Milestone (Open/Closed/Total)</th>
                                                <th>
                                                    Number
                                                </th>
                                            </tr>
                                            </thead>

                                            <tbody>

                                            <tr>
                                                <td>Open</td>
                                                <td>{{$item->openMilestone}}</td>
                                            </tr>
                                            <tr>
                                                <td>Closed</td>
                                                <td>{{$item->closedMilestone}}</td>
                                            </tr>

                                            </tbody>

                                        </table>


                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- #END# Basic Examples -->
                    </div>

                    <div class="row clearfix">
                        <!-- Basic Examples -->
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        Task(s) (Open/Closed/Total)
                                        <small></small>
                                    </h2>

                                </div>
                                <div class="body">
                                    <h2>Total Tasks -- {{$item->totalTask}}</h2>
                                    <div class="row clearfix">

                                        <table class="highchart" id="" data-graph-container-before="1" data-graph-type="pie" style="display:none">
                                            <thead>
                                            <tr>
                                                <th>Task (Open/Closed/Total)</th>
                                                <th>
                                                    Number
                                                </th>
                                            </tr>
                                            </thead>

                                            <tbody>

                                            <tr>
                                                <td>Open</td>
                                                <td>{{$item->openTask}}</td>
                                            </tr>
                                            <tr>
                                                <td>Closed</td>
                                                <td>{{$item->closedTask}}</td>
                                            </tr>

                                            </tbody>

                                        </table>


                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- #END# Basic Examples -->
                        <!-- With Icons -->
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        Task List (Open/Closed/Total)
                                    </h2>

                                </div>
                                <div class="body">
                                    <h2>Total Task List -- {{$item->totalList}}</h2>
                                    <div class="row">
                                        <table class="highchart" id="" data-graph-container-before="1" data-graph-type="pie" style="display:none">
                                            <thead>
                                            <tr>
                                                <th>Task List </th>
                                                <th>
                                                    Number
                                                </th>
                                            </tr>
                                            </thead>

                                            <tbody>

                                            <tr>
                                                <td>Open</td>
                                                <td>{{$item->openList}}</td>
                                            </tr>
                                            <tr>
                                                <td>Closed</td>
                                                <td>{{$item->closedList}}</td>
                                            </tr>

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- #END# With Icons -->
                    </div>

                    <div class="row clearfix">
                        <!-- Basic Examples -->

                        <!-- #END# Basic Examples -->
                        <!-- With Icons -->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        Overdue (Task/Task List/Milestone/Project)
                                    </h2>

                                </div>
                                <div class="body">
                                    <table class="highchart" id="" data-graph-container-before="1" data-graph-type="column" >
                                        <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>
                                                Number
                                            </th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        <tr>
                                            <td>Overdue Milestone</td>
                                            <td>{{$item->overdueMilestone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Overdue Task List</td>
                                            <td>{{$item->overdueList}}</td>
                                        </tr>
                                        <tr>
                                            <td>Overdue Task(s)</td>
                                            <td>{{$item->overdueTask}}</td>
                                        </tr>
                                        <tr>
                                            <td>Overdue Project(s)</td>
                                            <td>{{$item->overdueProject}}</td>
                                        </tr>

                                        </tbody>

                                    </table>

                                </div>
                            </div>
                        </div>
                        <!-- #END# With Icons -->
                    </div>

                    <div class="row clearfix">
                        <!-- Basic Examples -->
                        <div class=" col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        Project Status
                                        <small></small>
                                    </h2>

                                </div>
                                <div class="body">

                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                        <li role="presentation" class="active"><a href="#bar_chart_project" data-toggle="tab">Bar Chart</a></li>
                                        <li role="presentation"><a href="#pie_chart_project" data-toggle="tab">Pie Chart</a></li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="bar_chart_project">
                                            <b>Bar Chart</b>
                                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="column" style="display:none">
                                                <thead>
                                                <tr>
                                                    <th>Project Status</th>
                                                    <th>
                                                        Number
                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($item->projectStatus as $key => $var)
                                                    <tr>
                                                        <td>{{$key}}</td>
                                                        <td>{{$var}}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>

                                            </table>

                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="pie_chart_project">
                                            <b>Pie Chart</b>
                                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="pie" style="display:none">
                                                <thead>
                                                <tr>
                                                    <th>Project(s)</th>
                                                    <th>
                                                        Number
                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($item->projectStatus as $key => $var)
                                                    <tr>
                                                        <td>{{$key}}</td>
                                                        <td>{{$var}}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <!-- Basic Examples -->
                        <div class=" col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        Task Status
                                        <small></small>
                                    </h2>

                                </div>
                                <div class="body">

                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                        <li role="presentation" class="active"><a href="#bar_chart_task" data-toggle="tab">Bar Chart</a></li>
                                        <li role="presentation"><a href="#pie_chart_task" data-toggle="tab">Pie Chart</a></li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="bar_chart_task">
                                            <b>Bar Chart</b>
                                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="column" style="display:none">
                                                <thead>
                                                <tr>
                                                    <th>Task Status</th>
                                                    <th>
                                                        Number
                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($item->taskStatus as $key => $var)
                                                    <tr>
                                                        <td>{{$key}}</td>
                                                        <td>{{$var}}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>

                                            </table>

                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="pie_chart_task">
                                            <b>Pie Chart</b>
                                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="pie" style="display:none">
                                                <thead>
                                                <tr>
                                                    <th>Tasks</th>
                                                    <th>
                                                        Number
                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($item->taskStatus as $key => $var)
                                                    <tr>
                                                        <td>{{$key}}</td>
                                                        <td>{{$var}}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <!-- Basic Examples -->
                        <div class=" col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        Task List Status
                                        <small></small>
                                    </h2>

                                </div>
                                <div class="body">

                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                        <li role="presentation" class="active"><a href="#bar_chart_list" data-toggle="tab">Bar Chart</a></li>
                                        <li role="presentation"><a href="#pie_chart_list" data-toggle="tab">Pie Chart</a></li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="bar_chart_list">
                                            <b>Bar Chart</b>

                                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="column" style="display:none">
                                                <thead>
                                                <tr>
                                                    <th>Task List</th>
                                                    <th>
                                                        Number
                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($item->listStatus as $key => $var)
                                                    <tr>
                                                        <td>{{$key}}</td>
                                                        <td>{{$var}}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>

                                            </table>

                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="pie_chart_list">
                                            <b>Pie Chart</b>
                                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="pie" style="display:none">
                                                <thead>
                                                <tr>
                                                    <th>Task List</th>
                                                    <th>
                                                        Number
                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($item->listStatus as $key => $var)
                                                    <tr>
                                                        <td>{{$key}}</td>
                                                        <td>{{$var}}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <!-- Basic Examples -->
                        <div class=" col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        Milestone Status
                                        <small></small>
                                    </h2>

                                </div>
                                <div class="body">

                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                        <li role="presentation" class="active"><a href="#bar_chart_milestone" data-toggle="tab">Bar Chart</a></li>
                                        <li role="presentation"><a href="#pie_chart_milestone" data-toggle="tab">Pie Chart</a></li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="bar_chart_milestone">
                                            <b>Bar Chart</b>

                                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="column" style="display:none">
                                                <thead>
                                                <tr>
                                                    <th>Milestone Status</th>
                                                    <th>
                                                        Number
                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($item->milestoneStatus as $key => $var)
                                                    <tr>
                                                        <td>{{$key}}</td>
                                                        <td>{{$var}}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>

                                            </table>

                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="pie_chart_milestone">
                                            <b>Pie Chart</b>
                                            <p>
                                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="pie" style="display:none">
                                                <thead>
                                                <tr>
                                                    <th>Milestone Status</th>
                                                    <th>
                                                        Number
                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($item->milestoneStatus as $key => $var)
                                                    <tr>
                                                        <td>{{$key}}</td>
                                                        <td>{{$var}}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <!-- Basic Examples -->
                        <div class=" col-sm-12 col-xs-12">
                            <div class="card">
                                <div class="header">
                                    <h2>
                                        My Task Status
                                        <small></small>
                                    </h2>
                                    <ul class="header-dropdown m-r--5">
                                        <li class="dropdown">
                                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="javascript:void(0);">Action</a></li>
                                                <li><a href="javascript:void(0);">Another action</a></li>
                                                <li><a href="javascript:void(0);">Something else here</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="body">

                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                        <li role="presentation" class="active"><a href="#bar_chart_my_task" data-toggle="tab">Bar Chart</a></li>
                                        <li role="presentation"><a href="#pie_chart_my_task" data-toggle="tab">Pie Chart</a></li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="bar_chart_my_task">
                                            <b>Bar Chart</b>
                                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="column" style="display:none">
                                                <thead>
                                                <tr>
                                                    <th>Tasks</th>
                                                    <th>
                                                        Number
                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($item->taskUserStatus as $key => $var)
                                                    <tr>
                                                        <td>{{$key}}</td>
                                                        <td>{{$var}}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>

                                            </table>


                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="pie_chart_my_task">
                                            <b>Pie Chart</b>
                                            <table class="highchart" id="" data-graph-container-before="1" data-graph-type="pie" style="display:none">
                                                <thead>
                                                <tr>
                                                    <th>Task Status</th>
                                                    <th>
                                                        Number
                                                    </th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($item->taskUserStatus as $key => $var)
                                                    <tr>
                                                        <td>{{$key}}</td>
                                                        <td>{{$var}}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

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
        getProducts(page);
    });

    $(document).on('click','.pagination a', function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        getProducts(page);
        location.hash = page;
    });

    function getProducts(page){

        $.ajax({
            url: '?page=' + page
        }).done(function(data){
            $('#reload_data').html(data);
        });
    }

</script>

    <script>
        $(document).ready(function() {
            $('table.highchart').highchartTable();
        });
    </script>

@endsection