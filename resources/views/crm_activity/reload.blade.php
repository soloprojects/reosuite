@if(!empty($mainData))
    @foreach($mainData as $activity)
        <div class="row" id="activity{{$activity->id}}">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{$activity->subject}} <small>{{$activity->type->name}}</small>
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    @if(Auth::user()->id == $activity->created_by)
                                        <li>
                                            @if($activity->response != '')
                                                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$activity->id}}','attach_content','attachModal','<?php echo url('crm_activity_response_form') ?>','<?php echo csrf_token(); ?>')">Modify Feedback</a>
                                            @else
                                                <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$activity->id}}','attach_content','attachModal','<?php echo url('crm_activity_response_form') ?>','<?php echo csrf_token(); ?>')">Feedback</a>
                                            @endif
                                        </li>

                                        <li><a style="cursor: pointer;" class="btn btn-warning" onclick="fetchHtml('{{$activity->id}}','edit_activity_content','editActivityModal','<?php echo url('edit_crm_activity_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i>Edit</a></li>

                                        <li><a type="button" onclick="deleteSingleItemCrm('{{$activity->id}}','<?php echo url('delete_crm_activity'); ?>','<?php echo csrf_token(); ?>','activity{{$activity->id}}');" class="btn btn-danger">
                                                <i class="fa fa-trash-o"></i>Delete
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <p>{{$activity->details}}</p>
                        <div class="row">
                            <span class="badge bg-cyan">Due date({{$activity->due_date}})</span>
                            <span class="badge bg-green">Status({{\App\Helpers\Utility::defaultStatus($activity->response_status)}})</span>
                            <span class="badge bg-black">Created by({{$activity->user_c->firstname}} {{$activity->user_c->lastname}})</span>
                            <span class="badge bg-blue-gray">Created at({{$activity->created_at}})</span>
                            <span class="badge bg-grey">({{$activity->created_at->diffForHumans()}})</span>
                        </div>
                    </div>
                </div>
            </div>

            @if(!empty($activity->response))
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Feedback <small>{{$activity->type->name}}</small>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        @if(Auth::user()->id == $activity->created_by)
                                            <li>
                                                @if($activity->response != '')
                                                    <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$activity->id}}','attach_content','attachModal','<?php echo url('crm_activity_response_form') ?>','<?php echo csrf_token(); ?>')">Modify Feedback</a>
                                                @else
                                                    <a style="cursor: pointer;" class="btn btn-info" onclick="fetchHtml('{{$activity->id}}','attach_content','attachModal','<?php echo url('crm_activity_response_form') ?>','<?php echo csrf_token(); ?>')">Feedback</a>
                                                @endif
                                            </li>

                                        @endif
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <p>{!!$activity->response!!}</p>
                            <div class="row">
                                <span class="badge bg-black">Created by({{$activity->user_u->firstname}} {{$activity->user_u->lastname}})</span>
                                <span class="badge bg-blue-gray">Updated at({{$activity->updated_at}})</span>
                                <span class="badge bg-grey">({{$activity->updated_at->diffForHumans()}})</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div><hr/>

    @endforeach
@endif