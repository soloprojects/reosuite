

<div class="modal fade" id="printPreviewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Print Preview</h4>
                @include('includes/print_pdf',[$exportId = 'print_preview_data', $exportDocId = 'print_preview_data'])

            </div>
            <div class="modal-body" id="print_preview" style="height:450px; overflow-y:scroll;">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>