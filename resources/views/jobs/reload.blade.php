
<h5>Job Application Page Url -- {{url('OByxRFDeOtxHYxnTTfJmSukkJZ7aCY/positions/2y101HS5A2C30Nex/available')}}</h5>
<hr/>
<table class="table table-bordered table-hover table-striped" id="main_table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                   name="check_all" class="" />

        </th>

        <th>Job Title</th>
        <th>Applicants</th>
        <th>Job Type</th>
        <th>Job Status</th>
        <th>Location</th>
        <th>Salary Range</th>
        <th>Experience</th>
        <th>Manage</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>{{$data->job_title}}</td>
            <td><a href="{{url('job_item/'.$data->id)}}">View Applicants</a></td>
            <td>{{$data->job_type}}</td>
            <td class="{{\App\Helpers\Utility::statusDisplayIndicator($data->job_status)}}">{{\App\Helpers\Utility::statusDisplay($data->job_status)}}</td>
            <td>{{$data->location}}</td>
            <td>{{$data->salary_range}}</td>
            <td>{{$data->experience}} yrs</td>

            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td>
                <a style="cursor: pointer;" onclick="editForm('{{$data->id}}','edit_content','<?php echo url('edit_jobs_form') ?>','<?php echo csrf_token(); ?>')"><i class="fa fa-pencil-square-o fa-2x"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class=" pagination pull-right">
    {!! $mainData->render() !!}
</div>