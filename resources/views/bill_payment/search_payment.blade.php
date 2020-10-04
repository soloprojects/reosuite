
<!-- Table Default Size -->
@include('bill_payment.table_payment',['mainData'=>$mainData])

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>