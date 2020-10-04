<div class="row clearfix">

    <div class="col-sm-4">
        <b>Mail Option</b>
        <div class="form-group">
            <div class="form-line">
                <select class="form-control" name="mail_option" >
                    <option selected value="1">Send Mail</option>
                    <option value="0">Do not send mail</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <b>Send Mail To</b>
        <div class="form-group">
            <div class="form-line">
                <textarea class="form-control" name="emails" id="emails" placeholder="Enter Email(s), use a comma to separate them" ></textarea>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <b>Attachment</b>
        <div class="form-group">
            <div class="form-line">
                <input type="file" class="form-control" multiple="multiple" name="file[]" >
            </div>
        </div>
    </div>

</div>

<div class="container row clearfix">

    <div class="col-sm-4">
        <b>Copy (cc)</b>
        <div class="form-group">
            <div class="form-line">
                <textarea class="form-control" name="mail_copy" id="copy_mails" placeholder="Enter Email(s), use a comma to separate them" ></textarea>
            </div>
        </div>
    </div>

</div>

<div class="row clearfix">

    <textarea id="mail_message" name="message" class="ckeditor" placeholder="Message">Message...</textarea>
    <script>
        CKEDITOR.replace('mail_message');
    </script>
</div>