<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 21/01/2018
 * Time: 23:55
 */

namespace app\System\Photo;

use app\dbClass\appDBClass;
use app\System\Lov\appGetValue;
use app\System\Tools\appSystemTools;
use PHPMailer\PHPMailer\PHPMailer;
use app\System\Lists\appDataList;

class appPhoto
{
    private $dbCon;

    public function __construct()
    {
        $this->dbCon = new appDBClass();
    }

    public function appPhotoData($data = NULL,$file = NULL)
    {
        $v_reqMethod = $data['method'];
        $v_serverRoot = $_SERVER['DOCUMENT_ROOT']."/__appFiles/".$_SESSION['userClnt']."/_photos/";
        $v_dirCheck = (!file_exists($v_serverRoot)) ? (mkdir($v_serverRoot, 0777, true)) : true;

        if(!$v_dirCheck)
        {
            return false;
        }

        if ($v_reqMethod === "POST")
        {
            $v_fileInfo = pathinfo($file['fileData']['name']);

            $v_fileExt = $v_fileInfo['extension'];
            $v_fileServerName = (hash('sha256',$_SESSION['userClnt'].$file['fileData']['name'].time())).'.'.$v_fileExt;
            $v_fileTarget = $v_serverRoot.$v_fileServerName;
            $v_customerID = isset($data['customerID']) ? $data['customerID'] : 'NULL';
            $v_contactID = isset($data['contactID']) ? $data['contactID'] : 'NULL';
            $v_productID = isset($data['productID']) ? $data['productID'] : 'NULL';

            if(move_uploaded_file($file['fileData']['tmp_name'], $v_fileTarget))
            {
                $query = "INSERT INTO %appDBprefix%_photo_data (clnt,customer_id,contact_id,product_id,photo_type_id,photo,photo_original_name,photo_crc,photo_extension,photo_mime,photo_notes,photo_size,created_by,photo_status) VALUES ('".$_SESSION['userClnt']."',".$v_customerID.",".$v_contactID.",".$v_productID.",'".$data['photoTypeID']."','".$v_fileServerName."','".addslashes($file['fileData']['name'])."','".sha1_file($v_fileTarget)."','$v_fileExt','".addslashes($file['fileData']['type'])."','".addslashes($data['photoNotes'])."','".$file['fileData']['size']."','".$_SESSION['userID']."','1')";
                $v_insertData = $this->dbCon->dbInsert($query);
                $v_return['status'] = true;
                $v_return['photoID'] = $v_insertData['rsInsertID'];
            }
            else
            {
                $v_return['status'] = false;
            }
            return $v_return;
        }
        elseif ($v_reqMethod === "PUT")
        {
            //ToDo: Implementar o PUT/EDIT

        }
        elseif ($v_reqMethod === "GET")
        {
            $v_videoCode = !empty($data['videoCode']) ?? NULL;
            $query = "SELECT customer_token,user_id,alarme_type_id,alarme_desc,video_code,photo,photo_original_name,cam_folder,alarme_datetime,read_at,read_count,validated_at,created_at FROM %appDBprefix%_view_email_photo_data WHERE video_code = '".$v_videoCode."'";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            $v_return['apiData']['status'] = true;
            return $v_return;
        }
        elseif ($v_reqMethod === "DELETE")
        {
            $v_photoID = !empty($data['photoID']) ? $data['photoID'] : NULL;
            $query = "SELECT photo FROM %appDBprefix%_view_product_photo_list  WHERE photo_id = $v_photoID AND clnt = '".$_SESSION['userClnt']."'";
            $v_photoFileData = $this->dbCon->dbSelect($query);
            $v_photoFile = $v_photoFileData['rsData'][0]['photo'];
            $v_photoDelete = $v_serverRoot.$v_photoFile;

            if(!is_null($v_photoFile))
            {
                if(unlink($v_photoDelete))
                {
                    $query = "DELETE FROM %appDBprefix%_photo_data WHERE photo_id = $v_photoID AND clnt = '".$_SESSION['userClnt']."'";
                    if($this->dbCon->dbDelete($query))
                    {
                        $v_return['status'] = true;
                    }
                    else
                    {
                        $v_return['status'] = true;
                    }
                }
                else
                {
                    $v_return['status'] = false;
                }
            }
            else
            {
                $v_return['status'] = false;
            }
            return $v_return;
        }
    }

    public function appAlarmCloud($data = NULL,$fileData = NULL)
    {
        //print_r($data);
        //print_r($fileData);

        $v_reqMethod = $data['method'];
        $v_customerID = $data['customerID'];
        $v_cloudPath = $data['cloudPath'];
        $v_tokenData = $data['tokenData'];
        $v_fileNameHash = $data['fileName'].$data['fileNumber'].'.'.$data['fileExt'];
        $v_alarmID = $data['alarmID'];
        $v_dateTime = $data['dateTime'];
        $v_fileNumber = $data['fileNumber'];

        $v_getValueData = new appGetValue();

        $v_data['table'] = 'lov_system_alarme_type';
        $v_data['field'] = 'alarme_type_id';
        $v_data['fieldName'] = 'alarme_desc';
        $v_data['fieldID'] = $data['alarmType'];

        $v_getValueReturn = $v_getValueData->appGetValueData($v_data);
        $v_alarmeTypeID = $v_getValueReturn['alarme_type_id'];
        $v_fileName = $fileData['name'][$v_fileNumber];
        $v_fileTarget = $v_cloudPath.$fileData['name'][$data['fileNumber']];
        $v_cloudDirCheck = !(!file_exists($v_cloudPath)) || mkdir($v_cloudPath, 0777, true);

        if(!$v_cloudDirCheck)
        {
            return false;
        }

        if ($v_reqMethod === "POST")
        {
            if(move_uploaded_file($fileData['tmp_name'][$data['fileNumber']], $v_fileTarget))
            {
                $query  = "INSERT INTO %appDBprefix%_photo_data (customer_id,alarme_type_id,alarme_id,photo,photo_original_name,alarme_datetime) ";
                $query .= "VALUES ('".$v_customerID."',".$v_alarmeTypeID.",".$v_alarmID.",'".$v_fileNameHash."','".$v_fileName."','".$v_dateTime."')";
                $v_insertData = $this->dbCon->dbInsert($query);
                $v_return['status'] = true;
                $v_return['photoID'] = $v_insertData['rsInsertID'];
                $v_return['fileName'] = $v_fileName;
                $v_return['alarmeTypeID'] = $v_alarmeTypeID;
            }
            else
            {
                $v_return['status'] = false;
            }
            return $v_return;
        }
        elseif ($v_reqMethod === "PUT")
        {
            //ToDo: Implementar o PUT/EDIT

        }
        elseif ($v_reqMethod === "GET")
        {
        }
        elseif ($v_reqMethod === "DELETE")
        {
         }
    }

    public function appUserPhotoData($data = NULL,$file = NULL)
    {
        $v_reqMethod = $data['method'];
        $v_serverRoot = $_SERVER['DOCUMENT_ROOT']."/__appFiles/".$data['userID']."/_userAvatar/";
        $v_dirCheck = (!file_exists($v_serverRoot)) ? (mkdir($v_serverRoot, 0777, true)) : true;

        if(!$v_dirCheck)
        {
            return false;
        }
        if ($v_reqMethod === "PUT")
        {
            $v_fileInfo = pathinfo($file['fileData']['name']);
            $v_fileExt = $v_fileInfo['extension'];
            $v_fileServerName = (hash('sha256',$data['userID'].$data['userLogin'].date('U'))).'.'.$v_fileExt;
            $v_fileTarget = $v_serverRoot.$v_fileServerName;

            if(move_uploaded_file($file['fileData']['tmp_name'], $v_fileTarget))
            {
                $query = "UPDATE %appDBprefix%_user_access SET  user_avatar = '".$v_fileServerName."' WHERE user_id = ".$data['userID'];
                $v_updateData = $this->dbCon->dbUpdate($query);
                $v_return['status'] = true;
                $v_return['file'] = $v_fileServerName;

                if($data['userAvatar']!='default_avatar.png' &&  $data['userAvatar']!='')
                {
                    unlink($v_serverRoot.$data['userAvatar']);
                }
                if($_SESSION['userID'] == $data['userID'])
                {
                    $_SESSION['userAvatar'] =  $v_fileServerName;
                }

            }
            else
            {
                $v_return['status'] = false;
            }
            return $v_return;
        }
    }

    public function appGetViperPhoto($data = NULL){

        $v_alarmeID = !empty($data['alarmeID']) ? $data['alarmeID'] : NULL;
        $query = "SELECT photo_original_name,customer_token,nuc FROM %appDBprefix%_view_photo_alarme_viper WHERE alarme_id = $v_alarmeID ";
        $v_return = $this->dbCon->dbSelect($query);
        return $v_return['rsData'];
    }

    public function appEmailPhotoData($data):array
    {
        $query = "SELECT email_id,customer_id,customer_token,user_id,alarme_type_id,alarme_desc,video_code,photo,photo_original_name,cam_folder,alarme_datetime,read_at,read_count,validated_at,created_at FROM %appDBprefix%_view_email_photo_data WHERE video_code = '".$data."' ORDER BY photo_original_name ASC";
        $v_dbReturn = $this->dbCon->dbSelect($query);

        $v_return['photoTotal'] = $v_dbReturn['rsTotal'];
        $v_return['emailID'] = $v_dbReturn['rsData'][0]['email_id'];
        $v_return['customerID'] = $v_dbReturn['rsData'][0]['customer_id'];
        $v_return['customerToken'] = $v_dbReturn['rsData'][0]['customer_token'];
        $v_return['userID'] = $v_dbReturn['rsData'][0]['user_id'];
        $v_return['alarmeTypeID'] = $v_dbReturn['rsData'][0]['alarme_type_id'];
        $v_return['alarmeDesc'] = $v_dbReturn['rsData'][0]['alarme_desc'];
        $v_return['camPath'] = $v_dbReturn['rsData'][0]['cam_folder'];

        foreach ($v_dbReturn['rsData'] as $k => $v) {
            $v_return['photoArray'][] = $_SERVER['DOCUMENT_ROOT']."/__appCloud/".$v_return['customerToken']."/".$v_return['camPath']."/".$v['photo_original_name'];
            $v_return['photoDuration'][] = 40;
        }
        $v_return['status'] = true;
        return $v_return;
    }

    public function appEmailUpdateRead($data):array
    {
        $query = "UPDATE %appDBprefix%_alarme_email_data SET read_count = read_count+1 WHERE video_code = '".$data."'";
        $v_return = $this->dbCon->dbUpdate($query);
        $v_return['status'] = true;
        return $v_return;
    }

    public function appAlarmeEmailData($data = NULL)
    {
        $v_reqMethod = $data['method'];
        if ($v_reqMethod === "PUT")
        {
            $query = "UPDATE %appDBprefix%_alarme_email_data SET read_count = read_count+1 WHERE video_code = '".$data['videoCode']."'";
            $v_return = $this->dbCon->dbInsert($query);
            $v_return['status'] = true;
            return $v_return;

        }elseif($v_reqMethod === "POST"){
            $v_customerID = $data['customerID'] ?? NULL;
            $v_userID = $data['userID'] ?? '';
            $v_alarmeTypeID = $data['alarmeTypeID'] ?? NULL;
            $v_alarmeID = $data['alarmeID'] ?? NULL;
            $v_videoCode = $data['videoCode'] ?? NULL;

            $query  = "INSERT INTO %appDBprefix%_alarme_email_data (customer_id, user_id, alarme_type_id, alarme_id, video_code) ";
            $query .= "VALUES ('".$v_customerID."','".$v_userID."',".$v_alarmeTypeID.",".$v_alarmeID.",'".$v_videoCode."')";
           // trigger_error ( "Query: $query", E_USER_ERROR );
            $v_insertData = $this->dbCon->dbInsert($query);
            $v_return['status'] = true;
            $v_return['emailID'] = $v_insertData['rsInsertID'];
            return $v_return;
        }
    }

    public function appSendEmailViper($data = NULL){

        /*  pegar dados do customer (customerName, customerEmail,) OK
         *
         *  pegar dados do alerta (data,hora,camera) - OK
         *
         *  pegar dados AlarmeEmailData (alarmeID, videoCode)
         *
         * */

        //get customer data (customerName, customerEmail)

        $v_customerData = new appDataList();
        $v_customerList = $v_customerData->appCustomerList($data);
        $v_customer = $v_customerList['rsData'][0];
       // print "customer_nome_fantasia = ".$v_customer['customer_nome_fantasia']. " customer_email = ".$v_customer['customer_email'];


        $v_fileName = $data['fileName'] ?? NULL;//ex. AL_VIPE_000007_26112021_073000_06_00.JPG
        if($v_fileName){
            $v_dateTime = substr($v_fileName,15,15);
            $v_dateTimeObj = date_create_from_format('dmY_His',$v_dateTime);
            $v_alertData = (string) date_format($v_dateTimeObj,'d/m/Y');
            $v_alertHora = (string) date_format($v_dateTimeObj,'H:i:s');
            $v_alertCamera = substr($v_fileName,31,2)	;
            $data['customerEmail'] = $v_customer['customer_email'];
            $data['customerName'] = $v_customer['customer_nome_fantasia'];
            //teste Email
            $v_dataParse = array(
                'customerName' => $v_customer['customer_nome_fantasia'],
                'alertData' => $v_alertData,
                'alertHora' => $v_alertHora,
                'alertCamera' => $v_alertCamera,
                'alertVideo' => ''.$GLOBALS['g_appRoot'].'/vasCloudVideo/Player/'.$data['videoCode'].'.gif',//hash 256
                'currentYear' => date('Y'),
                'vaSystemsDomain' => $GLOBALS['g_appRoot'],
                'videoCode' => $data['videoCode']
            );
            //var_dump($v_dataParse);die();
            $v_htmlBody = new appSystemTools();
            $v_htmlBody->contentParse(file_get_contents('../appSystemTemplate/appMailSendAlertViperTemplate.html'),$v_dataParse);
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

                $v_sendInvitation->setFrom('suporte@vasystem.com.br', 'VA Systems');
                $v_sendInvitation->addReplyTo('suporte@vasystem.com.br', 'VA Systems');
                $v_sendInvitation->addAddress($v_customer['customer_email'], $v_customer['customer_nome_fantasia']);
                $v_sendInvitation->Subject = 'Alerta detectado.';
                $v_sendInvitation->msgHTML($v_htmlMsg);
                $v_sendInvitation->AltBody = 'Acabamos de detectar um alerta, seguem os dados: Data '.$v_dataParse['alertData'].' às '.$v_dataParse['alertHora'].' na câmera '.$v_dataParse['alertCamera'];
                if ($v_sendInvitation->send()) {
                    $v_return['sendEmail'] = true;
                } else {
                    $v_return['sendEmail'] = false;
                }
            }
            catch (Exception $e) {
                echo 'A mensagem não pode ser enviada. Mailer Error: ', $v_sendInvitation->ErrorInfo;
            }
        }


    }

}