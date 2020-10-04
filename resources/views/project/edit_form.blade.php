<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->project_name}}" name="project_name" placeholder="Project Name">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control" name="project_description" placeholder="Project Description">{{$edit->project_desc}}
                        </textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <b>Start Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker" value="{{$edit->start_date}}" autocomplete="off" name="start_date" placeholder="Start Date">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>End Date</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control datepicker" value="{{$edit->end_date}}" autocomplete="off" name="end_date" placeholder="End Date">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <b>Budget</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" value="{{$edit->budget}}" name="budget" placeholder="Budget">
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                Customer/Client
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" autocomplete="off" value="{{$edit->customer->name}}" id="select_customer_edit" onkeyup="searchOptionList('select_customer_edit','myUL2_edit','{{url('default_select')}}','search_customer','customer_edit');" name="select_user" placeholder="Select Customer">

                        <input type="hidden" class="user_class" value="{{$edit->customer_id}}" name="customer" id="customer_edit" />
                    </div>
                </div>
                <ul id="myUL2_edit" class="myUL"></ul>
            </div>

            <div class="col-sm-4">
                <b>Project Head</b>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" autocomplete="off" value="{{$edit->pro_head->firstname}} {{$edit->pro_head->lastname}}" id="select_user_edit" onkeyup="searchOptionList('select_user_edit','myUL1_edit','{{url('default_select')}}','default_search','user_edit');" name="select_user" placeholder="Department Head">

                        <input type="hidden" class="user_class" value="{{$edit->project_head}}" name="project_head" id="user_edit" />
                    </div>
                </div>
                <ul id="myUL1_edit" class="myUL"></ul>
            </div>

            <div class="col-sm-4">
                <b>Billing Method</b>
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control" name="bill_method" >
                            <option value="{{$edit->bill_id}}">{{$edit->billing->bill_name}}</option>
                            @foreach($billMethod as $bill)
                                <option value="{{$bill->id}}">{{$bill->bill_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select class="form-control project_status" name="project_status" >

                            @foreach(\App\Helpers\Utility::TASK_STATUS as $key => $task)
                                @if($edit->project_status == $key)
                                    <option selected value="{{$key}}">{{$task}}</option>
                                @endif
                                <option value="{{$key}}">{{$task}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
        $( ".datepicker" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>