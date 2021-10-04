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

    $v_alert = substr($v_appRequest['i3pData'],0,10);

    if($v_alert == '#XI3PALERT'){
        $v_origem = 'VIPER';
        $v_apiData = $v_appData->appCustomerAlarme($v_appRequest['i3pData'],$v_origem,$v_customerID);
    }
    else {
        $v_origem = 'OBCON';

        if(substr_count($v_appRequest['i3pData'],',') > 0) {
            $v_apiData = $v_appData->appCustomerAlarme($v_appRequest['i3pData'],$v_origem,$v_customerID);
        }else{
            $v_apiData = $v_appData->appAlarmeProblema($v_appRequest['i3pData']);
        }
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



else
{
    header("HTTP/1.0 404 Not Found");
}