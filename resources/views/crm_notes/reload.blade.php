@if(!empty($mainData))
    @foreach($mainData as $note)
        <div class="row" id="notes{{$note->id}}">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">

                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    @if(Auth::user()->id == $note->created_by)

                                        <li><a style="cursor: pointer;" onclick="fetchHtml('{{$note->id}}','edit_notes_content','editNotesModal','<?php echo url('edit_crm_notes_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a></li>

                                        <li><a type="button" onclick="deleteSingleItemCrm('{{$note->id}}','<?php echo url('delete_crm_notes'); ?>','<?php echo csrf_token(); ?>','notes{{$note->id}} ');" class="btn btn-danger">
                                                <i class="fa fa-trash-o"></i>Delete
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <p>{{$note->details}}</p>
                        <div class="row">
                            <span class="badge bg-black">Created by({{$note->user_c->firstname}} {{$note->user_c->lastname}})</span>
                            <span class="badge bg-blue-gray">Created at({{$note->created_at}})</span>
                            <span class="badge bg-grey">({{$note->created_at->diffForHumans()}})</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endforeach
@endif