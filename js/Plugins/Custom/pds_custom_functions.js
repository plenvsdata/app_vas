function strip_html_tags(str)
{
    if ((str===null) || (str===''))
        return "";
    else
        str = str.toString();
    return str.replace(/<[^>]*>/g, '');
}

function validatePhoneData(phone,country)
{
    // Example:
    // 55 -> Brazil | 10 Length WITHOUT country code
    let v_countryPhoneLength = {
        1 : 10,
        55 : 10,
        559 : 11
    };

    let v_countryCode = parseInt(String(country).replace(/(\(|\))/gmi,""));
    let v_phoneString = String(phone);
    return (parseInt(v_phoneString.length) >= parseInt(v_countryPhoneLength[v_countryCode]));
}

function validateZipData(zip,country)
{
    // Example:
    // 55 -> Brazil | 10 Length WITHOUT country code
    let v_countryZipLength = {
        1 : 5,
        55 : 8
    };

    let v_countryCode = parseInt(String(country).replace(/(\(|\))/gmi,""));
    let v_zipString = String(zip);
    return (parseInt(v_zipString.length) >= parseInt(v_countryZipLength[v_countryCode]));
}

function pwdStrenghCheck(pwd)
{
    let v_pwdData = new RegExp(/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%&*?]).{8,}/g);
    return v_pwdData.test(pwd);
}


function initMagnificPopup(classID)
{
    $('.'+classID).magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        mainClass: 'mfp-img-mobile',
        image: {
            verticalFit: true
        }
    });
}

function showStateCityLoading(stateField='#stateID',state=false,cityField="#cityID",city=false) {
    if(state===true)
    {
        $(stateField+" > option:first-child").text('Loading States...');
        $(stateField).selectpicker();
        $(stateField).selectpicker("refresh");
    }
    else
    {
        $(stateField+" > option:first-child").text('Select State');
        $(stateField).selectpicker();
        $(stateField).selectpicker("refresh");
    }

    if(city===true)
    {
        $(cityField+" > option:first-child").text('Loading Cities...');
        $(cityField).selectpicker();
        $(cityField).selectpicker("refresh");
    }
    else
    {
        $(cityField+" > option:first-child").text('Select City');
        $(cityField).selectpicker();
        $(cityField).selectpicker("refresh");
    }
}

let pdsComboData = {
    pdsCountryList: function(countryID=null) {
        return $.ajax({
            url: $.systemData.url+"/appDataAPI/appComboSystemCountry",
            type: "POST",
            data: { formData: countryID, type:"json" }
        });
    },
    pdsStateList: function(countryID=null) {
        return $.ajax({
            url: $.systemData.url+"/appDataAPI/appComboSystemState",
            type: "POST",
            data: { countryID: countryID, type:"json" }
        });
    },
    pdsCityList: function(stateID=null) {
        return $.ajax({
            url: $.systemData.url+"/appDataAPI/appComboSystemCity",
            type: "POST",
            data: { stateID: stateID, type:"json" }
        });
    },
    pdsOpportunityStage: function(stageID=null) {
        return $.ajax({
            url: $.systemData.url+"/appDataAPI/appComboSystemOpportunityStageInit",
            type: "POST",
            data: { stageID: stageID,type:"json" }
        });
    },
    pdsOpportunitySource: function(sourceID=null) {
        return $.ajax({
            url: $.systemData.url+"/appDataAPI/appComboSource",
            type: "POST",
            data: { sourceID: sourceID, type:"json" }
        });
    },
    pdsOpportunityCustomer: function(customerID=null) {
        return $.ajax({
            url: $.systemData.url+"/appDataAPI/appListCustomer",
            type: "POST",
            data: { customerID: customerID, type:"json" }
        });
    },
    pdsOpportunityProduct: function(productID=null) {
        return $.ajax({
            url: $.systemData.url+"/appDataAPI/appListProduct",
            type: "POST",
            data: { productID: productID, type:"json" }
        });
    },
    pdsOpportunityPhoneType: function(phoneTypeID=null) {
        return $.ajax({
            url: $.systemData.url+"/appDataAPI/appComboPhoneType",
            type: "POST",
            data: { phoneTypeID: phoneTypeID, type:"json" }
        });
    },
    pdsGeoData: function() {
        return $.ajax({
            url: $.systemData.url+"/appDataAPI/appToolGeoData",
            type: "POST",
            data: { type:"json" }
        });
    },
    signUpReturn: function(status) {
        return status;
    }
};

let pdsGlobalFn = {
    setMapHeight() {
        let v_windowWidth = $(window).width();
        let v_windowHeight = $(window).height();
        $('#main').css('height',(v_windowHeight-220)+'px');
    }
};