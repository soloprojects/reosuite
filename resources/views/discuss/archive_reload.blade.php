<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Title</th>
        <th>Department Access</th>
        <th>User(s) Access</th>
        <th>Created by</th>
        <th>Updated by</th>
        <th>Created at</th>
        <th>Updated at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->title}}</td>
            <td>
                @if(!empty($data->deptAccess))
                    <table>
                        <tbody>
                        @foreach($data->deptAccess as $dept)
                            <tr><td>{{$dept->dept_name}}</td></tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </td>
            <td>
                @if(!empty($data->userAccess))
                    <table>
                        <tbody>
                        @foreach($data->userAccess as $user)
                            <tr><td>{{$user->firstname}} {{$user->lastname}}</td></tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </td>
            <td>
                {{$data->user_c->firstname}} {{$data->user_c->lastname}}
            </td>
            <td>
                {{$data->user_u->firstname}} {{$data->user_u->lastname}}
            </td>
            <td>{{$data->created_at}}</td>
            <td>{{$data->updated_at}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>