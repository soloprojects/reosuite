<p>
    {{$edit->test_name}}
</p>

<table class="table table-bordered table-hover table-striped" id="">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_remove_cat');" id="parent_check_remove_cat"
                   name="check_all" class="" />

        </th>

        <th>Current Test Category(ies)</th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($edit->testCategory))
    @foreach($edit->testCategory as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="remove_cat_{{$data->id}}" class="kid_checkbox_remove_cat" />

            </td>

            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->category_name}}</td>

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
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox_add_cat');" id="parent_check_add_cat"
                   name="check_all" class="" />

        </th>

        <th>Non Test Category(ies)</th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($edit->extra_category))
        @foreach($edit->extra_category as $data)
            <tr>
                <td scope="row">
                    <input value="{{$data->id}}" type="checkbox" id="add_cat_{{$data->id}}" class="kid_checkbox_add_cat" />

                </td>

                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                <td>{{$data->category_name}}</td>

                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

            </tr>
        @endforeach
    @endif
    </tbody>
</table>

<input type="hidden" value="{{$edit->id}}" id="cat_test_id" name="cat_test_id" />