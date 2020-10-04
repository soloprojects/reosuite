@extends('layouts.app')

@section('content')

    <!-- Bordered Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Final Individual Goal comment/Review of Unit Heads
                    </h2>
                    <ul class="header-dropdown m-r--5">

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
                    <form name="searchFrameForm" id="searchFrameForm" onsubmit="false;" id="" class="form form-horizontal" method="get" enctype="multipart/form-data">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <select  class="form-control " name="goal_set" >
                                        <option value="">Goal Set</option>
                                        @foreach($mainData as $ap)
                                            <option value="{{$ap->id}}">{{$ap->goal_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button onclick="searchReport('searchFrameForm','<?php echo url('review_unit_head_comments'); ?>','reload_data',
                                '','<?php echo csrf_token(); ?>')" type="button" class="btn btn-info waves-effect">
                            Search/View
                        </button>
                    </form>
                    <hr/>
                </div>
                <div class="body table-responsive" id="reload_data">


                </div>

            </div>

        </div>
    </div>

    <!-- #END# Bordered Table -->


@endsection