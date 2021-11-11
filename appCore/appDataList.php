<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 21/01/2018
 * Time: 23:15
 */

namespace app\System\Lists;
use app\dbClass\appDBClass;

class appDataList
{
    private appDBClass $dbCon;

    public function __construct()
    {
        $this->dbCon = new appDBClass();
    }

    public function appCustomerList()
    {
        $query = "SELECT customer_id,customer_cnpj,customer_razao_social,customer_nome_fantasia,customer_token_in,customer_token_out,customer_phone,customer_email,allow_delete,customer_status,ok FROM %appDBprefix%_view_customer_list WHERE 1=1 ";
        $query.=" ORDER BY customer_nome_fantasia";
        return $this->dbCon->dbSelect($query);
    }

    public function appUserList()
    {
        $query = "SELECT user_id, user_login, user_pwd, user_name, user_nickname, user_phone, user_avatar, access_profile_id,customer_nome_fantasia, user_sess_id,user_status,status_desc,status_class,owner,created_at,created_by FROM %appDBprefix%_view_user  ";
        return $this->dbCon->dbSelect($query);
    }

    public function appSettingsUserList()
    {
        $query = "SELECT user_id, clnt, user_login, user_pwd, user_name, user_nickname, user_birthday, user_phone, user_avatar, user_sess_id,user_status,status_desc,status_class,owner,created_at,created_by FROM %appDBprefix%_view_settings_user_list WHERE clnt = '".$_SESSION['userClnt']."' ";
        return $this->dbCon->dbSelect($query);
    }

    public function appInstallationList()
    {
        $query = "SELECT installation_id,installation_desc,customer_id,customer_nome_fantasia,ninst,created_at,ok FROM %appDBprefix%_view_installation WHERE 1 = 1  ";

        if($_SESSION['checkCustomerID'] == true){
            $query .= " AND customer_id = '".$_SESSION['customerID']."'";
        }

        return $this->dbCon->dbSelect($query);
    }

    public function appCameraList($data = NULL)
    {
        $v_installationID = !empty($data['installationID']) ? $data['installationID'] : NULL;
        $query  = "SELECT obcon_camera_id,installation_id,installation_desc,customer_id,customer_nome_fantasia,cam,cam_desc,ninst,created_at,ok FROM %appDBprefix%_view_obcon_camera WHERE 1=1 ";
        if(!is_null($v_installationID))
        {
            $query .= " AND installation_id = '".$v_installationID."' ";
        }
        if($_SESSION['checkCustomerID'] == true){
            $query .= " AND customer_id = '".$_SESSION['customerID']."'";
        }
        return $this->dbCon->dbSelect($query);
    }

    public function appDashboardCameraList($data = NULL)
    {
        $v_installationID = !empty($data['installationID']) ? $data['installationID'] : NULL;
        $v_dashboardID = !empty($data['dashboardID']) ? $data['dashboardID'] : NULL;
        $query  = "SELECT dashboard_id,obcon_camera_id,installation_id,installation_desc,customer_id,customer_nome_fantasia,cam,cam_desc,ninst,created_at,ok FROM %appDBprefix%_view_dashboard_camera WHERE 1=1 ";
        if(!is_null($v_installationID))
        {
            $query .= " AND installation_id = '".$v_installationID."' AND ( dashboard_id = '".$v_dashboardID."' OR ISNULL( dashboard_id )) ";
        }
        if($_SESSION['checkCustomerID'] == true){
            $query .= " AND customer_id = '".$_SESSION['customerID']."'";
        }
        return $this->dbCon->dbSelect($query);
    }

    public function appDashboardLastEventList($data = NULL)
    {
        $v_dashboardID = !empty($data['dashboardID']) ? $data['dashboardID'] : NULL;
        $query  = "SELECT alarme_obcon_id,data,data_br,hora,cam,cam_desc,sent_desc FROM %appDBprefix%_view_report_obcon_data WHERE 1=1  ";
        $query .= " AND dashboard_id = '".$v_dashboardID."' AND data = '".date('Y-m-d')."' ORDER BY data DESC,hora DESC LIMIT 10";
        return $this->dbCon->dbSelect($query);
    }
    public function appDashboardLastDaysList($data = NULL)
    {
        $v_dashboardID = !empty($data['dashboardID']) ? $data['dashboardID'] : NULL;
        $query  = "SELECT count_data,data_br,entrada,saida,total_atual FROM %appDBprefix%_view_dashboard_obcon_count_by_day  ";
        $query .= " WHERE dashboard_id = '".$v_dashboardID."' ORDER BY count_data DESC";
        return $this->dbCon->dbSelect($query);
    }

    public function appDashboardList($data = NULL)
    {
        $v_dashboardID = !empty($data['dashboardID']) ? $data['dashboardID'] : NULL;
        $query = "SELECT dashboard_id,dashboard_desc,customer_id,customer_nome_fantasia,installation_id,installation_desc,ninst,created_at,ok FROM %appDBprefix%_view_obcon_dashboard WHERE 1=1 ";
        if(!is_null($v_dashboardID))
        {
            $query .= " AND dashboard_id = $v_dashboardID";
        }
        if($_SESSION['checkCustomerID'] == true){
            $query .= " AND customer_id = '".$_SESSION['customerID']."'";
        }
        return $this->dbCon->dbSelect($query);
    }

    public function appDashboardConfig()
    {
        $query = "SELECT dashboard_id,dashboard_desc,created_at,ok FROM %appDBprefix%_obcon_dashboard ";
        return $this->dbCon->dbSelect($query);
    }

    public function appAlarmeViperList($data = NULL)
    {
        $v_dataStart = !empty($data['dataStart']) ? $data['dataStart'] : NULL;
        $v_dataEnd = !empty($data['dataEnd']) ? $data['dataEnd'] : NULL;
        $query = "SELECT alarme_viper_id,customer_id,customer_nome_fantasia,ori,idr,nor,cod,dat,data_br,nuc,apl,ins,origem_id,origem_desc,subtipo_id,subtipo_desc,nsb,sbn,cor,ips,pos,alarme_viper_completo,alarme_status,created_at,updated_at,updated_by,ok FROM %appDBprefix%_view_alarme_viper_data WHERE 1=1 ";
        if(!is_null($v_dataStart) && !is_null($v_dataEnd))
        {
            $query .= " AND (dat BETWEEN '".$v_dataStart." 00:00:00' AND '".$v_dataEnd." 23:59:59') ";
        }
        if($_SESSION['checkCustomerID'] == true){
            $query .= " AND customer_id = '".$_SESSION['customerID']."'";
        }
        return $this->dbCon->dbSelect($query);
    }

    public function appAlarmeObconList($data = NULL)
    {
        $v_dataStart = !empty($data['dataStart']) ? $data['dataStart'] : NULL;
        $v_dataEnd = !empty($data['dataEnd']) ? $data['dataEnd'] : NULL;
        $query = "SELECT alarme_obcon_id,customer_id,customer_nome_fantasia,clid,ninst,data,data_br,hora,cam,tw,sent,numo,tama,alarme_obcon_completo,created_at,ok FROM %appDBprefix%_view_alarme_obcon_data WHERE 1=1 ";
        if(!is_null($v_dataStart) && !is_null($v_dataEnd))
        {
            $query .= " AND (data BETWEEN '".$v_dataStart."' AND '".$v_dataEnd."') ";
        }
        if($_SESSION['checkCustomerID'] == true){
            $query .= " AND customer_id = '".$_SESSION['customerID']."'";
        }
        return $this->dbCon->dbSelect($query);
    }

    public function appProductPhotoList($data)
    {
        $v_productID = !empty($data['productID']) ? $data['productID'] : NULL;
        $query = "SELECT clnt,photo_id,photo_type_id,photo_type_desc,photo,photo_original_name,photo_crc,photo_notes,photo_size,product_id,product_desc,product_type_id,product_type_desc,manufacturer_id,manufacturer_desc,product_category_id,product_category_desc,base_price,created_at,datetime_order,created_by,user_name,photo_status FROM %appDBprefix%_view_product_photo_list  WHERE product_id = $v_productID AND clnt = '".$_SESSION['userClnt']."' ORDER BY datetime_order DESC";
        return $this->dbCon->dbSelect($query);
    }

    public function appPhotoList($data):VOID
    {
        $v_productID = !empty($data['productID']) ? $data['productID'] : NULL;
        $query = "SELECT clnt,photo_id,photo_type_id,photo_type_desc,photo,photo_original_name,photo_crc,photo_type,photo_notes,photo_size,product_id,product_desc,product_type_id,product_type_desc,manufacturer_id,manufacturer_desc,product_category_id,product_category_desc,base_price,created_at,datetime_order,created_by,user_name,photo_status FROM %appDBprefix%_view_product_photo_list  WHERE product_id = $v_productID AND clnt = '".$_SESSION['userClnt']."' ORDER BY datetime_order DESC";
        $v_return['apiData'] = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    } //ToDO: Lista Geral de Photos da Instância

    public function appContactPhotoList($data):VOID
    {
        $v_contactID = !empty($data['contactID']) ? $data['contactID'] : NULL;
        $query = "SELECT photo_id,clnt,contact_id,title_id,title_desc,contact_name,contact_nickname,gender_id,gender_desc,contact_birthdate,contact_information,contact_status,photo_type_id,photo_type_desc,photo,photo_original_name,photo_crc,photo_extension,photo_mime,photo_notes,photo_size,created_at,datetime_order,created_by,user_name,photo_status,ok FROM %appDBprefix%_view_contact_photo_list  WHERE contact_id = $v_contactID AND clnt = '".$_SESSION['userClnt']."' ORDER BY datetime_order DESC";
        $v_return['apiData'] = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appFileList($data):VOID
    {
        $v_productID = !empty($data['productID']) ? $data['productID'] : NULL;
        $query = "SELECT clnt,photo_id,photo_type_id,photo_type_desc,photo,photo_original_name,photo_crc,photo_type,photo_notes,photo_size,product_id,product_desc,product_type_id,product_type_desc,manufacturer_id,manufacturer_desc,product_category_id,product_category_desc,base_price,created_at,datetime_order,created_by,user_name,photo_status FROM %appDBprefix%_view_product_photo_list  WHERE product_id = $v_productID AND clnt = '".$_SESSION['userClnt']."' ORDER BY datetime_order DESC";
        $v_return['apiData'] = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    } //ToDO: Lista Geral de Arquivos da Instância

    public function appProductSpecList($data):VOID
    {
        $v_productID = !empty($data['productID']) ? $data['productID'] : NULL;
        $query = "SELECT spec_id,clnt,product_id,product_desc,spec_type_id,spec_type_desc,spec_info,created_at,created_by,user_name,product_type_id,product_type_desc,manufacturer_id,manufacturer_desc,manufacturer_logo,product_category_id,product_category_desc,spec_status  FROM %appDBprefix%_view_product_spec WHERE product_id = $v_productID AND clnt = '".$_SESSION['userClnt']."'";
        $v_return = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appProductReferenceList($data):VOID
    {
        $v_productID = !empty($data['productID']) ? $data['productID'] : NULL;
        $query = "SELECT reference_id,clnt,product_id,product_desc,base_price,reference_info,reference_url,created_at,created_by,user_name,product_type_id,product_type_desc,manufacturer_id,manufacturer_desc,manufacturer_logo,product_category_id,product_category_desc,reference_status FROM %appDBprefix%_view_product_reference WHERE product_id = $v_productID AND clnt = '".$_SESSION['userClnt']."'";
        $v_return = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appContactList($customerID = null)
    {
        $v_where = "";
        if(!is_null($customerID))
        {
            $v_where = " AND customer_id = ".$customerID;
        }

        $query = "SELECT contact_id,customer_id,customer_name,clnt,title_id,title_desc,contact_name,contact_nickname,gender_id,gender_desc,contact_birthdate,contact_information,department_id,department_desc,position_id,position_desc,email_address,email_direct,email_type_id,email_type_desc,has_map,country_id,phone_direct,full_number,phone_area,phone_number,phone_type_id,phone_type_desc,phone_extension,created_at,created_by,user_name,contact_status FROM %appDBprefix%_view_contact_list WHERE clnt = '".$_SESSION['userClnt']."'".$v_where;
        return $this->dbCon->dbSelect($query);
    }

    public function appContactFileList($data)
    {
        $v_contactID = !empty($data['contactID']) ? $data['contactID'] : NULL;
        $query = "SELECT file_id,clnt,contact_id,file_type_id,file_type_desc,file,file_original_name,download_link,file_crc,file_extension,file_mime,file_notes,file_size,created_at,datetime_order,created_by,user_name,file_status  FROM %appDBprefix%_view_file_list  WHERE contact_id = $v_contactID AND clnt = '".$_SESSION['userClnt']."' ORDER BY datetime_order DESC";
        return $this->dbCon->dbSelect($query);
    }

    public function appCustomerFileList($data)
    {
        $v_customerID = !empty($data['customerID']) ? $data['customerID'] : NULL;
        $query = "SELECT file_id,clnt,customer_id,file_type_id,file_type_desc,file,file_original_name,download_link,file_crc,file_extension,file_mime,file_notes,file_size,created_at,datetime_order,created_by,user_name,file_status  FROM %appDBprefix%_view_file_list  WHERE customer_id = $v_customerID AND clnt = '".$_SESSION['userClnt']."' ORDER BY datetime_order DESC";
        return $this->dbCon->dbSelect($query);
    }

    public function appCustomerGroupFileList($data):VOID
    {
        $v_customerGroupID = !empty($data['customerGroupID']) ? $data['customerGroupID'] : NULL;
        $query = "SELECT file_id,clnt,customer_group_id,file_type_id,file_type_desc,file,file_original_name,download_link,file_crc,file_extension,file_mime,file_notes,file_size,created_at,datetime_order,created_by,user_name,file_status  FROM %appDBprefix%_view_file_list  WHERE customer_group_id = $v_customerGroupID AND clnt = '".$_SESSION['userClnt']."' ORDER BY datetime_order DESC";
        $v_return['apiData'] = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appCustomerMarketList($data):VOID
    {
        $v_customerID = !empty($data['customerID']) ? $data['customerID'] : NULL;
        $query = "SELECT clnt,customer_id,customer_group_id,customer_group_desc,customer_name,customer_nickname,customer_logo,more_information,market_id,market_desc,customer_status  FROM %appDBprefix%_view_customer_market_list  WHERE customer_id = $v_customerID AND clnt = '".$_SESSION['userClnt']."'";
        $v_return['apiData'] = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appCustomerGroupMarketList($data):VOID
    {
        $v_customerGroupID = !empty($data['customerGroupID']) ? $data['customerGroupID'] : NULL;
        $query = "SELECT clnt,customer_group_id,customer_group_desc,market_id,market_desc,customer_group_status  FROM %appDBprefix%_view_customer_group_market_list  WHERE customer_group_id = $v_customerGroupID AND clnt = '".$_SESSION['userClnt']."'";
        $v_return['apiData'] = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appContactAddressList()
    {
        $query = "SELECT clnt,address_id,contact_id,title_id,title_desc,contact_name,contact_nickname,gender_id,gender_desc,contact_birthdate,contact_information,contact_status,country_id,country_desc,country_code,country_capital,continent_id,continent_code,state_id,state_desc,state_code,city_id,city_desc,city_code,full_address,complement,zip_code,address_notes,lat,lng,created_at,created_by,user_name,address_status FROM %appDBprefix%_view_contact_address_list WHERE clnt = '".$_SESSION['userClnt']."'";
        $v_return['apiData'] = $this->dbCon->dbSelect($query);
        return $v_return;
    }

    public function appCustomerPhoneList($data):VOID
    {
        $v_customerID = !empty($data['customerID']) ? $data['customerID'] : NULL;
        $query = "SELECT phone_id,clnt,customer_id,customer_group_id,customer_group_desc,customer_name,customer_nickname,customer_logo,more_information,customer_status,phone_type_id,phone_type_desc,country_id,country_desc,country_phone_code,phone_area,phone_number,phone_extension,created_at,created_by,user_name,phone_status FROM %appDBprefix%_view_customer_phone_list  WHERE customer_id = $v_customerID AND clnt = '".$_SESSION['userClnt']."' ORDER BY customer_name DESC";
        $v_return['apiData'] = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appOpportunityList()
    {
        $query = 'SELECT opportunity_id,clnt,opportunity_sequence,opportunity_prefix,opportunity_code,opportunity_desc,opportunity_info,opportunity_type_id,opportunity_type_desc,owner_user_id,owner_user_name,owner_user_nickname,owner_user_avatar,customer_id,customer_type_id,title_id,customer_name,customer_nickname,customer_group_id,customer_group_desc,customer_city,source_id,source_desc,opportunity_stage_id,opportunity_stage_desc,opportunity_css,opportunity_init,opportunity_stage_color,opportunity_status,opportunity_stage_percentage,follow_ups_interval,follow_ups_int,total_expected_value,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(total_expected_value),total_expected_value,0.00),2,"{{userLocale}}")) AS total_expected_value_format,total_value,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(total_value),total_value,0.00),2,"{{userLocale}}")) AS total_value_format,total_pct,FORMAT(IF(NOT ISNULL(total_pct),total_pct,0.00),2,"{{userLocale}}") AS total_pct_format,total_quoted_value,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(total_quoted_value),total_quoted_value,0.00),2,"{{userLocale}}")) AS total_quoted_value_format,total_quoted_expected_value,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(total_quoted_expected_value),total_quoted_expected_value,0.00),2,"{{userLocale}}")) AS total_quoted_expected_value_format,total_quoted_pct,FORMAT(IF(NOT ISNULL(total_quoted_pct),total_quoted_pct,0.00),2,"{{userLocale}}") AS total_quoted_pct_format,total_sold_value,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(total_sold_value),total_sold_value,0.00),2,"{{userLocale}}")) AS total_sold_value_format,total_quoted_sold_value,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(total_quoted_sold_value),total_quoted_sold_value,0.00),2,"{{userLocale}}")) AS total_quoted_sold_value_format,FORMAT(IF ( NOT ISNULL( total_sold_pct ), total_sold_pct, 0.00 ),2,"{{userLocale}}") as total_sold_pct,CONCAT(FORMAT(IF(NOT ISNULL(total_sold_pct),total_sold_pct,0.00),2,"{{userLocale}}"),"%") AS total_sold_pct_format,probability_id,probability_desc,probability_color,preferred,sold_units,created_at,created_by,user_name,user_nickname,user_birthday,gender_id,user_avatar FROM %appDBprefix%_view_opportunity_list WHERE clnt = "'.$_SESSION['userClnt'].'" ORDER BY preferred DESC,opportunity_sequence ASC';
        $v_userLocaleNumber = ($_SESSION['userLocale'] == 'pt_BR') ? 'de_DE' : $_SESSION['userLocale'];
        $v_currencySymbol = $_SESSION['instanceCurrencySymbol'] ?? '$';
        $query = str_replace("{{userLocale}}",$v_userLocaleNumber,$query);
        $query = str_replace("{{currencySymbol}}",$v_currencySymbol,$query);
        return $this->dbCon->dbSelect($query);
    }

    public function appBusinessList($data = NULL)
    {
        $v_stageID = !empty($data['stageID']) ? $data['stageID'] : NULL;
        $query  = 'SELECT business_id,clnt,business_sequence,business_prefix,business_code,';
        $query .= 'business_desc,business_info,business_type_id,business_type_desc,owner_user_id,';
        $query .= 'owner_user_name,owner_user_nickname,owner_user_avatar,customer_id,customer_type_id,';
        $query .= 'title_id,customer_name,customer_nickname,customer_group_id,customer_group_desc,';
        $query .= 'customer_city,source_id,source_desc,business_stage_id,business_stage_desc,business_css,';
        $query .= 'business_init,business_stage_color,business_status,business_stage_percentage,';
        $query .= 'follow_ups_interval,follow_ups_int,total_opportunities,performance_factor,probability_id,';
        $query .= 'probability_desc,probability_color,preferred,created_at,created_by,user_name,';
        $query .= 'days_to_next_follow_up,user_nickname,user_birthday,gender_id,user_avatar ';
        $query .= 'FROM %appDBprefix%_view_business_list WHERE clnt = "'.$_SESSION['userClnt'].'" ';
        if($v_stageID != NULL){
            $query.= ' AND business_stage_id = "'.$v_stageID.'" ';
        }
        $query.= ' ORDER BY preferred DESC,business_sequence ASC';
        $v_userLocaleNumber = ($_SESSION['userLocale'] === 'pt_BR') ? 'de_DE' : $_SESSION['userLocale'];
        $v_currencySymbol = $_SESSION['instanceCurrencySymbol'] ?? '$';
        $query = str_replace("{{userLocale}}",$v_userLocaleNumber,$query);
        $query = str_replace("{{currencySymbol}}",$v_currencySymbol,$query);
        return $this->dbCon->dbSelect($query);
    }

    public function appSocialList()
    {
        $query = "SELECT social_id,clnt,social_type_id,social_address,created_at,created_by,user_name,social_type_desc,social_type_url,contact_id,title_id,title_desc,contact_name,contact_nickname,gender_id,gender_desc,contact_birthdate,contact_information,contact_status,customer_id,customer_group_id,customer_group_desc,customer_name,customer_nickname,customer_logo,more_information,customer_status,social_status FROM %appDBprefix%_view_social_list WHERE clnt = '".$_SESSION['userClnt']."'";
        $v_return['apiData'] = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appOpportunityFollowUpList($data)
    {
        $v_opportunityID = !empty($data['opportunityID']) ? $data['opportunityID'] : NULL;
        $v_limit = !empty($data['limit']) ? $data['limit'] : NULL;
        $v_offset = !empty($data['offset']) ? $data['offset'] : 0;
        $v_textSearch = !empty($data['textSearch']) ? $data['textSearch'] : '';
        $v_followUpTypeID = !empty($data['followUpTypeID']) ? $data['followUpTypeID'] : '';

        $query = "SELECT opportunity_id,clnt,effective,follow_up_id,follow_up_type_id,follow_up_type_desc,follow_up_icon,follow_up_info,created_at,days_since_last_followup,datetime,datetime_order,created_by,updated_by,user_name,user_avatar,follow_up_status FROM %appDBprefix%_view_opportunity_follow_up_list WHERE opportunity_id = ".$v_opportunityID." AND clnt = '".$_SESSION['userClnt']."' ";
        if($v_textSearch != ''){
            $query.= " AND (follow_up_info LIKE '%".$v_textSearch."%' OR user_name LIKE '%".$v_textSearch."%')";
        }
        if($v_followUpTypeID != ''){
            $query.= " AND follow_up_type_id = '".$v_followUpTypeID."' ";
        }

        $query.= " ORDER BY follow_up_id DESC";

        if($v_limit != NULL){
            $query.= " LIMIT $v_limit OFFSET $v_offset";
        }
        $v_return = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appBusinessFollowUpList($data)
    {
        $v_businessID = !empty($data['businessID']) ? $data['businessID'] : NULL;
        $v_businessOpportunityID = !empty($data['businessOpportunityID']) ? $data['businessOpportunityID'] : NULL;
        $v_limit = !empty($data['limit']) ? $data['limit'] : NULL;
        $v_offset = !empty($data['offset']) ? $data['offset'] : 0;
        $v_followUpTypeID = !empty($data['followUpTypeID']) ? $data['followUpTypeID'] : '';

        $query = "SELECT business_id,business_opportunity_id,clnt,effective,follow_up_id,follow_up_type_id,follow_up_type_desc,follow_up_icon,follow_up_info,created_at,days_since_last_followup,datetime,datetime_order,created_by,updated_by,user_name,user_avatar,follow_up_status FROM %appDBprefix%_view_business_follow_up_list WHERE clnt = '".$_SESSION['userClnt']."' ";
        if($v_businessID != ''){
            $query.= " AND business_id = ".$v_businessID." ";
        }elseif($v_businessOpportunityID != ''){
            $query.= " AND business_opportunity_id = ".$v_businessOpportunityID." ";
        }
        if($v_followUpTypeID != ''){
            $query.= " AND follow_up_type_id = '".$v_followUpTypeID."' ";
        }

        if($v_followUpTypeID != ''){
            $query.= " AND follow_up_type_id = '".$v_followUpTypeID."' ";
        }

        $query.= " ORDER BY follow_up_id DESC";

        if($v_limit != NULL){
            $query.= " LIMIT $v_limit OFFSET $v_offset";
        }
        $v_return = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appOpportunitySaleItemList($data = NULL)
    {
        if(is_null($data))
        {
            $query = 'SELECT opportunity_id,opportunity_sequence,clnt,item_id,product_id,base_price_id,quoted_price_id,product_type_id,product_type_desc,probability_id,probability_desc,manufacturer_id,manufacturer_desc,manufacturer_logo,product_category_id,product_category_desc,product_desc,part_number,item_info,base_price,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(base_price),base_price,0.00),2,"{{userLocale}}")) AS base_price_format,quoted_units,expected_value,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(expected_value),expected_value,0.00),2,"{{userLocale}}")) AS expected_value_format,free,quoted_price,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(quoted_price),quoted_price,0.00),2,"{{userLocale}}")) AS quoted_price_format,quoted_value,sold_price,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(sold_price),sold_price,0.00),2,"{{userLocale}}")) AS sold_price_format,sold_units,sold_value,total_item_value,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(total_item_value),total_item_value,0.00),2,"{{userLocale}}")) AS total_item_value_format,total_item_profit,total_item_profit_pct,FORMAT(IF(NOT ISNULL(total_item_profit_pct),total_item_profit_pct,0.00),2,"{{userLocale}}") AS total_item_profit_pct_format,item_stage_id,item_stage_desc,item_css,total_item_profit_color,total_item_profit_symbol,sold_date,sold_date_order,opportunity_type_id,opportunity_prefix,opportunity_code,opportunity_desc,opportunity_info,opportunity_type_desc,customer_id,source_id,opportunity_stage_id,opportunity_stage_desc,opportunity_status,offer_type_id,alternative_product_id,created_at,created_at_order,created_by,user_name,user_nickname,user_avatar,item_status FROM %appDBprefix%_view_opportunity_sale_item_list WHERE clnt = "'.$_SESSION['userClnt'].'" ORDER BY product_desc';
            $v_userLocaleNumber = ($_SESSION['userLocale'] === 'pt_BR') ? 'de_DE' : $_SESSION['userLocale'];
        }else
        {
            $v_opportunityID = !empty($data['opportunityID']) ? $data['opportunityID'] : NULL;
            $v_manufacturerID = !empty($data['manufacturerID']) ? $data['manufacturerID'] : NULL;
            $query = 'SELECT opportunity_id,opportunity_sequence,clnt,item_id,product_id,base_price_id,quoted_price_id,product_type_id,product_type_desc,probability_id,probability_desc,manufacturer_id,manufacturer_desc,manufacturer_logo,product_category_id,product_category_desc,product_desc,part_number,item_info,base_price,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(base_price),base_price,0.00),2,"{{userLocale}}")) AS base_price_format,quoted_units,expected_value,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(expected_value),expected_value,0.00),2,"{{userLocale}}")) AS expected_value_format,free,quoted_price,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(quoted_price),quoted_price,0.00),2,"{{userLocale}}")) AS quoted_price_format,quoted_value,sold_price,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(sold_price),sold_price,0.00),2,"{{userLocale}}")) AS sold_price_format,sold_units,sold_value,total_item_value,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(total_item_value),total_item_value,0.00),2,"{{userLocale}}")) AS total_item_value_format,total_item_profit,total_item_profit_pct,FORMAT(IF(NOT ISNULL(total_item_profit_pct),total_item_profit_pct,0.00),2,"{{userLocale}}") AS total_item_profit_pct_format,item_stage_id,item_stage_desc,item_css,total_item_profit_color,total_item_profit_symbol,sold_date,sold_date_order,opportunity_type_id,opportunity_prefix,opportunity_code,opportunity_desc,opportunity_info,opportunity_type_desc,customer_id,source_id,opportunity_stage_id,opportunity_stage_desc,opportunity_status,offer_type_id,alternative_product_id,created_at,created_at_order,created_by,user_name,user_nickname,user_avatar,item_status FROM %appDBprefix%_view_opportunity_sale_item_list WHERE opportunity_id = "'.$v_opportunityID.'" AND manufacturer_id = "'.$v_manufacturerID.'"  AND clnt = "'.$_SESSION['userClnt'].'" ORDER BY product_desc';
            $v_userLocaleNumber = ($_SESSION['userLocale'] == 'pt_BR') ? 'de_DE' : $_SESSION['userLocale'];
        }
        $v_currencySymbol = $_SESSION['instanceCurrencySymbol'] ?? '$';
        $query = str_replace("{{userLocale}}",$v_userLocaleNumber,$query);
        $query = str_replace("{{currencySymbol}}",$v_currencySymbol,$query);
        return $this->dbCon->dbSelect($query);
    }

    public function appBusinessOpportunityItemList($data = NULL)
    {
        if(is_null($data))
        {
            $query = 'SELECT item_id,clnt,business_opportunity_id,opportunity_desc,opportunity_info,business_id,business_stage_id,business_sequence,business_desc,product_id,product_desc,product_category_id,product_type_id,product_type_desc,manufacturer_id,manufacturer_desc,currency_id,currency_desc,currency_symbol,currency_code,currency_css,part_number,alternative_product_id,probability_id,probability_desc,estimate_id,item_info,quoted_units,item_stage_id,offer_type_id,created_at,created_at_order,created_at_date,created_by,user_name,user_nickname,item_status,item_stage_desc,item_css FROM %appDBprefix%_view_business_opportunity_item_list WHERE clnt = "'.$_SESSION['userClnt'].'" ORDER BY product_desc';
            $v_userLocaleNumber = ($_SESSION['userLocale'] == 'pt_BR') ? 'de_DE' : $_SESSION['userLocale'];
            $v_currencySymbol = $_SESSION['instanceCurrencySymbol'] ?? '$';
            $query = str_replace("{{userLocale}}",$v_userLocaleNumber,$query);
            $query = str_replace("{{currencySymbol}}",$v_currencySymbol,$query);
        }else
        {
            $v_businessOpportunityID = !empty($data['businessOpportunityID']) ? $data['businessOpportunityID'] : NULL;
            $query = 'SELECT item_id,clnt,business_opportunity_id,opportunity_desc,opportunity_info,business_id,business_stage_id,business_sequence,business_desc,product_id,product_desc,product_category_id,product_type_id,product_type_desc,manufacturer_id,manufacturer_desc,currency_id,currency_desc,currency_symbol,currency_code,currency_css,part_number,alternative_product_id,probability_id,probability_desc,estimate_id,item_info,quoted_units,item_stage_id,offer_type_id,created_at,created_at_order,created_at_date,created_by,user_name,user_nickname,item_status,item_stage_desc,item_css FROM %appDBprefix%_view_business_opportunity_item_list WHERE clnt = "'.$_SESSION['userClnt'].'" AND business_opportunity_id =  "'.$v_businessOpportunityID.'" ORDER BY product_desc';
        }
        return $this->dbCon->dbSelect($query);
    }

    public function appOpportunityContactList($data):VOID
    {
        $v_opportunityID = !empty($data['opportunityID']) ? $data['opportunityID'] : NULL;
        $query = "SELECT opportunity_id,opportunity_sequence,clnt,contact_id,customer_id,customer_name,title_id,title_desc,contact_name,contact_nickname,gender_id,gender_desc,contact_birthdate,contact_information,department_id,department_desc,position_id,position_desc,contact_status,phone_country_id,phone_direct,phone_area,phone_number,phone_type_id,phone_type_desc,phone_extension,full_phone,full_phone_link,email_address,email_direct,email_type_id,email_type_desc,address_id,address_main,country_id,country_desc,country_code,country_capital,country_phone_code,zipcode_mask,phone_mask,state_id,state_desc,state_code,city_id,city_desc,city_code,full_address,complement,zip_code,address_notes,lat,lng,google_maps_embed,address_status,created_at,created_by,user_name FROM %appDBprefix%_view_opportunity_contact_list WHERE opportunity_id = ".$v_opportunityID." AND clnt = '".$_SESSION['userClnt']."'";
        $v_return = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appBusinessContactList($data):VOID
    {
        $v_businessID = !empty($data['businessID']) ? $data['businessID'] : NULL;
        $query = "SELECT business_id,business_sequence,clnt,contact_id,customer_id,customer_name,title_id,title_desc,contact_name,contact_nickname,gender_id,gender_desc,contact_birthdate,contact_information,department_id,department_desc,position_id,position_desc,contact_status,phone_country_id,phone_direct,phone_area,phone_number,phone_type_id,phone_type_desc,phone_extension,full_phone,full_phone_link,email_address,email_direct,email_type_id,email_type_desc,address_id,address_main,country_id,country_desc,country_code,country_capital,country_phone_code,zipcode_mask,phone_mask,state_id,state_desc,state_code,city_id,city_desc,city_code,full_address,complement,zip_code,address_notes,lat,lng,google_maps_embed,address_status,created_at,created_by,user_name FROM %appDBprefix%_view_business_contact_list WHERE business_id = ".$v_businessID." AND clnt = '".$_SESSION['userClnt']."'";
        $v_return = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appBusinessOpportunityContactList($data):VOID
    {
        $v_businessID = !empty($data['businessID']) ? $data['businessID'] : NULL;
        $v_businessOpportunityID = !empty($data['businessOpportunityID']) ? $data['businessOpportunityID'] : NULL;
        $v_contactID = !empty($data['contactID']) ? $data['contactID'] : NULL;

        $query = "SELECT business_opportunity_id,business_opportunity_sequence,clnt,business_id, business_sequence, contact_id,customer_id,customer_name, probability_id,probability_desc, opportunity_stage_desc, opportunity_stage_color, opportunity_css, manufacturer_id, manufacturer_desc,product_category_id,product_category_desc,title_id,title_desc,contact_name,contact_nickname,gender_id,gender_desc,contact_birthdate,contact_information,department_id,department_desc,position_id,position_desc,contact_status,phone_country_id,phone_direct,phone_area,phone_number,phone_type_id,phone_type_desc,phone_extension,full_phone,full_phone_link,email_address,email_direct,email_type_id,email_type_desc,address_id,address_main,country_id,country_desc,country_code,country_capital,country_phone_code,zipcode_mask,phone_mask,state_id,state_desc,state_code,city_id,city_desc,city_code,full_address,complement,zip_code,address_notes,lat,lng,google_maps_embed,address_status,created_at,created_by,user_name, COUNT(business_opportunity_id) AS total_opportunity FROM %appDBprefix%_view_business_opportunity_contact_list WHERE ";
        if($v_businessID){
            $query.= " business_id = ".$v_businessID." ";
        }elseif ($v_businessOpportunityID){
            $query.= " business_opportunity_id = ".$v_businessOpportunityID." ";
        }
        $query.= " AND clnt = '".$_SESSION['userClnt']."' ";
        if($v_contactID){
            $query.= " AND contact_id = '".$v_contactID."' GROUP BY business_opportunity_id";
        }else{
            $query.= " GROUP BY contact_id";
        }

        $v_return = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appOpportunityFileList($data)
    {
        $v_opportunityID = !empty($data['opportunityID']) ? $data['opportunityID'] : NULL;
        $query = "SELECT file_id,clnt,opportunity_id,file_type_id,file_type_desc,file,file_original_name,download_link,file_crc,file_extension,file_mime,file_notes,file_size,created_at,datetime_order,created_by,user_name,file_status  FROM %appDBprefix%_view_file_list  WHERE opportunity_id = $v_opportunityID AND clnt = '".$_SESSION['userClnt']."' ORDER BY datetime_order DESC";
        $v_return = $this->dbCon->dbSelect($query);
        return $v_return;
    }

    public function appBusinessOpportunityFileList($data)
    {
        $v_businessOpportunityID = !empty($data['businessOpportunityID']) ? $data['businessOpportunityID'] : NULL;
        $query = "SELECT file_id,clnt,business_opportunity_id,file_type_id,file_type_desc,file,file_original_name,download_link,file_crc,file_extension,file_mime,file_notes,file_size,created_at,datetime_order,created_by,user_name,file_status  FROM %appDBprefix%_view_file_list  WHERE business_opportunity_id = $v_businessOpportunityID AND clnt = '".$_SESSION['userClnt']."' ORDER BY datetime_order DESC";
        $v_return = $this->dbCon->dbSelect($query);
        return $v_return;
    }

    public function appBusinessFileList($data)
    {
        $v_businessID = !empty($data['businessID']) ? $data['businessID'] : NULL;
        $query = "SELECT file_id,clnt,business_id,file_type_id,file_type_desc,file,file_original_name,download_link,file_crc,file_extension,file_mime,file_notes,file_size,created_at,datetime_order,created_by,user_name,file_status  FROM %appDBprefix%_view_file_list  WHERE business_id = $v_businessID AND clnt = '".$_SESSION['userClnt']."' ORDER BY datetime_order DESC";
        $v_return = $this->dbCon->dbSelect($query);
        return $v_return;
    }

    public function appEstimateFileList($data)
    {
        $v_businessOpportunityID = !empty($data['businessOpportunityID']) ? $data['businessOpportunityID'] : NULL;
        $query = "SELECT estimate_id,clnt,currency_id,currency_desc,currency_symbol,currency_code,currency_format,currency_locale,currency_css,client_code,main,business_opportunity_id,sale_type,manufacturer_id,sale_type_desc,estimate_file_name,estimate_code,revision,last_revision,additional_information,estimate_item_array,estimate_currency_id,estimate_value,expected_sale_value,expected_sale_value_conversion,estimate_stage_id,estimate_stage_desc,estimate_stage_color,estimate_stage_css,estimate_currency_symbol,estimate_currency_code,conversion_currency_id,estimate_currency_group,conversion_estimate_value,conversion_estimate_symbol,conversion_currency_group,today_conversion_value,today_expected_conversion_value,file_id,file_type_id,file_type_desc,file,file_original_name,download_link,file_crc,file_extension,file_mime,file_notes,file_size,datetime_order,sharepoint_sync,sharepoint_sync_date,created_at,created_by,created_by_user_name,updated_by,updated_by_user_name,uploaded_at,uploaded_by_user_name,estimate_status,ok FROM %appDBprefix%_view_estimate_file_list  WHERE business_opportunity_id = $v_businessOpportunityID AND clnt = '".$_SESSION['userClnt']."' ORDER BY estimate_id DESC";
        return $this->dbCon->dbSelect($query);
    }

    public function appCustomerWebsiteList($data):VOID
    {
        $v_customerID = !empty($data['customerID']) ? $data['customerID'] : NULL;
        $query = "SELECT customer_id,website_id,website_type_id,website_type_desc,website_url,created_at,created_by,user_name,website_status FROM %appDBprefix%_view_website_list WHERE customer_id = ".$v_customerID." AND clnt = '".$_SESSION['userClnt']."'";
        $v_return['apiData'] = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appOpportunityQuoteItemList($data = NULL)
    {
        if(is_null($data))
        {
            $query = 'SELECT quoted_price_id, clnt,product_id,product_desc,base_price_id,base_price,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(base_price),base_price,0.00),2,"{{userLocale}}")) AS base_price_format,part_number,opportunity_id,business_id,item_id,quoted_price,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(quoted_price),quoted_price,0.00),2,"{{userLocale}}")) AS quoted_price_format,quoted_units,free,created_at,created_by,user_name,quoted_price_status FROM %appDBprefix%_view_quoted_price WHERE clnt = "'.$_SESSION['userClnt'].'" ORDER BY created_at DESC';
            // Para que o formato numérico no Brasil for: x.xxx.xxx,xx usar o 'de_DE'
            $v_userLocaleNumber = ($_SESSION['userLocale'] == 'pt_BR') ? 'de_DE' : $_SESSION['userLocale'];
            $v_currencySymbol = $_SESSION['instanceCurrencySymbol'] ?? '$';
            $query = str_replace("{{userLocale}}",$v_userLocaleNumber,$query);
            $query = str_replace("{{currencySymbol}}",$v_currencySymbol,$query);
            $v_return = $this->dbCon->dbSelect($query);
            return $v_return;
        }else
        {
            $v_itemID = !empty($data['itemID']) ? $data['itemID'] : NULL;
            $query = 'SELECT quoted_price_id, clnt,product_id,product_desc,base_price_id,base_price,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(base_price),base_price,0.00),2,"{{userLocale}}")) AS base_price_format,part_number,opportunity_id,business_id,item_id,quoted_price,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(quoted_price),quoted_price,0.00),2,"{{userLocale}}")) AS quoted_price_format,quoted_units,free,created_at,created_by,user_name,quoted_price_status FROM %appDBprefix%_view_quoted_price WHERE item_id = "'.$v_itemID.'" AND clnt = "'.$_SESSION['userClnt'].'" ORDER BY created_at DESC';
            // Para que o formato numérico no Brasil for: x.xxx.xxx,xx usar o 'de_DE'
            $v_userLocaleNumber = ($_SESSION['userLocale'] == 'pt_BR') ? 'de_DE' : $_SESSION['userLocale'];
            $v_currencySymbol = $_SESSION['instanceCurrencySymbol'] ?? '$';
            $query = str_replace("{{userLocale}}",$v_userLocaleNumber,$query);
            $query = str_replace("{{currencySymbol}}",$v_currencySymbol,$query);
            $v_return = $this->dbCon->dbSelect($query);
            return $v_return;
        }
    }

    public function appBusinessQuoteItemList($data = NULL)
    {
        if(is_null($data))
        {
            $query = 'SELECT quoted_price_id, clnt,product_id,product_desc,base_price_id,base_price,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(base_price),base_price,0.00),2,"{{userLocale}}")) AS base_price_format,part_number,business_id,item_id,quoted_price,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(quoted_price),quoted_price,0.00),2,"{{userLocale}}")) AS quoted_price_format,quoted_units,free,created_at,created_by,user_name,quoted_price_status FROM %appDBprefix%_view_quoted_price WHERE clnt = "'.$_SESSION['userClnt'].'" ORDER BY created_at DESC';
            // Para que o formato numérico no Brasil for: x.xxx.xxx,xx usar o 'de_DE'
            $v_userLocaleNumber = ($_SESSION['userLocale'] == 'pt_BR') ? 'de_DE' : $_SESSION['userLocale'];
            $v_currencySymbol = $_SESSION['instanceCurrencySymbol'] ?? '$';
            $query = str_replace("{{userLocale}}",$v_userLocaleNumber,$query);
            $query = str_replace("{{currencySymbol}}",$v_currencySymbol,$query);
            $v_return = $this->dbCon->dbSelect($query);
            return $v_return;
        }else
        {
            $v_itemID = !empty($data['itemID']) ? $data['itemID'] : NULL;
            $query = 'SELECT quoted_price_id, clnt,product_id,product_desc,base_price_id,base_price,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(base_price),base_price,0.00),2,"{{userLocale}}")) AS base_price_format,part_number,business_id,item_id,quoted_price,CONCAT("{{currencySymbol}}",FORMAT(IF(NOT ISNULL(quoted_price),quoted_price,0.00),2,"{{userLocale}}")) AS quoted_price_format,quoted_units,free,created_at,created_by,user_name,quoted_price_status FROM %appDBprefix%_view_quoted_price WHERE item_id = "'.$v_itemID.'" AND clnt = "'.$_SESSION['userClnt'].'" ORDER BY created_at DESC';
            // Para que o formato numérico no Brasil for: x.xxx.xxx,xx usar o 'de_DE'
            $v_userLocaleNumber = ($_SESSION['userLocale'] == 'pt_BR') ? 'de_DE' : $_SESSION['userLocale'];
            $v_currencySymbol = $_SESSION['instanceCurrencySymbol'] ?? '$';
            $query = str_replace("{{userLocale}}",$v_userLocaleNumber,$query);
            $query = str_replace("{{currencySymbol}}",$v_currencySymbol,$query);
            $v_return = $this->dbCon->dbSelect($query);
            return $v_return;
        }
    }

    public function appCustomerAddressList(){
        $query = "SELECT address_id,contact_id,customer_id,user_id,clnt,address_main,country_id,country_desc,country_code,country_capital,state_id,state_desc,state_code,city_id,city_desc,city_code,full_address,complement,zip_code,address_notes,address_google,lat,lng,created_at,created_by,address_status FROM %appDBprefix%_view_address_list WHERE clnt = '".$_SESSION['userClnt']."'";
        $v_return = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }

    public function appLovList($lovID = null)
    {
        $v_where = "";
        if(!is_null($lovID))
        {
            $v_where = " AND lov_id = ".$lovID;
        }

        $query = "SELECT lov_id,lov_desc,lov_table,lov_view,field_id,field_desc,field_data,field_code,language_id,lov_status,ok FROM %appDBprefix%_system_lov_list WHERE 1=1 ".$v_where." ORDER BY lov_order ASC";
        return $this->dbCon->dbSelect($query);
    }

    public function appBusinessOpportunityList($data = NULL){
        $v_businessID = !empty($data['businessID']) ? $data['businessID'] : NULL;
        $query = "SELECT business_opportunity_id, business_opportunity_sequence, clnt, product_category_id, product_category_desc, manufacturer_id, manufacturer_desc, sale_type_desc, business_id, business_desc,	business_sequence, customer_id, customer_name, customer_nickname, owner_id, owner_user_nickname, customer_group_desc, probability_id,probability_desc,probability_color,probability_icon, opportunity_desc, business_stage_id, business_stage_desc,business_css,business_stage_color,currency_symbol,opportunity_estimate_value,opportunity_sold_value,opportunity_total_value,total_opportunity_pct,outstanding_quotes_array,overall_income_array,last_effective_follow_up,days_to_next_follow_up,created_at, created_by, opportunity_status, ok  FROM %appDBprefix%_view_business_opportunity_list WHERE business_id = '".$v_businessID."' AND clnt = '".$_SESSION['userClnt']."'";
        return $this->dbCon->dbSelect($query);
    }

    public function appOpportunityStageList($data = NULL){
        $v_stageID = !empty($data['stageID']) ? $data['stageID'] : NULL;
        $query = "SELECT business_opportunity_id, business_opportunity_sequence, clnt, product_category_id, product_category_desc, manufacturer_id, manufacturer_desc, sale_type_desc, business_id, business_desc,	business_sequence, customer_id, customer_name, customer_nickname, owner_id, owner_user_nickname, customer_group_desc, probability_id,probability_desc,probability_color,probability_icon, opportunity_desc, business_stage_id, business_stage_desc,business_css,business_stage_color,currency_symbol,opportunity_estimate_value,opportunity_sold_value,opportunity_total_value,total_opportunity_pct,outstanding_quotes_array,overall_income_array,last_effective_follow_up,days_to_next_follow_up,created_at, created_by, opportunity_status, ok  FROM %appDBprefix%_view_business_opportunity_list WHERE clnt = '".$_SESSION['userClnt']."' ";
        if($v_stageID){
            $query.= " AND business_stage_id = '".$v_stageID."' ";
        }else{
            $query.= " AND (business_stage_id <= '3' OR business_stage_id = '12') ";
        }
        $v_return = $this->dbCon->dbSelect($query);
        return $v_return;
    }

    public function appManufacturerByCategoryList($data = NULL)
    {
        $v_categoryID = !empty($data['categoryID']) ? $data['categoryID'] : NULL;
        $v_type = !empty($data['type']) ? $data['type'] : NULL;
        $query  = "SELECT clnt, manufacturer_id, manufacturer_desc FROM %appDBprefix%_view_product_list ";
        $query .= "WHERE product_category_id = '".$v_categoryID."' AND ( clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ";
        $query .= "GROUP BY manufacturer_id ORDER BY clnt ASC, manufacturer_desc ASC";
        $v_return = $this->dbCon->dbSelect($query);

        if($v_type === "json")
        {
            echo json_encode($v_return['rsData']);
            return null;
        }
            return $v_return;
    }

    public function appExpenseList()
    {
        $query  = "SELECT expense_id,clnt,expense_year,expense_month,expense_month_desc,expense_stage_id,expense_stage_desc,";
        $query .= "expense_stage_class,total_value,allow_delete,created_at,created_by,user_name,ok ";
        $query .= "FROM %appDBprefix%_view_expense_list WHERE clnt = '".$_SESSION['userClnt']."' ";
        if($_SESSION['accessProfileID'] > 2) { //ToDo:Melhorar controle de Perfis de Acesso
            $query .= "AND owner_user_id = '".$_SESSION['userID']."'";
        }
        $query.=" ORDER BY expense_id";
        return $this->dbCon->dbSelect($query);
    }

    public function appExpenseItemList($data = NULL){
        $v_expenseID = !empty($data['expenseID']) ? $data['expenseID'] : NULL;
        $query ='SELECT expense_item_id,clnt,expense_id,expense_type_id,expense_type_desc,expense_date,DATE_FORMAT(expense_date,"'.$_SESSION['dateFormat'].'") AS expense_date_format, opportunity_id, invoice, paid_to,additional_information,expense_additional_info, expense_value, CONCAT("{{currencySymbol}}",';
        $query.=' FORMAT(IF(NOT ISNULL(expense_value),expense_value,0.00),2,"{{userLocale}}")) AS expense_value_format,mileage_address_id,mileage_distance_informed,mileage_distance_calculated,created_by,created_at,';
        $query.=' expense_item_status, ok FROM %appDBprefix%_view_expense_item_list WHERE expense_id = "'.$v_expenseID.'" AND clnt = "'.$_SESSION['userClnt'].'" ';
        // Para que o formato numérico no Brasil for: x.xxx.xxx,xx usar o 'de_DE'
        $v_userLocaleNumber = ($_SESSION['userLocale'] == 'pt_BR') ? 'de_DE' : $_SESSION['userLocale'];
        $v_currencySymbol = $_SESSION['instanceCurrencySymbol'] ?? '$';
        $query = str_replace("{{userLocale}}",$v_userLocaleNumber,$query);
        $query = str_replace("{{currencySymbol}}",$v_currencySymbol.' ',$query);
        return $this->dbCon->dbSelect($query);
    }

    public function appExpenseNotesList($data)
    {
        $v_expenseID = !empty($data['expenseID']) ? $data['expenseID'] : NULL;
        $v_limit = !empty($data['limit']) ? $data['limit'] : NULL;
        $v_offset = !empty($data['offset']) ? $data['offset'] : 0;
        $v_textSearch = !empty($data['textSearch']) ? $data['textSearch'] : '';

        $query = "SELECT expense_notes_id,clnt,expense_id,expense_notes_info,created_at,created_by,updated_by,user_name,expense_notes_status FROM %appDBprefix%_view_expense_notes_list WHERE expense_id = ".$v_expenseID." AND clnt = '".$_SESSION['userClnt']."' ";
        if($v_textSearch != ''){
            $query.= " AND (expense_notes_info LIKE '%".$v_textSearch."%' OR user_name LIKE '%".$v_textSearch."%')";
        }
        $query.= " ORDER BY expense_notes_id DESC";

        if($v_limit != NULL){
            $query.= " LIMIT $v_limit OFFSET $v_offset";
        }
        //print $query;die();
        $v_return = $this->dbCon->dbSelect($query);
        echo json_encode($v_return);
    }
}