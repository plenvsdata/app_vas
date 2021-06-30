$.wizardData = {
        cscData: null,
        firstAccess : true,
        countryListPhone : null,
        countryList : null,
        stateLoad: true,
    /*
        stageCombo: null,
        sourceCombo: null,
        customerCombo: null,
        productCombo: null,
        phoneTypeCombo: null,
    */
        wizardStep: 0,

    };

let v_newCustomer;
let v_wizardCustomerNickname;
let v_wizardCountryID;
let v_wizardStateID;
let v_wizardCityID;
let v_sourceID;


$('.divAppOpportunityWizard').bind('afterShow',function () {
        console.log('ueba');
    });

function wizardDataLoader(){
    $.when(pdsComboData.pdsOpportunityStage(),pdsComboData.pdsOpportunitySource(),pdsComboData.pdsOpportunityCustomer(),pdsComboData.pdsOpportunityProduct(),pdsComboData.pdsCountryList(),pdsComboData.pdsOpportunityPhoneType()).then(function(comboStage,comboSource,comboCustomer,comboProduct,comboCountry,comboPhoneType) {
        //Stage
        let v_jsonComboStage = jQuery.parseJSON(comboStage[0]);
        let v_comboStage = '';
        var tempContactID = 0;
        var tempProductID = 0;

        $.each(v_jsonComboStage.rsData, function (i, v) {
            v_comboStage += '<option value="' + v.opportunity_stage_id + '" >' + v.opportunity_stage_desc + '</option>';
        });
        $("#wizardOpportunityStageID").html(v_comboStage).selectpicker('render').selectpicker('refresh');

        //Source
        let v_jsonComboSource = jQuery.parseJSON(comboSource[0]);
        let v_comboSource = '';
        $.each(v_jsonComboSource.rsData, function (i, v) {
            v_comboSource += '<option value="' + v.source_id + '" >' + v.source_desc + '</option>';
        });
        $("#wizardSourceID").html(v_comboSource).selectpicker('render').selectpicker('refresh');

        //Customer
        let v_jsonComboCustomer = jQuery.parseJSON(comboCustomer[0]);
        let v_comboCustomer = '';
        $.each(v_jsonComboCustomer.appCustomerList, function (i, v) {
            v_comboCustomer += '<option value="' + v.customer_id + '" >' + v.customer_name + '</option>';
        });
        $("#wizardCustomerID").html(v_comboCustomer).selectpicker('render').selectpicker('refresh');

        //Product
        let v_jsonComboProduct = jQuery.parseJSON(comboProduct[0]);
        let v_comboProduct = '';
        $.each(v_jsonComboProduct.appProductList, function (i, v) {
            v_comboProduct += '<option data-base_price="'+v.base_price+'" value="' + v.product_id + '" >' + v.product_desc+ '</option>';
        });
        $("#wizardProductID").html(v_comboProduct).selectpicker('render').selectpicker('refresh');

        //Country
        let v_jsonComboCountry = jQuery.parseJSON(comboCountry[0]);
        let v_comboCountry = '';
        $.each(v_jsonComboCountry.rsData, function (i, v) {
            v_comboCountry += '<option value="' + v.country_id + '" >' + v.country_desc + '</option>';
        });
        $("#wizardCountryID").html(v_comboCountry).selectpicker('render').selectpicker('refresh');

        //PhoneCountry
        let v_comboPhoneCountry = '';
        $.each(v_jsonComboCountry.rsData, function (i, v) {
            v_comboPhoneCountry += '<option data-wizard_phone_mask="'+v.phone_mask+'" data-phone_area="'+v.country_phone_code+'" value="' + v.country_id + '" >(' +v.country_phone_code+') '+v.country_desc+'</option>';
        });
        $("#wizardPhoneCountryID").html(v_comboPhoneCountry).selectpicker('render').selectpicker('refresh');

        //PhoneType
        let v_jsonComboPhoneType = jQuery.parseJSON(comboPhoneType[0]);
        let v_comboPhoneType = '';
        $.each(v_jsonComboPhoneType.rsData, function (i, v) {
            v_comboPhoneType += '<option value="' + v.phone_type_id + '" >' + v.phone_type_desc + '</option>';
        });
        $("#wizardPhoneTypeID").html(v_comboPhoneType).selectpicker('render').selectpicker('refresh');

        getCountryList();
        let initialWizardCountryID = $('#wizardCountryID').val();

        getStateList(initialWizardCountryID);

        function getCountryList(){
            let v_countryListPhone = "";
            let v_countryList = "";
            $.ajax( {
                url: "/appDataAPI/appComboSystemCountry",
                method: "POST",
                data:{
                    method : "POST",
                    type : "json",
                    randData: Math.floor((Math.random() * 999999) + 1)
                },
                dataType: "JSON",
                success:function(d)
                {
                    $.each(d.rsData,function (i,v)
                    {
                        v_countryListPhone += '<option value="'+v.country_id+'" data-phone_mask="'+v.phone_mask+'" data-area_code="('+v.country_phone_code+')">('+v.country_phone_code+') '+v.country_desc+'</option>';
                        v_countryList += '<option value="'+v.country_id+'" data-locale="'+v.locale+'" data-zipcode_mask="'+v.zipcode_mask+'" data-area_code="'+v.country_phone_code+'" data-locale="'+v.locale+'">'+v.country_desc+'</option>';
                    });
                },
                complete:function()
                {
                    $.wizardData.countryListPhone = v_countryListPhone;
                    $.wizardData.countryList = v_countryList;
                }
            });
        }

        function getContactList(customerID) {
            let v_contactList = '';
            $.ajax({
                url: "/appDataAPI/appListContact",
                method: "POST",
                data: {
                    method: "POST",
                    type: "json",
                    customerID: customerID,
                    randData: Math.floor((Math.random() * 999999) + 1)
                },
                dataType: "JSON",
                success: function (d) {
                    //console.log(d);
                    //console.log('******');
                    //console.log(d.appContactList);
                    $.each(d.appContactList, function (i, v) {
                        v_contactList += '<option value="' + v.contact_id + '" data-wizard_contact_name="'+v.contact_name+'" data-wizard_email_address="'+v.email_address+'" data-wizard_full_number="'+v.full_number+'" data-wizard_phone_type_desc="'+v.phone_type_desc+'">' + v.contact_name + '</option>';
                    });
                    //console.log(v_contactList);
                    $('#wizardContactID').html(v_contactList).selectpicker({'title': 'Select Contacts'}).selectpicker('render').selectpicker('refresh');
                },
                complete: function () {
                }
            });
        }

        function getStateList(countryID,stateID){
            let v_stateList = "";
            let v_stateSelect;
            $('#wizardStateID').selectpicker({'title': 'Loading States...'}).selectpicker('render').selectpicker('refresh');
            $('#wizardCityID').selectpicker({'title': 'Loading Cities...'}).selectpicker('render').selectpicker('refresh');

            if(typeof stateID === 'undefined')
            {
                v_stateSelect = null;
            }
            else
            {
                v_stateSelect = stateID;
            }

            $.ajax({
                url: $.systemData.url+"/appDataAPI/appComboSystemState",
                method: "POST",
                data: {
                    method: "POST",
                    type: "json",
                    countryID: countryID,
                    randData: Math.floor((Math.random() * 999999) + 1)
                },
                dataType: "JSON",
                success: function (d) {
                    $.each(d.rsData, function (i, v) {
                        v_stateList += '<option value="' + v.state_id + '" data-state_code="' + v.state_code + '">' + v.state_desc + '</option>';
                    });
                    $('#wizardStateID').html(v_stateList);

                    if(v_stateSelect!=null){
                        $("#wizardStateID").selectpicker('refresh').selectpicker('val',v_stateSelect);
                    }else{
                        $('#wizardStateID').selectpicker({'title': 'Select State'}).selectpicker('render').selectpicker('refresh');
                    }
                },
                complete: function () {
                }
            });
        }

        function getCityList(stateID,cityID){
            let v_cityList = "";
            let v_citySelect;
            if(typeof cityID === 'undefined')
            {
                v_citySelect = null;
            }
            else
            {
                v_citySelect = cityID;
            }

            if(stateID === "") { return false; }

            $.ajax({
                url: $.systemData.url+"/appDataAPI/appComboSystemCity",
                method: "POST",
                data: {
                    method: "POST",
                    type: "json",
                    stateID: stateID,
                    randData: Math.floor((Math.random() * 999999) + 1)
                },
                dataType: "JSON",
                success: function (d) {
                    $.each(d.rsData, function (i, v) {
                        v_cityList += '<option value="' + v.city_id + '">' + v.city_desc + '</option>';
                    });
                    $('#wizardCityID').html(v_cityList);
                    if(v_citySelect!=null){
                        $("#wizardCityID").selectpicker('refresh').selectpicker('val',v_citySelect);
                    }else{
                        $('#wizardCityID').selectpicker({'title': 'Select City'}).selectpicker('render').selectpicker('refresh');
                    }
                    if($.wizardData.firstAccess === true){
                        $.wizardData.firstAccess = false;
                    }

                },
                complete: function () {

                }
            });

        }

        $(".wizardCustomerPlus").click(function(){

            if($.wizardData.firstAccess === true) {
                $("#wizardCountryID").selectpicker('refresh').selectpicker('val',$.globalData.userCountryID);
            }
        });

        $(document).on('change','#wizardCountryID',function() {

            let wizardCountryID = $(this).val();

            getStateList(wizardCountryID);

            $('#wizardCityID').html('');

            $('#wizardCityID').selectpicker({'title': 'Select City'}).selectpicker('render').selectpicker('refresh');

        });

        $(document).on('change','#wizardStateID',function() {
            let wizardStateID = $(this).val();
            getCityList(wizardStateID);
        });

        $(document).on('click','.appAddCustomer',function () {

            $.ajax({
                url: $.systemData.url+"/appDataAPI/appListCustomerGroup",
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

        $(document).on('click','.saveWizardCustomer',function () {

            // let v_title = $('.groupTitle').text();
            let v_customer_desc = $('#wizardCustomerNew').val();
            v_customer_desc = v_customer_desc.trim();
            if(v_customer_desc.length < 3)
            {
                toastr["warning"]("New Customer too small. Fix it and try again.", "Attention!");
            }else
            {
                $('#customerID option:selected').removeAttr('selected');
                $v_option = '<option value="new" selected>'+v_customer_desc+'</option>';
                $("#wizardCustomerID").append($v_option).selectpicker('refresh');
                $('.switchWizardSelect').addClass('hidden');
                $('.saveWizardCustomer').addClass('hidden');
                $('.wizardCustomerInput').addClass('hidden');
                $('.wizardSwitchCustomerNew').removeClass('hidden');

                $('#wizardCustomerNew').addClass('hidden');
                $('#wizardCustomerNew').val('');
                $('#wizardCustomerID').selectpicker('show');
                $('input[type=hidden].wizardCustomerUpdType').val('1');

            }
        });

        $("#btnWizardSaveCustomer").click(function() {
            let v_erro = 0;
            v_wizardCustomerNickname = $("#wizardCustomerNickname").val();
            v_wizardCountryID = $("#wizardCountryID").val();
            v_wizardStateID = $("#wizardStateID").val();
            v_wizardCityID = $("#wizardCityID").val();

            if(v_wizardCustomerNickname.length > 2) {
                $(".divWizardCustomerNickname").removeClass("has-danger");
                $("#wizardCustomerNicknameHelp").hide();

            } else {
                $(".divWizardCustomerNickname").addClass("has-danger");
                $("#wizardCustomerNicknameHelp").show();
                v_erro = 1;
            }

            if(v_erro === 1){return false;}else{
                $('#wizardAddCustomerModal').modal('hide');
                $('#customerID option:selected').removeAttr('selected');
                $v_option = '<option value="new" selected>'+v_wizardCustomerNickname+'</option>';
                $("#wizardCustomerID").append($v_option).selectpicker('refresh');
            }
        });

        $('.wizardStepForward').on('click',function () {
            let v_nextStep = parseInt($(this).attr('data-step'));
            let v_currentStep = parseInt($(this).attr('data-current-step'));
            let v_erro = 0;

           if(v_nextStep === 2) {
                let wizardOpportunityDesc = $('#wizardOpportunityDesc').val();
                if(wizardOpportunityDesc.length > 2) {
                    $(".divWizardOpportunityDesc").removeClass("has-danger");
                    $("#wizardOpportunityDescHelp").hide();
                } else {
                    $(".divWizardOpportunityDesc").addClass("has-danger");
                    $("#wizardOpportunityDescHelp").show();
                    v_erro = 1;
                }

                let wizardCustomerID = $('#wizardCustomerID').val();
                if(wizardCustomerID !== '') {
                    $(".divWizardCustomerID").removeClass("has-danger");
                    $("#wizardCustomerIDHelp").hide();
                } else {
                    $(".divWizardCustomerID").addClass("has-danger");
                    $("#wizardCustomerIDHelp").show();
                    v_erro = 1;
                }

                if (v_erro === 0) {
                    v_sourceID = $('#wizardSourceID').val();
                    let v_wizardSourceDesc = $("#wizardSourceID").find(':selected').text();
                    let v_wizardOpportunityStageID = $('#wizardOpportunityStageID').val();
                    let v_wizardOpportunityStageDesc = $("#wizardOpportunityStageID").find(':selected').text();

                    if (wizardCustomerID === 'new') {
                        v_newCustomer = true;
                        v_wizardCustomerNickname = $("#wizardCustomerNickname").val();
                        v_wizardCountryID = $("#wizardCountryID").val();
                        v_wizardStateID = $("#wizardStateID").val();
                        v_wizardCityID = $("#wizardCityID").val();
                        v_wizardCustomerTypeID = $("#wizardCustomerTypeID").val();
                    } else {
                        v_newCustomer = false;
                        v_wizardCustomerNickname = $("#wizardCustomerID").find(':selected').text();
                        v_wizardCountryID = null;
                        v_wizardStateID = null;
                        v_wizardCityID = null;
                        v_wizardCustomerTypeID = null;
                    }
                        $.ajax({
                            url: $.systemData.url+"/appDataAPI/wizardOpportunity",
                            method: "POST",
                            data: {
                                method: "POST",
                                type: "json",
                                stepID: v_currentStep,
                                customerID: wizardCustomerID,
                                customerNickname: v_wizardCustomerNickname,
                                newCustomer: v_newCustomer,
                                sourceID: v_sourceID,
                                sourceDesc: v_wizardSourceDesc,
                                opportunityStageID: v_wizardOpportunityStageID,
                                opportunityStageDesc: v_wizardOpportunityStageDesc,
                                opportunityDesc: wizardOpportunityDesc,
                                countryID: v_wizardCountryID,
                                stateID: v_wizardStateID,
                                cityID: v_wizardCityID,
                                customerTypeID: v_wizardCustomerTypeID
                            },
                            dataType: "JSON",
                            complete: function () {
                                $('.wizardStep-1').attr('data-step-status',true).val(true).addClass('wizard-done');
                                wizardStep(v_nextStep);
                            }
                        });
                    }
           }
           else if (v_nextStep === 3) {
               console.log('v_nextStep 3');
               $('.wizardStep-2').attr('data-step-status',true).addClass('wizard-done');
               wizardStep(v_nextStep);
                //nao obrigatorio
           }
           else if (v_nextStep === 4)
           {

                let v_qtdLinhas = $("#wizardProductAdded tbody tr").length;
                if(v_qtdLinhas < 1){
                    v_erro = 1;
                }else{
                    $.ajax({
                        url: $.systemData.url+"/appDataAPI/wizardOpportunity",
                        method: "POST",
                        data: {
                            method: "POST",
                            type: "json",
                            stepID: v_nextStep//definir retorno
                        },
                        dataType: "JSON",
                        success: function (d) {

                            //console.log(d[0]);
                            console.log('------------ retorno ajax-----'+d[0]);
                            //console.log('---');

                            $("#wizardConfirmCustomerNickname").text(d[0][2]);
                            $("#wizardConfirmOpportunityStageDesc").text(d[0][4]);
                            $("#wizardConfirmSourceDesc").text(d[0][6]);
                            $("#wizardConfirmOpportunityDesc").text(d[0][7]);

                            let v_tableConfirmContact = "";
                            $.each(d[1], function( index, value ) {
                                let v_contactPhone = '';
                                if(value[0]=='true'){
                                    v_contactPhone =  value[6]+' '+value[7];
                                }else{
                                    v_contactPhone =  value[4];
                                }
                                v_tableConfirmContact += "<tr><td>"+value[2]+"</td><td>"+value[3]+"</td><td>"+v_contactPhone+"</td><td>"+value[9]+"</td></tr>";
                            });
                            if(v_tableConfirmContact == ""){
                                $("#wizardTableContact").hide();
                                $("#wizardNoContact").show();
                            }else{
                                $("#wizardTableContact").show();
                                $("#wizardNoContact").hide();
                            }
                            $("#tableConfirmContact").html(v_tableConfirmContact);

                            let v_tableConfirmProduct = "";
                            $.each(d[2], function( index, value ) {
                                v_tableConfirmProduct += "<tr><td>"+value[2]+"</td><td class='text-right'>"+value[3]+"</td><td class='text-right'>"+value[4]+"</td><td class='text-right'>"+value[6]+"</td></tr>";
                            });
                            $("#tableConfirmProduct").html(v_tableConfirmProduct);

                        },
                        complete: function () {
                            //wizardStep(v_currentStep);
                            $('.wizardStep-3').attr('data-step-status',true).val(true).addClass('wizard-done');
                            wizardStep(v_nextStep);

                        }
                    });
                }

           }
           /*else if(v_currentStep === 3){

            }*/

           if(v_erro===1){ return false; }

            console.log('v_currentStep = '+v_currentStep);
            
        });

        $('.wizardStepPrevious').on('click',function () {
            let v_nextStep = parseInt($(this).attr('data-step'));
            //let v_currentStep = parseInt($(this).attr('data-current-step'));
            wizardStep(v_nextStep,false);

        });

        $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
            //return confirm("Do you want to leave the step "+stepNumber+"?");
            let v_erro = 0;

            if(stepDirection === 'forward'){
                if(stepNumber === 0){

                    let wizardOpportunityDesc = $('#wizardOpportunityDesc').val();
                    if(wizardOpportunityDesc.length > 2) {
                        $(".divWizardOpportunityDesc").removeClass("has-danger");
                        $("#wizardOpportunityDescHelp").hide();

                    } else {
                        $(".divWizardOpportunityDesc").addClass("has-danger");
                        $("#wizardOpportunityDescHelp").show();
                        v_erro = 1;
                    }

                    let wizardCustomerID = $('#wizardCustomerID').val();
                    if(wizardCustomerID !== '') {
                        $(".divWizardCustomerID").removeClass("has-danger");
                        $("#wizardCustomerIDHelp").hide();

                    } else {
                        $(".divWizardCustomerID").addClass("has-danger");
                        $("#wizardCustomerIDHelp").show();
                        v_erro = 1;
                    }

                    if(v_erro === 0){
                        v_sourceID = $('#wizardSourceID').val();
                        let v_wizardSourceDesc = $("#wizardSourceID").find(':selected').text();
                        let v_wizardOpportunityStageID = $('#wizardOpportunityStageID').val();
                        let v_wizardOpportunityStageDesc = $("#wizardOpportunityStageID").find(':selected').text();

                        if(wizardCustomerID=='new')
                        {
                            v_newCustomer = true;
                            v_wizardCustomerNickname = $("#wizardCustomerNickname").val();
                            v_wizardCountryID = $("#wizardCountryID").val();
                            v_wizardStateID = $("#wizardStateID").val();
                            v_wizardCityID = $("#wizardCityID").val();
                        }else{
                            v_newCustomer = false;
                            v_wizardCustomerNickname = $("#wizardCustomerID").find(':selected').text();
                            v_wizardCountryID = null;
                            v_wizardStateID = null;
                            v_wizardCityID = null;
                        }

                        $.ajax({
                            url: $.systemData.url+"/appDataAPI/wizardOpportunity",
                            method: "POST",
                            data: {
                                method: "POST",
                                type: "json",
                                stepID: stepNumber,
                                customerID: wizardCustomerID,
                                customerNickname: v_wizardCustomerNickname,
                                newCustomer: v_newCustomer,
                                sourceID: v_sourceID,
                                sourceDesc: v_wizardSourceDesc,
                                opportunityStageID: v_wizardOpportunityStageID,
                                opportunityStageDesc: v_wizardOpportunityStageDesc,
                                opportunityDesc: wizardOpportunityDesc,
                                countryID: v_wizardCountryID,
                                stateID: v_wizardStateID,
                                cityID: v_wizardCityID
                            },
                            dataType: "JSON",
                            success: function (d) {
                            },
                            complete: function () {

                            }
                        });
                    }


                }else if(stepNumber==1){
                    //nao obrigatorio

                }else if(stepNumber==2){

                    let v_qtdLinhas = $("#wizardProductAdded tbody tr").length;
                    if(v_qtdLinhas<2){
                        v_erro = 1;
                    }

                }
                if(v_erro===1){return false;}
            }

        });

        $("#wizardCustomerID").change(function () {
            let wizardCustomerID = $(this).val();
            if(wizardCustomerID!==''){
                getContactList(wizardCustomerID);
            }
        });

        $("#wizardContactID").change(function () {
            let wizardContactID = $(this).val();
            if(wizardContactID!==''){
                $('#switchSaveWizardContact').removeClass('hidden');
            }
        });

        $("#wizardPhoneCountryID").selectpicker('refresh').selectpicker('val',$.globalData.userCountryID);

        let v_wizardPhoneMask = $('#wizardPhoneCountryID option:selected').attr('data-wizard_phone_mask');

        $("#wizardContactPhone").mask(v_wizardPhoneMask);

        $('#wizardPhoneCountryID').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            let v_phone_mask =  $('#wizardPhoneCountryID option:selected').attr('data-wizard_phone_mask');
            $("#wizardContactPhone").val('');
            $("#wizardContactPhone").mask(v_phone_mask);
        });

        $("#wizardContactPhone").keyup(function(){
            let v_wizardPhoneCountryID = $('#wizardPhoneCountryID option:selected').val();
            let v_phoneClean = $(this).cleanVal();

            if(v_wizardPhoneCountryID == 3){
                if(v_phoneClean.charAt(2) === '9'){
                    $("#wizardContactPhone").mask('(00) 00000-0000');
                    $('#wizardPhoneCountryID option:selected').attr('data-wizard_phone_mask','(00) 00000-0000');
                }else{
                    $("#wizardContactPhone").mask('(00) 0000-0000');
                    $('#wizardPhoneCountryID option:selected').attr('data-wizard_phone_mask','(00) 0000-0000');
                }
            }
        });

        $("#switchSaveWizardContact").click(function () {
            tempContactID++;
            let wizardContactID = $("#wizardContactID").val();
            let wizardContactName = $("#wizardContactID").find(':selected').data("wizard_contact_name");
            let wizardEmailAddress = $("#wizardContactID").find(':selected').data("wizard_email_address");
            let wizardFullNumber = $("#wizardContactID").find(':selected').data("wizard_full_number");
            let wizardPhoneTypeDesc = $("#wizardContactID").find(':selected').data("wizard_phone_type_desc");
            let wizardContactTable = "<tr><td>"+wizardContactName+"</td><td>"+wizardEmailAddress+"</td><td>"+wizardFullNumber+"</td><td>"+wizardPhoneTypeDesc+"</td><td class='text-center'><i class=\"fa fa-border fa-trash wizardContactDel\" style=\"cursor: pointer;\" data-temp_contact_id=\""+tempContactID+"\"></i></td></tr>";

            if(wizardContactID!==''){
                $("#wizardContactAdded").append(wizardContactTable);
                $("#wizardContactAdded").show();
                $("#wizardContactID").find(':selected').remove();
                $("#wizardContactID").selectpicker('refresh');

                $.ajax({
                    url: $.systemData.url+"/appDataAPI/wizardOpportunity",
                    method: "POST",
                    data: {
                        method: "POST",
                        type: "json",
                        stepID: 2,
                        newContact: false,
                        contactID: wizardContactID,
                        contactName: wizardContactName,
                        contactEmail: wizardEmailAddress,
                        fullNumber: wizardFullNumber,
                        phoneCountryID: false,
                        phoneArea: false,
                        contactPhone: false,
                        phoneTypeID: false,
                        phoneTypeDesc: wizardPhoneTypeDesc,
                        tempContactID: tempContactID
                    },
                    dataType: "JSON",
                    success: function (d) {
                    },
                    complete: function () {

                    }
                });

            }
            $(this).addClass('hidden');
        });

        $(".btnWizardSaveContact").on('click',function () {

            let v_erro = 0;

            let wizardContactName = $("#wizardContactName").val();
            if(wizardContactName.length > 2) {
                $(".divWizardContactName").removeClass( "has-danger" );
                $("#wizardContactNameHelp").hide();
            } else {
                $(".divWizardContactName").addClass("has-danger");
                $("#wizardContactNameHelp").show();
                v_erro = 1;
            }

            let wizardContactEmail = $("#wizardContactEmail").val();
            if(!validator.isEmail(wizardContactEmail))
            {
                if(wizardContactEmail==''){
                    $(".divWizardContactEmail").removeClass( "has-danger" );
                    $("#wizardContactEmailHelp").hide();
                }else{
                    $(".divWizardContactEmail").addClass("has-danger");
                    $("#wizardContactEmailHelp").show();
                    v_erro = 1;
                }

            }else{
                $(".divWizardContactEmail").removeClass( "has-danger" );
                $("#wizardContactEmailHelp").hide();
            }


            let wizardContactPhone = $("#wizardContactPhone").val();
            let v_wizard_phone_mask = $('#wizardPhoneCountryID option:selected').attr('data-wizard_phone_mask');

            if(wizardContactPhone.length == v_wizard_phone_mask.length || wizardContactPhone.length == 0){
                $(".divWizardContactPhone").removeClass( "has-danger" );
                $("#wizardContactPhoneHelp").hide();
            }else{
                $(".divWizardContactPhone").addClass("has-danger");
                $("#wizardContactPhoneHelp").show();
                v_erro = 1;
            }


            if(v_erro === 1) { return false; } else {
                tempContactID++;
                let wizardPhoneCountryID = $("#wizardPhoneCountryID").val();
                let wizardPhoneTypeID = $("#wizardPhoneTypeID").val();
                let wizardPhoneTypeDesc = $("#wizardPhoneTypeID").find(':selected').text();
                let wizardPhoneArea = $("#wizardPhoneCountryID option:selected").data("phone_area");
                let v_newContact = true;
                let v_contactID = false;
                let wizardContactTable = "<tr><td>"+wizardContactName+"</td><td>"+wizardContactEmail+"</td><td>"+wizardPhoneArea+" "+wizardContactPhone+"</td><td>"+wizardPhoneTypeDesc+"</td><td class='text-center'><i class=\"fa fa-border fa-trash wizardContactDel\" style=\"cursor: pointer;\" data-temp_contact_id=\""+tempContactID+"\"></i></td></tr>";
                $("#wizardContactAdded tbody").append(wizardContactTable);
                $("#wizardContactAdded").show();

                $.ajax({
                    url: $.systemData.url+"/appDataAPI/wizardOpportunity",
                    method: "POST",
                    data: {
                        method: "POST",
                        type: "json",
                        stepID: 2,
                        newContact: v_newContact,
                        contactID: v_contactID,
                        contactName: wizardContactName,
                        contactEmail: wizardContactEmail,
                        fullNumber: false,
                        phoneCountryID: wizardPhoneCountryID,
                        phoneArea: wizardPhoneArea,
                        contactPhone: wizardContactPhone,
                        phoneTypeID: wizardPhoneTypeID,
                        phoneTypeDesc: wizardPhoneTypeDesc,
                        tempContactID: tempContactID

                    },
                    dataType: "JSON",
                    success: function (d) {
                    },
                    complete: function () {

                    }
                });

                $('#wizardAddContactModal').modal('hide');
            }

        });

        $(document).on('click', '.wizardContactDel', function(){
            let v_tempContactID = $(this).attr("data-temp_contact_id");
            var v_trDeleted =  $(this).closest('tr');

            $.ajax({
                url: $.systemData.url+"/appDataAPI/wizardOpportunityDelete",
                method: "POST",
                data: {
                    method: "POST",
                    type: "json",
                    stepID: 2,
                    tempContactID: v_tempContactID
                },
                dataType: "JSON",
                success: function (d) {
                    console.log(d);
                    if(d === true){
                        console.log($(this).closest('tr'));
                        $(v_trDeleted).remove();
                    }
                },
                complete: function () {

                }
            });
        });

        $(document).on('click', '.wizardProductDel', function(){
            let v_tempProductID = $(this).attr("data-temp_product_id");
            var v_trDeleted =  $(this).closest('tr');

            $.ajax({
                url: $.systemData.url+"/appDataAPI/wizardOpportunityDelete",
                method: "POST",
                data: {
                    method: "POST",
                    type: "json",
                    stepID: 3,
                    tempProductID: v_tempProductID
                },
                dataType: "JSON",
                success: function (d) {
                    if(d === true){
                        $(v_trDeleted).remove();
                    }
                },
                complete: function () {

                }
            });
        });

        $('#wizardAddContactModal').on('hidden.bs.modal', function(e) {
            $("#wizardContactName").val("");
            $("#wizardContactEmail").val("");
            $("#wizardContactPhone").val("");
        });

        let wizardBasePriceOptions =  {
            onComplete: function(wizardBasePriceOptions){},
            onKeyPress: function(wizardBasePriceOptions, event, currentField, options){

                let v_basePrice = wizardBasePriceOptions.replace(/\,/g,'');

                if(v_basePrice.length=='1')
                {
                    v_basePrice = parseFloat(v_basePrice/100);
                }
                $('#cleanWizardProductBasePrice').val(v_basePrice);
                $('#wizardProductBasePrice').val(Number(v_basePrice).toLocaleString($.globalData.localeJS, { style: 'currency', currency: 'USD' }));
                if(parseFloat(v_basePrice) === 0 || isNaN(v_basePrice))
                {
                    $('#wizardProductBasePrice').val('0');
                    $('#cleanWizardProductBasePrice').val('0.00');
                }

            },
            onChange: function(basePrice){},
            onInvalid: function(val, e, f, invalid, options){
                //let error = invalid[0];
                //console.log ("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
            },
            reverse: true,
            placeholder: "0.00"
        };

        let wizardNewQuoteMaskOptions =  {
            onComplete: function(wizardNewProductQuotedPrice){},
            onKeyPress: function(wizardNewProductQuotedPrice, event, currentField, options){
                let v_quotePrice = parseFloat(wizardNewProductQuotedPrice.replace(/\,/g,''));

                if(wizardNewProductQuotedPrice.length=='1')
                {
                    v_quotePrice = parseFloat(v_quotePrice/100);
                }
                $('#wizardNewProductQuotedClean').val(v_quotePrice);
                //$('#newQuotePrice').val(v_quotePrice);
                $('#wizardNewProductQuotedPrice').val(Number(v_quotePrice).toLocaleString($.globalData.localeJS, { style: 'currency', currency: 'USD' }));

                if(parseFloat(v_quotePrice) === 0 || isNaN(v_quotePrice))
                {
                    $('#wizardNewProductQuotedPrice').val('');
                    $('#cleanWizardNewProductQuotedPrice').val('');
                }
            },
            onChange: function(itemValue){},
            onInvalid: function(val, e, f, invalid, options){
                //let error = invalid[0];
                //console.log ("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
            },
            reverse: true,
            placeholder: ""
        };

        $("#wizardNewFreeOfCharge").bootstrapToggle();

        $("#btnWizardSaveProduct").click(function() {
            let v_erro = 0;
            let wizardProductDesc = $("#wizardProductDesc").val();
            if(wizardProductDesc.length > 1) {
                $(".divWizardProductDesc").removeClass( "has-danger" ).addClass( "has-success" );
                $("#wizardProductDescHelp").hide();
            } else {
                $(".divWizardProductDesc").removeClass( "has-success" ).addClass( "has-danger" );
                $("#wizardProductDescHelp").show();
                v_erro = 1;
            }

            let wizardQuotedUnits = $("#wizardQuotedUnits").val();
            if(wizardQuotedUnits > 0 ) {
                $(".divWizardQuotedUnits").removeClass( "has-danger" ).addClass( "has-success" );
                $("#wizardQuotedUnitsHelp").hide();
            } else {
                $(".divWizardQuotedUnits").removeClass( "has-success" ).addClass( "has-danger" );
                $("#wizardQuotedUnitsHelp").show();
                v_erro = 1;
            }

            if(v_erro === 1) { return false; } else {
                tempProductID++;
                let wizardProductBasePrice = $("#wizardProductBasePrice").val();
                let cleanWizardProductBasePrice = $("#cleanWizardProductBasePrice").val();
                let wizardNewProductQuotedPrice = $("#wizardNewProductQuotedPrice").val();
                let wizardNewFreeOfCharge = $("#wizardNewFreeOfCharge").prop('checked');
                let wizardNewProductQuotedClean = $("#wizardNewProductQuotedClean").val();

                let wizardProductTable = "<tr><td>"+wizardProductDesc+"</td><td class='text-right'>"+wizardProductBasePrice+"</td><td class='text-right'>"+wizardNewProductQuotedPrice+"</td><td class='text-right'>"+wizardQuotedUnits+"</td><td class='text-center'><i class=\"fa fa-border fa-trash wizardProductDel\" style=\"cursor: pointer;\" data-temp_product_id=\""+tempProductID+"\"></i></td></tr>";
                $("#wizardProductAdded tbody").append(wizardProductTable);
                $("#wizardProductAdded").show();
                $('#wizardNewProductModal').modal('hide');

                $.ajax({
                    url: $.systemData.url+"/appDataAPI/wizardOpportunity",
                    method: "POST",
                    data: {
                        method: "POST",
                        type: "json",
                        stepID: 3,
                        newProduct: true,
                        productID: false,
                        productDesc: wizardProductDesc,
                        wizardProductBasePrice: wizardProductBasePrice,
                        productQuotedPrice: wizardNewProductQuotedPrice,
                        freeOfCharge: wizardNewFreeOfCharge,
                        quotedUnits: wizardQuotedUnits,
                        wizardProductBasePriceClean : cleanWizardProductBasePrice,
                        productQuotedPriceClean: wizardNewProductQuotedClean,
                        tempProductID: tempProductID
                    },
                    dataType: "JSON",
                    complete: function () {

                    }
                });

            }
        });

        $("#btnWizardAddProduct").click(function () {
            console.log('addProduct');

            let wizardProductID = $("#wizardProductID").val();
            let wizardAddProductDesc = $("#wizardAddProductDesc").text();
            let wizardAddProductBasePrice = $("#wizardAddProductBasePrice").val();
            let wizardNewProductQuotedPrice = $("#wizardNewProductQuotedPrice").val();
            let wizardNewFreeOfCharge = $("#wizardNewFreeOfCharge").prop('checked');
            let wizardQuotedUnits = $("#wizardQuotedUnits").val();
            let wizardProductBasePriceClean = $("#cleanWizardAddProductBasePrice").val();
            let wizardProductQuotedPriceClean = $("#wizardNewProductQuotedClean").val();
            let v_erro = 0;
            if(wizardQuotedUnits > 0 )
            {
                $(".divWizardQuotedUnits").removeClass( "has-danger" ).addClass( "has-success" );
                $("#wizardQuotedUnitsHelp").hide();
            } else {
                $(".divWizardQuotedUnits").removeClass( "has-success" ).addClass( "has-danger" );
                $("#wizardQuotedUnitsHelp").show();
                v_erro = 1;
            }

            if(v_erro === 1) { return false; } else {
                tempProductID++;
                let wizardProductTable = "<tr><td>"+wizardAddProductDesc+"</td><td class='text-right'>"+wizardAddProductBasePrice+"</td><td class='text-right'>"+wizardNewProductQuotedPrice+"</td><td class='text-right'>"+wizardQuotedUnits+"</td><td class='text-center'><i class=\"fa fa-border fa-trash wizardProductDel\" style=\"cursor: pointer;\" data-temp_product_id=\""+tempProductID+"\"></i></td></tr>";
                $("#wizardProductAdded tbody").append(wizardProductTable);
                $("#wizardProductAdded").show();
                $('#wizardNewProductModal').modal('hide');

                $.ajax({
                    url: $.systemData.url+"/appDataAPI/wizardOpportunity",
                    method: "POST",
                    data: {
                        method: "POST",
                        type: "json",
                        stepID: 3,
                        newProduct: false,
                        productID: wizardProductID,
                        productDesc: wizardAddProductDesc,
                        wizardProductBasePrice: wizardAddProductBasePrice,
                        productQuotedPrice: wizardNewProductQuotedPrice,
                        freeOfCharge: wizardNewFreeOfCharge,
                        quotedUnits: wizardQuotedUnits,
                        wizardProductBasePriceClean: wizardProductBasePriceClean,
                        productQuotedPriceClean: wizardProductQuotedPriceClean,
                        tempProductID: tempProductID
                    },
                    dataType: "JSON",
                    complete: function () {

                    }
                });
            }


        });

        $("#wizardProductID").change(function () {
            let wizardProductID = $(this).val();
            if(wizardProductID!==''){
                $('#switchSaveWizardProduct').removeClass('hidden');
            }
        });

        $("#wizardProductPlus").click(function () {
            $("#wizardQuotedUnitsHelp").hide();
            $("#wizardProductDesc").val('');
            $("#wizardProductBasePrice").val('');
            $("#wizardNewProductQuotedClean").val('0.00');

            $('#wizardProductBasePrice').mask("#,##0.00",wizardBasePriceOptions);
            $('#wizardProductBasePrice').val(Number(0).toLocaleString($.globalData.localeJS, { style: 'currency', currency: 'USD' }));

            $('#wizardNewProductQuotedPrice').mask("#,##0.00",wizardNewQuoteMaskOptions);


            $("#wizardNewProductQuotedPrice").prop('disabled',false).val('');
            $('#wizardNewFreeOfCharge').prop('checked', false).change();

            let wizardQuotedUnits = 1;
            $('#wizardQuotedUnits').val(wizardQuotedUnits);
            $('#wizardQuotedUnits').mask('000000');

            $(".divAddProduct").hide();
            $(".divWizardProductDesc").show();
            $(".divNewProductBasePrice").hide();
            $(".divWizardProductBasePrice").show();
            $("#btnWizardSaveProduct").show();
            $("#btnWizardAddProduct").hide();
            $("#wizardProductDescHelp").hide();

            $(".divWizardProductDesc").removeClass( "has-danger" ).removeClass("has-success");
            $(".divWizardQuotedUnits").removeClass( "has-danger" ).removeClass("has-success");

        });

        $("#switchSaveWizardProduct").click(function () {

            $("#wizardNewProductQuotedPrice").val('');
            $("#wizardNewProductQuotedClean").val('0.00');
            $(".divAddProduct").show();
            $(".divWizardProductDesc").hide();
            $(".divNewProductBasePrice").show();
            $(".divWizardProductBasePrice").hide();
            $("#btnWizardSaveProduct").hide();
            $("#btnWizardAddProduct").show();
            $(".divWizardProductDesc").removeClass("has-danger" ).removeClass("has-success");
            $(".divWizardQuotedUnits ").removeClass("has-danger" ).removeClass("has-success");
            $("#wizardQuotedUnitsHelp").hide();

            let v_wizardProductID = $("#wizardProductID").val();
            let v_wizardProductDesc = $("#wizardProductID").find(':selected').text();
            let v_basePrice =  $("#wizardProductID option:selected").data("base_price");
            $("#wizardAddProductDesc").text(v_wizardProductDesc);
            $('#wizardNewProductQuotedPrice').mask("#,##0.00",wizardNewQuoteMaskOptions);
            $('#wizardAddProductBasePrice').val(Number(v_basePrice).toLocaleString($.globalData.localeJS, { style: 'currency', currency: 'USD' }));
            $("#cleanWizardAddProductBasePrice").val(v_basePrice);
            $('#wizardAddFreeOfCharge').prop('checked', false).change();
            let v_wizardQuotedUnits = 1;
            $('#wizardQuotedUnits').val(v_wizardQuotedUnits);
            $('#wizardQuotedUnits').mask('000000');
        });

        $(document).on('change','#wizardNewFreeOfCharge',function(e) {

            if(!$(this).prop('checked'))
            {
                $("#wizardNewProductQuotedPrice").prop('disabled',false).val('');
            }
            else
            {
                $("#wizardNewProductQuotedPrice").prop('disabled',true).val('Free');
            }

        });

        $(document).on('click','#btnWizardConfirm',function (){

            bootbox.confirm({
                message: "Are you sure you want to add all informations and create a new opportunity?",
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
                        $("#step-4").fadeOut('slow',function() {
                            $('#wizardLoading').fadeIn('slow');
                        });

                        $.ajax({
                            url: $.systemData.url+"/appDataAPI/wizardOpportunityConfirm",
                            method: "POST",
                            data: {
                                method: "POST",
                                type: "json"
                            },
                            dataType: "JSON",
                            success: function (d) {
                                if(d === true){
                                    $(".divAppOpportunityWizard").fadeOut('slow',function () {
                                        $(".basicContent").fadeIn('slow',function () {
                                            $('#wizardLoading').fadeOut('slow',function(){
                                            });
                                        });
                                    });
                                    toastr["success"]("Your new opportunity has been created successfully!","Success!");
                                    wizardReset();
                                }else{
                                    $("#wizardLoading").fadeOut('slow',function() {
                                        $("#step-4").fadeIn('slow',function() {});
                                    });

                                    toastr["warning"]("Something went wrong. Check all informations and try again.","Oooops!");
                                }
                            },
                            complete: function () {

                            }
                        });
                    }
                }
            });
        });

        wizardStep(1);

        $(document).on('change','#wizardCustomerType',function(e) {

            if(!$(this).prop('checked'))
            {
                $('#wizardLabelCustomerType').text('Full Name:');
                $('#wizardCustomerTypeID').val(2);
            }
            else
            {
                $('#wizardLabelCustomerType').text('DBA:');
                $('#wizardCustomerTypeID').val(1);
            }

        });


    });
}

function wizardStep(s=0,nxt=true) {
    console.log('step = '+s);
    //console.log('nxt = '+nxt);

    $('.wizardStepsContainer:visible').fadeOut('slow',function() {
        if(s > 0)
        {
            if(nxt===true){
                $('.wizardSteps').removeClass('wizard-active');
                $('.wizardStep-'+s).removeClass('wizard-inactive wizard-active').addClass('wizard-active');
            }else{
                $('.wizardSteps').removeClass('wizard-active');
                $('.wizardStep-'+s).removeClass('wizard-inactive wizard-active').addClass('wizard-active');
                let currentStep = s+1;
                $('.wizardStep-'+currentStep).removeClass('wizard-done').addClass('wizard-inactive');console.log('inativa step'+currentStep);
            }

        }

        let v_step = '#step-'+s;
        $(v_step).fadeIn('slow',function () {
            //console.log('step '+s+' displayed');
        });
    });
}

function wizardReset() {
    $('.wizardSteps').removeClass('wizard-done wizard-active').addClass('wizard-inactive');
    wizardStep(1);
    //customer
    $('#wizardOpportunityDesc').val('');
    $("#wizardCustomerID").selectpicker('refresh').selectpicker('val','');
    $("#wizardContactID").selectpicker('refresh').selectpicker('val','');
    $("#wizardContactAdded tbody").html('');
    $("#wizardContactAdded").hide();
    $("#wizardProductAdded tbody").html('');
    $("#wizardProductAdded").hide();
    $("#wizardProductID").selectpicker('refresh').selectpicker('val','');


}

$(".wizardCancel").click(function () {''
    $('.divAppOpportunityWizard').fadeOut('slow',function () {
        $.ajax({
            url: $.systemData.url+"/appDataAPI/wizardOpportunityCancel",
            method: "POST",
            data: {
                method: "POST",
                type: "json"
            },
            dataType: "JSON",
            complete: function () {
                wizardReset();
                $(".basicContent").fadeIn('slow');
            }
        });
    });
});


