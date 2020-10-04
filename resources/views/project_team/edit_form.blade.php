<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">

            <div class="col-sm-4">
                <?php $divId = ($edit->user_type == '' || $edit->user_type == \App\Helpers\Utility::P_USER) ? 'normal_user_edit': 'temp_user_edit'; ?>
                <?php $checkStatus = ($edit->user_type == '' || $edit->user_type == \App\Helpers\Utility::P_USER) ? '': 'checked'; ?>
                <?php $changeValue = ($edit->user_type == '' || $edit->user_type == \App\Helpers\Utility::P_USER) ? \App\Helpers\Utility::P_USER: \App\Helpers\Utility::T_USER; ?>

                <div class="form-group" id="{{$divId}}">
                    <div class="form-line">
                        @if($edit->user_type == \App\Helpers\Utility::P_USER)
                            <input type="text" class="form-control" value="{{$edit->member->firstname}} {{$edit->member->lastname}}" autocomplete="off" id="select_user_edit" onkeyup="searchOptionList('select_user_edit','myUL1_edit','{{url('default_select')}}','default_search','user_edit');" name="select_user" placeholder="Select User">
                            <input type="hidden" value="{{$edit->user_id}}" class="" name="user" id="user_edit" />
                    </div>
                </div>
                    <ul id="myUL1_edit" class="myUL"></ul>

                        @elseif($edit->user_type == \App\Helpers\Utility::T_USER)
                            <input type="text" class="form-control" value="{{$edit->extUser->firstname}} {{$edit->extUser->lastname}}" autocomplete="off" id="select_user" onkeyup="searchOptionList('select_user_edit','myUL_edit','{{url('default_select')}}','default_search_temp','user_edit');" name="select_user" placeholder="Select External/Contract User">
                            <input type="hidden" value="{{$edit->temp_user}}" class="" name="user" id="user_edit" />
                    </div>
                </div>
                    <ul id="myUL_edit" class="myUL"></ul>

                        @else
                            <input type="text" class="form-control" autocomplete="off" id="select_user_edit" onkeyup="searchOptionList('select_user_edit','myUL1_edit','{{url('default_select')}}','default_search','user_edit');" name="select_user" placeholder="Select User">
                            <input type="hidden" class="" name="user" id="user_edit" />
                    </div>
                    </div>
                    <ul id="myUL1_edit" class="myUL"></ul>
                    </div>

    @endif

            </div>

            @if($edit->user_type == \App\Helpers\Utility::P_USER || $edit->user_type == '')

                <div class="col-sm-4" id="temp_user_edit" style="display:none;">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" autocomplete="off" id="select_users_edit" onkeyup="searchOptionList('select_users_edit','myUL_edit','{{url('default_select')}}','default_search_temp','users_edit');" name="select_user" placeholder="Select External/Contract User">

                            <input type="hidden" class="" disabled="disabled" name="user" id="users_edit" />
                        </div>
                    </div>
                    <ul id="myUL_edit" class="myUL"></ul>
                </div>

            @else

                <div class="col-sm-4" id="normal_user_edit" style="display:none;">
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" autocomplete="off" id="select_user_edit" onkeyup="searchOptionList('select_user_edit','myUL1_edit','{{url('default_select')}}','default_search','user_edit');" name="select_user" placeholder="Select User">

                            <input type="hidden" class="" disabled="disabled" name="user" id="user_edit" />
                        </div>
                    </div>
                    <ul id="myUL1_edit" class="myUL"></ul>
                </div>

            @endif

        </div>
        <input type="checkbox" name="change_user" class="" {{$checkStatus}} value="{{$changeValue}}" onclick="changeUserT('normal_user_edit','temp_user_edit','change_user_edit','user_edit','users_edit');" id="change_user_edit" />Check to select contract/external user
        <hr/>


    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<script>
    $(function() {
        $( ".datepicker1" ).datepicker({
            /*changeMonth: true,
             changeYear: true*/
        });
    });
</script>