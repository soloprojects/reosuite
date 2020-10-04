
<!-- Print Transact Default Size -->
@include('invoice_payment_receipt.table_receipt',['mainData'=>$mainData])

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>


