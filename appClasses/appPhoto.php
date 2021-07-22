<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 21/01/2018
 * Time: 23:55
 */

namespace app\System\Photo;

use app\dbClass\appDBClass;

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
            $v_photoID = !empty($data['photoID']) ? $data['photoID'] : NULL;
            $query = "SELECT clnt,photo_id,photo_type_id,photo_type_desc,photo,photo_original_name,photo_crc,photo_extension,photo_mime,photo_notes,photo_size,product_id,product_desc,product_type_id,product_type_desc,manufacturer_id,manufacturer_desc,product_category_id,product_category_desc,base_price,created_at,created_by,user_name,photo_status FROM %appDBprefix%_view_product_photo_list  WHERE photo_id = $v_photoID AND clnt = '".$_SESSION['userClnt']."'";
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

    public function  appUserPhotoData($data = NULL,$file = NULL)
    {
        $v_reqMethod = $data['method'];
        $v_serverRoot = $_SERVER['DOCUMENT_ROOT']."/__appFiles/".$_SESSION['userID']."/_userAvatar/";
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

                if($data['userAvatar']!='default_avatar.png')
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



}