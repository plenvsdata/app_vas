<?php
session_start();

include ("../appGlobals/appGlobalSettings.php");
require ("../appClasses/appGlobal.php");

use app\System\API\appDataAPI;
use app\System\Photo\appPhoto;

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
    $v_data['cloudPath'] = $_SERVER['DOCUMENT_ROOT']."/__appCloud/".$v_appRequest['customerToken']."/".$v_appRequest['camPath']."/";;
    $v_data['tokenData'] = $v_appRequest['customerToken'];
    $v_data['fileName'] = $v_fileName;
    $v_data['alarmID'] = $v_appRequest['alarmID'];
    $v_data['alarmType'] = $v_appRequest['alarmType'];
    $v_data['dateTime'] = $v_date[2].'-'.$v_date[1].'-'.$v_date[0].' '.$v_appRequest['alarmTime'];
    $v_file = $_FILES['image'];
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
    $v_videoData = $v_appRequest['videoData'] ?? NULL;
    $v_videoData = explode('.',$v_videoData);

    $v_gifData = $v_videoData[0];



    //Roda Classe de geração de GIF



}


else
{
    header("HTTP/1.0 404 Not Found");
}