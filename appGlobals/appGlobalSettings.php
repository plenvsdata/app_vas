<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 16/11/2017
 * Time: 23:14
 */
//error_reporting(E_ALL);

// Environment Settings
$g_envData = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/__envDataSettings__/__appEnvironmentData__.php");
$g_appEnv = $g_envData['envSetData'];
$g_appDevIP = $g_envData['devIP'][$g_envData['devIPset']];

// App Global Settings
$g_appRoot = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$g_appDocRoot = $_SERVER['DOCUMENT_ROOT'];
$g_appTitle = "Plenvs Data System";
$g_appIcon = "";
$g_appLanguage = "en";
$g_appHeaderLogo = "plenvsDataSystemAltType.svg";
$g_locale = $_SESSION['instanceLocale'] ?? 'pt_BR';
$g_userCurrencyCode = $_SESSION['userCurrencyCode'] ?? 'USD';
$g_currencySymbol = $_SESSION['instanceCurrencySymbol'] ?? '$';
$g_localeJS = isset($_SESSION['instanceLocale']) ? str_replace('_','-',$_SESSION['instanceLocale']) : 'en-US';

$g_currencyID = $_SESSION['currencyID'] ?? 3;//default BR
$g_userLocaleCountryID = $_SESSION['userLocaleCountryID'] ?? 3;//default BR

$g_user_locale = $_SESSION['userLocale'] ?? 'en_US';
$g_user_localeJS = isset($_SESSION['userLocale']) ? str_replace('_','-',$_SESSION['userLocale']) : 'en-US';
$g_user_moment = $_SESSION['userMomentJS'] ?? 'en';
$g_user_locale_CountryID = $_SESSION['userLocaleCountryID'] ?? 2;
$g_user_date_format = $_SESSION['dateFormat'] ?? '%Y-%m-%d';

//$g_locale = 'en_US'; //TODO Remover only for test
//$g_user_localeJS = 'en-US'; //TODO Remover only for test
//$g_localeJS = 'en-US'; //TODO Remover only for test
//$g_userCurrencyCode = 'BRL'; //TODO Remover only for test
//$g_user_localeJS = 'en-US'; //TODO Remover only for test
//$_SESSION['userLocale'] = 'en_US'; //TODO Remover only for test
setlocale(LC_MONETARY,$g_locale);

$g_maxSignUpTry = 3;
$g_userIP = ($g_appEnv == 'dev') ? $g_appDevIP : $_SERVER['REMOTE_ADDR'];
// App Default IDs
$g_appDefaultCountryID = 2; //USA
$g_appDefaultStateID = 1; //Not Available
$g_appDefaultCityID = 1; //Not Available


// Database Globals
$g_appDBPrefix = "vas";
$g_appDBTimeZone = $_SESSION['userTimeZone'] ?? 'America/Sao_Paulo';
$g_appDBGMT = $_SESSION['userGMT'] ?? '-03:00';
$g_appDBGMTOffset = $_SESSION['userGMTOffset'] ?? '-10800';

// MapBox Settings
$g_mapboxToken = 'pk.eyJ1Ijoib3JnYW5pa28iLCJhIjoiSFRRSTBPWSJ9.1eChtHvZF8f40XiQaCi07A';
$g_mapboxUrl = 'https://api.mapbox.com/geocoding/v5/mapbox.places/{{checkAddress}}.json?country={{countryCode}}&access_token={{mapboxToken}}';
$g_mapboxForwardUrl = 'https://api.mapbox.com/geocoding/v5/mapbox.places/{{checkAddress}}.json?access_token={{mapboxToken}}';

// Default Messages
$g_dropZoneDefaultMessage = "Drop file here to upload";

// Template Folder
$g_appTemplatePath = $GLOBALS['g_appRoot'].'/appSystemTemplate/';

// PHPMailer Data Default
$g_phpMailerDebug = 0;
$g_useSMTP = true; //true: real email; false: Use MailHog http://plenvs.test:8025/
$g_emailHostSettings = array('host' => 'mail.goabh.com', 'username' => 'plenvs@goabh.com', 'password' => 'E4f4n_k6','secure' => 'TLS', 'smtpAuth' => true, 'port' => 587);
$g_emailFrom = array('address' => 'plenvs@goabh.com', 'name' => 'Plenvs Data System');
$g_emailReplyTo = array('address' => 'plenvs@goabh.com', 'name' => 'Plenvs Data System');
$g_emailSubject = 'Welcome to the Plenvs Data System!';
$g_alternateTextBody = '';

// IPStack
$g_ipStackURL = 'https://api.ipstack.com/{{checkUserIP}}?access_key={{ipStackKey}}';
$g_ipStackAPIKey = '6cac277bcba0d3c568ba318b9e5b3be7';
$g_defaultCountryID = 2;

// Fixer.IO
    // Currency to Currency conversion
    $g_fixerIoConvertURL = 'https://data.fixer.io/api/convert?access_key={{fixerIoKey}}&from={{fromCurrency}}&to={{toCurrency}}&amount={{currencyValue}}&data={{convertDate}}';
    $g_fixerIoBaseConversionURL = 'https://data.fixer.io/api/latest?access_key={{fixerIoKey}}&base={{baseCurrency}}';
    $g_fixerIoAPIKey = '4f18e9e2d471007a51b630d878e51c7e';

// Hub do Desenvolvedor
    $g_hubTokenCNPJ = '106365475lQaEtgnBwM192039640';
    $g_hubCnpjURL = 'https://ws.hubdodesenvolvedor.com.br/v2/cnpj/?cnpj={{customerCNPJ}}&token={{hubToken}}';

// Page Control
$g_appPageData = array(
    "Companies" => "appCustomer/appCustomerList",
    "Company" => "appCustomer/appCustomerDetail",
    "Customers" => "appCustomer/appCustomerListBR",
    "Customer" => "appCustomer/appCustomerDetailBR",
    "Individuals" => "appIndividual/appIndividualList",
    "Individual" => "appIndividual/appIndividualDetail",
    "Contacts" => "appContact/appContactList",
    "Contact" => "appContact/appContactDetail",
    "Products" => "appProduct/appProductList",
    "Product" => "appProduct/appProductDetail",
    "Users" => "appUser/appUserList",
    "User" => "appUser/appUserDetail",
    "MyProfile" => "appUser/appUserProfile",
    "Opportunities" => "appOpportunity/appOpportunityList",
    "Businesses" => "appBusiness/appBusinessList",
    "Opportunity" => "appOpportunity/appOpportunityDetail",
    "Business" => "appBusiness/appBusinessDetail",
    "BusinessOpportunity" => "appBusiness/appBusinessOpportunity",
    "MileageControl" => "appReport/appMileageControl",
    "ExpenseReport" => "appReport/appExpenseReport",
    "ExpenseReportDetail" => "appReport/appExpenseReportDetail",
    "OpportunityGlobal" => "appReport/appOpportunityGlobalReport",
    "SalesGlobal" => "appReport/appSalesGlobalReport",
    "GlobalReports" => "appReport/appReportGlobal",
    "LovManagement" => "appLovManagement/appLovManagementList",
    "GlobalSettings" => "appGlobalSetting/appGlobalSettings",
    "ImportData" => "appImportData/appImportData",
    "ManageImportedData" => "appImportData/appManageImportedData",
    "CompaniesLocation" => "appMaps/appCompaniesMap",
    "ContactsLocation" => "appMaps/appContactsMap",
    "IndividualsLocation" => "appMaps/appIndividualsMap",
    "OpportunitiesLocation" => "appMaps/appOpportunitiesMap",
    "LayoutTest" => "appMaps/appLayoutMap",
    "Stages" => "appBusiness/appBusinessStage"
);

setlocale(LC_ALL,$g_locale.".UTF-8"); //ToDo: Ajustar itens para cada país