<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Week</b>
                <div class="form-group">
                    <div class="form-line">
                        <select type="text" class="form-control" name="week1" placeholder="Week 1">
                            <option value="{{$edit->week}}">Week {{$edit->week}}</option>    
                            @for($j=1;$j<=4;$j++)
                                <option value="{{$j}}">Week {{$j}}</option>
                            @endfor
                        </select>    
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <b>Month</b>
                    <div class="form-line">
                        <select type="text" class="form-control" name="month1" placeholder="Month 1">
                            <option value="{{$edit->month}}">{{date("F", mktime(0, 0, 0, $edit->month, 10))}}</option>    
                            @for($k=1;$k<=12;$k++)
                                <option value="{{$k}}">{{date("F", mktime(0, 0, 0, $k, 10))}}</option>
                            @endfor
                        </select>    
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <b>Year</b>
                    <div class="form-line">
                        <select type="text" class="form-control" name="year1" placeholder="Year 1">
                            <option value="{{$edit->year}}">{{$edit->year}}</option>    
                            @for($l=date('Y')+5;1980 <= $l;$l--)
                                <option value="{{$l}}">{{$l}}</option>
                            @endfor
                        </select>    
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>