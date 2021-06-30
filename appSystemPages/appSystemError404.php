<?php
session_start();
require_once ('../appGlobals/appGlobalSettings.php');
require("../appClasses/appGlobal.php");

?>
<!DOCTYPE html>
<html lang="<?=$g_appLanguage?>">
<head>
    <?php
    include ('../appCore/appHead.php');
    ?>

    <style>
        .btn-signup {
            position: absolute;
            right: 0;
            z-index: 9999;
            top: 0!important;
            margin: 5px!important;
        }
    </style>

</head>

<body class="fix-header card-no-border">

<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper" class="error-page">
    <div class="error-box">
        <div class="error-body text-center">
            <h1>404</h1>
            <h3 class="text-uppercase">Page Not Found !</h3>
            <p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
    </div>
</section>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
</body>
</html>