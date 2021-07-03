<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 05/01/2018
 * Time: 19:18
 */

namespace app\userAccess\userData;

use app\System\Tools\appSystemTools;
use app\userAccess\appUserControl;
use app\System\Relational\appRelationalData;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class appUserData extends appUserControl
{
    public function appUserAccess($data = NULL)
    {
        $v_reqMethod = $data['method'];

        if($v_reqMethod === "POST")
        {

            $v_buyUserQtd = !empty($data['buyUserQtd']) ? trim($data['buyUserQtd']) : NULL;
            $v_transactionID = !empty($data['transactionID']) ? trim($data['transactionID']) : NULL;
            if(is_null($v_buyUserQtd) || is_null($v_transactionID))
            {
                $v_return['apiData']['status'] = false;
                return $v_return;
            }
            else
            {
                $i = 1;

                while ($i <= $v_buyUserQtd)
                {
                    //add user_access
                    $v_userLogin = md5(microtime()).'@available';
                    $v_userPwd = hash('sha256',microtime());
                    $query = "INSERT INTO %appDBprefix%_user_access (clnt,user_login,user_pwd,user_status,transaction_id ,created_by) VALUES ('".$_SESSION['userClnt']."' , '".$v_userLogin."', '".$v_userPwd."','6','".$v_transactionID."','".$_SESSION['userID']."' )";
                    $v_return['apiData'] = $this->dbCon->dbInsert($query);
                    $v_userID = $v_return['apiData']['rsInsertID'];

                    //add user_info
                    $data['userID'] =  $v_userID;
                    $userInfo = $this->appUserInfo($data);

                    $i++;
                }

                if($v_userID)
                {
                    $v_return['apiData']['status'] = true;
                    return $v_return;
                }else
                {
                    $v_return['apiData']['status'] = false;
                    return $v_return;
                }

            }
        }
        elseif ($v_reqMethod === "PUT")
        {
            $v_userID = !empty($data['userID']) ? trim($data['userID']) : NULL;
            $v_userLogin = !empty($data['userLogin']) ? trim($data['userLogin']) : NULL;
            $v_userPwdNew = !empty($data['userPwdNew']) ? trim($data['userPwdNew']) : NULL;

            if(is_null($v_userLogin) || strlen($v_userLogin) < 1 || strlen($v_userPwdNew) < 1 || is_null($v_userPwdNew ) || empty($v_userID) )
            {
                $v_return['apiData']['status'] = false;
                echo json_encode($v_return);
            }
            else
            {
                $v_userPwd = hash('sha256',$v_userPwdNew);
                $query = "UPDATE %appDBprefix%_user_access SET user_login = '".addslashes($v_userLogin)."', user_pwd = '".$v_userPwd."'  WHERE clnt = '".$_SESSION['userClnt']."' AND user_id = ".$v_userID;
                $v_return['apiData'] = $this->dbCon->dbUpdate($query);
                $v_return['apiData']['status'] = true;
                echo json_encode($v_return);
            }
        }
        elseif ($v_reqMethod === "STATUS")
        {
            $v_userID = !empty($data['userID']) ? trim($data['userID']) : NULL;
            $v_userStatus = !empty($data['userStatus']) ? $data['userStatus'] : "1";

            if(is_null($v_userID))
            {
                $v_return['status'] = false;
                echo json_encode($v_return);
            }
            else
            {
                $query = "UPDATE %appDBprefix%_user_access SET user_status = ".$v_userStatus."  WHERE clnt = '".$_SESSION['userClnt']."' AND user_id = ".$v_userID;
                $v_return = $this->dbCon->dbUpdate($query);
                $v_return['status'] = true;
                echo json_encode($v_return);
            }
        }
        elseif ($v_reqMethod === "GET")
        {
            $v_userID = !empty($data['userID']) ? $data['userID'] : NULL;
            if(is_null($v_userID) || empty($v_userID))
            {
                $v_return['apiData']['status'] = false;
                echo json_encode($v_return);
            }
            else
            {
                $query = "SELECT user_id,user_info_id, clnt, user_login, user_pwd, user_name, user_nickname, user_birthday, gender_id, (IF(LENGTH(user_phone)>0,user_phone,'Not Available')) as user_phone, user_avatar, country_id, state_id, city_id, user_sess_id,user_status,created_at,created_by FROM %appDBprefix%_view_user_list WHERE user_id = ".$v_userID." AND clnt = '".$_SESSION['userClnt']."' ";
                $v_return['apiData'] = $this->dbCon->dbSelect($query);
                $v_return['apiData']['status'] = true;
                return $v_return;
            }
        }
        elseif ($v_reqMethod === "DELETE")
        {
            $v_userID = !empty($data['userID']) ? $data['userID'] : NULL;
            $v_userStatus = !empty($data['userStatus']) ? $data['userStatus'] : NULL;
            if(is_null($v_userID) || empty($v_userID))
            {
                $v_return['status'] = false;
                echo json_encode($v_return);
            }
            else
            {
                if($v_userStatus=='1' || $v_userStatus=='2')
                {
                    //Exclusao Logica
                    $query = "UPDATE %appDBprefix%_user_access SET ok = 0  WHERE clnt = '".$_SESSION['userClnt']."' AND user_id = ".$v_userID;
                    $v_return = $this->dbCon->dbUpdate($query);
                }else
                {
                    //Exclusao Fisica
                    $query = "DELETE FROM %appDBprefix%_user_access WHERE user_id = $v_userID AND clnt = '".$_SESSION['userClnt']."' ";
                    $v_return = $this->dbCon->dbDelete($query);
                }
                $v_return['status'] = true;
                echo json_encode($v_return);
            }
        }
        else
        {
            header("HTTP/1.0 204 No Content");
        }

    }

    public function appUserInfo($data = NULL)
    {
        $v_reqMethod = $data['method'];

        if($v_reqMethod === "POST")
        {
            $v_userName = 'New User Available';
            $v_userNickname = 'New User Available';
            $v_userID = !empty($data['userID']) ? trim($data['userID']) : NULL;
            $query = "INSERT INTO %appDBprefix%_user_info (clnt,user_id,user_name,user_nickname) VALUES ('".$_SESSION['userClnt']."',$v_userID,'".addslashes($v_userName)."','".addslashes($v_userNickname)."')";

            $v_return['apiData'] = $this->dbCon->dbInsert($query);
            $v_return['apiData']['status'] = true;
            return $v_return;
        }
        elseif ($v_reqMethod === "PUT")
        {
            $v_fieldArray = array(
                "updUserName" => "user_name",
                "updUserNickname" => "user_nickname",
                "updUserBirthday" => "user_birthday",
                "updUserPhone" => "user_phone",
                "updUserGender" => "gender_id"
            );

            $v_userID = !empty($data['userID']) ? trim($data['userID']) : NULL;
            $v_userField = !empty($v_fieldArray[$data['dataControl']]) ? trim($v_fieldArray[$data['dataControl']]) :NULL;
            $v_userData = !empty($data['userData']) ? trim($data['userData']) : "";
            $v_mobileCountryID = !empty($data['mobileCountryID']) ? trim($data['mobileCountryID']) : NULL;

            if(is_null($v_userID) || is_null($v_userField) || is_null($v_userData))
            {
                $v_return['status'] = false;
                return $v_return;
            }else
            {
                $query = "UPDATE %appDBprefix%_user_info SET ".$v_userField." = '".addslashes($v_userData)."' ";
                $query.= " WHERE user_id = ".$v_userID;
                $v_return = $this->dbCon->dbUpdate($query);
                $v_return['status'] = true;
                return $v_return;
            }
        }
        elseif ($v_reqMethod === "STATUS")
        {
            $v_userID = !empty($data['userID']) ? trim($data['userID']) : NULL;

            if(is_null($v_userID))
            {
                $v_return['apiData']['status'] = false;
                echo json_encode($v_return);
            }
            else
            {

                $query = "UPDATE %appDBprefix%_user_info SET user_data_status = ".$data['userDataStatus']."  WHERE clnt = '".$_SESSION['userClnt']."' AND user_id = ".$v_userID;
                $v_return['apiData'] = $this->dbCon->dbUpdate($query);
                $v_return['apiData']['status'] = true;
                echo json_encode($v_return);
            }
        }
        elseif ($v_reqMethod === "GET")
        {
            $v_userID = !empty($data['userID']) ? $data['userID'] : NULL;
            if(is_null($v_userID) || empty($v_userID))
            {
                $v_return['apiData']['status'] = false;
                echo json_encode($v_return);
            }
            else
            {
                $query = "SELECT user_id,user_info_id, clnt, user_login, user_pwd, user_name, user_nickname, user_birthday, gender_id, user_phone, user_avatar, country_id, state_id, city_id, user_sess_id,user_status,created_at,created_by FROM %appDBprefix%_view_user_list WHERE user_id = ".$v_userID." AND clnt = '".$_SESSION['userClnt']."' ";
                $v_return['apiData'] = $this->dbCon->dbSelect($query);
                $v_return['apiData']['status'] = true;
                echo json_encode($v_return);
            }
        }
        else
        {
            header("HTTP/1.0 204 No Content");
        }

    }

    public function appUserAllInfo($data = NULL)
    {
        $v_reqMethod = $data['method'];

        if($v_reqMethod === "ALL_INFO")
        {
            $v_userID = !empty($data['userID']) ? $data['userID'] : NULL;
            if(is_null($v_userID) || empty($v_userID))
            {
                $v_return['apiData']['status'] = false;
                return $v_return;
            }
            else
            {
                $query = "SELECT user_id,user_name,user_nickname,user_phone,user_login,user_pwd,temp_pwd,user_sess_id,user_status,status_desc,status_class,owner,user_info_id,access_profile_id,access_profile_desc,user_avatar,user_data_status,access_profile_data_user_only,access_profile_homepage,access_profile_status,first_access,welcome_screen,transaction_id,billing_status,created_by,created_at,ok FROM %appDBprefix%_view_user WHERE user_id = ".$v_userID."  ";
                $v_return['main'] = $this->dbCon->dbSelect($query);
            }
            return $v_return;
        }
    }

    public function appNewUserInvitation($data = NULL)
    {
        $v_reqMethod = $data['method'];

        if ($v_reqMethod === "POST"){
            $v_return['inviteSent'] = false;

            $v_userID = !empty($data['userID']) ? trim($data['userID']) : NULL;
            $v_userProfile = !empty($data['userProfile']) ? trim($data['userProfile']) : NULL;
            $v_userName = !empty($data['userName']) ? trim($data['userName']) : NULL;
            $v_userEmail = !empty($data['userEmail']) ? trim($data['userEmail']) : NULL;
            $v_microtimeToken = (string)(str_replace(' ','',str_replace('.','',microtime())));
            $v_tokenData = hash('sha256',$v_userProfile . $v_userName . $v_userEmail . $v_microtimeToken);
            $v_inviteToken = implode('-', str_split($v_tokenData, 8));
            $v_activationLink = $GLOBALS['g_appRoot'].'/NewUserRegistration/'.$v_inviteToken;
            $v_expirationDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 5, date('Y')));

            $v_pwdGen = new appSystemTools();
            $v_pwdGen->pwdGenerator();
            $v_userPwd = hash('sha256',$v_pwdGen->returnPwd);
            $query = "UPDATE %appDBprefix%_user_access SET  user_login = '".$v_userEmail."',user_pwd = '".$v_userPwd."',temp_pwd = '1',user_status = '3',first_access = '1'  WHERE user_id='".$v_userID."' AND clnt = '".$_SESSION['userClnt']."'  ";

            $v_newUserUpdate = $this->dbCon->dbUpdate($query);

            if($v_newUserUpdate['updateStatus']) {
                $query = "UPDATE %appDBprefix%_user_info SET  user_name = '".$v_userName."' WHERE user_id='".$v_userID."' AND clnt = '".$_SESSION['userClnt']."'  ";
                $v_newUserInfoUpdate = $this->dbCon->dbUpdate($query);
                $query = "DELETE FROM %appDBprefix%_system_user_invitation WHERE clnt = '" . $_SESSION['userClnt'] . "' AND user_email = '" . $data['userEmail'] . "'";
                $v_delete = $this->dbCon->dbDelete($query);
                $query = "INSERT INTO %appDBprefix%_system_user_invitation (clnt,token_data,user_id,user_email,user_name,user_profile_id,token_used,created_by) VALUES ('" . $_SESSION['userClnt'] . "','" . $v_inviteToken . "',".$v_userID.",'" . addslashes($v_userEmail) . "','" . addslashes($v_userName) . "'," . $v_userProfile . ",0," . $_SESSION['userID'] . ")";
                $v_insert = $this->dbCon->dbInsert($query);

                if ($v_insert['insertStatus'] === true) {
                    $v_dataParse = array(
                        'newUserName' => $v_userName,
                        'newUserActivationLink' => $v_activationLink,
                        'newUserExpirationDate' => $v_expirationDate,
                        'currentYear' => date('Y'),
                        'imageToken' => $v_inviteToken,
                        'plenvsDomain' => $GLOBALS['g_appRoot']
                    );

                    $v_htmlBody = new appSystemTools();
                    $v_htmlBody->contentParse(file_get_contents('../appSystemTemplate/appMailInvitationTemplate.html'),$v_dataParse);
                    $v_htmlMsg = $v_htmlBody->returnContent;

                    //echo $v_htmlMsg;
                    //die();


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
                        $v_sendInvitation->addAddress($v_userEmail, $v_userName);
                        $v_sendInvitation->Subject = 'Welcome to the Plenvs Data System! Complete your registration.';
                        $v_sendInvitation->msgHTML($v_htmlMsg);
                        $v_sendInvitation->AltBody = 'Teste de Email de Texto';

                        if ($v_sendInvitation->send()) {
                            $v_return['inviteSent'] = true;
                        } else {
                            $v_return['inviteSent'] = false;
                        }

                    }
                   catch (Exception $e) {
                        echo 'Message could not be sent. Mailer Error: ', $v_sendInvitation->ErrorInfo;
                    }

                } else {
                    $v_return['inviteSent'] = false;
                }
                echo json_encode($v_return);
            }
            else {

                if($v_newUserUpdate['duplicateData']) {
                    $v_return['duplicateData'] = true;
                }

                echo json_encode($v_return);
            }

        }
        elseif ($v_reqMethod === "PUT") {
            $v_return['inviteSent'] = false;
            $query = "SELECT token_id, clnt, token_data, user_id, user_email, user_name, user_profile_id, token_status, created_by, created_at, first_open, last_open, open_qtd, register_open, invitation_number, ok FROM %appDBprefix%_system_user_invitation WHERE user_id = ".$data['userID']." AND clnt = '".$_SESSION['userClnt']."' ";
            $getInvitation = $this->dbCon->dbSelect($query);
            $v_userProfile = $getInvitation['rsData']['0']['user_profile_id'];
            $v_userName = $getInvitation['rsData']['0']['user_name'];
            $v_userEmail = $getInvitation['rsData']['0']['user_email'];
            $v_invitationNumber = $getInvitation['rsData']['0']['invitation_number']+1;
            $v_microtimeToken = (string)(str_replace(' ','',str_replace('.','',microtime())));
            $v_tokenData = hash('sha256',$v_userProfile . $v_userName . $v_userEmail . $v_microtimeToken);
            $v_inviteToken = implode('-', str_split($v_tokenData, 8));
            $v_activationLink = $GLOBALS['g_appRoot'].'/NewUserRegistration/'.$v_inviteToken;
            $v_expirationDate = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 5, date('Y')));

            $query = "UPDATE %appDBprefix%_system_user_invitation SET  token_data = '".$v_inviteToken."',invitation_number = '".$v_invitationNumber."',token_status = '1' WHERE user_id='".$data['userID']."' AND clnt = '".$_SESSION['userClnt']."'  ";
            $v_update =  $this->dbCon->dbUpdate($query);

                if ($v_update['updateStatus'] === true) {

                    $v_dataParse = array(
                        'newUserName' => $v_userName,
                        'newUserActivationLink' => $v_activationLink,
                        'newUserExpirationDate' => $v_expirationDate,
                        'currentYear' => date('Y'),
                        'imageToken' => $v_inviteToken,
                        'plenvsDomain' => $GLOBALS['g_appRoot']
                    );

                    $v_htmlBody = new appSystemTools();
                    $v_htmlBody->contentParse(file_get_contents('../appSystemTemplate/appMailInvitationTemplate.html'),$v_dataParse);
                    $v_htmlMsg = $v_htmlBody->returnContent;

                    $v_sendInvitation = new PHPMailer(true);
                    $v_sendInvitation->SMTPDebug = $GLOBALS['g_phpMailerDebug'];

                    try {
                        if($GLOBALS['g_useSMTP'] === true)
                        {
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

                        $v_sendInvitation->setFrom('plenvs@goabh.com','Plenvs Data System');
                        $v_sendInvitation->addReplyTo('plenvs@goabh.com','Plenvs Data System');
                        $v_sendInvitation->addAddress($v_userEmail,$v_userName);
                        $v_sendInvitation->Subject = 'Welcome to the Plenvs Data System! Complete your registration.';
                        $v_sendInvitation->msgHTML($v_htmlMsg);
                        $v_sendInvitation->AltBody = 'Teste de Email de Texto';

                        if ($v_sendInvitation->send()) {
                            $v_return['inviteSent'] = true;
                           //user_access SET  user_status = '2' WHERE user_id='".$data['userID']."' AND clnt = '".$_SESSION['userClnt']."'  ";
                            //$v_update =  $this->dbCon->dbUpdate($query);
                        } else {
                            $v_return['inviteSent'] = false;
                        }

                    } catch (Exception $e) {
                        echo 'Message could not be sent. Mailer Error: ', $v_sendInvitation->ErrorInfo;
                    }

                }
                else {
                    $v_return['inviteSent'] = false;
                }
                echo json_encode($v_return);

        }
        elseif ($v_reqMethod === "STATUS") {
        }
        elseif ($v_reqMethod === "GET") {}
    }

    public function appNewUserInvitationUsed($data = NULL)
    {
        $query = "UPDATE %appDBprefix%_system_user_invitation SET token_status = 0, token_used = 1, ok = 0 WHERE 1=1 AND token_data = '".$data['tokenData']."' AND user_id = ".$data['userId']." AND ok = 1";
        return $this->dbCon->dbUpdate($query);
    }

    public function appUserTempPassword($data = NULL)
    {
        $v_userID = !empty($data['userID']) ? $data['userID'] : NULL;
        $query = "UPDATE %appDBprefix%_user_access SET temp_pwd = '0' WHERE clnt = '".$_SESSION['userClnt']."' AND user_id = ".$v_userID;
        $v_return = $this->dbCon->dbUpdate($query);
        $v_return['status'] = true;
        return $v_return;
    }

    public function appUserSessionFirstAccess()
    {
        $query = "UPDATE %appDBprefix%_user_access SET first_access = '0' WHERE clnt = '".$_SESSION['userClnt']."' AND user_id = ".$_SESSION['userID'];
        $v_return = $this->dbCon->dbUpdate($query);
        $v_return['status'] = true;
        return $v_return;
    }

    public function appNewUserTokenData($data = NULL)
    {
        $query = "SELECT token_id,clnt,token_data,user_id,user_email,user_name,user_profile_id,token_status,created_by,created_at,first_open,last_open,open_qtd,register_open FROM %appDBprefix%_system_user_invitation WHERE token_data = '".$data."'";
        return $this->dbCon->dbSelect($query);
    }

    public function appNewUserAccessUpdate($data)
    {
        $query = "UPDATE %appDBprefix%_user_access SET user_pwd = '".$data['userPwd']."', user_status = 2, temp_pwd = 0, first_access = 1 WHERE 1=1 AND clnt = '".$data['userClnt']."' AND user_id = ".$data['userId']." AND ok = 1";
        return $this->dbCon->dbUpdate($query);
    }

    public function appNewUserInfoUpdate($data)
    {
        $query = "UPDATE %appDBprefix%_user_info SET user_name = '".addslashes($data['userName'])."', user_nickname = '".addslashes($data['userNickname'])."', user_birthday = '".$data['userBirthday']."', gender_id = ".$data['userGenderID'].", user_phone = '".$data['userPhone']."', mobile_country_id = '".$data['userCountryID']."', user_locale_country_id = '".$data['userCountryID']."' WHERE 1=1 AND clnt = '".$data['userClnt']."' AND user_id = ".$data['userId']." AND ok = 1";
        return $this->dbCon->dbUpdate($query);
    }

    public function appNewUserProfile($data)
    {
        if($data['method'] === 'POST')
        {
            $query = "INSERT INTO %appDBprefix%_user_has_access_profile (clnt,user_id,access_profile_id) VALUES ('".$data['clnt']."',".$data['userID'].",".$data['profileID'].")";
            return $this->dbCon->dbInsert($query);
        }
        elseif($data['method'] === 'PUT')
        {
            //$query = "UPDATE %appDBprefix%_user_info SET user_name = '".addslashes($data['userName'])."', user_nickname = '".addslashes($data['userNickname'])."', user_birthday = '".$data['userBirthday']."', gender_id = ".$data['userGenderID'].", user_phone = '".$data['userPhone']."', country_id = '".$data['userCountryID']."' WHERE 1=1 AND clnt = '".$data['userClnt']."' AND user_id = ".$data['userId']." AND ok = 1";
            //return $this->dbCon->dbUpdate($query);
            return false;
        }

    }

    public function appValidateRecoverCode($token,$recoverCode){
        $queryUpdate = "UPDATE %appDBprefix%_user_password_recover SET code_used_qtd = code_used_qtd+1 WHERE token_data = '".$token."' ";
        $this->dbCon->dbUpdate($queryUpdate);

        $query = "SELECT user_id,user_email,code_used_qtd,token_data,recover_code,user_email_status,ok,created_at,token_status FROM %appDBprefix%_user_password_recover WHERE  token_data = '" . $token . "' ";
        $v_return =  $this->dbCon->dbSelect($query);

        if($v_return['rsStatus'])
        {
            $v_recover_code = $v_return['rsData'][0]['recover_code'];
            $v_code_used_qtd = $v_return['rsData'][0]['code_used_qtd'];



            if($v_code_used_qtd > 3){
                $v_return = 'limit';
                echo json_encode($v_return);
            }elseif($v_recover_code == $recoverCode){
                $v_userEmailInfo = $this->userEmailCheck($v_return['rsData'][0]['user_email']);
                $v_data['userName'] = $v_userEmailInfo['rsData']['0']['user_name'];
                $v_data['userID'] = $v_return['rsData'][0]['user_id'];
                $v_data['userLogin'] = $v_return['rsData'][0]['user_email'];
                $this->userPasswordReset($v_data);

                $query = "DELETE FROM %appDBprefix%_user_password_recover WHERE user_id = '".$v_return['rsData'][0]['user_id']." ' ";
                $this->dbCon->dbDelete($query);

                $v_return = 'valid';
                echo json_encode($v_return);
            }else{
                $v_return = 'invalidCode';
                echo json_encode($v_return);
            }

        }else{
            $v_return = 'invalidToken';
            echo json_encode($v_return);
        }
    }
}