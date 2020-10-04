<!-- Table Default Size -->
@include('invoice.table',['mainData'=>$mainData])

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>