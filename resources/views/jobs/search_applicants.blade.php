

    <table class="table table-bordered table-hover table-striped" id="main_table">
        <thead>
        <tr>
            <th>
                <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                       name="check_all" class="" />

            </th>

            <th>Cover Letter</th>
            <th>Download CV</th>
            <th>Job Title</th>
            <th>Fullname</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Experience</th>
        </tr>
        </thead>
        <tbody>
        @foreach($mainData as $data)
        <tr>
            <td scope="row">
                <input value="{{$data->id}}" type="checkbox" id="{{$data->id}}" class="kid_checkbox" />

            </td>
            <td>
                <a style="cursor: pointer;" onclick="viewLetter('letterModal','letter_content','{{$data->cover_letter}}')">View Cover Letter</a>
            </td>
            <!-- ENTER YOUR DYNAMIC COLUMNS HERE -->
            <td><a target="_blank" href="<?php echo URL::to('download_cv_attachment?file='); ?>{{$data->cv_file}}">
                    <i class="fa fa-files-o fa-2x"></i>Download
                </a>
            </td>
            <td>{{$data->job->job_title}}</td>
            <td>{{$data->firstname}} {{$data->lastname}}</td>
            <td>{{$data->phone}}</td>
            <td>{{$data->email}}</td>
            <td>{{$data->address}}</td>
            <td>{{$data->experience}} yrs</td>

            <!--END ENTER YOUR DYNAMIC COLUMNS HERE -->

        </tr>
        @endforeach
        </tbody>
    </table>


