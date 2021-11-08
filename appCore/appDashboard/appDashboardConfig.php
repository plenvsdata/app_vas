<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 31/01/2018
 * Time: 13:13
 */
use app\System\Combo\appCombo;
use app\System\Lists\appDataList;
use  app\System\API\appDataAPI;

$v_dashboardID = !empty($_REQUEST['dataValue']) ? $_REQUEST['dataValue'] : null;
$v_comboData = new appCombo();
$v_comboProfile = $v_comboData->comboSystemAccessProfile('array');
$v_comboCustomer = $v_comboData->comboCustomer('array');
$v_data['dashboardID'] = $v_dashboardID;

$v_checkCounterData = new appDataAPI();
$v_checkCounter = $v_checkCounterData->appObconCounter($v_data,false,true);

$v_listDashboard = new appDataList();
$v_dashboardList = $v_listDashboard->appDashboardList($v_data);
$v_dashboardData = $v_dashboardList['rsData'][0];

if(is_null($v_dashboardData)){
    header('location:../Dashboard');
}

$v_sectionIDCheck = true;
$_dataSectionCheck = 'true';
if(isset($_SESSION['sectionIDCheck'])){
    if(!$_SESSION['sectionIDCheck']){
        $v_sectionIDCheck = false;
        $_dataSectionCheck = 'false';
        $_SESSION['sectionIDCheck'] = true;
    }
}
$v_chart2DateEnd = date('Y-m-d');
$v_timestamp1 = strtotime($v_chart2DateEnd);
$v_timestamp2 = strtotime('-30 day', $v_timestamp1);
$v_chart2DateStart = date('Y-m-d',$v_timestamp2);
?>
<style>
    .flex-item
    {
        justify-content: space-around;
    }
    .help-block {display: none;}-
    .hidden
    {
        display: none!important;
    }
    .bootbox .modal-header h4 {
        order: 0;
    }
    .bootbox .modal-header button {
        order: 1;
    }
    .teste_class .modal-header{
        display: flex!important;
    }
</style>
<div class="row page-titles basicContent">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=$GLOBALS['g_appRoot']?>/MeuPerfil">Home</a></li>
            <li class="breadcrumb-item">Obcon</li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
</div>

<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid basicContent">
    <div class="row">
        <div class="col-5 pr-1">
            <div class="card">
                <div class="card-body p-1">
                    <div class="row m-1">
                        <div class="col-md-12 mb-2">
                            <div class="position-absolute w-100" style="right: 0px!important;"><i id="zeraContador" class="fa fa-refresh pull-right r-5 hide" aria-hidden="true" style="cursor: pointer!important;"></i></div>
                            <h4><?=$v_dashboardData['dashboard_desc']?></h4>
                            <h6>Data do Controle: <span id="controleData"></span> - Horário de Início: <span id="controleHora"></span></h6>
                        </div>
                        <div class="col-4 p-1">
                            <div class="col-12 dashboardPanel shadow" style="border-radius: 10px!important;">
                                <h6 class="text-black-50">Entradas</h6>
                                <h2 class="w-100 text-center text-black" id="countEntrada">0</h2>
                            </div>
                        </div>
                        <div class="col-4 p-1">
                            <div class="col-12 dashboardPanel shadow" style="border-radius: 10px!important;">
                                <h6 class="text-black-50">Saídas</h6>
                                <h2 class="w-100 text-center text-black" id="countSaida">0</h2>
                            </div>
                        </div>
                        <div class="col-4 p-1">
                            <div class="col-12 dashboardPanel shadow" style="border-radius: 10px!important;">
                                <h6 class="text-black-50">Contagem Atual</h6>
                                <h2 class="w-100 text-center text-black" id="countTotal">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-12 p-4">

                            <h6>Últimos Eventos</h6>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="appDatatableLastEvent" class="display nowrap table table-hover table-striped table-bordered appDatatableLastEvent" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Data e Hora</th>
                                            <th>Câmera</th>
                                            <th>Evento</th>
                                        </tr>
                                        </thead>
                                        <tbody style="text-align: center!important;"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7 pl-1">
            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="dashboardTabList" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link dashboardNavPanel" id="obconReport-tab" data-toggle="tab" href="#obconReport" role="tab" aria-controls="obconReport" aria-selected="true">Consolidação</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link dashboardNavPanel active" id="obconChart-tab" data-toggle="tab" href="#obconChart" role="tab" aria-controls="obconChart" aria-selected="true">Gráficos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link dashboardNavPanel" id="dashboardInformation-tab" data-toggle="tab" href="#dashboardInfo" role="tab" aria-controls="dashboardInfo" aria-selected="true">Informações</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link dashboardNavPanel" id="dashboardConfig-tab" data-toggle="tab" href="#dashboardConfig" role="tab" aria-controls="dashboardConfig" aria-selected="true">Configuração</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="dashboardContent">
                        <div class="tab-pane fade" id="obconReport" role="tabpanel" aria-labelledby="obcon-tab">
                            <div class="row pt-0">
                                <div class="col-12 p-4">
                                    <h6 class="text-left">Últimos Dias</h6>
                                    <table id="appDatatableLastDays" class="display nowrap table table-hover table-striped table-bordered appDatatableLastDays" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Entradas</th>
                                            <th>Saídas</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody style="text-align: center!important;"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="obconChart" role="tabpanel" aria-labelledby="chart-tab">

                            <div class="row pb-4">
                                <div class="col-12">
                                    <div style="width: 100%!important;" id="chart_hoje"></div>
                                </div>
                                <div class="col-12" style="font-size: 12px!important;">
                                    <i class="fa fa-square" style="color:#3666CC" aria-hidden="true"></i> Entradas&nbsp;&nbsp;&nbsp;
                                    <i class="fa fa-square" style="color:#DC3913" aria-hidden="true"></i> Saídas
                                </div>
                            </div>

                            <hr>
                            <div class="row pt-4">
                                <div class="col-12">
                                    <div id="chart2Range" style="background: #fff; cursor: pointer; padding: 5px 10px; width: 250px; border: 1px solid #ccc;white-space: nowrap!important;">
                                <input type="hidden" name="chart2DateStart" id="chart2DateStart" value="<?=$v_chart2DateStart?>">
                                <input type="hidden" name="chart2DateEnd" id="chart2DateEnd" value="<?=$v_chart2DateEnd?>">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                                    <div style="" id="chart_dia"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="dashboardInfo" role="tabpanel" aria-labelledby="chart-tab">
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="text-left">Informações do Dashboard</h6>
                                    <table class="table table-striped w-100">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th style="width: 40%!important;">Parâmetro</th>
                                            <th>Valor</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-right text-monospace">Cliente:</td>
                                            <td class="text-right text-monospace"><?=$v_dashboardData['customer_nome_fantasia']?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-monospace">I3P (ninst):</td>
                                            <td class="text-right text-monospace"><?=$v_dashboardData['ninst']?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-right text-monospace">Instalação:</td>
                                            <td class="text-right text-monospace"><?=$v_dashboardData['ninst']?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="dashboardConfig" role="tabpanel" aria-labelledby="config-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <input type="hidden" id="camArray" name="camArray" value="">
                                        <div style="position:absolute;"><button type="button" id="saveCam" class="btn btn-sm waves-effect waves-light btn-success">Salvar</button></div>
                                        <table id="appDatatableCamera" class="display nowrap table table-hover table-striped table-bordered appDatatableCamera" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th><div class="appCamCheckAll cameraCheckAll text-success fa fa-square-o fa-lg"  style="cursor: pointer;"></div></th>
                                                <th>Cam</th>
                                                <th>Descrição</th>
                                            </tr>
                                            </thead>
                                            <tbody style="text-align: center!important;"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<script src="../../assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $.docData = {
            dtTable : null,
            profileList : '',
            dataSectionCheck : <?=$_dataSectionCheck?>,
            installationID :  '<?=$v_dashboardData['installation_id']?>',
            dashboardID: '<?=$v_dashboardID?>',
            chart1Data: null,
            chart2Data: null,
            chart2DateStart: '<?=$v_chart2DateStart?>',
            chart2DateEnd: '<?=$v_chart2DateEnd?>'
        };

        $.docData.dtTableCamera = $('.appDatatableCamera').DataTable({
            "autoWidth": false,
            "paging": true,
            "select": true,
            "pageLength": 5,
            "lengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            "dom": '<"dtFloatRight dtPageLength"l><"dtFloatRight"f><"dtInfoBeta">rt<"dtCenter"i<"dtFloatLeft"><"dtFloatRight"p>>',
            "ajax": {
                "url": "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appListDashboardCamera",
                "xhrFields": { withCredentials: true },
                "dataSrc": "appDashboardCameraList",
                "dataType": "json",
                "type":"POST",
                "headers":
                    {
                        "appDatatable":true
                    },
                "data": function(d)
                {
                    d.dashboardID = $.docData.dashboardID,
                    d.installationID = $.docData.installationID
                }
            },
            "initComplete": function () {
                $(".dt-buttons").removeClass("btn-group");
            },
            "order":[[0,'asc']],
            "columns": [
                { data:
                        {

                            display: function (data) {
                                if(data.dashboard_id == $.docData.dashboardID){
                                    return '<div class="appCamCheck camCheck text-success fa fa-check-square fa-lg" style="cursor: pointer;"></div>';
                                }else{
                                    return '<div class="appCamCheck camCheck text-success fa fa-square-o fa-lg" style="cursor: pointer;"></div>';
                                }
                            }

                        }, "className":"text-center","width":"8%"
                },
                {
                    data: "cam", "className":"text-left"
                },
                {
                    data: "cam_desc", "className":"text-left"
                }
            ],
            "createdRow": function( row, data, dataIndex ) {
                $(row).attr("data-obcon_camera_id",data.obcon_camera_id);

            },
            "columnDefs": [
                {
                    "targets": 0,
                    "orderable": false,
                    "searchable": false
                }
            ]
        });

        $.docData.dtTableLastEvent = $('.appDatatableLastEvent').DataTable({
            "autoWidth": false,
            "paging": false,
            "select": true,
            "pageLength": 10,
            //"dom": '<"dtFloatRight dtPageLength"l><"dtFloatRight"f><"dtInfoBeta">rt<"dtCenter"<"dtFloatLeft"><"dtFloatRight"p>>',
            "dom": '<"dtFloatRight"f><"dtInfoBeta">rt',
            "ajax": {
                "url": "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appListDashboardLastEvent",
                "xhrFields": { withCredentials: true },
                "dataSrc": "appDashboardLastEventList",
                "dataType": "json",

                "type":"POST",
                "headers":
                    {
                        "appDatatable":true
                    },
                "data": function(d)
                {
                    d.dashboardID = $.docData.dashboardID
                }
            },
            "initComplete": function () {
                $(".dt-buttons").removeClass("btn-group");
            },
            "order":[[0,'asc']],
            "columns": [
                { data:
                        {
                            display: function (data) {
                                 return '<div>'+data.data_br+' '+data.hora+'</div>';
                            }
                        }, "className":"text-center text-monospace"
                },
                {
                    data: "cam", "className":"text-right text-monospace"
                },
                {
                    data: "sent_desc", "className":"text-left text-monospace"
                }
            ],
            "createdRow": function( row, data, dataIndex ) {
            },
            "columnDefs": [
                {
                }
            ]
        });

        $.docData.dtTableLastDays = $('.appDatatableLastDays').DataTable({
            "autoWidth": false,
            "paging": true,
            "select": true,
            "pageLength": 10,
            "dom": '<"dtFloatRight dtPageLength"l><"dtFloatRight"f><"dtInfoBeta">rt<"dtCenter"<"dtFloatLeft"><"dtFloatRight"p>>',
            "ajax": {
                "url": "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appListDashboardLastDays",
                "xhrFields": { withCredentials: true },
                "dataSrc": "appDashboardLastDaysList",
                "dataType": "json",
                "type":"POST",
                "headers":
                    {
                        "appDatatable":true
                    },
                "data": function(d)
                {
                    d.dashboardID = $.docData.dashboardID
                }
            },
            "initComplete": function () {
                $(".dt-buttons").removeClass("btn-group");
            },
            "order":[[0,'asc']],
            "columns": [
                { data:
                        {
                            display: function (data) {
                                return '<div>'+data.data_br+'</div>';
                            }
                        }, "className":"text-center text-monospace"
                },
                { data: "entrada", "className":"text-right text-monospace"},
                { data: "saida", "className":"text-right text-monospace"},
                { data: "total_atual", "className":"text-right text-monospace"},
            ],
            "createdRow": function( row, data, dataIndex ) {
            },
            "columnDefs": [
                {
                }
            ]
        });

        $(document).on('click','.appCamCheck',function (){
            let v_camCheck = $(this).hasClass("fa-check-square");
            if(v_camCheck)
            {
                //deselect item
                $(this).removeClass("fa-check-square").addClass("fa-square-o");
                $(".appCamCheckAll").removeClass("fa-check-square").addClass("fa-square-o");
                let camItemArray = [];
                $.docData.dtTableCamera.$('.fa-check-square').each(function(){
                    camItemArray.push($(this).attr("data-obcon_camera_id"));
                });
            }
            else
            {
                $(this).removeClass("fa-square-o").addClass("fa-check-square");
            }
        });

        $(document).on('click','.appCamCheckAll',function (){
            let v_camCheck = $(this).hasClass("fa-check-square");
            let rows = $.docData.dtTableCamera.rows({ 'search': 'applied' }).nodes();
            let currencyIDArray = [];
            $('.appCamCheck', rows).each(function(){
                currencyIDArray.push(parseInt($(this).attr("data-currency_id")));
            });
            currencyIDArray = $.unique(currencyIDArray);
            if(v_camCheck)
            {
                //deselect all
                $(this).removeClass("fa-check-square").addClass("fa-square-o");
                $('.appCamCheck', rows).removeClass("fa-check-square").addClass("fa-square-o");
            }
            else
            {
                $(this).removeClass("fa-square-o").addClass("fa-check-square");
                $('.appCamCheck', rows).removeClass('fa-square-o').addClass('fa-check-square');

            }
        });

        $(document).on('click','#saveCam',function () {
            //validate required item
            let camArray = [];
            $.docData.dtTableCamera.$('.fa-check-square').each(function () {
                camArray.push($(this).closest("tr").attr("data-obcon_camera_id"));
            });

            if (camArray.length > 0) {
                $("#camArray").val(camArray.join(','));
                let v_camString= $("#camArray").val();

                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appDashboardCamera",
                    type: "POST",
                    dataType: "json",
                    data: {
                        method: "POST",
                        camString: v_camString,
                        dashboardID: $.docData.dashboardID
                    },
                    success: function (d) {
                        if (d.status === true)
                        {
                            $.docData.dtTableCamera.ajax.reload(v_setTooltip);
                            toastr["success"]("Configuração Salva", "Success");
                        }
                        else {
                            toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                        }
                    },
                    error: function () {
                        toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                    }
                });
            } else {
                toastr["warning"]("Selecione uma câmera para Salvar", "Ooops!");
                return false;
            }
        });

        $(document).on('click','#obconChart-tab',function (){
            setTimeout(function(){
                redrawChart();
            }, 500);

        });

        $(document).on('click','#zeraContador',function (){

            bootbox.confirm({
                message: "Tem certeza que deseja zerar o contador?",
                buttons: {
                    confirm: {
                        label: 'Sim',
                        className: 'btn btn-success btn-sm'
                    },
                    cancel: {
                        label: 'Não',
                        className: 'btn btn-danger btn-sm'
                    }
                },
                callback: function (result) {
                    if(result===true)
                    {
                        $.ajax({
                            url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appObconZeroCounter",
                            type: "POST",
                            dataType: "json",
                            data:
                                {
                                    dashboardID: $.docData.dashboardID
                                },
                            success: function(d)
                            {
                                if(d === true)
                                {
                                    setControleData();
                                    toastr["success"]("Contagem reiniciada.", "Success");
                                }
                                else
                                {
                                    toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                                }
                            },
                            error:function ()
                            {
                                toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                            }
                        });

                    }
                }
            });
        });

        $('#chart2Range').on('apply.daterangepicker', function(ev, picker) {
            $('#chart2DateStart').val(picker.startDate.format('YYYY-MM-DD'));
            $('#chart2DateEnd').val(picker.endDate.format('YYYY-MM-DD'));
            $.docData.chart2DateStart = $('#chart2DateStart').val();
            $.docData.chart2DateEnd = $('#chart2DateEnd').val();
            getChart2Data();
        });
        let start = moment('<?=$v_chart2DateStart?>');
        let end = moment();

        $('#chart2Range').daterangepicker({
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
            minDate:"01-09-2021",
            maxDate: moment(),
            maxSpan:{"days": 30},
            ranges: {
                'Hoje': [moment(), moment()],
                'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                'Este Mês': [moment().startOf('month'), moment().endOf('month')],
                'Mês Passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);

        // Load the Visualization API and the corechart package.
       // google.charts.load('current', {'packages':['corechart','bar']});
        google.charts.load('current', {'packages':['corechart','bar']});

        getChart1Data();
        getChart2Data();

        setControleData();

        setInterval(function(){
            setControleData();
            getChart1Data();
            getChart2Data();
            $.docData.dtTableLastEvent.ajax.reload(v_setTooltip);
            $.docData.dtTableLastDays.ajax.reload(v_setTooltip);
        }, 30000);

    });

    function setControleData(){
        $.ajax({
            url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appObconCounter",
            type: "POST",
            dataType: "json",
            data: {
                method: "GET",
                dashboardID: $.docData.dashboardID
            },
            success: function (d) {
                if (d)
                {
                    $("#controleData").html(d.data_br);
                    $("#controleHora").html(d.count_hora);
                    $("#countEntrada").html(d.entrada);
                    $("#countSaida").html(d.saida);
                    $("#countTotal").html(d.total_atual);
                    $("#zeraContador").show();
                }
            },
            error: function () {
                //toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                console.log('Ocorreu algum erro.');
            }
        });
    }

    function getChart1Data(){
        $.ajax({
            url: "<?=$GLOBALS['g_appRoot']?>/appBIDataAPI/appChartObconEntradaSaida",
            type: "POST",
            dataType: "json",
            data: {
                dashboardID: $.docData.dashboardID
            },
            success: function (d) {
                $.docData.chart1Data = d;
                google.charts.setOnLoadCallback(drawChart);
            },
            error: function () {
                //toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                console.log('Ocorreu algum erro.');
            }
        });
    }

    function drawChart() {
        // Create the data table.
        let data = new google.visualization.DataTable();
        data.addColumn('timeofday', 'Time of Day');
        data.addColumn('number', 'Entradas');
        data.addColumn('number', 'Saídas');
        data.addRows($.docData.chart1Data);

        let options = {
            title: 'Evolução Entrada e Saída Hoje',
            width: "100%",
            chartArea: {  width: "90%", height: "70%" },
            legend: {
                position: 'none'
            },
            hAxis: {
                format: 'H:mm',
                viewWindow: {
                    min: [-1, 30, 0],
                    max: [23, 30, 0]
                }
            }
        };

        // Instantiate and draw our chart, passing in some options.
        let chart = new google.visualization.ColumnChart(document.getElementById('chart_hoje'));
        chart.draw(data, options);
    }

    function getChart2Data(){
        $.ajax({
            url: "<?=$GLOBALS['g_appRoot']?>/appBIDataAPI/appChartObconDashboardDia",
            type: "POST",
            dataType: "json",
            data: {
                dashboardID: $.docData.dashboardID,
                dateStart: $.docData.chart2DateStart,
                dateEnd: $.docData.chart2DateEnd,
            },
            success: function (d) {
                $.docData.chart2Data = d;
                google.charts.setOnLoadCallback(drawChart2);
            },
            error: function () {
                //toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                console.log('Ocorreu algum erro.');
            }
        });
    }

    function drawChart2() {
        // Create the data table.
        let data = new google.visualization.DataTable();
        data.addColumn('string', 'Dia');
        data.addColumn('number', 'Entradas');
        data.addRows($.docData.chart2Data);

        let options = {
            title: 'Entradas por Data',
            chartArea: {  width: "90%", height: "70%" },
            legend: {
                position: 'none'
            },
            width: '100%',
            hAxis: {
                fontSize: 9
            }

        };

        // Instantiate and draw our chart, passing in some options.
        let chart = new google.visualization.ColumnChart(document.getElementById('chart_dia'));
        chart.draw(data, options);
    }

    function redrawChart(){
        drawChart();
        drawChart2();
    }

    function cb(start, end) {
        $('#chart2Range span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    }
</script>