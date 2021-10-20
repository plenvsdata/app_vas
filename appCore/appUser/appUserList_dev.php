<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 31/01/2018
 * Time: 13:13
 */
use app\System\Lists\appDataList;
use app\System\Combo\appCombo;
use app\System\Lov\appGetValue;
//use app\SystemPaypal\payPalExpress;
$v_comboData = new appCombo();
$v_comboGender = json_decode($v_comboData->comboSystemGender(),true);
$v_comboTitle = $v_comboData->comboSystemTitle();
$v_comboPosition = json_decode($v_comboData->comboPosition(),true);

//$v_payPalData = new payPalExpress();
//$v_payPal = $v_payPalData->createPlan();


//Get Plan price
$v_fieldData['table'] = "view_client_instance";
$v_fieldData['field'] = "plan_price";
$v_fieldData['fieldID'] = $_SESSION['userClnt'];
$v_fieldData['fieldName'] = "clnt";
$v_planPriceData = new appGetValue();
$v_planPriceDataInfo = $v_planPriceData->appGetValueData($v_fieldData);
$v_plan_price = $v_planPriceDataInfo['0']['plan_price'];

$v_locale = $_SESSION['userLocale'];
$v_localeJS = str_replace('_','-',$_SESSION['userLocale']);

?>
<style>
    .modal-lg {
        max-width: 90% !important;
    }
    .flex-item
    {
        justify-content: space-around;
    }
    .help-block {display: none;}
    .hidden
    {
        display: none!important;
    }
    .btn-organizer
    {
        border: 1px solid #D9D9D9!important;
        height: 38px!important;
        background-color: #ffffff;
    }
    .btn-organizer-error
    {
        border: 1px solid #ef5350!important;
        height: 38px!important;
        background-color: #ffffff;
    }
    .btn-left-radius
    {
        border-radius: 4px 0 0 4px!important;
    }
    .btn-right-radius
    {
        border-radius: 0 4px 4px 0!important;
    }
    .bootbox .modal-header h4 {
        order: 0;
    }
    .bootbox .modal-header button {
        order: 1;
    }
    #divPurchase{
        margin-left: 15%;
    }


</style>
<div class="row page-titles basicContent">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><?=$v_appCrmPage?></h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=$GLOBALS['g_appRoot']?>/MeuPerfil">Home</a></li>
            <li class="breadcrumb-item">System Settings</li>
            <li class="breadcrumb-item active"><?=$v_appCrmPage?></li>
        </ol>
    </div>
</div>

<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid basicContent">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div style="position:absolute;"><button type="button" class="btn waves-effect waves-light btn-success" data-toggle="modal" data-target="#buyUserModal">Buy New Users</button><div id="paypal"></div></div>
                    <div class="table-responsive">
                        <table id="appDatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center!important;"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- Start Modal Buy Users  -->
<!-- ============================================================== -->
<div class="modal fade" id="buyUserModal" tabindex="-1" role="dialog" aria-labelledby="buyUserModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered-60" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Buy New Users</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <!--<input type="hidden" id="modalProductID" name="modalProductID" value="">-->
                <input type="hidden" id="plan_price" name="plan_price" value="<?=$v_plan_price?>">

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group has-feedback divBuyUserQtd">
                            <label for="quotedUnits" class="control-label">Units: <span id="buyUserQtdHelp" class="help-block text-danger"><small>(min 1 user)</small></span></label>
                            <input type="text" class="form-control newItemAdd vertical-spin form-control" maxlength="5" id="buyUserQtd" name="buyUserQtd" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" aria-describedby="buyUserQtdHelp" value="1">
                        </div>
                    </div>
                    <div class="col-md-4" id="divPurchase">
                       <label for="purchaseTotal" class="control-label">Purchase Total:</label>
                        <h2 id="purchaseTotal">$ 15.00</h2>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-success waves-effect waves-light" id="btnSaveBuy">Confirm Purchase</button>
                </div>


            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Modal Buy Users  -->
<!-- ============================================================== -->
<script src="../../assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
<!-- Load the required checkout.js script
<script src="https://www.paypalobjects.com/api/checkout.js" data-version-4></script>

<!-- Load the required Braintree components. -->
<!--<script src="https://js.braintreegateway.com/web/3.33.0/js/client.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.33.0/js/paypal-checkout.min.js"></script>


<script>
    paypal.Button.render({
        braintree: braintree,
        // Other configuration
    }, '#paypal');
</script>
-->
<script type="text/javascript">

    function addUserData(userID,profileID,userName,userEmail)
    {
        var v_chk = false;
        var v_userName = userName.trim();

        if(v_userName.length < 2)
        {
            $('#userAccessNameData').removeClass('has-success').addClass('has-danger');
            $('.userAccessNameFeedback').removeClass('hidden');
            $('#userAccessName').val(v_userName);
            v_chk = true;
        }
        else
        {
            $('#userAccessNameData').removeClass('has-danger').addClass('has-success');
            $('.userAccessNameFeedback').addClass('hidden');
            $('#userAccessName').val(v_userName);
            v_chk = true;
        }

        if(!validator.isEmail(userEmail))
        {
            $('#userAccessEmailData').removeClass('has-success').addClass('has-danger');
            $('.userAccessEmailFeedback').removeClass('hidden');
            v_chk = false;
        }
        else
        {
            $('#userAccessEmailData').removeClass('has-danger').addClass('has-success');
            $('.userAccessEmailFeedback').addClass('hidden');
            v_chk = true;
        }

        if(!v_chk)
        {
            toastr["warning"]("Correct all informations and try again.", "Attention!");
            return v_chk;
        }
        else
        {
            //alert(userID);
            $.when(
                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserInvitation",
                    type: "POST",
                    dataType: "json",
                    data:
                        {
                            appFormData:
                                {
                                    type:"json",
                                    userID:userID,
                                    userProfile:profileID,
                                    userName:userName,
                                    userEmail:userEmail,
                                    method:"POST"
                                }
                        }
                    })
            ).then(function(data,textStatus,jqXHR)
            {
                if(textStatus === 'success')
                {
                    if(data.inviteSent === false)
                    {
                        toastr["warning"]("This email can't be used. Change it and try again.", "Attention!");
                        return false;
                    }
                    else
                    {
                        toastr["success"]("Plenvs Data System invitation sent successfully.", "Success!");
                        $.docData.dtTable.ajax.reload();
                        bootbox.hideAll();
                        return true;
                    }
                }
                else
                {
                    toastr["warning"]("User can't be added. Try again.", "Attention!");
                    return false;
                }
            });
        }
    }

    $(document).ready(function() {
        //window.location = "<?=$GLOBALS['g_appRoot']?>/teste.php";
        $.docData = {
                dtTable : null,
                profileList : '',
        };
        $('.phone_us').mask('(000) 000-0000');
        $('#buyUserQtd').mask('00000');
        $("#btnSave").click(function()
        {
            var v_erro = 0;
            var v_userName = $("#userName").val();

            if(v_userName.length > 2)
            {
                $(".divUserName").removeClass( "has-danger" ).addClass( "has-success" );
                $("#userNameHelp").hide();
            }else
            {
                $(".divUserName").removeClass( "has-success" ).addClass( "has-danger" );
                $("#userNameHelp").show();
                v_erro = 1;
            }
            var v_userNickname = $("#userNickname").val();
            if(v_userNickname.length > 2)
            {
                $(".divUserNickname").removeClass( "has-danger" ).addClass( "has-success" );
                $("#userNicknameHelp").hide();
            }else
            {
                $(".divUserNickname").removeClass( "has-success" ).addClass( "has-danger" );
                $("#userNicknameHelp").show();
                v_erro = 1;
            }

            var v_phoneNumber = $("#phoneNumber").val();
            if(v_phoneNumber.length >13)
            {
                $(".divPhoneNumber").removeClass( "has-danger" ).addClass( "has-success" );
                $("#phoneNumberHelp").hide();
            }else
            {
                $(".divPhoneNumber" ).removeClass( "has-success" ).addClass( "has-danger" );
                $("#phoneNumberHelp").show();
                v_erro = 1;
            }
            var v_emailAddress = $("#emailAddress").val();
            v_emailAddress = v_emailAddress.trim();
            if(validator.isEmail(v_emailAddress) || v_emailAddress.length==0)
            {
                $(".divEmailAddress" ).removeClass( "has-danger" ).addClass( "has-success" );
                $("#emailAddressHelp" ).hide();
            }else
            {
                $(".divEmailAddress" ).removeClass( "has-success" ).addClass( "has-danger" );
                $("#emailAddressHelp" ).show();
                v_erro = 1;
            }
            var v_customerID = $("#customerID").val();

            if(v_customerID!='')
            {
                $('[data-id="customerID"]').removeClass('btn-organizer-error').addClass('btn-organizer');
                $("#customerIDHelp").hide();
            }else
            {
                $('[data-id="customerID"]').removeClass('btn-organizer').addClass('btn-organizer-error');
                $("#customerIDHelp").show();
                v_erro = 1;
            }


            if(v_erro==1){return false;}

            var serial_form = $('.divUser').find('select, textarea, input').serialize();
            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUser",
                type: "POST",
                dataType: "json",
                data:
                    {
                        formData: serial_form,
                        method :'POST'
                    },
                success: function(d)
                {
                    if(d.status === true)
                    {
                        location.href = "<?=$GLOBALS['g_appRoot']?>/CRM/User/"+d.userID;
                    }
                    else
                    {
                        toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                    }
                },
                error:function (d)
                {
                    toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                }
            });
        });

        $(".selectCustomerID").change(function()
        {
            var v_customer_id = $(this).val();

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboDepartment",
                type: "POST",
                dataType: "json",
                data:
                    {
                        appFormData:{
                            customerID: v_customer_id
                        }
                    },
                success: function(d)
                {
                    var options = '';
                    var v_selected;
                    $.each(d.rsData, function (key, val) {
                        if(val.department_id === 1)
                        {
                            v_selected = ' selected';
                        }else{
                            v_selected='';
                        }
                        options += '<option value="' + val.department_id + '" '+v_selected+'>' + val.department_desc + '</option>';
                    });
                    $("#departmentID").html(options).selectpicker('refresh');
                }
            });

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboPosition",
                type: "POST",
                dataType: "json",
                data:
                    {
                        appFormData:{
                            customerID: v_customer_id
                        }
                    },
                success: function(d)
                {
                    var options = '';
                    var v_selected;
                    $.each(d.rsData, function (key, val) {
                        if(val.position_id==1)
                        {
                            v_selected = ' selected';
                        }else{
                            v_selected='';
                        }
                        options += '<option value="' + val.position_id + '" '+v_selected+'>' + val.position_desc + '</option>';
                    });
                    $("#positionID").html(options).selectpicker('refresh');
                }
            });

        });

        $(".appUserStatus").on("click",function()
        {
            var v_elemento = $(this);
            var v_user_status_str = $(this).attr("data-user_status");
            var v_user_status_array = v_user_status_str.split("_");
            var v_user_status_new;
            if(v_user_status_array[1]==2){
                v_user_status_new = 1;
            }else{
                v_user_status_new = 2;
            }
            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUser",
                type: "POST",
                dataType: "json",
                data:
                    {
                        appFormData:{
                            method: "STATUS",
                            userID: v_user_status_array[0],
                            userStatus: v_user_status_new
                        }
                    },
                success: function(d)
                {
                    if(d.apiData.status==true)
                    {
                        location.reload();
                        if(v_user_status_new==2)
                        {
                            $(v_elemento).removeClass("btn-warning").addClass("btn-info");
                            $(v_elemento).text("Active");
                            $(v_elemento).data('user_status',v_user_status_array[0]+'_'+v_user_status_new);


                        }else{
                            $(v_elemento).removeClass("btn-info").addClass("btn-warning");
                            $(v_elemento).text("Inactive");
                            $(v_elemento).data('user_status',v_user_status_array[0]+'_'+v_user_status_new);
                        }
                    }else{
                        console.log('Can´t change status user');
                    }
                }
            });

        });

        $.docData.dtTable = $('#appDatatable').DataTable({
                "autoWidth": false,
                "paging": true,
                "pageLength": 10,
                "dom": '<"dtFloatRight"f><"dtInfoBeta">rt<"dtCenter"i<"dtFloatLeft"B><"dtFloatLeft"><"dtFloatRight"p>>',
                "ajax":
                    {
                        "url": "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appListSettingsUser",
                        "xhrFields": { withCredentials: true },
                        "dataSrc": "appUserList",
                        "dataType": "json",
                        "headers":
                            {
                                "userClnt":"<?=$_SESSION['userClnt']?>",
                                "appDatatable":true
                            },
                        "data": function(d){ }
                    },
                "buttons":
                    [
                        {"extend": 'excelHtml5', "text": 'Excel', "className": 'btn btn-sm dt-btn-width btn-success buttons-html5'}
                    ],
                "initComplete": function () {
                    $(".dt-buttons").removeClass("btn-group");
                },
                "columns":
                    [
                        { data:
                                {
                                    _: function(data)
                                    {
                                        if(data.user_status==1||data.user_status==2)
                                        {
                                            return "<a href='User/"+data.user_id+"'>"+data.user_name+"</a>";
                                        }else
                                        {
                                            return "<div>"+data.user_name+"</div>";
                                        }

                                    },
                                    _sort: "user_name"
                                }, "className":"text-left"
                        },
                        { data: "user_login", "className":"text-left" },
                        { data: "user_phone", "className":"text-left" },
                        { data:
                                {
                                    sort: "user_status",
                                    _: function (data)
                                    {
                                        if(data.user_status === "1"){
                                            return "<button type='button' data-user_id='"+data.user_id+"' data-user_status='2' class='btn waves-effect waves-light btn-sm btn-"+data.status_class+" appUserStatus' style='width:100%!important;'>"+data.status_desc+"</button>";
                                        }else if (data.user_status === "2") {
                                            return "<button type='button' data-user_id='"+data.user_id+"' data-user_status='1' class='btn waves-effect waves-light btn-sm btn-"+data.status_class+" appUserStatus' style='width:100%!important;'>"+data.status_desc+"</button>";
                                        }
                                        else if(data.user_status === "3"){
                                            return "<button type='button' data-user_id='"+data.user_id+"'  class='btn waves-effect waves-light btn-sm btn-"+data.status_class+" appUserInvite' style='width:100%!important;'>"+data.status_desc+"</button>";
                                        }
                                        else if(data.user_status === "4"){
                                            return "<button type='button' data-user_id='"+data.user_id+"'  class='btn waves-effect waves-light btn-sm btn-"+data.status_class+" appUserInvite' style='width:100%!important;'>"+data.status_desc+"</button>";
                                        }else if(data.user_status === "6"){
                                            return "<button type='button' data-user_id='"+data.user_id+"'  class='btn waves-effect waves-light btn-sm btn-"+data.status_class+" appUserConfig'  style='width:100%!important;'>"+data.status_desc+"</button>";
                                        }else{
                                            return "<button type='button' data-user_id='"+data.user_id+"'  class='btn waves-effect waves-light btn-sm btn-"+data.status_class+" ' style='width:100%!important;'>"+data.status_desc+"</button>";
                                        }
                                    }
                                },
                            "className":"text-center" },
                        { data:
                                {
                                    _: function (data)
                                    {
                                        if(data.owner==1)
                                        {
                                            var v_options = "<div style='width:100%!important; display: inline-flex;' class='flex-item'>"+
                                                "<i class=\"fa fa-border fa-star\" style='cursor: pointer;' data-user_id='"+data.user_id+"' data-user_name='"+data.user_name+"' data-toggle='tooltip' data-placement='top'  data-original-title='"+data.user_name+"'></i>"+
                                                "</div>";
                                        }else
                                        {
                                            var v_options = "<div style='width:100%!important; display: inline-flex;' class='flex-item'>"+
                                                "<i class=\"fa fa-border fa-trash appUserDel\" style='cursor: pointer;' data-user_status_del='"+data.user_status+"' data-user_id='"+data.user_id+"' data-user_name='"+data.user_name+"'></i>"+
                                                "</div>";
                                        }

                                        return v_options;
                                    }
                                },
                            "className":"text-center"
                        }
                    ],
                "createdRow": function( row, data, dataIndex )
                {
                    $(row).attr("data-user_id",data.user_id);
                },
                "columnDefs":
                    [
                        {
                            "targets": 4,
                            "orderable": false,
                            "searchable": false

                        }
                    ]
            }
        );
        $("input[name='buyUserQtd']").TouchSpin({ });


        $.docData.dtTable.on("click",".appUserStatus",function() {
            var v_userStatus = $(this).attr("data-user_status")
            var v_userID = $(this).attr("data-user_id");

            $.ajax({
                url:"<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserAccess",
                method:"POST",
                dataType:"json",
                data:
                    {
                        appFormData:{
                            userID: v_userID,
                            userStatus: v_userStatus,
                            method: "STATUS"
                        }

                    },
                success:function(d)
                {
                    if(d.status === true)
                    {
                        toastr["success"]("User Status Changed", "Success");
                        $.docData.dtTable.ajax.reload();
                    }
                    else
                    {
                        toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                    }
                },
                error:function()
                {
                    toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                }
            });
        });

        $.docData.dtTable.on("click",".appUserDel",function() {
            var v_userID = $(this).attr("data-user_id");
            var v_userName = $(this).attr("data-user_name");
            var v_userStatus = $(this).attr("data-user_status_del");

            bootbox.confirm({
                message: "Are you sure you want to delete this user:<br/><h3 class='text-center'>"+v_userName+"</h3><h3 style='color: #ef5350'>EVERYTHING related to this user will also be PERMANENTLY DELETED!</h3>",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn btn-success btn-sm'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn btn-danger btn-sm'
                    }
                },
                callback: function (result) {
                    if(result===true)
                    {
                        $.ajax({
                            url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserAccess",
                            type: "POST",
                            dataType: "json",
                            data:
                                {
                                    appFormData:{
                                        method: "DELETE",
                                        userID: v_userID,
                                        userStatus: v_userStatus
                                    }

                                },
                            success: function(d)
                            {
                                if(d.status === true)
                                {
                                    toastr["success"]("User "+v_userName+" deleted.", "Success");
                                    $.docData.dtTable.ajax.reload();
                                }
                                else
                                {
                                    toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                                }
                            },
                            error:function ()
                            {
                                toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                            }
                        });
                    }
                }
            });

        });

        $(document).on('click','#switchPlusDepartment',function () {
            $(this).addClass('hidden');
            $('#switchListDepartment').removeClass('hidden');
            $('#switchSaveDepartment').removeClass('hidden');
            $('#departmentNew').removeClass('hidden');
            $('#departmentID').selectpicker('hide');
            $('#departmentAction').val('2');
        });
        $(document).on('click','#switchListDepartment',function () {
            $(this).addClass('hidden');
            $('#switchPlusDepartment').removeClass('hidden');
            $('#switchSaveDepartment').addClass('hidden');
            $('#departmentNew').addClass('hidden');
            $('#departmentID').selectpicker('show');
            $('#departmentAction').val('1');
        });
        $(document).on('click','#switchPlusPosition',function () {
            $(this).addClass('hidden');
            $('#switchListPosition').removeClass('hidden');
            $('#switchSavePosition').removeClass('hidden');
            $('#positionNew').removeClass('hidden');
            $('#positionID').selectpicker('hide');
            $('#positionAction').val('2');
        });
        $(document).on('click','#switchListPosition',function () {
            $(this).addClass('hidden');
            $('#switchPlusPosition').removeClass('hidden');
            $('#switchSavePosition').addClass('hidden');
            $('#positionNew').addClass('hidden');
            $('#positionID').selectpicker('show');
            $('#positionAction').val('1');
        });
        $(document).on('click','#switchSaveDepartment',function () {

            var v_department_desc = $('#departmentNew').val();
            v_department_desc = v_department_desc.trim();
            var v_customerID = $('#customerID').val();

            if(v_department_desc.length < 3)
            {
                toastr["warning"]("New Department too small. Fix it and try again.", "Attention!");
            }else
            {
                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appLovDepartment",
                    type: "POST",
                    dataType: "json",
                    data:
                        {
                            type:"json",
                            departmentDesc:v_department_desc,
                            customerID:v_customerID,
                            method:"POST"
                        },
                    success: function(d)
                    {
                        if(d.status  == true)
                        {

                            $v_option = '<option value="'+d.rsInsertID+'" selected>'+v_department_desc+'</option>';
                            $('#departmentID option:selected').removeAttr('selected');
                            $("#departmentID").append($v_option).selectpicker('refresh');
                            $('#switchPlusDepartment').removeClass('hidden');
                            $('#switchListDepartment').addClass('hidden');
                            $('#switchSaveDepartment').addClass('hidden');
                            $('#departmentNew').addClass('hidden');
                            $('#departmentNew').val('');
                            $('#departmentID').selectpicker('show');
                            $('#departmentAction').val('1');
                        }

                    }
                });

            }
        });
        $(document).on('click','#switchSavePosition',function () {

            var v_position_desc = $('#positionNew').val();
            v_position_desc = v_position_desc.trim();
            var v_customerID = $('#customerID').val();

            if(v_position_desc.length < 3)
            {
                toastr["warning"]("New Position too small. Fix it and try again.", "Attention!");
            }else
            {
                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appLovPosition",
                    type: "POST",
                    dataType: "json",
                    data:
                        {
                            type:"json",
                            positionDesc:v_position_desc,
                            customerID:v_customerID,
                            method:"POST"
                        },
                    success: function(d)
                    {
                        if(d.status  == true)
                        {

                            $v_option = '<option value="'+d.rsInsertID+'" selected>'+v_position_desc+'</option>';
                            $('#positionID option:selected').removeAttr('selected');
                            $("#positionID").append($v_option).selectpicker('refresh');
                            $('#switchPlusPosition').removeClass('hidden');
                            $('#switchListPosition').addClass('hidden');
                            $('#switchSavePosition').addClass('hidden');
                            $('#positionNew').addClass('hidden');
                            $('#positionNew').val('');
                            $('#positionID').selectpicker('show');
                            $('#positionAction').val('1');
                        }

                    }
                });

            }
        });
        $(document).on('click','#btnSaveBuy',function () {
            var v_buyUserQtd = $('#buyUserQtd').val();
            var v_erro = 0;
            if(v_buyUserQtd.length > 0 && v_buyUserQtd>0)
            {
                $(".divBuyUserQtd").removeClass( "has-danger" );
                $("#buyUserQtdHelp" ).hide();
            }else
            {
                $(".divBuyUserQtd").addClass( "has-danger" );
                $("#buyUserQtdHelp" ).show();
                v_erro = 1;
            }

            if(v_erro==1){return false;}

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appPaymentAPI/appPayment",
                type: "POST",
                dataType: "json",
                data:
                    {
                        type:"json",
                        method:"POST",
                        buyUserQtd: v_buyUserQtd
                    },
                success: function(d)
                {
                    if(d.apiData.status===true)
                    {
                        $('#buyUserModal').modal('hide');
                        toastr["success"]("New Users added!", "Success");
                        $.docData.dtTable.ajax.reload();
                    }
                },
                complete: function(d)
                {

                }
            });

        });
        $(document).on('click','.appUserInvite',function () {
          var v_userID = $(this).attr("data-user_id");
            bootbox.dialog(
                {
                    message: 'Resend Invitation',
                    buttons: {
                        confirm: {
                            label: 'Confirm',
                            className: 'btn-success',
                            callback: function () {
                                $.ajax({
                                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserInvitation",
                                    type: "POST",
                                    dataType: "json",
                                    data:
                                        {
                                            appFormData:
                                                {
                                                    type:"json",
                                                    userID:v_userID,
                                                    method:"PUT"
                                                }
                                        },
                                    success: function(d)
                                    {
                                        if(d.inviteSent === true)
                                        {
                                            toastr["success"]("Invitation sent.", "Success");
                                            $.docData.dtTable.ajax.reload();
                                        }
                                        else
                                        {
                                            toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                                        }
                                    },
                                    error:function ()
                                    {
                                        toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                                    }
                                });
                            }
                        },
                        cancel: {
                            label: 'Cancel',
                            className: 'btn-danger',
                            callback: function () { return true; }
                        }
                    }
                });
        });
        $(document).on('shown.bs.modal', '#buyUserModal', function (event) {
            $('#buyUserQtd').val('1');
        });
        $(document).on('change','#buyUserQtd',function (){
            $v_qtdUser = $(this).val();
            $v_planPrice = $("#plan_price").val();
            $v_total = $v_qtdUser * $v_planPrice;
            $('#purchaseTotal').html($v_total.toLocaleString($.globalData.localeJS, { style:'currency', currency:'USD' }));
        });
        $(document).on('click','.appUserConfig',function(){
            var v_userID = $(this).attr("data-user_id");

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboSystemUserProfile",
                type: "POST",
                dataType: "json",
                data:
                    {
                        type:"json",
                        method:"POST"
                    },
                success: function(d)
                {
                    var v_data = d.apiData;
                    $.docData.profileList = "";
                    $.each(v_data.rsData, function (key, val)
                    {
                        $.docData.profileList += '<option value="' + val.access_profile_id + '">' + val.access_profile_desc + '</option>';
                    });
                },
                complete: function(d)
                {
                    bootbox.dialog(
                        {
                            title: 'Invite New User',
                            message: '<div class="row">'+
                                '<div class="col-md-12">'+
                                '<div class="form-group has-feedback userAccessProfileData">'+
                                '<label class="control-label">Access Profile</label>'+
                                '<select class="form-control custom-select userAccessProfile" id="userAccessProfile" name="userAccessProfile">'+
                                $.docData.profileList+
                                '</select>'+
                                '</div>'+
                                '</div>'+
                                '<div class="col-md-12">'+
                                '<div class="form-group has-feedback" id="userAccessNameData">'+
                                '<label class="control-label" for="userAccessName">Name <span class="userAccessNameFeedback text-danger hidden"><small>(min 2 characters)</small></span></label>'+
                                '<input type="text" class="form-control userAccessName" id="userAccessName" name="userAccessName" aria-describedby="userAccessNameStatus">'+
                                '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="margin-left: -180px!important;"></span>' +
                                '<span id="userAccessNameStatus" class="sr-only">(success)</span>'+
                                '</div>'+
                                '</div>'+
                                '<div class="col-md-12">'+
                                '<div class="form-group has-feedback" id="userAccessEmailData">'+
                                '<label class="control-label" for="userAccessEmail">Email <span class="userAccessEmailFeedback text-danger hidden"><small>(Add a valid email address)</small></span></label>'+
                                '<input type="text" class="form-control userAccessEmail" id="userAccessEmail" name="userAccessEmail" aria-describedby="userAccessEmailStatus">'+
                                '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="margin-left: -180px!important;"></span>' +
                                '<span id="userAccessEmailStatus" class="sr-only">(success)</span>'+
                                '</div>'+
                                '</div>'+
                                '</div>',
                            buttons: {
                                confirm: {
                                    label: 'Send Invitation',
                                    className: 'btn-success',
                                    callback: function () {
                                        return addUserData(v_userID,$(".userAccessProfile").val(),$(".userAccessName").val(),$(".userAccessEmail").val());
                                    }
                                },
                                cancel: {
                                    label: 'Cancel',
                                    className: 'btn-danger',
                                    callback: function () { return true; }
                                }
                            }
                        });
                }
            });
        });



    });
</script>


