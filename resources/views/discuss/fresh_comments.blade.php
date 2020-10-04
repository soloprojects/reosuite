@foreach($mainData as $data)
<div class="row">
    <div class="media-left">
        <a href="#">
            <img class="media-object" src="{{ asset('images/'.\App\Helpers\Utility::checkAuth('temp_user')->photo) }}" width="64" height="64">
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading">{{\App\Helpers\Utility::checkAuth('temp_user')->firstname}} {{\App\Helpers\Utility::checkAuth('temp_user')->lastname}}</h4>

        {{$data->comment}} <br/> @ {{$data->created_at }} ({{$data->created_at->diffForHumans()}})
        <input type="hidden" class="comment_class" value="{{$data->id}}" />
    </div>
</div>
@endforeach
<div class="media" id="display_comment"></div>


