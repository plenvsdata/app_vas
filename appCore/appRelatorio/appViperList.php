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
     tfoot input {
         width: 100%;
         padding: 3px;
         box-sizing: border-box;
         font-size: small;
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
                                <th class="text-center" style="width: 220px!important;">Cliente</th>
                                <th>ORI</th>
                                <th>IDR</th>
                                <th>NOR</th>
                                <th class="text-center" style="width: 60px!important;">COD</th>
                                <th>Data</th>
                                <th>NUC</th>
                                <th class="text-center" style="width: 80px!important;">APL</th>
                                <th>INS</th>
                                <th>Origem</th>
                                <th>Subtipo</th>
                                <th>NSB</th>
                                <th>SBN</th>
                                <th>COR</th>
                                <th>IPS</th>
                                <th>POS</th>
                            </tr>
                            </thead>
                            <tbody class="text-center"></tbody>
                            <tfoot id="appDatatableFoot" class="collapse">
                            <tr id="trFilters" class="collapse">
                                <th>Cliente</th>
                                <th>ORI</th>
                                <th>IDR</th>
                                <th>NOR</th>
                                <th>COD</th>
                                <th>Data</th>
                                <th>NUC</th>
                                <th>APL</th>
                                <th>INS</th>
                                <th>Origem</th>
                                <th>Subtipo</th>
                                <th>NSB</th>
                                <th>SBN</th>
                                <th>COR</th>
                                <th>IPS</th>
                                <th>POS</th>
                            </tr>
                            </tfoot>
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

        // Setup - add a text input to each footer cell
        $('#appDatatable tfoot th').each( function () {
            //var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Fitro" />' );
        });

        $.docData.dtTable = $('#appDatatable').DataTable(
            {
                "autoWidth": false,
                "paging": true,
                "pageLength": 10,
                "dom": '<"dtFloatRight"f><"#excelBtnDiv.dtFloatLeft hidden"B><"dtInfoBeta">rt<"dtCenter"i<"dtFloatLeft"><"dtFloatRight"p>>',
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
                "buttons":
                    [
                        {"text":'Filtros',"className": 'btn btn-sm dt-btn-width btn-info dtFloatSpaceLeft filterPage'},
                        <?php
                        if(in_array($_SESSION['accessProfileID'],$GLOBALS['g_allowExport'])){
                        ?>
                        {"extend": 'excelHtml5', "text": 'Excel', "className": 'btn btn-sm dt-btn-width btn-success buttons-html5 hidden', "attr": { id: 'exportExcel' }},
                        <?php
                        }
                        ?>
                        {"extend": 'colvis', "text": 'Colunas', "className": 'btn btn-sm dt-btn-width btn-info dtFloatSpaceLeft' }
                    ],
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
                    let r = $('#appDatatable tfoot tr');
                    r.find('th').each(function(){
                        $(this).css('padding', 8);
                    });
                    $('#appDatatable thead').append(r);
                },
                "drawCallback": function( settings ) {
                },
                "columns":
                    [
                        { data: "customer_nome_fantasia", "className":"text-left text-monospace reportCustomerCol" },
                        { data: "ori", "className":"text-center text-monospace" },
                        { data: "idr", "className":"text-right text-monospace" },
                        { data: "nor", "className":"text-left text-monospace" },
                        { data: "cod", "className":"text-right text-monospace" },
                        { data: "data_br", "className":"text-right text-monospace" },
                        { data: "nuc", "className":"text-right text-monospace" },
                        { data: "apl", "className":"text-left text-monospace reportCustomer80px" },
                        { data: "ins", "className":"text-right text-monospace" },
                        { data: "origem_desc", "className":"text-left text-monospace" },
                        { data: "subtipo_desc", "className":"text-left text-monospace" },
                        { data: "nsb", "className":"text-right text-monospace" },
                        { data: "sbn", "className":"text-right text-monospace" },
                        { data: "cor", "className":"text-left text-monospace" },
                        { data: "ips", "className":"text-left text-monospace" },
                        { data: "pos", "className":"text-left text-monospace" }
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

        // Apply the search
        $.docData.dtTable.columns().every( function () {
            let that = this;
            $( 'input', this.footer() ).on( 'keyup change', function ()
            {
                //console.log(that.search()+'-vs-'+this.value);
                if ( that.search() !== this.value )
                {
                    that.search( this.value ).draw();
                }
            });
        });


        $('.filterPage').on( 'click',function () {
            $('#filterDiv').collapse('toggle');
            $('#appDatatableFoot').collapse('toggle');
            $('#trFilters').collapse('toggle');
        });
    });
</script>


