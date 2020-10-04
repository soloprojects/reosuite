

@if(count($bomData) > 0)
    <tr class="bom_{{$data->id}}" style="display:none;"><td>Bill of materials (BOM)</td></tr>
    @foreach($bomData as $bom)
        <tr class="bom_{{$data->id}}" style="display:none;">
            <td>{{$bom->inventory->item_name}} ({{$bom->inventory->item_no}})</td>
            <td>{{$bom->inventory->purchase_desc}}</td>
            <td>{{$bom->quantity}}</td>
        </tr>

    @endforeach

@else
    <tr class="bom_{{$data->id}}" style="display:none;"><td>Not BOM Item</td></tr>
@endif