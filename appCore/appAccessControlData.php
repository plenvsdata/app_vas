<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 02/10/2017
 * Time: 22:51
 */
session_start();
require($_SERVER['DOCUMENT_ROOT'] . "/appClasses/appGlobal.php");
require($_SERVER['DOCUMENT_ROOT'] . "/appGlobals/appGlobalSettings.php");

use app\System\Tools\appSystemTools;
use app\userAccess\userData\appUserData as appLoginCheck;
//use app\System\GeoData\appGeoData;
use app\System\Lov\appGetValue;

$v_dataSec = !empty($_REQUEST['dataSec']) ? $_REQUEST['dataSec'] : NULL;
//echo $v_dataSec;die();

if (is_null($v_dataSec)) {
    $dbHome = new appLoginCheck();
    $vLgnCheck = $dbHome->userSessionCheck();
    $v_dataRedirect = "<script>location.href = '" . $GLOBALS['g_appRoot'] . "/SignIn'</script>";
}
elseif ($v_dataSec == "loginCheck") {
    $v_lgn = !empty($_POST['email']) ? $_POST['email'] : null;
    $v_pwd = !empty($_POST['password']) ? $_POST['password'] : null;
    $v_chk = !empty($_POST['dataCheck']) ? $_POST['dataCheck'] : null;
    $v_rem = !empty($_POST['rememberMe']) ? $_POST['rememberMe'] : 'F';

    if ($v_rem == 'T') {
        $numberOfDays = 30;
        $expirationDate = time() + 60 * 60 * 24 * $numberOfDays;
        setcookie("appRememberMe", 'T', $expirationDate);
        setcookie("appUsername", $v_lgn, $expirationDate);
    } else {
        $expirationDate = time() - 60;
        setcookie("appRememberMe", 'F', $expirationDate);
        setcookie("appUsername", '', $expirationDate);
    }

    $v_sesCheck = session_id();
    if ($v_chk === $v_sesCheck) {
        $dbHome = new appLoginCheck();
        $dbData = $dbHome->userLoginCheck($v_lgn, $v_pwd);
        if ($dbData['rsStatus'] === true) {
            $v_userData = $dbData['rsData'][0];
            unset($_SESSION['adminErrCode']);
            $_SESSION['lgnChk'] = session_id();
            $_SESSION['dateToken'] = hash('sha256', date("Ymd"));
            $_SESSION['userID'] = $v_userData['user_id'];
            $_SESSION['userName'] = $v_userData['user_name'];
            $_SESSION['userIP'] = $v_userIP['userIPData'] = $g_userIP;
/*
            $v_geoData = new appGeoData();
            $v_geoInfo = $v_geoData->getIPGeoInfo($v_userIP,'array');
            $v_geoCSCData = new appGetValue();

            // Busca country_id
            if(strlen(trim($v_geoInfo['country_code'])) > 0) {
                $v_geoCountryCode['table'] = 'view_combo_system_country';
                $v_geoCountryCode['field'] = 'country_id';
                $v_geoCountryCode['fieldName'] = 'country_code';
                $v_geoCountryCode['fieldID'] = $v_geoInfo['country_code'];
                $v_geoCSCCountryID = $v_geoCSCData->appGetValueData($v_geoCountryCode);

                if(count($v_geoCSCCountryID) > 0) {
                    if(array_key_exists('country_id',$v_geoCSCCountryID[0])){
                        $v_geoInfo['country_id'] = $v_geoCSCCountryID[0]['country_id'];
                    }
                } else {
                    $v_geoInfo['country_id'] = $g_appDefaultCountryID;
                }
            } else {
                $v_geoInfo['country_id'] = $g_appDefaultCountryID;
            }

            // Busca state_id
            if(strlen(trim($v_geoInfo['region_name'])) > 0) {
                $v_geoStateDesc['table'] = 'view_combo_system_state';
                $v_geoStateDesc['field'] = 'state_id';
                $v_geoStateDesc['fieldName'] = array('state_desc','country_id');
                $v_geoStateDesc['fieldID'] = array($v_geoInfo['region_name'],$v_geoInfo['country_id']);
                $v_geoCSCStateID = $v_geoCSCData->appGetValueData($v_geoStateDesc);

                if(count($v_geoCSCStateID) > 0) {
                    if(array_key_exists('state_id',$v_geoCSCStateID[0])){
                        $v_geoInfo['state_id'] = $v_geoCSCStateID[0]['state_id'];
                    }
                } else {
                    $v_geoInfo['state_id'] = $g_appDefaultStateID;
                }
            } else {
                $v_geoInfo['state_id'] = $g_appDefaultStateID;
            }

            // Busca city_id
            if(strlen(trim($v_geoInfo['city'])) > 0) {
                $v_geoCityDesc['table'] = 'view_combo_system_city';
                $v_geoCityDesc['field'] = 'city_id';
                $v_geoCityDesc['fieldName'] = array('city_desc','country_id','state_id');
                $v_geoCityDesc['fieldID'] = array($v_geoInfo['city'],$v_geoInfo['country_id'],$v_geoInfo['state_id']);
                $v_geoCSCCityID = $v_geoCSCData->appGetValueData($v_geoCityDesc);

                if(count($v_geoCSCCityID) > 0) {
                    if(array_key_exists('city_id',$v_geoCSCCityID[0])){
                        $v_geoInfo['city_id'] = $v_geoCSCCityID[0]['city_id'];
                    }
                } else {
                    $v_geoInfo['city_id'] = $g_appDefaultCityID;
                }
            } else {
                $v_geoInfo['city_id'] = $g_appDefaultCityID;
            }

   */
            //$_SESSION['geoInfo'] = $v_geoInfo;
            $_SESSION['userLogin'] = $v_userData['user_login'];
            $_SESSION['tempPwd'] = $v_userData['temp_pwd'];
            $_SESSION['userAvatar'] = $v_userData['user_avatar'];
            $_SESSION['firstAccess'] = $v_userData['first_access'];
            $_SESSION['userWelcomeScreen'] = $v_userData['welcome_screen'];
            $_SESSION['accessProfileID'] = $v_userData['access_profile_id'];
            $_SESSION['accessProfileDesc'] = $v_userData['access_profile_desc'];
            $_SESSION['accessFeaturesArray'] = explode(',',$v_userData['access_features_array']);
            $_SESSION['customerID'] = $v_userData['customer_id'];
            $_SESSION['checkCustomerID'] = $v_userData['check_customer_id'];

            $_SESSION['accessProfileDataUserOnly'] = $v_userData['access_profile_data_user_only'];
            //$_SESSION['accessFeatureArray'] = explode(',',$v_userData['access_feature_array']);
            //ToDo: userProfileData - Ajustes
            /*
            $_SESSION['instanceLocale'] = $v_userData['user_locale'];
            $_SESSION['instanceLocaleJS'] = str_replace('_','-',$v_userData['user_locale']);
            $_SESSION['userLocaleCountryID'] = $v_userData['user_locale_country_id'];
            $_SESSION['userLocale'] = $v_userData['user_locale'];
            $_SESSION['userLocaleJS'] = str_replace('_','-',$v_userData['user_locale']);
            $_SESSION['dateFormat'] = $v_userData['date_format'];
            $setUserMoment = explode("_",$v_userData['user_locale']);
            $setInstanceMoment = explode("_",$v_userData['user_locale']);

            $_SESSION['instanceMomentJS'] = $setInstanceMoment[0];
            $_SESSION['userMomentJS'] = $setUserMoment[0];
            $_SESSION['userCurrencyCode'] = $v_userData['user_currency_code'];
            $_SESSION['instanceCurrencySymbol'] = $v_userData['instance_currency_symbol'];
            $_SESSION['currencyID'] = $v_userData['currency_id'];
            $_SESSION['userAddressID'] = $v_userData['user_address_id'];
            $_SESSION['instanceAddressID'] = $v_userData['instance_address_id'];
            */
            $dbUserSession = $dbHome->setUserSession($v_userData['user_id'], $_SESSION['lgnChk']);

            if ($dbUserSession == true) {
                $rememberMe = $dbHome->userRememberMe($v_rem, $v_lgn);

/*
                echo '<pre>';
                print_r($_SESSION['accessProfileID'].' - '.$v_userData['access_profile_homepage']);
                echo '</pre>';
                die();
*/

                if ($_SESSION['firstAccess'] == 0) {
                    if($v_userData['access_profile_homepage']){
                        header('Location: ' . $GLOBALS['g_appRoot'] . '/MeuPerfil');
                        //header('Location: ' . $GLOBALS['g_appRoot'] .'/'. $v_userData['access_profile_homepage']);
                    }else{
                        header('Location: ' . $GLOBALS['g_appRoot'] . '/Welcome');
                    }

                } else {
                    header('Location: ' . $GLOBALS['g_appRoot'] . '/MeuPerfil');
                }
            } else {
                $rememberMe = $dbHome->userRememberMe($v_rem, $v_lgn);
                header('Location: ' . $GLOBALS['g_appRoot'] . '/SignIn');
            }
        } else {
            $rememberMe = $dbHome->userRememberMe($v_rem, $v_lgn);
            $_SESSION['adminErrCode'] = true;
            header('Location: ' . $GLOBALS['g_appRoot'] . '/SignIn');
        }
    } else {
        $_SESSION['adminErrCode'] = true;
        header('Location: ' . $GLOBALS['g_appRoot'] . '/SignIn');

    }
}
elseif ($v_dataSec == "recoverEmail") {
    $v_lgn = !empty($_POST['email']) ? $_POST['email'] : null;

    $dbHome = new appLoginCheck();
    $dbData = $dbHome->userEmailCheck($v_lgn);

    if ($dbData['rsStatus'] === true)
    {
        $v_codeData = new appSystemTools();
        $v_codeData->pwdGenerator(8,false,'ud',false);
        $v_recoverCode = $v_codeData->returnPwd;
        $v_tokenData = hash('sha256', date("Ymd").($dbData['rsData'][0]['user_login']));

        //armazenar código na base
        $recoverPWDData['userID'] = ($dbData['rsData'][0]['user_id']);
        $recoverPWDData['userEmail'] = ($dbData['rsData'][0]['user_login']);
        $recoverPWDData['recoverCode'] = $v_recoverCode;
        $recoverPWDData['tokenData'] = $v_tokenData;
        $recoverPWDData['method'] = 'POST';
        $v_recoverPassword = $dbHome->appRecoverPassword($recoverPWDData);

        //enviar email.
        $data['msgTitle'] = 'Recover my password!';
        $data['msgTemplate'] = 'appMailPasswordRecoverTemplate';
       // $data['emailFromAddress'] = 'appMailPasswordRecover';
        //$data['emailFromName'] = 'appMailPasswordRecover';
       // $data['emailReplyToddress'] = 'appMailPasswordRecover';
        //$data['emailReplyToName'] = 'appMailPasswordRecover';
        $data['emailToAddress'] = $dbData['rsData'][0]['user_login'];
        $data['emailToName'] = $dbData['rsData'][0]['user_name'];

        $v_codeArray = str_split($v_recoverCode,1);
        $v_codeCount = 1;
        foreach ($v_codeArray AS $value) {
            $data['msgParse']['cc'.$v_codeCount] = $value;
            $v_codeCount++;
        }

        $data['msgParse']['userName'] = $dbData['rsData'][0]['user_name'];
        $data['msgParse']['plenvsDomain'] = $GLOBALS['g_appRoot'];
        $data['msgParse']['tokenData'] = $v_tokenData;
        $data['msgParse']['linkCode'] = $GLOBALS['g_appRoot'].'/RecoverMyPassword/'.$v_tokenData.'/ConfirmationCode';
        $data['msgParse']['currentYear'] = date('Y');

        $v_sendEmail = $v_codeData->appMsgSender($data);

        if($v_sendEmail){
            $_SESSION['toasterMsg'] = '1';
            header('Location: ' . $GLOBALS['g_appRoot'] . '/SignIn');
        }else{
            $_SESSION['toasterMsg'] = '2';
            header('Location: ' . $GLOBALS['g_appRoot'] . '/SignIn');
        }

    }else{
        header('Location: ' . $GLOBALS['g_appRoot'] . '/SignIn');
    }

}
elseif ($v_dataSec == "appQuit") {

    $dbHome = new appLoginCheck();
    $dbData = $dbHome->userSignOut($_SESSION['userID']);

    if ($dbData == true) {
        session_destroy();
        header('Location: ' . $GLOBALS['g_appRoot'] . '/SignIn');
    }
}
elseif ($v_dataSec == "appRecoverPasswordCodeValidation") {
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_recoverCode = '';
    $v_tokenData = $v_appData['tokenData'];

    foreach($v_appData['formData'] as $key=>$value){
        $v_recoverCode.= $v_appData['formData'][$key]['value'];
    }
    $dbHome = new appLoginCheck();
    $v_validateRecover = $dbHome->appValidateRecoverCode($v_tokenData,strtoupper($v_recoverCode));
    /*
    $v_userEmailInfo = $dbHome->userEmailCheck($v_validateRecover['user_email']);

    if($v_validateRecover){

        $v_data['userName'] = $v_userEmailInfo['rsData']['0']['user_name'];
        $v_data['userID'] = $v_validateRecover['user_id'];
        $v_data['userLogin'] = $v_validateRecover['user_email'];

        $dbHome->userPasswordReset($v_data);
        return true;

    }else{
        return false;
    }
    */

}
else {
    header("HTTP/1.0 404 Not Found");
}
