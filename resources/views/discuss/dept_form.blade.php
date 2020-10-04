<p>
    {{$edit->title}}
</p>

<table class="table table-bordered table-hover table-striped" id="">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_remove');" id="parent_check_remove"
                   name="check_all" class="" />

        </th>

        <th>Current department(s) accessible to discussion(s)</th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($edit->dept))
    @foreach($edit->dept as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="add_{{$data->id}}" class="kid_checkbox_remove" />

            </td>

            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->dept_name}}</td>

            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    @endif
    </tbody>
</table>


<table class="table table-bordered table-hover table-striped" id="">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_add');" id="parent_check_add"
                   name="check_all" class="" />

        </th>

        <th>Department(s) currently not accessible to discussion(s)</th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($edit->extra_dept))
        @foreach($edit->extra_dept as $data)
            <tr>
                <td scope="row">
                    <input value="{{$data->id}}" type="checkbox" id="add_{{$data->id}}" class="kid_checkbox_add" />

                </td>

                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                <td>{{$data->dept_name}}</td>

                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

            </tr>
        @endforeach
    @endif
    </tbody>
</table>

<input type="hidden" value="{{$edit->id}}" id="discuss_id" name="discuss_id" />