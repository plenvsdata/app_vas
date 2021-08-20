<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 31/01/2018
 * Time: 13:13
 */
$v_sectionIDCheck = true;
$_dataSectionCheck = 'true';
if(isset($_SESSION['sectionIDCheck'])){
    if(!$_SESSION['sectionIDCheck']){
        $v_sectionIDCheck = false;
        $_dataSectionCheck = 'false';
        $_SESSION['sectionIDCheck'] = true;
    }
}
?>

<script src='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.css' rel='stylesheet' />

<style>
    .modal-lg {
        max-width: 90% !important;
    }
    .flex-item
    {
        justify-content: space-around;
    }
    .help-block {display: none;}
    .hidden
    {
        display: none!important;
    }
    .btn-organizer
    {
        border: 1px solid #D9D9D9!important;
        height: 38px!important;
        background-color: #ffffff;
    }
    .btn-organizer-error
    {
        border: 1px solid #ef5350!important;
        height: 38px!important;
        background-color: #ffffff;
    }
    .btn-left-radius
    {
        border-radius: 4px 0 0 4px!important;
    }
    .btn-right-radius
    {
        border-radius: 0 4px 4px 0!important;
    }
    .cardPosition {
        position: relative!important;
    }
    .customersMaps {
        height: 550px!important;
        border-radius: 5px!important;
        top:0;
        bottom:0;
        width:100%!important;
        position: relative;
        z-index: 29;
    }
    .mapDivLoaderBackdrop {
        border-radius: 5px!important;
        position: absolute;
        background-color: #FFFFFF;
        z-index: 30;
        top: 0!important;
        bottom: 0!important;
        width: 100%!important;
    }
    .mapDivLoader {
        position: absolute;
        width: 100%!important;
        bottom: 0!important;
        top: 0!important;
        background-color: #67757c;
        background-position: center;
        background-repeat: no-repeat;
        background-size: 150px;
        opacity: 1;
        overflow: hidden;
        -webkit-mask-image: url("../../appImages/svgLoaders/rings.svg");
        -webkit-mask-position: center!important;
        -webkit-mask-repeat: no-repeat!important;
        -webkit-mask-size: 150px!important;
        mask-image: url("../../appImages/svgLoaders/rings.svg");
        mask-position: center;
        mask-repeat: no-repeat;
        mask-size: 150px!important;
        z-index: 31;
    }
    .container-fluid{
        padding: 0 10px 0 10px!important;
    }
</style>
<div class="row page-titles basicContent">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><?=$v_appCrmPage?></h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=$GLOBALS['g_appRoot']?>/Welcome">Home</a></li>
            <li class="breadcrumb-item">Relatório</li>
            <li class="breadcrumb-item active"><?=$v_appCrmPage?></li>
        </ol>
    </div>
</div>
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid basicContent">
    <div class="row">
        <div class="col-12">
            <div class="card" id="mainCard">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <div class="table-responsive">
                        <table id="appDatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Aplicação</th>
                                <th>Origem</th>
                                <th>Código</th>
                                <th>Câmera</th>
                                <th>Data</th>
                            </tr>
                            </thead>
                            <tbody class="text-center"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

<div id="popoverData" style="display: none"></div>

<script type="text/javascript">

    $.docData = {
        dtTable : null,
        comboCountry : "",
        mapData :  null,
        customerDtTable : null,
        countryChangeState : false,
        stateChangeState : false,
        dataSectionCheck : <?=$_dataSectionCheck?>
    };

    function showMap() {
        $('.mapDiv').fadeOut(500);
    }

    $(document).ready(function() {

        $.docData.dtTable = $('#appDatatable').DataTable(
            {
                "autoWidth": false,
                "paging": true,
                "pageLength": 10,
                "dom": '<"dtFloatRight"f><"dtInfoBeta">rt<"dtCenter"i<"#excelBtnDiv.dtFloatLeft hidden"B><"dtFloatLeft"><"dtFloatRight"p>>',
                "ajax":
                    {
                        "url": "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appListAlarmeViper",
                        "xhrFields": { withCredentials: true },
                        "dataSrc": "appViperList",
                        "dataType": "json",
                        "type": "POST",
                        "headers":
                            {
                                "appDatatable":true
                            },
                        "data": function(d){ }
                    },
                <?php
                if(in_array($_SESSION['accessProfileID'],$GLOBALS['g_allowExport'])){
                ?>
                "buttons":
                    [
                        {"extend": 'excelHtml5', "text": 'Excel', "className": 'btn btn-sm dt-btn-width btn-success buttons-html5 hidden', "attr": { id: 'exportExcel' }}
                    ],
                <?php
                }
                ?>
                "initComplete": function () {
                    <?php
                    if(in_array($_SESSION['accessProfileID'],$GLOBALS['g_allowExport'])){
                    ?>
                    $('#exportExcel').removeClass('hidden');
                    $('#excelBtnDiv').removeClass('hidden');

                    <?php
                    }
                    ?>
                    $(".dt-buttons").removeClass("btn-group");
                    v_setTooltip();
                },
                "drawCallback": function( settings ) {
                },
                "columns":
                    [
                        { data: "customer_nome_fantasia", "className":"text-left" },
                        { data: "apl", "className":"text-left" },
                        { data: "origem_desc", "className":"text-left" },
                        { data: "cod", "className":"text-right" },
                        { data: "nuc", "className":"text-right" },
                        { data: "data_br", "className":"text-right text-monospace" }
                    ],
                "createdRow": function( row, data, dataIndex )
                {
                },
                "columnDefs":
                    [
                        {
                        }
                    ]
            }
        );
    });
</script>


