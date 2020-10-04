<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control department"  name="department1" >
                            <option value="">Department</option>
                            @foreach($dept as $ap)
                                @if($edit->dept_id == $ap->id)
                                <option value="{{$ap->id}}" selected>{{$ap->dept_name}}</option>
                                @else
                                <option value="{{$ap->id}}">{{$ap->dept_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <select  class="form-control competency" name="competency_type" >
                            <option value="">Competency Type</option>
                            @foreach($compType as $ap)
                                @if($edit->skill_comp_id == $ap->id)
                                    <option value="{{$ap->id}}" selected>{{$ap->skill_comp}}</option>
                                @else
                                    <option value="{{$ap->id}}">{{$ap->skill_comp}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control category" value="{{$edit->category_name}}" name="category_name" placeholder="Category Name">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control desc" value="{{$edit->cat_desc}}" name="description" placeholder="Description">
                    </div>
                </div>
            </div>

        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>