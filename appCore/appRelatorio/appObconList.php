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

$v_dateEnd = date('Y-m-d');
$v_timestamp1 = strtotime($v_dateEnd);
$v_timestamp2 = strtotime('-7 day', $v_timestamp1);
$v_dateStart = date('Y-m-d',$v_timestamp2);

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
            <li class="breadcrumb-item"><a href="<?=$GLOBALS['g_appRoot']?>/MeuPerfil">Home</a></li>
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
                    <div>
                        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; width: 230px; border: 1px solid #ccc;white-space: nowrap!important;">
                            <input type="hidden" name="dateStart" id="dateStart" value="<?=$v_dateStart?>">
                            <input type="hidden" name="dateEnd" id="dateEnd" value="<?=$v_dateEnd?>">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="appDatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center reportCustomerData">Data</th>
                                <th class="text-center reportCustomerHora">Hora</th>
                                <th class="text-center reportCustomer80px">Clid</th>
                                <th>Cliente</th>
                                <th>NINST</th>
                                <th>CAM</th>
                                <th>TW</th>
                                <th>SENT</th>
                                <th>NUMO</th>
                                <th>TAMA</th>
                            </tr>
                            </thead>
                            <tbody class="text-center"></tbody>
                            <tfoot id="appDatatableFoot" class="collapse">
                            <tr id="trFilters" class="collapse">
                                <th>Data</th>
                                <th>Hora</th>
                                <th>Clid</th>
                                <th>Cliente</th>
                                <th>NINST</th>
                                <th>CAM</th>
                                <th>TW</th>
                                <th>SENT</th>
                                <th>NUMO</th>
                                <th>TAMA</th>
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
        dataSectionCheck : <?=$_dataSectionCheck?>,
        dataStart: '<?=$v_dateStart?>',
        dataEnd: '<?=$v_dateEnd?>',
    };

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
                        "url": "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appListAlarmeObcon",
                        "xhrFields": { withCredentials: true },
                        "dataSrc": "appObconList",
                        "dataType": "json",
                        "type": "POST",
                        "headers":
                            {
                                "appDatatable":true
                            },
                        "data": function(d){
                            d.dataStart = $.docData.dataStart,
                            d.dataEnd = $.docData.dataEnd
                        }
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
                        { data: "data_br", "className":"text-left text-monospace reportCustomerData" },
                        { data: "hora", "className":"text-right text-monospace reportCustomerHora" },
                        { data: "clid", "className":"text-right text-monospace reportCustomer80px" },
                        { data: "customer_nome_fantasia", "className":"text-left text-monospace reportCustomerCol" },
                        { data: "ninst", "className":"text-right text-monospace" },
                        { data: "cam", "className":"text-right text-monospace" },
                        { data: "tw", "className":"text-right text-monospace" },
                        { data: "sent", "className":"text-left text-monospace" },
                        { data: "numo", "className":"text-right text-monospace" },
                        { data: "tama", "className":"text-right text-monospace" }
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
                    that.search( this.value ? '^'+this.value+'$' : '', true, false ).draw();
                }
            });
        });

        $('.filterPage').on( 'click',function () {
            $('#filterDiv').collapse('toggle');
            $('#appDatatableFoot').collapse('toggle');
            $('#trFilters').collapse('toggle');
        });

        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            $('#dateStart').val(picker.startDate.format('YYYY-MM-DD'));
            $('#dateEnd').val(picker.endDate.format('YYYY-MM-DD'));
            $.docData.dataStart = $('#dateStart').val();
            $.docData.dataEnd = $('#dateEnd').val();
            $.docData.dtTable.ajax.reload(v_setTooltip);
        });

        $('#reportrange').on('show.daterangepicker', function(ev, picker) {
            //var v_rangePosition = parseInt($.reportData.dateRangePosition.top) + parseInt($.reportData.dateRangeHeight)-2;
            //console.log($.this.dateRangePosition.top);
            //$('.daterangepicker').css('top',v_rangePosition+'px');
        });

        let start = moment('<?=$v_dateStart?>');
        let end = moment();

        $('#reportrange').daterangepicker({
            "locale": {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "customRangeLabel": "Período",
                "daysOfWeek": [
                    "D",
                    "S",
                    "T",
                    "Q",
                    "Q",
                    "S",
                    "S"
                ],
                "monthNames": [
                    "Janeiro",
                    "Fevereiro",
                    "Março",
                    "Abril",
                    "Maio",
                    "Junho",
                    "Julho",
                    "Agosto",
                    "Setembro",
                    "Outubro",
                    "Novembro",
                    "Dezembro"
                ],
                "firstDay": 1
            },
            cancelClass: "btn-danger",
            startDate: start,
            endDate: end,
            minDate:"01-10-2021",
            maxDate: moment(),
            ranges: {
                'Hoje': [moment(), moment()],
                'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                'Este Mês': [moment().startOf('month'), moment().endOf('month')],
                'Último Mês': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
    });

    function cb(start, end) {
        $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }

</script>


