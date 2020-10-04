

<div class="row clearfix" id="export_news">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                   {{$edit->news_title}} <small>Created {{$edit->created_at->diffForHumans()}} by {{$edit->user_c->firstname}} {{$edit->user_c->lastname}}</small>
                </h2>
            </div>
            <div class="body">
                {!! $edit->embed_video !!}
               {!! $edit->news_desc !!}
            </div>
        </div>
    </div>
</div>