
@if($data->type == 'next_approval')
    @if(Auth::user()->id == $data->user_id)
    <p>
        Hello {{$data->name}}, {{$data->sender_name}} made a leave request contained below<br>
        {{$data->desc}}. Please action this request.

    </p>
    @else
        <p>
            Hello {{$data->name}}, {{Auth::user()->firstname}} made a leave request on behalf of {{$data->sender_name}},<br>
            {{$data->desc}}. Please action this request.
        </p>
    @endif

@endif

@if($data->type == 'request_approved')

    Hello, the leave request made by {{$data->sender_name}} has been approved.<br>
    {{$data->desc}}.

@endif

@if($data->type == 'request_denied')

    Hello, the leave request made by {{$data->sender}} has been denied.<br>
    {{$data->desc}}.

@endif