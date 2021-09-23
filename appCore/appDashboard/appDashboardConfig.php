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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div style="position:absolute;"><button type="button" class="btn btn-sm waves-effect waves-light btn-success addDashboard" data-toggle="modal" data-target="#dashboardModal">Adicionar Dashboard</button></div>
                    <div class="table-responsive">
                        <table id="appDatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Descrição</th>
                                <th class="text-center org-col-50">Action</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center!important;"></tbody>
                            <tfoot id="appDatatableFoot" class="collapse">
                            <tr id="trFilters" class="collapse">
                                <th>Descrição</th>
                                <th hidden>Action</th>
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