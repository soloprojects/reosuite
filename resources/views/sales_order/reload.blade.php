

@include('sales_order.table',['mainData' => $mainData])

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>




