
<!-- Print Transact Default Size -->
@include('invoice_payment_receipt.table',['mainData'=>$mainData])

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>


