<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Lead</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->lead->name}}"  autocomplete="off" id="select_lead" onkeyup="searchOptionList('select_lead','myUL','{{url('default_select')}}','search_crm_lead','lead');" name="select_user" placeholder="Search Lead">

                        <input type="hidden" value="{{$edit->lead_id}}" class="lead_class" value="" name="lead" id="lead" />
                    </div>
                </div>
                <ul id="myUL" class="myUL"></ul>
            </div>

            <div class="col-sm-4">
                <b>Opportunity Name</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->opportunity_name}}" name="opportunity_name" placeholder="Opportunity Name">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Amount ({{\App\Helpers\Utility::defaultCurrency()}})</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->amount}}" id="amount_edit" name="amount" placeholder="Amount">
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Sales Team</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="sales_team" >
                            <option value="{{$edit->sales_team_id}}">{{$edit->sales->name}}</option>
                            @foreach($salesTeam as $d)
                                <option value="{{$d->id}}">{{$d->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Opportunity Stage</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="opportunity_stage" id="stage_edit" onchange="getRevenue('amount_edit','stage_edit','revenue_edit','{{url('fetch_crm_possibility')}}')" >
                            <option value="{{$edit->stage_id}}">{{$edit->phase->name}} (Stage{{$edit->phase->stage}})</option>
                            @foreach($opportunityStage as $d)
                                <option value="{{$d->id}}">{{$d->name}}(Stage {{$d->stage}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <b>Expected Revenue ({{\App\Helpers\Utility::defaultCurrency()}})</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->expected_revenue}}" id="revenue_edit" name="expected_revenue" placeholder="Expected Revenue">
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Closing Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker2" value="{{$edit->closing_date}}" name="closing_date" placeholder="Closing Date">
                    </div>
                </div>
            </div>
        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
        $( ".datepicker2" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
            /*yearRange: "-90:+00"*/

        });
    });
</script>