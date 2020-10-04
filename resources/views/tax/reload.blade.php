<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Tax Name</th>
        <th>Percentage Sum</th>
        <th>Tax Components</th>
        <th>Manage</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->tax_name}}</td>
            <td>{{$data->sum_percentage}}</td>
            <td>
                @if($data->component != '')
                    <table class="table table-bordered table-hover">
                        <thead>
                        <th>Name</th>
                        <th>Agent</th>
                        <th>Percentage</th>
                        </thead>
                        <tbody>
                        <?php $components = json_decode($data->component,TRUE); ?>
                        @foreach($components as $comp)
                            <tr>
                                <td>{{$comp['component']}}</td>
                                <td>{{$comp['tax_agent']}}</td>
                                <td>{{$comp['percentage']}}%</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_tax_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>