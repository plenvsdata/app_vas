<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 04/06/2018
 * Time: 11:18
 */

namespace app\System\Tools;
use app\dbClass\appDBClass;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class appSystemTools
{
    public $dbCon;
    public $returnContent;
    public $returnPwd;
    public $pwdCheck;
    public $returnImage;
    public $pwdCheckData;

    public function __construct()
    {
        $this->dbCon = new appDBClass();
    }

    public function contentParse($data,$parse)
    {
        $v_content = $data;

        foreach ($parse as $key => $value)
        {
            $v_content = str_replace('{{'.$key.'}}',$value,$v_content);
        }
        $this->returnContent = $v_content;
    }

    public function pwdGenerator($length = 9, $add_dashes = false, $available_sets = 'luds', $pwd_check = false) {
        $sets = array();
        $all = '';
        $password = '';
        $dash_len = floor(sqrt($length));
        $dash_str = '';

        if(strpos($available_sets, 'l') !== false)
        {
            $sets[] = 'abcdefghijklmnopqrstuvwxyz';
        }
        if(strpos($available_sets, 'u') !== false)
        {
            $sets[] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        if(strpos($available_sets, 'd') !== false)
        {
            $sets[] = '0123456789';
        }
        if(strpos($available_sets, 's') !== false)
        {
            $sets[] = '!@#$%&*?';
        }

        if($pwd_check == false) {
            foreach ($sets as $set) {
                $password .= $set[array_rand(str_split($set))];
                $all .= $set;
            }

            $all = str_split($all);

            for ($i = 0; $i < $length - count($sets); $i++) {
                $password .= $all[array_rand($all)];
            }

            $password = str_shuffle($password);

            if (!$add_dashes) {
                $this->returnPwd = $password;
            } else {
                while (strlen($password) > $dash_len) {
                    $dash_str .= substr($password, 0, $dash_len) . '-';
                    $password = substr($password, $dash_len);
                }
                $this->returnPwd = $password;
            }
        }
        else
        {
            $v_pwdArray = str_split(trim($this->pwdCheckData));

            foreach ($sets AS $set)
            {
                $v_setArray = str_split($set);
                $v_pwdCheck = array_intersect($v_pwdArray,$v_setArray);
                $this->pwdCheck = true;

                if(count($v_pwdArray) < $length || count($v_pwdCheck) < 1)
                {
                    $this->pwdCheck = false;
                    break;
                }
            }
            return;
        }
    }

    public function imageTrack($token=null,$table=null,$trackType='invitationEmail') {
        $v_dateTime = date('Y-m-d H:i:s');
        $query = "SELECT token_data,first_open,last_open,open_qtd,token_status FROM %appDBprefix%_".$table." WHERE token_data = '".$token."'";

        $v_chk = $this->dbCon->dbSelect($query);

        if($v_chk['rsTotal'] > 0)
        {
            $v_chkData = $v_chk['rsData'][0];

            if($v_chkData['token_status'] == 1)
            {
                if($trackType == 'invitationEmail' || $trackType == 'clientSignUp') {
                    if (is_null($v_chkData['first_open'])) {
                        $query = "UPDATE %appDBprefix%_" . $table . " SET first_open = '" . $v_dateTime . "',last_open = '" . $v_dateTime . "', open_qtd = open_qtd+1  WHERE token_data = '" . $token . "' AND token_status = 1";
                    } else {
                        $query = "UPDATE %appDBprefix%_" . $table . " SET last_open = '" . $v_dateTime . "', open_qtd = open_qtd+1  WHERE token_data = '" . $token . "' AND token_status = 1";
                    }
                }
                elseif ($trackType == 'newUserRegistration')
                {
                    $query = "UPDATE %appDBprefix%_" . $table . " SET register_open = '" . $v_dateTime . "' WHERE token_data = '" . $token . "' AND token_status = 1";
                }
                elseif ($trackType == 'userPasswordRecover')
                {
                    $query = "UPDATE %appDBprefix%_" . $table . " SET code_used_qtd = code_used_qtd+1,  '" . $v_dateTime . "' WHERE token_data = '" . $token . "' AND token_status = 1";
                }

                $v_return = $this->dbCon->dbUpdate($query);

                if($v_return['affectedRows'] > 0)
                {
                    $v_imageType = '';
                }
                else
                {
                    $v_imageType = '404';
                }
            }
            elseif ($v_chkData['token_status'] == 1 && $trackType == 'userPasswordRecover') {
                $v_imageType = '';
            }
            else
            {
                $v_imageType = 'Expired';
            }
        }
        else
        {
            $v_imageType = '404';
        }
        $this->returnImage = $v_imageType;
    }

    public function randomBG($dir='',$pattern='bg_*.jpg') {
        $v_dir = "../appImages/bgImages/".$dir.'/';
        $v_files = array_map('basename',glob($v_dir.$pattern));
        shuffle($v_files);
        $this->returnImage = $v_files[0];
    }

    public function instanceCreatedDate($clnt=null) {
        if(is_null($clnt))
            return false;
        $query = "SELECT created_at, DATE_FORMAT(created_at,'%Y-%m-%d') AS created_date,DATE_FORMAT(created_at,'%H:%i:%s') AS created_time FROM %appDBprefix%_client_instance WHERE clnt = '".$clnt."'";
        return $v_chk = $this->dbCon->dbSelect($query);
    }

    public function appMsgSender($data) {
        $v_msgTitle = !empty($data['msgTitle']) ? $data['msgTitle'] : $GLOBALS['g_emailSubject'];
        $v_msgTemplate = !empty($data['msgTemplate']) ? $data['msgTemplate'] : NULL;
        $v_msgDataParse = !empty($data['msgParse']) ? $data['msgParse'] : [];
        $v_emailFromAddress = !empty($data['emailFromAddress']) ? $data['emailFromAddress'] : $GLOBALS['g_emailFrom']['address'];
        $v_emailFromName = !empty($data['emailFromName']) ? $data['emailFromName'] : $GLOBALS['g_emailFrom']['name'];
        $v_emailReplyToAddress = !empty($data['emailReplyToAddress']) ? $data['emailReplyToAddress'] : $GLOBALS['g_emailReplyTo']['address'];
        $v_emailReplyToName = !empty($data['emailReplyToName']) ? $data['emailReplyToName'] : $GLOBALS['g_emailReplyTo']['name'];
        $v_emailToAddress = !empty($data['emailToAddress']) ? $data['emailToAddress'] : NULL;
        $v_emailToName = !empty($data['emailToName']) ? $data['emailToName'] : NULL;
        $v_emailBccAddress = !empty($data['emailBccAddress']) ? $data['emailBccAddress'] : NULL;
        $v_emailBccName = !empty($data['emailBccName']) ? $data['emailBccName'] : NULL;

        if(is_null($v_msgTemplate) || is_null($v_msgDataParse) || is_null($v_emailToAddress) || is_null($v_emailToName)) {
            $v_return['msgSent'] = false;
            return false;
        }

        $v_htmlBody = new appSystemTools();
        $v_htmlBody->contentParse(file_get_contents('../appSystemTemplate/'.$v_msgTemplate.'.html'),$v_msgDataParse);
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
            $v_sendInvitation->setFrom($v_emailFromAddress,$v_emailFromName);
            $v_sendInvitation->addReplyTo($v_emailReplyToAddress,$v_emailReplyToName);
            $v_sendInvitation->addAddress($v_emailToAddress, $v_emailToName);

            if(!is_null($v_emailBccAddress)) {
                $v_sendInvitation->addBCC($v_emailBccAddress,$v_emailBccName);
            }

            $v_sendInvitation->Subject = $v_msgTitle;
            $v_sendInvitation->msgHTML($v_htmlMsg);
            $v_sendInvitation->AltBody = $GLOBALS['g_alternateTextBody'];

            if ($v_sendInvitation->send()) {
                $v_return['msgSent'] = true;
            } else {
                $v_return['msgSent'] = false;
            }

        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $v_sendInvitation->ErrorInfo;
        }

        return $v_return;

    }

    public function appGetRealIP() {
        if(!empty( $_SERVER['HTTP_CLIENT_IP']))
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif(!empty( $_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function appIPLocation($data) {

        $ch = curl_init('https://api.ipstack.com/'.$ip.'?access_key='.$access_key.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Store the data:
            $json = curl_exec($ch);
            curl_close($ch);

    // Decode JSON response:
            $api_result = json_decode($json, true);

    // Output the "capital" object inside "location"
            echo $api_result['location']['capital'];

        }

    public function appCurrencyConversion($data,$type='json') {
        $v_fromCurrency = $data['fromCurrency'];
        $v_toCurrency = $data['toCurrency'];
        $v_currencyValue = $data['currencyValue'];
        $v_convertData = !empty($data['convertDate']) ? $data['convertDate'] : date('Y-m-d');

        $v_url = str_replace("{{fixerIoKey}}",$GLOBALS['g_fixerIoAPIKey'],$GLOBALS['g_fixerIoConvertURL']);
        $v_url = str_replace("{{fromCurrency}}",$v_fromCurrency,$v_url);
        $v_url = str_replace("{{toCurrency}}",$v_toCurrency,$v_url);
        $v_url = str_replace("{{currencyValue}}",$v_currencyValue,$v_url);
        $v_url = str_replace("{{convertDate}}",$v_convertData,$v_url);

        $v_ch = curl_init();
        curl_setopt($v_ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($v_ch, CURLOPT_HEADER, 0);
        curl_setopt($v_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($v_ch, CURLOPT_URL, $v_url);
        curl_setopt($v_ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $v_data = curl_exec($v_ch);
        curl_close($v_ch);

        if($type != 'json') {

            $v_data = json_decode($v_data,true);
        }
        return $v_data;

        }

    public function appCurrencyExchange($data = NULL,$type='json') {
        $v_baseCurrency = !empty($data['baseCurrency']) ? $data['baseCurrency'] : 'USD';
        $v_url = str_replace("{{fixerIoKey}}",$GLOBALS['g_fixerIoAPIKey'],$GLOBALS['g_fixerIoBaseConversionURL']);
        $v_url = str_replace("{{baseCurrency}}",$v_baseCurrency,$v_url);

        $v_ch = curl_init();
        curl_setopt($v_ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($v_ch, CURLOPT_HEADER, 0);
        curl_setopt($v_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($v_ch, CURLOPT_URL, $v_url);
        curl_setopt($v_ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $v_data = curl_exec($v_ch);
        curl_close($v_ch);

        if($type != 'json') {
            $v_data = json_decode($v_data,true);
        }
        return $v_data;
    }

    static function countNullValues($a,$b) {
        $v_return = 0;
        if(count(array_filter($a)) == count(array_filter($b)))
        {
        $v_return = 0;
        } elseif(count(array_filter($a)) > count(array_filter($b)))
        {
        $v_return = -1;
        } elseif (count(array_filter($a)) < count(array_filter($b)))
        {
        $v_return = 1;
        }
        return $v_return;
    }

    public function appArrayLastKey($array) {
        $key = NULL;
        if ( is_array( $array ) ) {
            end( $array );
            $key = key( $array );
        }
        return $key;
    }

    public function checkMimeType()
    {
        $v_mimeArray = array( //ToDo: Completar com MIMEs a serem validados
            'csv' => array('text/csv','text/plain'),
        );
        return $v_mimeArray;
    }

    public function stringExtract($str,$type='email',$returnType='array',$first=true,$glue = '|') {

        if($type == 'email') {
            preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $str, $v_emailMatches);
            $v_extractData = $v_emailMatches;
        }
        elseif($type == 'emailDomain') {
            explode('.',substr(strrchr($str, "@"), 1));
            $v_extractData[0] = explode('.',substr(strrchr($str, "@"), 1));
          }
        elseif($type == 'phoneNumber') {
            //ToDo: Extrair números, parenteses, +, -
            explode('.',substr(strrchr($str, "@"), 1));
            $v_extractData[0] = explode('.',substr(strrchr($str, "@"), 1));
        }


        if(is_array($v_extractData)) {
            $v_extractData = $v_extractData[0];
            if($first == true) {
                $v_return = key_exists(0,$v_extractData) ? $v_extractData[0] : null;
            } else {
                $v_return = $v_extractData;
            }
        } else {
            $v_return = $v_extractData;
        }

        if($returnType == 'json') {
            $v_returnData = json_encode($v_return);
        } elseif ($returnType == 'text') {
            $v_returnData = is_array($v_return) ? implode($glue,$v_return) : $v_return;
        } else {
            $v_returnData = $v_return;
        }

        if($returnType == 'json') {
            echo $v_returnData;
        } else {
            return $v_returnData;
        }

    }

    public function clearControlChar ($str,$replacement=' ') {
        return trim(preg_replace('/[[:cntrl:]]/', $replacement, $str));
    }

    public function implodeMultidimensionalArray ($array,$idx,$glue=',',$returnType='string',$debug=false) {
        $v_finalArray = array();
        if(is_array($array)) {
            foreach ($idx AS $k => $v) {
                $v_strData = trim(preg_replace('/[[:cntrl:]]/', ' ', $array[$v]));
                if (strlen($v_strData) > 0) {
                    $v_finalArray[] = $v_strData;
                }
            }
        }

        if($debug == true) {
            echo '---- DEBUG START ----</br>';
            echo 'isArray = '.is_array($v_finalArray);
            echo '</br>';
            echo 'arrayCount = '.count($v_finalArray);
            echo '</br>';
            echo '---- DEBUG END ----</br>';
            die();
        }

        if($returnType == 'string') {

            if(count($v_finalArray) > 0) {
                return implode($glue,$v_finalArray);
            } else {
                return '';
            }

        } elseif ($returnType == 'array') {
            return $v_finalArray;
        } else {
            return rtrim(implode($glue,$v_finalArray),$glue);
        }
    }

    public function dataValidate ($data,$type = 'email') {

        if($type == 'email') {
            return filter_var($data, FILTER_VALIDATE_EMAIL);
        }
        elseif ($type == 'domain') {
            return filter_var($data, FILTER_VALIDATE_DOMAIN);
        }

    }

    public function convertDate ($dateCheck='') {
        $v_dateCheck = trim($dateCheck);

        if (preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $v_dateCheck)) // MySQL-compatible YYYY-MM-DD format
        {
            $v_return = $v_dateCheck;
        }
        elseif (preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/', $v_dateCheck)) // DD-MM-YYYY format
        {
            $v_return = substr($v_dateCheck, 6, 4) . '-' . substr($v_dateCheck, 3, 2) . '-' . substr($v_dateCheck, 0, 2);
        }
        elseif (preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/', $v_dateCheck)) // DD/MM/YYYY format
        {
            $v_return = substr($v_dateCheck, 6, 4) . '-' . substr($v_dateCheck, 3, 2) . '-' . substr($v_dateCheck, 0, 2);
        }
        elseif (preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{2}$/', $v_dateCheck)) // DD-MM-YY format
        {
            $v_return = substr($v_dateCheck, 6, 4) . '-' . substr($v_dateCheck, 3, 2) . '-20' . substr($v_dateCheck, 0, 2);
        }
        else // Any other format. Set it as an empty date.
        {
            //$v_return = '0000-00-00';
            $v_return = NULL;
        }
        return $v_return;
    }

    public function urlLoader($data = NULL) {
        //ToDO: Implementar para futuro uso
        echo 'urlLoader<br/>';

        if(!is_array($data)) {
            $v_return['urlStatus'] = false;
        } else {
            $v_url = !empty($data['loadURL']) ? $data['loadURL'] : NULL;
            $v_postVars = !empty($data['formData']) ? $data['formData'] : NULL;
            $v_method = !empty($data['method']) ? $data['method'] : NULL;
            $v_returnType = !empty($data['loadReturnType']) ? $data['loadReturnType'] : 'array';
            $v_loadMethod = !empty($data['loadMethod']) ? $data['loadMethod'] : 'curl';
            $v_dataSec = !empty($data['dataSec']) ? $data['dataSec'] : NULL;

            echo '<pre>';
            print_r($data);
            echo '</pre>';

            if($v_loadMethod == 'curl') {
                $v_options = array(
                    CURLOPT_URL => $v_url,
                    CURLOPT_PORT => 80,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => http_build_query($data),
                    CURLOPT_HTTP_VERSION => 1.0,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER => false
                );

                $ch = curl_init( $v_url );
                curl_setopt_array($ch,$v_options);
                $v_return = curl_exec( $ch );

                curl_error($ch);

                curl_close($ch);
                echo $v_return;
                echo 'curl_close';
                die();


            } elseif ($v_loadMethod == 'getContent') {
                $v_postVars = array('data' => $v_postVars, 'method' => $v_method, 'returnType' => $v_returnType );
                $v_options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => $v_method,
                        'content' => http_build_query($v_postVars),
                    )
                );
                $v_context  = stream_context_create($v_options);
                $v_return = file_get_contents($v_url, false, $v_context);
            } else {
                $v_return['urlStatus'] = false;
            }
        }
        return $v_return;
    }

    public function replaceChar($char = NULL){
        $comAcentos = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú',' ');
        $semAcentos = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', '0', 'U', 'U', 'U', '_');
        return str_replace($comAcentos, $semAcentos, $char);
    }
}
