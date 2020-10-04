
@include('sales_order.table',['mainData' => $mainData])

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>

<script>
    // $('.tbl_order').on('scroll', function () {
    //     $(".tbl_order > *").width($(".tbl_order").width() + $(".tbl_order").scrollLeft());
    // });
</script>

