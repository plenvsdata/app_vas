<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 31/01/2018
 * Time: 13:13
 */
use app\System\Lists\appDataList;
use app\System\Combo\appCombo;
//use app\System\Lov\appGetValue;

$v_dashboardID = !empty($_REQUEST['dataValue']) ? $_REQUEST['dataValue'] : null;
//print $v_dashboardID;
$v_comboData = new appCombo();
$v_comboProfile = $v_comboData->comboSystemAccessProfile('array');
$v_comboCustomer = $v_comboData->comboCustomer('array');
//print_r($v_comboCustomer);
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
    .help-block {display: none;}
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
                    <div style="position:absolute;"><button type="button" class="btn btn-sm waves-effect waves-light btn-success addDashboard" data-toggle="modal" data-target="#dashboardModal">Adicionar Dashboard</button></div>
                    <div class="row m-1">
                        <div class="col-md-12 mb-2">
                            <div class="position-relative w-100 "><i class="fa fa-refresh pull-right l-5" aria-hidden="true"></i></div>
                            <h3>Track & Field - Shopping Villa Lobos</h3>
                            <h6>Data do Controle: 23/09/2021</h6>
                            <h6>Horário de Início: 07:11:55</h6>
                        </div>
                        <div class="col-4 bg-info p-2">
                            <h4 class="text-white">Contagem Atual</h4>
                            <h2 class="w-100 text-center text-white">666 Pessoas</h2>
                        </div>
                        <div class="col-4 bg-primary p-2">
                            <h4 class="text-white">Entraram</h4>
                            <h2 class="w-100 text-center text-white">999 Pessoas</h2>
                        </div>
                        <div class="col-4 bg-success p-2">
                            <h4 class="text-white">Sairam</h4>
                            <h2 class="w-100 text-center text-white">333 Pessoas</h2>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-12 p-4">
                            <h6>Últimos Eventos</h6>
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
                                        <td>23/09/2021 - 13:23:45</td>
                                        <td>Camera 88</td>
                                        <td>Entrada</td>
                                    </tr>
                                    <tr>
                                        <td>23/09/2021 - 13:33:45</td>
                                        <td>Camera 66</td>
                                        <td>Saída</td>
                                    </tr>
                                    <tr>
                                        <td>23/09/2021 - 15:23:45</td>
                                        <td>Camera 88</td>
                                        <td>Entrada</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 pl-1">
            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Consolidação</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Configuração</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Gráficos</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">

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
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- Start Modal Dashboard  -->
<!-- ============================================================== -->
<div class="modal fade" id="dashboardModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered-90" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span id="txtLabel">Editar</span> Dashboard</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <input type="hidden" id="dashboardID">
                <input type="hidden" id="action">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="divCustomer" class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Cliente:</label>
                            <select id=customerID" name="customerID" class="form-control custom-select selectpicker customerID">
                                <option value="">Selecione Cliente</option>
                                <?php foreach ($v_comboCustomer['rsData'] as $key=>$value){ ?>
                                    <option value="<?=$value['customer_id']?>"><?=$value['customer_nome_fantasia']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div id="divCustomer" class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Instalação:</label>
                            <select id=customerID" name="installationID" class="form-control custom-select selectpicker installationID">
                                <option value="">Selecione a Instalação</option>
                            </select>
                        </div>
                    </div>
                    <div id="divCustomer" class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Câmeras:</label>
                            <select id=obconCameraID" name="obconCameraID" class="form-control custom-select selectpicker obconCameraID">
                                <option value="">Selecione as Câmeras</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal" id="btnCancel">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-success waves-effect waves-light" id="btnSave">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Modal Dashboard  -->
<!-- ============================================================== -->
<script src="../../assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $.docData = {
            dtTable : null,
            profileList : '',
            dataSectionCheck : <?=$_dataSectionCheck?>
        };

        $('.customerID').on('changed.bs.select', function (e) {
            let v_customerID = $(e.currentTarget).val();
            if(v_customerID){
                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboInstallation",
                    type: "POST",
                    dataType: "json",
                    data:
                        {
                            customerID: v_customerID,
                            type:''
                        },
                    success: function(d)
                    {
                        if(d.apiData.status==true)
                        {
                           alert('dados carregados');
                            console.log(d);
                        }else{
                            console.log('Não carrega o combo de clientes');
                        }
                    }
                });
            }

        });






















    });
</script>