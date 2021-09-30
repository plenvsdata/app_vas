<?php
session_start();

include ("../appGlobals/appGlobalSettings.php");
require ("../appClasses/appGlobal.php");

use app\System\API\appDataAPI;

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
    $v_customerID = $v_appRequest['customerID'];
    $v_appData = new appDataAPI();

    if(strpos($v_appRequest['i3pData'],'#XI3PALERT')){
        //echo 'VIPER';
        $v_apiData = $v_appData->appCustomerAlarme($v_appRequest['i3pData'],'VIPER',$v_customerID);
    }
    else {
        //echo 'OBCON';
        $v_apiData = $v_appData->appCustomerAlarme($v_appRequest['i3pData'],'OBCON',$v_customerID);
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($v_apiData);
}


else
{
    header("HTTP/1.0 404 Not Found");
}