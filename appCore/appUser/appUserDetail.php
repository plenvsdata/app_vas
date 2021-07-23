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
    $v_avatarFolder = $GLOBALS['g_appRoot']."/__appFiles/".$_SESSION['userID']."/_userAvatar/".$v_userInfo['user_avatar'];
    if(!file_exists(__DIR__."/../../__appFiles/".$_SESSION['userID']."/_userAvatar/".$v_userInfo['user_avatar']))
    {
        $v_avatarFolder = $GLOBALS['g_appRoot']."/appImages/defaultImages/default_avatar.png";
    }
}else{
    $v_avatarFolder = $GLOBALS['g_appRoot']."/appImages/defaultImages/default_avatar.png";
}

//Combos
$v_comboData = new appCombo();
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
                <li class="breadcrumb-item"><a href="<?=$GLOBALS['g_appRoot']?>/Welcome">Home</a></li>
                <li class="breadcrumb-item">Configurações</li>
                <li class="breadcrumb-item"><a href="<?=$GLOBALS['g_appRoot']?>/System/Users">Usuário</a></li>
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
                                            <h4 class="modal-title">Add New Photo</h4>
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
                                                        <button id="userPhotoSave" type="button" class="btn btn-sm btn-success waves-effect waves-light">Adicionar Arquivo</button>
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
                                    <div class="col-md-3 col-xs-12 b-r">
                                        <strong class="userNameTitle">Nome completo
                                            <small>
                                                <i class="fa fa-pencil iconColor editUserNameTitle" data-title_id="<?=$v_userInfo['user_id']?>" aria-hidden="true"></i>
                                            </small>
                                        </strong>
                                        <br>
                                        <p class="text-muted userNameData"><?=$v_userInfo['user_name']?></p>
                                    </div>
                                    <div class="col-md-3 col-xs-12 b-r">
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


<script type="text/javascript">
    $.docData = {
        phoneCheck: false,
        zipCheck: false,
        phoneMask: null,
        divMaps: "<?=$v_addressMap?>",
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

    let v_zipmaskOptions =  {
        onComplete: function(zipcode) {
            $.docData.zipCheck = true;
            console.log("true");
        },
        onKeyPress: function(zipcode, event, currentField, v_zipmaskOptions){

            v_countryCode = $('.popover').find('.userAddressCountry option:selected').attr('data-area_code');
            v_zipcodeClean = String($('.popover').find('.userZipCode').cleanVal());
            $.docData.zipCheck = validateZipData(v_zipcodeClean,v_countryPhoneCode);
        },
        onChange: function(zipcode){
            //console.log('phone changed! ', phone);
        },
        onInvalid: function(val, e, f, invalid, v_zipmaskOptions){
            $.docData.zipCheck = false;
        }
    };

    function getCountryList(){
        let v_countryListPhone = "";
        let v_countryList = "";
        $.ajax( {
            url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboSystemCountry",
            method: "POST",
            data:{
                method : "POST",
                type : "json",
                randData: Math.floor((Math.random() * 999999) + 1)
            },
            dataType: "JSON",
            success:function(d)
            {
                $.each(d.rsData,function (i,v)
                {
                    v_countryListPhone += '<option value="'+v.country_id+'" data-country_code="'+v.country_code+'" data-phone_mask="'+v.phone_mask+'" data-area_code="'+v.country_phone_code+'">('+v.country_phone_code+') '+v.country_desc+'</option>';
                    v_countryList += '<option value="'+v.country_id+'"  data-country_code="'+v.country_code+'" data-zipcode_mask="'+v.zipcode_mask+'" data-area_code="'+v.country_phone_code+'" data-locale="'+v.locale+'">'+v.country_desc+'</option>';
                });
            },
            complete:function() {
                $.docData.countryListPhone = v_countryListPhone;
                $.docData.countryList = v_countryList;
            }
        });
    }

    function getStateList(countryID,stateID){
        let v_stateList = "";
        let v_stateSelect;
        if(typeof stateID === 'undefined')
        {
            v_stateSelect = null;
        }
        else
        {
            v_stateSelect = stateID;
        }

        if($.docData.stateLoad === true) {
            $.docData.stateLoad = false;
            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboSystemState",
                method: "POST",
                data: {
                    method: "POST",
                    type: "json",
                    countryID: countryID,
                    randData: Math.floor((Math.random() * 999999) + 1)
                },
                dataType: "JSON",
                success: function (d) {
                    $.each(d.rsData, function (i, v) {
                        v_stateList += '<option value="' + v.state_id + '" data-state_code="' + v.state_code + '">' + v.state_desc + '</option>';
                    });
                },
                complete: function () {
                    $.docData.stateLoad = true;
                    $('.popover').find('#stateID').empty().html(v_stateList);
                    if(v_stateSelect === null)
                    {
                        $('.popover').find('#stateID').prop('disabled', false).selectpicker({'title': 'Select State'}).selectpicker('render').selectpicker('refresh');
                    }
                    else
                    {
                        $('.popover').find('#stateID').prop('disabled', false);
                        $('.userAddressState').selectpicker('render').val(stateID).selectpicker('refresh');
                        $('.popover').find('.userAddressPlaceholderState').remove();
                    }
                }
            });
        }
    }

    function getCityList(stateID,cityID){
        let v_cityList = "";
        let v_citySelect;
        if(typeof cityID === 'undefined')
        {
            v_citySelect = null;
        }
        else
        {
            v_citySelect = cityID;
        }

        if(stateID === "") { return false; }

        if($.docData.cityLoad === true) {
            $.docData.cityLoad = false;
            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboSystemCity",
                method: "POST",
                data: {
                    method: "POST",
                    type: "json",
                    stateID: stateID,
                    randData: Math.floor((Math.random() * 999999) + 1)
                },
                dataType: "JSON",
                success: function (d) {
                    $.each(d.rsData, function (i, v) {
                        v_cityList += '<option value="' + v.city_id + '">' + v.city_desc + '</option>';
                    });
                },
                complete: function () {
                    $.docData.cityLoad = true;
                    $('.popover').find('#cityID').empty().html(v_cityList);
                    if(v_citySelect === null)
                    {
                        $('.popover').find('#cityID').prop('disabled', false).selectpicker({'title': 'Select City'}).selectpicker('render').selectpicker('refresh');
                    }
                    else
                    {
                        $('.popover').find('#cityID').prop('disabled', false);
                        $('.userAddressCity').selectpicker('render').val(cityID).selectpicker('refresh');
                        $('.popover').find('.userAddressPlaceholderCity').remove();
                    }


                }
            });
        }
    }

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

        //--Edit User
        $('.editUserNameTitle').popover({
            title: '<div style="width:100%!important;">Edit Full Name<i class="fa fa-times fa-pull-right iconColor popoverClose" aria-hidden="true"></i></div>',
            content : function()
            {
                $('.popover').popover('hide');
                $('.popover').remove();
                let v_userID = $('#userID').val();
                let v_userName = $(".userNameData").text();
                let v_return = '<div class="input-group">'+
                    '<input class="form-control newUserName" data-user_id="'+v_userID+'" style="width: 250px!important;" placeholder="New Full Name" value="'+v_userName+'">'+
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
                toastr["warning"](v_title+" too small. Fix it and try again.", "Attention!");
            }
            else
            {
                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserInfo",
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
                            toastr["success"](v_title+" " + v_userName + " updated.", "Success");
                            $('.userNameData').text(v_userName);
                            $('.txtName').text(v_userName);
                            $('.popover').popover('hide');
                        }
                        else {
                            toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                            $('.popover').popover('hide');
                        }
                    },
                    error: function () {
                        toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                        $('.popover').popover('hide');
                    }
                });
            }
        });

        $('.editNicknameTitle').popover({
            title: '<div style="width:100%!important;">Edit Nickname <i class="fa fa-times fa-pull-right iconColor popoverClose" aria-hidden="true"></i></div>',
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
            let v_userID = $('#userID').val();
            let v_nickname = $.trim($('.newNickname').val());
            let v_title = $('.nicknameTitle').text();

            if(v_nickname.length < 3)
            {
                toastr["warning"](v_title+" too small. Fix it and try again.", "Attention!");
            }
            else
            {
                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserInfo",
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
                            toastr["success"](v_title+" " + v_nickname + " updated.", "Success");
                            $('.nicknameData').text(v_nickname);
                            $('.popover').popover('hide');
                        }
                        else {
                            toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                            $('.popover').popover('hide');
                        }
                    },
                    error: function () {
                        toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                        $('.popover').popover('hide');
                    }
                });
            }
        });

        $('.editPhoneTitle').popover({
            title: '<div>Edit Mobile <i class="fa fa-times fa-pull-right iconColor popoverClose" aria-hidden="true"></i></div>',
            content : function()
            {
                $('.popover').popover('hide');
                $('.popover').remove();
                var v_userID = $('#userID').val();
                var v_phone = $(".phoneData").text();
                var v_return = '<div class="input-group">';
                v_return += '<select class="form-control custom-select userMobileCountry customBootstrapSelect" name="countryID" id="countryID" data-live-search="true" data-live-search-normalize="true" data-container="body">';
                v_return += $.docData.countryListPhone;
                v_return += '</select>';
                v_return += '</div>';
                v_return += '<div class="input-group">';
                v_return += '<input class="form-control newPhone" data-user_id="'+v_userID+'" placeholder="New Mobile" value="'+v_phone+'">'+
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
            let v_countryID_default = $(this).attr('data-mobile_country_id');
            $('.popover').find('#countryID').val(v_countryID_default);
            $('.contactAddressCountry').selectpicker();
            let v_phoneMask = $('.popover').find('#countryID option:selected').attr('data-phone_mask');
            $(".newPhone").mask(v_phoneMask);
        });

        $(document).on('change','#countryID',function() {
            $(".newPhone").val("");
            let v_phoneMask = $('.popover').find('#countryID option:selected').attr('data-phone_mask');
            $(".newPhone").mask(v_phoneMask);
        });

        $(document).on('click','.savePhone',function () {
            let v_userID = $('#userID').val();
            let v_phone = $.trim($('.newPhone').val());
            let v_title = $('.phoneTitle').text();
            let v_countryID = $("#countryID").val();
            let v_countryCode = $('.popover').find('#countryID option:selected').attr('data-area_code');

            if(v_phone.length < 3)
            {
                toastr["warning"](v_title+" too small. Fix it and try again.", "Attention!");
            }
            else
            {
                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserInfo",
                    type: "POST",
                    dataType: "json",
                    data:
                        {
                            method: "PUT",
                            userID: v_userID,
                            userData: v_phone,
                            mobileCountryID:  v_countryID,
                            dataControl : 'updUserPhone',
                        },
                    success: function (d) {
                        if (d.status === true) {
                            $('.popover').popover('hide');
                            toastr["success"](v_title+" " + v_phone + " updated.", "Success");
                            $('.phoneData').text(v_phone);
                            $('.phoneCode').text(v_countryCode+' ');
                            $('.editPhoneTitle').attr('data-mobile_country_id',v_countryID);
                            $('.editPhoneTitle').attr('data-title_id',v_phone);
                        }
                        else {
                            toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                            $('.popover').popover('hide');
                        }
                    },
                    error: function () {
                        toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                        $('.popover').popover('hide');
                    }
                });
            }
        });

        $(document).on('click', '.editGender', function () {

            $('.popover').popover('hide');
            $('.popover').remove();

            let v_userID = $('#userID').val();
            let v_genderID = $('.genderData').attr("data-gender_id");
            let v_content = "";
            let v_data;
            let v_popover = $(this);

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboSystemGender",
                method: "POST",
                data:{
                    method : "POST",
                    type : "json"
                },
                dataType: "JSON",
                success:function(d){
                    v_data = d;
                    v_content  = '<div class="input-group">';
                    v_content += '<input type="hidden" class="genderID" name="genderID" id="genderID" value="'+v_genderID+'">';
                    v_content += '<select class="form-control custom-select comboGenderData" style="width: 250px!important;" name="comboGenderData" id="comboGenderData">';

                    $.each(v_data.rsData,function (i,v)
                    {
                        v_content += '<option value="'+v.gender_id+'">'+v.gender_desc+'</option>';
                    });

                    v_content += '</select>';
                    v_content += '<div class="input-group-btn">';
                    v_content += '<button type="button" class="btn btn-success saveGender" style="height: 38px!important; width: 47px!important;">';
                    v_content += '<span class="fa fa-lg fa-check"></span>';
                    v_content += '</button>';
                    v_content += '</div>';
                    v_content += '</div>';

                    $("#popoverData").html(v_content);
                    $(v_popover).popover({
                        html: true,
                        title: '<div style="width:100%!important;">Edit Gender<i class="fa fa-times fa-pull-right iconColor popoverClose" aria-hidden="true"></i></div>',
                        container: 'body',
                        sanitize: false,
                        placement: 'top',
                        content: $("#popoverData").html(),
                        delay: 100
                    });
                    $.docData.periodPopover = true;
                    $(v_popover).popover('show');
                },
                complete:function()
                {
                    $(v_popover).on("shown.bs.popover",function (){
                        $('.comboGenderData').val(v_genderID);
                    });


                }
            });
        });

        $(document).on('click','.saveGender',function () {
            let v_userID = $('#userID').val();
            let v_genderID = $('.popover').find('.comboGenderData').val();
            $(".genderData").attr('data-gender_id',v_genderID);
            let v_popover = $('.popover');
            let v_genderTitleText = $.trim(v_popover.find('#comboGenderData option:selected').text());

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserInfo",
                type: "POST",
                dataType: "json",
                data: {
                    method: "PUT",
                    userID: v_userID,
                    userData: v_genderID,
                    dataControl : 'updUserGender'
                },
                success: function (d) {
                    if (d.status === true)
                    {
                        toastr["success"]("Gender " + v_genderTitleText + " updated.", "Success");
                        $('.genderData').text(v_genderTitleText);
                        $('.popover').popover('hide');
                    }
                    else {
                        toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                        $('.popover').popover('hide');
                    }
                },
                error: function () {
                    toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                    $('.popover').popover('hide');
                }
            });

        });

        $(document).on("click",'.editUserAddress',function(){

            let v_userID = $('#userID').val();
            let v_addressID = $(this).attr('data-address_id');
            let v_addressMain = 1;//$(this).attr('data-address_main');
            let v_countryID = $(this).attr('data-country_id');
            let v_stateID = $(this).attr('data-state_id');
            let v_cityID = $(this).attr('data-city_id');
            let v_fullAddress = $(this).attr('data-full_address');
            let v_complement = $(this).attr('data-complement');
            let v_zipCode = $(this).attr('data-zip_code');
            let v_popover = $(this);
            let v_content;
            $("#popoverData").empty();
            $('.popover').popover('hide');
            $('.popover').remove();

            v_content  = '<div class="input-group">';
            /*
            v_content += '<button type="button" class="btn btn-sm btn-light userMainAddress" style="height:38px!important;width:47px!important;" data-toggle="tooltip" data-placement="top" title="Set as Main Address">';
            v_content += '<span class="fa fa-lg ';

            if(parseInt(v_addressMain) === 0)
            {
                v_content += 'fa-star-o';
            }
            else
            {
                v_content += 'fa-star';
            }

            v_content += ' starAddress" style="color:#ffe821" data-main_address="'+v_addressMain+'"></span>';
            v_content += '</button>';
            */

            v_content += '<select class="form-control custom-select userAddressCountry customBootstrapSelect" style="display:none!important; " name="countryID" id="countryID" data-live-search="true" data-live-search-normalize="true" data-container="body" data-style="btn-ocsCountry">';
            v_content += $.docData.countryList;
            v_content += '</select>';
            v_content += '<button type="button" class="btn btn-success updateAddress" style="height:38px!important; width: 47px!important; border-radius: 0 5px 5px 0!important;">';
            v_content += '<span class="fa fa-lg fa-check"></span>';
            v_content += '</button>';
            v_content += '</div>';

            v_content += '<div class="input-group" style="margin-top:10px!important;width:100%!important;">';
            v_content += '<div class="col-md-6" style="padding-left: 0!important; padding-right:5px!important; height: 38px;!important;">';
            v_content += '<select class="form-control custom-select userAddressPlaceholderState" style="display:none!important;width:100%!important;" name="placeholderID" id="placeholderID" data-style="btn-ocsStateCity" data-title="Loading..." disabled></select>';
            v_content += '<select class="form-control custom-select userAddressState" style="display:none!important;width:100%!important;" name="stateID" id="stateID" data-live-search="true" data-live-search-normalize="true" data-container="body" data-style="btn-ocsStateCity" data-title="Select a State" disabled>';
            v_content += getStateList(v_countryID,v_stateID);
            v_content += '</select>';
            v_content += '</div>';
            v_content += '<div class="col-md-6" style="padding-right: 0!important; padding-left:5px!important;">';
            v_content += '<div style="height: 38px!important;">'
            v_content += '<select class="form-control custom-select userAddressPlaceholderCity" style="display:none!important;width:100%!important;" name="placeholderID" id="placeholderID" data-style="btn-ocsStateCity" data-title="Loading..." disabled></select>';
            v_content += '<select class="form-control custom-select userAddressCity" style="display:none!important;width:100%!important;" name="cityID" id="cityID" data-live-search="true" data-live-search-normalize="true" data-container="body" data-style="btn-ocsStateCity" data-title="Select a State first" disabled>';
            v_content += getCityList(v_stateID,v_cityID);
            v_content += '</select>';
            v_content += '</div>';
            v_content += '</div>';
            v_content += '</div>';

            v_content += '<div class="input-group" style="margin-top:10px!important;width:100%!important;">';
            v_content += '<div class="col-md-12" style="padding-left: 0!important; padding-right:0!important;">';
            v_content += '<input class="form-control userFullAddress" id="fullAddress" name="fullAddress" style="width:100%!important;" placeholder="Full Address" value="'+v_fullAddress+'">';
            v_content += '</div>';
            v_content += '</div>';

            v_content += '<div class="input-group" style="margin-top:10px!important;width:100%!important;">';
            v_content += '<div class="col-md-8" style="padding-left: 0!important; padding-right:5px!important;">';
            v_content += '<input class="form-control userAddressComplement" id="addressComplement" name="addressComplement" style="width:100%!important;" placeholder="Complement" value="'+v_complement+'">';
            v_content += '</div>';
            v_content += '<div class="col-md-4" style="padding-left: 5px!important; padding-right:0!important;">';
            v_content += '<input class="form-control userZipCode" id="zipCode" name="zipCode" style="width:100%!important;" placeholder="Zip Code" value="'+v_zipCode+'">';
            v_content += '<input type="hidden" id="addressID" name="addressID" value="'+v_addressID+'">';
            v_content += '<input type="hidden" id="userID" name="userID" value="'+v_userID+'">';
            v_content += '</div>';
            v_content += '</div>';

            $("#popoverData").html(v_content);
            $(v_popover).popover({
                html: true,
                title: '<div style="width:500px!important;">Edit Address<i class="fa fa-times fa-pull-right iconColor popoverClose" aria-hidden="true"></i></div>',
                container: 'body',
                sanitize: false,
                placement: 'top',
                content: $("#popoverData").html(),
                delay: 100
            });
            $(v_popover).on("shown.bs.popover",function (){
                $('.popover').find('.userAddressPlaceholderState').selectpicker('refresh');
                $('.popover').find('.userAddressPlaceholderCity').selectpicker('refresh');
                $('.userMainAddress').tooltip();
                $('.popover').find('#countryID').val(v_countryID).selectpicker('refresh');
                let v_zipMask = $('.popover').find('#countryID option:selected').attr('data-zipcode_mask');
                $('.userZipCode').mask(v_zipMask,v_zipmaskOptions);
            });

            $(v_popover).popover('show');

        });

        $(document).on('click','.updateAddress',function () {
            $('.popover').find('#zipCode').keyup();
            let v_userID = $('#userID').val();
            let v_addressID = $('#addressID').val();
            let v_userMainAddress = 1;//$('.popover').find('.starAddress').attr("data-main_address");
            let v_userCountryID = $('.popover').find('#countryID').val();
            let v_userCountryDesc = $.trim($('.popover').find('#countryID option:selected').text());
            let v_userCountryCode = $.trim($('.popover').find('#countryID option:selected').attr("data-country_code"));
            let v_userStateID = $('.popover').find('#stateID').selectpicker('val');
            let v_userStateDesc = $.trim($('.popover').find('#stateID option:selected').text());
            let v_userStateCode = $.trim($('.popover').find('#stateID option:selected').attr("data-state_code"));
            let v_userCityID = $('.popover').find('#cityID').selectpicker('val');
            let v_userCityDesc = $.trim($('.popover').find('#cityID option:selected').text());
            let v_userFullAddress = $('.popover').find('#fullAddress').val();
            let v_userAddressComplement = $('.popover').find('#addressComplement').val();
            let v_userZipCode = $('.popover').find('#zipCode').val();
            let v_mapAddress = v_userFullAddress.replace(/\ /g,'+')+','+v_userCityDesc.replace(/\ /g,'+')+'+'+v_userStateCode.replace(/\ /g,'+')+','+v_userCountryDesc.replace(/\ /g,'+');
            let v_countryCode = $('.popover').find('.userAddressCountry option:selected').attr('data-area_code');
            let v_zipcodeClean = String($('.popover').find('#zipCode').cleanVal());
            let v_addressInfo;

            $.docData.zipCheck = validateZipData(v_zipcodeClean,v_countryCode);

            if(v_userStateID === "")
            {
                toastr["warning"]("Select State and City", "Attention!");
            }
            else if(v_userCityID === "")
            {
                toastr["warning"]("Select City", "Attention!");
            }
            else if(v_userFullAddress.length < 5)
            {
                toastr["warning"]("Add a valid Address", "Attention!");
            }
            else if(!$.docData.zipCheck)
            {
                toastr["warning"]("Add a valid Zip Code", "Attention!");
            }
            else
            {
                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserAddress",
                    type: "POST",
                    dataType: "json",
                    data:
                        {
                            method: "PUT",
                            userID: v_userID,
                            addressID: v_addressID,
                            mainAddress: v_userMainAddress,
                            countryID: v_userCountryID,
                            countryDesc: v_userCountryDesc,
                            countryCode: v_userCountryCode,
                            stateID: v_userStateID,
                            stateDesc: v_userStateDesc,
                            stateCode: v_userStateCode,
                            cityID: v_userCityID,
                            cityDesc: v_userStateDesc,
                            fullAddress: v_userFullAddress,
                            complement: v_userAddressComplement,
                            zipCode: v_userZipCode
                        },
                    success: function (d) {

                        if(Boolean(d.updateStatus) === true)
                        {

                            $("div.addressDataInfo[data-address_id='"+v_addressID+ "']").remove();

                            v_addressInfo  = "<div class='addressDataInfo' data-address_id='"+v_addressID+"'>";
                            v_addressInfo += "<h6><small>";

                            if(parseInt(v_userMainAddress) === 1)
                            {
                                v_addressInfo += "<li class='fa fa-star ocsStar' data-toggle='tooltip' data-placement='top' title='Main Address'></li>";
                            }

                            v_addressInfo += "<span>"+v_userFullAddress+", "+v_userStateCode+" "+v_userZipCode+"</span>";
                            v_addressInfo += "&nbsp;<i class='fa fa-pencil iconColor editUserAddress' aria-hidden='true' data-address_id='"+v_addressID+"'  data-address_main='"+v_userMainAddress+"' data-country_id='"+v_userCountryID+"' data-state_id='"+v_userStateID+"' data-city_id='"+v_userCityID+"' data-full_address='"+v_userFullAddress+"' data-complement='"+v_userAddressComplement+"' data-zip_code='"+v_userZipCode+"'></i>&nbsp;";
                            //v_addressInfo += "<i class='fa fa-trash iconColor delUserAddress' aria-hidden='true' data-address_id='"+v_addressID+"'></i>&nbsp;";
                            v_addressInfo += "</small></h6>";
                            v_addressInfo += "<div class='map-box'>";
                            v_addressInfo += "<iframe src='"+$.docData.divMaps+v_mapAddress+"' width='100%' height='150' frameborder='0' style='border:0' allowfullscreen></iframe>";
                            v_addressInfo += "</div>";
                            v_addressInfo += "<hr>";
                            v_addressInfo += "</div>";

                            let v_addressQuantity = $("[class='addressDataInfo']").length;

                            if(v_addressQuantity < 1)
                            {
                                $(".appUserAddress").empty();
                                //$('.appUserAddress').append('<h6><small>No Address Available</small></h6>');
                            }

                            if(parseInt(v_userMainAddress) === 1)
                            {
                                if(v_addressQuantity > 1)
                                {
                                    $(".appUserAddress").prepend(v_addressInfo);
                                }
                                else
                                {
                                    $(".appUserAddress").append(v_addressInfo);
                                }

                            }
                            else
                            {
                                if(v_addressQuantity > 1)
                                {
                                    $(".appUserAddress div:last-child").after(v_addressInfo);
                                }
                                else
                                {
                                    $(".appUserAddress").append(v_addressInfo);
                                }
                            }

                            toastr["success"]("New Address added.", "Success");
                            $('.popover').popover('hide');
                        }
                        else {
                            toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                            $('.popover').popover('hide');
                        }
                    },
                    error: function () {
                        toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                        $('.popover').popover('hide');
                    }
                });
            }

        });

        $('.addUserSocial').on("click",function(){

            let v_userID = $('#userID').val();
            let v_popover = $(this);
            let v_content = "";
            let v_count = 0;
            $("#popoverData").empty();
            $('.popover').popover('hide');
            $('.popover').remove();

            $.ajax( {
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboSystemSocial",
                method: "POST",
                data:{
                    method : "POST",
                    type : "json",
                    userID: v_userID,
                    randData: Math.floor((Math.random() * 999999) + 1)
                },
                dataType: "JSON",
                success:function(d){
                    v_content  = '<div class="input-group">';
                    v_content += '<select class="form-control custom-select userSocialType" style="width:250px!important;" name="socialTypeID" id="socialTypeID">';


                    $.each(d.rsData,function (i,v)
                    {
                        v_socialCheck = $("."+v.social_icon).length;

                        if(v_socialCheck < 1)
                        {
                            v_count++;
                            v_content += '<option value="'+v.social_id+'" data-social_icon="'+v.social_icon+'">'+v.social_desc+'</option>';
                        }
                    });

                    v_content += '</select>';
                    v_content += '</div>';

                    v_content += '<div class="input-group" style="margin-top: 10px!important; width: 100%!important;">';
                    v_content += '<input class="form-control userSocialAddress" id="userSocialAddress" name="userSocialAddress" style="width: 250px!important;" placeholder="New Social Media" value="">';
                    v_content += '<div class="input-group-btn">';
                    v_content += '<button type="button" class="btn btn-success saveSocialMedia" style="height: 38px!important; width: 47px!important;">';
                    v_content += '<span class="fa fa-lg fa-check"></span>';
                    v_content += '</button>';
                    v_content += '</div>';
                    v_content += '</div>';

                    $("#popoverData").html(v_content);
                    $(v_popover).popover({
                        html: true,
                        title: '<div style="width:350px!important;">Add New Social Media<i class="fa fa-times fa-pull-right iconColor popoverClose" aria-hidden="true"></i></div>',
                        container: 'body',
                        sanitize: false,
                        placement: 'top',
                        content: $("#popoverData").html(),
                        delay: 100
                    });
                    if(v_count === 0)
                    {
                        toastr["warning"]("All types of Social Media already added.", "Attention!");
                        return false;
                    }

                    $(v_popover).popover('show');
                },
                complete:function()
                {
                    $(v_popover).on("shown.bs.popover",function (){

                    });
                }
            });
        });

        $(document).on('click','.saveSocialMedia',function () {
            let v_userID = $('#userID').val();
            let v_userSocialTypeID = $('.popover').find('.userSocialType').val();
            let v_userSocialAddress = $.trim($('.popover').find('#userSocialAddress').val());
            let v_userSocialType = $.trim($('.popover').find('#socialTypeID option:selected').text());
            let v_socialClass = v_userSocialType.toLowerCase();
            let v_userSocialIcon = $.trim($('.popover').find('#socialTypeID option:selected').attr('data-social_icon'));
            let v_socialInfo;

            if(!validator.isURL(v_userSocialAddress))
            {
                toastr["warning"]("Add a valid social media url", "Attention!");
            }
            else
            {
                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserSocial",
                    type: "POST",
                    dataType: "json",
                    data:
                        {
                            method: "POST",
                            userID: v_userID,
                            socialTypeID: v_userSocialTypeID,
                            socialAddress: v_userSocialAddress
                        },
                    success: function (d) {
                        if(Boolean(d.status) === true)
                        {
                            v_socialInfo  = '<div style="display:table-cell;padding:3px!important;position:relative;" class="socialDivData div_'+v_socialClass+'">';
                            v_socialInfo += '<a href="'+v_userSocialAddress+'" target="_blank" class="btn btn-circle btn-secondary socialMediaData">';
                            v_socialInfo += '<i class="fa '+v_userSocialIcon+'"></i></a>';
                            v_socialInfo += '<small class="pull-left"><i class="fa fa-trash iconColor userSocialDel pull-left" data-social_id="'+d.socialID+'" data-social_type="'+v_userSocialType+'" style="position: absolute; bottom:0!important;" aria-hidden="true"></i></small>';
                            v_socialInfo += '</div>';

                            if($(".socialDivData").length < 1)
                            {
                                $('.appUserSocial').empty();
                            }


                            $(".appUserSocial").append(v_socialInfo);
                            toastr["success"]("New Social Media added.", "Success");
                            $('.popover').popover('hide');
                        }
                        else {
                            toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                            $('.popover').popover('hide');
                        }
                    },
                    error: function () {
                        toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                        $('.popover').popover('hide');
                    }
                });
            }

        });

        $(document).on('click','.userSocialDel',function () {
            let v_userID = $('#userID').val();
            let v_socialID = $(this).attr('data-social_id');
            let v_socialDesc = $(this).attr('data-social_type');
            let v_socialClass = v_socialDesc.toLowerCase();

            bootbox.confirm({
                message: "Are you sure you want to remove <br/><h3 class='text-center'>"+v_socialDesc+"</h3>",
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
                            url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserSocial",
                            type: "POST",
                            dataType: "json",
                            data:
                                {
                                    method: "DELETE",
                                    userID: v_userID,
                                    socialID: v_socialID
                                },
                            success: function(d)
                            {
                                if(d.deleteStatus === true)
                                {
                                    $(".div_"+v_socialClass).remove();

                                    if($(".socialDivData").length < 1)
                                    {
                                        $('.appUserSocial').append('<h6><small>No Social Media Available</small></h6>');
                                    }

                                    toastr["success"](v_socialDesc+" removed.", "Success");
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

        $(document).on('click','.editPassword',function () {
            $('.popover').popover('hide');
            let v_userID = $('#userID').val();
            let v_userName = $('.userNameData').text();
            let v_userLogin = $('#userLogin').val();
            bootbox.dialog(
                {
                    title: 'User Password Reset',
                    message:
                        '<div class="row">'+
                        '<div class="col-md-12">Attention!</div>'+
                        '<div class="col-md-12">When click on confirm, the user\'s password will be reset and a new one will be send as a temporary password.</div>'+
                        '</div>',
                    buttons: {
                        confirm: {
                            label: 'Confirm',
                            className: 'btn-success',
                            callback: function ()
                            {
                                $.ajax({
                                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserPasswordReset",
                                    type: "POST",
                                    dataType: "json",
                                    data:
                                        {
                                            userID:v_userID,
                                            userName:v_userName,
                                            userLogin:v_userLogin,
                                            method:"POST"
                                        },
                                    success: function(d)
                                    {
                                        if(d.sendEmail === true)
                                        {
                                            toastr["success"]("Password updated.", "Success");
                                        }else{
                                            toastr["warning"]("Password can't be reset. Try again.", "Attention!");
                                        }

                                    },
                                    error: function(d)
                                    {
                                        toastr["warning"]("Password can't be reset. Try again.", "Attention!");
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
                                    toastr["warning"]("File is too big!<br>Max 10mb.", "Ooops!");
                                }else if(this.files.length > $.docData.maxFiles)
                                {
                                    toastr["warning"]("Only one photo allowed.", "Ooops!");
                                }
                                else
                                {
                                    toastr["warning"]("File type not allowed.", "Ooops!");
                                }
                                this.removeFile(file);
                            }
                        });

                        this.on('sending', function(file, xhr, formData)
                        {
                            var data = $('#formUserPhoto').serializeArray();
                            $.each(data, function(key, el) {
                                formData.append(el.name, el.value);
                            });
                        });

                        this.on('success', function(file,data)
                        {
                            let v_result = JSON.parse(data);

                            if(v_result.status === true)
                            {
                                var pathAvatar = '<?=$GLOBALS['g_appRoot']."/__appFiles/".$_SESSION['userClnt']."/_userAvatar/"?>'+v_result.file;
                                $("#avatarImg").css('background-image',"url("+pathAvatar+")");
                                $("#userAvatar").val(v_result.file);
                                $('#appAddUserPhoto').modal('hide');

                                toastr["success"]("Avatar updated.", "Success");
                            }
                            else
                            {
                                toastr["warning"]("Upload not possible. Please try again.", "Ooops!");
                            }
                        });

                        $('#userPhotoSave').on('click',function()
                        {
                            if (userPhotoDropzone.files.length>0) {
                                userPhotoDropzone.processQueue();
                            } else {
                                toastr["warning"]("Photo Required", "Ooops!");
                            }
                        });
                    }
                });
        }

        var userPhotoDropzone;
        $('#appAddUserPhoto').on('show.bs.modal', function (e) {
            userPhotoDropzone = dropzonePhotoCreate();
        });
        $('#appAddUserPhoto').on('hidden.bs.modal', function (e) {
            userPhotoDropzone.destroy();
            userPhotoDropzone = null;
        });

        const flatCalendar = $("#regUserBirthday").flatpickr({
            altInput: true,
            altFormat: "<?=$v_altFormat?>",
            dateFormat: "Y-m-d",
            maxDate: "today",
            allowInput: false,
            disableMobile: true,
            onClose: function(selectedDates, dateStr, instance){

                let v_userID = $('#userID').val();
                if($.docData.currentBirthday != dateStr){
                    $.ajax({
                        url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserInfo",
                        type: "POST",
                        dataType: "json",
                        data:
                            {
                                method: "PUT",
                                userID: v_userID,
                                userData: dateStr,
                                dataControl : 'updUserBirthday'
                            },
                        success: function (d) {
                            if (d.status === true) {
                                toastr["success"]("Birthday updated.", "Success");
                                $.docData.currentBirthday = dateStr;
                            }
                            else {
                                toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                            }
                        },
                        error: function () {
                            toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                        }
                    });
                }
            }
        });

        $(document).on('click','.editBirthday', function (){
            flatCalendar.toggle();
        });

        $(document).on('click','.closeBirthday', function (){

            bootbox.confirm({
                message: "Remove birthday info?",
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
                        flatCalendar.clear();
                        $.docData.currentBirthday = '';

                        let v_userID = $('#userID').val();
                        $.ajax({
                            url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserInfo",
                            type: "POST",
                            dataType: "json",
                            data:
                                {
                                    method: "PUT",
                                    userID: v_userID,
                                    userData: '',
                                    dataControl : 'updUserBirthday'
                                },
                            success: function (d) {
                                if (d.status === true) {
                                    toastr["success"]("Birthday updated.", "Success");
                                }
                                else {
                                    toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                                }
                            },
                            error: function () {
                                toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                            }
                        });
                    }
                }
            });

        });


    });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
