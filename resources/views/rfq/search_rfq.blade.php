

@include('rfq.table',['mainData' => $mainData])

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>