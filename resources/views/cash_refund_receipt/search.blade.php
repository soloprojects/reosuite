
<!-- Table Default Size -->
@include('cash_refund_receipt.table',['mainData'=>$mainData])

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>