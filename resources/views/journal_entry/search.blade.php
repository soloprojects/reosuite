

@include('journal_entry.table',['mainData' => $mainData])

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>