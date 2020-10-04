<form name="" id="editMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

    <div class="body">

        <div class="row clearfix">
            <div class="col-sm-4">
                <div class="form-group">
                    Assign User
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$edit->assigned->firstname}} {{$edit->assigned->lastname}}" autocomplete="off" id="select_user_edit" onkeyup="searchOptionList('select_user_edit','myUL2_edit','{{url('default_select')}}','default_search','user_edit');" name="select_user" placeholder="Select User">

                        <input type="hidden" class="user_class_edit" value="{{$edit->assigned_user}}" name="user" id="user_edit" />
                    </div>
                </div>
                <ul id="myUL2_edit" class="myUL"></ul>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    RFQ Number
                    <div class="form-line">
                        <input type="text" class="form-control" name="rfq_no" value="{{$edit->rfq_no}}" placeholder="RFQ Number">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    Due Date
                    <div class="form-line">
                        <input type="text" class="form-control datepicker4" value="{{$edit->due_date}}" id="due_date_edit" name="due_date" placeholder="Due Date">
                    </div>
                </div>
            </div>

        </div>
        <hr/>
        <div class="row clearfix">
            <h4>Account Section</h4>
            <!-- TABLE FOR THE ACCOUNT SECTION -->
            <table class="table table-bordered table-hover table-striped" id="account_main_table_edit">
                <thead>
                <tr>
                    <th>
                        <input type="checkbox" onclick="toggleme(this,'kid_checkbox');" id="parent_check"
                               name="check_all" class="" />

                    </th>
                    <th>Account</th>
                    <th>Description</th>
                    <th>Manage</th>
                </tr>
                </thead>
                <tbody id="add_more_acc_rfq_edit">

                <?php $num = 1000; $num2 = 0; $num1 = 0; $countDataAcc = []; $countDataPo = []; ?>
                @foreach($rfqData as $po)

                    @if($po->account_id != '')
                        <?php $num++; $num1++; $countDataAcc[] = $num2; ?>
                        <tr id="itemId{{$po->id}}">

                            <td scope="row">
                                <input value="{{$po->id}}" type="checkbox" id="po_id{{$po->id}}" class="" />

                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="" value="{{$po->account->acct_name}}" autocomplete="off" id="select_acc{{$num}}" onkeyup="searchOptionListAcc('select_acc{{$num}}','myUL500_acc{{$num}}','{{url('default_select')}}','search_accounts','acc500{{$num}}','vendorCust_edit','posting_date_edit');" name="select_user" placeholder="Select Account">

                                            <input type="hidden" value="{{$po->account_id}}" class=""  name="acc_class{{$num1}}" id="acc500{{$num}}" />
                                        </div>
                                    </div>
                                    <ul id="myUL500_acc{{$num}}" class="myUL"></ul>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class=" " name="item_desc_acc{{$num1}}" id="item_desc_acc{{$num}}" placeholder="Description">{{$po->rfq_desc}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="center-align" id="">
                                <div class="form-group">
                                    <div style="cursor: pointer;" id="" onclick="permDeleteData('itemId{{$po->id}}','<?php echo url('delete_rfq_item') ?>','{{$po->id}}')" >
                                        <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                                    </div>
                                </div>
                            </td>

                        </tr>

                        <input type="hidden" name="accId{{$num1}}" value="{{$po->id}}" >
                    @endif
                @endforeach

                <tr>
                    <td class="center-align" id="hide_button_acc_rfq_edit">
                        <div class="form-group center-align">
                            <div onclick="addMore('add_more_acc_rfq_edit','hide_button_acc_rfq_edit','100000','<?php echo URL::to('add_more'); ?>','acc_rfq','hide_button_acc_rfq_edit');">
                                <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                            </div>
                        </div>
                    </td>


                </tr>

                <input type="hidden" name="count_ext_acc" value="<?php echo count($countDataAcc); ?>" >
                </tbody>
            </table>

        </div>
        <hr/>

        <!-- ITEM SECTION BEGINS HERE -->
        <div class="row clearfix">
            <h4>Item Section</h4>

            <table class="table table-bordered table-hover table-striped" id="po_main_table_edit">
                <thead>
                <tr>
                    <th class="col-md-2">
                        <input type="checkbox" onclick="toggleme(this,'kid_checkbox_po_edit');" id="parent_check_po_edit"
                               name="check_all_po_edit" class="" />

                    </th>


                    <th>Inventory Item</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Measure</th>
                    <th>Manage</th>
                </tr>
                </thead>
                <tbody id="add_more_rfq_edit">

                @foreach($rfqData as $po)

                    @if(!empty($po->item_id))
                        <?php $num++; $num2++; $countDataPo[] = $num2; ?>
                        <tr id="itemId{{$po->id}}">

                            <td >
                                <input value="{{$po->id}}" type="checkbox" id="po_id{{$po->id}}" class="kid_checkbox_po_edit" />

                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="" value="{{$po->inventory->item_name}}" autocomplete="off" id="select_inv{{$num}}" onkeyup="searchOptionList('select_inv{{$num}}','myUL500{{$num}}','{{url('default_select')}}','search_inventory','inv500{{$num}}');" name="select_user" placeholder="Inventory Item">

                                            <input type="hidden" class="inv_class" value="{{$po->item_id}}" name="inv_class{{$num2}}" id="inv500{{$num}}" />
                                        </div>
                                    </div>
                                    <ul id="myUL500{{$num}}" class="myUL"></ul>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea class=" " name="item_desc{{$num2}}" id="item_desc{{$num}}" placeholder="Description">{{$po->rfq_desc}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" class=" " value="{{$po->quantity}}" name="quantity{{$num2}}" id="qty{{$num}}" placeholder="Quantity"
                                                   onkeyup="itemSum('sub_total{{$num}}','unit_cost{{$num}}','inv500{{$num}}','qty{{$num}}','discount_amount{{$num}}','tax_amount{{$num}}','shared_sub_total_edit','overall_sum_edit','foreign_overall_sum_edit','<?php echo url('amount_to_default_curr') ?>','{{url('get_rate')}}','shared_tax_amount_edit','shared_discount_amount_edit','total_tax_amount_edit','total_discount_amount_edit','vendorCust_edit','posting_date_edit','tax_perct{{$num}}','discount_perct{{$num}}')">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select type="text" class=" " name="unit_measure{{$num2}}" id="unit_measure{{$num}}" >
                                            @foreach($unitMeasure as $data)
                                                <option value="{{$po->unit_measurement}}">{{$po->unit_measurement}}</option>
                                                <option value="{{$data->unit_name}}">{{$data->unit_name}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="center-align" id="">
                                <div class="form-group">
                                    <div style="cursor: pointer;" id="" onclick="permDeleteData('itemId{{$po->id}}','<?php echo url('delete_rfq_item') ?>','{{$po->id}}')">
                                        <i style="color:red;" class="fa fa-minus-circle fa-2x pull-right"></i>
                                    </div>
                                </div>
                            </td>

                        </tr>

                        <input type="hidden" name="poId{{$num2}}" value="{{$po->id}}" >
                    @endif
                @endforeach

                <tr>
                    <td class="center-align" id="hide_button_rfq_edit">
                        <div class="form-group center-align">
                            <div onclick="addMore('add_more_rfq_edit','hide_button_rfq_edit','100000','<?php echo URL::to('add_more'); ?>','rfq','hide_button_rfq_edit');">
                                <i style="color:green;" class="fa fa-plus-circle fa-2x pull-right"></i>
                            </div>
                        </div>
                    </td>

                </tr>

                <input type="hidden" name="count_ext_po" value="<?php echo count($countDataPo) ?>" >

                </tbody>
            </table>

        </div>
        <hr/>
        <div class="row clearfix container">

            <div class="row clearfix">

                <div class="col-sm-4">
                    <b>Mail Option</b>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control" name="mail_option" >
                                <option selected value="1">Send Mail</option>
                                <option value="0">Do not send mail</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <b>Send Mail To</b>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea class="form-control" name="emails" id="emails" placeholder="Enter Email(s), use a comma to separate them" >{{$edit->mails}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <b>Attachment</b>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="file" class="form-control" multiple="multiple" name="file[]" >
                        </div>
                    </div>
                </div>

            </div>

            <div class="row clearfix">

                <div class="col-sm-4">
                    <b>Copy (cc)</b>
                    <div class="form-group">
                        <div class="form-line">
                            <textarea class="form-control" name="mail_copy" id="copy_mails" placeholder="Enter Email(s), use a comma to separate them" >{{$edit->mail_copy}}</textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row clearfix">

                <textarea id="mail_message_edit" name="message" class="ckeditor" placeholder="Message">{{$edit->message}}</textarea>
                <script>
                    CKEDITOR.replace('mail_message_edit');
                </script>
                <script src="{{ asset('templateEditor/ckeditor/ckeditor.js') }}"></script>
            </div>

        </div>

    </div>
    <input type="hidden" name="edit_id" value="{{$edit->id}}" >
</form>

<?php $attach = json_decode($edit->attachment,true); $num=0; ?>
@if(count($attach) < 1)
    No Document
@else

    <table class="table table-responsive">
        <thead>
        <th> Attachment</th>
        <th>Download/Open</th>
        <th>Remove Attachment</th>
        </thead>
        <tbody>
        @foreach($attach as $at)
            <?php $num++; ?>
            <tr id="removeAttach{{$num}}">
                <td>File{{$num}}</td>
                <td><a target="_blank" href="<?php echo URL::to('rfq_download_attachment?file='); ?>{{$at}}">
                        <i class="fa fa-files-o fa-2x"></i>
                    </a></td>
                <td>

                    <form name="" id="removeAttachForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">

                        <div class="body">
                            <div class="row clearfix">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="hidden" value="{{$at}}"  class="form-control" name="attachment" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <input type="hidden" name="edit_id" value="{{$edit->id}}" >
                    </form>

                    <button type="button"  onclick="removeMediaForm('removeAttach{{$num}}','removeAttachForm','<?php echo url('rfq_remove_attachment'); ?>','reload_data',
                            '<?php echo url('rfq'); ?>','<?php echo csrf_token(); ?>')"
                            class="btn btn-danger waves-effect">
                        Remove
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

<script>
    $(function() {
        $( ".datepicker4" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
            /*yearRange: "-90:+00"*/

        });
    });

</script>