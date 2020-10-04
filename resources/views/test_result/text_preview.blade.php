<table class="table table-bordered table-hover table-striped" id="print_text_data">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Name</th>
        <th>Category</th>
        <th>Question</th>
        <th>Explanation</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->participant->firstname}} {{$data->participant->lastname}}</td>
            <td>{{$data->category->category_name}} </td>
            <td>{!!$data->question->question!!} </td>
            <td>{{$data->text_answer}}</td>
            <td>{{$data->created_at}}</td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
    @endforeach
    </tbody>
</table>



