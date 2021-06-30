let pdsSetSession = {
    firstAccess: function(sessID = 1) {
        return $.ajax({
            url: "appDataAPI/FirstAccessComplete",
            type: "POST",
            data: { sessID: sessID }
        });
    },
    welcomeScreen: function(sessID = 1) {
        return $.ajax({
            url: "appDataAPI/WelcomeScreenAccess",
            type: "POST",
            data: { sessID: sessID }
        });
    },
    featureRedirect(fID) {
        const v_featureURL = [null,'#featureImportData','#opportunityWizardLink',null,'#addNewContacts'];
        if(v_featureURL[fID]!==null) {
            $(v_featureURL[fID])[0].click();
        } else {
            $.unblockUI();
        }
    }
};