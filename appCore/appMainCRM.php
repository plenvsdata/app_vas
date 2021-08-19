<?php
session_start();

include ("../appGlobals/appGlobalSettings.php");
require ("../appClasses/appGlobal.php");

use app\userAccess\appUserControl as appLoginCheck;

session_regenerate_id();

$_SESSION['sesChk'] = session_id();
$v_lgnError = false;
$dbHome = new appLoginCheck();
$vLgnCheck = $dbHome->userSessionCheck();

if(!$vLgnCheck) {
    header('Location: '.$GLOBALS['g_appRoot'].'/SignIn');
    die();
}

//$dbHome->setUserSessionHomePosition();//set Default Location for User

if(isset($_SESSION['adminErrCode']))
{
    $v_lgnError = true;
}

$v_appCrmPage = ($_REQUEST['pageData']!="Default") ? $_REQUEST['pageData'] : "appTemplate";
$v_sec = !empty($_REQUEST['sec']) ? $_REQUEST['sec'] : '';
$v_pageName = $v_appCrmPage.$v_sec;

$v_pageContent = array_key_exists($v_pageName,$g_appPageData) ? $g_appPageData[$v_pageName] : "appTemplate";
var_dump($v_pageContent);
if(!file_exists($v_pageContent.".php")) {
    /*
        $v_url = $GLOBALS['g_appRoot'].'/Welcome';
        $v_redirect  = '<script type="text/javascript">';
        $v_redirect .= 'window.location = "' . $vURL . '"';
        $v_redirect .= '</script>';
        echo $v_url;
    */
    $v_pageContent = "appTemplate";
}
?>
<!DOCTYPE html>
<html lang="<?=$g_appLanguage?>">
<head>
    <? include("appHeadMeta.php");?>
    <? include("appHeadStyles.php");?>
    <? include("appHeadJQuery.php");?>
</head>

<body class="fix-header fix-sidebar card-no-border">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->

<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">

    <header class="topbar">
        <? include ("appHeader.php");?>
    </header>

    <? include ("appLeftSideBar.php");?>
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">

        <!-- Container fluid  -->
    <!-- ============================================================== -->

        <? include ($v_pageContent.".php");?>

        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->

<? include ("appPlugins.php");?>
</body>
</html>