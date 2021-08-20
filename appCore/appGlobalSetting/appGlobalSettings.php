<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 23/06/2021
 * Time: 21:39
 */
use app\System\Combo\appCombo;
$v_appData['method'] = "GET";
$v_appData['type'] = 'array';
$v_appCombo =  new appCombo();
$v_comboCurrency = $v_appCombo->comboSystemCurrency($v_appData);//Pode ser alterado para Client Instance
$v_instance_currency = $v_comboCurrency['rsData'][0];
$v_appMeasureData['method'] = "COMBO";
$v_appMeasureData['type'] = 'array';
$v_comboMeasureSystem = $v_appCombo->comboSystemMeasureSystem($v_appMeasureData);
$v_comboMeasure = $v_comboMeasureSystem['rsData'];
$v_popOverContent = '';
foreach ($v_comboMeasure as $key => $valor) {
    $v_popOverContent .= '<option value="'.$valor['measure_system_id'].'">'.$valor['measure_system_desc'].' '.$valor['measure_system_list'].'</option>';
}
$v_appMeasureData['method'] = "GET";
$v_measureSystemData = $v_appCombo->comboSystemMeasureSystem($v_appMeasureData);
$v_measureData = $v_measureSystemData['rsData'][0];
?>
<style>
    svg > g > g:last-child { pointer-events: none }

    .chartLoader {
        width: 100%!important;
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
    }

    .chartNoData {
        width: 100%!important;
        background-color: #67757c;
        background-position: center;
        background-repeat: no-repeat;
        background-size: 150px;
        opacity: 1;
        overflow: hidden;
        -webkit-mask-image: url("../../appImages/defaultImages/default_no_data.svg");
        -webkit-mask-position: center!important;
        -webkit-mask-repeat: no-repeat!important;
        -webkit-mask-size: 150px!important;
        mask-image: url("../../appImages/defaultImages/default_no_data.svg");
        mask-position: center;
        mask-repeat: no-repeat;
        mask-size: 150px!important;
    }

    .chartResponsive {
        width: 100% !important;
    }

    .pdsWelcome {
        background-image: url("../../appImages/defaultImages/logo_welcome_to.svg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: 90%;
        height: 300px!important;
        max-height: 150px!important;
        width: 70%;
        max-width: 400px!important;
        margin: auto!important;
    }

    .circle {
        position:relative;
        border-radius:50%;
        -moz-border-radius:50%;
        -webkit-border-radius:50%;
        border:10px solid rgba(255,255,255,.10);
        width:180px;
        height:180px;
        overflow:hidden;
        -webkit-transition: all .3s ease;
        -moz-transition: all .3s  ease;
        -o-transition: all .3s  ease;
        transition: all .3s ease;
        margin: auto!important;
        display: table;
        cursor: pointer!important;
    }
    .circleCenterText {
        width: 100%!important;
        text-align: center!important;
        display: table-cell;
        vertical-align: middle;
        font-size: 16pt!important;
        font-weight: bold!important;
    }
    .circleDropShadow {
        -webkit-box-shadow: 10px 10px 47px -4px rgba(0,0,0,0.57);
        -moz-box-shadow: 10px 10px 47px -4px rgba(0,0,0,0.57);
        box-shadow: 10px 10px 47px -4px rgba(0,0,0,0.57);
    }

    #welcomeOptions {
        cursor: default!important;
    }
    .iconColor
    {
        color: #99abb4!important;
        cursor: pointer;
    }

</style>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles basicContent">
    <div class="col-md-7 align-self-center">
        <h3 class="text-themecolor">Global Settings</h3>
    </div>
    <div class="col-md-5 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=$GLOBALS['g_appRoot']?>/Welcome">Home</a></li>
            <li class="breadcrumb-item">Configurações</li>
            <li class="breadcrumb-item active">Global Settings</li>
        </ol>
    </div>
    <!--
    <div>
        <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
    </div>
    -->
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid basicContent">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <!-- Row -->
    <div class="row">
        <div class="col-lg-4 pds_padding-right">
            <div class="card">
                <div class="card-body" style="height: 133px!important;">
                    <h2 class="card-title">Default Currency <span style="font-size: 12pt"><br>
                        <i class='fa fa-pencil iconColor editDefaultCurrency popoverOCS' aria-hidden='true'></i>
                            <span id="txt_currency">(<?=$v_instance_currency['currency_symbol']?>) <?=$v_instance_currency['currency_desc']?></span>
                        </span>
                    </h2>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style="height: 133px!important;">
                    <h2 class="card-title">Value Per <span id="labelMeasureDesc"><?=$v_measureData['measure_system_id']=='1'?'Kilometer':'Mile'?></span><span style="font-size: 12pt"><br>
                        <i class='fa fa-pencil iconColor editValueKm popoverOCS'  aria-hidden='true'></i>
                            <span id="currencySymbol"><?=$_SESSION['instanceCurrencySymbol']?></span>
                            <span id="txt_value_km" data-value_km_clean="<?=$v_instance_currency['value_km']?>" data-currency_format="<?=$v_instance_currency['currency_format']?>"></span>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4 pds_padding-left pds_padding-right">
            <div class="card">
                <div class="card-body" style="height: 133px!important;">
                    <h2 class="card-title">Default Unit System<span style="font-size: 12pt"><br>
                        <i class='fa fa-pencil iconColor editDefaultUnit popoverOCS' aria-hidden='true'></i>
                            <span id="txt_measure"><?=$v_measureData['measure_system_desc'].' '.$v_measureData['measure_system_list']?></span>
                        </span>
                    </h2>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style="height: 133px!important;">
                    <h2 class="card-title">
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4 pds_padding-left">
            <div class="card">
                <div class="card-body chartSalesData chartLoader chartLoaderDiv" style="height: 276px!important;">
                    <h4 class="card-title">Sales Information <span style="font-size: 10pt">(last 10 weeks)</span></h4>
                    <div id="chartSalesData" class="chartResponsive chartDataDiv chartSalesArea"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 pds_padding-right">
            <div class="card">
                <div class="card-body chartStageCount chartLoader chartLoaderDiv" style="height: 276px!important;">
                    <h4 class="card-title">Opportunity Stage <span style="font-size: 10pt">(By Number)</span></h4>
                    <div id="chartStageCount" class="chartResponsive chartDataDiv chartStageCountArea"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 pds_padding-left pds_padding-right">
            <div class="card">
                <div class="card-body chartStageTotal chartLoader chartLoaderDiv" style="height: 276px!important;">
                    <h4 class="card-title">Opportunity Stage <span style="font-size: 10pt">(Overall Value)</span></h4>
                    <div id="chartStageTotal" class="chartResponsive chartDataDiv chartStageTotalArea"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 pds_padding-left">
            <div class="card">
                <div class="card-body chartOpportunitySourceData chartLoader chartLoaderDiv" style="height: 276px!important;">
                    <h4 class="card-title">Opportunity Origin <span style="font-size: 10pt">(Marketing Channel)</span></h4>
                    <div id="chartOpportunitySourceData" class="chartResponsive chartDataDiv chartOpportunitySourceArea"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
<div id="popoverData" style="display: none;"></div>
<div id="welcomeOptions" style="display: none;">
    <div class="row">
        <div class="col-sm-12">
            <div class="pdsWelcome"></div>
        </div>
        <div class="col-md-4" style="padding: 10px!important;">

            <?php
            //ToDo: userProfileData - Ajustes
            // Valores configurados: 1 = SysOp / 2 = Administrador
            if(in_array(1,$_SESSION['accessProfileID']) || in_array(2,$_SESSION['accessProfileID'])) {
                ?>
                <div class="circle circleDropShadow pdsImportData pdsFirstFeature" data-feature="1" style="background-color: rgba(172,160,207,0.65)!important;">
                    <span class="circleCenterText">
                        Import<br/>My Data
                    </span>
                </div>
            <? } else { ?>
                <div class="circle circleDropShadow pdsAddContact pdsFirstFeature" data-feature="4" style="background-color: rgba(172,160,207,0.65)!important;">
                    <span class="circleCenterText">
                        Add<br/>Contacts
                    </span>
                </div>
            <? } ?>
        </div>
        <div class="col-md-4" style="padding: 10px!important;">
            <div class="circle circleDropShadow pdsQuickOpportunity pdsFirstFeature" data-feature="2" style="background-color: rgba(168,206,150,0.65)!important; width: 220px!important; height: 220px!important;">
                    <span class="circleCenterText">
                        Quick Start!<br/>Create a New Opportunity!
                    </span>
            </div>
        </div>
        <div class="col-md-4" style="padding: 10px!important;">
            <div class="circle circleDropShadow pdsGetStarted pdsFirstFeature" data-feature="3" style="background-color: rgba(172,160,207,0.65)!important;">
                    <span class="circleCenterText">
                        Start using<br/>Plenvs Data
                    </span>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="<?=$GLOBALS['g_appRoot']?>/js/Plugins/jquery.blockUI/jquery.blockUI.min.js"></script>
<script type="text/javascript" src="<?=$GLOBALS['g_appRoot']?>/js/Plugins/Custom/pds_functions.js"></script>

<script type="text/javascript">

    $.docData = {
        chartSaleType: '',
        chartCustomerType: '',
    };

    function updateDashboard() {
        $('.chartDataDiv').empty();
        $('.chartLoaderDiv').removeClass('chartNoData').removeClass('chartLoader').addClass('chartLoader');
        $('.chartPipelineCount').removeClass('chartLoader');//
    }

    function formatCurrency(valor){
        //valor no formato 0.00
        let v_formated ;
        if($.globalData.userLocaleCountryID == '3'){
            v_formated = Number(valor).toLocaleString('de-DE', { maximumFractionDigits: 2,minimumFractionDigits:2 });
            //$('.popover').find('input#editValueKm').val(v_formated);//Exibir Usuario
            console.log("pt-BR v_formated="+v_formated+" valor="+valor);
        }else{
            v_formated = Number(valor).toLocaleString('en-US', { maximumFractionDigits: 2,minimumFractionDigits:2 });
            //$('.popover').find('input#editValueKm').val(v_formated);//Exibir Usuario
            console.log("en-US v_formated="+v_formated+" valor="+valor);
        }
        return v_formated;
    }

    $(document).ready(function()
    {
        $("#txt_value_km").text(formatCurrency('<?=$v_instance_currency['value_km']?>'));

        $(document).on('click','.editDefaultCurrency',function (){

            $('.popover').popover('hide');

            let v_popover = $(this);
            let v_content = "";
            $("#popoverData").empty();

            $.ajax( {
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboSystemCurrency",
                method: "POST",
                data:{
                    type : "json",
                    method: "COMBOCURRENCY"
                },
                dataType: "JSON",
                success:function(d){

                    v_content  = '<div class="input-group">';
                    v_content += '<select class="form-control custom-select changeDefaultCurrency" style="width:180px!important;" name="currencyID" id="currencyID">';

                    $.each(d.rsData,function (i,v)
                    {
                        v_content += '<option value="'+v.currency_id+'" data-currency_format="'+v.currency_format+'"   data-symbol="'+v.currency_symbol+'">('+v.currency_symbol+') '+v.currency_desc+'</option>';
                    });

                    v_content += '</select>';

                    v_content += '<div class="input-group-btn">';
                    v_content += '<button type="button" class="btn btn-sm btn-success saveDefaultCurrency" style="height: 38px!important; width: 47px!important;">';
                    v_content += '<span class="fa fa-lg fa-check"></span>';
                    v_content += '</button>';
                    v_content += '</div>';
                    v_content += '</div>';

                    $("#popoverData").html(v_content);
                    $(v_popover).popover({
                        html: true,
                        title: '<div>Change Default Currency<i class="fa fa-times fa-pull-right iconColor popoverClose" aria-hidden="true"></i></div>',
                        container: 'body',
                        sanitize: false,
                        placement: 'top',
                        content: $("#popoverData").html(),
                        delay: 100
                    });

                    $(v_popover).popover('show');

                },
                complete:function()
                {
                    $(v_popover).on("show.bs.popover",function ()
                    {
                        //$(".businessOwnerList").val(v_ownerID);
                    });
                }
            });

        });

        $(document).on('click','.editDefaultUnit',function (){

            $('.popover').popover('hide');

            //let v_ownerID = $(this).attr('data-owner_id');
            let v_popover = $(this);
            let v_content = "";
            $("#popoverData").empty();

            v_content  = '<div class="input-group">';
            v_content += '<select class="form-control custom-select changeDefaultUnit"  name="measureSystemID" id="measureSystemID">';

            v_content += '<?=$v_popOverContent?>';
            v_content += '</select>';

            v_content += '<div class="input-group-btn">';
            v_content += '<button type="button" class="btn btn-sm btn-success saveDefaultUnit" style="height: 38px!important; width: 47px!important;">';
            v_content += '<span class="fa fa-lg fa-check"></span>';
            v_content += '</button>';
            v_content += '</div>';
            v_content += '</div>';

            $("#popoverData").html(v_content);
            $(v_popover).popover({
                html: true,
                title: '<div>Change Default Unit<i class="fa fa-times fa-pull-right iconColor popoverClose" aria-hidden="true"></i></div>',
                container: 'body',
                sanitize: false,
                placement: 'top',
                content: $("#popoverData").html(),
                delay: 100
            });

            $(v_popover).popover('show');

            /*

            $.ajax( {
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboSystemCurrency",
                method: "POST",
                data:{
                    type : "json",
                    method: "COMBOCURRENCY"
                },
                dataType: "JSON",
                success:function(d){

                    v_content  = '<div class="input-group">';
                    v_content += '<select class="form-control custom-select changeDefaultUnit" style="width:180px!important;" name="currencyID" id="currencyID">';

                    $.each(d.rsData,function (i,v)
                    {
                        v_content += '<option value="'+v.currency_id+'" data-currency_format="'+v.currency_format+'"   data-symbol="'+v.currency_symbol+'">('+v.currency_symbol+') '+v.currency_desc+'</option>';
                    });

                    v_content += '</select>';

                    v_content += '<div class="input-group-btn">';
                    v_content += '<button type="button" class="btn btn-sm btn-success saveDefaultUnit" style="height: 38px!important; width: 47px!important;">';
                    v_content += '<span class="fa fa-lg fa-check"></span>';
                    v_content += '</button>';
                    v_content += '</div>';
                    v_content += '</div>';

                    $("#popoverData").html(v_content);
                    $(v_popover).popover({
                        html: true,
                        title: '<div>Change Default Unit<i class="fa fa-times fa-pull-right iconColor popoverClose" aria-hidden="true"></i></div>',
                        container: 'body',
                        sanitize: false,
                        placement: 'top',
                        content: $("#popoverData").html(),
                        delay: 100
                    });

                    $(v_popover).popover('show');

                },
                complete:function()
                {
                    $(v_popover).on("show.bs.popover",function ()
                    {
                        //$(".businessOwnerList").val(v_ownerID);
                    });
                }
            });
            */

        });

        $(document).on('click','.saveDefaultUnit',function () {
            let v_measureData = $('.popover').find('.changeDefaultUnit option:selected');
            let v_measureID = v_measureData.val();
            let v_measureDesc = v_measureData.text();
            let v_labelMeasureDesc = 'Kilometer';
            if(v_measureID==2){ v_labelMeasureDesc = 'Mile';}

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboSystemMeasureSystem",
                type: "POST",
                dataType: "json",
                data:
                    {
                        type : "json",
                        method: "POST",
                        measureSystemID: v_measureID
                    },
                success: function (d)
                {
                    if (d.status === true)
                    {
                        toastr["success"]("Unit System changed.", "Success");
                        $("#txt_measure").text(v_measureDesc);
                        $("#labelMeasureDesc").text(v_labelMeasureDesc);
                    }
                    else {
                        toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                    }
                    $('.popover').popover('hide');
                },
                error: function () {
                    toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                    $('.popover').popover('hide');
                }
            });
        });

        $(document).on('click','.saveDefaultCurrency',function () {
            let v_currencyData = $('.popover').find('.changeDefaultCurrency option:selected');
            let v_currencyID = v_currencyData.val();
            let v_currencyDesc = v_currencyData.text();
            let v_currencyFormat = v_currencyData.data('currency_format');
            let v_currencySymbol = v_currencyData.data('symbol');

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboSystemCurrency",
                type: "POST",
                dataType: "json",
                data:
                    {
                        type : "json",
                        method: "UPDATECURRENCY",
                        currencyID: v_currencyID,
                        currencySymbol: v_currencySymbol
                    },
                success: function (d)
                {
                    if (d.status === true)
                    {
                        toastr["success"]("Default Currency changed.", "Success");
                        $("#txt_currency").text(v_currencyDesc);
                        $('.popover').popover('hide');
                        $.globalData.currencyID = v_currencyID;
                        //Alterando value per KM
                        let v_value_km_clean = $("#txt_value_km").attr('data-value_km_clean');
                        $("#txt_value_km").text(formatCurrency(v_value_km_clean));
                        $("#txt_value_km").attr("data-currency_format",v_currencyFormat);
                        $("#currencySymbol").text(v_currencySymbol);
                    }
                    else {
                        toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                        $('.popover').popover('hide');
                    }
                },
                error: function () {
                    toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                    $('.popover').popover('hide');
                }
            });
        });

        $(document).on('click','.editValueKm',function (){

            $('.popover').popover('hide');
            let v_currency_format = $("#txt_value_km").attr('data-currency_format');
            let v_value_km_clean = $("#txt_value_km").attr('data-value_km_clean');
            let v_popover = $(this);
            let v_content = "";
            $("#popoverData").empty();
            v_content  = '<div class="input-group">';
            v_content += '<input type="text" id="editValueKm" name="editValueKm" value="" class="form-control" style="width:180px!important;">';
            v_content += '<div class="input-group-btn">';
            v_content += '<button type="button" class="btn btn-sm btn-success saveValueKm" style="height: 38px!important; width: 47px!important;">';
            v_content += '<span class="fa fa-lg fa-check"></span>';
            v_content += '</button>';
            v_content += '</div>';
            v_content += '</div>';

            $("#popoverData").html(v_content);

            $(v_popover).popover({
                html: true,
                title: '<div>Change Value <i class="fa fa-times fa-pull-right iconColor popoverClose" aria-hidden="true"></i></div>',
                container: 'body',
                sanitize: false,
                placement: 'top',
                content: $("#popoverData").html(),
                delay: 100
            });

            $(v_popover).on("inserted.bs.popover",function ()
            {
                $('.popover').find('input#editValueKm').attr("value",'').mask(v_currency_format,basePriceOptions);
            });
            $(v_popover).popover('show');

        });

        $(document).on('click','.saveValueKm',function () {

            let v_currencyData = $('.popover').find('.changeDefaultCurrency option:selected');
            let v_value_km = $("#txt_value_km").attr("data-value_km_clean");
            let v_edit_value_km = $('.popover').find('input#editValueKm').val();
            if(v_edit_value_km.length < 2){
                toastr["warning"]("Value too small. Fix it and try again.", "Attention!");
                return false;
            }

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appComboSystemCurrency",
                type: "POST",
                dataType: "json",
                data:
                    {
                        type : "json",
                        method: "UPDATEKM",
                        valueKm: v_value_km
                    },
                success: function (d)
                {
                    if (d.status === true)
                    {
                        toastr["success"]("Value per Km Changed.", "Success");
                        $("#txt_value_km").text(formatCurrency(v_value_km));
                        $("#txt_value_km").attr("data-value_km_clean",v_value_km);
                        $('.popover').popover('hide');
                    }
                    else {
                        toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                        $('.popover').popover('hide');
                    }
                },
                error: function () {
                    toastr["error"]("Something went wrong. Please, try again.", "Ooops!");
                    $('.popover').popover('hide');
                }
            });
        });

        $(document).on('click','.popoverClose',function () {
            $('.popover').popover('hide');
        });

        let basePriceOptions =  {
            onComplete: function(basePrice){},
            onKeyPress: function(basePrice, event, currentField, options){

                if($.globalData.currencyID == '3'){
                    basePrice = basePrice.replace(/\./g, '');
                    basePrice = basePrice.replace(',', '.');
                }
                var v_basePrice = basePrice.replace(/\,/g,'');

                if(v_basePrice.length<'3')
                {
                    v_basePrice = parseFloat(v_basePrice/100);
                }

                if(parseFloat(v_basePrice) < 0.01 || isNaN(v_basePrice))
                {
                    $("#txt_value_km").attr("data-value_km_clean","");
                    $('.popover').find('input#editValueKm').val("");
                }else {
                    $("#txt_value_km").attr("data-value_km_clean",v_basePrice);
                    $('.popover').find('input#editValueKm').val(formatCurrency(v_basePrice));//Exibir Usuario
                }
            },
            onChange: function(basePrice){},
            onInvalid: function(val, e, f, invalid, options){
                //var error = invalid[0];
                //console.log ("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
            },
            reverse: true,
            placeholder: ""
        };
        /*
        if($.globalData.currencyID == '3'){
            $('.popover').find('input#editValueKm').mask("#.##0,00",basePriceOptions);
        }else{
            $('#editValueKm').mask("#.##0.00",basePriceOptions);
        }
        */
    });
</script>