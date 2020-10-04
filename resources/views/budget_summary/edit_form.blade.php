<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Budget Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" value="{{$edit->name}}" class="form-control" id="" name="name" placeholder="Budget Name" >
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Financial Year*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="financial_year"  required>
                            <option value="{{$edit->fin_year_id}}">{{$edit->financialYear->fin_name}}</option>
                            @foreach($finYear as $data)
                                <option value="{{$data->id}}">{{$data->fin_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @if($edit->created_by == Auth::user()->id)
            <div class="col-sm-4">
                <b>Copy Budget*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="copy_budget"  required>
                            <option value="">Select Budget to Copy</option>
                            @foreach($budgetCopy as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @endif

        </div>
        <hr/>

        <div class="row clearfix">
            @if($edit->created_by == Auth::user()->id)
            <div class="col-sm-6">
                <b>Total Budget Amount {{\App\Helpers\Utility::defaultCurrency()}}*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" value="{{$edit->budget_amount}}" class="form-control" name="total_budget_amount" placeholder="Total Budget Amount" required>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Budget Status*</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="budget_status"  required>
                            <option value="{{$edit->budget_status}}">{{\App\Helpers\Utility::budgetStatusReadyDisplay($edit->budget_status)}}</option>
                            <option value="{{\App\Helpers\Utility::NOT_READY_FOR_APPROVAL}}">{{\App\Helpers\Utility::budgetStatusReadyDisplay(\App\Helpers\Utility::NOT_READY_FOR_APPROVAL)}}</option>
                            <option value="{{\App\Helpers\Utility::READY_FOR_APPROVAL}}">{{\App\Helpers\Utility::budgetStatusReadyDisplay(\App\Helpers\Utility::READY_FOR_APPROVAL)}}</option>

                        </select>
                    </div>
                </div>
            </div>
            @else
            <div class="col-sm-6">
                <b>Total Budget Amount {{\App\Helpers\Utility::defaultCurrency()}}*</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" disabled value="{{$edit->total_budget}}" class="form-control" name="total_budget_amount" placeholder="Total Budget Amount" required>
                    </div>
                </div>
            </div>
            @endif

        </div>
        <hr/>

        <div class="row clearfix">
            @if(in_array(Auth::user()->role,\App\Helpers\Utility::TOP_USERS) && $edit->created_by != Auth::user()->id)
            <div class="col-sm-6">
                <b>Reviewer's Comment</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" rows="10" name="reviewer_comment" placeholder="Comment Here" >{{$edit->reviewer_comment}}</textarea>
                    </div>
                </div>
            </div>

                <div class="col-sm-6">
                    <b>Comment</b>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea class="form-control" rows="10" disabled name="comment" placeholder="Comment Here" >{{$edit->comment}}</textarea>
                        </div>
                    </div>
                </div>
            @else

            <div class="col-sm-6">
                <b>Reviewer's Comment</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" rows="10" disabled name="reviewer_comment" placeholder="Comment Here" >{{$edit->reviewer_comment}}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <b>Comment</b>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" rows="10" name="comment" placeholder="Comment Here" >{{$edit->comment}}</textarea>
                    </div>
                </div>
            </div>

            @endif

        </div>
        <hr/>

    </div>

    <input type="hidden" name="created_by" value="{{$edit->created_by}}" >
    <input type="hidden" name="approval_status" value="{{$edit->approval_status}}" >
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
        $( ".datepicker1" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
            /*yearRange: "-90:+00"*/

        });
    });
</script>

