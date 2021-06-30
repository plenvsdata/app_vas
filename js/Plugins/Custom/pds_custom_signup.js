let pdsValidation = {
    strLenCheck: function(str,strLen=1) {
        return ($.trim(str).length >= strLen);
    },
    voucherFormat: function(voucher) {
        let v_voucherData = new RegExp(/([A-Z0-9]){8}/g);
        return v_voucherData.test(voucher);
    },
    voucherValidate: function(hasVoucher,voucher) {
        let v_return = [];
        if(hasVoucher) {
            if(this.voucherFormat(voucher)) {
                return $.ajax({
                    url: "appSignUpAPI/appVoucherCheck",
                    type: "POST",
                    data: { appVoucherData: voucher }
                });
            } else {
                v_return[0] = '{ "voucherCheck" : false }';
                return v_return;
            }
        } else {
            v_return[0] = '{ "voucherCheck" : null }';
            return v_return;
        }
    },
    signUpEmailValidation: function(signUpForm) {
        if(validator.isEmail($.trim(signUpForm.regEmail))) {
            return $.ajax({
                url: "appSignUpAPI/appEmailValidation",
                type: "POST",
                data: { formData: signUpForm }
            });
        } else {
            return ['{ "emlAvailable" : false, "emlValid" : false }'];
        }

    },
    appValidation: function(urlToken) {
        return $.ajax({
            url: "appSignUpAPI/"+urlToken+"/appSignUpProcess",
            type: "POST",
            data: { formData: urlToken }
        });
    },
    signUpTokenData: function(signUpInfo) {
        return $.ajax({
            url: "appSignUpAPI/appSignUpToken",
            type: "POST",
            data: { formData: signUpInfo }
        });
    },
    signUpCodeValidation: function (signUpCode) {
        return $.ajax({
            url: "appSignUpAPI/appCodeValidation",
            type: "POST",
            data: { formData: signUpCode }
        });
    },
    recoverPasswordCodeValidation: function (recoverPasswordCode,token,url) {
        return $.ajax({
            url: url,
            type: "POST",
            data: {
                formData: recoverPasswordCode,
                tokenData: token
            }
        });
    }
};
/*
let pdsComboData = {
    signUpCountryList: function(countryID=null) {
        return $.ajax({
            url: "appDataAPI/appComboSystemCountry",
            type: "POST",
            data: { formData: countryID }
        });
    },
    signUpStateList: function(countryID=null) {
        return $.ajax({
            url: "appDataAPI/appComboSystemState",
            type: "POST",
            data: { countryID: countryID }
        });
    },
    signUpCityList: function(stateID=null) {
        return $.ajax({
            url: "appDataAPI/appComboSystemCity",
            type: "POST",
            data: { stateID: stateID }
        });
    },
    signUpReturn(status) {
        return status;
    }
};
*/