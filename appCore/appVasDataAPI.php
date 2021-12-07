<?php
session_start();

include ("../appGlobals/appGlobalSettings.php");
require ("../appClasses/appGlobal.php");
require_once __DIR__ . '/../appClasses/autoloader.php';

use app\System\API\appDataAPI;
use gifCreator\GifCreator;
use app\System\Photo\appPhoto;
use app\System\ErrorLog\ErrorLog;

$v_dataSec = !empty($_REQUEST['dataSec']) ? $_REQUEST['dataSec'] : NULL;

if($v_dataSec == "customerTokenData") {
    $v_appRequest = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appData = new appDataAPI();
    $v_apiData = $v_appData->appCustomerTokenData($v_appRequest);

    if($v_apiData['customer_status'] == 1){
        $v_apiData['customer_status'] = true;
    } else {
        $v_apiData['customer_status'] = false;
    }
    $v_apiData['lastUpdate'] = date('d/m/Y H:i:s');

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($v_apiData);
}
elseif ($v_dataSec == "checkAppConnection") {
    $v_appRequest = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appData = new appDataAPI();
    $v_apiData = $v_appData->appCustomerLicenceData($v_appRequest);

    if($v_apiData['customer_status'] == 1) {
        $v_returnData['customerLicence'] = true;
    }else{
        $v_returnData['customerLicence'] = false;
    }
    $v_returnData['ping'] = true;
    $v_returnData['lastUpdate'] = date('d/m/Y H:i:s');
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "i3pDataReceiver") {
    $v_appRequest = !empty($_REQUEST) ? $_REQUEST : NULL;

    $v_errorLog = new ErrorLog();
    $v_errorInsert = $v_errorLog->appInsertFullData($v_appRequest);

    $v_customerID = $v_appRequest['customerID'] ?? NULL;

    if($v_customerID == NULL){
        header("HTTP/1.0 404 Not Found");
        die();
    }

    $v_appData = new appDataAPI();

    $v_alarmType = substr($v_appRequest['i3pData'],0,10);

    if($v_alarmType == '#XI3PALERT'){
        $v_origem = 'VIPER';
        $v_apiData = $v_appData->appCustomerAlarme($v_appRequest['i3pData'],$v_origem,$v_customerID);
    }
    elseif($v_alarmType == '#XI3POBCDE'){
        $v_origem = 'OBCON';
        $v_apiData = $v_appData->appCustomerAlarme($v_appRequest['i3pData'],$v_origem,$v_customerID);
    }
    else {
        $v_origem = 'desconhecida';
        $v_apiData = $v_appData->appCustomerAlarme($v_appRequest['i3pData'],$v_origem,$v_customerID);
    }

    header('Content-Type: application/json; charset=utf-8');
    //echo json_encode($v_origem);
    echo json_encode($v_apiData);
}
elseif ($v_dataSec == "i3pPhotoReceiver") {
    $v_appRequest = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_customerID = $v_appRequest['customerID'] ?? NULL;
    $v_file = $_FILES['image'];
    $v_fileName = (hash('sha256',$v_appRequest['customerToken'].$v_file['name'][0].time()));
    $v_return['uploadStatus'] = true;

    $v_data['method'] = 'POST';
    $v_data['customerID'] = $v_customerID;

    if($v_customerID == NULL){
        header("HTTP/1.0 404 Not Found");
        die();
    }

    $v_date = explode('/',$v_appRequest['alarmDate']);
    $v_data['cloudPath'] = $_SERVER['DOCUMENT_ROOT']."/__appCloud/".$v_appRequest['customerToken']."/".$v_appRequest['camPath']."/";
    $v_data['tokenData'] = $v_appRequest['customerToken'];
    $v_data['fileName'] = $v_fileName;
    $v_data['alarmID'] = $v_appRequest['alarmID'];
    $v_data['alarmType'] = $v_appRequest['alarmType'];
    $v_data['dateTime'] = $v_date[2].'-'.$v_date[1].'-'.$v_date[0].' '.$v_appRequest['alarmTime'];
    $v_fileCount = count($v_file);

    $v_photoData = new appPhoto();

    for ($i = 0; $i < $v_fileCount; $i++) {
        $v_data['file'] = $v_file;
        $v_data['fileExt'] = 'JPG';
        $v_data['fileNumber'] = $i;
        $v_photoDataReturn = $v_photoData->appAlarmCloud($v_data,$_FILES['image']);

        if(!$v_photoDataReturn['status']){
            $v_return['uploadStatus'] = false;
            break;
        }
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($v_return);
}

elseif ($v_dataSec == "apiTeste") {
    $v_apiData[] = date("Y-m-d");
    header('Content-Type: application/json; charset=utf-8');
    //echo json_encode($v_origem);
    echo json_encode($v_apiData);
}
elseif ($v_dataSec = "Player") {
    $v_dataRequest = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_videoCode = $v_dataRequest['videoData'] ?? NULL;//video_code.gif
    $v_videoData = new appPhoto();
    $v_gifData = $v_videoData->appEmailPhotoData($v_videoCode);

    $v_customerID = $v_gifData['customerID'];
    $v_customerToken = $v_gifData['customerToken'];
    $v_emailID = $v_gifData['emailID'];
    $v_userID = $v_gifData['userID'];
    $v_alarmeTypeID = $v_gifData['alarmeTypeID'];
    $v_alarmeDesc = $v_gifData['alarmeDesc'];
    $v_camPath = $v_gifData['camPath'];
    $v_photoArray = $v_gifData['photoArray'];
    $v_photoDurationArray = $v_gifData['photoDuration'];
    $v_status = $v_gifData['status'];

    $v_cloudPath = $_SERVER['DOCUMENT_ROOT']."/__appCloud/".$v_customerToken."/".$v_camPath."/";
    $v_gifCreator = new GifCreator();
    $v_gifCreator->create($v_photoArray,$v_photoDurationArray,0);
    $gifBinary = $v_gifCreator->getGif();
    $v_gifName = $v_videoCode.'.gif';
    $v_videoData->appEmailUpdateRead($v_videoCode);
    header('Content-type: image/gif');
    header('Content-Disposition: filename="'.$v_gifName.'"');
    echo $gifBinary;
    exit;
}
elseif ($v_dataSec = "eventValidation") {
    $v_dataRequest = !empty($_REQUEST) ? $_REQUEST : NULL;

    var_dump($v_dataRequest);


}


else
{
    header("HTTP/1.0 404 Not Found");
}