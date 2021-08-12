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
            <li class="breadcrumb-item">CRM</li>
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
                    <div style="position:absolute; left: 20px!important;"><button type="button" class="btn btn-sm waves-effect waves-light btn-success appAddCustomer" data-toggle="modal" data-target="#newCustomerModal">Adicionar Cliente</button></div>
                    <div class="table-responsive">
                        <table id="appDatatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>CNPJ</th>
                                <th class="text-center org-col-50">Action</th>
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

<!-- sample modal content -->
<div id="newCustomerModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar Cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="addNewCustomer" name="addNewCustomer">
                    <div class="row divCustomerCompany">
                        <div class="col-md-6">
                            <div class="form-group divCustomerRazaoSocial has-feedback">
                                <label for="customerRazaoSocial" class="control-label">Razão Social:</label>
                                <input type="text" class="form-control" id="customerRazaoSocial" name="customerRazaoSocial" aria-describedby="customerRazaoSocialHelp">
                                <span id="customerRazaoSocialHelp" class="help-block">Min 3 characters</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group divCustomerNomeFantasia has-feedback">
                                <label for="customerNomeFantasia" class="control-label" >Nome Fantasia:</label>
                                <input type="text" class="form-control" id="customerNomeFantasia" name="customerNomeFantasia" aria-describedby="customerNomeFantasiaHelp">
                                <span id="customerNomeFantasiaHelp" class="help-block">Min 3 characters</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback divCustomerEmail">
                                <label for="userEmail" class="control-label">Email:</label>
                                <input type="text" class="form-control customerEmail" required id="customerEmail" name="customerEmail" aria-describedby="customerEmailHelp">
                                <span id="customerEmailHelp" class="help-block text-danger">Min 3 caracteres</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group has-feedback divCustomerPhone">
                                <label for="customerPhone" class="control-label">Telefone:</label>
                                <input type="text" class="form-control customerPhone" id="customerPhone" name="customerPhone" aria-describedby="customerPhoneHelp">
                                <span id="customerPhoneHelp" class="help-block text-danger">Min 3 characters</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group divCustomerCnpj has-feedback">
                                <label for="customerCnpj" class="control-label">CNPJ:</label>
                                <input type="text" class="form-control" id="customerCnpj" name="customerCnpj" aria-describedby="customerCnpjHelp">
                                <span id="customerCnpjHelp" class="help-block">Min 3 characters</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-sm btn-success waves-effect waves-light" id="btnSave">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

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

        if($.docData.dataSectionCheck === false){
            toastr["warning"]("Este cliente não existe.", "Atenção!");
        }

        $("#customerPhone").mask('(00) 00000-0000');
        $('#customerCnpj').mask('00.000.000/0000-00', {reverse: true});

        $(document).on('click','.switchGroupNew',function () {
            $('.newCustomerGroup').removeClass('hidden');
            $('.customerGroupList').addClass('hidden');
            $('#customerGroupID').selectpicker('hide');

            $('.saveCustomerGroup').removeClass('hidden');
            $('input[type=hidden].customerGroupUpdType').val('2');
        });

        $(document).on('click','.switchGroupSelect',function () {
            $('.customerGroupList').removeClass('hidden');
            $('.newCustomerGroup').addClass('hidden');
            $('#customerGroupID').selectpicker('show');
            $('.saveCustomerGroup').addClass('hidden');
            $('input[type=hidden].customerGroupUpdType').val('1');
        });

        $("#btnSave").click(function() {

            let v_erro = 0;
            let serial_form = $("form[id=addNewCustomer]").find('select, textarea, input').serialize();
            let v_customerNickname = $("form[id=addNewCustomer]").find("#customerNickname").val();
            let v_customerNomeFantasia = $("#customerNomeFantasia").val();



            let v_customerPhone = $("#customerPhone").val();
            if(v_customerPhone.length < 14){
                v_erro+='-Telefone deve ter min. 14 caracteres.<br>';
            }

            let v_customerName = $("form[id=addNewCustomer]").find("#customerName").val();
            if(v_customerNomeFantasia.length > 2)
            {
                $("form[id=addNewCustomer]").find(".divCustomerNomeFantasia" ).removeClass( "has-danger" ).addClass( "has-success" );
                $("form[id=addNewCustomer]").find("#customerNomeFantasiaHelp" ).hide();
            }else
            {
                $("form[id=addNewCustomer]").find(".divCustomerNomeFantasia" ).removeClass( "has-success" ).addClass( "has-danger" );
                $("form[id=addNewCustomer]").find("#customerNomeFantasiaHelp" ).show();
                v_erro = 1;
            }

            let v_websiteUrl = $("form[id=addNewCustomer]").find("#websiteUrl").val();
            v_websiteUrl = v_websiteUrl.trim();
            if(validator.isURL(v_websiteUrl) || v_websiteUrl.length==0)
            {
                $("form[id=addNewCustomer]").find(".divWebsiteUrl" ).removeClass( "has-danger" ).addClass( "has-success" );
                $("form[id=addNewCustomer]").find("#websiteUrlHelp" ).hide();
            }else
            {
                $("form[id=addNewCustomer]").find(".divWebsiteUrl" ).removeClass("has-success").addClass("has-danger");
                $("form[id=addNewCustomer]").find("#websiteUrlHelp" ).show();
                v_erro = 1;
            }
            if(v_erro === 1){return false;}
            alert('fim');return false;


            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appCustomer",
                type: "POST",
                dataType: "json",
                data:
                    {
                        formData: serial_form,
                        customerTypeID:customerTypeID,
                        method :'POST'
                    },
                success: function(d)
                {
                    //console.log(d);
                    if(d.status === true)
                    {
                        location.href = "<?=$GLOBALS['g_appRoot']?>/CRM/Company/"+d.customerID;
                    }
                    else
                    {
                        toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                    }
                },
                error:function (d)
                {
                    //console.log(d);
                    toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                }
            });
        });

        $.docData.dtTable = $('#appDatatable').DataTable(
            {
                "autoWidth": false,
                "paging": true,
                "pageLength": 10,
                "dom": '<"dtFloatRight"f><"dtInfoBeta">rt<"dtCenter"i<"#excelBtnDiv.dtFloatLeft hidden"B><"dtFloatLeft"><"dtFloatRight"p>>',
                "ajax":
                    {
                        "url": "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appListCustomer",
                        "xhrFields": { withCredentials: true },
                        "dataSrc": "appCustomerList",
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
                    console.log( 'DataTables has redrawn the table' );
                    //correctHeight();
                },
                "columns":
                    [
                        { data: "customer_nome_fantasia", "className":"text-left" },
                        { data: "customer_phone", "className":"text-left" },
                        { data: "customer_email", "className":"text-left" },
                        { data: "customer_cnpj", "className":"text-left" },
                        { data:
                                {
                                    _: function (data)
                                    {
                                        let v_options = '';
                                        if(data.allow_delete == 1){
                                            v_options = "<div style='width:100%!important; display: inline-flex;' class='flex-item'>"+
                                                "<i class=\"fa fa-border fa-trash appCustomerDel\" style='cursor: pointer;' data-customer_id='"+data.customer_id+"' data-customer_nome_fantasia='"+data.customer_nome_fantasia+"' ></i>"+
                                                "</div>";
                                        }else{
                                            v_options = "<div style='width:100%!important; display: inline-flex;' class='flex-item'>"+
                                                "<i data-toggle='tooltip' data-placement='top' title='Este cliente não pode ser excluído.' class=\"fa fa-lock\" data-customer_id='"+data.customer_id+"' data-customer_nome_fantasia='"+data.customer_nome_fantasia+"' ></i>"+
                                                "</div>";
                                        }

                                        return v_options;
                                    }
                                },
                            "className":"text-center"
                        }
                    ],
                "createdRow": function( row, data, dataIndex )
                {
                    $(row).attr("data-customer_id",data.customer_id);
                },
                "columnDefs":
                    [
                        {
                            "targets": [4],
                            "orderable": false,
                            "searchable": false
                        }
                    ]
            }
        );

        $.docData.dtTable.on("click",".appCustomerStatus",function() {
            let v_customerStatus = $(this).attr("data-customer_status")
            let v_customerID = $(this).attr("data-customer_id");

            $.ajax({
                url:"<?=$GLOBALS['g_appRoot']?>/appDataAPI/appCustomer",
                method:"POST",
                dataType:"json",
                data:
                    {
                        customerID: v_customerID,
                        customerStatus: v_customerStatus,
                        method: "STATUS"
                    },
                success:function(d)
                {
                    if(d.status === true)
                    {
                        toastr["success"]("Company Status Changed", "Success");
                        $.docData.dtTable.ajax.reload();
                    }
                    else
                    {
                        toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                    }
                },
                error:function()
                {
                    toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                }
            });
        });

        $.docData.dtTable.on("click",".appCustomerDel",function() {
            let v_customerID = $(this).attr("data-customer_id");
            let v_customerName = $(this).attr("data-customer_name");

            bootbox.confirm({
                message: "Are you sure you want to delete this company:<br/><h3 class='text-center'>"+v_customerName+"</h3><h3 style='color: #ef5350'>EVERYTHING related to this company will also be PERMANENTLY DELETED!</h3>",
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
                        $.ajax({
                            url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appCustomer",
                            type: "POST",
                            dataType: "json",
                            data:
                                {
                                    method: "DELETE",
                                    customerID: v_customerID
                                },
                            success: function(d)
                            {
                                if(d.status === true)
                                {
                                    toastr["success"]("Company "+v_customerName+" deleted.", "Success");
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
                }
            });

        });

        $(document).on('click','.appAddCustomer',function () {

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appListCustomerGroup",
                type: "POST",
                dataType: "json",
                data:
                    {
                        type:"json"
                    },
                success: function(d)
                {
                    let options = '';
                    $.each(d.rsData, function (key, val)
                    {
                        options += '<option value="' + val.customer_group_id + '">' + val.customer_group_desc + '</option>';
                    });
                    $("#customerGroupID").html(options).selectpicker('refresh');

                }
            });
        });

        $(document).on('click','.saveCustomerGroup',function () {

            // let v_title = $('.groupTitle').text();
            let v_customer_group_desc = $('#customerNewGroup').val();
            v_customer_group_desc = v_customer_group_desc.trim();
            if(v_customer_group_desc.length < 3)
            {
                toastr["warning"]("New Company Group too small. Fix it and try again.", "Attention!");
            }else
            {
                $.ajax({
                    url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appCustomerGroup",
                    type: "POST",
                    dataType: "json",
                    data:
                        {
                            type:"json",
                            appFormData:
                                {
                                    customerGroupDesc:v_customer_group_desc,
                                    method:"POST"
                                }
                        },
                    success: function(d)
                    {
                        //console.log(d);
                        if(d.status  == true)
                        {
                            $('#customerGroupID option:selected').removeAttr('selected');
                            $v_option = '<option value="'+d.rsInsertID+'" selected>'+v_customer_group_desc+'</option>';
                            $("#customerGroupID").append($v_option).selectpicker('refresh');
                            $('.switchGroupSelect').addClass('hidden');
                            $('.saveCustomerGroup').addClass('hidden');
                            $('.switchGroupNew').removeClass('hidden');
                            $('#customerNewGroup').addClass('hidden');
                            $('#customerNewGroup').val('');
                            $('#customerGroupID').selectpicker('show');
                            $('input[type=hidden].customerGroupUpdType').val('1');
                        }

                    }
                });

            }
        });

        $('#newCustomerModal').on('show.bs.modal', function (e) {
            $("[id='titleID']").empty();

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboSystemTitle",
                type: "POST",
                dataType: "json",
                data:
                    {
                        type:"json"
                    },
                success: function(d)
                {

                    $.each(d.rsData, function (key, val) {
                        $("[id='titleID']").append('<option value="' + val.title_id + '">' + val.title_desc + '</option>');
                    });
                },
                complete: function () {
                    $("[id='titleID']").selectpicker('refresh');
                }
            });
        });

        $.docData.dtTable.on("click",".appNewAddressTour",function() {
            let v_customerID = $(this).attr("data-customer_id");

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appSetSessionNewAddressTour",
                type: "POST",
                dataType: "json",
                data:
                    { },
                success: function(d)
                {
                    window.location="<?=$GLOBALS['g_appRoot']?>/CRM/Company/"+v_customerID;
                },
                error:function ()
                {
                    toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                }
            });
        });
        function correctHeight(){
            $('#mainCard').height('auto');
            setTimeout(function() {
                let v_page_height = $('html').height();//height page
                let v_useful_height = window.innerHeight;
                if(v_page_height==v_useful_height) {
                    let v_fix_elements = 185;//header,footer,paddings
                    let v_new_card_height = v_page_height-v_fix_elements;
                    $('#mainCard').height(v_new_card_height);
                }
            }, 200);
        }


    });
</script>


