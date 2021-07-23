<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 31/01/2018
 * Time: 13:13
 */
use app\System\Lists\appDataList;
use app\System\Combo\appCombo;
//use app\System\Lov\appGetValue;

$v_comboData = new appCombo();
$v_comboProfile = $v_comboData->comboSystemAccessProfile('array');
$v_comboCustomer = $v_comboData->comboCustomer('array');

$v_sectionIDCheck = true;
$_dataSectionCheck = 'true';
if(isset($_SESSION['sectionIDCheck'])){
    if(!$_SESSION['sectionIDCheck']){
        $v_sectionIDCheck = false;
        $_dataSectionCheck = 'false';
        $_SESSION['sectionIDCheck'] = true;
    }
}

?>
<style>
    .flex-item
    {
        justify-content: space-around;
    }
    .help-block {display: none;}
    .hidden
    {
        display: none!important;
    }
    .bootbox .modal-header h4 {
        order: 0;
    }
    .bootbox .modal-header button {
        order: 1;
    }
    .teste_class .modal-header{
        display: flex!important;
    }


</style>
<div class="row page-titles basicContent">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><?=$v_appCrmPage?></h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=$GLOBALS['g_appRoot']?>/Welcome">Home</a></li>
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
                    <div style="position:absolute;"><button type="button" class="btn btn-sm waves-effect waves-light btn-success" data-toggle="modal" data-target="#userModal">Adicionar Usuário</button><div id="paypal"></div></div>
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
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered-90" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar Usuário</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group has-feedback divUserName">
                            <label for="userName" class="control-label">Nome completo:</label>
                            <input type="text" class="form-control userName" id="userName" name="userName" aria-describedby="userNameHelp">
                            <span id="userNameHelp" class="help-block text-danger">Min 3 characters</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group has-feedback divUserNickname">
                            <label for="userNickname" class="control-label">Conhecido por:</label>
                            <input type="text" class="form-control userNickname" id="userNickname" name="userNickname" aria-describedby="userNicknameHelp">
                            <span id="userNicknameHelp" class="help-block text-danger">Min 3 caracteres</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group has-feedback divUserEmail">
                            <label for="userEmail" class="control-label">Email:</label>
                            <input type="text" class="form-control userEmail" required id="userEmail" name="userEmail" aria-describedby="userEmailHelp">
                            <span id="userEmailHelp" class="help-block text-danger">Min 3 caracteres</span>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group has-feedback divUserPhone">
                            <label for="userPhone" class="control-label">Telefone:</label>
                            <input type="text" class="form-control userPhone" id="userPhone" name="userPhone" aria-describedby="userPhoneHelp">
                            <span id="userPhoneHelp" class="help-block text-danger">Min 3 characters</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Perfil de Acesso</label>
                            <select id=profileID" name="profileID" class="form-control custom-select selectpicker profileID">
                            <?php foreach ($v_comboProfile['rsData'] as $key=>$value){ ?>
                                <option value="<?=$value['access_profile_id']?>"><?=$value['access_profile_desc']?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div id="divCustomer" class="col-md-5 hide">
                        <div class="form-group">
                            <label class="control-label">Cliente:</label>
                            <select id=customerID" name="customerID" class="form-control custom-select selectpicker customerID">
                                <?php foreach ($v_comboCustomer['rsData'] as $key=>$value){ ?>
                                    <option value="<?=$value['customer_id']?>"><?=$value['customer_nome_fantasia']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal" id="btnCancel">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-success waves-effect waves-light" id="btnSave">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Modal Buy Users  -->
<!-- ============================================================== -->
<script src="../../assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $.docData = {
            dtTable : null,
            profileList : '',
            dataSectionCheck : <?=$_dataSectionCheck?>
        };

        if($.docData.dataSectionCheck === false){
            toastr["warning"]("This user doesn't exist.", "Attention!");
        }

        $("#userPhone").mask('(00) 00000-0000');

        $(".appUserStatus").on("click",function()
        {
            let v_elemento = $(this);
            let v_user_status_str = $(this).attr("data-user_status");
            let v_user_status_array = v_user_status_str.split("_");
            let v_user_status_new;
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
                        "url": "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appListUser",
                        "xhrFields": { withCredentials: true },
                        "dataSrc": "appUserList",
                        "dataType": "json",
                        "headers":
                            {
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
                                            return "<button type='button' data-user_id='"+data.user_id+"' data-user_status='2' class='btn waves-effect waves-light btn-xs btn-"+data.status_class+" appUserStatus' style='width:100%!important;'>"+data.status_desc+"</button>";
                                        }else if (data.user_status === "2") {
                                            return "<button type='button' data-user_id='"+data.user_id+"' data-user_status='1' class='btn waves-effect waves-light btn-xs btn-"+data.status_class+" appUserStatus' style='width:100%!important;'>"+data.status_desc+"</button>";
                                        }
                                        else if(data.user_status === "3"){
                                            return "<button type='button' data-user_id='"+data.user_id+"'  class='btn waves-effect waves-light btn-xs btn-"+data.status_class+" appUserInvite' style='width:100%!important;'>"+data.status_desc+"</button>";
                                        }
                                        else if(data.user_status === "4"){
                                            return "<button type='button' data-user_id='"+data.user_id+"'  class='btn waves-effect waves-light btn-xs btn-"+data.status_class+" appUserInvite' style='width:100%!important;'>"+data.status_desc+"</button>";
                                        }else if(data.user_status === "6"){
                                            return "<button type='button' data-user_id='"+data.user_id+"'  class='btn waves-effect waves-light btn-xs btn-"+data.status_class+" appUserConfig'  style='width:100%!important;'>"+data.status_desc+"</button>";
                                        }else{
                                            return "<button type='button' data-user_id='"+data.user_id+"'  class='btn waves-effect waves-light btn-xs btn-"+data.status_class+" ' style='width:100%!important;'>"+data.status_desc+"</button>";
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

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboOwner",
                type: "POST",
                dataType: "json",
                data:
                    {
                        userID: v_userID,
                    },
                success: function(e)
                {
                    $.ajax({
                        url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appOpportunity",
                        type: "POST",
                        dataType: "json",
                        data:
                            {
                                method: "OWNER",
                                ownerID: v_userID
                            },
                        success: function(d)
                        {
                            if(d === true)
                            {

                                bootbox.prompt({
                                    title: "Are you sure you want to delete this user:<br/><h3 class='text-center'>"+v_userName+"</h3><div style='color: #ef5350;' class='text-center'>Please identify to whom shall we merge all information attributed to:</div>",
                                    inputType: 'select',
                                    inputOptions: e,
                                    className:'teste_class',
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
                                        if(result){
                                            $.ajax({
                                                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appOpportunity",
                                                type: "POST",
                                                dataType: "json",
                                                data:
                                                    {
                                                        method: "OWNER_TRANSFER",
                                                        ownerIDCurrent: v_userID,
                                                        ownerIDNew: result
                                                    },
                                                success: function(d)
                                                {
                                                    console.log(d.status);
                                                    if(d.status === true){
                                                        console.log('transfer ok');
                                                        delUser(v_userID,v_userStatus,v_userName);
                                                    }else{
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

                            }
                            else
                            {
                                bootbox.confirm({
                                    message: "Are you sure you want to delete this user:<br/><h3 class='text-center'>"+v_userName+"</h3>",
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
                                            delUser(v_userID,v_userStatus,v_userName);
                                        }
                                    }
                                });
                            }
                        },
                        error:function ()
                        {
                            toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                        }
                    });
                }
            });

        });

        function delUser(userID,userStatus,userName){

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserAccess",
                type: "POST",
                dataType: "json",
                data:
                    {
                        appFormData:{
                            method: "DELETE",
                            userID: userID,
                            userStatus: userStatus
                        }

                    },
                success: function(d)
                {
                    if(d.status === true)
                    {
                        toastr["success"]("User "+userName+" deleted.", "Success");
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

        $(document).on('click','.appUserConfig',function(){
            let v_userID = $(this).attr("data-user_id");

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
                    let v_data = d.apiData;
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
                                '<label class="control-label" for="userAccessName">Name <span class="userAccessNameFeedback text-danger hidden"><small>(min 2 characters)</small></span></label><br>'+
                                '<input type="text" class="form-control userAccessName" id="userAccessName" name="userAccessName" aria-describedby="userAccessNameStatus">'+
                                '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="margin-left: -180px!important;"></span>' +
                                '<span id="userAccessNameStatus" class="sr-only">(success)</span>'+
                                '</div>'+
                                '</div>'+
                                '<div class="col-md-12">'+
                                '<div class="form-group has-feedback" id="userAccessEmailData">'+
                                '<label class="control-label" for="userAccessEmail">Email <span class="userAccessEmailFeedback text-danger hidden"><small>(Add a valid email address)</small></span></label><br>'+
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

        $(document).on('click','#btnSave',function(){
            let v_userName = $("#userName").val();
            let v_userNickname = $("#userNickname").val();
            let v_userEmail = $("#userEmail").val();
            let v_userPhone = $("#userPhone").val();
            let v_profileID = parseInt($(".profileID option:selected").val());
            let v_customerID = parseInt($(".customerID option:selected").val());
            let v_erro = '';

            if(v_userName.length<5){
                v_erro+='-Nome completo deve ter min. 5 caracteres.<br>';
            }
            if(v_userNickname.length<3){
                v_erro+='-Conhecido por deve ter min. 3 caracteres.<br>';
            }
            if(v_userPhone.length<14){
                v_erro+='-Telefone deve ter min. 14 caracteres.<br>';
            }

            if(v_erro != ''){
                toastr["warning"](v_erro, "Atenção!");
            }else{

                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserAccess",
                    type: "POST",
                    dataType: "json",
                    data:
                        {
                            method: 'POST',
                            userName: v_userName,
                            userNickname: v_userNickname,
                            userPhone: v_userPhone,
                            userEmail: v_userEmail,
                            profileID: v_profileID,
                            customerID: v_customerID
                        },
                    success: function(d)
                    {
                        if(d.apiData.status === true)
                        {
                            toastr["success"]("Usuário "+v_userName+" inserido(a) com sucesso.", "Success");
                            $.docData.dtTable.ajax.reload();
                            $('#userModal').modal('hide');
                        }
                        else
                        {
                            toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                        }
                    }
                });
            }



        });


        $('.profileID').on('changed.bs.select', function (e, clickedIndex, newValue, oldValue) {
            let v_profileID = $(e.currentTarget).val();
            if(v_profileID == 3){
                $('#divCustomer').show();
            }else{
                $('#divCustomer').hide();
            }
        });

    });
</script>


