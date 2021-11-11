<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 16/11/2017
 * Time: 23:38
 */
?>
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<!--
<script src="<?=$GLOBALS['g_appRoot']?>/js/bootstrap/4.3.1/js/popper.min.js"></script>
-->

<script src="<?=$GLOBALS['g_appRoot']?>/js/jQuery/3.6.0/jquery-3.6.0.min.js"></script>
<script src="<?=$GLOBALS['g_appRoot']?>/js/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>

<script src="<?=$GLOBALS['g_appRoot']?>/js/Plugins/jquery.removeClassRegExp/jquery.removeClassRegExp.min.js"></script>
<script src="<?=$GLOBALS['g_appRoot']?>/js/Plugins/jquery-serializeJSON/jquery.serializejson.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script type="text/javascript" src="<?=$GLOBALS['g_appRoot']?>/js/Plugins/dropzone/js/dropzone.min.js"></script>
<script type="text/javascript">
    Dropzone.autoDiscover = false;
    $.systemData = {
        protocol: window.location.protocol,
        domain: window.location.hostname,
        port: window.location.port,
        url: window.location.protocol+'//'+window.location.hostname+':'+window.location.port,
    };

</script>
