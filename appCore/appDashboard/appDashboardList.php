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

$v_comboData = new appCombo();
$v_comboProfile = $v_comboData->comboSystemAccessProfile('array');
$v_comboCustomer = $v_comboData->comboCustomer('array');

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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div style="position:absolute;"><button type="button" class="btn btn-sm waves-effect waves-light btn-success addDashboard" data-toggle="modal" data-target="#dashboardModal">Adicionar Dashboard</button></div>
                    <div class="table-responsive">
                        <table id="appDatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Cliente</th>
                                <th>Ninst</th>
                                <th>Instalação</th>
                                <th class="text-center org-col-50">Ação</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center!important;"></tbody>
                            <tfoot id="appDatatableFoot" class="collapse">
                            <tr id="trFilters" class="collapse">
                                <th>Descrição</th>
                                <th>Cliente</th>
                                <th>Ninst</th>
                                <th>Instalação</th>
                                <th hidden>Ação</th>
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
<div class="modal fade" id="dashboardModal" tabindex="-1" role="dialog" aria-labelledby="dashboardModal">
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
                    <div class="col-md-12">
                        <div class="form-group has-feedback divDescricao">
                            <label for="dashboardDesc" class="control-label">Descrição:</label>
                            <input type="text" class="form-control dashboardDesc" id="dashboardDesc" name="dashboardDesc" aria-describedby="dashboardDescHelp">
                            <span id="dashboardDescHelp" class="help-block text-danger">Min 3 caracteres</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="divCustomer" class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Cliente:</label>
                            <select id=customerID" name="customerID" class="form-control customerID">
                                <option value="">Selecione o Cliente</option>
                                <?php foreach ($v_comboCustomer['rsData'] as $key=>$value){ ?>
                                    <option value="<?=$value['customer_id']?>"><?=$value['customer_nome_fantasia']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div id="divCustomer" class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Instalação:</label>
                            <select id=installationID" name="installationID" class="form-control installationID">
                                <option value="">Selecione a Instalação</option>
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
        // Setup - add a text input to each footer cell
        $('#appDatatable tfoot th').each( function () {
            //var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Fitro" />' );
        });

        $.docData.dtTable = $('#appDatatable').DataTable({
                "autoWidth": false,
                "paging": true,
                "pageLength": 10,
                "dom": '<"dtFloatRight"f><"dtInfoBeta">rt<"dtCenter"i<"dtFloatLeft"B><"dtFloatLeft"><"dtFloatRight"p>>',
                "ajax":
                    {
                        "url": "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appListDashboard",
                        "xhrFields": { withCredentials: true },
                        "dataSrc": "appDashboardList",
                        "dataType": "json",
                        "headers":
                            {
                                "appDatatable":true
                            },
                        "data": function(d){ }
                    },
                "buttons":
                    [
                        {"extend": 'excelHtml5', "text": 'Excel', "className": 'btn btn-sm dt-btn-width btn-success buttons-html5'}
                    ],
                "initComplete": function () {
                    $(".dt-buttons").removeClass("btn-group");
                    let r = $('#appDatatable tfoot tr');
                    r.find('th').each(function(){
                        $(this).css('padding', 8);
                    });
                    $('#appDatatable thead').append(r);
                },
                "columns":
                    [
                        { data:
                            {
                                _: function(data)
                                {
                                    return "<a href='DashboardConfig/"+data.dashboard_id+"'>"+data.dashboard_desc+"</a>";
                                },
                                sort: "dashboard_desc"
                            }, "className":"text-left"
                        },
                        {
                            data: "customer_nome_fantasia", "className":"text-left"
                        },
                        {
                            data: "ninst", "className":"text-left"
                        },
                        {
                            data: "installation_desc", "className":"text-left"
                        },
                        { data:
                                {
                                    _: function (data)
                                    {

                                        return "<div style='display: inline-flex;' class='flex-item'>"+
                                            "<i class=\"fa fa-border fa-pencil appEditDesc\" style='cursor: pointer;' data-dashboard_id='"+data.dashboard_id+"' data-customer_id='"+data.customer_id+"' data-installation_id='"+data.installation_id+"' data-dashboard_desc='"+data.dashboard_desc+"'></i>"+
                                            "</div><div style='display: inline-flex;' class='flex-item'>"+
                                            "<i class=\"fa fa-border fa-trash appDel\" style='cursor: pointer;' data-dashboard_id='"+data.dashboard_id+"' data-dashboard_desc='"+data.dashboard_desc+"' ></i>"+
                                            "</div>";
                                    }
                                },
                            "className":"text-center"
                        }
                    ],
                "createdRow": function( row, data, dataIndex )
                {
                    $(row).attr("data-dashboard_id",data.dashboard_id);
                },
                "columnDefs":
                    [
                        {}
                    ]
            }
        );
        // Apply the search
        $.docData.dtTable.columns().every( function () {
            let that = this;
            $( 'input', this.footer() ).on( 'keyup change', function ()
            {
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

        $.docData.dtTable.on("click",".appEditDesc",function(){
            $("#txtLabel").text('Editar');
            $("#action").val('PUT');
            let v_dashboard_id = $(this).attr("data-dashboard_id");
            let v_dashboard_desc = $(this).attr("data-dashboard_desc");
            let v_customer_id = $(this).attr("data-customer_id");
            let v_installation_id = $(this).attr("data-installation_id");
            getComboInstallation(v_customer_id,v_installation_id);
            $('.customerID').val(v_customer_id);
            $("#dashboardID").val(v_dashboard_id);
            $("#dashboardDesc").val(v_dashboard_desc);
            $("#dashboardModal").modal('show');
        });

        $(document).on('click','#btnSave',function(){
            let v_dashboard_id = $("#dashboardID").val();
            let v_dashboard_desc = $("#dashboardDesc").val();
            let v_customer_id = $(".customerID").val();
            let v_installation_id = $(".installationID").val();
            let v_action = $("#action").val();
            let v_erro = '';

            if(v_dashboard_desc.length<3){
                v_erro+='-Descrição deve ter min. 3 caracteres.<br>';
            }

            if(!v_customer_id){
                v_erro+='-Selecione o cliente.<br>';
            }

            if(!v_installation_id){
                v_erro+='-Selecione a instalação.<br>';
            }

            if(v_erro != ''){
                toastr["warning"](v_erro, "Atenção!");
                return false;
            }else{

                if(v_action==='POST'){
                    $.ajax({
                        url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appDashboard",
                        type: "POST",
                        dataType: "json",
                        data:
                            {
                                method: 'POST',
                                customerID: v_customer_id,
                                installationID: v_installation_id,
                                dashboardDesc: v_dashboard_desc
                            },
                        success: function(d)
                        {
                            if(d.status === true)
                            {
                                toastr["success"]("Dasboard criado com sucesso.", "Success");
                                $.docData.dtTable.ajax.reload();
                                $('#dashboardModal').modal('hide');
                            }
                            else
                            {
                                toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                            }
                        }
                    });
                }else if(v_action==='PUT'){
                    $.ajax({
                        url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appDashboard",
                        type: "POST",
                        dataType: "json",
                        data:
                            {
                                method: 'PUT',
                                dashboardID: v_dashboard_id,
                                dashboardDesc: v_dashboard_desc
                            },
                        success: function(d)
                        {
                            if(d.status === true)
                            {
                                toastr["success"]("Dasboard atualizado com sucesso.", "Success");
                                $.docData.dtTable.ajax.reload();
                                $('#dashboardModal').modal('hide');
                            }
                            else
                            {
                                toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                            }
                        }
                    });
                }
            }



        });

        $(document).on('click','.addDashboard',function () {
            $("#txtLabel").text('Adicionar');
            $("#action").val('POST');
            $("#dashboardDesc").val('');
            $("#dashboardID").val('');
            $(".customerID").val('');
            $(".installationID").html('<option value="">Selecione a Instalação</option>');
        });

        $.docData.dtTable.on("click",".appDel",function() {
            let v_dashboardID = $(this).attr("data-dashboard_id");
            let v_dashboardDesc = $(this).attr("data-dashboard_desc");
            bootbox.confirm({
                message: "Tem certeza que deseja excluir este Dashboard:<br/><h3 class='text-center'>"+v_dashboardDesc+"</h3>",
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
                            url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appDashboard",
                            type: "POST",
                            dataType: "json",
                            data:
                                {
                                    method: "DELETE",
                                    dashboardID: v_dashboardID
                                },
                            success: function(d)
                            {
                                if(d.status === true)
                                {
                                    toastr["success"]("Dashboard "+v_dashboardDesc+" excluído.", "Success");
                                    $.docData.dtTable.ajax.reload();
                                }
                                else
                                {
                                    toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                                }
                            },
                            error:function ()
                            {
                                toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                            }
                        });
                    }
                }
            });

        });

        $('.customerID').on('change', function () {
            let v_customerID = $(this).val();
            if(v_customerID){
                getComboInstallation(v_customerID);
            }else{
                $(".installationID").html('<option value="">Selecione a Instalação</option>');
            }
        });

        function getComboInstallation(customerID,installationID){
            $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboInstallation",
                    type: "POST",
                    dataType: "json",
                    data:
                        {
                            customerID: customerID
                        },
                    success: function(d)
                    {
                        if(d.rsTotal){
                            let v_content = '<option value="">Selecione a Instalação</option>';
                            $.each(d.rsData,function (i,v)
                            {
                                v_content += '<option value="'+v.installation_id+'">'+v.ninst+' - '+v.installation_desc+'</option>';
                            });
                            $(".installationID").html(v_content);
                            if(installationID){
                                $(".installationID").val(installationID);
                            }else{
                                $(".installationID").val('');
                            }

                        }else{
                            toastr["warning"]("Este cliente não possui dados para instalação", "Atenção!");
                            $(".installationID").html('<option value="">Selecione a Instalação</option>');
                        }
                    },
                    error:function (d)
                    {
                        toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                    }
                });
        }

    });
</script>