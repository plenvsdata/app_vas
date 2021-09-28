<?php
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Credentials: true');
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 02/10/2017
 * Time: 22:51
 */
session_start();
require($_SERVER['DOCUMENT_ROOT'] . "/appClasses/appGlobal.php");
require($_SERVER['DOCUMENT_ROOT'] . "/appGlobals/appGlobalSettings.php");

use app\System\Tools\UpdateBatchID\appSetNullBatchID;
use app\userAccess\userData\appUserData;
use app\userAccess\appUserControl;
use app\System\Lov\appLov;
use app\System\Customer\appCustomer;
use app\System\Combo\appCombo;
use app\System\Installation\appInstallation;
use app\System\Lists\appDataList;


use app\System\Product\appProduct;

use app\System\Photo\appPhoto;
use app\System\File\appFile;
use app\System\Relational\appRelationalData;
use app\System\Contact\appContact;
use app\System\Address\appAddress;
use app\System\Phone\appPhone;
use app\System\Reference\appReference;
use app\System\Spec\appSpec;
use app\System\Email\appEmail;


use app\System\Website\appWebsite;
use app\System\Price\appPrice;
use app\System\Tools\appSystemTools;
use app\System\DataLoader\appDataLoader;
use app\System\GeoData\appGeoLocCustomersData;
use app\System\GeoData\appGeoLocContactsData;
use app\System\Lov\appGetValue;
use app\userAccess\userData\appUserData as appLoginCheck;
use app\System\BusinessOpportunityItem\appBusinessOpportunityItem;
use app\System\Expense\appExpense;

$v_dataSec = !empty($_REQUEST['dataSec']) ? $_REQUEST['dataSec'] : NULL;

/* API Features */
if($v_dataSec == "appListUser")
{
    $v_appData = new appDataList();
    $v_appUserList = $v_appData->appUserList();
    $v_returnData["appUserList"] = $v_appUserList["rsData"];
    echo json_encode($v_returnData);
}
elseif($v_dataSec == "appListSettingsUser")
{
    $v_appData = new appDataList();
    $v_appUserList = $v_appData->appSettingsUserList();
    $v_returnData["appUserList"] = $v_appUserList["rsData"];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appUser")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_contactData =  new appContact();
    $v_appContact = $v_contactData->appContactData($v_appData);
    echo json_encode($v_appContact);
}
elseif ($v_dataSec == "appInstallation")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_data =  new appInstallation();
    $v_appReturn = $v_data->appInstallationData($v_appData);
}
elseif ($v_dataSec == "appDashboard")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_data =  new appInstallation();
    $v_appReturn = $v_data->appDashboardData($v_appData);
}
elseif ($v_dataSec == "appDashboardCamera")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_data =  new appInstallation();
    $v_appReturn = $v_data->appDashboardCameraData($v_appData);
}
elseif ($v_dataSec == "appCamera")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_data =  new appInstallation();
    $v_appReturn = $v_data->appCameraData($v_appData);
}
elseif ($v_dataSec == "appUserAccess")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_userAccess =  new appUserData();
    $v_UserAccessData = $v_userAccess->appUserAccess($v_appData);
    echo json_encode($v_UserAccessData);
}
elseif($v_dataSec == "appListInstallation")
{
    $v_appData = new appDataList();
    $v_appInstallationList = $v_appData->appInstallationList();
    $v_returnData["appInstallationList"] = $v_appInstallationList["rsData"];
    echo json_encode($v_returnData);
}
elseif($v_dataSec == "appListCamera")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_data = new appDataList();
    $v_appList = $v_data->appCameraList($v_appData);
    $v_returnData["appCameraList"] = $v_appList["rsData"];
    echo json_encode($v_returnData);
}
elseif($v_dataSec == "appListDashboardCamera")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_data = new appDataList();
    $v_appList = $v_data->appDashboardCameraList($v_appData);
    $v_returnData["appDashboardCameraList"] = $v_appList["rsData"];
    echo json_encode($v_returnData);
}
elseif($v_dataSec == "appListDashboard")
{
    $v_appData = new appDataList();
    $v_appDashboardList = $v_appData->appDashboardList();
    $v_returnData["appDashboardList"] = $v_appDashboardList["rsData"];
    echo json_encode($v_returnData);
}
elseif($v_dataSec == "appDashboardConfig")
{
    $v_appData = new appDataList();
    $v_appDashboardConfig = $v_appData->appDashboardConfig();
    $v_returnData["appDashboardConfig"] = $v_appDashboardConfig["rsData"];
    echo json_encode($v_returnData);
}
elseif($v_dataSec == "appListAlarmeViper")
{
    $v_appData = new appDataList();
    $v_appViperList = $v_appData->appAlarmeViperList();
    $v_returnData["appViperList"] = $v_appViperList["rsData"];
    echo json_encode($v_returnData);
}
elseif($v_dataSec == "appListAlarmeObcon")
{
    $v_appData = new appDataList();
    $v_appObconList = $v_appData->appAlarmeObconList();
    $v_returnData["appObconList"] = $v_appObconList["rsData"];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListCustomer")
{
    $v_appCustomerData = new appDataList();
    $v_appCustomerList = $v_appCustomerData->appCustomerList();
    $v_returnData["appCustomerList"] = $v_appCustomerList["rsData"];
    echo json_encode($v_returnData);
}
/*VAS*/







/*PLENVS INICIO*/
elseif ($v_dataSec == "FirstAccessComplete")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;

    if($v_appData['sessID'] === 'Mauricio') {
        $v_sessID = '1';
    } else {
        $v_sessID = '0';
    }

    $v_userAccess =  new appUserControl();
    $v_UserAccessData = $v_userAccess->setInstanceFirstAccessSession($v_sessID);

    if($v_UserAccessData['updateStatus']) {
        $_SESSION['instanceFirstAccess'] = $v_sessID;
        $v_return['ok'] = true;
        echo json_encode($v_return);
    }
}
elseif ($v_dataSec == "WelcomeScreenAccess")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;

    if($v_appData['sessID'] === 'Mauricio') {
        $v_sessID = '1';
    } else {
        $v_sessID = '0';
    }
    $v_userAccess =  new appUserControl();
    $v_UserAccessData = $v_userAccess->setUserFirstAccessSession($v_sessID);

    if($v_UserAccessData['updateStatus']) {
        $_SESSION['userWelcomeScreen'] = $v_sessID;
        $v_return['ok'] = true;
        echo json_encode($v_return);
    }
}
elseif ($v_dataSec == "appUserInfo")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_userInfo =  new appUserData();
    $v_userInfoData = $v_userInfo->appUserInfo($v_appData);
    echo json_encode($v_userInfoData);
}
elseif ($v_dataSec == "appUserAddress")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_addressData = new appAddress();
    $v_appAddress = $v_addressData->appAddressData($v_appData);
    echo json_encode($v_appAddress);
}
elseif ($v_dataSec == "appUserPasswordReset")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_userPasswordReset =  new appUserData();
    $v_userPwd = $v_userPasswordReset->userPasswordReset($v_appData);
    echo json_encode($v_userPwd);
}
elseif ($v_dataSec == "appUserTempPassword")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_userTempPassword =  new appUserData();
    $v_userTempPwd = $v_userTempPassword->appUserTempPassword($v_appData);
    echo json_encode($v_userTempPwd);
}
elseif ($v_dataSec == "appUserChangePassword")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_userChangePassword =  new appUserControl();
    $v_userChangePwd = $v_userChangePassword->userChangePassword($v_appData);
    echo json_encode($v_userChangePwd);
}
elseif ($v_dataSec == "appUserSessionFirstAccess"){

    $v_appSessionData = new appUserData();
    $v_appSessionFirstAccess = $v_appSessionData->appUserSessionFirstAccess();
    if($v_appSessionFirstAccess['status']){
        $_SESSION['firstAccess'] = 0;
        echo json_encode(true);
    }else{
        echo json_encode(false);
    }

}
elseif ($v_dataSec == "appUserSocial")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_socialData = new appSocial();
    $v_appSocial = $v_socialData->appSocialData($v_appData);
    echo json_encode($v_appSocial);
}
elseif ($v_dataSec == "appUserPhoto")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appFile = !empty($_FILES) ? $_FILES : NULL;
    $v_photoUpload = new appPhoto();
    $v_photoData = $v_photoUpload->appUserPhotoData($v_appData,$v_appFile);

    if($v_appData['method']==='POST')
    {
        if(!is_null($v_photoData['photoID']) && $v_photoData['status'])
        {
            $v_dataArray['photoID'] = $v_photoData['photoID'];//enviar array
            $v_dataRelation['method'] = $v_appData['method'];
            $v_dataRelation['leftCol'] = 'product';
            $v_dataRelation['leftField'] = 'product_id';
            $v_dataRelation['leftValue'] = $v_appData['productID'];
            $v_dataRelation['rightCol'] = 'photo';
            $v_dataRelation['rightField'] = 'photo_id';
            $v_dataRelation['rightValue'] = $v_dataArray;
            $v_appRelation = new appRelationalData();
            $v_return['productPhotoData'] = $v_appRelation->setDataRelation($v_dataRelation);
            echo json_encode($v_return);
        }
        else
        {
            $v_return['productPhotoData'] = false;
            echo json_encode($v_return);
        }
    }
    else
    {
        echo json_encode($v_photoData);
    }

}
elseif ($v_dataSec == "appCustomerGroup")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_customerGroup =  new appCustomer();
    $v_customerGroupData = $v_customerGroup->appCustomerGroupData($v_appData,$v_type);
}
elseif ($v_dataSec == "appCustomer")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;

    if($v_appData['method']=='POST' || $v_appData['method']=='PUT')
    {
        //tratamento serialize
        $v_formData = array();
        parse_str($v_appData['formData'], $v_formData);

        foreach($v_formData as $key=>$valor)
        {
            $v_appData[$key] = $valor;
        }
        unset($v_appData['formData']);
        //add costumer
        $v_customer =  new appCustomer();
        $v_customerData = $v_customer->appCustomerData($v_appData);
        echo json_encode($v_customerData);
    }else
    {
        $v_customer =  new appCustomer();
        $v_customerData = $v_customer->appCustomerData($v_appData);
    }

}
elseif ($v_dataSec == "appProduct")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;

    if($v_appData['method']==='POST')
    {
        //tratamento serialize
        $v_formData = array();
        parse_str($v_appData['formData'], $v_formData);
        foreach($v_formData as $key=>$valor)
        {
            $v_appData[$key] = $valor;
        }
        unset($v_appData['formData']);
        $v_product =  new appProduct();
        $v_productData = $v_product->appProductData($v_appData);

        if($v_productData['apiData']['status'])
        {
            $v_product_id = $v_productData['apiData']['rsInsertID'];
            $v_return['status'] = true;
            $v_return['productID'] = $v_product_id;

            $v_basePriceInfo['productID'] = $v_product_id;
            $v_basePriceInfo['basePrice'] = $v_appData['productBasePriceClean'];
            $v_basePriceInfo['method'] = $v_appData['method'];

            $v_basePrice = new appPrice();
            $v_basePriceData = $v_basePrice->appBasePrice($v_basePriceInfo);
            $v_return['basePriceID'] = $v_basePriceData['basePriceID'];
            echo json_encode($v_return);

        }else
        {
            $v_return['status'] = false;
            $v_return['productID'] = false;
            echo json_encode($v_return);
        }

    }else
    {
        $v_product =  new appProduct();
        $v_productData = $v_product->appProductData($v_appData);
        echo json_encode($v_productData);
    }

}
elseif ($v_dataSec == "appProductPhoto")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appFile = !empty($_FILES) ? $_FILES : NULL;
    $v_photoUpload = new appPhoto();
    $v_photoData = $v_photoUpload->appPhotoData($v_appData,$v_appFile);

    if($v_appData['method']==='POST')
    {
        if(!is_null($v_photoData['photoID']) && $v_photoData['status'])
        {
            echo json_encode($v_photoData);
        }
        else
        {
            $v_return['status'] = false;
            echo json_encode($v_return);
        }
    }
    else
    {
        echo json_encode($v_photoData);
    }

}
elseif ($v_dataSec == "appProductFile")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appFile = !empty($_FILES) ? $_FILES : NULL;

    if($v_appData['method']==='POST')
    {
        $v_fileUpload = new appFile();
        $v_fileData = $v_fileUpload->appFileData($v_appData,$v_appFile);

        if(!is_null($v_fileData['fileID']) && $v_fileData['status'])
        {
            echo json_encode($v_fileData);
        }
        else
        {
            $v_fileData['status'] = false;
            echo json_encode($v_fileData);
        }
    }
    else
    {
        $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
        $v_appFile =  new appFile();
        $v_fileUpdate = $v_appFile->appFileData($v_appData);
        echo json_encode($v_fileUpdate);
    }
}
elseif ($v_dataSec == "appProductReference")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_referenceData = new appReference();
    $v_appReference = $v_referenceData->appReferenceData($v_appData);
    echo json_encode($v_appReference);
}
elseif ($v_dataSec == "appProductSpec")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_specData = new appSpec();
    $v_appSpec = $v_specData->appSpecData($v_appData);
    echo json_encode($v_appSpec);
}
elseif ($v_dataSec == "appCustomerFile")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appFile = !empty($_FILES) ? $_FILES : NULL;

    $v_fileUpload = new appFile();
    $v_fileData = $v_fileUpload->appFileData($v_appData,$v_appFile);

    if($v_appData['method']==='POST')
    {
        if(!is_null($v_fileData['fileID']) && $v_fileData['status'])
        {
            echo json_encode($v_fileData);
        }
        else
        {
            $v_return['status'] = false;
            echo json_encode($v_return);
        }
    }
    else
    {
        echo json_encode($v_fileData);
    }
}
elseif ($v_dataSec == "appCustomerGroupFile")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appFile = !empty($_FILES['appFormData']) ? $_FILES['appFormData'] : NULL;
    $v_fileUpload = new appFile();
    $v_fileData = $v_fileUpload->appFileData($v_appFile,$v_appData);

    if($v_fileData['fileUpload'] && $v_appData['method']==='POST')
    {
        if(!is_null($v_fileData['fileID']))
        {
            $v_dataArray['fileID'] = $v_fileData['fileID'];//enviar array
            $v_dataRelation['method'] = $v_appData['method'];
            $v_dataRelation['leftCol'] = 'customer_group';
            $v_dataRelation['leftField'] = 'customer_group_id';
            $v_dataRelation['leftValue'] = $v_appData['customerGroupID'];
            $v_dataRelation['rightCol'] = 'file';
            $v_dataRelation['rightField'] = 'file_id';
            $v_dataRelation['rightValue'] = $v_dataArray;
            $v_appRelation = new appRelationalData();
            $v_return['customerFileData'] = $v_appRelation->setDataRelation($v_dataRelation);
            echo json_encode($v_return);
        }
        else
        {
            $v_return['customerFileData'] = $v_fileData['fileUpload'];
        }
    }
    elseif($v_appData['method']!=='POST')
    {
        echo json_encode($v_fileData);
    }
}
elseif ($v_dataSec == "appCustomerMarket")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_updateType = !empty($_REQUEST['updateType']) ? $_REQUEST['updateType'] : '1';
    $v_method = !empty($v_appData['method']) ? $v_appData['method'] : 'POST';

    if(!isset($v_appData['marketID']))
    {
        $v_appData['marketID'] = $v_appData['customerData'];
    }

    if($v_method == "PUT" || !empty($_REQUEST['newMarket'])) {
        if ($v_updateType === "2") {
            $v_newData['method'] = "POST";
            $v_newData['marketDesc'] = $_REQUEST['newMarket'];
            $v_appLov = new appLov();
            $v_newMarket = $v_appLov->lovMarket($v_newData);
            $v_appData['marketID'] = $v_newMarket['apiData']['rsInsertID'];
        } elseif ($v_updateType === "1") {
            $v_appData['marketID'] = $v_appData['customerData'];
        }
    }

        $v_dataArray = array();
        $v_dataArray['marketID'] = $v_appData['marketID'];//enviar array
        $v_dataRelation['method'] = $v_appData['method'];
        $v_dataRelation['leftCol'] = 'customer';
        $v_dataRelation['leftField'] = 'customer_id';
        $v_dataRelation['leftValue'] = $v_appData['customerID'];
        $v_dataRelation['rightCol'] = 'market';
        $v_dataRelation['rightField'] = 'market_id';
        $v_dataRelation['rightValue'] = $v_dataArray;

        $v_appRelation = new appRelationalData();

    if($v_method == "POST")
    {

        $v_return['customerMarketData'] = $v_appRelation->setDataRelation($v_dataRelation);

        if ($v_updateType === "2") {
            $v_return['marketID'] = $v_appData['marketID'];
            $v_return['marketDesc'] = $_REQUEST['newMarket'];
        }

        $v_updateBatchID = new appSetNullBatchID();
        if(isset($v_appData['customerID'])){
            $v_updateBatchID->updateCustomerBatchID($v_appData['customerID']);
        }
    }
    elseif ($v_method == "DELETE")
    {
        $v_dataArray['marketID'] = $_REQUEST['marketID'];//enviar array
        $v_dataRelation['rightValue'] = $v_dataArray;
        $v_return['customerMarketData'] = $v_appRelation->setDataRelation($v_dataRelation);
    }
    echo json_encode($v_return);
}
elseif ($v_dataSec == "appCustomerGroupMarket")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;

    $v_dataRelation['method'] = $v_appData['method'];
    $v_dataRelation['leftCol'] = 'customer_group';
    $v_dataRelation['leftField'] = 'customer_group_id';
    $v_dataRelation['leftValue'] = $v_appData['customerGroupID'];
    $v_dataRelation['rightCol'] = 'market';
    $v_dataRelation['rightField'] = 'market_id';
    $v_dataRelation['rightValue'] = $v_appData['marketID'];
    $v_appRelation = new appRelationalData();
    $v_return['customerGroupMarketData'] = $v_appRelation->setDataRelation($v_dataRelation);
    echo json_encode($v_return);
}
elseif ($v_dataSec == "appContact")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;

    if($v_appData['method'] == 'POST') {
        //tratamento serialize
        $v_formData = array();
        if(!is_array($v_appData['formData'])) {
            parse_str($v_appData['formData'], $v_formData);
        } else {
            $v_formData = $v_appData['formData'];
        }
        foreach($v_formData as $key=>$valor)
        {
            $v_appData[$key] = $valor;
        }
        unset($v_appData['formData']);
        //var_dump($v_appData);die();
        //get cityID by customerID and send to $v_appData
        $v_appCustomer['customerID'] = $v_appData['customerID'];
        $v_appCustomer['method'] = 'GET';
        $v_customer = new appCustomer();
        $v_customerData = $v_customer->appCustomerData($v_appCustomer);
        //var_dump($v_customerData);die();
        $v_appData['countryID'] = $v_customerData['rsData']['0']['country_id'];

        $v_contact =  new appContact();
        $v_contactData = $v_contact->appContactData($v_appData);
        if($v_contactData['status'])
        {
            $v_contact_id = $v_contactData['rsInsertID'];
            $v_appData['contactID'] = $v_contact_id;

            //add position
            $v_dataArray = array();
            $v_dataArray['positionID'] = $v_appData['positionID'];//enviar array
            $v_dataRelation['method'] = $v_appData['method'];
            $v_dataRelation['leftCol'] = 'contact';
            $v_dataRelation['leftField'] = 'contact_id';
            $v_dataRelation['leftValue'] = $v_contact_id;
            $v_dataRelation['rightCol'] = 'position';
            $v_dataRelation['rightField'] = 'position_id';
            $v_dataRelation['rightValue'] = $v_dataArray;
            $v_appRelation = new appRelationalData();
            $v_relationPosition = $v_appRelation->setDataRelation($v_dataRelation);
            if($v_relationPosition){$v_return['relationPosition'] = true;}else{$v_return['relationPosition']= false;}

            //add contact_type
            $v_dataArray = array();
            $v_dataArray['contactTypeID'] = '1';//enviar array
            $v_dataRelation['method'] = $v_appData['method'];
            $v_dataRelation['leftCol'] = 'contact';
            $v_dataRelation['leftField'] = 'contact_id';
            $v_dataRelation['leftValue'] = $v_contact_id;
            $v_dataRelation['rightCol'] = 'contact_type';
            $v_dataRelation['rightField'] = 'contact_type_id';
            $v_dataRelation['rightValue'] = $v_dataArray;
            $v_appRelation = new appRelationalData();
            $v_relationContactType = $v_appRelation->setDataRelation($v_dataRelation);
            if($v_relationContactType){$v_return['relationContactType'] = true;}else{$v_return['relationContactType']= false;}

            //add department
            $v_dataArray = array();
            $v_dataArray['departmentID'] = $v_appData['departmentID'];//enviar array
            $v_dataRelation['method'] = $v_appData['method'];
            $v_dataRelation['leftCol'] = 'contact';
            $v_dataRelation['leftField'] = 'contact_id';
            $v_dataRelation['leftValue'] = $v_contact_id;
            $v_dataRelation['rightCol'] = 'department';
            $v_dataRelation['rightField'] = 'department_id';
            $v_dataRelation['rightValue'] = $v_dataArray;
            $v_appRelation = new appRelationalData();
            $v_relationDepartment = $v_appRelation->setDataRelation($v_dataRelation);
            if($v_relationDepartment){$v_return['relationDepartment'] = true;}else{$v_return['relationDepartment']= false;}

            //Add contactID to businessOpportunityID
            if(isset($v_appData['businessOpportunityID'])){
                $v_dataArrayContact = array();
                $v_dataArrayContact['contactID'] = $v_contact_id;//enviar array
                $v_dataRelationContact['method'] = $v_appData['method'];
                $v_dataRelationContact['leftCol'] = 'business_opportunity';
                $v_dataRelationContact['leftField'] = 'business_opportunity_id';
                $v_dataRelationContact['leftValue'] = $v_appData['businessOpportunityID'];
                $v_dataRelationContact['rightCol'] = 'contact';
                $v_dataRelationContact['rightField'] = 'contact_id';
                $v_dataRelationContact['rightValue'] = $v_dataArrayContact;
                $v_appRelation = new appRelationalData();
                $v_appRelation->setDataRelation($v_dataRelationContact);
                $v_contactToBusinessOpportunity = true;
            }else{
                $v_contactToBusinessOpportunity = false;
            }

            $v_return['status'] = true;
            $v_return['contactID'] = $v_contact_id;
            $v_return['contactToBusinessOpportunity'] = $v_contactToBusinessOpportunity;
            echo json_encode($v_return);

        } else {
            $v_return['status'] = false;
            $v_return['contactID'] = false;
            echo json_encode($v_return);
        }
    }
    else {
        $v_contactData =  new appContact();
        $v_appContact = $v_contactData->appContactData($v_appData);
        echo json_encode($v_appContact);
    }
}
elseif ($v_dataSec == "appContactPhoto")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appFile = !empty($_FILES) ? $_FILES : NULL;
    $v_photoData = new appPhoto();
    $v_appPhoto = $v_photoData->appPhotoData($v_appFile,$v_appData);

    if($v_appPhoto['fileUpload'] && $v_appData['method']==='POST')
    {
        echo json_encode($v_appPhoto);
    }
    elseif(($v_appData['method']!=='POST' && $v_appPhoto['apiData']['rsTotal'] > 0) || $v_appData['method']==='DELETE')
    {
        echo json_encode($v_appPhoto);
    }
}
elseif ($v_dataSec == "appContactAddress")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_addressData = new appAddress();
    $v_appAddress = $v_addressData->appAddressData($v_appData);
    echo json_encode($v_appAddress);
}
elseif ($v_dataSec == "appContactType")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;

    $v_dataRelation['method'] = $v_appData['method'];
    $v_dataRelation['leftCol'] = 'contact';
    $v_dataRelation['leftField'] = 'contact_id';
    $v_dataRelation['leftValue'] = $v_appData['contactID'];
    $v_dataRelation['rightCol'] = 'contact_type';
    $v_dataRelation['rightField'] = 'contact_type_id';
    $v_dataRelation['rightValue'] = $v_appData['contactTypeID'];
    $v_appDocRelation = new appRelationalData();
    $v_return['contactTypeData'] = $v_appDocRelation->setDataRelation($v_dataRelation);
    echo json_encode($v_return);
}
elseif ($v_dataSec == "appCustomerDepartment")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;

    $v_dataRelation['method'] = $v_appData['method'];
    $v_dataRelation['leftCol'] = 'customer';
    $v_dataRelation['leftField'] = 'customer_id';
    $v_dataRelation['leftValue'] = $v_appData['customerID'];
    $v_dataRelation['rightCol'] = 'department';
    $v_dataRelation['rightField'] = 'department_id';
    $v_dataRelation['rightValue'] = $v_appData['departmentID'];
    $v_appRelation = new appRelationalData();
    $v_return['customerDepartmentData'] = $v_appRelation->setDataRelation($v_dataRelation);
    echo json_encode($v_return);
}
elseif ($v_dataSec == "appContactPhone")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_phoneData = new appPhone();
    $v_appPhone = $v_phoneData->appPhoneData($v_appData);
    echo json_encode($v_appPhone);
}
elseif ($v_dataSec == "appContactFile")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appFile = !empty($_FILES) ? $_FILES : NULL;

    $v_fileUpload = new appFile();
    $v_fileData = $v_fileUpload->appFileData($v_appData,$v_appFile);

    if($v_appData['method']==='POST')
    {
        if(!is_null($v_fileData['fileID']) && $v_fileData['status'])
        {
            echo json_encode($v_fileData);
        }
        else
        {
            $v_return['status'] = false;
            echo json_encode($v_return);
        }
    }
    else
    {
        echo json_encode($v_fileData);
    }
}
elseif ($v_dataSec == "appCustomerPhone")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_phoneData = new appPhone();
    $v_appPhone = $v_phoneData->appPhoneData($v_appData);
    echo json_encode($v_appPhone);
}
elseif ($v_dataSec == "appCustomerAddress")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;

    $v_addressData = new appAddress();
    $v_appAddress = $v_addressData->appAddressData($v_appData);
    echo json_encode($v_appAddress);
}
elseif ($v_dataSec == "appAddressMarker")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_addressData = new appAddress();
    $v_appAddress = $v_addressData->appAddressData($v_appData);
    echo json_encode($v_appAddress);
}
elseif ($v_dataSec == "appCustomerEmail")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_emailData = new appEmail();
    $v_appEmail = $v_emailData->appEmailData($v_appData);
    echo json_encode($v_appEmail);
}
elseif ($v_dataSec == "appCustomerWebsite")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_customerWebsiteData = new appWebsite();
    $v_appCustomerWebsite = $v_customerWebsiteData->appWebsiteData($v_appData);
    echo json_encode($v_appCustomerWebsite);
}
elseif ($v_dataSec == "appContactEmail")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_emailData = new appEmail();
    $v_appEmail = $v_emailData->appEmailData($v_appData);
    echo json_encode($v_appEmail);
}
elseif ($v_dataSec == "appContactDepartment")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;

    $v_dataRelation['method'] = $v_appData['method'];
    $v_dataRelation['leftCol'] = 'contact';
    $v_dataRelation['leftField'] = 'contact_id';
    $v_dataRelation['leftValue'] = $v_appData['contactID'];
    $v_dataRelation['rightCol'] = 'department';
    $v_dataRelation['rightField'] = 'department_id';
    $v_dataRelation['rightValue'] = $v_appData['departmentID'];
    $v_appRelation = new appRelationalData();
    $v_return['contactDepartmentData'] = $v_appRelation->setDataRelation($v_dataRelation);
    echo json_encode($v_return);
}
elseif ($v_dataSec == "appContactPosition")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;

    $v_dataRelation['method'] = $v_appData['method'];
    $v_dataRelation['leftCol'] = 'contact';
    $v_dataRelation['leftField'] = 'contact_id';
    $v_dataRelation['leftValue'] = $v_appData['contactID'];
    $v_dataRelation['rightCol'] = 'position';
    $v_dataRelation['rightField'] = 'position_id';
    $v_dataRelation['rightValue'] = $v_appData['positionID'];
    $v_appRelation = new appRelationalData();
    $v_return['customerPositiontData'] = $v_appRelation->setDataRelation($v_dataRelation);
    echo json_encode($v_return);
}
elseif ($v_dataSec == "appContactSocial")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_socialData = new appSocial();
    $v_appSocial = $v_socialData->appSocialData($v_appData);
    echo json_encode($v_appSocial);
}
elseif ($v_dataSec == "appOpportunity")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;

    if($v_appData['method']==='POST')
    {
        //tratamento serialize
        $v_formData = array();
        parse_str($v_appData['formData'], $v_formData);
        foreach($v_formData as $key=>$valor)
        {
            $v_appData[$key] = $valor;
        }
        unset($v_appData['formData']);
        $v_opportunity =  new appOpportunity();
        $appOpportunityData = $v_opportunity->appOpportunityData($v_appData);
        if($appOpportunityData['apiData']['status'])
        {
            $v_opportunity_id = $appOpportunityData['apiData']['rsInsertID'];
            $v_return['status'] = true;
            $v_return['opportunityID'] = $v_opportunity_id;
            $v_return['opportunitySequence'] = $appOpportunityData['apiData']['opportunitySequence'];
            echo json_encode($v_return);
        }else
        {
            $v_return['status'] = false;
            $v_return['opportunityID'] = false;
            $v_return['opportunitySequence'] = false;
            echo json_encode($v_return);
        }
    }else
    {
        $v_appOpportunityData =  new appOpportunity();
        $v_appOpportunity = $v_appOpportunityData->appOpportunityData($v_appData);
        echo json_encode($v_appOpportunity);
    }

}
elseif ($v_dataSec == "appBusiness")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;

    if($v_appData['method']==='POST')
    {
        //tratamento serialize
        $v_formData = array();
        parse_str($v_appData['formData'], $v_formData);
        foreach($v_formData as $key=>$valor)
        {
            $v_appData[$key] = $valor;
        }
        unset($v_appData['formData']);
        $v_business =  new appBusiness();
        $appBusinessData = $v_business->appBusinessData($v_appData);
        if($appBusinessData['apiData']['status'])
        {
            $v_business_id = $appBusinessData['apiData']['rsInsertID'];
            $v_return['status'] = true;
            $v_return['businessID'] = $v_business_id;
            $v_return['businessSequence'] = $appBusinessData['apiData']['businessSequence'];
            echo json_encode($v_return);
        }else
        {
            $v_return['status'] = false;
            $v_return['businessID'] = false;
            $v_return['businessSequence'] = false;
            echo json_encode($v_return);
        }
    }else
    {
        $v_appBusinessData =  new appBusiness();
        $v_appBusiness = $v_appBusinessData->appBusinessData($v_appData);
        echo json_encode($v_appBusiness);
    }

}
elseif ($v_dataSec == "appOpportunityContact")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;

    $v_dataArray['contactID'] = $v_appData['contactID'];//enviar array
    $v_dataRelation['method'] = $v_appData['method'];
    $v_dataRelation['leftCol'] = 'opportunity';
    $v_dataRelation['leftField'] = 'opportunity_id';
    $v_dataRelation['leftValue'] = $v_appData['opportunityID'];
    $v_dataRelation['rightCol'] = 'contact';
    $v_dataRelation['rightField'] = 'contact_id';
    $v_dataRelation['rightValue'] = $v_dataArray;
    $v_appRelation = new appRelationalData();
    $v_return = $v_appRelation->setDataRelation($v_dataRelation);

    $v_updateBatchID = new appSetNullBatchID();
    if(isset($v_appData['contactID'])){
        $v_updateBatchID->updateContactBatchID($v_appData['contactID']);
    }

    echo json_encode($v_return);
}
elseif ($v_dataSec == "appBusinessContact")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;

    $v_dataArray['contactID'] = $v_appData['contactID'];//enviar array
    $v_dataRelation['method'] = $v_appData['method'];
    $v_dataRelation['leftCol'] = 'business';
    $v_dataRelation['leftField'] = 'business_id';
    $v_dataRelation['leftValue'] = $v_appData['businessID'];
    $v_dataRelation['rightCol'] = 'contact';
    $v_dataRelation['rightField'] = 'contact_id';
    $v_dataRelation['rightValue'] = $v_dataArray;
    $v_appRelation = new appRelationalData();
    $v_return = $v_appRelation->setDataRelation($v_dataRelation);

    $v_updateBatchID = new appSetNullBatchID();
    if(isset($v_appData['contactID'])){
        $v_updateBatchID->updateContactBatchID($v_appData['contactID']);
    }

    echo json_encode($v_return);
}
elseif ($v_dataSec == "appBusinessOpportunityContact")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;

    $v_dataArray['contactID'] = $v_appData['contactID'];//enviar array
    $v_dataRelation['method'] = $v_appData['method'];
    $v_dataRelation['leftCol'] = 'business_opportunity';
    $v_dataRelation['leftField'] = 'business_opportunity_id';
    $v_dataRelation['leftValue'] = $v_appData['businessOpportunityID'];
    $v_dataRelation['rightCol'] = 'contact';
    $v_dataRelation['rightField'] = 'contact_id';
    $v_dataRelation['rightValue'] = $v_dataArray;
    $v_appRelation = new appRelationalData();
    $v_return = $v_appRelation->setDataRelation($v_dataRelation);

    $v_updateBatchID = new appSetNullBatchID();
    if(isset($v_appData['contactID'])){
        $v_updateBatchID->updateContactBatchID($v_appData['contactID']);
    }

    echo json_encode($v_return);
}
elseif ($v_dataSec == "appOpportunityFile")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appFile = !empty($_FILES) ? $_FILES : NULL;

    $v_fileUpload = new appFile();
    $v_fileData = $v_fileUpload->appFileData($v_appData,$v_appFile);

    if($v_appData['method']==='POST')
    {
        if(!is_null($v_fileData['fileID']) && $v_fileData['status'])
        {
            echo json_encode($v_fileData);
        }
        else
        {
            $v_return['status'] = false;
            echo json_encode($v_return);
        }
    }
    else
    {
        echo json_encode($v_fileData);
    }
}
elseif ($v_dataSec == "appBusinessFile")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appFile = !empty($_FILES) ? $_FILES : NULL;

    $v_fileUpload = new appFile();
    $v_fileData = $v_fileUpload->appFileData($v_appData,$v_appFile);

    if($v_appData['method']==='POST')
    {
        if(!is_null($v_fileData['fileID']) && $v_fileData['status'])
        {
            echo json_encode($v_fileData);
        }
        else
        {
            $v_return['status'] = false;
            echo json_encode($v_return);
        }
    }
    else
    {
        echo json_encode($v_fileData);
    }
}
elseif ($v_dataSec == "appEstimateFile")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appFile = !empty($_FILES) ? $_FILES : NULL;
    $v_fileUpload = new appFile();

    $v_fileData = $v_fileUpload->appEstimateFileData($v_appData,$v_appFile);
    if($v_appData['method']==='POST')
    {
        if(!is_null($v_fileData['fileID']) && $v_fileData['status'])
        {
            echo json_encode($v_fileData);
        }
        else
        {
            $v_return['status'] = false;
            echo json_encode($v_return);
        }
    }
    else
    {
        echo json_encode($v_fileData);
    }
}
elseif ($v_dataSec == "appEstimate"){
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_estimate = new appFile();
    $v_estimateData = $v_estimate->appEstimateData($v_appData);
    echo json_encode($v_estimateData);
}
elseif ($v_dataSec == "appEstimateSetMain")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_fileUpload = new appFile();
    $v_fileData = $v_fileUpload->appEstimateFileData($v_appData);

    if($v_appData['method']==='POST')
    {
        if(!is_null($v_fileData['fileID']) && $v_fileData['status'])
        {
            echo json_encode($v_fileData);
        }
        else
        {
            $v_return['status'] = false;
            echo json_encode($v_return);
        }
    }
    else
    {
        echo json_encode($v_fileData);
    }
}
elseif ($v_dataSec == "appOpportunityFollowUp")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_followUpData = new appFollowUp();
    $v_appFollowUp = $v_followUpData->appOpportunityFollowUpData($v_appData);
    echo json_encode($v_appFollowUp);
}
elseif ($v_dataSec == "appBusinessFollowUp")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_followUpData = new appFollowUp();
    $v_appFollowUp = $v_followUpData->appBusinessFollowUpData($v_appData);
    echo json_encode($v_appFollowUp);
}
elseif ($v_dataSec == "appExpenseNotes")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_expenseData = new appExpense();
    $v_appExpenseNotes = $v_expenseData->appExpenseNotes($v_appData);
    echo json_encode($v_appExpenseNotes);
}
elseif ($v_dataSec == "appOpportunityQuoteItem")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_quotedPrice = new appPrice();
    $v_quotedPriceData = $v_quotedPrice->appQuotedPrice($v_appData);

    $v_return['quotedPriceData'] = $v_quotedPriceData;
    echo json_encode($v_return);
}
elseif ($v_dataSec == "appBusinessQuoteItem")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_quotedPrice = new appPrice();
    $v_quotedPriceData = $v_quotedPrice->appQuotedPrice($v_appData);

    $v_return['quotedPriceData'] = $v_quotedPriceData;
    echo json_encode($v_return);
}
elseif ($v_dataSec == "appOpportunitySoldItem")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_soldPrice = new appPrice();
    $v_soldPriceData = $v_soldPrice->appSoldPrice($v_appData);

    $v_return['soldPriceData'] = $v_soldPriceData;
    echo json_encode($v_return);
}
elseif ($v_dataSec == "appBusinessSoldItem")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_soldPrice = new appPrice();
    $v_soldPriceData = $v_soldPrice->appSoldPrice($v_appData);

    $v_return['soldPriceData'] = $v_soldPriceData;
    echo json_encode($v_return);
}
elseif ($v_dataSec == "appOpportunitySoldUnits")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_soldPrice = new appPrice();
    $v_soldPriceData = $v_soldPrice->appSoldPrice($v_appData);

    $v_return['soldPriceData'] = $v_soldPriceData;
    echo json_encode($v_return);
}
elseif ($v_dataSec == "appBusinessSoldUnits")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_soldPrice = new appPrice();
    $v_soldPriceData = $v_soldPrice->appSoldPrice($v_appData);

    $v_return['soldPriceData'] = $v_soldPriceData;
    echo json_encode($v_return);
}
elseif ($v_dataSec == "appOpportunitySaleItem")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_saleItemData = new appSaleItem();
    $v_appSaleItem = $v_saleItemData->appSaleItemData($v_appData);
    if($v_appData['method']==='POST')
    {

        if($v_appSaleItem['status']) {
            $v_dataArray['itemID'] = $v_appSaleItem['itemID'];//enviar array
            $v_dataRelation['method'] = $v_appData['method'];
            $v_dataRelation['leftCol'] = 'opportunity';
            $v_dataRelation['leftField'] = 'opportunity_id';
            $v_dataRelation['leftValue'] = $v_appData['opportunityID'];
            $v_dataRelation['rightCol'] = 'sale_item';
            $v_dataRelation['rightField'] = 'item_id';
            $v_dataRelation['rightValue'] = $v_dataArray;

            //print_r($v_dataRelation);
            //die();

            $v_appRelation = new appRelationalData();
            $v_return['opportunitySaleItemData'] = $v_appRelation->setDataRelation($v_dataRelation);

            $v_appData['itemID'] = $v_appSaleItem['itemID'];

            $v_directSale = !empty($v_appData['directSale']) ? $v_appData['directSale'] : false;
            if(!$v_directSale)
            {
                $v_quotedPrice = new appPrice();
                $v_quotedPriceData = $v_quotedPrice->appQuotedPrice($v_appData);
                $v_return['quotedPriceData'] = $v_quotedPriceData['quotedPriceID'];
            }

            echo json_encode($v_return);
        }
    }
}
elseif ($v_dataSec == "appBusinessOpportunityEstimateItem")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_businessOpportunityEstimateItemData = new appBusinessOpportunityItem();
    $v_appBusinessOpportunityEstimateItem = $v_businessOpportunityEstimateItemData->appBusinessOpportunityEstimateItemData($v_appData);
}
elseif ($v_dataSec == "appBusinessOpportunityItem")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_businessOpportunityItemData = new appBusinessOpportunityItem();
    $v_appBusinessOpportunityItem = $v_businessOpportunityItemData->appBusinessOpportunityItemData($v_appData);

    /*
    if($v_appData['method']==='POST')
    {

        if($v_appSaleItem['status']) {
            $v_dataArray['itemID'] = $v_appSaleItem['itemID'];//enviar array
            $v_dataRelation['method'] = $v_appData['method'];
            $v_dataRelation['leftCol'] = 'business';
            $v_dataRelation['leftField'] = 'business_id';
            $v_dataRelation['leftValue'] = $v_appData['businessID'];
            $v_dataRelation['rightCol'] = 'sale_item';
            $v_dataRelation['rightField'] = 'item_id';
            $v_dataRelation['rightValue'] = $v_dataArray;

            //print_r($v_dataRelation);
            //die();

            $v_appRelation = new appRelationalData();
            $v_return['businessSaleItemData'] = $v_appRelation->setDataRelation($v_dataRelation);

            $v_appData['itemID'] = $v_appSaleItem['itemID'];

            $v_directSale = !empty($v_appData['directSale']) ? $v_appData['directSale'] : false;
            if(!$v_directSale)
            {
                $v_quotedPrice = new appPrice();
                $v_quotedPriceData = $v_quotedPrice->appQuotedPrice($v_appData);
                $v_return['quotedPriceData'] = $v_quotedPriceData['quotedPriceID'];
            }

            echo json_encode($v_return);
        }
    }
    */
}
elseif ($v_dataSec == "appBusinessOpportunity")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_businessOpportunity = new appBusiness();
    $v_appBusinessOpportunity = $v_businessOpportunity->appBusinessOpportunity($v_appData);
    echo json_encode($v_appBusinessOpportunity);
}
elseif ($v_dataSec == "appBusinessValues")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_business = new appBusiness();
    $v_appBusiness = $v_business->appBusinessValues($v_appData);
    echo json_encode($v_appBusiness);
}
elseif ($v_dataSec == "appBusinessOpportunityValues")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_businessOpportunity = new appBusiness();
    $v_appBusinessOpportunity = $v_businessOpportunity->appBusinessOpportunityValues($v_appData);
    echo json_encode($v_appBusinessOpportunity);
}
elseif ($v_dataSec == "appOpportunityOwner")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_opportunity =  new appOpportunity();
    $appOpportunityData = $v_opportunity->appOpportunityData($v_appData);
    echo json_encode($appOpportunityData);
}
elseif ($v_dataSec == "appBusinessOwner")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_business =  new appBusiness();
    $appBusinessData = $v_business->appBusinessData($v_appData);
    echo json_encode($appBusinessData);
}
elseif ($v_dataSec == "appBusinessOpportunityData")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_businessOpportunity =  new appBusiness();
    $appBusinessOpportunityData = $v_businessOpportunity->appBusinessOpportunityData($v_appData);
    echo json_encode($appBusinessOpportunityData);
}
elseif ($v_dataSec == "appBusinessOpportunityOwner")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_businessOpportunity =  new appBusiness();
    $appBusinessOpportunityData = $v_businessOpportunity->appBusinessOpportunityData($v_appData);
    echo json_encode($appBusinessOpportunityData);
}
elseif ($v_dataSec == "appCustomerSocial")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_socialData = new appSocial();
    $v_appSocial = $v_socialData->appSocialData($v_appData);
    echo json_encode($v_appSocial);
}
elseif ($v_dataSec == "appCustomerContact")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_contact = new appContact();
    $v_contactData = $v_contact->appContactData($v_appData);
    echo json_encode($v_contactData);
}
elseif ($v_dataSec == "appTimeline")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appTimelineData =  new appTimeline();
    $v_appTimelineList = $v_appTimelineData->appTimelineData($v_appData);
}
elseif ($v_dataSec == "appUserInvitation")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appUserInvitationData =  new appUserData();
    $v_appUserInvitation = $v_appUserInvitationData->appNewUserInvitation($v_appData);
}
elseif ($v_dataSec == "appUserRegistration")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appUserTokenData =  new appUserData();
    $v_appUserTokenCheck = $v_appUserTokenData->appNewUserTokenData($_REQUEST['userInvite']);

    if($v_appUserTokenCheck['rsStatus'])
    {
        $v_formData = $_REQUEST['appFormData'];
        parse_str($_REQUEST['appFormData'],$v_userData);
        $v_userPwd = $v_userData['regUserPwd'];
        $v_userPwdConfirm = $v_userData['regUserPwdConfirm'];
        $v_pwdCheckData = new appSystemTools();
        $v_pwdCheckData->pwdCheckData = $v_userPwd;
        $v_pwdCheckData->pwdGenerator(8, false, 'luds', true);
        $v_checkPwdStrengh = $v_pwdCheckData->pwdCheck;

        if($v_checkPwdStrengh && ($v_userPwd === $v_userPwdConfirm))
        {
            $v_userTokenData = $v_appUserTokenCheck['rsData'][0];
            $v_userAccessData['userPwd'] = hash('sha256', $v_userPwd);
            $v_userAccessData['userClnt'] = $v_userInfoData['userClnt'] = $v_userProfileData['clnt'] = $v_userTokenData['clnt'];
            $v_userAccessData['userId'] = $v_userInfoData['userId'] = $v_tokenData['userId'] = $v_userProfileData['userID'] = $v_userTokenData['user_id'];

            $v_userInfoData['userName'] = $v_userData['regFullName'];
            $v_userInfoData['userNickname'] = $v_userData['regNickname'];
            $v_userInfoData['userBirthday'] = $v_userData['regUserBirthday'];
            $v_userInfoData['userGenderID'] = $v_userData['regUserGender'];
            $v_userInfoData['userCountryID'] = $v_userData['regUserCountry'];
            $v_userInfoData['userPhone'] = $v_userData['regMobileNumber'];

            $v_tokenData['tokenData'] = $_REQUEST['userInvite'];

            $v_userProfileData['method'] = 'POST';
            $v_userProfileData['profileID'] = $v_userTokenData['user_profile_id'];


            $v_newUserData = new appUserData();
            $v_newUserAccessCheck = $v_newUserData->appNewUserAccessUpdate($v_userAccessData);
            $v_newUserInfoCheck = $v_newUserData->appNewUserInfoUpdate($v_userInfoData);
            $v_newUserProfileCheck = $v_newUserData->appNewUserProfile($v_userProfileData);

            if($v_newUserAccessCheck['updateStatus'] && $v_newUserInfoCheck['updateStatus'])
            {
                $v_userTokenUpdate = $v_newUserData->appNewUserInvitationUsed($v_tokenData);
                $v_return['newUserChk'] = true;
                $v_return['newUserMsg'] = "User registered successfully!";
                $v_return['inviteStatus'] = true;
            }
            else{
                $v_return['newUserChk'] = false;
                $v_return['newUserMsg'] = "Something went wrong. Contact your administrator.";
                $v_return['inviteStatus'] = true;
            }
        }
    }
    else
    {
        $v_return['newUserChk'] = false;
        $v_return['newUserMsg'] = "User invitation not available!";
        $v_return['inviteStatus'] = false;
    }
    echo json_encode($v_return);
}
elseif ($v_dataSec == "appGeoCustomerHasAddress")
{
    $v_type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_geoData = new appGeoData();
    $v_appCustomerHasAddress = $v_geoData->geoCustomerHasAddress($v_type);
}

/* API Lists */
elseif ($v_dataSec == "appListCustomerGroup")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appCustomerGroup = new appDataList();
    $v_customerGroupList = $v_appCustomerGroup->appCustomerGroupList($v_appData);

}
elseif ($v_dataSec == "appListProductPhoto")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appProductPhotoData =  new appDataList();
    $v_appProductPhotoList = $v_appProductPhotoData->appProductPhotoList($v_appData);
    $v_returnData['appProductPhotoList'] = $v_appProductPhotoList['rsData'];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListContactPhoto")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_contactPhoto =  new appDataList();
    $v_appContactPhotoList = $v_contactPhoto->appContactPhotoList($v_appData);
}
elseif ($v_dataSec == "appListProduct")
{
    $v_manufacturerID = !empty($_REQUEST['manufacturerID']) ? $_REQUEST['manufacturerID'] : NULL;
    $v_alwaysDisplay = !empty($_REQUEST['alwaysDisplay']) ? $_REQUEST['alwaysDisplay'] : NULL;
    $v_appData = NULL;

    if(!is_null($v_manufacturerID) && !is_null($v_alwaysDisplay)) {
        $v_appData = $v_manufacturerID.','.$v_alwaysDisplay;
    }elseif(!is_null($v_manufacturerID) && is_null($v_alwaysDisplay)) {
        $v_appData = $v_manufacturerID;
    }
    $v_appProductData = new appDataList();
    $v_appProductList = $v_appProductData->appProductList($v_appData);
    $v_returnData["appProductList"] = $v_appProductList["rsData"];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListProductSpec")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_specData = new appDataList();
    $v_appProductSpec = $v_specData->appProductSpecList($v_appData);
}
elseif ($v_dataSec == "appListProductReference") {
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_productReferenceData = new appDataList();
    $v_appProductReference = $v_productReferenceData->appProductReferenceList($v_appData);
}
elseif ($v_dataSec == "appListProductFile")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appProductFileData =  new appDataList();
    $v_appProductFileList = $v_appProductFileData->appProductFileList($v_appData);
    $v_returnData['appProductFileList'] = $v_appProductFileList['rsData'];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListCustomerFile")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appCustomerFileData =  new appDataList();
    $v_appCustomerFileList = $v_appCustomerFileData->appCustomerFileList($v_appData);
    $v_returnData['appCustomerFileList'] = $v_appCustomerFileList['rsData'];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListCustomerGroupFile") {
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_productData = new appDataList();
    $v_appProductList = $v_productData->appCustomerGroupFileList($v_appData);
}
elseif ($v_dataSec == "appListCustomerMarket") {
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_customerMarketData = new appDataList();
    $v_appCustomerMarketList = $v_customerMarketData->appCustomerMarketList($v_appData);
}
elseif ($v_dataSec == "appListCustomerGroupMarket") {
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_customerGroupMarketData = new appDataList();
    $v_appCustomerGroupMarketList = $v_customerGroupMarketData->appCustomerGroupMarketList($v_appData);
}
elseif ($v_dataSec == "appListContact")
{
    $v_customerID = !empty($_REQUEST['customerID']) ? $_REQUEST['customerID'] : NULL;
    $v_appData = new appDataList();
    $v_appContactList = $v_appData->appContactList($v_customerID);
    $v_returnData["appContactList"] = $v_appContactList["rsData"];
    echo json_encode($v_returnData);

}
elseif ($v_dataSec == "appListContactFile")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appContactFileData =  new appDataList();
    $v_appContactFileList = $v_appContactFileData->appContactFileList($v_appData);
    $v_returnData['appContactFileList'] = $v_appContactFileList['rsData'];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListContactAddress")
{
    $v_appData =  new appDataList();
    $v_appContactAddressList = $v_appData->appContactAddressList();
}
elseif ($v_dataSec == "appListCustomerPhone")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appCustomerPhoneData =  new appDataList();
    $v_appCustomerPhoneList = $v_appCustomerPhoneData->appCustomerPhoneList($v_appData);
}
elseif ($v_dataSec == "appListOpportunity")
{
    $v_appData = new appDataList();
    $v_appOpportunityList = $v_appData->appOpportunityList();
    $v_returnData["appOpportunityList"] = $v_appOpportunityList["rsData"];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListBusiness")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appDataList = new appDataList();
    $v_appBusinessList = $v_appDataList->appBusinessList($v_appData);
    $v_returnData["appBusinessList"] = $v_appBusinessList["rsData"];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListSocial")
{
    $v_appData =  new appDataList();
    $v_appOpportunityList = $v_appData->appSocialList();
}
elseif ($v_dataSec == "appListOpportunityFollowUp")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appOpportunityFollowUpData =  new appDataList();
    $v_appOpportunityFollowUpList = $v_appOpportunityFollowUpData->appOpportunityFollowUpList($v_appData);
}
elseif ($v_dataSec == "appListBusinessFollowUp")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appBusinessFollowUpData =  new appDataList();
    $v_appBusinessFollowUpList = $v_appBusinessFollowUpData->appBusinessFollowUpList($v_appData);
}
elseif ($v_dataSec == "appListOpportunitySaleItem")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appOpportunitySaleItemData =  new appDataList();
    $v_appOpportunitySaleItem = $v_appOpportunitySaleItemData->appOpportunitySaleItemList($v_appData);
    $v_returnData["appOpportunitySaleItem"] = $v_appOpportunitySaleItem["rsData"];
    echo json_encode($v_returnData);
}
//
elseif ($v_dataSec == "appListBusinessOpportunityItem")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appBusinessOpportunityItemData =  new appDataList();
    $v_appBusinessOpportunityItem = $v_appBusinessOpportunityItemData->appBusinessOpportunityItemList($v_appData);
    $v_returnData["appBusinessOpportunityItem"] = $v_appBusinessOpportunityItem["rsData"];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListOpportunityContact")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appOpportunityContactData =  new appDataList();
    $v_appOpportunityContact = $v_appOpportunityContactData->appOpportunityContactList($v_appData);
}
elseif ($v_dataSec == "appListBusinessContact")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appBusinessContactData =  new appDataList();
    $v_appBusinessContact = $v_appBusinessContactData->appBusinessContactList($v_appData);
}
elseif ($v_dataSec == "appListBusinessOpportunityContact")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appBusinessOpportunityContactData =  new appDataList();
    $v_appBusinessOpportunityContact = $v_appBusinessOpportunityContactData->appBusinessOpportunityContactList($v_appData);
}
elseif ($v_dataSec == "appListOpportunityFile")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appOpportunityFileData =  new appDataList();
    $v_appOpportunityFileList = $v_appOpportunityFileData->appOpportunityFileList($v_appData);
    $v_returnData['appOpportunityFileList'] = $v_appOpportunityFileList['rsData'];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListBusinessOpportunityFile")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appBusinessOpportunityFileData =  new appDataList();
    $v_appBusinessOpportunityFileList = $v_appBusinessOpportunityFileData->appBusinessOpportunityFileList($v_appData);
    $v_returnData['appBusinessOpportunityFileList'] = $v_appBusinessOpportunityFileList['rsData'];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListBusinessFile")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appBusinessFileData =  new appDataList();
    $v_appBusinessFileList = $v_appBusinessFileData->appBusinessFileList($v_appData);
    $v_returnData['appBusinessFileList'] = $v_appBusinessFileList['rsData'];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListEstimateFile")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appEstimateFileData =  new appDataList();
    $v_appEstimateFileList = $v_appEstimateFileData->appEstimateFileList($v_appData);
    $v_returnData['appEstimateFileList'] = $v_appEstimateFileList['rsData'];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListCustomerWebsite")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appCustomerWebsiteData =  new appDataList();
    $v_appCustomerWebsite = $v_appCustomerWebsiteData->appCustomerWebsiteList($v_appData);
}
elseif ($v_dataSec == "appListOpportunityQuoteItem")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appOpportunityQuoteItemData =  new appDataList();
    $v_appOpportunityQuoteItem = $v_appOpportunityQuoteItemData->appOpportunityQuoteItemList($v_appData);
    $v_returnData["appOpportunityQuoteItem"] = $v_appOpportunityQuoteItem["rsData"];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListBusinessQuoteItem")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appBusinessQuoteItemData =  new appDataList();
    $v_appBusinessQuoteItem = $v_appBusinessQuoteItemData->appBusinessQuoteItemList($v_appData);
    $v_returnData["appBusinessQuoteItem"] = $v_appBusinessQuoteItem["rsData"];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListBusinessOpportunity")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appBusinessOpportunityData =  new appDataList();
    $v_appBusinessOpportunityList = $v_appBusinessOpportunityData->appBusinessOpportunityList($v_appData);
    $v_returnData["appBusinessOpportunityList"] = $v_appBusinessOpportunityList["rsData"];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListOpportunityStage")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appOpportunityStageData =  new appDataList();
    $v_appOpportunityStageList = $v_appOpportunityStageData->appOpportunityStageList($v_appData);
    $v_returnData["appOpportunityStageList"] = $v_appOpportunityStageList["rsData"];
    echo json_encode($v_returnData);
}

elseif ($v_dataSec == "appListLov")
{
    $v_lovID = !empty($_REQUEST['lovID']) ? $_REQUEST['lovID'] : NULL;
    $v_appData = new appDataList();
    $v_appLovList = $v_appData->appLovList($v_lovID);
    $v_returnData["appLovList"] = $v_appLovList["rsData"];
    echo json_encode($v_returnData);
}

/* API Combos */
elseif ($v_dataSec == "appComboManufacturer")
{
    $v_appData['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appData['alwaysDisplay'] = !empty($_REQUEST['displayAways']) ? $_REQUEST['displayAways'] : 0;
    $v_appCombo =  new appCombo();
    $v_appManufacturer = $v_appCombo->comboManufacturer($v_appData['type'],$v_appData['alwaysDisplay']);
}
elseif ($v_dataSec == "appComboProductType")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appCombo =  new appCombo();
    $v_appManufacturer = $v_appCombo->comboProductType($v_appData);
}
elseif ($v_dataSec == "appComboOpportunityType")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboOpportunityType();
}
elseif ($v_dataSec == "appComboBusinessType")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboBusinessType();
}
elseif ($v_dataSec == "appComboTimelineType")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboTimelineType();
}
elseif ($v_dataSec == "appComboProductCategory")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appCombo =  new appCombo();
    $v_appProductCategory = $v_appCombo->comboProductCategory($v_appData);
}
elseif ($v_dataSec == "appComboSpecType")
{
    $v_appCombo =  new appCombo();
    $v_specTypeCombo = $v_appCombo->comboSpecType();
}
elseif ($v_dataSec == "appComboSource")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSource($v_appData);
}
elseif ($v_dataSec == "appComboPhotoType")
{
    $v_appCombo =  new appCombo();
    $v_appPhotoTypeCombo = $v_appCombo->comboPhotoType();
}
elseif ($v_dataSec == "appComboFollowUpType")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboFollowUpType();
}
elseif ($v_dataSec == "appComboReasonType")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboReasonType($v_appData);
}
elseif ($v_dataSec == "appComboSystemTitle")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemTitle($v_appData);
}
elseif ($v_dataSec == "appComboSystemAlertType")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemAlertType();
}
elseif ($v_dataSec == "appComboSystemAccessProfile")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemAccessProfile();
}
elseif ($v_dataSec == "appComboSystemContinent")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemContinent();
}
elseif ($v_dataSec == "appComboSystemCountry")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemCountry();
}
elseif ($v_dataSec == "appComboSystemState")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appCombo =  new appCombo();
    $v_return = $v_appCombo->comboSystemState($v_appData);
    echo $v_return;
}
elseif ($v_dataSec == "appComboSystemCity")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appCombo =  new appCombo();
    $v_return = $v_appCombo->comboSystemCity($v_appData);
    echo $v_return;
}
elseif ($v_dataSec == "appComboSystemCurrency")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemCurrency($v_appData);
}
elseif ($v_dataSec == "appComboSystemFeature")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemFeature();
}
elseif ($v_dataSec == "appComboSystemGender")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemGender($v_appData);
}
elseif ($v_dataSec == "appComboSystemLanguage")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemLanguage();
}
elseif ($v_dataSec == "appComboSystemMeasureSystem")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemMeasureSystem($v_appData);
}
elseif ($v_dataSec == "appComboSystemMeasure")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemMeasure();
}
elseif ($v_dataSec == "appComboSystemPlan")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemPlan();
}
elseif ($v_dataSec == "appComboSystemOpportunityStage")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemOpportunityStage($v_appData);
}
elseif ($v_dataSec == "appComboSystemBusinessStage")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemBusinessStage($v_appData);
}
elseif ($v_dataSec == "appComboSystemOpportunityBusinessStage")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemBusinessOpportunityStage($v_appData);
}
elseif ($v_dataSec == "appComboSystemOpportunityProbability")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboProbability($v_appData);
    echo $v_appData;
}
elseif ($v_dataSec == "appBusinessOpportunityItem")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appItemData =  new appBusinessOpportunityItem();
    $v_appData = $v_appItemData->appBusinessOpportunityItemData($v_appData);
    echo $v_appData;
}
elseif ($v_dataSec == "appComboSystemBusinessProbability")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboProbability($v_appData);
    echo $v_appData;
}
elseif ($v_dataSec == "appComboSystemPeriodType")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemPeriodType();
}
elseif ($v_dataSec == "appComboSystemOpportunityStageInit")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemOpportunityStageInit($v_appData);
}
elseif ($v_dataSec == "appComboSystemBusinessStageInit")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemBusinessStageInit($v_appData);
}
elseif ($v_dataSec == "appComboSystemSocial")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemSocial();
}
elseif ($v_dataSec == "appComboSystemTheme")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemTheme();
}
elseif ($v_dataSec == "appComboAddressType")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboAddressType();
}
elseif ($v_dataSec == "appComboContactType")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboContactType();
}
elseif ($v_dataSec == "appComboEmailType")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboEmailType();
}
elseif ($v_dataSec == "appComboFileType")
{
    $v_appData = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboFileType($v_appData);
}
elseif ($v_dataSec == "appComboPhoneType")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboPhoneType();
}
elseif ($v_dataSec == "appComboWebsiteType")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboWebsiteType();
    echo $v_appData;
}
elseif ($v_dataSec == "appComboMarket")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboMarket();
}
elseif ($v_dataSec == "appComboPosition")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appCombo =  new appCombo();
    $v_return = $v_appCombo->comboPosition($v_appData);
    echo $v_return;
}
elseif ($v_dataSec == "appComboDepartment")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appCombo =  new appCombo();
    $v_return = $v_appCombo->comboDepartment($v_appData);
    echo $v_return;
}
elseif ($v_dataSec == "appComboSpecType")
{
    $v_appCombo =  new appCombo();
    $v_specTypeCombo = $v_appCombo->comboSpecType();
}
elseif ($v_dataSec == "appComboSystemUserProfile")
{
    $v_appCombo =  new appCombo();
    $v_appData = $v_appCombo->comboSystemUserProfile();
}
elseif ($v_dataSec == "appComboItemStatus")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appCombo =  new appCombo();
    $v_comboItem = $v_appCombo->comboItemStatus($v_appData);
}
elseif ($v_dataSec == "appComboDefaultCurrency")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appCombo =  new appCombo();
    $v_systemCurrency = $v_appCombo->comboSystemCurrency($v_appData);
}

/* API LOVs */
elseif ($v_dataSec == "appLovSource")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_source = $v_appLov->lovSource($v_appData);
}
elseif ($v_dataSec == "appLovTimelineType")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_timeline = $v_appLov->lovTimelineType($v_appData);
}
elseif ($v_dataSec == "appLovProductType")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appLov =  new appLov();
    $v_appProductType= $v_appLov->lovProductType($v_appData,$v_type);
}
elseif ($v_dataSec == "appLovManufacturer")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appLov =  new appLov();
    $v_appManufacturer = $v_appLov->lovManufacturer($v_appData,$v_type);
}
elseif ($v_dataSec == "appLovFollowUpType")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_appFollowUp = $v_appLov->lovFollowUpType($v_appData);
}
elseif ($v_dataSec == "appLovAddressType")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_appAddressType = $v_appLov->lovAddressType($v_appData);
}
elseif ($v_dataSec == "appLovContactType")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_appContactType = $v_appLov->lovContactType($v_appData);
}
elseif ($v_dataSec == "appLovEmailType")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_EmailType = $v_appLov->lovEmailType($v_appData);
}
elseif ($v_dataSec == "appLovFileType")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_FileType = $v_appLov->lovFileType($v_appData);
}
elseif ($v_dataSec == "appLovPhoneType")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_appPhoneType = $v_appLov->lovPhoneType($v_appData);
}
elseif ($v_dataSec == "appLovWebsiteType")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_appWebsiteType = $v_appLov->lovWebsiteType($v_appData);
}
elseif ($v_dataSec == "appLovMarket")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appLov =  new appLov();
    $v_market = $v_appLov->lovMarket($v_appData);
}
elseif ($v_dataSec == "appLovPosition")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appLov =  new appLov();
    $v_position = $v_appLov->lovPosition($v_appData);
}
elseif ($v_dataSec == "appLovDepartment")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appLov =  new appLov();
    $v_department = $v_appLov->lovDepartment($v_appData);
}
elseif ($v_dataSec == "appLovPhotoType")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_appPhotoType = $v_appLov->lovPhotoType($v_appData);
}
elseif ($v_dataSec == "appLovSpecType")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_specType = $v_appLov->lovSpecType($v_appData);
}
elseif ($v_dataSec == "appLovProductCategory")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : NULL;
    $v_appLov =  new appLov();
    $v_appProductCategory = $v_appLov->lovProductCategory($v_appData,$v_type);
}
elseif ($v_dataSec == "appLovOpportunityType")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_opportunity = $v_appLov->lovOpportunityType($v_appData);
}
elseif ($v_dataSec == "appLovBusinessType")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_business = $v_appLov->lovBusinessType($v_appData);
}
elseif ($v_dataSec == "appLovSpecType")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_specType = $v_appLov->lovSpecType($v_appData);
}
elseif ($v_dataSec == "appLovList")
{
    $v_appData = !empty($_REQUEST['appFormData']) ? $_REQUEST['appFormData'] : NULL;
    $v_appLov =  new appLov();
    $v_lovList = $v_appLov->lovList($v_appData);
}
elseif ($v_dataSec == "appLovColumns"){
    $v_appRequest = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_lovID = $v_appRequest['lovID'];
    $v_appData = new appLov();
    $v_appLovColum = $v_appData->lovColumns($v_lovID);
    echo json_encode($v_appLovColum);
}
elseif ($v_dataSec == "appLovTable")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appLovData =  new appLov();
    $v_lovTable = $v_appLovData->lovTable($v_appData);
    $v_return['lovData'] = $v_lovTable['rsData'];
    echo json_encode($v_return);
}
elseif ($v_dataSec == "appLovGlobal") {
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;

    $v_appLov = new appLov();
    $v_return = $v_appLov->lovGlobal($v_appData);
}
elseif ($v_dataSec == "appToolGeoData")
{
    $v_systemTools = new appSystemTools();
    $v_userIP['userIPData'] = $v_systemTools->appGetRealIP();//retorna IP
    $v_userIP['userIPData'] = '177.80.176.118'; //ToDo: Remover depois do DEV - William
    $v_ipUserData = new appGeoData();
    $v_userLocationData = $v_ipUserData->getIPGeoInfo($v_userIP,'array');
    $v_userTimezone = $v_userLocationData['time_zone'];
    $v_userGMT = substr($v_userTimezone['current_time'],-6);
    if(!empty($v_userLocationData['continent_code'])) {
        $_SESSION['userTimeZone'] = $v_userTimezone['id'];
        $_SESSION['userGMT'] = $v_userGMT;
        $_SESSION['userGMTOffset'] = $v_userTimezone['gmt_offset'];
        $v_ipLocationCSCData = $v_ipUserData->geoCheckCSCData($v_userLocationData,'array');
        $v_ipLocationCSCJson = $v_ipLocationCSCData[0];
        if(is_null($v_ipLocationCSCJson)) {
            $v_return['country_id'] = (string)$GLOBALS['g_defaultCountryID'];
            $v_return['state_id'] = null;
            $v_return['city_id'] = null;
        } else {
            $v_return = $v_ipLocationCSCData[0];
        }
        $v_ipLocationData = json_encode($v_return);

    } else
    {
        unset($_SESSION['userTimeZone']);
        unset($_SESSION['userGMT']);
        unset($_SESSION['userGMTOffset']);
        $v_return['country_id'] = (string)$GLOBALS['g_defaultCountryID'];
        $v_return['state_id'] = null;
        $v_return['city_id'] = null;
        $v_ipLocationData = json_encode($v_return);
    }
    echo $v_ipLocationData;

}
elseif ($v_dataSec == "wizardOpportunity") {
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    //Não alterar a ordem dos indices dos arrays
    if($v_appData['stepID'] == 1){ //customer
        //$v_wizardArray[0] = Array ($v_appData['newCustomer'],$v_appData['customerID'],$v_appData['customerNickname'],$v_appData['opportunityStageID'],$v_appData['opportunityStageDesc'],$v_appData['sourceID'],$v_appData['sourceDesc'],$v_appData['opportunityDesc'], $v_appData['countryID'],$v_appData['stateID'],$v_appData['cityID']);
        $_SESSION['wizardOpportunityArray'][0] = Array ($v_appData['newCustomer'],$v_appData['customerID'],$v_appData['customerNickname'],$v_appData['opportunityStageID'],$v_appData['opportunityStageDesc'],$v_appData['sourceID'],$v_appData['sourceDesc'],$v_appData['opportunityDesc'], $v_appData['countryID'],$v_appData['stateID'],$v_appData['cityID'],$v_appData['customerTypeID']);
        //print_r($v_wizardArray);die();
    }elseif($v_appData['stepID'] == 2){ //contacts
        $_SESSION['wizardOpportunityArray'][1][] = Array($v_appData['newContact'],$v_appData['contactID'],$v_appData['contactName'],$v_appData['contactEmail'],$v_appData['fullNumber'],$v_appData['phoneCountryID'],$v_appData['phoneArea'],$v_appData['contactPhone'],$v_appData['phoneTypeID'], $v_appData['phoneTypeDesc'],$v_appData['tempContactID']);
        //print_r($v_wizardArray);die();
    }elseif($v_appData['stepID'] == 3){ //products
        $_SESSION['wizardOpportunityArray'][2][] = Array($v_appData['newProduct'],$v_appData['productID'],$v_appData['productDesc'],$v_appData['wizardProductBasePrice'],$v_appData['productQuotedPrice'],$v_appData['freeOfCharge'],$v_appData['quotedUnits'],$v_appData['wizardProductBasePriceClean'],$v_appData['productQuotedPriceClean'],$v_appData['tempProductID']);
    }
    /*
    echo '<pre>appData<BR>';
    print_r($v_appData);
    echo "<HR>";
    echo 'wizardOpportunityArray<BR>';
    print_r($_SESSION['wizardOpportunityArray']);
    echo '</pre>';
    */
    echo json_encode($_SESSION['wizardOpportunityArray']);

}
elseif ($v_dataSec == "wizardBusiness") {
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    //Não alterar a ordem dos indices dos arrays
    if($v_appData['stepID'] == 1){ //customer
        //$v_wizardArray[0] = Array ($v_appData['newCustomer'],$v_appData['customerID'],$v_appData['customerNickname'],$v_appData['businessStageID'],$v_appData['businessStageDesc'],$v_appData['sourceID'],$v_appData['sourceDesc'],$v_appData['businessDesc'], $v_appData['countryID'],$v_appData['stateID'],$v_appData['cityID']);
        $_SESSION['wizardBusinessArray'][0] = Array ($v_appData['newCustomer'],$v_appData['customerID'],$v_appData['customerNickname'],$v_appData['businessStageID'],$v_appData['businessStageDesc'],$v_appData['sourceID'],$v_appData['sourceDesc'],$v_appData['businessDesc'], $v_appData['countryID'],$v_appData['stateID'],$v_appData['cityID'],$v_appData['customerTypeID']);
        //print_r($v_wizardArray);die();
    }elseif($v_appData['stepID'] == 2){ //contacts
        $_SESSION['wizardBusinessArray'][1][] = Array($v_appData['newContact'],$v_appData['contactID'],$v_appData['contactName'],$v_appData['contactEmail'],$v_appData['fullNumber'],$v_appData['phoneCountryID'],$v_appData['phoneArea'],$v_appData['contactPhone'],$v_appData['phoneTypeID'], $v_appData['phoneTypeDesc'],$v_appData['tempContactID']);
        //print_r($v_wizardArray);die();
    }elseif($v_appData['stepID'] == 3){ //products
        $_SESSION['wizardBusinessArray'][2][] = Array($v_appData['newProduct'],$v_appData['productID'],$v_appData['productDesc'],$v_appData['wizardProductBasePrice'],$v_appData['productQuotedPrice'],$v_appData['freeOfCharge'],$v_appData['quotedUnits'],$v_appData['wizardProductBasePriceClean'],$v_appData['productQuotedPriceClean'],$v_appData['tempProductID']);
    }
    /*
    echo '<pre>appData<BR>';
    print_r($v_appData);
    echo "<HR>";
    echo 'wizardBusinessArray<BR>';
    print_r($_SESSION['wizardBusinessArray']);
    echo '</pre>';
    */
    echo json_encode($_SESSION['wizardBusinessArray']);

}
elseif ($v_dataSec == "wizardOpportunityDelete"){
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_return['deleted'] = false;

    if($v_appData['stepID'] == 2){
        foreach($_SESSION['wizardOpportunityArray'][1] as $keyContact=>$valueContact){
            if($valueContact[10] == $v_appData['tempContactID']){
                //deleta contato da sessão
                unset($_SESSION['wizardOpportunityArray'][1][$keyContact]);
                $v_return['deleted'] = true;
            }
        }
    }elseif($v_appData['stepID'] == 3){
        foreach($_SESSION['wizardOpportunityArray'][2] as $keyProduct=>$valueProduct) {
            if ($valueProduct[9] == $v_appData['tempProductID']) {
                //deleta produto da sessão
               unset($_SESSION['wizardOpportunityArray'][2][$keyProduct]);
                $v_return['deleted'] = true;
            }
        }
    }

    echo json_encode($v_return['deleted']);
}
elseif ($v_dataSec == "wizardBusinessDelete"){
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_return['deleted'] = false;

    if($v_appData['stepID'] == 2){
        foreach($_SESSION['wizardBusinessArray'][1] as $keyContact=>$valueContact){
            if($valueContact[10] == $v_appData['tempContactID']){
                //deleta contato da sessão
                unset($_SESSION['wizardBusinessArray'][1][$keyContact]);
                $v_return['deleted'] = true;
            }
        }
    }elseif($v_appData['stepID'] == 3){
        foreach($_SESSION['wizardBusinessArray'][2] as $keyProduct=>$valueProduct) {
            if ($valueProduct[9] == $v_appData['tempProductID']) {
                //deleta produto da sessão
                unset($_SESSION['wizardBusinessArray'][2][$keyProduct]);
                $v_return['deleted'] = true;
            }
        }
    }

    echo json_encode($v_return['deleted']);
}
elseif ($v_dataSec == "wizardOpportunityConfirm"){
    //For test Only
    //echo json_encode(true); $_SESSION['wizardOpportunityArray'] = array(); die();

    //add Customer
    if($_SESSION['wizardOpportunityArray'][0][0]=='true') {

        $v_appCustomerData['method'] = 'POST';
        $v_appCustomerData['customerName'] = $_SESSION['wizardOpportunityArray'][0][2];
        $v_appCustomerData['customerNickname'] = $_SESSION['wizardOpportunityArray'][0][2];
        $v_appCustomerData['customerTypeID'] = $_SESSION['wizardOpportunityArray'][0][11];
        $v_customer =  new appCustomer();
        $v_customerData = $v_customer->appCustomerData($v_appCustomerData);

        if($v_customerData['apiData']['status']){
            $v_customerID = $v_customerData['apiData']['rsInsertID'];
            $_SESSION['wizardOpportunityArray'][0][1] = $v_customerID;
            $v_cityData['table'] = 'view_combo_system_city';
            $v_cityData['field'] = 'city_desc';
            $v_cityData['fieldName'] = 'city_id';
            $v_cityData['fieldID'] = $_SESSION['wizardOpportunityArray'][0][10];

            $v_getValueData = new appGetValue();
            $v_cityDataReturn = $v_getValueData->appGetValueData($v_cityData);
            $v_cityDesc = $v_cityDataReturn[0]['city_desc']; //nome da cidade p/ usar como full address

            $v_countryData['table'] = 'view_combo_system_country';
            $v_countryData['field'] = array('country_desc','country_code');
            $v_countryData['fieldName'] = 'country_id';
            $v_countryData['fieldID'] = $_SESSION['wizardOpportunityArray'][0][8];
            $v_countryDataReturn = $v_getValueData->appGetValueData($v_countryData);

            $v_stateData['table'] = 'view_combo_system_state';
            $v_stateData['field'] = array('state_desc','state_code');
            $v_stateData['fieldName'] = 'state_id';
            $v_stateData['fieldID'] = $_SESSION['wizardOpportunityArray'][0][9];
            $v_stateDataReturn = $v_getValueData->appGetValueData($v_stateData);

            //inserir endereço
            $v_appAddressData['method'] = 'POST';
            $v_appAddressData['fullAddress'] = $v_cityDesc;
            $v_appAddressData['customerID'] = $v_customerID;
            $v_appAddressData['countryID'] = $_SESSION['wizardOpportunityArray'][0][8];
            $v_appAddressData['countryDesc'] = $v_countryDataReturn[0]['country_desc'];
            $v_appAddressData['countryCode'] = $v_countryDataReturn[0]['country_code'];
            $v_appAddressData['stateID'] = $_SESSION['wizardOpportunityArray'][0][9];
            $v_appAddressData['stateDesc'] = $v_stateDataReturn[0]['state_desc'];
            $v_appAddressData['stateCode'] = $v_stateDataReturn[0]['state_code'];
            $v_appAddressData['cityID'] = $_SESSION['wizardOpportunityArray'][0][10];
            $v_appAddressData['cityDesc'] =  $v_cityDesc;

            $v_addressData = new appAddress();
            $v_appAddress = $v_addressData->appAddressData($v_appAddressData);

        }else{
            $v_customerID = false;
        }
    }else{
        $v_customerID = $_SESSION['wizardOpportunityArray'][0][1];
    }

    //add contact
    $v_contact = new appContact();
    $v_opportunityContactsArray = array(); //array de contatos que serão adicionados a oportunidade
    if(isset($_SESSION['wizardOpportunityArray'][1])){
        foreach ($_SESSION['wizardOpportunityArray'][1] as  $v_key => $v_value) {

            if ($v_value[0] == 'true') {

                $v_appContactData['method'] = 'POST';
                $v_appContactData['contactName'] = $v_value[2];
                $v_appContactData['contactNickname'] = $v_value[2];
                $v_appContactData['titleID'] = 1; //Not Applicable
                $v_appContactData['genderID'] = 2; //Not Applicable
                $v_appContactData['contactInformation'] = '';
                $v_appContactData['customerID'] = $v_customerID;

                $v_contactData = $v_contact->appContactData($v_appContactData);
                if ($v_contactData['status']) {
                    $v_contact_id = $v_contactData['rsInsertID'];
                    $_SESSION['wizardOpportunityArray'][1][$v_key][1] = $v_contact_id;
                    $v_opportunityContactsArray[] = $v_contact_id;
                    $v_appData['contactID'] = $v_contact_id;

                    //add phone
                    if ($v_value[7] != '') {

                        $v_phoneData = new appPhone();
                        $v_appPhoneData['method'] = 'POST';
                        $v_appPhoneData['contactID'] = $v_contact_id;
                        $v_appPhoneData['phoneArea'] = $v_value[6];
                        $v_appPhoneData['phoneNumber'] = $v_value[7];
                        $v_appPhoneData['phoneTypeID'] = $v_value[8];
                        $v_appPhoneData['countryID'] = $v_value[5];
                        $v_appPhone = $v_phoneData->appPhoneData($v_appPhoneData);
                        if ($v_appPhone['status']) {
                            $v_return['addPhone'] = true;
                        } else {
                            $v_return['addPhone'] = false;
                        }
                    }

                    //add email
                    if($v_value[3] != ''){
                        $v_appEmailData['emailAddress'] = $v_value[3];
                        $v_appEmailData['method'] = 'POST';
                        $v_appEmailData['contactID'] = $v_contact_id;

                        $v_emailData = new appEmail();
                        $v_appEmail = $v_emailData->appEmailData($v_appEmailData);
                        if ($v_appEmail['apiData']['status']) {
                            $v_return['addEmail'] = true;
                        } else {
                            $v_return['addEmail'] = false;
                        }
                    }

                    //add position
                    $v_dataArray = array();
                    $v_dataArray['positionID'] = '1';//enviar array
                    $v_dataRelation['method'] = 'POST';

                    $v_dataRelation['leftCol'] = 'contact';
                    $v_dataRelation['leftField'] = 'contact_id';
                    $v_dataRelation['leftValue'] = $v_contact_id;
                    $v_dataRelation['rightCol'] = 'position';
                    $v_dataRelation['rightField'] = 'position_id';
                    $v_dataRelation['rightValue'] = $v_dataArray;
                    $v_appRelation = new appRelationalData();
                    $v_relationPosition = $v_appRelation->setDataRelation($v_dataRelation);
                    if ($v_relationPosition) {
                        $v_return['relationPosition'] = true;
                    } else {
                        $v_return['relationPosition'] = false;
                    }

                    //add department
                    $v_dataArray = array();
                    $v_dataArray['departmentID'] = '1';//enviar array
                    $v_dataRelation['method'] = 'POST';
                    $v_dataRelation['leftCol'] = 'contact';
                    $v_dataRelation['leftField'] = 'contact_id';
                    $v_dataRelation['leftValue'] = $v_contact_id;
                    $v_dataRelation['rightCol'] = 'department';
                    $v_dataRelation['rightField'] = 'department_id';
                    $v_dataRelation['rightValue'] = $v_dataArray;
                    $v_appRelation = new appRelationalData();
                    $v_relationDepartment = $v_appRelation->setDataRelation($v_dataRelation);
                    if ($v_relationDepartment) {
                        $v_return['relationDepartment'] = true;
                    } else {
                        $v_return['relationDepartment'] = false;
                    }

                }

            }else{
                $v_contact_id = $v_value[1];
                $v_opportunityContactsArray[] = $v_contact_id;
            }

        }
    }


    //add product
    $v_product = new appProduct();
    $v_basePrice = new appPrice();
    foreach ($_SESSION['wizardOpportunityArray'][2] as $v_key => $v_value) {

        if ($v_value[0] == 'true') {

            $v_appProductData['method'] = 'POST';
            $v_appProductData['productDesc'] = $v_value[2];
            $v_appProductData['productBasePriceClean'] = floatval($v_value[7]);

            $v_productData = $v_product->appProductData($v_appProductData);

            if($v_productData['apiData']['status'])
            {
                $v_product_id = $v_productData['apiData']['rsInsertID'];
                $_SESSION['wizardOpportunityArray'][2][$v_key][1] = $v_product_id;
                $v_return['status'] = true;
                $v_return['productID'] = $v_product_id;

                $v_basePriceInfo['productID'] = $v_product_id;
                $v_basePriceInfo['basePrice'] = $v_appProductData['productBasePriceClean'];
                $v_basePriceInfo['method'] = 'POST';

                $v_basePriceData = $v_basePrice->appBasePrice($v_basePriceInfo);
                $v_return['basePriceID'] = $v_basePriceData['basePriceID'];

            }else
            {
                $v_return['basePriceID'] = false;
            }
        }else{
            $v_product_id = $v_value[1];
        }

    }

    //create opportunity
    $v_opportunity =  new appOpportunity();

    $v_appOpportunityData['method'] = 'POST';
    $v_appOpportunityData['opportunityStageID'] = $_SESSION['wizardOpportunityArray'][0][3];
    $v_appOpportunityData['sourceID'] = $_SESSION['wizardOpportunityArray'][0][5];
    $v_appOpportunityData['opportunityDesc'] = trim($_SESSION['wizardOpportunityArray'][0][7]);
    $v_appOpportunityData['customerID'] = $v_customerID;
    $v_appOpportunityData['probabilityID'] = '2';   //Default - Medium
    $v_appOpportunityData['ownerID'] = $_SESSION['userID'];


    $v_opportunityData = $v_opportunity->appOpportunityData($v_appOpportunityData);
    if($v_opportunityData['apiData']['status'])
    {
        $v_opportunity_id = $v_opportunityData['apiData']['rsInsertID'];
        $v_return['status'] = true;
        $v_return['opportunityID'] = $v_opportunity_id;
        $v_return['opportunitySequence'] = $v_opportunityData['apiData']['opportunitySequence'];

        if(isset($_SESSION['wizardOpportunityArray'][1])){
            //atrela contatos a oportunidade
            $v_dataRelation['method'] = 'POST';
            $v_dataRelation['leftCol'] = 'opportunity';
            $v_dataRelation['leftField'] = 'opportunity_id';
            $v_dataRelation['leftValue'] = $v_opportunity_id;
            $v_dataRelation['rightCol'] = 'contact';
            $v_dataRelation['rightField'] = 'contact_id';
            $v_dataRelation['rightValue'] = $v_opportunityContactsArray;
            $v_appRelation = new appRelationalData();
            $v_relationContactOpportunity = $v_appRelation->setDataRelation($v_dataRelation);
            if ($v_relationContactOpportunity) {
                $v_return['relationContactOpportunity'] = true;
            } else {
                $v_return['relationContactOpportunity'] = false;
            }
        }


        //atrela produtos a oportunidade
        $v_saleItemData = new appSaleItem();
        $v_quotedPrice = new appPrice();
        $v_appRelation = new appRelationalData();

        $v_appOpportunitySaleItemData['method'] = 'POST';
        $v_appOpportunitySaleItemData['opportunityID'] = $v_opportunity_id;
        foreach($_SESSION['wizardOpportunityArray'][2] as $v_value){
            $v_appOpportunitySaleItemData['productID'] = $v_value[1];
            $v_appOpportunitySaleItemData['itemValue'] = $v_value[8];
            $v_appOpportunitySaleItemData['quotedUnits'] = $v_value[6];
            $v_appOpportunitySaleItemData['freeOfCharge'] = $v_value[5];

            $v_appSaleItem = $v_saleItemData->appSaleItemData($v_appOpportunitySaleItemData);
            if($v_appSaleItem['status']) {
                $v_dataArray = array();
                $v_dataArray['itemID'] = $v_appSaleItem['itemID'];//enviar array
                $v_appOpportunitySaleItemData['itemID'] = $v_appSaleItem['itemID'];
                $v_dataRelation['method'] = 'POST';
                $v_dataRelation['leftCol'] = 'opportunity';
                $v_dataRelation['leftField'] = 'opportunity_id';
                $v_dataRelation['leftValue'] = $v_opportunity_id;
                $v_dataRelation['rightCol'] = 'sale_item';
                $v_dataRelation['rightField'] = 'item_id';
                $v_dataRelation['rightValue'] = $v_dataArray;

                $v_return['opportunitySaleItemData'] = $v_appRelation->setDataRelation($v_dataRelation);
            }
            $v_quotedPriceData = $v_quotedPrice->appQuotedPrice($v_appOpportunitySaleItemData);
            $v_return['quotedPriceData'] = $v_quotedPriceData['quotedPriceID'];

        }

        $v_return['opportunityCreated'] = true;
        $_SESSION['wizardOpportunityArray'] = array();//limpa a sessão

    }else {
        $v_return['opportunityCreated'] = false;
        $v_return['opportunityID'] = false;
        $v_return['opportunitySequence'] = false;
    }
    echo json_encode($v_return['opportunityCreated']);
    //print ' --- ';print_r($v_return);

}
elseif ($v_dataSec == "wizardBusinessConfirm"){
    //For test Only
    //echo json_encode(true); $_SESSION['wizardBusinessArray'] = array(); die();

    //add Customer
    if($_SESSION['wizardBusinessArray'][0][0]=='true') {

        $v_appCustomerData['method'] = 'POST';
        $v_appCustomerData['customerName'] = $_SESSION['wizardBusinessArray'][0][2];
        $v_appCustomerData['customerNickname'] = $_SESSION['wizardBusinessArray'][0][2];
        $v_appCustomerData['customerTypeID'] = $_SESSION['wizardBusinessArray'][0][11];
        $v_customer =  new appCustomer();
        $v_customerData = $v_customer->appCustomerData($v_appCustomerData);

        if($v_customerData['apiData']['status']){
            $v_customerID = $v_customerData['apiData']['rsInsertID'];
            $_SESSION['wizardBusinessArray'][0][1] = $v_customerID;
            $v_cityData['table'] = 'view_combo_system_city';
            $v_cityData['field'] = 'city_desc';
            $v_cityData['fieldName'] = 'city_id';
            $v_cityData['fieldID'] = $_SESSION['wizardBusinessArray'][0][10];

            $v_getValueData = new appGetValue();
            $v_cityDataReturn = $v_getValueData->appGetValueData($v_cityData);
            $v_cityDesc = $v_cityDataReturn[0]['city_desc']; //nome da cidade p/ usar como full address

            $v_countryData['table'] = 'view_combo_system_country';
            $v_countryData['field'] = array('country_desc','country_code');
            $v_countryData['fieldName'] = 'country_id';
            $v_countryData['fieldID'] = $_SESSION['wizardBusinessArray'][0][8];
            $v_countryDataReturn = $v_getValueData->appGetValueData($v_countryData);

            $v_stateData['table'] = 'view_combo_system_state';
            $v_stateData['field'] = array('state_desc','state_code');
            $v_stateData['fieldName'] = 'state_id';
            $v_stateData['fieldID'] = $_SESSION['wizardBusinessArray'][0][9];
            $v_stateDataReturn = $v_getValueData->appGetValueData($v_stateData);

            //inserir endereço
            $v_appAddressData['method'] = 'POST';
            $v_appAddressData['fullAddress'] = $v_cityDesc;
            $v_appAddressData['customerID'] = $v_customerID;
            $v_appAddressData['countryID'] = $_SESSION['wizardBusinessArray'][0][8];
            $v_appAddressData['countryDesc'] = $v_countryDataReturn[0]['country_desc'];
            $v_appAddressData['countryCode'] = $v_countryDataReturn[0]['country_code'];
            $v_appAddressData['stateID'] = $_SESSION['wizardBusinessArray'][0][9];
            $v_appAddressData['stateDesc'] = $v_stateDataReturn[0]['state_desc'];
            $v_appAddressData['stateCode'] = $v_stateDataReturn[0]['state_code'];
            $v_appAddressData['cityID'] = $_SESSION['wizardBusinessArray'][0][10];
            $v_appAddressData['cityDesc'] =  $v_cityDesc;

            $v_addressData = new appAddress();
            $v_appAddress = $v_addressData->appAddressData($v_appAddressData);

        }else{
            $v_customerID = false;
        }
    }else{
        $v_customerID = $_SESSION['wizardBusinessArray'][0][1];
    }

    //add contact
    $v_contact = new appContact();
    $v_businessContactsArray = array(); //array de contatos que serão adicionados a oportunidade
    if(isset($_SESSION['wizardBusinessArray'][1])){
        foreach ($_SESSION['wizardBusinessArray'][1] as  $v_key => $v_value) {

            if ($v_value[0] == 'true') {

                $v_appContactData['method'] = 'POST';
                $v_appContactData['contactName'] = $v_value[2];
                $v_appContactData['contactNickname'] = $v_value[2];
                $v_appContactData['titleID'] = 1; //Not Applicable
                $v_appContactData['genderID'] = 2; //Not Applicable
                $v_appContactData['contactInformation'] = '';
                $v_appContactData['customerID'] = $v_customerID;

                $v_contactData = $v_contact->appContactData($v_appContactData);
                if ($v_contactData['status']) {
                    $v_contact_id = $v_contactData['rsInsertID'];
                    $_SESSION['wizardBusinessArray'][1][$v_key][1] = $v_contact_id;
                    $v_businessContactsArray[] = $v_contact_id;
                    $v_appData['contactID'] = $v_contact_id;

                    //add phone
                    if ($v_value[7] != '') {

                        $v_phoneData = new appPhone();
                        $v_appPhoneData['method'] = 'POST';
                        $v_appPhoneData['contactID'] = $v_contact_id;
                        $v_appPhoneData['phoneArea'] = $v_value[6];
                        $v_appPhoneData['phoneNumber'] = $v_value[7];
                        $v_appPhoneData['phoneTypeID'] = $v_value[8];
                        $v_appPhoneData['countryID'] = $v_value[5];
                        $v_appPhone = $v_phoneData->appPhoneData($v_appPhoneData);
                        if ($v_appPhone['status']) {
                            $v_return['addPhone'] = true;
                        } else {
                            $v_return['addPhone'] = false;
                        }
                    }

                    //add email
                    if($v_value[3] != ''){
                        $v_appEmailData['emailAddress'] = $v_value[3];
                        $v_appEmailData['method'] = 'POST';
                        $v_appEmailData['contactID'] = $v_contact_id;

                        $v_emailData = new appEmail();
                        $v_appEmail = $v_emailData->appEmailData($v_appEmailData);
                        if ($v_appEmail['apiData']['status']) {
                            $v_return['addEmail'] = true;
                        } else {
                            $v_return['addEmail'] = false;
                        }
                    }

                    //add position
                    $v_dataArray = array();
                    $v_dataArray['positionID'] = '1';//enviar array
                    $v_dataRelation['method'] = 'POST';

                    $v_dataRelation['leftCol'] = 'contact';
                    $v_dataRelation['leftField'] = 'contact_id';
                    $v_dataRelation['leftValue'] = $v_contact_id;
                    $v_dataRelation['rightCol'] = 'position';
                    $v_dataRelation['rightField'] = 'position_id';
                    $v_dataRelation['rightValue'] = $v_dataArray;
                    $v_appRelation = new appRelationalData();
                    $v_relationPosition = $v_appRelation->setDataRelation($v_dataRelation);
                    if ($v_relationPosition) {
                        $v_return['relationPosition'] = true;
                    } else {
                        $v_return['relationPosition'] = false;
                    }

                    //add department
                    $v_dataArray = array();
                    $v_dataArray['departmentID'] = '1';//enviar array
                    $v_dataRelation['method'] = 'POST';
                    $v_dataRelation['leftCol'] = 'contact';
                    $v_dataRelation['leftField'] = 'contact_id';
                    $v_dataRelation['leftValue'] = $v_contact_id;
                    $v_dataRelation['rightCol'] = 'department';
                    $v_dataRelation['rightField'] = 'department_id';
                    $v_dataRelation['rightValue'] = $v_dataArray;
                    $v_appRelation = new appRelationalData();
                    $v_relationDepartment = $v_appRelation->setDataRelation($v_dataRelation);
                    if ($v_relationDepartment) {
                        $v_return['relationDepartment'] = true;
                    } else {
                        $v_return['relationDepartment'] = false;
                    }

                }

            }else{
                $v_contact_id = $v_value[1];
                $v_businessContactsArray[] = $v_contact_id;
            }

        }
    }


    //add product
    $v_product = new appProduct();
    $v_basePrice = new appPrice();
    foreach ($_SESSION['wizardBusinessArray'][2] as $v_key => $v_value) {

        if ($v_value[0] == 'true') {

            $v_appProductData['method'] = 'POST';
            $v_appProductData['productDesc'] = $v_value[2];
            $v_appProductData['productBasePriceClean'] = floatval($v_value[7]);

            $v_productData = $v_product->appProductData($v_appProductData);

            if($v_productData['apiData']['status'])
            {
                $v_product_id = $v_productData['apiData']['rsInsertID'];
                $_SESSION['wizardBusinessArray'][2][$v_key][1] = $v_product_id;
                $v_return['status'] = true;
                $v_return['productID'] = $v_product_id;

                $v_basePriceInfo['productID'] = $v_product_id;
                $v_basePriceInfo['basePrice'] = $v_appProductData['productBasePriceClean'];
                $v_basePriceInfo['method'] = 'POST';

                $v_basePriceData = $v_basePrice->appBasePrice($v_basePriceInfo);
                $v_return['basePriceID'] = $v_basePriceData['basePriceID'];

            }else
            {
                $v_return['basePriceID'] = false;
            }
        }else{
            $v_product_id = $v_value[1];
        }

    }

    //create business
    $v_business =  new appBusiness();

    $v_appBusinessData['method'] = 'POST';
    $v_appBusinessData['businessStageID'] = $_SESSION['wizardBusinessArray'][0][3];
    $v_appBusinessData['sourceID'] = $_SESSION['wizardBusinessArray'][0][5];
    $v_appBusinessData['businessDesc'] = trim($_SESSION['wizardBusinessArray'][0][7]);
    $v_appBusinessData['customerID'] = $v_customerID;
    $v_appBusinessData['probabilityID'] = '2';   //Default - Medium
    $v_appBusinessData['ownerID'] = $_SESSION['userID'];


    $v_businessData = $v_business->appBusinessData($v_appBusinessData);
    if($v_businessData['apiData']['status'])
    {
        $v_business_id = $v_businessData['apiData']['rsInsertID'];
        $v_return['status'] = true;
        $v_return['businessID'] = $v_business_id;
        $v_return['businessSequence'] = $v_businessData['apiData']['businessSequence'];

        if(isset($_SESSION['wizardBusinessArray'][1])){
            //atrela contatos a oportunidade
            $v_dataRelation['method'] = 'POST';
            $v_dataRelation['leftCol'] = 'business';
            $v_dataRelation['leftField'] = 'business_id';
            $v_dataRelation['leftValue'] = $v_business_id;
            $v_dataRelation['rightCol'] = 'contact';
            $v_dataRelation['rightField'] = 'contact_id';
            $v_dataRelation['rightValue'] = $v_businessContactsArray;
            $v_appRelation = new appRelationalData();
            $v_relationContactBusiness = $v_appRelation->setDataRelation($v_dataRelation);
            if ($v_relationContactBusiness) {
                $v_return['relationContactBusiness'] = true;
            } else {
                $v_return['relationContactBusiness'] = false;
            }
        }


        //atrela produtos a oportunidade
        $v_saleItemData = new appSaleItem();
        $v_quotedPrice = new appPrice();
        $v_appRelation = new appRelationalData();

        $v_appBusinessSaleItemData['method'] = 'POST';
        $v_appBusinessSaleItemData['businessID'] = $v_business_id;
        foreach($_SESSION['wizardBusinessArray'][2] as $v_value){
            $v_appBusinessSaleItemData['productID'] = $v_value[1];
            $v_appBusinessSaleItemData['itemValue'] = $v_value[8];
            $v_appBusinessSaleItemData['quotedUnits'] = $v_value[6];
            $v_appBusinessSaleItemData['freeOfCharge'] = $v_value[5];

            $v_appSaleItem = $v_saleItemData->appSaleItemData($v_appBusinessSaleItemData);
            if($v_appSaleItem['status']) {
                $v_dataArray = array();
                $v_dataArray['itemID'] = $v_appSaleItem['itemID'];//enviar array
                $v_appBusinessSaleItemData['itemID'] = $v_appSaleItem['itemID'];
                $v_dataRelation['method'] = 'POST';
                $v_dataRelation['leftCol'] = 'business';
                $v_dataRelation['leftField'] = 'business_id';
                $v_dataRelation['leftValue'] = $v_business_id;
                $v_dataRelation['rightCol'] = 'sale_item';
                $v_dataRelation['rightField'] = 'item_id';
                $v_dataRelation['rightValue'] = $v_dataArray;

                $v_return['businessSaleItemData'] = $v_appRelation->setDataRelation($v_dataRelation);
            }
            $v_quotedPriceData = $v_quotedPrice->appQuotedPrice($v_appBusinessSaleItemData);
            $v_return['quotedPriceData'] = $v_quotedPriceData['quotedPriceID'];

        }

        $v_return['businessCreated'] = true;
        $_SESSION['wizardBusinessArray'] = array();//limpa a sessão

    }else {
        $v_return['businessCreated'] = false;
        $v_return['businessID'] = false;
        $v_return['businessSequence'] = false;
    }
    echo json_encode($v_return['businessCreated']);
    //print ' --- ';print_r($v_return);

}
elseif ($v_dataSec == "wizardOpportunityCancel"){
    $_SESSION['wizardOpportunityArray'] = array();//limpa a sessão
}
elseif ($v_dataSec == "wizardBusinessCancel"){
    $_SESSION['wizardBusinessArray'] = array();//limpa a sessão
}

/* API Geoloc */
elseif ($v_dataSec == "appCustomersGeoloc")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_customerMarkers = new appGeoLocCustomersData($v_appData);
    $v_geoData = new appDataLoader();
    $v_return = $v_geoData->getLocationData($v_customerMarkers);
    $v_geoData = array();

    if($v_return['rsTotal'] > 0) {
        $v_data = $v_return['rsData'];
        $v_geoData['type'] = 'FeatureCollection';
        $v_geoData['customerData'] = true;
        $v_geoData['features'] = array();
        $v_geoData['table'] = $v_data;
        foreach ($v_data AS $k=>$data) {
            $v_geoInfo['type'] = 'Feature';
            $v_geoInfo['properties']['title'] = $data['customer_name'];
            $v_geoInfo['properties']['description'] = $data['customer_type_desc'];
            $v_geoInfo['properties']['distance_km_format'] = $data['distance_km_format'];
            $v_geoInfo['properties']['distance_miles_format'] = $data['distance_miles_format'];
            $v_geoInfo['geometry']['type'] = 'Point';
            $v_geoInfo['geometry']['coordinates'] = array();
            $v_geoInfo['geometry']['coordinates'][] = $data['lng'];
            $v_geoInfo['geometry']['coordinates'][] = $data['lat'];

            $v_geoData['features'][] = $v_geoInfo;
        }
    } else {
        $v_geoData['customerData'] = false;
    }
    echo json_encode($v_geoData);
}
elseif ($v_dataSec == "appContactsGeoloc")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_customerMarkers = new appGeoLocContactsData($v_appData);
    $v_geoData = new appDataLoader();
    $v_return = $v_geoData->getLocationData($v_customerMarkers);
    $v_geoData = array();

    if($v_return['rsTotal'] > 0) {
        $v_data = $v_return['rsData'];
        $v_geoData['type'] = 'FeatureCollection';
        $v_geoData['contactData'] = true;
        $v_geoData['features'] = array();
        $v_geoData['table'] = $v_data;
        foreach ($v_data AS $k=>$data) {
            $v_geoInfo['type'] = 'Feature';
            $v_geoInfo['properties']['title'] = $data['contact_name'];
            $v_geoInfo['properties']['description'] = $data['customer_name'];
            $v_geoInfo['properties']['distance_km_format'] = $data['distance_km_format'];
            $v_geoInfo['properties']['distance_miles_format'] = $data['distance_miles_format'];
            $v_geoInfo['geometry']['type'] = 'Point';
            $v_geoInfo['geometry']['coordinates'] = array();
            $v_geoInfo['geometry']['coordinates'][] = $data['lng'];
            $v_geoInfo['geometry']['coordinates'][] = $data['lat'];

            $v_geoData['features'][] = $v_geoInfo;
        }
    } else {
        $v_geoData['customerData'] = false;
    }
    echo json_encode($v_geoData);
}
elseif($v_dataSec == 'appSetSessionContactEmail'){
    $v_email = new appEmail();
    $return  = $v_email->appSessionContactEmail();
    echo json_encode($return);
}
elseif ($v_dataSec == "appValidContactEmail"){

    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_index = $v_appData['indexEmail'][0];
    $v_row = $v_appData['row'];//Controla quando a session deve ser limpa()

    if($v_row==0){
        $_SESSION["importDataArray"]  = array();
    }

    $v_return['check'] = false;

    if(is_null($v_appData['rowData'][$v_index]) || empty($v_appData['rowData'][$v_index])){
        $v_return['check'] = false;
    }else{
        if (array_key_exists($v_appData['rowData'][$v_index], $_SESSION['importEmailArray'])){
            $v_return['check'] = false;
        }else{
            $v_return['check'] = true;
            $_SESSION["importDataArray"][] = $v_appData['rowData'];
            //print_r($_SESSION["importDataArray"]);
        }
    }
    echo json_encode($v_return);
}
elseif($v_dataSec == "appSetSessionDataChunk"){
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $_SESSION["dataSequence"] =  $v_appData['dataSequence'];

    $_SESSION["importDataArrayChunk"] = array();
    $_SESSION["importDataArrayChunk"]["data"] = array_chunk($_SESSION["importDataArray"], 200);//alterar p 200
    $_SESSION["importDataArrayChunk"]["importLoadedQtdContacts"] = count($_SESSION["importDataArray"]);
    $_SESSION["importDataArrayChunk"]["importedQtdContacts"] = 0;
    $v_return['totalChunk'] = count($_SESSION["importDataArrayChunk"]["data"]);
    $_SESSION["importDataArray"] = array();//zera sessão

    echo json_encode($v_return);
}
elseif($v_dataSec == "appSetSessionNewAddressTour"){
    $_SESSION["appNewAddressTour"] =  true;
    echo json_encode(true);
}
elseif($v_dataSec == "appComboOwner"){
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;

    $v_combo = new appCombo();
    $result  = $v_combo->comboSystemUserList('array',$v_appData['userID']);
    $v_data = $result;

    $return = array();
    $return[0] = array(
        "text" => "Select...",
        "value" => ""
    );

    foreach ($v_data['rsData'] AS $k=>$data) {
        $return[$k+1]['text'] = $data['user_name'];
        $return[$k+1]['value'] = $data['user_id'];
    }
    echo json_encode($return);
}

/* API Fixer IO (currency)*/
elseif ($v_dataSec == "appCurrencyConversion")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appConversionData = new appSystemTools();
    $v_returnData = $v_appConversionData->appCurrencyConversion($v_appData);
    echo $v_returnData;
}

/* API Session Check */
elseif ($v_dataSec == "appSessCheck") {
    $dbHome = new appLoginCheck();
    $vLgnCheck = $dbHome->userSessionCheck();
    echo json_encode($vLgnCheck);
}
elseif ($v_dataSec == "appNewOpportunityFollowUpCheck") {
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_followUpData = new appFollowUp();
    $v_appFollowUp = $v_followUpData->appOpportunityFollowUpData($v_appData);
}
elseif ($v_dataSec == "appNewBusinessFollowUpCheck") {
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_followUpData = new appFollowUp();
    $v_appFollowUp = $v_followUpData->appBusinessFollowUpData($v_appData);
}
elseif ($v_dataSec == "appManufacturerByCategoryList") {
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_dataList = new appDataList();
    $v_appData = $v_dataList->appManufacturerByCategoryList($v_appData);
}
elseif ($v_dataSec == "appListExpense")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appExpenseData = new appDataList();
    $v_appExpenseList = $v_appExpenseData->appExpenseList($v_appData);
    $v_returnData["appExpenseList"] = $v_appExpenseList["rsData"];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appExpense"){
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;

    if($v_appData['method']==='POST')
    {
        //tratamento serialize
        $v_formData = array();
        parse_str($v_appData['formData'], $v_formData);
        foreach($v_formData as $key=>$valor)
        {
            $v_appData[$key] = $valor;
        }
        unset($v_appData['formData']);
        $v_expense =  new appExpense();
        $appExpenseData = $v_expense->appExpenseData($v_appData);

        if($appExpenseData['status'])
        {
            $v_return['status'] = true;
            echo json_encode($appExpenseData);
        }else
        {
            $v_return['status'] = false;
            echo json_encode($v_return);
        }
    }else
    {
        $v_appExpenseData =  new appExpense();
        $v_appExpense = $v_appExpenseData->appExpenseData($v_appData);
        echo json_encode($v_appExpense);
    }
}
elseif ($v_dataSec == "appExpenseItem"){
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appExpenseData =  new appExpense();
    $v_appExpense = $v_appExpenseData->appExpenseItem($v_appData);
    echo json_encode($v_appExpense);
}
elseif ($v_dataSec == "appListExpenseItem")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appExpenseItemData =  new appDataList();
    $v_appExpenseItemList = $v_appExpenseItemData->appExpenseItemList($v_appData);
    $v_returnData["appExpenseItemList"] = $v_appExpenseItemList["rsData"];
    echo json_encode($v_returnData);
}
elseif ($v_dataSec == "appListExpenseNotes")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appExpenseData =  new appDataList();
    $v_appExpenseNotesList = $v_appExpenseData->appExpenseNotesList($v_appData);
}
elseif ($v_dataSec == "appComboExpenseOpportunity")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appCombo =  new appCombo();
    $v_comboItem = $v_appCombo->comboExpenseOpportunity($v_appData);
}
elseif ($v_dataSec == "appComboNinst")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appCombo =  new appCombo();
    $v_comboItem = $v_appCombo->comboNinst($v_appData);
}
elseif ($v_dataSec == "appComboInstallation")
{
    $v_appData = !empty($_REQUEST) ? $_REQUEST : NULL;
    $v_appCombo =  new appCombo();
    $v_comboItem = $v_appCombo->comboInstallation($v_appData);
    echo json_encode($v_comboItem);
}
/* API Test */
elseif ($v_dataSec == "appApiTest")
{
    $v_appData["teste_01"] = "test ok 01!";
    $v_appData["teste_02"] = "test ok 02!";
    $v_appData["teste_03"] = "test ok 03!";

    echo json_encode($v_appData);
}

/* API Not Found */
else
{
    header("HTTP/1.0 404 Not Found");
}
