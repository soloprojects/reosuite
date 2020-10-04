@extends('layouts.app')

@section('content')


    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        My Calendar
                    </h2>
                    <ul class="header-dropdown m-r--5">

                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a class="btn bg-blue-grey waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-print"></i>Print</a></li>
                                <li><a class="btn bg-red waves-effect" onClick ="print_content('main_table');" ><i class="fa fa-file-pdf-o"></i>Pdf</a></li>
                                <li><a class="btn btn-warning" onClick ="$('#main_table').tableExport({type:'excel',escape:'false'});" ><i class="fa fa-file-excel-o"></i>Excel</a></li>
                                <li><a class="btn  bg-light-green waves-effect" onClick ="$('#main_table').tableExport({type:'csv',escape:'false'});" ><i class="fa fa-file-o"></i>CSV</a></li>
                                <li><a class="btn btn-info" onClick ="$('#main_table').tableExport({type:'doc',escape:'false'});" ><i class="fa fa-file-word-o"></i>Msword</a></li>

                            </ul>
                        </li>

                    </ul>
                </div>
                <div class="body table-responsive" id="reload_data">
                    <div id="my_calendar">

                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->

<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('my_calendar');


        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            height: 'parent',
            header: {
                left: 'prevYear,prev,next,nextYear today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            defaultView: 'dayGridMonth',
            defaultDate: '{{date('Y-m-d')}}',
            navLinks: true, // can click day/week names to navigate views

            selectable: true,
            selectMirror: true,
            selectHelper: true,
            select: function(arg,start,end,allDay) {
                var title = prompt('Enter Event Title:');
                if (title) {
                    var start = (new Date(arg.start)).toISOString().slice(0, 10);
                    var end = (new Date(arg.end)).toISOString().slice(0, 10);
                    $.ajax({
                        url:"{{url('change_calendar')}}",
                        type:"GET",
                        data: "title="+title+"&start="+start+"&end="+end+"&type=create",
                        success:function(){
                            calendar.addEvent({
                                title: title,
                                start: arg.start,
                                end: arg.end,
                                allDay: arg.allDay
                            })
                            alert('Added Successfully');
                        }
                    })
                }
                calendar.unselect()
            },

            editable: true,
            eventResize: function(arg){
                var start = moment(arg.event.start).toISOString();

                var end = moment(arg.event.end).toISOString();


                var title = arg.event.title;
                var id = arg.event.id;
                $.ajax({
                    url:"{{url('change_calendar')}}",
                    type:"GET",
                    data: "title="+title+"&start="+start+"&end="+end+"&id="+id+"&type=edit",
                    success:function(){
                        calendar.addEvent({
                            title: title,
                            start: start,
                            end: end,
                            allDay: arg.allDay
                        });
                        alert('Updated Successfully');
                    }
                })

            },
            eventDrop: function(arg){
                var start = moment(arg.event.start).toISOString();

                var end = moment(arg.event.end).toISOString();


                var title = arg.event.title;
                var id = arg.event.id;
                $.ajax({
                    url:"{{url('change_calendar')}}",
                    type:"GET",
                    data: "title="+title+"&start="+start+"&end="+end+"&id="+id+"&type=edit",
                    success:function(){
                        /*calendar.addEvent({
                            title: title,
                            start: start,
                            end: end,
                            allDay: arg.allDay
                        });*/
                        alert('Updated Successfully');
                    }
                })

            },
            eventLimit: false, // allow "more" link when too many events
            events: '{{url('load_my_calendar')}}'
        });

        calendar.render();
    });


</script>


@endsection