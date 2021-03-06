<?php
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Credentials: true');
/**
 * Created by PhpStorm.
 * User: William
 * Date: 25/10/2021
 * Time: 13:00
 */
session_start();
require($_SERVER['DOCUMENT_ROOT'] . "/appClasses/appGlobal.php");
require($_SERVER['DOCUMENT_ROOT'] . "/appGlobals/appGlobalSettings.php");

use app\System\Chart\appChart;

$v_dataSec = !empty($_REQUEST['dataSec']) ? $_REQUEST['dataSec'] : NULL;

/* API Features */
//Charts

if($v_dataSec == "appChartInOutEntradaSaida")
{
$v_appRequest = !empty($_REQUEST) ? $_REQUEST : NULL;
$v_appData = new appChart();
$v_appChart = $v_appData->chartInOutEntradaSaida($v_appRequest);

echo json_encode($v_appChart);
}
elseif($v_dataSec == "appChartInOutDashboardDia")
{
    $v_appRequest = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appData = new appChart();
    $v_appChart = $v_appData->chartInOutDashboardDia($v_appRequest);
    echo json_encode($v_appChart);
}
/* API Not Found */
else
{
    header("HTTP/1.0 404 Not Found");
}
