@extends('layouts.app')

@section('content')


<div class="row clearfix">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2>
                {{$mainData->title}}
            </h2>
            <ul class="header-dropdown m-r--5">

                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">more_vert</i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        @include('includes/export',[$exportId = 'reload_data', $exportDocId = 'reload_data'])
                    </ul>
                </li>

            </ul>
        </div>

        <div class="body table-responsive" id="reload_data">

                    <!-- Default Media -->

                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="{{ asset('images/'.$mainData->user_c->photo) }}" width="64" height="64">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">{{$mainData->user_c->firstname}} {{$mainData->user_c->lastname}}</h4>
                            {{$mainData->title}} @ {{$mainData->created_at }} ({{$mainData->created_at->diffForHumans()}})

                            <div class="" id="refresh_comments">
                            @if(!empty($mainData->allComments))
                            @foreach($mainData->allComments as $data)
                            <div class="media">
                                <div class="row">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" src="{{ asset('images/'.$data->user->photo) }}" width="64" height="64">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">{{$data->user->firstname}} {{$data->user->lastname}}</h4>
                                    {{$data->comment}} <br/> @ {{$data->created_at}}  ({{$data->created_at->diffForHumans()}})
                                    <input type="hidden" class="comment_class" value="{{$data->id}}" />
                                </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                                <div class="media" id="display_comment"></div>
                            </div>


                            <br/>

                            <div class="media">
                                <div class="media-left">
                                        <a href="#">
                                            <img class="media-object" src="{{ asset('images/'.\App\Helpers\Utility::checkAuth('temp_user')->photo) }}" width="64" height="64">
                                        </a>
                                </div>
                                <div class="media-body">
                                        <h4 class="media-heading">{{\App\Helpers\Utility::checkAuth('temp_user')->firstname}} {{\App\Helpers\Utility::checkAuth('temp_user')->lastname}}</h4>

                                    <form name="comment" id="commentMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea type="text" class="form-control" name="comment" placeholder="Write your comment"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                        <input type="hidden" name="discuss_id" value="{{$mainData->id}}" />
                                    </form>
                                    <div class="row">
                                        <div class="col-sm-12">
                                                <button type="button" class="form-control pull-right btn-info"
                                                        onclick="submitComment('commentModal','commentMainForm','<?php echo url('comment_discuss'); ?>','display_comment',
                                                                '<?php echo url('discuss/'.$mainData->id); ?>','<?php echo csrf_token(); ?>')"
                                                        name="comment" >Submit Comment</button>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- #END# Default Media -->

        </div>



    </div>

</div>
</div>




    <!-- END OF TABS -->

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
        function submitComment(formModal,formId,submitUrl,reload_id,reloadUrl,token){
            var inputVars = $('#'+formId).serialize();
            var summerNote = '';
            var htmlClass = document.getElementsByClassName('t-editor');
            if (htmlClass.length > 0) {
                summerNote = $('.summernote').eq(0).summernote('code');;
            }
            var postVars = inputVars+'&editor_input='+summerNote;

            $('#'+formModal).modal('hide');
            sendRequestForm(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {

                    $('#'+reload_id).append(ajax.responseText);

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

                }
            }

        }

        function fetchCommentInterval(postId,commentClass,displayId,submitUrl,token){

            setInterval(function(){
                fetchFreshComments(postId,commentClass,displayId,submitUrl,token)
            },5400)

        }

        fetchCommentInterval('{{$mainData->id}}','comment_class','refresh_comments','{{url('fetch_fresh_comments')}}','{{csrf_token()}}')

    </script>


@endsection