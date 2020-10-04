<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Name</th>
        <th>Description</th>
        <th>Net Pay</th>
        <th>Gross Pay</th>
        <th>Tax</th>
        <th>Components</th>
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
            <td>{{$data->salary_name}}</td>
            <td>{{$data->desc}}</td>
            <td>{{Utility::numberFormat($data->net_pay)}}</td>
            <td>{{Utility::numberFormat($data->gross_pay)}}</td>
            <td>
                @if($data->tax_id != '')
                    {{$data->tax->tax_name}}
                @endif
            </td>
            <td>
                @if($data->component != '')
                    <table class="table table-bordered table-hover">
                        <thead>
                        <th>Component</th>
                        <th>Amount</th>
                        <th>Component Type</th>
                        </thead>
                        <tbody>
                        <?php $components = json_decode($data->component,TRUE); ?>
                        @foreach($components as $comp)
                            <tr>
                                <td>{{$comp['component']}}</td>
                                <td>{{Utility::numberFormat($comp['amount'])}}</td>
                                <td>{{$comp['component_type']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </td>
            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>
                <a style="cursor: pointer;" onclick="editFormSalStr('{{$data->id}}','edit_content','<?php echo url('edit_structure_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>