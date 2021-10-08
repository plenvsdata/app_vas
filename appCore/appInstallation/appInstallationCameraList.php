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
        <h3 class="text-themecolor">Câmera Obcon</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=$GLOBALS['g_appRoot']?>/Welcome">Home</a></li>
            <li class="breadcrumb-item">Configurações</li>
            <li class="breadcrumb-item active">Câmera Obcon</li>
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
                    <div class="table-responsive">
                        <table id="appDatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 100px!important;">Ninst</th>
                                <th class="text-center" style="width: 250px!important;">Cliente</th>
                                <th>Instalação</th>
                                <th class="text-center" style="width: 80px!important;">Cam</th>
                                <th class="text-center" style="width: 250px!important;">Cam Desc</th>
                                <th class="text-center org-col-50">Action</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center!important;"></tbody>
                            <tfoot id="appDatatableFoot" class="collapse">
                            <tr id="trFilters" class="collapse">
                                <th>Ninst</th>
                                <th>Cliente</th>
                                <th>Instalação</th>
                                <th>Cam</th>
                                <th>Cam Desc</th>
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
<!-- Start Modal Buy Users  -->
<!-- ============================================================== -->
<div class="modal fade" id="cameraModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered-90" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Câmera Obcon</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <input type="hidden" id="obconCameraID">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback divDescricao">
                            <label for="camDesc" class="control-label">Descrição:</label>
                            <input type="text" class="form-control camDesc" id="camDesc" name="camDesc" aria-describedby="camDescHelp">
                            <span id="camDescHelp" class="help-block text-danger">Min 3 caracteres</span>
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
<!-- End Modal Buy Users  -->
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
                "dom": '<"dtFloatRight"f><"#excelBtnDiv.dtFloatLeft hidden"B><"dtInfoBeta">rt<"dtCenter"i<"dtFloatLeft"><"dtFloatRight"p>>',
                "ajax":
                    {
                        "url": "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appListCamera",
                        "xhrFields": { withCredentials: true },
                        "dataSrc": "appCameraList",
                        "dataType": "json",
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
                "columns":
                    [
                        { data: "ninst", "className":"text-right" },
                        { data: "customer_nome_fantasia", "className":"text-left" },
                        { data: "installation_desc", "className":"text-left" },
                        { data: "cam", "className":"text-right" },
                        { data: "cam_desc", "className":"text-left" },
                        { data:
                                {
                                    _: function (data)
                                    {

                                        return "<div style='display: inline-flex;' class='flex-item'>"+
                                            "<i class=\"fa fa-border fa-pencil appEditDesc\" style='cursor: pointer;' data-obcon_camera_id='"+data.obcon_camera_id+"' data-cam_desc='"+data.cam_desc+"'></i>"+
                                            "</div>";
                                    }
                                },
                            "className":"text-center"
                        }
                    ],
                "createdRow": function( row, data, dataIndex )
                {
                    $(row).attr("data-installation_id",data.installation_id);
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
            //console.log(that);
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

        $.docData.dtTable.on("click",".appEditDesc",function(){
            let v_obcon_camera_id = $(this).attr("data-obcon_camera_id");
            let v_cam_desc = $(this).attr("data-cam_desc");
            $("#obconCameraID").val(v_obcon_camera_id);
            $("#camDesc").val(v_cam_desc);
            $("#cameraModal").modal('show');
        });

        $(document).on('click','#btnSave',function(){
            let v_obcon_camera_id = $("#obconCameraID").val();
            let v_cam_desc = $("#camDesc").val();
            let v_erro = '';

            if(v_cam_desc.length<3){
                v_erro+='-Descrição deve ter min. 3 caracteres.<br>';
            }

            if(v_erro != ''){
                toastr["warning"](v_erro, "Atenção!");
            }else{

                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appCamera",
                    type: "POST",
                    dataType: "json",
                    data:
                        {
                            method: 'PUT',
                            obconCameraID: v_obcon_camera_id,
                            camDesc: v_cam_desc
                        },
                    success: function(d)
                    {
                        if(d.status === true)
                        {
                            toastr["success"]("Câmera atualizada com sucesso.", "Success");
                            $.docData.dtTable.ajax.reload();
                            $('#cameraModal').modal('hide');
                        }
                        else
                        {
                            toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                        }
                    }
                });
            }



        });






        $.docData.dtTable.on("click",".appUserDel",function() {
            var v_userID = $(this).attr("data-user_id");
            var v_userName = $(this).attr("data-user_name");
            var v_userStatus = $(this).attr("data-user_status_del");

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboOwner",
                type: "POST",
                dataType: "json",
                data:
                    {
                        userID: v_userID,
                    },
                success: function(e)
                {
                    $.ajax({
                        url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appOpportunity",
                        type: "POST",
                        dataType: "json",
                        data:
                            {
                                method: "OWNER",
                                ownerID: v_userID
                            },
                        success: function(d)
                        {
                            if(d === true)
                            {

                                bootbox.prompt({
                                    title: "Are you sure you want to delete this user:<br/><h3 class='text-center'>"+v_userName+"</h3><div style='color: #ef5350;' class='text-center'>Please identify to whom shall we merge all information attributed to:</div>",
                                    inputType: 'select',
                                    inputOptions: e,
                                    className:'teste_class',
                                    buttons: {
                                        confirm: {
                                            label: 'Yes',
                                            className: 'btn btn-success btn-sm'
                                        },
                                        cancel: {
                                            label: 'No',
                                            className: 'btn btn-danger btn-sm'
                                        }
                                    },
                                    callback: function (result) {
                                        if(result){
                                            $.ajax({
                                                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appOpportunity",
                                                type: "POST",
                                                dataType: "json",
                                                data:
                                                    {
                                                        method: "OWNER_TRANSFER",
                                                        ownerIDCurrent: v_userID,
                                                        ownerIDNew: result
                                                    },
                                                success: function(d)
                                                {
                                                    console.log(d.status);
                                                    if(d.status === true){
                                                        console.log('transfer ok');
                                                        delUser(v_userID,v_userStatus,v_userName);
                                                    }else{
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

                            }
                            else
                            {
                                bootbox.confirm({
                                    message: "Are you sure you want to delete this user:<br/><h3 class='text-center'>"+v_userName+"</h3>",
                                    buttons: {
                                        confirm: {
                                            label: 'Yes',
                                            className: 'btn btn-success btn-sm'
                                        },
                                        cancel: {
                                            label: 'No',
                                            className: 'btn btn-danger btn-sm'
                                        }
                                    },
                                    callback: function (result) {
                                        if(result===true)
                                        {
                                            delUser(v_userID,v_userStatus,v_userName);
                                        }
                                    }
                                });
                            }
                        },
                        error:function ()
                        {
                            toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                        }
                    });
                }
            });

        });

        function delUser(userID,userStatus,userName){

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appUserAccess",
                type: "POST",
                dataType: "json",
                data:
                    {
                        appFormData:{
                            method: "DELETE",
                            userID: userID,
                            userStatus: userStatus
                        }

                    },
                success: function(d)
                {
                    if(d.status === true)
                    {
                        toastr["success"]("User "+userName+" deleted.", "Success");
                        $.docData.dtTable.ajax.reload();
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

        $(document).on('click','.appUserConfig',function(){
            let v_userID = $(this).attr("data-user_id");

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboSystemUserProfile",
                type: "POST",
                dataType: "json",
                data:
                    {
                        type:"json",
                        method:"POST"
                    },
                success: function(d)
                {
                    let v_data = d.apiData;
                    $.docData.profileList = "";
                    $.each(v_data.rsData, function (key, val)
                    {
                        $.docData.profileList += '<option value="' + val.access_profile_id + '">' + val.access_profile_desc + '</option>';
                    });
                },
                complete: function(d)
                {
                    bootbox.dialog(
                        {
                            title: 'Invite New User',
                            message: '<div class="row">'+
                                '<div class="col-md-12">'+
                                '<div class="form-group has-feedback userAccessProfileData">'+
                                '<label class="control-label">Access Profile</label>'+
                                '<select class="form-control custom-select userAccessProfile" id="userAccessProfile" name="userAccessProfile">'+
                                $.docData.profileList+
                                '</select>'+
                                '</div>'+
                                '</div>'+
                                '<div class="col-md-12">'+
                                '<div class="form-group has-feedback" id="userAccessNameData">'+
                                '<label class="control-label" for="userAccessName">Name <span class="userAccessNameFeedback text-danger hidden"><small>(min 2 characters)</small></span></label><br>'+
                                '<input type="text" class="form-control userAccessName" id="userAccessName" name="userAccessName" aria-describedby="userAccessNameStatus">'+
                                '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="margin-left: -180px!important;"></span>' +
                                '<span id="userAccessNameStatus" class="sr-only">(success)</span>'+
                                '</div>'+
                                '</div>'+
                                '<div class="col-md-12">'+
                                '<div class="form-group has-feedback" id="userAccessEmailData">'+
                                '<label class="control-label" for="userAccessEmail">Email <span class="userAccessEmailFeedback text-danger hidden"><small>(Add a valid email address)</small></span></label><br>'+
                                '<input type="text" class="form-control userAccessEmail" id="userAccessEmail" name="userAccessEmail" aria-describedby="userAccessEmailStatus">'+
                                '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="margin-left: -180px!important;"></span>' +
                                '<span id="userAccessEmailStatus" class="sr-only">(success)</span>'+
                                '</div>'+
                                '</div>'+
                                '</div>',
                            buttons: {
                                confirm: {
                                    label: 'Send Invitation',
                                    className: 'btn-success',
                                    callback: function () {
                                        return addUserData(v_userID,$(".userAccessProfile").val(),$(".userAccessName").val(),$(".userAccessEmail").val());
                                    }
                                },
                                cancel: {
                                    label: 'Cancel',
                                    className: 'btn-danger',
                                    callback: function () { return true; }
                                }
                            }
                        });
                }
            });
        });

        $('.profileID').on('changed.bs.select', function (e, clickedIndex, newValue, oldValue) {
            let v_profileID = $(e.currentTarget).val();
            if(v_profileID == 3){
                $('#divCustomer').show();
            }else{
                $('#divCustomer').hide();
            }
        });

    });
</script>


