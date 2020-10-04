
<!-- Table Default Size -->
@include('credit_memo.table',['mainData'=>$mainData])

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>