
<hr/>
<div class="row clear-fix" >
@if(\App\Helpers\Utility::detectClosingBookStatus() == \App\Helpers\Utility::STATUS_ACTIVE)
    <div class="col-sm-4">
        <div class="form-group">
            <b>Password(Use only when books have been closed)</b>
            <div class="form-line">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
        </div>
    </div>
@else
    <input type="hidden" value="" name="password" />
@endif

</div>