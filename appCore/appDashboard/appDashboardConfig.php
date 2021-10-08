<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 31/01/2018
 * Time: 13:13
 */
use app\System\Combo\appCombo;
use app\System\Lists\appDataList;

$v_dashboardID = !empty($_REQUEST['dataValue']) ? $_REQUEST['dataValue'] : null;
$v_comboData = new appCombo();
$v_comboProfile = $v_comboData->comboSystemAccessProfile('array');
$v_comboCustomer = $v_comboData->comboCustomer('array');
$v_data['dashboardID'] = $v_dashboardID;
$v_listDashboard = new appDataList();
$v_dashboardList = $v_listDashboard->appDashboardList($v_data);
$v_dashboardData = $v_dashboardList['rsData'][0];

//var_dump($v_dashboardData);

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
            <li class="breadcrumb-item"><a href="<?=$GLOBALS['g_appRoot']?>/Welcome">Home</a></li>
            <li class="breadcrumb-item">Obcon</li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
</div>

<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid basicContent">
    <div class="row">
        <div class="col-6 pr-1">
            <div class="card">
                <div class="card-body p-1">
                    <div class="row m-1">
                        <div class="col-md-12 mb-2">
                            <div class="position-absolute w-100" style="right: 0px!important;"><i class="fa fa-refresh pull-right r-5" aria-hidden="true" style="cursor: pointer!important;"></i></div>
                            <h4><?=$v_dashboardData['dashboard_desc']?></h4>
                            <h6>Data do Controle: 07/10/2021 - Horário de Início: 00:00:00</h6>
                        </div>
                        <div class="col-4 p-1">
                            <div class="col-12 dashboardPanel shadow" style="border-radius: 10px!important;">
                                <h6 class="text-black-50">Contagem Atual</h6>
                                <h2 class="w-100 text-center text-black">3</h2>
                            </div>
                        </div>
                        <div class="col-4 p-1">
                            <div class="col-12 dashboardPanel shadow" style="border-radius: 10px!important;">
                                <h6 class="text-black-50">Entradas</h6>
                                <h2 class="w-100 text-center text-black">7</h2>
                            </div>
                        </div>
                        <div class="col-4 p-1">
                            <div class="col-12 dashboardPanel shadow" style="border-radius: 10px!important;">
                                <h6 class="text-black-50">Saídas</h6>
                                <h2 class="w-100 text-center text-black">4</h2>
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
                            <!--
                            <h6>Últimos 10 Eventos</h6>
                            <table class="table table-striped w-100">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Data e Hora</th>
                                        <th>Câmera</th>
                                        <th>Evento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2021-10-07 - 08:48:48</td>
                                        <td>Câmera 3</td>
                                        <td>Entrada</td>
                                    </tr>
                                    <tr>
                                        <td>2021-10-07 - 07:11:49</td>
                                        <td>Câmera 2</td>
                                        <td>Entrada</td>
                                    </tr>
                                    <tr>
                                        <td>2021-10-07 - 06:27:09</td>
                                        <td>Câmera 3</td>
                                        <td>Saída</td>
                                    </tr>
                                    <tr>
                                        <td>2021-10-07 - 06:07:42</td>
                                        <td>Câmera 2</td>
                                        <td>Saída</td>
                                    </tr>
                                    <tr>
                                        <td>2021-10-07 - 05:34:51</td>
                                        <td>Câmera 1</td>
                                        <td>Saída</td>
                                    </tr>
                                    <tr>
                                        <td>2021-10-07 - 03:37:46</td>
                                        <td>Câmera 2</td>
                                        <td>Entrada</td>
                                    </tr>
                                    <tr>
                                        <td>2021-10-07 - 02:51:59</td>
                                        <td>Câmera 1</td>
                                        <td>Entrada</td>
                                    </tr><tr>
                                        <td>2021-10-07 - 02:26:09</td>
                                        <td>Câmera 2</td>
                                        <td>Saída</td>
                                    </tr>
                                    <tr>
                                        <td>2021-10-07 - 02:14:51</td>
                                        <td>Câmera 3</td>
                                        <td>Entrada</td>
                                    </tr>
                                    <tr>
                                        <td>2021-10-07 - 02:08:02</td>
                                        <td>Câmera 1</td>
                                        <td>Entrada</td>                                    </tr>
                                </tbody>
                            </table>
                            -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 pl-1">
            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="dashboardTabList" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link dashboardNavPanel active" id="obconReport-tab" data-toggle="tab" href="#obconReport" role="tab" aria-controls="obconReport" aria-selected="true">Consolidação</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link dashboardNavPanel" id="obconChart-tab" data-toggle="tab" href="#obconChart" role="tab" aria-controls="obconChart" aria-selected="true">Gráficos</a>
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
                        <div class="tab-pane fade show active" id="obconReport" role="tabpanel" aria-labelledby="obcon-tab">
                            <div class="row pt-0">
                                <div class="col-12 p-4">
                                    <h6 class="text-left">Últimos Dias</h6>
                                    <table class="table table-striped w-100">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Data</th>
                                            <th>Entradas</th>
                                            <th>Saídas</th>
                                            <th>Total de Pessoas</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>22/09/2021</td>
                                            <td class="text-right text-monospace">500</td>
                                            <td class="text-right text-monospace">400</td>
                                            <td class="text-right text-monospace">500</td>
                                        </tr>
                                        <tr>
                                            <td>21/09/2021</td>
                                            <td class="text-right text-monospace">500</td>
                                            <td class="text-right text-monospace">400</td>
                                            <td class="text-right text-monospace">500</td>
                                        </tr>
                                        <tr>
                                            <td>20/09/2021</td>
                                            <td class="text-right text-monospace">500</td>
                                            <td class="text-right text-monospace">400</td>
                                            <td class="text-right text-monospace">500</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="obconChart" role="tabpanel" aria-labelledby="chart-tab">
                            gráficos
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

<script type="text/javascript">

    $(document).ready(function() {

        $.docData = {
            dtTable : null,
            profileList : '',
            dataSectionCheck : <?=$_dataSectionCheck?>,
            installationID :  '<?=$v_dashboardData['installation_id']?>',
            dashboardID: '<?=$v_dashboardID?>',
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
                                console.log('resposta='+data.dashboard_id+' - '+$.docData.dashboardID);
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
            "paging": true,
            "select": true,
            "pageLength": 5,
            "lengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            "dom": '<"dtFloatRight dtPageLength"l><"dtFloatRight"f><"dtInfoBeta">rt<"dtCenter"i<"dtFloatLeft"><"dtFloatRight"p>>',
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
                                console.log('resposta='+data.dashboard_id+' - '+$.docData.dashboardID);
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

    });
</script>