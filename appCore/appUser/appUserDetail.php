<?php /** @noinspection PhpUndefinedVariableInspection */

/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 31/01/2018
 * Time: 13:16
 */

use app\userAccess\userData\appUserData;
use app\System\Combo\appCombo;

$v_userID = !empty($_REQUEST['dataValue']) ? $_REQUEST['dataValue'] : null;

$v_formData['method'] = "ALL_INFO";
$v_formData['userID'] = $v_userID;

$v_apiData = new appUserData();
$v_userResult = $v_apiData->appUserAllInfo($v_formData);
$v_userInfo = $v_userResult['main']['rsData'][0];
if(!$v_userInfo)
{
    $_SESSION['sectionIDCheck'] = false;
    echo '<script>window.location="'.$GLOBALS['g_appRoot'].'/CRM/Users"</script>';
}

if(!empty($v_userInfo['user_avatar']) && ($v_userInfo['user_avatar']!='default_avatar.png')){
    $v_avatarFolder = $GLOBALS['g_appRoot']."/__appFiles/".$v_userID."/_userAvatar/".$v_userInfo['user_avatar'];
    if(!file_exists(__DIR__."/../../__appFiles/".$v_userID."/_userAvatar/".$v_userInfo['user_avatar']))
    {
        $v_avatarFolder = $GLOBALS['g_appRoot']."/appImages/defaultImages/default_avatar.png";
    }
}else{
    $v_avatarFolder = $GLOBALS['g_appRoot']."/appImages/defaultImages/default_avatar.png";
}
?>
<style>
    .iconColor
    {
        color: #99abb4!important;
        cursor: pointer;
    }
    .flex-item
    {
        justify-content: space-around;
    }
    .popover
    {
        max-width: 100%; /* Max Width of the popover (depending on the container!) */
    }
    .hidden
    {
        display: none!important;
    }
    .marketBtn
    {
        margin: 2px!important;
    }
    .btn-organizer
    {
        border: 1px solid #D9D9D9!important;
        height: 38px!important;
        background-color: #ffffff;
    }
    .ocsStar
    {
        color: #FFE821;
    }
    .ocsPhoneStar,.starAddress
    {
        color: #FFE821;
        background-color: !important;
        border: none !important;
    }

    .dropdown-menu .selected {
        color: #FFFFFF!important;
    }

    .dropdown-item.active {
        color: #FFFFFF!important;
    }

    a.dropdown-item.active {
        color: #FFFFFF!important;
    }

    a.dropdown-item.active:hover {
        color: #007bff!important;
    }

    .dropdown-menu.selected:hover {
        color: #007bff!important;
    }

    .dropdown-menu.show {
        border-radius: 0 0 0 0!important;
        border-top: 0!important;
        margin-top: -1px!important;

    }

    .btn-light
    {
        background-color: #FFFFFF!important;
        height: 38px!important;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 5px!important;
    }

    .btn-ocsCountry
    {
        background-color: #FFFFFF!important;
        height: 38px!important;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 5px 0 0 5px!important;
    }
    .btn-ocsCountryBox
    {
        width: 200px!important;
    }

    .btn-ocsStateCity
    {
        background-color: #FFFFFF!important;
        height: 38px!important;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 5px!important;
    }

    .userAddressCountry
    {
        border-width: 3px 3px 3px 3px;
    }
    #avatarImg{ cursor: pointer;}

    .profileAvatarImg{
        background-image: url("<?=$v_avatarFolder?>");
    }
    .profileAvatar .profileAvatarEdit{
        position: absolute;
        bottom:10px;
        right: 10px;
    }
    .profileAvatar{
        width: 200px;
        height: 200px;
        margin: auto!important;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
    }
    .flatpickr-input {
        background-color: #FFFFFF!important;
        border-collapse: collapse!important;
        border: none!important;
        padding-left: 0!important;
        color: #99ABB4!important;
    }
    .userMobileCountry {
        margin-bottom: 5px!important;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="<?=$GLOBALS['g_appRoot']?>/js/Plugins/flatpickr/css/ocs_vas_flatpickr_theme.css">
<div>
    <form action="appFormData">
        <input type="hidden" id="userID" value="<?=$v_userID?>">
    </form>
    <div class="row page-titles basicContent">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor userDetailTitle"><?=$v_userInfo['user_name']?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=$GLOBALS['g_appRoot']?>/MeuPerfil">Home</a></li>
                <li class="breadcrumb-item">Configurações</li>
                <li class="breadcrumb-item"><a href="<?=$GLOBALS['g_appRoot']?>/System/Users">Usuários</a></li>
                <li class="breadcrumb-item active">Detalhes do Usuário</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid basicContent">
        <div class="row">
            <div class="col-lg-4 col-xlg-3 col-md-5 pds_padding-right">
                <div class="card">
                    <div class="card-body">
                        <div class="m-t-30 text-center">
                            <div id="appAddUserPhoto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="New Photo" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Adicionar Foto</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="modal-body">
                                                <form id="formUserPhoto" name="formUserPhoto"  method="post" enctype="multipart/form-data" >
                                                    <input type="hidden" id="userID" name="userID" value="<?=$v_userID?>">
                                                    <input type="hidden" id="userLogin" name="userLogin" value="<?=$v_userInfo['user_login']?>">
                                                    <input type="hidden" id="userAvatar" name="userAvatar" value="<?=$v_userInfo['user_avatar']?>">
                                                    <input type="hidden" id="method" name="method" value="PUT">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <div class="dropzone" id="userPhotoDropzone" style="border-radius: 15px!important; border: dashed 1px; text-align: center!important;">
                                                                <div class="dz-message" data-dz-message><span><?=$GLOBALS['g_dropZoneDefaultMessage']?></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button id="userPhotoCancel" type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Cancelar</button>
                                                        <button id="userPhotoSave" type="button" class="btn btn-sm btn-success waves-effect waves-light">Adicionar arquivo</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="avatarImg" class="img-circle profileAvatar profileAvatarImg" data-toggle="modal" data-target="#appAddUserPhoto">
                                <i class="fa fa-camera iconColor profileAvatarEdit" aria-hidden="true"></i>
                            </div>

                            <h4 class="card-title m-t-10 txtName"><?=$v_userInfo['user_name']?></h4>
                            <h6 class="card-subtitle"><?=$v_userInfo['access_profile_desc']?></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-xlg-9 col-md-7 pds_padding-left">
                <div class="card">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs profile-tab" role="tablist">
                        <li class="nav-item"> <a class="nav-link tabProfile active" data-toggle="tab" href="#profile" role="tab">Perfil</a> </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile" role="tabpanel">
                            <div class="card-body">
                                <div class="row m-t-30">
                                    <div class="col-md-6 col-xs-12 b-r">
                                        <strong class="userNameTitle">Nome completo
                                            <small>
                                                <i class="fa fa-pencil iconColor editUserNameTitle" data-title_id="<?=$v_userInfo['user_id']?>" aria-hidden="true"></i>
                                            </small>
                                        </strong>
                                        <br>
                                        <p class="text-muted userNameData"><?=$v_userInfo['user_name']?></p>
                                    </div>
                                    <div class="col-md-6 col-xs-12 b-r">
                                        <strong class="nicknameTitle">Conhecido por
                                            <small>
                                                <i class="fa fa-pencil iconColor editNicknameTitle" data-title_id="<?=$v_userInfo['user_id']?>" aria-hidden="true"></i>
                                            </small>
                                        </strong>
                                        <br>
                                        <p class="text-muted nicknameData"><?=$v_userInfo['user_nickname']?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row m-t-30">
                                    <div class="col-md-5 col-xs-12 b-r">
                                        <strong class="Title">Email
                                            <small>

                                            </small>
                                        </strong>
                                        <br>
                                        <p class="text-muted userTitleData"><?=$v_userInfo['user_login']?></p>
                                    </div>
                                    <div class="col-md-4 col-xs-12 b-r">
                                        <strong class="phoneTitle">Telefone
                                            <small>
                                                <i class="fa fa-pencil iconColor editPhoneTitle" data-mobile_country_id="" data-title_id="<?=$v_userInfo['user_phone']?>" aria-hidden="true"></i>
                                            </small>
                                        </strong>
                                        <br>
                                        <span class="text-muted phoneCode"> </span><span class="text-muted phoneData"><?=$v_userInfo['user_phone']?></span>
                                    </div>
                                    <div class="col-md-3 col-xs-12 b-r">
                                        <strong class="nameTitle">Senha
                                            <small>
                                                <i class="fa fa-pencil iconColor editPassword" aria-hidden="true"></i>
                                            </small>
                                        </strong>
                                        <br>
                                        <p>* * * * * * * * * *</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="popoverData" style="display: none"></div>
<!-- Modal Password-->
<div class="form-content" style="display:none;">
    <form class="form" role="form">
        <div class="form-group has-feedback curPwdDiv" id="curPwdDiv">
            <label for="curPwd">Senha Atual</label>
            <input type="password" class="form-control" id="curPwd" name="curPwd" placeholder="Senha Atual">
        </div>
        <div class="form-group has-feedback newPwdDiv" id="newPwdDiv">
            <label for="newPwd">Senha Nova<span class="newPwdLabel text-danger hidden"></span></label><br>
            <input type="password" class="form-control" id="newPwd" name="newPwd" placeholder="Senha Nova" aria-describedby="newPwdStatus">
            <span class="glyphicon glyphicon-ok form-control-feedback"  style="margin-left: -180px!important;"></span>
            <span id="newPwdStatus" class="sr-only">(success)</span>
        </div>
        <div class="form-group has-feedback rePwdDiv" id="rePwdDiv">
            <label for="rePwd">Confirme Senha</label>
            <input type="password" class="form-control" id="rePwd" name="rePwd" placeholder="Confirme Senha" aria-describedby="rePwdStatus"><br>
            <span class="glyphicon glyphicon-ok form-control-feedback"  style="margin-left: -180px!important;"></span>
            <span id="rePwdStatus" class="sr-only">(success)</span>
        </div>
    </form>
</div>
<!-- End Modal Password-->

<script type="text/javascript">
    $.docData = {
        phoneCheck: false,
        zipCheck: false,
        phoneMask: null,
        maxFiles:1,
    };

    let v_phoneClean,v_countryID,v_countryPhoneCode,v_zipcodeClean,v_countryCode;

    let v_maskOptions =  {
        onComplete: function(phone) {
            $.docData.phoneCheck = true;
        },
        onKeyPress: function(phone, event, currentField, v_maskOptions){

            v_phoneClean = String($('.popover').find('#userNewPhone').cleanVal());
            v_countryID = $('.popover').find('#phoneCountryID option:selected').val();
            v_countryPhoneCode = $('.popover').find('#phoneCountryID option:selected').attr('data-area_code');

            if(parseInt(v_countryID) === 3 && v_phoneClean.length > 2)
            {
                if(v_phoneClean.charAt(2) === '9')
                {
                    $('.popover').find('#userNewPhone').mask("(00) 00000-0000",v_maskOptions);
                }
                else
                {
                    $('.popover').find('#userNewPhone').mask("(00) 0000-0000",v_maskOptions);
                }
            }
            $.docData.phoneCheck = validatePhoneData(v_phoneClean,v_countryPhoneCode);
        },
        onChange: function(phone){
            //console.log('phone changed! ', phone);
        },
        onInvalid: function(val, e, f, invalid, v_maskOptions){
            $.docData.phoneCheck = false;
            console.log("false");
        }
    };

    $(document).ready(function () {

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        $(document).on('click','.popoverClose',function () {
            $('.popover').popover('hide');
        });

        $(".popoverOCS").on('show.bs.popover',function(){
            $(".popover").css("width","100%!important");
        });

        $('.editUserNameTitle').popover({
            title: '<div style="width:100%!important;">Editar Nome Completo<i class="fa fa-times fa-pull-right iconColor popoverClose" aria-hidden="true"></i></div>',
            content : function()
            {
                $('.popover').popover('hide');
                $('.popover').remove();
                let v_userID = $('#userID').val();
                let v_userName = $(".userNameData").text();
                let v_return = '<div class="input-group">'+
                    '<input class="form-control newUserName" data-user_id="'+v_userID+'" style="width: 250px!important;" placeholder="Novo Nome Completo" value="'+v_userName+'">'+
                    '<div class="input-group-btn">'+
                    '<button type="button" class="btn btn-success saveUserName" style="height: 38px!important;">'+
                    '<span class="fa fa-lg fa-check"></span>'+
                    '</button>'+
                    '</div>'+
                    '</div>';
                return v_return;
            },
            html: true,
            placement: 'top',
            trigger: 'click',
            container: 'body',
            sanitize: false
        });

        $(document).on('click','.saveUserName',function () {
            let v_userID = $('#userID').val();
            let v_userName = $.trim($('.newUserName').val());
            let v_title = $('.userNameTitle').text();

            if(v_userName.length < 3)
            {
                toastr["warning"](v_title+" muito curto. Ajuste e tente novamente.", "Atenção!");
            }
            else
            {
                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserAccess",
                    type: "POST",
                    dataType: "json",
                    data:
                        {
                            method: "PUT",
                            userID: v_userID,
                            userData: v_userName,
                            dataControl : 'updUserName'
                        },
                    success: function (d) {
                        if (d.status === true) {
                            toastr["success"](v_title+" " + v_userName + " atualizado.", "Sucesso");
                            $('.userNameData').text(v_userName);
                            $('.txtName').text(v_userName);
                            $(".userDetailTitle").html(v_userName);
                            $('.popover').popover('hide');

                        }
                        else {
                            toastr["error"]("Ocorreu um erro. Tente novamente.", "Erro!");
                            $('.popover').popover('hide');
                        }
                    },
                    error: function () {
                        toastr["error"]("Ocorreu um erro. Tente novamente.", "Erro!");
                        $('.popover').popover('hide');
                    }
                });
            }
        });

        $('.editNicknameTitle').popover({
            title: '<div style="width:100%!important;">Editar Conhecido por <i class="fa fa-times fa-pull-right iconColor popoverClose" aria-hidden="true"></i></div>',
            content : function()
            {
                $('.popover').popover('hide');
                $('.popover').remove();
                let v_userID = $('#userID').val();
                let v_nickname = $(".nicknameData").text();
                let v_return = '<div class="input-group">'+
                    '<input class="form-control newNickname" data-user_id="'+v_userID+'" style="width: 250px!important;" placeholder="New Nickname" value="'+v_nickname+'">'+
                    '<div class="input-group-btn">'+
                    '<button type="button" class="btn btn-success saveNickname" style="height: 38px!important;">'+
                    '<span class="fa fa-lg fa-check"></span>'+
                    '</button>'+
                    '</div>'+
                    '</div>';
                return v_return;
            },
            html: true,
            placement: 'top',
            trigger: 'click',
            container: 'body',
            sanitize: false
        });

        $(document).on('click','.saveNickname',function () {
            var v_userID = $('#userID').val();
            var v_nickname = $.trim($('.newNickname').val());
            var v_title = $('.nicknameTitle').text();

            if(v_nickname.length < 3)
            {
                toastr["warning"](v_title+" muito curto. Ajuste e tente novamente.", "Atenção!");
            }
            else
            {
                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserAccess",
                    type: "POST",
                    dataType: "json",
                    data:
                        {
                            method: "PUT",
                            userID: v_userID,
                            userData: v_nickname,
                            dataControl : 'updUserNickname'
                        },
                    success: function (d) {
                        if (d.status === true) {
                            toastr["success"](v_title+" " + v_nickname + " atualizado.", "Sucesso");
                            $('.nicknameData').text(v_nickname);
                            $('.popover').popover('hide');
                        }
                        else {
                            toastr["error"]("Ocorreu um erro. Tente novamente.", "Erro!");
                            $('.popover').popover('hide');
                        }
                    },
                    error: function () {
                        toastr["error"]("Ocorreu um erro. Tente novamente.", "Erro!");
                        $('.popover').popover('hide');
                    }
                });
            }
        });

        $('.editPhoneTitle').popover({
            title: '<div>Editar Telefone<i class="fa fa-times fa-pull-right iconColor popoverClose" aria-hidden="true"></i></div>',
            content : function()
            {
                $('.popover').popover('hide');
                $('.popover').remove();
                let v_userID = $('#userID').val();
                let v_phone = $(".phoneData").text();
                let v_return  = '<div class="input-group">';
                v_return += '<input class="form-control newPhone" data-user_id="'+v_userID+'" placeholder="Novo Telefone" value="'+v_phone+'">'+
                    '<div class="input-group-btn">'+
                    '<button type="button" class="btn btn-success savePhone" style="height: 38px!important;">'+
                    '<span class="fa fa-lg fa-check"></span>'+
                    '</button>'+
                    '</div>'+
                    '</div>';
                return v_return;

            },
            html: true,
            placement: 'top',
            trigger: 'click',
            container: 'body',
            sanitize: false
        });

        $('.editPhoneTitle').on("shown.bs.popover",function (){
            $(".newPhone").mask('(00) 00000-0000');
        });

        $(document).on('click','.savePhone',function () {
            let v_userID = $('#userID').val();
            let v_phone = $.trim($('.newPhone').val());
            let v_title = $('.phoneTitle').text();

            if(v_phone.length < 3)
            {
                toastr["warning"](v_title+" muito curto. Corrija e tente novamente.", "Atenção!");
            }
            else
            {
                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserAccess",
                    type: "POST",
                    dataType: "json",
                    data:
                        {
                            method: "PUT",
                            userID: v_userID,
                            userData: v_phone,
                            dataControl : 'updUserPhone',
                        },
                    success: function (d) {
                        if (d.status === true) {
                            $('.popover').popover('hide');
                            toastr["success"](v_title+" " + v_phone + " atualizado.", "Sucesso");
                            $('.phoneData').text(v_phone);
                            $('.editPhoneTitle').attr('data-title_id',v_phone);
                        }
                        else {
                            toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                            $('.popover').popover('hide');
                        }
                    },
                    error: function () {
                        toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                        $('.popover').popover('hide');
                    }
                });
            }
        });

        $(document).on('keypress',"#curPwd",function(e)
        {
            var v_key = e.keyCode;
            if (v_key === 32){
                e.preventDefault();
            }
        });

        $(document).on('keypress',"#newPwd",function(e)
        {
            var v_key = e.keyCode;
            if (v_key === 32){
                e.preventDefault();
            }
        });
        $(document).on('keypress',"#rePwd",function(e)
        {
            var v_key = e.keyCode;
            if (v_key === 32){
                e.preventDefault();
            }
        });

        $(document).on('click','.editPassword',function () {
            $('.popover').popover('hide');
            let v_userID = $('#userID').val();
            let v_userName = $('.userNameData').text();
            let v_userLogin = $('#userLogin').val();
            let modal = bootbox.dialog({
                title: "Editar Senha",
                message: $(".form-content").html(),
                buttons: [
                    {
                        label: "Salvar",
                        className: "btn btn-sm btn-success pull-left",
                        callback: function()
                        {
                            let form = modal.find(".form");
                            let v_curPwd = modal.find("#curPwd").val();
                            let v_newPwd = modal.find("#newPwd").val();
                            let v_rePwd = modal.find("#rePwd").val();
                            let v_erroCurPwd = false;
                            let v_erroNewPwd = false;
                            // Validate lowercase letters
                            let lowerCaseLetters = /[a-z]/g;
                            let upperCaseLetters = /[A-Z]/g;
                            let numbers = /[0-9]/g;
                            let specialChars = /[!@#$%&*?]/g;
                            if(!v_curPwd.match(lowerCaseLetters) || !v_curPwd.match(upperCaseLetters) || !v_curPwd.match(numbers) || !v_curPwd.match(specialChars) || v_curPwd.length<8) {
                                v_erroCurPwd = true;
                                $(".curPwdDiv").addClass('has-danger');
                                toastr["warning"]("A senha atual deve conter pelo menos uma letra maiúscula, uma letra minúscula, um número, um char. especial e 8 ou mais caracteres.", "Atenção!");
                            }else{
                                $(".curPwdDiv").removeClass('has-danger');
                            }

                            if(v_newPwd != v_rePwd)
                            {
                                toastr["warning"]("A Nova Senha e Confirme a Senha devem ser iguais.", "Atenção!");
                                $(".newPwdDiv").addClass('has-danger');
                                v_erroNewPwd = true;
                            }else if(!v_newPwd.match(lowerCaseLetters) || !v_newPwd.match(upperCaseLetters) || !v_newPwd.match(numbers) || !v_newPwd.match(specialChars) || v_newPwd.length<8){
                                toastr["warning"]("A senha atual deve conter pelo menos uma letra maiúscula, uma letra minúscula, um número, um char. especial e 8 ou mais caracteres.", "Atenção!");
                                $(".newPwdDiv").addClass('has-danger');
                                v_erroNewPwd = true;
                            }else{
                                $(".newPwdDiv").removeClass('has-danger');
                            }

                            if(v_erroCurPwd===true || v_erroNewPwd===true)
                            {
                                return false;
                            }
                            //alert('enviar ajax');return false;
                            $.ajax( {
                                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserChangePassword",
                                method: "POST",
                                data:{
                                    method : "POST",
                                    type : "json",
                                    userID : v_userID,
                                    curPwd : v_curPwd,
                                    newPwd : v_newPwd
                                },
                                dataType: "JSON",
                                success:function(d)
                                {
                                    if(d.updateStatus===true)
                                    {
                                        toastr["success"]("Senha atualizada.", "Sucesso!");
                                        modal.modal("hide");
                                    }else{
                                        if(d.msg == 'erro_pwd')
                                        {
                                            $(".curPwdDiv").addClass('has-danger');
                                            toastr["warning"]("Senha atual incorreta.", "Atenção!");
                                        }else if(d.msg == 'erro_format')
                                        {
                                            toastr["warning"]("A Nova Senha atual deve conter pelo menos uma letra maiúscula, uma letra minúscula, um número, um char. especial e 8 ou mais caracteres.", "Atenção!");
                                            $(".newPwdDiv").addClass('has-danger');
                                        }
                                    }
                                },
                                complete:function() {

                                }
                            });
                            return false;
                        }
                    },
                    {
                        label: "Fechar",
                        className: "btn btn-sm btn-danger pull-left",
                        callback: function() {
                            $(".curPwdDiv").removeClass('has-danger');
                            $(".newPwdDiv").removeClass('has-danger');
                        }

                    }
                ],
                show: false,
                onEscape: function() {
                    $(".curPwdDiv").removeClass('has-danger');
                    $(".newPwdDiv").removeClass('has-danger');
                    modal.modal("hide");
                }
            });

            modal.modal("show");
        });

        let userPhotoDropzone;

        function dropzonePhotoCreate(){
            return new Dropzone("#userPhotoDropzone",
                {
                    paramName: "fileData", // The name that will be used to transfer the file
                    maxFilesize: 10, // MB
                    acceptedFiles: ".jpg,.jpeg,.png",
                    uploadMultiple: false,
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserPhoto",
                    method: 'POST',
                    autoProcessQueue: false,
                    maxFiles: $.docData.maxFiles,
                    init: function()
                    {
                        this.on("error", function(file)
                        {
                            if(!file.accepted)
                            {
                                if(file.size > (1024 * 1024 * 10))//10MB
                                {
                                    toastr["warning"]("Arquivo muito grande!<br>Max 10mb.", "Atenção!");
                                }else if(this.files.length > $.docData.maxFiles)
                                {
                                    toastr["warning"]("Só é permitido enviar uma foto.", "Atenção!");
                                }
                                else
                                {
                                    toastr["warning"]("Tipo de arquivo não permitido.", "Atenção!");
                                }
                                this.removeFile(file);
                            }
                        });

                        this.on('sending', function(file, xhr, formData)
                        {
                            let data = $('#formUserPhoto').serializeArray();
                            $.each(data, function(key, el) {
                                formData.append(el.name, el.value);
                            });
                        });

                        this.on('success', function(file,data)
                        {
                            let v_result = JSON.parse(data);
                            console.log(data);
                            console.log(v_result);
                            if(v_result.status === true)
                            {
                                let pathAvatar = '<?=$GLOBALS['g_appRoot']."/__appFiles/".$v_userID."/_userAvatar/"?>'+v_result.file;
                                $("#avatarImg").css('background-image',"url("+pathAvatar+")");
                                //$("#profilePic").css('background-image',"url("+pathAvatar+")");
                                //$("#profilePic2").css('background-image',"url("+pathAvatar+")");
                                $("#userAvatar").val(v_result.file);
                                $('#appAddUserPhoto').modal('hide');
                                $.docData.tourAvatar = 1;
                                toastr["success"]("Avatar atualizado.", "Sucesso");
                            }
                            else
                            {
                                toastr["warning"]("Erro no envio do arquivo. Tente novamente.", "Atenção!");
                            }
                        });

                        $('#userPhotoSave').on('click',function()
                        {
                            if (userPhotoDropzone.files.length>0) {
                                userPhotoDropzone.processQueue();
                            } else {
                                toastr["warning"]("Foto obrigatória!", "Atenção!");
                            }
                        });
                    }
                });
        }

        $('#appAddUserPhoto').on('show.bs.modal', function (e) {
            userPhotoDropzone = dropzonePhotoCreate();
        });

        $('#appAddUserPhoto').on('hidden.bs.modal', function (e) {
            userPhotoDropzone.destroy();
            userPhotoDropzone = null;
        });
    });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
