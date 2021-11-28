<?php
session_start();

include ("../appGlobals/appGlobalSettings.php");
require ("../appClasses/appGlobal.php");

use app\System\API\appDataAPI;
use movemegif\domain\FileImageCanvas;
use movemegif\GifBuilder;


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

elseif ($v_dataSec == "apiTeste") {
    $v_apiData[] = date("Y-m-d");
    header('Content-Type: application/json; charset=utf-8');
    //echo json_encode($v_origem);
    echo json_encode($v_apiData);
}
elseif ($v_dataSec = "Player") {
    $v_dataRequest = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_videoCode = $v_appRequest['video_code'] ?? NULL;//video_code.gif
    //$v_videoData = explode('.',$v_videoData);

   // $v_videoCode = $v_videoData[0];//video_code


    //INICIO EMAIL AO RECEBER ALERTA VIPER
    //gerar Gif
    require_once __DIR__ . '/../appClasses/autoloader.php';
    // no width and height specified: they will be taken from the first frame
    $builder = new GifBuilder();
    $builder->setRepeat();

    for ($i = 0; $i <= 4; $i++) {
        $builder->addFrame()
            ->setCanvas(new FileImageCanvas(__DIR__ . '/../__appFiles/4E74390CFBF0DFDD015BC04E2A630932FDB8B1E2A13192ECAB1BCD08E644CEBA/CAM20/06112021_030327_20_0' . $i . '.jpg'))
            ->setDuration(15);
    }

    return $builder->output($v_videoCode);



    //atualizar read_at     vas_alarme_email_data





    //Roda Classe de geração de GIF



}


else
{
    header("HTTP/1.0 404 Not Found");
}