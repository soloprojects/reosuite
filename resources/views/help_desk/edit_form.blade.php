<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal container" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->subject}}" name="subject" placeholder="Subject ">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control" name="ticket_category" >
                            <option value="{{$edit->ticket_cat}}">{{$edit->ticketCategory->request_name}}</option>
                            @foreach($ticketCat as $ap)
                                <option value="{{$ap->id}}">{{$ap->request_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <hr/>

        <div class="row clearfix">

            <div class="">
                <div class="form-group">
                    <div class="form-line">
                        <textarea type="text" id="request_details_edit" class="form-control " name="details_edit" placeholder="Details">{{$edit->details}}</textarea>
                        <script>
                            CKEDITOR.replace('details_edit');
                        </script>
                    </div>
                </div>
            </div>

        </div>
        <hr/>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
        $( ".datepicker1" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>