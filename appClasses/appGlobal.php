<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 28/09/2017
 * Time: 20:04
 */

$v_globalRoot = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$v_allClassesPath = $v_globalRoot.'/appClasses/';
//Lista de classes
require_once "appDBClass.php";
require_once "appSystemTools.php";
require_once "appUserControl.php";
require_once "appHomePage.php";
require_once "appUserData.php";
require_once "PHPMailer/src/Exception.php";
require_once "PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/src/SMTP.php";
require_once "appGetValue.php";
/*
require_once "appDBErrorCodes.php";

require_once "appCountry.php";
require_once "appCombo.php";
require_once "appLov.php";
require_once "appCustomer.php";
require_once "appProduct.php";
require_once "appDataList.php";
require_once "appPhoto.php";
require_once "appFile.php";
require_once "appRelationalData.php";
require_once "appSpec.php";
require_once "appReference.php";
require_once "appContact.php";
require_once "appGeoData.php";
require_once "appAddress.php";
require_once "appPhone.php";
require_once "appEmail.php";
require_once "appOpportunity.php";
require_once "appBusiness.php";
require_once "appSocial.php";
require_once "appFollowUp.php";
require_once "appTimeline.php";
require_once "appSaleItem.php";
require_once "appBusinessOpportunityItem.php";

require_once "appUpdateValue.php";
require_once "appWebsite.php";
require_once "appPrice.php";
require_once "appChart.php";
require_once "appReport.php";
require_once "appClientSignUp.php";
require_once "appDataImport.php";

require_once "PaypalExpress.php";
require_once "appWidgets.php";
require_once "appSetNullBatchID.php";
require_once "appDataLoader.php";
require_once "appGeoLocInterface.php";
require_once "appGeoLocCustomersData.php";
require_once "appGeoLocContactsData.php";
require_once "appAlert.php";
require_once "appExpense.php";
*/