<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 09/10/2017
 * Time: 19:50
 */
namespace app\userAccess;
use app\dbClass\appDBClass;
use app\System\Tools\appSystemTools;
use PHPMailer\PHPMailer\PHPMailer;

require_once ('../appGlobals/appGlobalSettings.php');

class appUserControl
{
    public $dbCon;

    public function __construct()
    {
        $this->dbCon = new appDBClass();
    }

    public function userLoginCheck($userLgn,$userPwd)
    {
        $query = "SELECT user_id,user_name,user_nickname,user_phone,user_login,user_pwd,temp_pwd,user_sess_id,user_status,status_desc,status_class,customer_id,owner,access_profile_id,access_profile_desc,access_features_array,check_customer_id,user_avatar,access_profile_data_user_only,access_profile_homepage,access_profile_status,first_access,welcome_screen,transaction_id,billing_status,created_by,created_at,ok  FROM %appDBprefix%_view_user WHERE user_login='" . addslashes($userLgn) . "' AND user_pwd='" . hash('sha256', addslashes($userPwd) ). "' AND user_status = 1 AND ok=1";
        return $this->dbCon->dbSelect($query);
    }

    public function setUserSession($userID,$sessID)
    {
        $query = "UPDATE %appDBprefix%_user_access SET user_sess_id = '".$sessID."' WHERE user_id = '".$userID."' ";
        return $this->dbCon->dbUpdate($query);
    }

    public function setInstanceFirstAccessSession($sessID = 0)
    {
        $query = "UPDATE %appDBprefix%_client_instance SET instance_first_access = $sessID WHERE 1=1 AND clnt = '".$_SESSION['userClnt']."'  ";
        return $this->dbCon->dbUpdate($query);
    }

    public function setUserFirstAccessSession($sessID = 0)
    {
        $query = "UPDATE %appDBprefix%_user_access SET welcome_screen = $sessID WHERE 1=1 AND clnt = '".$_SESSION['userClnt']."' AND user_id = '".$_SESSION['userID']."'  ";
        return $this->dbCon->dbUpdate($query);
    }

    public function getUserSession($userID)
    {
        $query = "SELECT user_sess_id FROM %appDBprefix%_view_user WHERE user_id = ".$userID." ";
        return $this->dbCon->dbSelect($query);
    }

    public function userSessionCheck()
    {
        $dateCheck = hash('sha256' ,date("Ymd"));
        //echo 'userID='.$_SESSION['userID'].'token='.$_SESSION['dateToken'];die();
        if(isset($_SESSION['lgnChk']) && isset($_SESSION['dateToken']) && isset($_SESSION['userID']) && isset($_SESSION['userName']) && isset($_SESSION['userIP']) && isset($_SESSION['userLogin']) && isset($_SESSION['accessProfileID']))
        {
            if($dateCheck === $_SESSION['dateToken'])
            {
                $v_sessData = $this->getUserSession($_SESSION['userID']);
                $v_sessID = $v_sessData['rsData'][0]['user_sess_id'];

                if($v_sessID===$_SESSION['lgnChk'])
                {
                    return true;
                }
                else
                {
                    $dbData = $this->userSignOut($_SESSION['userID']);
                    if($dbData==true)
                    {
                        $_SESSION = array();
                        return false;
                    }
                }
            }
            else
            {
                $dbData = $this->userSignOut($_SESSION['userID']);
                if($dbData==true)
                {
                    $_SESSION = array();
                    //header('Location: '.$GLOBALS['g_appRoot'].'/SignIn');
                    return false;
                }
            }
        }
        else
        {
            $_SESSION = array();
            return false;
            //header('Location: '.$GLOBALS['g_appRoot'].'/SignIn');
        }
    }

    public function userSignOut($userID)
    {
        $query = "UPDATE %appDBprefix%_user_access SET user_sess_id = NULL WHERE user_id=".$userID;
        return $this->dbCon->dbUpdate($query);
    }

    public function userRememberMe($remember='F',$username=null):VOID
    {
        if ($remember == 'T')
        {
            $numberOfDays = 30 ;
            $expirationDate = time() + 60 * 60 * 24 * $numberOfDays ;
            setcookie("appRememberMe",'T',$expirationDate,'/');
            setcookie("appUsername",$username,$expirationDate,'/');
        }
        else
        {
            $expirationDate = time() - 60 ;
            setcookie("appRememberMe",'F',$expirationDate);
            setcookie("appUsername",'',$expirationDate);
        }
    }

    public function userPasswordReset($data)
    {
        $v_appTools =  new appSystemTools();
        $v_appTools->pwdGenerator();
        $v_newPassword = $v_appTools->returnPwd;
        $v_newPasswordSha = hash('sha256',$v_newPassword);

        $query = "UPDATE %appDBprefix%_user_access SET user_sess_id = NULL, user_pwd = '".$v_newPasswordSha."',temp_pwd = '1' WHERE user_id=".$data['userID'];
        $v_return =  $this->dbCon->dbUpdate($query);
        if ($v_return['updateStatus'] === true)
        {
            $v_dataParse = array(
                'userName' => $data['userName'],
                'newUserPassword' => $v_newPassword,
                'currentYear' => date('Y'),
                'plenvsDomain' => $GLOBALS['g_appRoot']
            );

            $v_htmlBody = new appSystemTools();
            $v_htmlBody->contentParse(file_get_contents('../appSystemTemplate/appMailPasswordResetTemplate.html'),$v_dataParse);
            $v_htmlMsg = $v_htmlBody->returnContent;

            $v_sendInvitation = new PHPMailer(true);
            $v_sendInvitation->SMTPDebug = $GLOBALS['g_phpMailerDebug'];

            try {
                if ($GLOBALS['g_useSMTP'] === true) {

                    $v_sendInvitation->isSMTP();
                    $v_sendInvitation->Host = gethostbyname($GLOBALS['g_emailHostSettings']['host']);
                    $v_sendInvitation->SMTPAuth = $GLOBALS['g_emailHostSettings']['smtpAuth'];
                    $v_sendInvitation->Username = $GLOBALS['g_emailHostSettings']['username'];
                    $v_sendInvitation->Password = $GLOBALS['g_emailHostSettings']['password'];
                    $v_sendInvitation->SMTPSecure = $GLOBALS['g_emailHostSettings']['secure'];
                    $v_sendInvitation->Port = $GLOBALS['g_emailHostSettings']['port'];
                    $v_sendInvitation->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                }

                $v_sendInvitation->setFrom('plenvs@goabh.com', 'Plenvs Data System');
                $v_sendInvitation->addReplyTo('plenvs@goabh.com', 'Plenvs Data System');
                $v_sendInvitation->addAddress($data['userLogin'], $data['userName']);
                $v_sendInvitation->Subject = 'Reset Password.';
                $v_sendInvitation->msgHTML($v_htmlMsg);
                $v_sendInvitation->AltBody = 'Your password has been changed. Please log on again using the temporary password: ' . $v_newPassword;
                if ($v_sendInvitation->send()) {
                    $v_return['sendEmail'] = true;
                } else {
                    $v_return['sendEmail'] = false;
                }
            }
            catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $v_sendInvitation->ErrorInfo;
            }
        }else
        {
            $v_return['sendEmail'] = false;
        }
        return $v_return;
    }

    public function userChangePassword($data)
    {

        $v_appTools =  new appSystemTools();
        $v_appTools->pwdCheckData = $data['curPwd'];
        $v_appTools->pwdGenerator(8, false, 'luds', true);
        $v_valida_cur_pwd = $v_appTools->pwdCheck;

        $v_appTools->pwdCheckData = $data['newPwd'];
        $v_appTools->pwdGenerator(8, false, 'luds', true);
        $v_valida_new_pwd = $v_appTools->pwdCheck;

        if($v_valida_cur_pwd && $v_valida_new_pwd)
        {
            $query = "SELECT user_pwd FROM %appDBprefix%_user_access WHERE user_id = ".$data['userID']."  ";
            $v_resultUserPwd = $this->dbCon->dbSelect($query);
            $v_userPwd = $v_resultUserPwd['rsData'][0]['user_pwd'];
            $v_curPwd = hash('sha256',$data['curPwd']);
            $v_newPwd = hash('sha256',$data['newPwd']);

            if($v_userPwd == $v_curPwd)
            {
                $query = "UPDATE %appDBprefix%_user_access SET  user_pwd = '".$v_newPwd."',temp_pwd = '0' WHERE user_id='".$data['userID']."'  ";
                $v_return =  $this->dbCon->dbUpdate($query);
            }else{
                $v_return['msg'] = 'erro_pwd';
                $v_return['updateStatus'] = false;
            }

        }else
        {
            $v_return['msg'] = 'erro_format';
            $v_return['updateStatus'] = false;
        }

        return $v_return;
    }

    public function userEmailCheck($userLgn)
    {
        $query = "SELECT user_id,clnt,user_login,user_pwd,temp_pwd,user_name,user_nickname,user_birthday,gender_id,user_phone,user_avatar,country_id,state_id,city_id,user_locale,first_access,user_sess_id,user_status,created_at,ok FROM %appDBprefix%_view_user WHERE user_login='" . $userLgn . "' AND user_status = 2 AND ok=1";
        return $this->dbCon->dbSelect($query);
    }

    public function appRecoverPassword($data = NULL)
    {
        $v_reqMethod = $data['method'];
        if ($v_reqMethod === "POST")
        {
            $v_userEmail = !empty($data['userEmail']) ? addslashes($data['userEmail']) : NULL;
            $v_recoverCode = !empty($data['recoverCode']) ? $data['recoverCode'] : NULL;
            $v_tokenData = !empty($data['tokenData']) ? $data['tokenData'] : NULL;
            $v_userID = !empty($data['userID']) ? $data['userID'] : NULL;

            if(is_null($v_userEmail) || is_null($v_recoverCode) || is_null($v_tokenData))
            {
                $v_return['status'] = false;
                return $v_return;
            }
            else
            {
                $query = "INSERT INTO %appDBprefix%_user_password_recover (user_id,user_email,recover_code,token_data) VALUES ('".$v_userID."','".$v_userEmail."','".$v_recoverCode."','".$v_tokenData."') ";
                $query.= " ON DUPLICATE KEY UPDATE user_email = '".$v_userEmail."', recover_code = '".$v_recoverCode."', token_data = '".$v_tokenData."', created_at = '".date('Y-m-d H:i:s')."',token_status = 1 ";
                $v_insertData = $this->dbCon->dbInsert($query);
                $v_return['status'] = true;
                return $v_return;
            }
        }
    }

    public function setUserSessionHomePosition()
    {
        $query = "SELECT lat,lng FROM %appDBprefix%_view_user WHERE user_id = '".$_SESSION['userID']."' ";
        $v_result =  $this->dbCon->dbSelect($query);

        if($v_result['rsTotal'] > 0){
            $_SESSION['userHomePosition'] = array($v_result['rsData'][0]['lat'],$v_result['rsData'][0]['lng']);
        }else{
            $_SESSION['userHomePosition'] = null;
        }
    }

    public function checkFeaturePermission($featureID = 0): bool
    {
        if(in_array($featureID,$_SESSION['accessFeaturesArray']))
        {
            return true;
        }else{
            return false;
        }
    }
}