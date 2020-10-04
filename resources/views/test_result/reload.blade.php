@if($type == 'error')
    No match found, please fill in all required fields
    <ul>
        @foreach($mainData as $data)
            <li>{{$data}}</li>
        @endforeach
    </ul>
@endif

@if($type == 'data')
<!-- Example Tab -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                   Test Result
                    <small></small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another action</a></li>
                            <li><a href="javascript:void(0);">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="body">
                <table class="table table-bordered table-hover table-striped" id="main_table">
                    <thead>
                    <tr>
                        <th>
                            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                                   name="check_all" class="" />

                        </th>
                        <th>Name</th>
                        <th>Session</th>
                        <th>Test</th>
                        <th>Test Category(ies)</th>
                        <th>View Question Explanation</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($mainData->testUsers as $data)
                        <tr>
                            <td scope="row">
                                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

                            </td>
                            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
                            <td>{{$data->firstname}} {{$data->lastname}}</td>
                            <td>{{$session->session_name}}</td>
                            <td>{{$mainData->test_name}}</td>
                            <td>
                                <table>
                                    <thead>
                                    <th>Category</th>
                                    <th>Score</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Average Score of All Category(ies)</td>
                                            <td>{{$data->avgScore}} out of {{$data->avgTotalScore}}({{$data->avgScorePerct}}%)</td>
                                        </tr>
                                    @foreach($data->category as $cat)
                                        <tr>
                                            <td>{{$cat->category_name}}</td>
                                            <td>{{$cat->scoreAns}} out of {{$cat->overallAns}}({{$cat->scorePerct}}%)</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
                                <td>
                                    <a style="cursor: pointer;" onclick="fetchExplanation('{{$mainData->id}}','text_preview','textModal','<?php echo url('test_explanation') ?>','<?php echo csrf_token(); ?>','{{$session->id}}','{{$participantType}}','{{$data->id}}');">View Explanation to Question(s)</a>
                                </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<!-- #END# Example Tab -->

<script>

    function fetchExplanation(dataId,displayId,modalId,submitUrl,token,param1,param2,userId){

        var postVars = "dataId="+dataId+"&param1="+param1+"&param2="+param2+"&userId="+userId;
        $('#'+modalId).modal('show');
        sendRequest(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                var ajaxData = ajax.responseText;
                $('#'+displayId).html(ajaxData);

            }
        }
        $('#'+displayId).html('LOADING DATA');

    }

    $(document).ready(function() {
        $('table.highchart').highchartTable();
    });
</script>

@endif

