

<hr/>
<div class="row clearfix">
    <div class="col-sm-4">
        <div class="form-group">
            1 {{\App\Helpers\Utility::defaultCurrency()}} =
            <div class="form-line ">
                <input type="text" class="form-control" name="curr_rate" id="curr_rate" readonly placeholder="Currency Rate">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            File/Ref Number
            <div class="form-line">
                <input type="text" class="form-control" autocomplete="off" name="file_no" placeholder="File Number">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        Status
        <div class="form-group">
            <div class="form-line">
                <select class="form-control " name="status" >
                    <option value="">Select status</option>
                    @foreach(\App\Helpers\Utility::accountStatus() as $val)                                                
                    <option value="{{$val->id}}">{{$val->name}}</option>
                @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<hr/>

<div class="row clearfix">
    
    <div class="col-sm-4">
        Location
        <div class="form-group">
            <div class="form-line">
                <select class="form-control" name="location" >
                    <option value="">Select Location</option>
                    @foreach($transLocation as $val)                                                
                    <option value="{{$val->id}}">{{$val->location}}</option>
                @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        Class
        <div class="form-group">
            <div class="form-line">
                <select class="form-control" name="transaction_class" >
                    <option value="">Select Class</option>
                    @foreach($transClass as $val)                                                
                    <option value="{{$val->id}}">{{$val->class_name}}</option>
                @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        Password
        <div class="form-group">
            <div class="form-line">
                <input type="password" class="form-control"  id="" name="password" placeholder="password"></textarea>
            </div>
        </div>
    </div>
    
</div>    
<div class="row clearfix">
       <div class="col-sm-4">
        Print
        <div class="form-group">
            <div class="form-line ">
                <input type="checkbox" class="form-control" name="print_status" id="" value="1" placeholder="">
            </div>
        </div>
    </div>
    
</div>