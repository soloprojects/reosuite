/**
 * Created by snweze on 11/8/2017.
 */

    const LoadingIcon = "public/icons/loading_icon.gif";
    const META = $('meta[name="csrf-token"]');
    const CSRF_TOKEN =  META.attr('content');

    function _(e){
        return document.getElementById(e);
    }

    function idVal(elementId){
        var elVal = $('#'+elementId);
        return elVal.val();
    }

    function getId(elementId){
        var el = $('#'+elementId);
        return el;
    }

    //DISPLAYS/HIDES LOADING ICON DURING SEARCH,SAVE,EDIT ETC
    function overlayBody(visibleStatus){
        var overlayAppBody = getId('overlay_app_body');
        var overlayLoadingIcon = getId('overlay_loading_icon');
        var overlayLoadingText = getId('overlay_loading_text');

        overlayAppBody.css('display',visibleStatus);
        overlayLoadingIcon.css('display',visibleStatus);
        overlayLoadingText.css('display',visibleStatus);
    }

    //DISPLAYS/HIDES LOADING ICON DURING SEARCH,SAVE,EDIT ETC
    function resetForm(formId){       
        var getForms = _(formId);
        getForms.reset();
    }
    

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': META.attr('content')
        }
    });

    var ajax = false;

    if (window.XMLHttpRequest){
        ajax= new XMLHttpRequest();
    }else if (window.ActiveXObject){
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }

    function sendRequest(linko,token,postVars){
        ajax.open("POST", linko, true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.setRequestHeader("X-CSRF-TOKEN", CSRF_TOKEN);
        ajax.send(postVars);
    }

    function sendRequestForm(linko,token,postVars){
        ajax.open("POST", linko, true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.setRequestHeader("X-CSRF-TOKEN", CSRF_TOKEN);
        ajax.send(postVars);

    }

    function sendRequestMediaForm(linko,token,postVars){
        ajax.open("POST", linko, true);
        ajax.setRequestHeader("X-CSRF-TOKEN", CSRF_TOKEN);
        ajax.send(postVars);

    }

    function swalFormError(formError){
        var errorMessage = '';
        errorMessage += formError;
        return errorMessage;

    }

    function swalDefaultError(errorMessage){

        var info_div = '';

        info_div += errorMessage;
        return info_div;

    }

    function swalWarningError(errorMessage){

        var info_div = '';

        info_div += errorMessage;
        return info_div;

    }

    function swalSuccess(successMessage){

        var info_div = '';
        info_div += successMessage;
        return info_div;

    }

    function phpValidationError(jsonObject){
        var validationErrors = "";
        for(var k in jsonObject) {
            if(jsonObject.hasOwnProperty(k)) {
                jsonObject[k].forEach(function(val)  {
                    validationErrors += val+', ';
                });
            }
        }
        return validationErrors;
    }

    function loopJson(jsonObject,val){
        var data = "";
        for(var k in jsonObject) {
            if(jsonObject.hasOwnProperty(k)) {
                //data += jsonObject[k];
                if (jsonObject[k] == val) {
                    data = val;
                }
            }
        }
        return data;
    }

    function checkArrItem(arr,val){
        var data = "";
        for(var i=0; i < arr.length; i++){
            if(arr[i] == val){
                data = val;
            }
        }

        return data;
    }

    //ADD GROUP OF CHECKED INPUT CHECKBOX INTO AN ARRAY
    function group_val(klass){

        var approve = document.getElementsByClassName(klass);
        var values = [];
        for(var i=0; i < approve.length; i++){
            if(approve[i].checked){
                values.push(approve[i].value);
            }
        }
        return values;
    }

    //ADD GROUP OF UNCHECKED INPUT CHECKBOX INTO AN ARRAY
    function group_val_unchecked(klass){

        var approve = document.getElementsByClassName(klass);
        var values = [];
        for(var i=0; i < approve.length; i++){
            if(approve[i].checked){                
            }else{
                values.push(approve[i].value);
            }
        }
        return values;
    }

    //toggle to check/uncheck all (this.id,class)
    function toggleme(master,one){
        var all = document.getElementsByClassName(one);
        for(var i=0; i < all.length; i++){
            did = document.getElementById(all[i].id);
            did.checked = master.checked;
        }
    }

    function filter_array(test_array) {
        var index = -1,
            arr_length = test_array ? test_array.length : 0,
            resIndex = -1,
            result = [];

        while (++index < arr_length) {
            var value = test_array[index];

            if (value) {
                result[++resIndex] = value;
            }
        }

        return result;
    }

    //CHECK IF ARRAY EXISTS TWICE
    function double(objects){
        var hold_objects = [];
        for(var i=0; i<objects.length;i++){
            for(var j=i+1; j<objects.length; j++){
                if(objects[j] == objects[i]){
                    hold_objects[i] = objects[j];
                }
            }
        }
        if(hold_objects.length > 0){
            return true;
        }else{
            return false;
        }
    }

    //CHECK IF ARRAY ITEM IS EMPTY
    function arrayItemEmpty(objects){
        var hold_objects = [];
        for(var i=0; i<objects.length;i++){
                if(objects[i] == ''){
                    hold_objects[i] = objects[i];
                }
        }
        if(hold_objects.length > 0){
            return true;
        }else{
            return false;
        }
    }

    function sumClassToArray(getClass){
        var classArray = classToArray(getClass);
        return sumArrayItems(classArray);
    }

    function replaceInputWithClassArraySum(getClass, idElem){
        var sum = sumClassToArray(getClass);
        getId(idElem).val(sum);
    }

    function replaceElemWithClassArraySum(getClass, idElem){
        var sum = sumClassToArray(getClass);
        getId(idElem).html(sum);
    }

    function replaceClassInputWithVal(getclass, inputVal ){
        var objects = document.getElementsByClassName(getclass);
        for(var i=0; i<objects.length;i++){
                objects[i].value = inputVal;
        }        
    }

    //CATCH ALL DATA FROM INPUT WITH CSS CLASS
    function classToArray(getclass ){
        var objects = document.getElementsByClassName(getclass);
        var hold_objects = [];
        for(var i=0; i<objects.length;i++){
            if(objects[i].tagName === 'SELECT' || objects[i].tagName === 'INPUT'|| objects[i].tagName === 'TEXTAREA' )
            hold_objects[i] = objects[i].value;
        }
        return filter_array(hold_objects);
    }

    function classToArray2(getclass ){
        var objects = document.getElementsByClassName(getclass);
        var hold_objects = [];
        for(var i=0; i<objects.length;i++){
                hold_objects[i] = objects[i].value;
        }
        return filter_array(hold_objects);
    }

    function sanitizeData(data){
        var str = classToArray(data);
        var strJson = JSON.stringify(str);
        var newStr = encodeURIComponent(strJson);
        return newStr;
    }

    function sanitizeDataWithoutEncode(data){
        var str = classToArray(data);
        var strJson = JSON.stringify(str);
        return strJson;
    }

    function hideCheckedClassItems(getclass){

        var approve = document.getElementsByClassName(getclass);
        var values = [];
        var trId = '';
        for(var i=0; i < approve.length; i++){
            if(approve[i].checked){
                //approve[i].id.style.visibility = 'hidden';
                trId = 'tr_'+approve[i].id;
                //var itemId = document.getElementById(trId);
                //itemId.style.visibility = 'hidden';
                $('#'+trId).remove();
            }
        }

    }

    function hideCheckedClassItemsUnique(getclass){

        var approve = document.getElementsByClassName(getclass);
        var values = [];
        var trId = '';
        for(var i=0; i < approve.length; i++){
            if(approve[i].checked){
                //approve[i].id.style.visibility = 'hidden';
                trId = 'tr_'+approve[i].id;
                var itemId = document.getElementById(trId);
                //onsole.log(itemId);
                itemId.style.visibility = 'hidden';
            }
        }

    }

    function hideClassItems(getclass){
        var objects = document.getElementsByClassName(getclass);
        for(var i=0; i<objects.length;i++){
            objects[i].style.visibility = 'hidden';
        }
    }

    function hideAllClassItems(getclass){
        var objects = getclass.split(',');
        for(var i=0; i<objects.length;i++){
           hideClassItems(objects[i]);
        }
    }

    function clearClassInputs(getclass){
        var objects = getclass.split(',');
        for(var i=0; i<objects.length;i++){
            objects[i].value = '';

        }
    }

    function removeClassInputs(getclass){
        var objects = getclass.split(',');
        for(var i=0; i<objects.length;i++){

            $('.' + objects[i]).remove();

        }
    }

    //CATCH ALL SELECTED DATA FROM MUTIPLE SELECT OPTIONS LIST AND PUSH TO AN ARRAY
    function mselectToArray(getid ){
        var objects = document.getElementById(getid);
        var values = [];
        for (var i = 0; i < objects.options.length; i++) {
            if (objects.options[i].selected) {
                values.push(objects.options[i].value);
            }
        }
        return values;
    }

    function reloadContent(id,page){
        $('#'+id).html('Loading...');
        $.ajax({
            type:'POST',
            url: page,
            data: 'get=rough'+'&_token'+CSRF_TOKEN
        }).done(function(data){
            $('#'+id).html('');
            $('#'+id).html(data);
        });

    }

    function reloadContentId(id,page,dataId){

        $.ajax({
            type:'POST',
            url: page+'?dataId='+dataId+'&_token'+CSRF_TOKEN
        }).done(function(data){
            $('#'+id).html('');
            $('#'+id).html(data);
        });

    }

    function reloadContentWithInputs(id,page,formId){

        var inputVars = $('#'+formId).serialize();

        $.ajax({
            type:'POST',
            url: page+'?get=rough&'+inputVars+'&_token'+CSRF_TOKEN
        }).done(function(data){
            $('#'+id).html(data);
        });

    }

    function submitDefault(formModal,formId,submitUrl,reload_id,reloadUrl,token){
        var inputVars = $('#'+formId).serialize();
        
        var postVars = inputVars;
        $('#'+formModal).modal('hide');
        //DISPLAY LOADING ICON
        overlayBody('block');

        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                //HIDE LOADING ICON
                overlayBody('none');
               
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){
                    //RESET FORM
                    //resetForm(formId);
                   var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", "Data saved successfully!", "success");

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id,reloadUrl);
            }
        }

    }

    function submitDefaultNoFormModal(formId,submitUrl,reload_id,reloadUrl,token){

    var inputVars = $('#'+formId).serialize();
    var postVars = inputVars;
    $('#'+formModal).modal('hide');
    //DISPLAY LOADING ICON
    overlayBody('block');

    sendRequestForm(submitUrl,token,postVars);
    ajax.onreadystatechange = function(){
        if(ajax.readyState == 4 && ajax.status == 200) {

            //HIDE LOADING ICON
            overlayBody('none');
            var rollback = JSON.parse(ajax.responseText);
            var message2 = rollback.message2;
            if(message2 == 'fail'){

                //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                var serverError = phpValidationError(rollback.message);

                var messageError = swalFormError(serverError);
                swal("Error",messageError, "error");

            }else if(message2 == 'saved'){

                 //RESET FORM
                 //resetForm(formId);
                var successMessage = swalSuccess('Data saved successfully');
                swal("Success!", "Data saved successfully!", "success");

            }else if(message2 == 'token_mismatch'){

                location.reload();

            }else {
                var infoMessage = swalWarningError(message2);
                swal("Warning!", infoMessage, "warning");
            }

            //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
            reloadContent(reload_id,reloadUrl);
        }
    }

}

    //SUBMIT FORM WITH A FILE
    function submitMediaForm(formModal,formId,submitUrl,reload_id,reloadUrl,token){
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);
        var postVars = new FormData(form);
        postVars.append('token',token);

        $('#'+formModal).modal('hide');
       //DISPLAY LOADING ICON
        overlayBody('block');

        sendRequestMediaForm(submitUrl,token,postVars);
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                //HIDE LOADING ICON
                overlayBody('none');
                

                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){
                   
                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){
                    //RESET FORM
                    //resetForm(formId);
                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", successMessage, "success");

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id,reloadUrl);

            }
        }

    }

    //SUBMIT FORM WITH A FILE AND CLASS OF INPUTS, WITH TEXT EDITOR
    function submitMediaFormClass(formModal,formId,submitUrl,reload_id,reloadUrl,token,classList,ckInputId='undefined'){
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);
        
        var postVars = new FormData(form);
        postVars.append('token',token);
        appendClassToPost(classList,postVars);

        if(ckInputId != 'undefined'){
            var ckInput = encodeURIComponent(CKEDITOR.instances[ckInputId].getData());
            postVars.append('mail_message',ckInput);
        }

        $('#'+formModal).modal('hide');   
        //DISPLAY LOADING ICON
        overlayBody('block');
        
        sendRequestMediaForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                //HIDE LOADING ICON
                overlayBody('none');
                
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){

                    //RESET FORM
                    //resetForm(formId);
                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", successMessage, "success");
                    //location.reload();

                }else{

                    //alert(message2);
                    
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id,reloadUrl);
            }
            
        }

        $('#loading_modal').modal('hide');
        
    }

    function searchReport(formId,submitUrl,reload_id,reloadUrl,token){
        var inputVars = $('#'+formId).serialize();
        
        var postVars = inputVars;
        $('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                $('#loading_modal').modal('hide');
                var result = ajax.responseText;
                $('#'+reload_id).html(result);

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

            }
        }

    }

    //SUBMIT FORM TO REMOVE ATTACHED FILE FROM EDIT FORM
    function removeMediaForm(hideId,formId,submitUrl,reload_id,reloadUrl,token){
        var form_get = $('#'+formId);
        var form = document.forms.namedItem(formId);
        var postVars = new FormData(form);
        postVars.append('token',token);
        $('#loading_modal').modal('show');
        sendRequestMediaForm(submitUrl,token,postVars);
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalFormError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'saved'){

                    var successMessage = swalSuccess('Data saved successfully');
                    swal("Success!", successMessage, "success");
                    $('#'+hideId).remove();

                }else if(message2 == 'token_mismatch'){

                    location.reload();

                }else {
                    var infoMessage = swalWarningError(message2);
                    swal("Warning!", infoMessage, "warning");
                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reload_id,reloadUrl);
            }
        }

    }

    function fillNextInput(value_id,displayId,page,moduleType){
            var pickedVal = $('#'+value_id).val();

            $.ajax({
                url:  page+'?pickedVal='+pickedVal+'&type='+moduleType
            }).done(function(data){
                $('#'+displayId).html(data);
            });
    }

    function fillNextInputParamGetVal(value_id,displayId,page,moduleType,param){
        var pickedVal = $('#'+value_id).val();
        $.ajax({
            url:  page+'?pickedVal='+pickedVal+'&type='+moduleType+'&param='+param
        }).done(function(data){
            $('#'+displayId).html(data);
        });
    }

    function fillNextInputParamGetValId(value_id,displayId,page,moduleType,paramId){
        var pickedVal = $('#'+value_id).val();
        var param = $('#'+paramId).val();
        $.ajax({
            url:  page+'?pickedVal='+pickedVal+'&type='+moduleType+'&param='+param
        }).done(function(data){
            $('#'+displayId).html(data);
        });
    }

    function fillNextInputParam(value,displayId,page,moduleType,param){

        $.ajax({
            url:  page+'?pickedVal='+value+'&type='+moduleType+'&param='+param
        }).done(function(data){
            $('#'+displayId).html(data);
        });
    }

    function fillNextInputParam2(value,displayId,page,moduleType,param){

        $.ajax({
            url:  page+'?pickedVal='+value+'&type='+moduleType+'&param='+param
        }).done(function(data){
            $('#'+displayId).val(data);
        });
    }

    function fillNextInputParamId(valueId,displayId,page,moduleType,param,paramId){
        var pickedVal = $('#'+valueId).val();
        $.ajax({
            url:  page+'?pickedVal='+pickedVal+'&type='+moduleType+'&param='+param+'&paramId='+paramId
        }).done(function(data){
            $('#'+displayId).html(data);
        });
    }

    function searchOptionList(searchId,listId,page,moduleType,hiddenId){
        var pickedValGet = $('#'+searchId);
        var pickedVal = pickedValGet.val();
        var hiddenValGet = $('#'+hiddenId);
        if(pickedVal == ''){
            hiddenValGet.val('');
        }
        $('#'+listId).show();
        $.ajax({
            url:  page+'?pickedVal='+pickedVal+'&type='+moduleType+'&hiddenId='+hiddenId+'&listId='+listId+'&searchId='+searchId
        }).done(function(data){
            $('#'+listId).html(data);
        });
    }

    function searchOptionListParam(searchId,listId,page,moduleType,hiddenId,param){
        var pickedValGet = $('#'+searchId);
        var pickedVal = pickedValGet.val();
        var hiddenValGet = $('#'+hiddenId);
        if(pickedVal == ''){
            hiddenValGet.val('');
        }
        $('#'+listId).show();
        $.ajax({
            url:  page+'?pickedVal='+pickedVal+'&type='+moduleType+'&hiddenId='+hiddenId+'&listId='+listId+'&searchId='+searchId+'&param1='+param
        }).done(function(data){
            $('#'+listId).html(data);
        });
    }

    function searchOptionListParamCheck(searchId,listId,page,moduleType,hiddenId,param,newInputId,moduleType2,newInputPage){
        var pickedValGet = $('#'+searchId);
        var pickedVal = pickedValGet.val();
        var hiddenValGet = $('#'+hiddenId);
        if(pickedVal == ''){
            hiddenValGet.val('');
        }
        $('#'+listId).show();
        $.ajax({
            url:  page+'?pickedVal='+pickedVal+'&type='+moduleType+'&hiddenId='+hiddenId+'&listId='+listId+'&searchId='+searchId+'&param1='+param+'&newInputId='+newInputId+'&moduleType2='+moduleType2+'&newInputPage='+newInputPage
        }).done(function(data){
            $('#'+listId).html(data);
        });
    }

    function dropdownItem(valDisplayId,val,hiddenValId,hiddenVal,dropdownId) {
        $("#"+valDisplayId).val(val);
        $("#"+hiddenValId).val(hiddenVal);
        $("#"+dropdownId).hide();
    }

    function dropdownItemRep(valDisplayId,val,hiddenValId,hiddenVal,dropdownId,newDisplayId,moduleType,page) {
        $("#"+valDisplayId).val(val);
        $("#"+hiddenValId).val(hiddenVal);
        $("#"+dropdownId).hide();
        fillNextInput(hiddenValId,newDisplayId,page,moduleType)
    }

    function dropdownItemRepParam(valDisplayId,val,hiddenValId,hiddenVal,dropdownId,newDisplayId,moduleType,page,param) {
        $("#"+valDisplayId).val(val);
        $("#"+hiddenValId).val(hiddenVal);
        $("#"+dropdownId).hide();
        fillNextInputParam(hiddenVal,newDisplayId,page,moduleType,param)
    }

    function dropdownItemRepParam2(valDisplayId,val,hiddenValId,hiddenVal,dropdownId,newDisplayId,moduleType,page,param) {
        $("#"+valDisplayId).val(val);
        $("#"+hiddenValId).val(hiddenVal);
        $("#"+dropdownId).hide();
        fillNextInputParam2(hiddenVal,newDisplayId,page,moduleType,param)
    }

    function addMore(more_id,hide_button,num,page,type,hideButtonId){

        var hide_id = document.getElementById(hide_button);
        //alert(page+'?num='+num+'&type='+type+'&add_id='+addButtonId+'&hide_id='+hideButtonId);
        $.ajax({
            url:  page+'?num='+num+'&type='+type+'&add_id='+more_id+'&hide_id='+hideButtonId
        }).done(function(data){

            hide_id.style.display = 'none';
            $('#'+more_id).append(data);
        });
    }

    function addMoreEditable(more_id,hide_button,num,page,type,hideButtonId,editClassOrId){

        var hide_id = document.getElementById(hide_button);
        //alert(page+'?num='+num+'&type='+type+'&hide_id='+hideButtonId+'&editClassOrId='+editClassOrId);
        $.ajax({
            url:  page+'?num='+num+'&type='+type+'&add_id='+more_id+'&hide_id='+hideButtonId+'&editClassOrId='+editClassOrId
        }).done(function(data){

            hide_id.style.display = 'none';
            $('#'+more_id).append(data);
        });
    }

    function addMoreParam(more_id,hide_button,num,page,type,hideButtonId,param1){

        var hide_id = document.getElementById(hide_button);
        //alert(page+'?num='+num+'&type='+type+'&add_id='+addButtonId+'&hide_id='+hideButtonId);
        $.ajax({
            url:  page+'?num='+num+'&type='+type+'&add_id='+more_id+'&hide_id='+hideButtonId+'&param1='+param1
        }).done(function(data){

            hide_id.style.display = 'none';
            $('#'+more_id).append(data);
        });
    }

    function removeInput(show_id,ghost_class,addUrl,type,all_new_fields_class,unique_num,addButtonId,hideButtonId) {
        var get_class = document.getElementsByClassName(all_new_fields_class);
        //var currAddId = _('hide_button'+unique_num);
        //var prevNum = unique_num - 1;
        //var prevAddId = _('hide_button'+prevNum);
        var addButtons = document.getElementsByClassName('addButtons');
        if(addButtons.length < 1 ) {

            if (addButtons.length < 1) {
            prevAddId.style.display = 'block';
            }
        }
        $('.' + ghost_class).remove();
        /*for (var i = 0; i < get_class.length; i++) {
            //get_class[i].parentNode.removeChild(get_class[i]);
        }*/
        //var show_all = document.getElementById(show_id);
        var show_all = document.getElementById(hideButtonId);
        var show_button = '';

        show_button += '<tr><td></td><td></td><td></td><td>';
        show_button += '<div style="cursor: pointer;" onclick="addMore(';

        show_button += "'"+addButtonId+"','"+hideButtonId+"','1','" + addUrl + "','"+type+"','"+hideButtonId+"');";
        show_button += '">';
        show_button += '<i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i></div>';
        show_button += '</tr>';
        if (get_class.length === 0) {

        show_all.innerHTML =show_button;
        show_all.style.display = 'block';
        }
    }

    function removeInputEditable(show_id,ghost_class,addUrl,type,all_new_fields_class,unique_num,addButtonId,hideButtonId,editableClass) {
    var get_class = document.getElementsByClassName(all_new_fields_class);
    //var currAddId = _('hide_button'+unique_num);
    //var prevNum = unique_num - 1;
    //var prevAddId = _('hide_button'+prevNum);
    var addButtons = document.getElementsByClassName('addButtons');
    if(addButtons.length < 1 ) {

        if (addButtons.length < 1) {
            prevAddId.style.display = 'block';
        }
    }
    $('.' + ghost_class).remove();
    /*for (var i = 0; i < get_class.length; i++) {
     //get_class[i].parentNode.removeChild(get_class[i]);
     }*/
    //var show_all = document.getElementById(show_id);
    var show_all = document.getElementById(hideButtonId);
    var show_button = '';

    show_button += '<tr><td></td><td></td><td></td><td>';
    show_button += '<div style="cursor: pointer;" onclick="addMoreEditable(';

    show_button += "'"+addButtonId+"','"+hideButtonId+"','1','" + addUrl + "','"+type+"','"+hideButtonId+"','"+editableClass+"');";
    show_button += '">';
    show_button += '<i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i></div>';
    show_button += '</tr>';
    if (get_class.length === 0) {

        show_all.innerHTML =show_button;
        show_all.style.display = 'block';
    }
}

    function removeInputParam(show_id,ghost_class,addUrl,type,all_new_fields_class,unique_num,addButtonId,hideButtonId,param1) {
    var get_class = document.getElementsByClassName(all_new_fields_class);
    //var currAddId = _('hide_button'+unique_num);
    //var prevNum = unique_num - 1;
    //var prevAddId = _('hide_button'+prevNum);
    var addButtons = document.getElementsByClassName('addButtons');
    if(addButtons.length < 1 ) {

        if (addButtons.length < 1) {
            prevAddId.style.display = 'block';
        }
    }
    $('.' + ghost_class).remove();
    /*for (var i = 0; i < get_class.length; i++) {
     //get_class[i].parentNode.removeChild(get_class[i]);
     }*/
    //var show_all = document.getElementById(show_id);
    var show_all = document.getElementById(hideButtonId);
    var show_button = '';

    show_button += '<tr><td></td><td></td><td></td><td>';
    show_button += '<div style="cursor: pointer;" onclick="addMoreParam(';

    show_button += "'"+addButtonId+"','"+hideButtonId+"','1','" + addUrl + "','"+type+"','"+hideButtonId+"','"+param1+"');";
    show_button += '">';
    show_button += '<i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i></div>';
    show_button += '</tr>';
    if (get_class.length === 0) {

        show_all.innerHTML =show_button;
        show_all.style.display = 'block';
    }
}

    function hideAddedInputs(getclass,addButtonId,hideButtonId,addUrl,type,hideButtonId){
        var objects = document.getElementsByClassName(getclass);
        for(var i=0; i<objects.length;i++){
            objects[i].style.visibility = 'hidden';
            
        }
        var show_all = document.getElementById(addButtonId);
        var show_button = '';

        show_button += '<tr><td></td><td></td><td></td><td>';
        show_button += '<div style="cursor: pointer;" onclick="addMore(';

        show_button += "'"+addButtonId+"','"+hideButtonId+"','1','" + addUrl + "','"+type+"','"+hideButtonId+"');";
        show_button += '">';
        show_button += '<i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i></div>';
        show_button += '</tr>';

        show_all.innerHTML =show_button;
        show_all.style.display = 'block';

    }

    function hideAddedInputs2(getclass,addButtonId,hideButtonId,addUrl,type){
        var objects = document.getElementsByClassName(getclass);
        for(var i=0; i<objects.length;i++){
            objects[i].style.display = 'none';
            
        }
        var show_all = document.getElementById(hideButtonId);
        var show_button = '';

        show_button += '<tr><td></td><td></td><td></td><td>';
        show_button += '<div style="cursor: pointer;" onclick="addMore(';

        show_button += "'"+addButtonId+"','"+hideButtonId+"','1','" + addUrl + "','"+type+"','"+hideButtonId+"');";
        show_button += '">';
        show_button += '<i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i></div>';
        show_button += '</td></tr>';

        //show_all.innerHTML =show_button;
        show_all.style.display = 'block';

    }

    function deleteEntry(klass,reloadId,reloadUrl,submitUrl,token){
        var data_string = group_val(klass);
        var all_data = JSON.stringify(data_string);
        var postVars = "all_data="+all_data;
        $('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalDefaultError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'deleted'){

                    var successMessage = swalSuccess(rollback.message);
                    swal("Success!", successMessage, "success");

                }else{

                    var infoMessage = swalWarningError(message2);
                    swal("Success!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                if(reloadUrl != '') {
                    reloadContent(reloadId, reloadUrl);
                }
            }
        }


    }

    function deleteSingleEntry(dataHtmlId,reloadId,reloadUrl,submitUrl,token){
    var dataVal = $('#'+dataHtmlId).val();
    var postVars = "dataId="+dataVal;
    $('#loading_modal').modal('show');
    sendRequestForm(submitUrl,token,postVars)
    ajax.onreadystatechange = function(){
        if(ajax.readyState == 4 && ajax.status == 200) {
            $('#loading_modal').modal('hide');
            var rollback = JSON.parse(ajax.responseText);
            var message2 = rollback.message2;
            if(message2 == 'fail'){

                //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                var serverError = phpValidationError(rollback.message);

                var messageError = swalDefaultError(serverError);
                swal("Error",messageError, "error");

            }else if(message2 == 'deleted'){

                var successMessage = swalSuccess(rollback.message);
                swal("Success!", successMessage, "success");

            }else{

                var infoMessage = swalWarningError(message2);
                swal("Success!", infoMessage, "warning");

            }

            //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
            if(reloadUrl != '') {
                reloadContent(reloadId, reloadUrl);
            }
        }
    }


}

    function deleteSingleEntryWithParam(dataHtmlId,param,reloadId,reloadUrl,submitUrl,token){
    var dataVal = $('#'+dataHtmlId).val();
    var postVars = "dataId="+dataVal+"&param="+param;
    $('#loading_modal').modal('show');
    sendRequestForm(submitUrl,token,postVars)
    ajax.onreadystatechange = function(){
        if(ajax.readyState == 4 && ajax.status == 200) {
            $('#loading_modal').modal('hide');
            var rollback = JSON.parse(ajax.responseText);
            var message2 = rollback.message2;
            if(message2 == 'fail'){

                //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                var serverError = phpValidationError(rollback.message);

                var messageError = swalDefaultError(serverError);
                swal("Error",messageError, "error");

            }else if(message2 == 'deleted'){

                var successMessage = swalSuccess(rollback.message);
                swal("Success!", successMessage, "success");

            }else{

                var infoMessage = swalWarningError(message2);
                swal("Success!", infoMessage, "warning");

            }

            //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
            if(reloadUrl != '') {
                reloadContent(reloadId, reloadUrl);
            }
        }
    }


}

    function deleteEntryFetchId(klass,reloadId,reloadUrl,submitUrl,token,dataId){
        var data_string = group_val(klass);
        var all_data = JSON.stringify(data_string);
        var postVars = "all_data="+all_data;
        $('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalDefaultError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'deleted'){

                    var successMessage = swalSuccess(rollback.message);
                    swal("Success!", successMessage, "success");

                }else{

                    var infoMessage = swalWarningError(message2);
                    swal("Success!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContentId(reloadId,reloadUrl,dataId);
            }
        }


    }

    function changeStatusMethod(klass,reloadId,reloadUrl,submitUrl,token,status){
        var data_string = group_val(klass);
        var all_data = JSON.stringify(data_string);
        var postVars = "all_data="+all_data+"&status="+status;

        $('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalDefaultError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'deleted'){

                    var successMessage = swalSuccess(rollback.message);
                    swal("Success!", successMessage, "success");

                }else{

                    var infoMessage = swalWarningError(message2);
                    swal("Success!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reloadId,reloadUrl);
            }
        }


    }

    function changeStatusMethodParam(klass,reloadId,reloadUrl,submitUrl,token,status,paramId,modalId){
        var param = $('#'+paramId).val();
        var data_string = group_val(klass);
        var all_data = JSON.stringify(data_string);
        var postVars = "all_data="+all_data+"&status="+status+"&param="+param;
       
        $('#'+modalId).modal('hide');
        $('#'+modalId).on('hidden.bs.modal', function () {
            $('#loading_modal').modal('show');
        });
        
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalDefaultError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'deleted'){

                    var successMessage = swalSuccess(rollback.message);
                    swal("Success!", successMessage, "success");

                }else{

                    var infoMessage = swalWarningError(message2);
                    swal("Success!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reloadId,reloadUrl);
            }
        }


    }

    function changeStatusMethodForm(klass,reloadId,reloadUrl,submitUrl,token,status,formId){
        var inputVars = $('#'+formId).serialize();
        var data_string = group_val(klass);
        var all_data = JSON.stringify(data_string);
        var postVars = inputVars+"&all_data="+all_data+"&status="+status;
        //alert(postVars);
        $('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
               
                $('#loading_modal').modal('hide');

                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalDefaultError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'deleted' || message2 == 'saved'){

                    var successMessage = swalSuccess(rollback.message);
                    swal("Success!", successMessage, "success");

                }else{

                    var infoMessage = swalWarningError(message2);
                    swal("Success!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reloadId,reloadUrl);
            }
        }


    }

    function changeStatusMethodInput(klass,reloadId,reloadUrl,submitUrl,token,status,input){
        var data_string = group_val(klass);
        var all_data = JSON.stringify(data_string);
        var postVars = "all_data="+all_data+"&status="+status+"&input_text="+input;
        $('#loading_modal').modal('show');
        sendRequestForm(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                $('#loading_modal').modal('hide');
                var rollback = JSON.parse(ajax.responseText);
                var message2 = rollback.message2;
                if(message2 == 'fail'){

                    //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                    var serverError = phpValidationError(rollback.message);

                    var messageError = swalDefaultError(serverError);
                    swal("Error",messageError, "error");

                }else if(message2 == 'deleted'){

                    var successMessage = swalSuccess(rollback.message);
                    swal("Success!", successMessage, "success");

                }else{

                    var infoMessage = swalWarningError(message2);
                    swal("Success!", infoMessage, "warning");

                }

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
                reloadContent(reloadId,reloadUrl);
            }
        }


    }

    function restoreDeletedItems(klass,reloadId,reloadUrl,submitUrl,token) {
    var items = group_val(klass);
    if (items.length > 0){
        swal({
                title: "Are you sure you want to restore?",
                text: "This will move this entry to its original location!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, restore it!",
                cancelButtonText: "No, cancel restore!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    deleteEntry(klass, reloadId, reloadUrl, submitUrl, token);
                    //swal("Deleted!", "Your item(s) has been deleted.", "success");
                } else {
                    swal("Restore Cancelled", "Your data was not restored :)", "error");
                }
            });

    }else{
        alert('Please select an entry to continue');
    }

}

    function deleteItems(klass,reloadId,reloadUrl,submitUrl,token) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to delete?",
                    text: "You will not be able to recover this data entry!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel delete!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        deleteEntry(klass, reloadId, reloadUrl, submitUrl, token);
                        //swal("Deleted!", "Your item(s) has been deleted.", "success");
                    } else {
                        swal("Delete Cancelled", "Your data is safe :)", "error");
                    }
                });

            }else{
                alert('Please select an entry to continue');
        }

    }

    function deleteSingleItem(dataHtmlId,reloadId,reloadUrl,submitUrl,token) {

        swal({
                title: "Are you sure you want to delete?",
                text: "You will not be able to recover this data entry!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel delete!",
                closeOnConfirm: true,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    deleteSingleEntry(dataHtmlId, reloadId, reloadUrl, submitUrl, token);
                    //swal("Deleted!", "Your item(s) has been deleted.", "success");
                } else {
                    swal("Delete Cancelled", "Your data is safe :)", "error");
                }
            });

    }

    function deleteSingleItemWithParam(dataHtmlId,param,reloadId,reloadUrl,submitUrl,token,divDataIdOnModalForRemoval) {

        swal({
                title: "Are you sure you want to delete?",
                text: "You will not be able to recover this data entry!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel delete!",
                closeOnConfirm: true,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    deleteSingleEntryWithParam(dataHtmlId, param, reloadId, reloadUrl, submitUrl, token);

                    if(divDataIdOnModalForRemoval != ''){
                        $('#'+divDataIdOnModalForRemoval).remove();
                    }
                    //swal("Deleted!", "Your item(s) has been deleted.", "success");
                } else {
                    swal("Delete Cancelled", "Your data is safe :)", "error");
                }
            });

    }

    function deleteItemsRemove(klass,reloadId,reloadUrl,submitUrl,token) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to delete?",
                    text: "You will not be able to recover this data entry!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel delete!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        deleteEntry(klass, reloadId, reloadUrl, submitUrl, token);
                        hideCheckedClassItems(klass);
                        //swal("Deleted!", "Your item(s) has been deleted.", "success");
                    } else {
                        swal("Delete Cancelled", "Your data is safe :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function deleteItemsFetchId(klass,reloadId,reloadUrl,submitUrl,token,dataId) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to delete?",
                    text: "You will not be able to recover this data entry!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel delete!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        deleteEntryFetchId(klass, reloadId, reloadUrl, submitUrl, token,dataId);
                        swal("Deleted!", "Your item(s) has been deleted.", "success");
                    } else {
                        swal("Delete Cancelled", "Your data is safe :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function changeStatus(klass,reloadId,reloadUrl,submitUrl,token,status) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to change status ?",
                    text: "This will enable/disable a user from login!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                        swal("Success!", "Status of selected item(s) have been changed.", "success");
                    } else {
                        swal("Status change Cancelled", "Status remains the same :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function warehousePost(klass,reloadId,reloadUrl,submitUrl,token,status,category) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to "+category+" ?",
                    text: "This will permanently "+category+"!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: true,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                        //swal("Processed!", "process complete.", "success");
                    } else {
                        swal(" Cancelled", category, "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function dynamicStatusEffect(klass,reloadId,reloadUrl,submitUrl,token,status,category) {
    var items = group_val(klass);
    if (items.length > 0){
        swal({
                title: "Are you sure you want to "+category+" ?",
                text: "This will permanently "+category+"!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, continue!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: true,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                    //swal("Processed!", "process complete.", "success");
                } else {
                    swal(" Cancelled", category, "error");
                }
            });

    }else{
        alert('Please select an entry to continue');
    }

}

    function changeItemStatus(klass,reloadId,reloadUrl,submitUrl,token,status) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to change status ?",
                    text: "This will enable/disable item!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                        swal("Changed!", "Status of selected item(s) have been changed.", "success");
                    } else {
                        swal("Status change Cancelled", "Status remains the same :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }



    function changeCurrencyStatus(klass,reloadId,reloadUrl,submitUrl,token,status) {
            var items = group_val(klass);
            if (items.length > 0){
                swal({
                        title: "Are you sure you want to change status ?",
                        text: "This will enable selected currency active!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, change it!",
                        cancelButtonText: "No, cancel change!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                            swal("Deleted!", "Status of selected item(s) have been changed.", "success");
                        } else {
                            swal("Status change Cancelled", "Status remains the same :)", "error");
                        }
                    });

            }else{
                alert('Please select an entry to continue');
            }

        }

    function changeDataStatus(klass,reloadId,reloadUrl,submitUrl,token,status) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to change status ?",
                    text: "This will enable selected data active!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                        swal("Changed!", "Status of selected item(s) have been changed.", "success");
                    } else {
                        swal("Status change Cancelled", "Status remains the same :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function timesheetApproval(klass,reloadId,reloadUrl,submitUrl,token,status) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to continue ?",
                    text: "This will change the status of the selected item(s)!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                        swal("Completed!", "Status of selected item(s) have been changed.", "success");
                        //$('#search_user_timesheet_btn').trigger('click');
                    } else {
                        swal("Status change Cancelled", "Status remains the same :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function removeAddItem(klass,reloadId,reloadUrl,submitUrl,token,status,category,paramId,modalId) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to "+category+" ?",
                    text: "This will "+category+"!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, "+category+"!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: true,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {

                        changeStatusMethodParam(klass, reloadId, reloadUrl, submitUrl, token,status,paramId,modalId);

                        swal("Complete!", "modification complete.", "success");
                    } else {
                        swal(" Cancelled", "Modification cancelled", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function changeAppraisalStatus(klass,reloadId,reloadUrl,submitUrl,token,status) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to change status ?",
                    text: "This will change appraisal status from ongoing to complete!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                        swal("Changed!", "Status of selected item(s) have been changed.", "success");
                    } else {
                        swal("Status change Cancelled", "Status remains the same :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function processPayroll(klass,reloadId,reloadUrl,submitUrl,token,status,formId) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "Are you sure you want to change status ?",
                    text: "This will change status of selected data!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethodForm(klass, reloadId, reloadUrl, submitUrl, token,status,formId);
                        swal("Changed!", "Status of selected item(s) have been changed.", "success");
                    } else {
                        swal("Status change Cancelled", "Status remains the same :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function approveFinanceRequest(klass,reloadId,reloadUrl,submitUrl,token,status) {
        var items = group_val(klass);
        if (items.length > 0){
            swal({
                    title: "You are about to complete these request(s) ?",
                    text: "Do you with to continue!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token,status);
                        swal("Processed!", "Request(s) have been processed.", "success");
                    } else {
                        swal("Cancelled", "Request processing Cancelled :)", "error");
                    }
                });

        }else{
            alert('Please select an entry to continue');
        }

    }

    function editForm(dataId,displayId,submitUrl,token){

        var postVars = "dataId="+dataId;
        $('#editModal').modal('show');
        sendRequest(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                var ajaxData = ajax.responseText;
                $('#'+displayId).html(ajaxData);

            }
        }
        $('#'+displayId).html('LOADING DATA');

    }

    function convertForm(dataId,displayId,submitUrl,token,modalId,hideContent){
        var dataVal = $('#'+dataId).val();
        if(dataVal != ''){
            $('#edit_content').html('');
            if(hideContent != ''){
                $('#'+hideContent).html('');
            }
            var postVars = "dataId="+dataVal;
            $('#'+modalId).modal('show');
            sendRequest(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {

                    var ajaxData = ajax.responseText;
                    $('#'+displayId).html(ajaxData);

                }
            }
            $('#'+displayId).html('LOADING DATA');

        }else{
            swal("Warning!", "Ensure to select an item from the dropdown.", "warning");
        }


    }

    function editTransactForm(dataId,displayId,submitUrl,token,currencyClass,vendorCustCurrPage,vendorId,billAddress,currRate,formContent1,formContent2){

        var postVars = "dataId="+dataId;

        if(formContent1 != ''){
            $('#'+formContent1).html('');
        }
        if(formContent2 != ''){
            $('#'+formContent2).html('');
        }
        $('#editModal').modal('show');
        sendRequest(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                var ajaxData = ajax.responseText;
                $('#'+displayId).html(ajaxData);
                fetchVendCustCurr(vendorId,currencyClass,vendorCustCurrPage,billAddress,currRate)

            }
        }
        //$('#'+displayId).html('LOADING DATA');

    }

    function appendClassToPost(classList,PostVar){
        for(var i=0; i<classList.length;i++){
            var classValue = sanitizeData(classList[i]);
            PostVar.append(classList[i],classValue);
        }
    }

    function fetchModal(dataId,requestId,modalId){

        $('#'+modalId).modal('show');

        $('#'+requestId).val(dataId);

    }

    function fetchHtml(dataId,displayId,modalId,submitUrl,token){

        var postVars = "dataId="+dataId;
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

    function fetchHtml2(dataId,displayId,modalId,submitUrl,token,type){

        var postVars = "dataId="+dataId+"&type="+type;
        
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

    function fetchHtml3(dataId,dataId2,displayId,modalId,submitUrl,token,type){

        var postVars = "dataId="+dataId+"&dataId2="+dataId2+"&type="+type;
        $('#'+modalId).modal('show');
        sendRequest(submitUrl,token,postVars);
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                var ajaxData = ajax.responseText;
                $('#'+displayId).html(ajaxData);

            }
        }
        $('#'+displayId).html('LOADING DATA');

    }

    function fetchHtml4(dataId,displayId,modalId,submitUrl,token,param1,param2){

        var postVars = "dataId="+dataId+"&param1="+param1+"&param2="+param2;
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

    function fetchMultipleData(klass,displayId,modalId,submitUrl,token){

        var data_array = group_val(klass);
        if(data_array.length > 0){
        var all_data = JSON.stringify(data_array);
        var postVars = "all_data="+all_data;
        $('#'+modalId).modal('show');
        sendRequest(submitUrl,token,postVars)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                var ajaxData = ajax.responseText;
                $('#'+displayId).html(ajaxData);

            }
        }
        $('#'+displayId).html('LOADING DATA');

        }else{
            alert('Please select an entry to continue');
        }

    }

    function navigatePage(pageUrl){
        window.location.replace(pageUrl);
    }

    function changeUserT(normal_user1,temp_user1,change_user1,input_id,temp_input_id){
        var changeUserT = $('#'+change_user1);
        var normalUser = $('#'+normal_user1);
        var tempUser = $('#'+temp_user1);
        var inputId = $('#'+input_id);
        var tempInputId = $('#'+temp_input_id);

        if(changeUserT.val() == '1'){

            changeUserT.val('2');
            inputId.removeClass( "user_class" );
            inputId.prop("disabled",true);
            normalUser.css("display", "none");

            tempUser.css("display", "block");
            tempInputId.addClass( "user_class" );
            tempInputId.prop("disabled",false);

        }else{

            changeUserT.val('1');
            tempInputId.removeClass( "user_class" );
            tempInputId.prop("disabled",true);
            tempUser.css("display", "none");

            normalUser.css("display", "block");
            inputId.addClass( "user_class" );
            inputId.prop("disabled",false);

        }

    }

    function swithInputs(normal_user1,temp_user1,change_user1){
        var changeUserT = $('#'+change_user1);
        var normalUser = $('#'+normal_user1);
        var tempUser = $('#'+temp_user1);

        if(changeUserT.val() == '1'){

            changeUserT.val('2');
            normalUser.css("display", "none");

            tempUser.css("display", "block");
        }else{

            changeUserT.val('1');
            tempUser.css("display", "none");
            normalUser.css("display", "block");

        }

    }

    function searchItem(inputId,displayId,submitUrl,defaultUrl,token){

        var searchInput = $('#'+inputId).val();
        var postVars = "?searchVar="+searchInput;
        //alert(postVars);
        if(searchInput != '') {
            $.ajax({
                url: submitUrl + postVars
            }).done(function (data) {
                $('#' + displayId).html(data);
            });
            $('#' + displayId).html('LOADING DATA');
        }else{
            reloadContent('reload_data',defaultUrl)
        }

    }

    function searchItem2(inputId,displayId,submitUrl,defaultUrl,token){

        var searchInput = $('#'+inputId).val();
        var postVars = "?searchVar="+searchInput;
        //alert(postVars);
            $.ajax({
                url: submitUrl + postVars
            }).done(function (data) {
                $('#' + displayId).html(data);
            });
            $('#' + displayId).html('LOADING DATA');       

    }


    function searchItemParam(inputId,displayId,submitUrl,defaultUrl,token,paramId){

        var searchInput = $('#'+inputId).val();
        var param = $('#'+paramId).val();
        var postVars = "?searchVar="+searchInput+"&param="+param;
        //alert(postVars);
        if(searchInput != '') {
            $.ajax({
                url: submitUrl + postVars
            }).done(function (data) {
                $('#' + displayId).html(data);
            });
            $('#' + displayId).html('LOADING DATA');
        }else{
            reloadContent('reload_data',defaultUrl)
        }

    }

    function searchUsingDate(formId,submitUrl,reload_id,reloadUrl,token,fromId,toId){

        var from = $('#'+fromId).val();
        var to = $('#'+toId).val();

        var inputVars = $('#'+formId).serialize();
        //alert(inputVars);
        if(from != '' && to !=''){
            
            var postVars = inputVars;
            $('#loading_modal').modal('show');
            sendRequestForm(submitUrl,token,postVars)
            ajax.onreadystatechange = function(){
                if(ajax.readyState == 4 && ajax.status == 200) {

                    $('#loading_modal').modal('hide');
                    var result = ajax.responseText;
                    $('#'+reload_id).html(result);

                    //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

                }
            }

        }else{
            swal("warning!", "Please ensure to select from, to date.", "warning");

        }

    }


    function print_content(el){
            var restorepage = document.body.innerHTML;

            var printcontent = document.getElementById(el).outerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            window.close();
            document.body.innerHTML = restorepage;
            location.reload();
        }

    function print_table(divdata)
    {
        var divToPrint=document.getElementById(divdata);
        newWin= window.open("");

        newWin.document.write(divToPrint.outerHTML);
        newWin.print();
        newWin.close();
    }

    $(function() {
        $( ".datepickers" ).datepicker({
            changeMonth: true,
            changeYear: true
        });
    });

    // $(document).ready(function() {
    //     $('.summernote').summernote();
    // });

    var db, isfullscreen = false;
    function toggleFullScreen(){
        db = document.body;
        if(isfullscreen == false){
            if(db.requestFullScreen){
                db.requestFullScreen();
            } else if(db.webkitRequestFullscreen){
                db.webkitRequestFullscreen();
            } else if(db.mozRequestFullScreen){
                db.mozRequestFullScreen();
            } else if(db.msRequestFullscreen){
                db.msRequestFullscreen();
            }
            isfullscreen = true;
            //wrap.style.width = window.screen.width+"px";
            //wrap.style.height = window.screen.height+"px";
        } else {
            if(document.cancelFullScreen){
                document.cancelFullScreen();
            } else if(document.exitFullScreen){
                document.exitFullScreen();
            } else if(document.mozCancelFullScreen){
                document.mozCancelFullScreen();
            } else if(document.webkitCancelFullScreen){
                document.webkitCancelFullScreen();
            } else if(document.msExitFullscreen){
                document.msExitFullscreen();
            }
            isfullscreen = false;
            wrap.style.width = "100%";
            //wrap.style.height = "auto";
            //wrap.style.overflow = "scroll";
        }
    }

    function getCurrency(page,token){

        setInterval(function(){
            $.ajax({
                url: 'http://www.apilayer.net/api/live?access_key=57d1e605533a2efddb58968de322110c'
            }).done(function(data){
                var jsonString = JSON.stringify(data);
                postCurrency(page,jsonString,token);
            });
        },3600000)

    }

    function postCurrency(page,jsonCurrency,token){
        var postVars = 'currency='+jsonCurrency;
        sendRequestForm(page,token,postVars);
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {
                var result = ajax.responseText;
                //alert(result);
                }
            }
    }

    function RequestApproval(klass,reloadId,reloadUrl,submitUrl,token,status) {
        var items = group_val(klass);
        if (items.length > 0) {
            if(status == 1){
            swal({
                    title: "Are you sure you want to approve this request(s) ?",
                    text: "You won't be able to deny after approval!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token, status);
                        swal("Approved!", "Selected request(s) have been approved.", "success");
                    } else {
                        swal("Approval Cancelled", "Requests remains unchanged :)", "error");
                    }
                });
            } else{ //END OF IF STATUS IS FOR APPROVAL AND NOT DENIAL

                swal({
                        title: "Are you sure you want to deny this request(s) ?",
                        text: "Reason for denial!",
                        type: "input",
                        inputPlaceholder: "Reason for denial",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, change it!",
                        cancelButtonText: "No, cancel!",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    },
                    function (denyReason) {
                        if (denyReason === false) return false;
                            if (denyReason  != '') {
                            changeStatusMethodInput(klass, reloadId, reloadUrl, submitUrl, token, status, denyReason);
                            swal("Denied!", "Selected request(s) have been denied.", "success");
                        } else {
                            swal.showInputError("Please enter reason for denial");
                                return false
                        }
                    });

            }  //END OF IF STATUS IS FOR DENIAL AND NOT APPROVAL

        }else{
            alert('Please select an entry to continue');
        }

    }

    function statusChangeWithReason(klass,reloadId,reloadUrl,submitUrl,token,status) {
    var items = group_val(klass);
    if (items.length > 0) {
        if(status == 3){

            swal({
                    title: "Are you sure you want to continue ?",
                    text: "State reason!",
                    type: "input",
                    inputPlaceholder: "State your reason",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function (denyReason) {
                    if (denyReason === false) return false;
                    if (denyReason  != '') {
                        changeStatusMethodInput(klass, reloadId, reloadUrl, submitUrl, token, status, denyReason);
                        swal("Changed!", "Selected data have been changed.", "success");
                    } else {
                        swal.showInputError("Please enter reason");
                        return false
                    }
                });
        } else{ //END OF IF STATUS IS FOR REJECTION AND NOT ACCEPTANCE

            swal({
                    title: "Are you sure you want to continue ?",
                    text: "You won't be able to revert changes!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token, status);
                        swal("Changed!", "Selected data have been changed.", "success");
                    } else {
                        swal("Change Cancelled", "Data remains unchanged :)", "error");
                    }
                });

        }  //END OF IF STATUS IS FOR ACCEPTANCE

    }else{
        alert('Please select an entry to continue');
    }

}

    function deleteChartAccount(klass,reloadId,reloadUrl,submitUrl,token,status) {
    var items = group_val(klass);
    if (items.length > 0) {
        if(status == 1){
            swal({
                    title: "Are you sure you want to delete this account(s) ?",
                    text: "You won't be able to retrieve after approval!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel change!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        changeStatusMethod(klass, reloadId, reloadUrl, submitUrl, token, status);
                        swal("Deleted!", "Selected account(s) have been deleted.", "success");
                    } else {
                        swal("Delete Cancelled", "Account remains unchanged :)", "error");
                    }
                });
        } else{ //END OF IF STATUS IS FOR APPROVAL AND NOT DENIAL

            swal({
                    title: "PLEASE IGNORE PASSWORD IF ACCOUNTS LAST TRANSACTION DATE IS AFTER THAT OF THE CLOSING BOOKS",
                    text: "Password (Enter Password)",
                    type: "input",
                    inputPlaceholder: "Enter Password",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, remove!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function (denyReason) {
                    if (denyReason === false) return false;
                    if (denyReason  != '') {
                        changeStatusMethodInput(klass, reloadId, reloadUrl, submitUrl, token, status, denyReason);
                        swal("Deleted!", "Selected account(s) have been deleted.", "success");
                    } else {
                        changeStatusMethodInput(klass, reloadId, reloadUrl, submitUrl, token, status, denyReason);
                        swal("Deleted!", "Selected account(s) have been deleted.", "success");
                    }
                });

            }  //END OF IF STATUS IS FOR DENIAL AND NOT APPROVAL

        }else{
            alert('Please select an entry to continue');
        }

    }

    function sumArrayItems(input){

        if (toString.call(input) !== "[object Array]")
            return false;

        var total =  0;
        for(var i=0;i<input.length;i++)
        {
            if(isNaN(input[i])){
                continue;
            }
            total += Number(input[i]);
        }
        return decPoints(total,2);
    }

    function decPoints(param,decP){
        return parseFloat(param).toFixed(decP);
    }


    function permDelete(bomId,page,bomIdVal){
            var bomVal = $('#'+bomIdVal).val();
                $.ajax({
                    url: page+'?dataId='+bomVal
                }).done(function(data){
                    $('#'+bomId).remove();
                    swal("Warning!", 'Item removed successfully', "success");

                });


        }

    function permDeleteData(bomId,page,dataVal){

        $.ajax({
            url: page+'?dataId='+dataVal
        }).done(function(data){
            $('#'+bomId).remove();
            swal("Warning!", 'Item removed successfully', "success");

        });


    }

        //////////////////////////// ITEM AND ACCOUNT METHODS INVOLVED IN CALCULATION OF VARIOUS INPUT AMOUNT FIELDS ////////////////

//SHOW EXCHANGE RATE EQUIVALENT TO DEFAULT CURRENCY AT A PARTICULAR DATE
    function exchangeRate(vendorId,exRateId,postDateId,page){

        setInterval(function(){
            var vendorVal = $('#'+vendorId).val();
            var postDate = $('#'+postDateId).val();
            //alert(vendorVal);
            if(vendorVal != ''){
                $.ajax({
                    url: page+'?post_date=' + postDate+'&search_id='+vendorVal
                }).done(function(data){
                    $('#'+exRateId).val(data.rate);
                });
            }
        },2000)

    }

    function exclTax(totalAmtId,totalTaxId,exclTaxId){
        var totalAmt = $('#'+totalAmtId);
        var totalTax = $('#'+totalTaxId);
        var taxVal = (totalTax.val() == '') ? 0.00 : totalTax.val();
        var newAmt = parseFloat(totalAmt.val())-parseFloat(taxVal);
        
        $('#'+exclTaxId).val(decPoints(newAmt,2));
    }
   
    function emptyOneTimeTaxDiscount(totalAmtId){
        var perctId = (totalAmtId.search('edit') > 0) ? 'total_tax_perct_edit' : 'total_tax_perct';
        var discountPerctId = (totalAmtId.search('edit') > 0) ? 'total_discount_perct_edit' : 'total_discount_perct';
        var taxPerct =  $('#'+perctId);
        var discountPerct =  $('#'+discountPerctId);
        taxPerct.val(''); 
        discountPerct.val('');      
    }
    
    function sharedTaxAmount(totalAmtId){
        var taxSharedClass = (totalAmtId.search('edit') > 0) ? 'shared_tax_amount_edit' : 'shared_tax_amount';
        var sumArrayTax = classToArray2(taxSharedClass);
        var sumArrayAmount = sumArrayItems(sumArrayTax);
        return sumArrayAmount;        
    }

    function sharedSubTotal(totalAmtId){
        var subTotalClass = (totalAmtId.search('edit') > 0) ? 'shared_sub_total_edit' : 'shared_sub_total';
        var sumArrayTotal = classToArray2(subTotalClass);
        var sumArrayAmount = sumArrayItems(sumArrayTotal);
        return sumArrayAmount;        
    }

    //END FOR CALCULATING ONE TIME TAX AND DISCOUNT

    function searchOptionListAcc(searchId,listId,page,moduleType,hiddenId,vendCustId,postDateId){
        var pickedVal = $('#'+searchId).val();
        var vendCustVal = $('#'+vendCustId).val();
        var postDate = $('#'+postDateId).val();
        if(vendCustVal != '' && postDate != ''){

            $('#'+listId).show();
            $.ajax({
                url:  page+'?pickedVal='+pickedVal+'&type='+moduleType+'&hiddenId='+hiddenId+'&listId='+listId+'&searchId='+searchId
            }).done(function(data){
                $('#'+listId).html(data);
            });

        }else{
            swal("Warning!", 'Please Select Vendor/Customer and posting date to continue', "warning");
        }

    }

    function searchOptionListVenCust(searchId,listId,page,moduleType,hiddenId,currencyClass,currPage,overallSumId,contactType,vendCustId,postDateId,billAddress,currRate,foreignOverallSum){
        var pickedVal = $('#'+searchId).val();
        $('#'+listId).show();
        $.ajax({
            url:  page+'?pickedVal='+pickedVal+'&type='+moduleType+'&hiddenId='+hiddenId+'&listId='+listId+'&searchId='+searchId+'&overallSumId='+overallSumId+'&contactType='+contactType+'&currencyClass='+currencyClass+'&vendCustId='+vendCustId+'&postDateId='+postDateId+'&billAddress='+billAddress+'&currRate='+currRate+'&foreignOverallSum='+foreignOverallSum
        }).done(function(data){
            $('#'+listId).html(data);
        });
    }

    function searchOptionListInventory(searchId,listId,page,moduleType,hiddenId,descId,rateId,unitMId,subTotalId,sharedSumClass,overallSumId,foreignCurrId,qtyId,vendCustId,postDateId,totalTaxId,billInvoice){
        var pickedVal = $('#'+searchId).val();
        $('#'+listId).show();
        var vendCustVal = $('#'+vendCustId).val();
        var postDate = $('#'+postDateId).val();
        if(vendCustVal != '' && postDate != ''){
        $.ajax({
            url:  page+'?pickedVal='+pickedVal+'&type='+moduleType+'&hiddenId='+hiddenId+'&listId='+listId+'&searchId='+searchId+'&descId='+descId+'&rateId='+rateId+'&unitMId='+unitMId+'&subTotalId='+subTotalId+'&sharedSubTotal='+sharedSumClass+'&overallSum='+overallSumId+'&foreignOverallSum='+foreignCurrId+'&qtyId='+qtyId+'&vendCustId='+vendCustId+'&postDateId='+postDateId+'&totalTaxId='+totalTaxId+'&billInvoice='+billInvoice
        }).done(function(data){
            $('#'+listId).html(data);

        });

        }else{
            swal("Warning!", 'Please Select Vendor/Customer and posting date to continue', "warning");
        }
    }

    function fetchVendCustCurr(searchId,currencyClass,page,billAddress,currRate) {
        var pickedVal = $('#'+searchId).val();
        $.ajax({
            url:  page+'?search_id='+pickedVal
        }).done(function(data){
            var all = document.getElementsByClassName(currencyClass);
            for(var i=0; i < all.length; i++){
                var column = all[i];
                column.innerHTML = data.currency;
            }
            $('#'+billAddress).val(data.billing_address);
            $('#'+currRate).val(data.rate);
            

        });

    }

    function fetchInventory(searchId,bill_invoice,page,descId,rateId,unitMId,subTotalId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,qtyId,vendorCustId,postDateId,totalTaxId) {
        var pickedVal = $('#'+searchId).val();


            $.ajax({
                url:  page+'?search_id='+pickedVal+'&bill_invoice_type='+bill_invoice
            }).done(function(data){

                $('#'+descId).val(data.item_desc);
                $('#'+rateId).val(decPoints(data.rate,2));
                $('#'+unitMId).val(data.unit_measure);
                $('#'+subTotalId).val(decPoints(data.rate,2));
                $('#'+qtyId).val('1');

                emptyOneTimeTaxDiscount(overallSumId);
                var sumArrayTax = sharedTaxAmount(overallSumId);
                $('#'+totalTaxId).val(sumArrayTax); 

                var sumToArray = classToArray2(sharedSumClass);
                var sumArray = sumArrayItems(sumToArray);

                $('#'+overallSumId).val(decPoints(sumArray,2));
                exclTax(overallSumId,totalTaxId,'excl_'+overallSumId);

                convertToDefaultCurr(foreignCurrId,overallSumId,defaultCurrPage,vendorCustId,postDateId)

            });

    }

    function getItemRate(itemId,page,qtyId,rateId){
        var pickedVal = $('#'+itemId).val();
        var qtyVal = $('#'+qtyId).val();
        var rate = $('#'+rateId);
        if(pickedVal != ''){
            $.ajax({
                url:  page+'?itemId='+pickedVal
            }).done(function(data){
                var result = data.rate;
                rate.val(decPoints(result*qtyVal,2));
            });
        }
    }

    //ON SELECTION OF AN ITEM FOR TRANSACTION
    function itemSum(amountId,rateId,itemId,qtyId,discountAmountId,taxAmountId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,ratePage,taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId,taxPerctId,discountPerctId){

        emptyOneTimeTaxDiscount(overallSumId);
        
        if(event.target.id == qtyId){

            //BEGINING
            var pickedVal = $('#'+itemId).val();


            if(pickedVal != ''){
                $.ajax({
                    url:  ratePage+'?itemId='+pickedVal
                }).done(function(data){
                    var result = data.rate;
                    var qty = $('#'+qtyId);
                    var qtyVal = qty.val();
                    var rateGet = $('#'+rateId);

                    //rateGet.val(result*qtyVal);

                    var amount = $('#'+amountId);
                    //var rate = data.rate;
                    var rate = rateGet.val();

                    var item = $('#'+itemId).val();
                    var discount = $('#'+discountAmountId);
                    var tax = $('#'+taxAmountId);
                    var discountPerct = $('#'+discountPerctId);
                    var taxPerct = $('#'+taxPerctId);

                    var qtyVal = (qty.val() != '') ? qty.val() : 0;
                    var real_amount = qtyVal*rate;

                    var discountVal = (discount.val() != '') ? discount.val() : 0;
                    var discountPerctVal = (discountPerct.val() != '') ?(discountPerct.val()/100)*real_amount : 0;
                    var discountA = (discountPerct.val() != '') ? discountPerctVal : discountVal ;
                    var taxVal = (tax.val() != '') ? tax.val() : 0;
                    var amountToTax = real_amount - discountA;
                    var taxPerctVal = (taxPerct.val() != '') ? (taxPerct.val()/100)*amountToTax : 0;
                    var taxA = (taxPerct.val() == '') ? taxVal: taxPerctVal ;
                    discount.val(decPoints(discountA,2));
                    tax.val(decPoints(taxA,2));



                    var new_amount = (parseFloat(real_amount)-discountA) + parseFloat(taxA);
                    amount.val(decPoints(new_amount,2));
                    var sumToArray = classToArray(sharedSumClass);
                    var sumArray = sumArrayItems(sumToArray);
                    $('#'+overallSumId).val(decPoints(sumArray,2));

                    //ALWAYS GET SUM OF ALL TAXES AND ALLOWANCES AND DISPLAY THEIR AMOUNTS IN TOTAL DISCOUNTS AND TAXES
                    var totalDiscountGet = $('#'+totalDiscount);
                    var totalTaxGet = $('#'+totalTax);
                    var sumToArrayTax = classToArray(taxSharedClass);
                    var sumArrayTax = sumArrayItems(sumToArrayTax);
                    var sumToArrayDiscount = classToArray(discountSharedClass);
                    var sumArrayDiscount = sumArrayItems(sumToArrayDiscount);
                    totalDiscountGet.val(decPoints(sumArrayDiscount,2));
                    totalTaxGet.val(decPoints(sumArrayTax,2));
                    exclTax(overallSumId,totalTax,'excl_'+overallSumId);
                    convertToDefaultCurr(foreignCurrId,overallSumId,defaultCurrPage,vendorCustId,postDateId)

                });
            }else{
                swal("Warning!", 'Please Select an item and enter quantity to continue', "warning");
                $('#'+itemId).val('')
            }
            
            //END

        }else{

            //BEGINING
            var amount = $('#'+amountId);
            var rateGet = $('#'+rateId);
            var rate = rateGet.val();
            var item = $('#'+itemId).val();
            var discount = $('#'+discountAmountId);
            var discountPerct = $('#'+discountPerctId);
            var tax = $('#'+taxAmountId);
            var taxPerct = $('#'+taxPerctId);
            var qty = $('#'+qtyId);

            var qtyVal = (qty.val() != '') ? qty.val() : 0;
            var real_amount = qtyVal*rate;

            var discountVal = (discount.val() != '') ? discount.val() : 0;
            var discountPerctVal = (discountPerct.val() != '') ?(discountPerct.val()/100)*real_amount : 0;
            var discountA = (discountPerct.val() == '') ? discountVal: discountPerctVal ;
            var taxVal = (tax.val() != '') ? tax.val() : 0;
            var amountToTax = real_amount - discountA;
            var taxPerctVal = (taxPerct.val() != '') ? (taxPerct.val()/100)*amountToTax : 0;
            var taxA = (taxPerct.val() == '') ? taxVal: taxPerctVal ;
            discount.val(decPoints(discountA,2));
            tax.val(decPoints(taxA,2));
            

            if(rate != '' && item != ''){
                //var real_amount = (event.target.id == qtyId) ? rate : qtyVal*rate;
                var new_amount = (real_amount-discountA)+parseFloat(taxA);
                amount.val(decPoints(new_amount,2));
                var sumToArray = classToArray(sharedSumClass);
                var sumArray = sumArrayItems(sumToArray);
                $('#'+overallSumId).val(decPoints(sumArray,2));

                //ALWAYS GET SUM OF ALL TAXES AND ALLOWANCES AND DISPLAY THEIR AMOUNTS IN TOTAL DISCOUNTS AND TAXES
                var totalDiscountGet = $('#'+totalDiscount);
                var totalTaxGet = $('#'+totalTax);
                var sumToArrayTax = classToArray(taxSharedClass);
                var sumArrayTax = sumArrayItems(sumToArrayTax);
                var sumToArrayDiscount = classToArray(discountSharedClass);
                var sumArrayDiscount = sumArrayItems(sumToArrayDiscount);
                totalDiscountGet.val(decPoints(sumArrayDiscount,2));
                totalTaxGet.val(decPoints(sumArrayTax,2));
                exclTax(overallSumId,totalTax,'excl_'+overallSumId);
                convertToDefaultCurr(foreignCurrId,overallSumId,defaultCurrPage,vendorCustId,postDateId);

            }else{
                swal("Warning!", 'Please Select an item and enter quantity to continue', "warning");
            }
            // END

        }

    }

    function accountSum(amountId,accountId,rateId,discountAmountId,taxAmountId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId,taxPerctId,discountPerctId){
        var amount = $('#'+amountId);
        var rate = $('#'+rateId).val();
        var account = $('#'+accountId);
        var discount = $('#'+discountAmountId);
        var discountPerct = $('#'+discountPerctId);
        var taxPerct = $('#'+taxPerctId);

        var tax = $('#'+taxAmountId);

        emptyOneTimeTaxDiscount(overallSumId);

        var discountPerctVal = (discountPerct.val()/100)*rate;
        var discountVal = (discount != '') ? discount.val() : 0;
        var discountA = (discountPerct.val() == '') ? discountVal: discountPerctVal ;
        var taxVal = (tax.val() != '') ? tax.val() : 0;
        var amountToTax = rate - discountA;
        var taxPerctVal = (taxPerct.val()/100)*amountToTax;
        var taxA = (taxPerct.val() == '') ? taxVal: taxPerctVal ;
        discount.val(decPoints(discountA,2));
        tax.val(decPoints(taxA,2));

        if(account.val() != '' && $('#'+postDateId).val() != ''){
            var new_amount = (rate-discountA) + parseFloat(taxA);
            amount.val(decPoints(new_amount,2));
            var sumToArray = classToArray(sharedSumClass);
            var sumArray = sumArrayItems(sumToArray);
            $('#'+overallSumId).val(decPoints(sumArray,2));

            //ALWAYS GET SUM OF ALL TAXES AND ALLOWANCES AND DISPLAY THEIR AMOUNTS IN TOTAL DISCOUNTS AND TAXES
            var totalDiscountGet = $('#'+totalDiscount);
            var totalTaxGet = $('#'+totalTax);
            var sumToArrayTax = classToArray(taxSharedClass);
            var sumArrayTax = sumArrayItems(sumToArrayTax);
            var sumToArrayDiscount = classToArray(discountSharedClass);
            var sumArrayDiscount = sumArrayItems(sumToArrayDiscount);
            totalDiscountGet.val(decPoints(sumArrayDiscount,2));
            totalTaxGet.val(decPoints(sumArrayTax,2));
            exclTax(overallSumId,totalTax,'excl_'+overallSumId);
            convertToDefaultCurr(foreignCurrId,overallSumId,defaultCurrPage,vendorCustId,postDateId)

        }else{
            alert('Please select an posting date, account and enter rate/amount');
        }
    }

    function percentToAmount(percentId,perctAmountId,amountId,rateId,itemId,qtyId,discountAmountId,taxAmountId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId){
        var percent = $('#'+percentId).val();
        var perctAmount = $('#'+perctAmountId);
        var amount = $('#'+amountId);
        var rate = $('#'+rateId).val();
        var item = $('#'+itemId).val();
        var discount = $('#'+discountAmountId);
        var tax = $('#'+taxAmountId);
        var qtyVal = '';
        if(qtyId != ''){
            var qty = $('#'+qtyId);
             qtyVal = (qty.val() != '') ? qty.val() : 0;
        }

        emptyOneTimeTaxDiscount(overallSumId);

        if(rate != '' && item != ''){
            var real_amount = (qtyId == '') ? decPoints(rate,2) : decPoints(rate*qtyVal,2); //TOTAL SUM EXCLUDING DISCOUNT AND TAX
            var taxA = (tax.val() != '') ? tax.val() : 0;   //TAX VALUE
            var discountA = (discount.val() != '') ? discount.val() : 0;    //DISCOUNT VALUE

            var taxPerct = parseFloat(taxA*100)/parseFloat(real_amount - discountA);   //PERCENTAGE OF TAX

            var discountForTax = (discount.val() != '') ? discount.val() : 0;   //USED TO CALCULATE TAX FROM DISCOUNTED AMOUNT
            var amountToTax = real_amount - discountForTax; //TOTAL SUM FOR CALCULATING TAX
            var percentage = (perctAmountId == taxAmountId) ? (percent/100)*amountToTax  : (percent/100)*real_amount;   //DISCOUNT/TAX VALUE
            perctAmount.val(decPoints(percentage,2));   //UPDATE INPUT WITH VALUE OF TAX OR DISCOUNT

            var newTax = (perctAmountId == taxAmountId) ? tax.val() : parseFloat(taxPerct/100)*parseFloat(real_amount-percentage);  //NEW TAX AMOUNT IN CASE DISCOUNT IS CHANGED
                    
            var new_amount = (real_amount-discount.val())+parseFloat(newTax);   //NEW SUBTOTAL AFTER DISCOUNT AND TAX
            
            amount.val(decPoints(new_amount,2));    //UPDATE INPUT WITH VALUE OF SUBTOTAL
            if(perctAmountId != taxAmountId){
                tax.val(decPoints(newTax,2));   //UPDATE INPUT WITH VALUE OF TAX
            }            
            
            //DISPLAY SUM TOTAL OF SUB TOTALS IN THE TOTAL SUM FIELD
            var sumToArray = classToArray(sharedSumClass);
            var sumArray = sumArrayItems(sumToArray);
            $('#'+overallSumId).val(decPoints(sumArray,2));

            //ALWAYS GET SUM OF ALL TAXES AND ALLOWANCES AND DISPLAY THEIR AMOUNTS IN TOTAL DISCOUNTS AND TAXES
            var totalDiscountGet = $('#'+totalDiscount);
            var totalTaxGet = $('#'+totalTax);
            var sumToArrayTax = classToArray(taxSharedClass);
            var sumArrayTax = sumArrayItems(sumToArrayTax);
            var sumToArrayDiscount = classToArray(discountSharedClass);
            var sumArrayDiscount = sumArrayItems(sumToArrayDiscount);
            totalDiscountGet.val(decPoints(sumArrayDiscount,2));
            totalTaxGet.val(decPoints(sumArrayTax,2));
            exclTax(overallSumId,totalTax,'excl_'+overallSumId);

            convertToDefaultCurr(foreignCurrId,overallSumId,defaultCurrPage,vendorCustId,postDateId)
        }else{
            swal("Warning!", 'Please Select an item/account and enter quantity if necessary to continue', "warning");
            $('#'+percentId).val('')
        }

    }

    function fillNextInputTax(value_id,displayId,page,moduleType,amountId,rateId,itemId,qtyId,discountAmountId,taxAmountId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId,taxPerctId,discountPerctId){
        var pickedVal = $('#'+value_id).val();

        if(pickedVal != ''){
            $.ajax({
                url:  page+'?pickedVal='+pickedVal+'&type='+moduleType
            }).done(function(data){
                $('#'+displayId).val(data);
                var rate = $('#'+rateId);
                var qtyVal = $('#'+qtyId);

                $('#'+taxAmountId).val(decPoints((data*rate.val()*qtyVal.val()*data)/100,2));
                itemSum(amountId,rateId,itemId,qtyId,discountAmountId,taxAmountId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,'',taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId,taxPerctId,discountPerctId)
            });
        }

    }

    function fillNextInputTaxAcc(value_id,displayId,page,moduleType,amountId,rateId,accountId,discountAmountId,taxAmountId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId,taxPerctId,discountPerctId){
        var pickedVal = $('#'+value_id).val();

        if(pickedVal != ''){
            $.ajax({
                url:  page+'?pickedVal='+pickedVal+'&type='+moduleType
            }).done(function(data){
                $('#'+displayId).val(data);
                var rate = $('#'+rateId);
                $('#'+taxAmountId).val(decPoints((data*rate.val())/100,2));
                accountSum(amountId,accountId,rateId,discountAmountId,taxAmountId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId,taxPerctId,discountPerctId);

            });
        }

    }

    function convertToDefaultCurr(repId,amountId,page,vendorCustId,postDateId){
        var amount = $('#'+amountId).val();
        var vendorCust = $('#'+vendorCustId).val();
        var postDateVal = $('#'+postDateId);
        var postDate = (postDateVal.length >0) ? postDateVal.val() : '';

        $.ajax({
            url: page+'?amount=' + amount+'&vendorCust='+vendorCust+'&postDate='+postDate
        }).done(function(data){
            $('#'+repId).val(decPoints(data.overall_sum,2));
        });
    }

    function dropdownItemTransact(valDisplayId,val,hiddenValId,hiddenVal,dropdownId,amountId,currPage,currencyClass,vendorCustId,postDateId,convertToDefaultCurrPage,billAddress,currRate,foreignOverallSum) {
        $("#"+valDisplayId).val(val);
        $("#"+hiddenValId).val(hiddenVal);
        $("#"+dropdownId).hide();
        var amount = $("#"+amountId).val();
        fetchVendCustCurr(hiddenValId,currencyClass,currPage,billAddress,currRate);

        //CONVERT SELECTED VENDOR CURRENCY TO DEFAULT CURRENCY IN CASE THERE IS EXISTING TOTAL SUM
        if(amount != 0 && amount != ''){
            convertToDefaultCurr(foreignOverallSum,amountId,convertToDefaultCurrPage,vendorCustId,postDateId)
        }

    }

    function dropdownItemInv(valDisplayId,val,hiddenValId,hiddenVal,dropdownId,bill_invoice,invPage,descId,rateId,unitMId,subTotalId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,qtyId,vendorCustId,postDateId,totalTaxId) {
        $("#"+valDisplayId).val(val);
        $("#"+hiddenValId).val(hiddenVal);
        $("#"+dropdownId).hide();

        fetchInventory(hiddenValId,bill_invoice,invPage,descId,rateId,unitMId,subTotalId,sharedSumClass,overallSumId,foreignCurrId,defaultCurrPage,qtyId,vendorCustId,postDateId,totalTaxId);

    }

    function removeInputCalc(show_id,ghost_class,addUrl,type,all_new_fields_class,unique_num,addButtonId,hideButtonId,amtId,sumTotalId,currRep,currPage,taxSharedClass,discountSharedClass,totalTax,totalDiscount,vendorCustId,postDateId) {

        var amt = $('#'+amtId);
        var amtVal = (amt.val() != '') ? amt.val() : 0.00;

        //MINUS SINGLE LINE AMOUNT FROM SUM TOTAL AMOUNT TO BE REMOVED

        if(amtVal != ''){
            var newAmt = $('#'+sumTotalId).val() - amtVal;

            $('#'+sumTotalId).val(decPoints(newAmt,2));
        }else{
            //$('#'+sumTotalId).val(0);
        }

        var get_class = document.getElementsByClassName(all_new_fields_class);
        var addButtons = document.getElementsByClassName('addButtons');
        if(addButtons.length < 1 ) {

            if (addButtons.length < 1) {
                prevAddId.style.display = 'block';
            }
        }
        $('.' + ghost_class).remove();
        var show_all = document.getElementById(hideButtonId);
        var show_button = '';

        show_button += '<tr><td></td><td></td><td></td><td>';
        show_button += '<div style="cursor: pointer;" onclick="addMore(';

        show_button += "'"+addButtonId+"','"+hideButtonId+"','1','" + addUrl + "','"+type+"','"+hideButtonId+"');";
        show_button += '">';
        show_button += '<i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i></div>';
        show_button += '</tr>';
        if (get_class.length === 0) {

            show_all.innerHTML =show_button;
            show_all.style.display = 'block';
        }

        //ALWAYS GET SUM OF ALL TAXES AND ALLOWANCES AND DISPLAY THEIR AMOUNTS IN TOTAL DISCOUNTS AND TAXES
        var totalDiscountGet = $('#'+totalDiscount);
        var totalTaxGet = $('#'+totalTax);
        emptyOneTimeTaxDiscount(sumTotalId);

        var sumToArrayTax = classToArray(taxSharedClass);
        var sumArrayTax = sumArrayItems(sumToArrayTax);
        var sumToArrayDiscount = classToArray(discountSharedClass);
        var sumArrayDiscount = sumArrayItems(sumToArrayDiscount);        
        
        var newSumTotal = sharedSubTotal(sumTotalId);
       
        $('#'+sumTotalId).val(decPoints(newSumTotal,2));
        totalDiscountGet.val(decPoints(sumArrayDiscount,2));
        totalTaxGet.val(decPoints(sumArrayTax,2));

        exclTax(sumTotalId,totalTax,'excl_'+sumTotalId);

        convertToDefaultCurr(currRep,sumTotalId,currPage,vendorCustId,postDateId);

    }

    function genPercentage(perctId,perctAmountId,overallSumId,sharedSumClass,vendCustId,odaPerctAmountId,foreignSumId,currPage,vendorCustId,postDateId,discountSharedClass,sharedRate){
        var perct = $('#'+perctId);
        var overallSum = $('#'+overallSumId);
        var overallSumExcl = $('#excl_'+overallSumId);
        var exclVal = overallSumExcl.val();
        var perctAmount = $('#'+perctAmountId);
        var perctAmountVal = (perctAmount.val() == '') ? 0 : perctAmount.val(); //TOTAL DISCOUNT
        var odaperctAmount = $('#'+odaPerctAmountId);
        var odaperctAmountVal = (odaperctAmount.val() == '') ? 0 : odaperctAmount.val();    //TOTAL TAX
        var sumToArrayDiscount = classToArray(discountSharedClass);
        var sumArrayDiscount = sumArrayItems(sumToArrayDiscount);

        var sumToArraySharedRate = classToArray(sharedRate);
        var sumArraySharedRate = sumArrayItems(sumToArraySharedRate);

        var sumToArray = classToArray(sharedSumClass);
        var sumArrayInclTax = sumArrayItems(sumToArray);

        var vendCustVal = $('#'+vendCustId).val();
        if(vendCustVal != '' && overallSum.val() != ''){
            //GET OVERALL SUM WITHOUT TAX AND DISCOUNT INCLUSIVE            
            var overallSumExclVal = parseFloat(overallSumExcl.val()); //excluding tax and discount still included

            //GET PERCENTAGE DISCOUNT AMOUNT
            var originalSum = overallSumExclVal + parseFloat(perctAmountVal);   // excluding tax and discount not included
            var taxPerct = (parseFloat(odaperctAmountVal) * 100)/overallSumExclVal;
            var percentage = (perct.val()*originalSum)/100;
            var newTax = (taxPerct/100)* (originalSum - percentage) //REMOVE NEW DISCOUNT FROM THE INITIAL ORIGINAL AMOUNT
            perctAmount.val(decPoints(percentage,2));   // DISPLAY PERCENTAGE AMOUNT
            overallSum.val(decPoints(originalSum+parseFloat(newTax)-parseFloat(percentage),2)); //DISPLAY OVERALL SUM INCLUDING TAX AND DISCOUNT AMOUNT
            overallSumExcl.val(decPoints((originalSum-parseFloat(percentage)),2)); //DISPLAY OVERALL SUM WITHOUT TAX
            odaperctAmount.val(decPoints(newTax,2)); //NEW TAX AFTER DISCOUNT
            
            convertToDefaultCurr(foreignSumId,overallSumId,currPage,vendorCustId,postDateId);

        }else{
            swal("Warning!", 'Please Select Vendor/Customer, posting date and ensure there is Grand Total', "warning");
        }

    }

    function genPercentageTax(perctId,perctAmountId,overallSumId,sharedSumClass,vendCustId,odaPerctAmountId,foreignSumId,currPage,vendorCustId,postDateId){
        var perct = $('#'+perctId);
        var overallSum = $('#'+overallSumId);
        var overallSumExcl = $('#excl_'+overallSumId);
        var perctAmount = $('#'+perctAmountId);
        var odaperctAmount = $('#'+odaPerctAmountId);
        var vendCustVal = $('#'+vendCustId).val();
        
        if(vendCustVal != '' && overallSum.val() != ''){
            
            var totalExclDiscount = (overallSumExcl.val() == '') ? 0 : overallSumExcl.val();
            var percentage = (perct.val()*totalExclDiscount)/100;   //NEW TAX AMOUNT
            var newTotal = parseFloat(totalExclDiscount)+parseFloat(decPoints(percentage,2));   //TOTAL INCLUDING TAX
            perctAmount.val(decPoints(percentage,2));
            overallSum.val(decPoints(newTotal,2));
                        
            convertToDefaultCurr(foreignSumId,overallSumId,currPage,vendorCustId,postDateId);

        }else{
            swal("Warning!", 'Please Select Vendor/Customer, posting date and ensure there is Grand Total', "warning");
        }

    }

    function permItemDelete(dataId,page,dataIdVal,amtVal,totalValId,currRep,currPage,taxAmountId,discountAmountId,totalTax,totalDiscount,vendorCustId,postDateId,parentDataId,updateSumPage,reloadId,reloadUrl,dbTable){
        var totalVal = $('#'+totalValId).val();
        var discount = $('#'+discountAmountId).val();
        var discountVal = (discount == '') ? 0 : discount;
        var tax = $('#'+taxAmountId).val();
        var taxVal = (tax == '') ? 0 : tax;
        var totalDiscountGet = $('#'+totalDiscount);
        var totalDiscount = (totalDiscountGet.val() != '') ? totalDiscountGet.val() : 0;
        var totalTaxGet = $('#'+totalTax);
        var totalTax = (totalTaxGet.val() != '') ? totalTaxGet.val() : 0;


        $.ajax({
            url: page+'?dataId='+dataIdVal
        }).done(function(data){
            $('#'+dataId).remove();
            var newTotal = totalVal - amtVal;
            $('#'+totalValId).val(decPoints(newTotal,2));

            //ALWAYS GET SUM OF ALL TAXES AND ALLOWANCES AND DISPLAY THEIR AMOUNTS IN TOTAL DISCOUNTS AND TAXES
           var newTotalTax = totalTax - taxVal;
            var newTotalDiscount = totalDiscount - discountVal;
            totalDiscountGet.val(decPoints(newTotalDiscount,2));
            totalTaxGet.val(decPoints(newTotalTax,2));
            exclTax(totalValId,totalTax,'excl_'+totalValId);

            convertToDefaultCurr(currRep,totalValId,currPage,vendorCustId,postDateId);
            updateDbSum(parentDataId,updateSumPage,newTotal,totalTaxGet.val(),totalDiscountGet.val(),vendorCustId,postDateId,reloadId,reloadUrl,dbTable);
            swal("Warning!", 'Item removed successfully', "success");

        });


    }

    function tempItemDeleteConvert(dataId,page,dataIdVal,amtVal,totalValId,currRep,currPage,taxAmountId,discountAmountId,totalTax,totalDiscount,vendorCustId,postDateId,parentDataId,updateSumPage,reloadId,reloadUrl,dbTable){
    var totalVal = $('#'+totalValId).val();
    var discount = $('#'+discountAmountId);
    var discountVal = (discount.val() != '') ? discount.val() : 0;
    var taxVal = $('#'+taxAmountId).val();
    var totalDiscountGet = $('#'+totalDiscount);
    var totalDiscountVal = (totalDiscountGet.val() != '') ? totalDiscountGet.val() : 0;
    var totalTaxGet = $('#'+totalTax);
    var totalTaxVal = (totalTaxGet.val() != '') ? totalTaxGet.val() : 0;

    $.ajax({
        url: page+'?dataId='+dataIdVal
    }).done(function(data){
        $('#'+dataId).remove();
        var newTotal = totalVal - amtVal;
        $('#'+totalValId).val(decPoints(newTotal,2));

        //ALWAYS GET SUM OF ALL TAXES AND ALLOWANCES AND DISPLAY THEIR AMOUNTS IN TOTAL DISCOUNTS AND TAXES
        var newTotalTax = totalTaxVal - taxVal;
        var newTotalDiscount = totalDiscountVal - discountVal;
        totalDiscountGet.val(decPoints(newTotalDiscount,2));
        totalTaxGet.val(decPoints(newTotalTax,2));
        exclTax(totalValId,totalTax,'excl_'+totalValId);

        convertToDefaultCurr(currRep,totalValId,currPage,vendorCustId,postDateId);
        //updateDbSum(parentDataId,updateSumPage,newTotal,totalTaxGet.val(),totalDiscountGet.val(),vendorCustId,postDateId,reloadId,reloadUrl,dbTable);
        swal("Warning!", 'Item removed successfully', "success");

    });


}



    function updateDbSum(dataId,page,totalVal,totalTax,totalDiscount,vendorCustId,postDateId,reloadId,reloadUrl,dbTable){

        var postDate = $('#'+postDateId).val();
        var vendorCust = $('#'+vendorCustId).val();
        //alert( page+'?dataId='+dataId+'&grandTotal='+totalVal+'&totalTax='+totalTax+'&totalDiscount='+totalDiscount+'&postDate='+postDate+'&vendorCust='+vendorCust+'&dbTable='+dbTable);

       $.ajax({
            url: page+'?dataId='+dataId+'&grandTotal='+totalVal+'&totalTax='+totalTax+'&totalDiscount='+totalDiscount+'&postDate='+postDate+'&vendorCust='+vendorCust+'&dbTable='+dbTable
        }).done(function(data){
            
            reloadContent(reloadId,reloadUrl);

        });


    }

        ///////////////////////////  END OF ITEM AND ACCOUNT METHODS CALCULATION METHODS  //////////////////////

        ///////////////     BEGIN OF TABS WITH NEXT AND PREVIOUS        //////////////////

        $(document).ready(function () {
            //Initialize tooltips
            $('.nav-tabs > li a[title]').tooltip();

            //Wizard
            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

                var $target = $(e.target);

                if ($target.parent().hasClass('disabled')) {
                    return false;
                }
            });

            $(".next-step").click(function (e) {

                var $active = $('.wizard .nav-tabs li.active');
                $active.next().removeClass('disabled');
                nextTab($active);

            });
            $(".prev-step").click(function (e) {

                var $active = $('.wizard .nav-tabs li.active');
                prevTab($active);

            });
        });

        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }
        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }

        ////////////////    END OF TABS WITH NEXT AND PREVIOUS      //////////////////////

    function numONLY (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    }

    function submitMediaFormEditor(formModal,formId,submitUrl,reload_id,reloadUrl,token,editorName,editorId){

    var form = document.forms.namedItem(formId);
    var ckInput = CKEDITOR.instances[editorId].getData();

    var postVars = new FormData(form);
    postVars.append('token',token);
    postVars.append(editorName,ckInput);

    $('#'+formModal).modal('hide');
        //DISPLAY LOADING ICON
        overlayBody('block');

    sendRequestMediaForm(submitUrl,token,postVars)
    ajax.onreadystatechange = function(){
        if(ajax.readyState == 4 && ajax.status == 200) {
            //HIDE LOADING ICON
            overlayBody('none');
            var rollback = JSON.parse(ajax.responseText);
            var message2 = rollback.message2;
            if(message2 == 'fail'){

                //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                var serverError = phpValidationError(rollback.message);

                var messageError = swalFormError(serverError);
                swal("Error",messageError, "error");

            }else if(message2 == 'saved'){

                 //RESET FORM
                 //resetForm(formId);
                var successMessage = swalSuccess('Data saved successfully');
                swal("Success!", successMessage, "success");
                //location.reload();

            }else{
                
                var infoMessage = swalWarningError(message2);
                swal("Warning!", infoMessage, "warning");

            }

            //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
            reloadContent(reload_id,reloadUrl);
        }
    }

}

    function submitMediaFormEditorReloadWithInputs(formModal,formId,submitUrl,reload_id,reloadUrl,token,editorName,editorId){

    var form = document.forms.namedItem(formId);
    var ckInput = CKEDITOR.instances[editorId].getData();

    var postVars = new FormData(form);
    postVars.append('token',token);
    postVars.append(editorName,ckInput);

    $('#'+formModal).modal('hide');
        //DISPLAY LOADING ICON
        overlayBody('block');

    sendRequestMediaForm(submitUrl,token,postVars)
    ajax.onreadystatechange = function(){
        if(ajax.readyState == 4 && ajax.status == 200) {
            //HIDE LOADING ICON
            overlayBody('none');

            var rollback = JSON.parse(ajax.responseText);
            var message2 = rollback.message2;
            if(message2 == 'fail'){

                //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                var serverError = phpValidationError(rollback.message);

                var messageError = swalFormError(serverError);
                swal("Error",messageError, "error");

            }else if(message2 == 'saved'){

                 //RESET FORM
                 //resetForm(formId);
                var successMessage = swalSuccess('Data saved successfully');
                swal("Success!", successMessage, "success");
                //location.reload();

            }else{

                
                var infoMessage = swalWarningError(message2);
                swal("Warning!", infoMessage, "warning");

            }

            //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
            reloadContentWithInputs(reload_id,reloadUrl,formId);
        }
    }

}

    function submitMediaFormReloadWithInputs(formModal,formId,submitUrl,reload_id,reloadUrl,token){
    var form_get = $('#'+formId);
    var form = document.forms.namedItem(formId);
    var postVars = new FormData(form);
    postVars.append('token',token);
    
    $('#'+formModal).modal('hide');
        //DISPLAY LOADING ICON
        overlayBody('block');

    sendRequestMediaForm(submitUrl,token,postVars);
    ajax.onreadystatechange = function(){
        if(ajax.readyState == 4 && ajax.status == 200) {
            //HIDE LOADING ICON
            overlayBody('none');

            var rollback = JSON.parse(ajax.responseText);
            var message2 = rollback.message2;
            if(message2 == 'fail'){

                //OBTAIN ALL ERRORS FROM PHP WITH LOOP
                var serverError = phpValidationError(rollback.message);

                var messageError = swalFormError(serverError);
                swal("Error",messageError, "error");

            }else if(message2 == 'saved'){

                 //RESET FORM
                 //resetForm(formId);
                var successMessage = swalSuccess('Data saved successfully');
                swal("Success!", successMessage, "success");

            }else if(message2 == 'token_mismatch'){

                location.reload();

            }else {
                var infoMessage = swalWarningError(message2);
                swal("Warning!", infoMessage, "warning");
            }

            //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS
            reloadContentWithInputs(reload_id,reloadUrl,formId);
        }
    }

}

    function fetchFreshComments(postId,commentClass,displayId,submitUrl,token){
        var commentIds = 'commentIds='+sanitizeDataWithoutEncode(commentClass);
        var postData = commentIds+'&postId='+postId;
        
        sendRequestForm(submitUrl,token,postData)
        ajax.onreadystatechange = function(){
            if(ajax.readyState == 4 && ajax.status == 200) {

                $('#'+displayId).html(ajax.responseText);

                //END OF IF CONDITION FOR OUTPUTING AJAX RESULTS

            }
        }

    }

    function idDisplayClass(getClass){
        $('.'+getClass).toggle();
    }


    //CREDITING A VENDOR OR CUSTOMER DURING PAYMENT OR RECEIPT, USED BY THE CREDIT INPUT FIELD
    function DebitCreditMemoApply(creditAppliedId,creditAppliedClass,defaultCreditBalClass,currCreditBalClass,payId,defaultTotalId,currTotalId,currTotalHiddenId,sumTotalId,sumTotalHiddenId,sumTotalClass){

        var creditApplied = $('#'+creditAppliedId); //CREDIT TO BE APPLIED TO CURRENT TOTAL
        var pay = $('#'+payId); //PAYMENT AMOUNT
        var defaultTotal = $('#'+defaultTotalId);   //AMOUNT BALANCE TO BE PAID/RECEIVED
        var currTotal = $('#'+currTotalId);     //AMOUNT PAID/RECEIVED
        var currTotalHidden = $('#'+currTotalHiddenId);  //HIDDEN INPUT FOR CURRENT TOTAL
        var sumTotal = $('#'+sumTotalId);   //SUM TOTAL TO BE RECEIVED/PAID BY ALL THE VENDOR/CUSTOMER SELECTED
        var sumTotalHidden = $('#'+sumTotalHiddenId);   //HIDDEN INPUT FOR SUM TOTAL

        var creditAppliedVal = (creditApplied.val() == '') ? 0 : creditApplied.val();
        var payVal = (pay.val() == '') ? 0 : pay.val();
        var defaultTotalVal = (defaultTotal.val() == '') ? 0 : defaultTotal.val();
        var currTotalVal = (currTotal.val() == '') ? 0 : currTotal.val();

        var defaultCreditBalGet = document.getElementsByClassName(defaultCreditBalClass);
        defaultCreditBal = sumClassToArray(defaultCreditBalClass)/defaultCreditBalGet.length;

        
        var currCreditBalGet = document.getElementsByClassName(currCreditBalClass); 
        var currCreditBal = sumClassToArray(currCreditBalClass)/currCreditBalGet.length;  //CREDIT BALANCED APPLIED FROM/TO VENDOR/CUSTOMER
        
        
        if(currCreditBal > (parseFloat(creditAppliedVal)) ){  //CHECK IF CREDIT APPLIED IS GREATER THAT TOTAL CREDIT

            if((parseFloat(creditAppliedVal)+parseFloat(payVal) ) > defaultTotalVal){   //CHECK IF SUM OF CREDIT APPLIED AND CASH IS GREATER THAN BALANCE TO BE PAID/RECEIVED
                var newBal = (currTotalVal < 1) ? 0 : currTotalVal - creditAppliedVal;
                currTotal.val(newBal);
                currTotalHidden.val(newBal);
                var totalAmount = sumClassToArray(sumTotalClass); //SUM ALL THE TOTAL FROM EACH CUSTOMER/VENDOR TO GET ONE TOTAL AFTER OBTAINING VALUE OF CURR TOTAL
                sumTotal.val(totalAmount);
                sumTotalHidden.val(totalAmount);
                creditApplied.val('0.00'); //CLEAR CREDIT APPLIED

            }else{
                var newBal = decPoints(parseFloat(creditAppliedVal) + parseFloat(payVal),2);
                currTotal.val(newBal);
                currTotalHidden.val(newBal);
                var totalAmount = sumClassToArray(sumTotalClass); //SUM ALL THE TOTAL FROM EACH CUSTOMER/VENDOR TO GET ONE TOTAL AFTER OBTAINING VALUE OF CURR TOTAL
                sumTotal.val(totalAmount);
                sumTotalHidden.val(totalAmount);
                var creditBal = defaultCreditBal - sumClassToArray(creditAppliedClass)    //CREDIT BALANCE TO UPDATE THE EXISTING CURRENCT/CHANGING BALANCE
                replaceClassInputWithVal(currCreditBalClass,decPoints(creditBal,2));
            }

        }else{  //CLEAR CREDIT APPLIED AND RESTORE PREVIOUS CURR TOTAL BALANCE
            var newBal = (currTotalVal < 1) ? 0 : currTotalVal - creditAppliedVal;

            currTotal.val(newBal);
            currTotalHidden.val(newBal);
            var totalAmount = sumClassToArray(sumTotalClass); //SUM ALL THE TOTAL FROM EACH CUSTOMER/VENDOR TO GET ONE TOTAL AFTER OBTAINING VALUE OF CURR TOTAL
            sumTotal.val(totalAmount);
            sumTotalHidden.val(totalAmount);

            creditApplied.val('0');

        }
        

    }

    function financePaymentOrReceipt(creditAppliedId,payId,currTotalId,defaultTotalId,currTotalHiddenId,sumTotalId,sumTotalHiddenId,sumTotalClass){

        var creditApplied = $('#'+creditAppliedId);
        var pay = $('#'+payId);
        var defaultTotal = $('#'+defaultTotalId);
        var currTotal = $('#'+currTotalId);
        var currTotalHidden = $('#'+currTotalHiddenId);  //HIDDEN INPUT FOR CURRENT TOTAL
        var sumTotal = $('#'+sumTotalId);   //SUM TOTAL TO BE RECEIVED/PAID BY ALL THE VENDOR/CUSTOMER SELECTED
        var sumTotalHidden = $('#'+sumTotalHiddenId);   //HIDDEN INPUT FOR SUM TOTAL

        var creditAppliedVal = (creditApplied.val() == '') ? 0 : creditApplied.val();
        var payVal = (pay.val() == '') ? 0 : pay.val();
        var defaultTotalVal = (defaultTotal.val() == '') ? 0 : defaultTotal.val();
        var currTotalVal = (currTotal.val() == '') ? 0 : currTotal.val();
        var totalAmount = sumClassToArray(sumTotalClass); //SUM ALL THE TOTAL FROM EACH CUSTOMER/VENDOR TO GET ONE TOTAL
        
        if((parseFloat(creditAppliedVal)+parseFloat(payVal) ) > defaultTotalVal){
            var newBal = decPoints(currTotalVal - payVal,2);
            console.log(newBal);
            currTotal.val(newBal);
            currTotalHidden.val(newBal);
            sumTotal.val(totalAmount);
            sumTotalHidden.val(totalAmount);
            pay.val('');
        }else{            
            var newBal = decPoints(parseFloat(payVal)+parseFloat(creditAppliedVal),2);
            console.log(newBal);
            currTotal.val(newBal);
            currTotalHidden.val(newBal);
            sumTotal.val(totalAmount);
            sumTotalHidden.val(totalAmount);
        }

    }

    function uiItemDelete(displayId){
        $('#'+displayId).remove();
        swal("Warning!", 'Item removed successfully', "success");
    }
   



