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
    .container-fluid{
        padding: 0 10px 0 10px!important;
    }
     tfoot input {
         width: 100%;
         padding: 3px;
         box-sizing: border-box;
         font-size: small;
     }
     #excelBtnDiv {
         margin-left: 250px!important;
     }
     #reportrange {
         position: absolute!important;
         height: 28px!important;
         padding-bottom: 2px!important;
         padding-top: 2px!important;
         margin-top: 10px!important;
     }
     .gallery{
         cursor: pointer;
     }
    .img-size{
        height: 450px;
        width: 700px;
        background-size: cover;
        overflow: hidden;
    }
    .modal-content {
        width: 700px!important;
        border:none;
        margin-left: auto;
        margin-right: auto;
    }
    .carousel-control-prev-icon {
        //background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23009be1' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
        width: 30px;
        height: 48px;
    }
    .carousel-control-next-icon {
        //background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23009be1' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
        width: 30px;
        height: 48px;
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
                                <th class="text-center" style="width: 220px!important;">Cliente</th>
                                <!--
                                <th>ORI</th>
                                <th>IDR</th>
                                <th>NOR</th>
                                -->
                                <th class="text-center" style="width: 60px!important;">COD</th>
                                <th>Data</th>
                                <th>Câmera</th>
                                <th class="text-center" style="width: 80px!important;">APL</th>
                                <th>INS</th>
                                <th>Origem</th>
                                <th>Status</th>
                                <th><i class="fa fa-video-camera"></i></th>
                                <!--
                                <th>Subtipo</th>
                                <th>NSB</th>
                                <th>SBN</th>
                                <th>COR</th>
                                <th>IPS</th>
                                <th>POS</th>
                                -->
                            </tr>
                            </thead>
                            <tbody class="text-center"></tbody>
                            <tfoot id="appDatatableFoot" class="collapse">
                            <tr id="trFilters" class="collapse">
                                <th>Cliente</th>
                                <!--
                                <th>ORI</th>
                                <th>IDR</th>
                                <th>NOR</th>
                                -->
                                <th>COD</th>
                                <th>Data</th>
                                <th>Câmera</th>
                                <th>APL</th>
                                <th>INS</th>
                                <th>Origem</th>
                                <th>Status</th>
                                <th><i class="fa fa-video-camera"></i></th>
                                <!--
                                <th>Subtipo</th>
                                <th>NSB</th>
                                <th>SBN</th>
                                <th>COR</th>
                                <th>IPS</th>
                                <th>POS</th>
                                -->
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
    <!-- Modal Carousel-->
    <div class="modal fade center" id="carouselModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- carousel -->
                    <div id='carouselExampleIndicators' class='carousel slide carousel-fade'>
                        <ol class='carousel-indicators'>
                            <li data-target='#carouselExampleIndicators' data-slide-to='0' class='active'></li>
                            <li data-target='#carouselExampleIndicators' data-slide-to='1'></li>
                            <li data-target='#carouselExampleIndicators' data-slide-to='2'></li>
                            <li data-target='#carouselExampleIndicators' data-slide-to='3'></li>
                            <li data-target='#carouselExampleIndicators' data-slide-to='4'></li>
                        </ol>
                        <div class='carousel-inner'>
                        </div>
                        <a class='carousel-control-prev' href='#carouselExampleIndicators' role='button' data-slide='prev'>
                        <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                            <span class='sr-only'>Previous</span>
                        </a>
                        <a class='carousel-control-next' href='#carouselExampleIndicators' role='button' data-slide='next'>
                            <span class='carousel-control-next-icon' aria-hidden='true'></span>
                            <span class='sr-only'>Next</span>
                        </a>
                    </div>
                </div>
                <div class="modal-footer" style="display: block">
                    <div class="float-left">
                        <input type="hidden" id="validaAlarmeID">
                        <button data-alarme_status="1" type="button" class="btn btn-sm btn-success validaAlarme">Alarme Válido</button>
                        <button data-alarme_status="0" type="button" class="btn btn-sm btn-danger validaAlarme">Alarme Falso</button>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- END Modal Carousel-->
<!-- Modal No image-->
<div class="modal fade center" id="noImageModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
               <div>Nenhuma imagem disponível</div>
            </div>
            <div class="modal-footer" style="display: block">
                <div class="float-right">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END No image-->
<script type="text/javascript">

    $.docData = {
        dtTable : null,
        comboCountry : "",
        mapData :  null,
        customerDtTable : null,
        countryChangeState : false,
        stateChangeState : false,
        dataSectionCheck : <?=$_dataSectionCheck?>,
        dataStart: '<?=$v_dateStart?>',
        dataEnd: '<?=$v_dateEnd?>'
    };

    function showMap() {
        $('.mapDiv').fadeOut(500);
    }

    function cb(start, end) {
        $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
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
                "dom": '<"dtFloatRight"f><"#excelBtnDiv.dtFloatLeft"B><"dtInfoBeta">rt<"dtCenter"i<"dtFloatLeft"><"dtFloatRight"p>>',
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
                        "data": function(d){
                            d.dataStart = $.docData.dataStart,
                            d.dataEnd = $.docData.dataEnd
                        }
                    },
                "buttons":
                    [
                        {"text":'Filtros',"className": 'btn btn-sm dt-btn-width btn-info dtFloatSpaceLeft filterPage'},
                        {"extend": 'excelHtml5', "text": 'Excel', "className": 'btn btn-sm dt-btn-width btn-success buttons-html5', "attr": { id: 'exportExcel' }},
                        {"extend": 'colvis', "text": 'Colunas', "className": 'btn btn-sm dt-btn-width btn-info dtFloatSpaceLeft' }
                    ],
                "initComplete": function () {
                    $(".dt-buttons").removeClass("btn-group");
                    $('#exportExcel').removeClass('hidden');
                    $('#excelBtnDiv').removeClass('hidden');

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
                        /*
                        { data: "ori", "className":"text-center text-monospace" },
                        { data: "idr", "className":"text-right text-monospace" },
                        { data: "nor", "className":"text-left text-monospace" },
                         */
                        { data: "cod", "className":"text-right text-monospace" },
                        { data:
                                {
                                    _: "data_br",
                                    sort: "data_order"
                                }, "className":"text-right text-monospace"
                        },
                        { data: "nuc", "className":"text-right text-monospace" },
                        { data: "apl", "className":"text-left text-monospace reportCustomer80px" },
                        { data: "ins", "className":"text-right text-monospace" },
                        { data: "origem_desc", "className":"text-left text-monospace" },
                        { data: "alarme_status_desc", "className":"text-left text-monospace" },
                        { data:
                                {
                                    _: function (data)
                                    {
                                        let v_icon
                                        if(parseInt(data.origem_id) === 3) {
                                            v_icon = '<span class="fa-stack">'+
                                                     '<i class="fa fa-video-camera fa-stack"></i>'+
                                                     '<i class="fa fa-ban fa-stack-2x text-danger"></i>'+
                                                     '</span>';
                                        } else {
                                            v_icon = '<i class="fa fa-video-camera gallery"></i>';
                                        }
                                        return v_icon;
                                    }
                                },
                            "className":"text-center"
                        },
                        /*
                        { data: "subtipo_desc", "className":"text-left text-monospace" },
                        { data: "nsb", "className":"text-right text-monospace" },
                        { data: "sbn", "className":"text-right text-monospace" },
                        { data: "cor", "className":"text-left text-monospace" },
                        { data: "ips", "className":"text-left text-monospace" },
                        { data: "pos", "className":"text-left text-monospace" }
                         */
                    ],
                "createdRow": function( row, data, dataIndex )
                {
                    $(row).attr("data-alarme_viper_id",data.alarme_viper_id);
                },
                "columnDefs":
                    [
                        {
                            "targets": [1],
                            "orderable": false,
                            "searchable": false
                        }
                    ],
                "order":[[2,'desc'],[7,'asc']]
            }
        );

        // Apply the search
        $.docData.dtTable.columns().every( function () {
            let that = this;
            $( 'input', this.footer() ).on( 'keyup change', function ()
            {
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
                'Mês Passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);

        $(document).on('click','.gallery',function (){

            let v_alarmeID = $(this).closest("tr").attr("data-alarme_viper_id");
            $('.carousel').carousel('dispose');
            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appGetViperPhoto",
                type: "POST",
                dataType: "json",
                data:
                    {
                        alarmeID: v_alarmeID
                    },
                success: function(d)
                {
                    if(d)
                    {
                        //594 COD
                        let v_html = "";
                        let v_active = "";
                        $.each(d, function(i, val) {
                            if(i===0){
                                v_active = "active";
                            }else{
                                v_active = "";
                            }
                            v_html+="<div class='carousel-item "+v_active+"'><img class='img-size' src='../../__appCloud/"+val.customer_token+"/CAM"+val.nuc+"/"+val.photo_original_name+"' alt='Foto "+(i+1)+"' /></div>";
                        });

                        $(".carousel-inner").html(v_html);
                        if(v_html==""){
                            $("#noImageModal").modal();
                        }else{
                            $("#validaAlarmeID").val(v_alarmeID);
                            $('.carousel').carousel({
                                interval: 100
                            });
                            $("#carouselModal").modal();
                        }
                    }
                    else
                    {
                        $("#noImageModal").modal();
                    }
                }
            });
        });

        $(document).on('click','.validaAlarme',function (){
            let v_alarmeID = $("#validaAlarmeID").val();
            let v_alarmeStatus = $(this).data('alarme_status');

            $.ajax({
                url: "<?=$GLOBALS['g_appRoot']?>/appDataAPI/appValidaAlarmeViper",
                type: "POST",
                dataType: "json",
                data:
                    {
                        alarmeID: v_alarmeID,
                        alarmeStatus: v_alarmeStatus
                    },
                success: function(d)
                {
                    if(d.status === true)
                    {
                        if(v_alarmeStatus == '1'){
                            toastr["success"]("Status: Alarme Válido alterado", "Success");
                        }else{
                            toastr["success"]("Status: Alarme falso alterado", "Success");
                        }
                        $.docData.dtTable.ajax.reload();
                    }
                    else
                    {
                        toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                    }
                },
                error:function (d)
                {
                    toastr["error"]("Ocorreu algum erro. Tente novamente", "Erro!");
                }
            });
        });

    });
</script>


