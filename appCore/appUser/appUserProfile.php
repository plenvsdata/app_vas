<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 31/01/2018
 * Time: 13:16
 */
use app\userAccess\userData\appUserData;
//use app\System\Combo\appCombo;

$v_userID = $_SESSION['userID'];
$v_formData['method'] = "ALL_INFO";
$v_formData['userID'] = $v_userID;

$v_apiData = new appUserData();
$v_userResult = $v_apiData->appUserAllInfo($v_formData);
$v_userInfo = $v_userResult['main']['rsData'][0];
$v_altFormat ='d/m/Y';


if(!empty($v_userInfo['user_avatar']) && ($v_userInfo['user_avatar']!='default_avatar.png')){
    $v_avatarFolder = $GLOBALS['g_appRoot']."/__appFiles/".$_SESSION['userClnt']."/_userAvatar/".$v_userInfo['user_avatar'];
    if(!file_exists(__DIR__."/../../__appFiles/".$_SESSION['userClnt']."/_userAvatar/".$v_userInfo['user_avatar']))
    {
        $v_avatarFolder = $GLOBALS['g_appRoot']."/appImages/defaultImages/default_avatar.png";
    }
    $v_tourAvatar = 1;
}else{
    $v_avatarFolder = $GLOBALS['g_appRoot']."/appImages/defaultImages/default_avatar.png";
    $v_tourAvatar = 0;
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
    .bootbox .modal-header h4 {
        order: 0;
    }
    .bootbox .modal-header button {
        order: 1;
    }
    #avatarImg{ cursor: pointer;}
    .profileAvatar{
        width: 200px;
        height: 200px;
        margin: auto!important;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
    }
    .profileAvatarImg{
        background-image: url("<?=$v_avatarFolder?>");
    }
    .profileAvatar .profileAvatarEdit{
        position: absolute;
        bottom:10px;
        right: 10px;
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
<link rel="stylesheet" type="text/css" href="<?=$GLOBALS['g_appRoot']?>/js/Plugins/hopscotch-master/css/hopscotch.css">
<script type="text/javascript" src="<?=$GLOBALS['g_appRoot']?>/js/Plugins/hopscotch-master/js/hopscotch.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="<?=$GLOBALS['g_appRoot']?>/js/Plugins/flatpickr/css/ocs_plenvs_flatpickr_theme.css">
<div>
    <div class="row page-titles basicContent">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor userDetailTitle"><? if($_SESSION['firstAccess']==1){echo 'Welcome '; }?><?=$v_userInfo['user_name']?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <? if($_SESSION['firstAccess']==1){?>
                    <li class="breadcrumb-item"><a href="<?=$GLOBALS['g_appRoot']?>/MyProfile">MyProfile</a></li>
                <? }else{?>
                    <li class="breadcrumb-item"><a href="<?=$GLOBALS['g_appRoot']?>/Welcome">Home</a></li>
                    <li class="breadcrumb-item active">Meu Perfil</li>
                <?}?>

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
                                                        <button id="userPhotoCancel" type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Cancel</button>
                                                        <button id="userPhotoSave" type="button" class="btn btn-sm btn-success waves-effect waves-light">Add File</button>
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
                    <div><hr></div>
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
<!-- Modal Password-->
<div class="form-content" style="display:none;">
    <form class="form" role="form">
        <div class="form-group has-feedback curPwdDiv" id="curPwdDiv">
            <label for="curPwd">Current Password</label>
            <input type="password" class="form-control" id="curPwd" name="curPwd" placeholder="Current Password">
        </div>
        <div class="form-group has-feedback newPwdDiv" id="newPwdDiv">
            <label for="newPwd">New Password <span class="newPwdLabel text-danger hidden"><small>(min 2 characters)</small></span></label><br>
            <input type="password" class="form-control" id="newPwd" name="newPwd" placeholder="New Password" aria-describedby="newPwdStatus">
            <span class="glyphicon glyphicon-ok form-control-feedback"  style="margin-left: -180px!important;"></span>
            <span id="newPwdStatus" class="sr-only">(success)</span>
        </div>
        <div class="form-group has-feedback rePwdDiv" id="rePwdDiv">
            <label for="rePwd">Confirm Password</label>
            <input type="password" class="form-control" id="rePwd" name="rePwd" placeholder="Confirm Password" aria-describedby="rePwdStatus"><br>
            <span class="glyphicon glyphicon-ok form-control-feedback"  style="margin-left: -180px!important;"></span>
            <span id="rePwdStatus" class="sr-only">(success)</span>
        </div>
    </form>
</div>
<!-- End Modal Password-->

<script type="text/javascript">
    $.docData = {
        countryListPhone : null,
        phoneCheck: false,
        zipCheck: false,
        phoneMask: null,
        stateLoad: true,
        maxFiles:1,
        firsAccess:<?=$_SESSION['firstAccess']?>,
        tour:null,
        tourAvatar: '<?=$v_tourAvatar?>'
    };

    var v_phoneClean,v_countryID,v_countryPhoneCode,v_zipcodeClean,v_countryCode;

    var v_maskOptions =  {
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

    var v_zipmaskOptions =  {
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

    function Revealer() {
        var OVERLAY_ZINDEX = 999;
        var OVERLAY_BACKGROUND = 'rgba(0,0,0,0.5)';

        var $overlay, $prevTarget, $currTarget;

        function overlay() {
            if ($overlay) {
                return $overlay;
            }
            $overlay = $('<div>');
            var $prevTarget, $currTarget;
            $overlay.css({
                zIndex:     OVERLAY_ZINDEX,
                background: OVERLAY_BACKGROUND,
                position:   'fixed',
                display:    'none',
                top:        0,
                right:      0,
                bottom:     0,
                left:       0
            });
            $(document.body).append($overlay);
            return $overlay;
        }

        function cleanupPrevTarget() {
            if ($prevTarget) {
                $prevTarget.css({
                    position: '',
                    zIndex:   ''
                });
            }
            $prevTarget = null;
        }

        function hide() {
            overlay().fadeOut();
            cleanupPrevTarget();
        }

        function reveal(target) {
            cleanupPrevTarget();
            overlay().fadeIn();
            if (target) {
                $currTarget = $(target);
                // make sure the target node's `position` behaves with `z-index` correctly
                var position = $currTarget.css('position')
                if (!/^(?:absolute|fixed|relative)$/.test(position)) {
                    position = 'relative';
                }
                $currTarget.css({
                    position: position,
                    zIndex:   OVERLAY_ZINDEX + 1
                });
                $prevTarget = $currTarget;
            }
        }

        return {
            reveal: reveal,
            hide: hide
        };
    }

    $(document).ready(function ()
    {
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
            title: '<div style="width:100%!important;">Edit Full Name<i class="fa fa-times fa-pull-right iconColor popoverClose" aria-hidden="true"></i></div>',
            content : function()
            {
                $('.popover').popover('hide');
                $('.popover').remove();
                var v_userID = $('#userID').val();
                var v_userName = $(".userNameData").text();
                var v_return = '<div class="input-group">'+
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
            var v_userID = $('#userID').val();
            var v_userName = $.trim($('.newUserName').val());
            var v_title = $('.userNameTitle').text();

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
                var v_userID = $('#userID').val();
                var v_nickname = $(".nicknameData").text();
                var v_return = '<div class="input-group">'+
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
            $('.userMobileCountry').selectpicker();
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
            var v_userID = $('#userID').val();
            var v_userName = $('.userNameData').text();
            var v_userLogin = $('#userLogin').val();
            var modal = bootbox.dialog({
                title: "Change Password",
                message: $(".form-content").html(),
                buttons: [
                    {
                        label: "Save",
                        className: "btn btn-sm btn-success pull-left",
                        callback: function()
                        {

                            var form = modal.find(".form");
                            var v_curPwd = modal.find("#curPwd").val();
                            var v_newPwd = modal.find("#newPwd").val();
                            var v_rePwd = modal.find("#rePwd").val();
                            var v_erroCurPwd = false;
                            var v_erroNewPwd = false;
                            // Validate lowercase letters
                            var lowerCaseLetters = /[a-z]/g;
                            var upperCaseLetters = /[A-Z]/g;
                            var numbers = /[0-9]/g;
                            var specialChars = /[!@#$%&*?]/g;
                            if(!v_curPwd.match(lowerCaseLetters) || !v_curPwd.match(upperCaseLetters) || !v_curPwd.match(numbers) || !v_curPwd.match(specialChars) || v_curPwd.length<8) {
                                v_erroCurPwd = true;
                                $(".curPwdDiv").addClass('has-danger');
                                toastr["warning"]("Current Password must contain at least one number and one uppercase and one lowercase letter and one special char, and at least 8 or more characters.", "Attention!");
                            }else{
                                $(".curPwdDiv").removeClass('has-danger');
                            }

                            if(v_newPwd != v_rePwd)
                            {
                                toastr["warning"]("New Password and Confirm Password must be the same.", "Attention!");
                                $(".newPwdDiv").addClass('has-danger');
                                v_erroNewPwd = true;
                            }else if(!v_newPwd.match(lowerCaseLetters) || !v_newPwd.match(upperCaseLetters) || !v_newPwd.match(numbers) || !v_newPwd.match(specialChars) || v_newPwd.length<8){
                                toastr["warning"]("New Password must contain at least one number and one uppercase and one lowercase letter and one special char, and at least 8 or more characters.", "Attention!");
                                $(".newPwdDiv").addClass('has-danger');
                                v_erroNewPwd = true;
                            }else{
                                $(".newPwdDiv").removeClass('has-danger');
                            }

                            if(v_erroCurPwd===true || v_erroNewPwd===true)
                            {
                                return false;
                            }
                           // alert('enviar ajax');return false;
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
                                        toastr["success"]("Password updated.", "Success!");
                                        modal.modal("hide");
                                    }else{
                                        if(d.msg == 'erro_pwd')
                                        {
                                            $(".curPwdDiv").addClass('has-danger');
                                            toastr["warning"]("Wrong Current Password.", "Attention!");
                                        }else if(d.msg == 'erro_format')
                                        {
                                            toastr["warning"]("New Password must contain at least one number and one uppercase and one lowercase letter and one special char, and at least 8 or more characters.", "Attention!");
                                            $(".newPwdDiv").addClass('has-danger');
                                        }

                                        //modal.find("#curPwd").val('');
                                        //modal.find("#newPwd").val('');
                                        //modal.find("#rePwd").val('');
                                    }
                                },
                                complete:function() {

                                }
                            });
                            return false;
                        }
                    },
                    {
                        label: "Close",
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
                            var v_result = JSON.parse(data);

                            if(v_result.status === true)
                            {
                                var pathAvatar = '<?=$GLOBALS['g_appRoot']."/__appFiles/".$_SESSION['userClnt']."/_userAvatar/"?>'+v_result.file;
                                $("#avatarImg").css('background-image',"url("+pathAvatar+")");
                                $("#userAvatar").val(v_result.file);
                                $('#appAddUserPhoto').modal('hide');
                                $.docData.tourAvatar = 1;
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
            hopscotch.endTour();
        });

        $('#appAddUserPhoto').on('hidden.bs.modal', function (e) {
            userPhotoDropzone.destroy();
            userPhotoDropzone = null;
        });
    });

    </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>