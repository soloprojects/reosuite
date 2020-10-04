

<div class=" table-responsive" id="reload_data_stock">

    <input type="hidden" id="stockId" value="{{$itemId}}">
    <table class="table table-bordered table-hover table-striped" id="main_table_stock">
        <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox_stock');" id="parent_check_stock"
                       name="check_all" class="" />

            </th>
            <th>Item Name</th>
            <th>Quantity Received</th>
            <th>Purchased at</th>
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
                    <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox_stock" />

                </td>

                <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->

                <td>{{$data->inventory->item_name}} </td>
                <td>{{$data->qty}}</td>
                <td>{{$data->purchase_date}}</td>
                <td>
                    @if($data->created_by != '0')
                        {{$data->user_c->firstname}} {{$data->user_c->lastname}}
                    @endif
                </td>
                <td>
                    @if($data->updated_by != '0')
                        {{$data->user_u->firstname}} {{$data->user_u->lastname}}
                    @endif
                </td>
                <td>{{$data->created_at}}</td>
                <td>{{$data->updated_at}}</td>
                <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="stock_pagination pull-right">
        {!! $mainData->render() !!}
    </div>

</div>

