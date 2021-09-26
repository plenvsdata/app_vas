<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 19/01/2018
 * Time: 11:05
 */

namespace app\System\Combo;
use app\dbClass\appDBClass;

class appCombo
{
    private $dbCon;

    public function __construct()
    {
        $this->dbCon = new appDBClass();
    }

    public function comboSystemAllUserList($type=NULL)
    {
        $query = "SELECT user_id,user_login,user_name,user_nickname,user_phone,user_avatar,user_status,created_at,created_by FROM %appDBprefix%_view_user WHERE first_access = 0 ORDER BY user_name ASC";
        $v_return = $this->dbCon->dbSelect($query);

        if(is_null($type))
        {
            return json_encode($v_return);
        }
        else
        {
            return $v_return;
        }
    }

    public function comboCustomer($type=NULL)
    {
        $query = "SELECT customer_id,customer_nome_fantasia,customer_razao_social FROM %appDBprefix%_customer_data WHERE 1=1 ORDER BY customer_nome_fantasia ASC";
        $v_return = $this->dbCon->dbSelect($query);

        if(is_null($type))
        {
            return json_encode($v_return);
        }
        else
        {
            return $v_return;
        }
    }

    public function comboNinst($data=NULL)
    {
        $query = "SELECT ninst_id,ninst,customer_id,customer_raz FROM %appDBprefix%_view_combo_obcon_ninst WHERE 1=1 AND customer_id = '".$data['customerID']."' ORDER BY customer_nome_fantasia ASC";
        $v_return = $this->dbCon->dbSelect($query);

        if(is_null($data['type']))
        {
            return json_encode($v_return);
        }
        else
        {
            return $v_return;
        }
    }

    public function comboInstallation($data=NULL)
    {

        $query = "SELECT installation_id,customer_id,customer_nome_fantasia,ninst,installation_desc FROM %appDBprefix%_view_installation WHERE installation_status = 1 AND customer_id = '".$data['customerID']."' ORDER BY customer_nome_fantasia ASC";
        return $this->dbCon->dbSelect($query);
    }

    public function comboSystemAccessProfile($type=NULL)
    {
        $query = "SELECT access_profile_id, access_profile_desc, access_profile_status FROM %appDBprefix%_lov_system_access_profile ORDER BY access_profile_desc ASC";
        $v_return = $this->dbCon->dbSelect($query);

        if(is_null($type))
        {
            return json_encode($v_return);
        }
        else
        {
            return $v_return;
        }
    }
    /*
        public function comboManufacturer($type = NULL,$alwaysDisplay = 0)
        {
            if($alwaysDisplay ==  true){
                $v_alwaysDisplay = " AND FIND_IN_SET(always_display,'0,1') ";
            }else{
                $v_alwaysDisplay = " ";
            }
            $query = "SELECT manufacturer_id, clnt, manufacturer_desc, manufacturer_logo, created_at, created_by, manufacturer_status FROM %appDBprefix%_view_combo_manufacturer WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ".$v_alwaysDisplay." ORDER BY clnt ASC, always_display ASC, manufacturer_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            if(is_null($type))
            {
                return $v_return;
            }
            elseif($type == "json")
            {
                echo json_encode($v_return['apiData']);
            }
        }

        public function comboCustomerGroup()
        {
            $query = "SELECT customer_group_id,clnt,customer_group_desc,created_at,created_by,user_name,customer_group_status FROM %appDBprefix%_view_customer_group_list WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, customer_group_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
           echo json_encode($v_return);
        }

        public function comboProductType($type = NULL)
        {
            $query = "SELECT product_type_id, clnt, product_type_desc, created_at, created_by, product_type_status FROM %appDBprefix%_view_combo_product_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, product_type_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            if(is_null($type))
            {
                return $v_return;
            }
            elseif($type == "json")
            {
                echo json_encode($v_return['apiData']);
            }
        }
        public function comboPhotoType()
        {
            $query = "SELECT photo_type_id, clnt, photo_type_desc, created_at, created_by, photo_type_status FROM %appDBprefix%_view_combo_photo_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, photo_type_desc ASC";
            $v_return = $this->dbCon->dbSelect($query);
            return json_encode($v_return);
        }
        public function comboSpecType()
        {
            $query = "SELECT spec_type_id, clnt, spec_type_desc, created_at, created_by, spec_type_status FROM %appDBprefix%_view_combo_spec_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, spec_type_desc ASC";
            $v_return = $this->dbCon->dbSelect($query);
            return json_encode($v_return);
        }
        public function comboProductCategory($type = NULL)
        {
            $query = "SELECT product_category_id, clnt, product_category_desc, created_at, created_by, product_category_status FROM %appDBprefix%_view_combo_product_category WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, product_category_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            if(is_null($type))
            {
                return $v_return;
            }
            elseif($type == "json")
            {
                echo json_encode($v_return['apiData']);
            }
        }
        public function comboOpportunityType()
        {
            $query = "SELECT opportunity_type_id, clnt, opportunity_type_desc, created_at, created_by, opportunity_type_status FROM %appDBprefix%_lov_opportunity_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, opportunity_type_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            return json_encode($v_return);
        }
        public function comboBusinessType()
        {
            $query = "SELECT business_type_id, clnt, business_type_desc, created_at, created_by, business_type_status FROM %appDBprefix%_lov_business_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, business_type_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            return json_encode($v_return);
        }
        public function comboTimelineType():VOID
        {
            $query = "SELECT timeline_type_id, clnt, timeline_type_desc, created_at, created_by, timeline_type_status FROM %appDBprefix%_lov_timeline_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, timeline_type_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            echo json_encode($v_return);
        }
        public function comboSource($type = NULL)
        {
            $query = "SELECT source_id, source_desc, created_at, created_by, source_status FROM %appDBprefix%_lov_source WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, source_desc ASC";
            $v_return = $this->dbCon->dbSelect($query);
            if($type == 'json')
            {
                echo json_encode($v_return);
            }
            else
            {
                return $v_return;
            }
        }
        public function comboFollowUpType($type = NULL)
        {
            $query = "SELECT follow_up_type_id, clnt, follow_up_type_desc, follow_up_icon, created_at, created_by, follow_up_type_status FROM %appDBprefix%_view_combo_follow_up_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, follow_up_type_id ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            if($type == NULL || $type == 'json')
            {
                echo json_encode($v_return);
            }
            else
            {
                return $v_return;
            }
        }
        public function comboReasonType($type = NULL)
        {
            $query = "SELECT reason_type_id, clnt, reason_type_desc, reason_type_status FROM %appDBprefix%_lov_reason_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY reason_type_id";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            if($type == NULL || $type == 'json')
            {
                echo json_encode($v_return);
            }
            else
            {
                return $v_return;
            }
        }
        public function comboSystemAlertType():VOID

        {
            $query = "SELECT alert_type_id, alert_type_desc, alert_type_status FROM %appDBprefix%_view_combo_system_alert_type ORDER BY alert_type_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            echo json_encode($v_return);
        }
        public function comboSystemContinent($data = null)
        {
            if(is_null($data))
            {
                $query = "SELECT continent_id,continent_code,continent_desc,continent_status FROM %appDBprefix%_view_combo_system_continent ORDER BY continent_desc ASC";
                $v_return['apiData'] = $this->dbCon->dbSelect($query);
                echo json_encode($v_return);
            }
            else
            {
                $query = "SELECT continent_id,continent_code,continent_desc,continent_status FROM %appDBprefix%_view_combo_system_continent WHERE continent_id = ".$data['continentID'];
                $v_return['apiData'] = $this->dbCon->dbSelect($query);
                return $v_return['apiData']['rsData'];
            }
        }
        public function comboSystemCountry($data = NULL,$type = NULL, $notAvailable=false)
        {
            if(is_null($data))
            {
                $query = "SELECT country_id,country_desc,country_code,country_capital,country_phone_code,zipcode_mask,phone_mask,continent_id,continent_desc,locale,country_status FROM %appDBprefix%_view_combo_system_country WHERE 1=1 AND ";
                if($notAvailable == false)
                {
                    $query .= " country_id > 1 ";
                }
                else
                {
                    $query .= " country_id > 0 ";
                }
            }
            else
            {
                $v_whereField = !empty($data['countryField']) ? $data['countryField'] : 'country_id';
                $v_valueField = !empty($data['countryID']) ? $data['countryID'] : $data['countryValue'];

                $query = "SELECT country_id,country_desc,country_code,country_capital,country_phone_code,zipcode_mask,phone_mask,continent_id,continent_desc,locale,country_status FROM %appDBprefix%_view_combo_system_country WHERE 1=1 AND ".$v_whereField." = '".$v_valueField."'";
            }

            $query .= " ORDER BY country_desc,continent_desc ASC";
            $v_return = $this->dbCon->dbSelect($query);

            if($type == NULL || $type == 'json')
            {
               echo json_encode($v_return);
            }
            else
            {
                return $v_return;
            }

        }
        public function comboSystemState($data = null)
        {
            if(is_null($data))
            {
                $query = "SELECT state_id,state_desc,state_code,country_id,country_desc,country_code,country_phone_code,zipcode_mask,phone_mask,country_capital,continent_id,continent_desc,state_status FROM %appDBprefix%_view_combo_system_state ORDER BY state_desc,country_desc,continent_desc ASC";
                $v_return = $this->dbCon->dbSelect($query);
                return json_encode($v_return);
            }
            else
            {
                if(isset($data['countryID']))
                {
                    $query = "SELECT state_id,state_desc,state_code,country_id,country_desc,country_code,country_phone_code,zipcode_mask,phone_mask,country_capital,continent_id,continent_desc,state_status FROM %appDBprefix%_view_combo_system_state WHERE country_id = ".$data['countryID']." ORDER BY state_desc,country_desc,continent_desc ASC";
                }else
                {
                    $query = "SELECT state_id,state_desc,state_code,country_id,country_desc,country_code,country_phone_code,zipcode_mask,phone_mask,country_capital,continent_id,continent_desc,state_status FROM %appDBprefix%_view_combo_system_state WHERE state_id = ".$data['stateID']." ORDER BY state_desc,country_desc,continent_desc ASC";
                }

                $v_return = $this->dbCon->dbSelect($query);
                return json_encode($v_return);
            }
        }
        public function comboSystemCity($data = null)
        {
            if(is_null($data))
            {
                $query = "SELECT city_id,city_desc,city_code,state_id,state_desc,state_code,country_id,country_desc,country_code,country_capital,continent_id,continent_desc,city_status FROM %appDBprefix%_view_combo_system_city ORDER BY city_desc,state_desc,country_desc,continent_desc ASC";
                $v_return = $this->dbCon->dbSelect($query);
                return json_encode($v_return);
            }
            else
            {
                if(isset($data['stateID']))
                {
                    $query = "SELECT city_id,city_desc,city_code,state_id,state_desc,state_code,country_id,country_desc,country_code,country_capital,continent_id,continent_desc,city_status FROM %appDBprefix%_view_combo_system_city WHERE state_id = ".$data['stateID']." ORDER BY city_desc,state_desc,country_desc,continent_desc ASC";
                }else
                {
                    $query = "SELECT city_id,city_desc,city_code,state_id,state_desc,state_code,country_id,country_desc,country_code,country_capital,continent_id,continent_desc,city_status FROM %appDBprefix%_view_combo_system_city WHERE city_id = ".$data['cityID']." ORDER BY city_desc,state_desc,country_desc,continent_desc ASC";
                }
                $v_return = $this->dbCon->dbSelect($query);
                return json_encode($v_return);
            }
        }
        public function comboSystemCurrency($data = null)
        {
            $v_reqMethod = $data['method'];
            $type = !empty($data['type']) ? $data['type'] : NULL;
            if ($v_reqMethod === "UPDATECURRENCY"){

                $v_currency_id = !empty($data['currencyID']) ? trim($data['currencyID']) : NULL;
                $v_currency_symbol = !empty($data['currencySymbol']) ? trim($data['currencySymbol']) : '$';

                if(is_null($v_currency_id))
                {
                    $v_return['status'] = false;
                }
                else
                {
                    $query = "UPDATE %appDBprefix%_client_instance SET currency_id = '".$v_currency_id."' WHERE clnt = '".$_SESSION['userClnt']."' ";
                    $v_return['data'] = $this->dbCon->dbUpdate($query);
                    $v_return['status'] = true;
                    $_SESSION['currencyID'] = $v_currency_id;
                    $_SESSION['instanceCurrencySymbol'] = $v_currency_symbol;
                }
                if($data['type']=='json'){
                    echo json_encode($v_return);
                }else{
                    return $v_return;
                }

            }
            elseif($v_reqMethod === "COMBOCURRENCY"){

                $query = "SELECT currency_id, currency_desc, currency_symbol ,currency_code, currency_format,exchange_rate,exchange_rate_update,exchange_rate_update_timestamp, currency_status FROM %appDBprefix%_view_combo_system_currency ORDER BY currency_desc ASC";
                $v_return = $this->dbCon->dbSelect($query);
                if($type == 'json')
                {
                    echo json_encode($v_return);
                }
                else
                {
                    return $v_return;
                }
            }
            elseif($v_reqMethod === "GET"){

                $query = "SELECT currency_id, currency_desc, currency_symbol, currency_format, currency_code,exchange_rate, value_km FROM %appDBprefix%_view_client_instance WHERE clnt = '".$_SESSION['userClnt']."' ";
                $v_return = $this->dbCon->dbSelect($query);
                if($type == 'json')
                {
                    echo json_encode($v_return);
                }
                else
                {
                    return $v_return;
                }
            }
            elseif ($v_reqMethod === "UPDATEKM"){

                $v_value_km = !empty($data['valueKm']) ? trim($data['valueKm']) : NULL;

                if(is_null($v_value_km))
                {
                    $v_return['status'] = false;
                }
                else
                {
                    $query = "UPDATE %appDBprefix%_client_instance SET value_km = '".$v_value_km."' WHERE clnt = '".$_SESSION['userClnt']."' ";
                    $v_return['data'] = $this->dbCon->dbUpdate($query);
                    $v_return['status'] = true;
                }
                if($data['type']=='json'){
                    echo json_encode($v_return);
                }else{
                    return $v_return;
                }

            }
        }
        public function comboSystemFeature():VOID
        {
            $query = "SELECT feature_id, feature_desc, feature_content_page, feature_status FROM %appDBprefix%_view_combo_system_feature ORDER BY feature_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            echo json_encode($v_return);
        }
        public function comboSystemGender($type = NULL,$orderBy='gender_desc',$notAvailable=true,$notApplicable=true)
        {
            $query = "SELECT gender_id, gender_desc, gender_status FROM %appDBprefix%_view_combo_system_gender WHERE 1=1 ";
            if ($notAvailable == false) {
                $query .= " AND gender_id <> 1 ";
            }

            if ($notApplicable == false)
            {
                $query .= " AND gender_id <> 2 ";
            }
            $query .= " ORDER BY ".$orderBy." ASC";
            $v_return = $this->dbCon->dbSelect($query);
            if(is_null($type))
            {
                return json_encode($v_return);
            }
            elseif($type == "json")
            {
                echo json_encode($v_return);
            }

        }
        public function comboSystemLanguage():VOID
        {
            $query = "SELECT language_id, language_desc, language_file, language_path, language_status FROM %appDBprefix%_view_combo_system_language ORDER BY language_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            echo json_encode($v_return);
        }

        public function comboSystemMeasureSystem($data = NULL)
        {
            $v_reqMethod = $data['method'];
            $type = $data['type'];
            if($v_reqMethod=='COMBO'){
                $query = "SELECT measure_system_id, measure_system_desc, measure_system_list, measure_system_status FROM %appDBprefix%_lov_system_measure_system ORDER BY measure_system_desc ASC";
                $v_return = $this->dbCon->dbSelect($query);
                if($type == 'json')
                {
                    echo json_encode($v_return);
                }else
                {
                    return $v_return;
                }
            }elseif($v_reqMethod=='GET'){
                $query = "SELECT measure_system_id,measure_system_desc,measure_system_list FROM %appDBprefix%_view_client_instance  WHERE clnt = '".$_SESSION['userClnt']."' ";
                $v_return = $this->dbCon->dbSelect($query);
                if($type == 'json')
                {
                    echo json_encode($v_return);
                }else
                {
                    return $v_return;
                }
            }elseif($v_reqMethod=='POST'){
                $query = "UPDATE %appDBprefix%_client_instance SET measure_system_id = ".$data['measureSystemID']." WHERE clnt = '".$_SESSION['userClnt']."'";
                $this->dbCon->dbUpdate($query);
                $v_return['status'] = true;
                if($type == 'json')
                {
                    echo json_encode($v_return);
                }else
                {
                    return $v_return;
                }
            }

        }
        public function comboSystemMeasure():VOID
        {
            $query = "SELECT measure_id, measure_desc, measure_symbol, measure_status FROM %appDBprefix%_view_combo_system_measure ORDER BY measure_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            echo json_encode($v_return);
        }
        public function comboSystemPlan():VOID
        {
            $query = "SELECT plan_id, plan_desc, plan_information, plan_max_users, plan_max_storage, plan_price, plan_started_date, plan_end_date, plan_status FROM %appDBprefix%_view_combo_system_plan ORDER BY plan_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            echo json_encode($v_return);
        }
        public function comboSystemOpportunityStage($type = NULL)
        {
            $query = "SELECT opportunity_stage_id,opportunity_stage_desc,opportunity_css,opportunity_stage_percentage,opportunity_stage_color,opportunity_stage_status FROM %appDBprefix%_view_combo_system_opportunity_stage ORDER BY opportunity_stage_id ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            if($type == 'json')
            {
                echo json_encode($v_return);
            }
            else
            {
                return $v_return;
            }
        }
        public function comboSystemBusinessStage($type = NULL)
        {
            $query = "SELECT business_stage_id,business_stage_desc,business_css,business_stage_percentage,business_stage_color,business_stage_status FROM %appDBprefix%_view_combo_system_business_stage ORDER BY business_stage_id ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            if($type == 'json')
            {
                echo json_encode($v_return);
            }
            else
            {
                return $v_return;
            }
        }

        public function comboSystemBusinessOpportunityStage($data = NULL)
        {
            $v_businessOpportunityID = !empty($data['businessOpportunityID']) ? $data['businessOpportunityID'] : '';
            $type = !empty($data['type']) ? $data['type'] : '';
            $v_userAdmin = 0;
            $v_arrayCheck = array(1,2);//-1sysop,2admin
            $v_accessProfileID = $_SESSION['accessProfileID'];
            if(in_array($v_accessProfileID, $v_arrayCheck)){
                $v_userAdmin = 1;
            }

            $queryProcedure = "CALL getBusinessOpportunityStageCombo('".$_SESSION['userClnt']."',".$v_businessOpportunityID.",".$v_userAdmin.")";
            $v_return = $this->dbCon->dbProcedure($queryProcedure);

            if($type == 'json')
            {
                echo $v_return['rsData'][0]['business_stage_combo'];
            }
            else
            {
                return $v_return;
            }
        }
        public function comboProbability($type = 'json')
        {
            $query = "SELECT probability_id,probability_desc,probability_color, probability_icon, created_at,	created_by,	probability_status,	ok,	clnt FROM %appDBprefix%_lov_probability WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') AND ok = '1' ";
            $v_return = $this->dbCon->dbSelect($query);
            if($type == 'json')
            {
                echo json_encode($v_return);
            }
            else
            {
                return $v_return;
            }
        }
        public function comboOfferType($type = 'json')
        {
            $query = "SELECT offer_type_id, offer_type_desc, offer_type_status, ok FROM %appDBprefix%_lov_system_offer_type WHERE ok = '1' ";
            $v_return = $this->dbCon->dbSelect($query);
            if($type == 'json')
            {
                echo json_encode($v_return);
            }
            else
            {
                return $v_return;
            }
        }
        public function comboSystemReportList($type = NULL)
        {
            $query = "SELECT report_list_id,report_id,clnt,client_desc,language_id,language_desc,report_desc,created_at,created_by,user_login,user_name,report_status FROM %appDBprefix%_view_combo_report WHERE 1=1 AND (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') AND report_status = 1 AND ok = 1 ORDER BY report_id ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            if(is_null($type))
            {
                return json_encode($v_return);
            }
            else
            {
                return $v_return;
            }
        }
        public function comboSystemPeriodType():VOID
        {
            $query = "SELECT period_id,period_desc,period_number,period_status FROM %appDBprefix%_view_combo_system_period_type ORDER BY period_id ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            echo json_encode($v_return);
        }
        public function comboSystemOpportunityStageInit($type = NULL)
        {
            $query = "SELECT opportunity_stage_id,opportunity_stage_desc,opportunity_css,opportunity_stage_percentage,opportunity_stage_color,opportunity_stage_status FROM %appDBprefix%_view_combo_system_opportunity_stage_initial ORDER BY opportunity_stage_id ASC";
            $v_return = $this->dbCon->dbSelect($query);
            if($type == 'json')
            {
                echo json_encode($v_return);
            }
            else
            {
                return $v_return;
            }
        }
        public function comboSystemBusinessStageInit($type = NULL)
        {
            $query = "SELECT business_stage_id,business_stage_desc,business_css,business_stage_percentage,business_stage_color,business_stage_status FROM %appDBprefix%_view_combo_system_business_stage_initial ORDER BY business_stage_id ASC";
            $v_return = $this->dbCon->dbSelect($query);
            if($type == 'json')
            {
                echo json_encode($v_return);
            }
            else
            {
                return $v_return;
            }
        }
        public function comboSystemUserList($type='json',$userID=NULL)
        {
            $query = "SELECT user_id,user_login,user_name,user_nickname,user_birthday,gender_id,user_phone,user_avatar,country_id,state_id,city_id,user_status,created_at,created_by FROM %appDBprefix%_view_user_list ";
            $query .=" WHERE clnt = '".$_SESSION['userClnt']."' AND user_status = '2' ";
            if($userID!=NULL){
                $query .= " AND user_id <> '".$userID."' ";
            }
            $query .=" ORDER BY user_name ASC";
            $v_return = $this->dbCon->dbSelect($query);
            if($type=='json')
            {
                return json_encode($v_return);
            }
            else
            {
                return $v_return;
            }
            return json_encode($v_return);
        }

        public function comboSystemSocial($type=NUll)
        {
            $query = "SELECT social_id, social_desc, social_url,social_icon, social_status FROM %appDBprefix%_view_combo_system_social_type ORDER BY social_desc ASC";
            $v_return = $this->dbCon->dbSelect($query);
            if(is_null($type))
            {
                echo json_encode($v_return);
            }
            else
            {
                return $v_return;
            }

        }
        public function comboSystemTheme():VOID
        {
            $query = "SELECT theme_id, theme_desc, theme_path, theme_status FROM %appDBprefix%_view_combo_system_theme ORDER BY theme_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            echo json_encode($v_return);
        }
        public function comboAddressType():VOID
        {
            $query = "SELECT address_type_id, address_type_desc FROM %appDBprefix%_view_combo_address_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, address_type_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            echo json_encode($v_return);
        }
        public function comboContactType():VOID
        {
            $query = "SELECT contact_type_id, clnt, contact_type_desc, created_at, created_by, contact_type_status FROM %appDBprefix%_view_combo_contact_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, contact_type_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            echo json_encode($v_return);
        }
        public function comboEmailType()
        {
            $query = "SELECT email_type_id, clnt, email_type_desc, created_at, created_by, email_type_status FROM %appDBprefix%_view_combo_email_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, email_type_desc ASC";
            $v_return = $this->dbCon->dbSelect($query);
            echo json_encode($v_return);
        }
        public function comboSystemImportType($type=NULL)
        {
            $query = "SELECT import_type_id, import_type_desc, file, default_separator,file_types, import_type_status FROM %appDBprefix%_view_combo_system_import_type ORDER BY import_type_id ASC";
            $v_return = $this->dbCon->dbSelect($query);

            if(is_null($type))
            {
                return json_encode($v_return);
            }
            else
            {
                return $v_return;
            }
        }
        public function comboFileType($type = NULL)
        {
            $query = "SELECT file_type_id, clnt, file_type_desc, created_at, created_by, file_type_status FROM %appDBprefix%_view_combo_file_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, file_type_desc ASC";
            $v_return = $this->dbCon->dbSelect($query);
            if(is_null($type))
            {
                return $v_return;
            }
            elseif($type == "json")
            {
                echo json_encode($v_return);
            }
        }
        public function comboPhoneType($type = 'json')
        {
            $query = "SELECT phone_type_id, clnt, phone_type_desc, created_at, created_by, phone_type_status FROM %appDBprefix%_view_combo_phone_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, phone_type_desc ASC";
            $v_return = $this->dbCon->dbSelect($query);
            if($type == 'json'){
                echo json_encode($v_return);
            }elseif($type == 'array'){
                return $v_return;
            }

        }
        public function comboWebsiteType()
        {
            $query = "SELECT website_type_id, website_type_desc, website_type_status FROM %appDBprefix%_view_combo_website_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, website_type_desc ASC";
            $v_return = $this->dbCon->dbSelect($query);
            return json_encode($v_return);
        }
        public function comboMarket()
        {
            $query = "SELECT market_id, clnt, market_desc, created_at, created_by, market_status FROM %appDBprefix%_view_combo_market WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, market_desc ASC";
            $v_return = $this->dbCon->dbSelect($query);
            echo json_encode($v_return);
        }
        public function comboPosition($data = null)
        {
            if(is_null($data)){
                $query = "SELECT position_id, clnt,customer_id,customer_name, position_desc, created_at, created_by, user_name, position_status FROM %appDBprefix%_view_combo_position WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, position_desc ASC";
            }else
            {
                $query = "SELECT position_id, clnt,customer_id,customer_name, position_desc, created_at, created_by, user_name, position_status FROM %appDBprefix%_view_combo_position WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') AND (customer_id = '1' OR customer_id = '".$data['customerID']."') ORDER BY clnt ASC, position_desc ASC";
            }
            $v_return = $this->dbCon->dbSelect($query);
            return json_encode($v_return);
        }
        public function comboDepartment($data = null)
        {
            if(is_null($data)){
                $query = "SELECT department_id, clnt,customer_id,customer_name, department_desc, created_at, created_by, user_name, department_status FROM %appDBprefix%_view_combo_department WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, department_desc ASC";
            }else
            {
                $query = "SELECT department_id, clnt,customer_id,customer_name, department_desc, created_at, created_by, user_name, department_status FROM %appDBprefix%_view_combo_department WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') AND (customer_id = '0' OR customer_id = '".$data['customerID']."') ORDER BY clnt ASC, department_desc ASC";
            }

            $v_return = $this->dbCon->dbSelect($query);
            return json_encode($v_return);
        }
        public function comboSystemTitle($type = NULL)
        {
            $query = "SELECT title_id, title_desc, title_status FROM %appDBprefix%_view_combo_system_title ORDER BY title_id ASC";
            $v_return = $this->dbCon->dbSelect($query);
            if(is_null($type))
            {
                return $v_return;
            }
            elseif($type == "json")
            {
                echo json_encode($v_return);
            }
        }
        public function comboSystemSaleType($type = NULL)
        {
            $query = "SELECT sale_type_id,sale_type_desc,sale_type_code FROM %appDBprefix%_lov_system_sale_type ORDER BY sale_type_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            if($type == 'json')
            {
                echo json_encode($v_return);
            }
            else
            {
                return $v_return;
            }
        }
        public function reportOpportunityGlobalCreatedDate()
        {
            $query = "SELECT created_at_date FROM %appDBprefix%_view_report_opportunity_global WHERE clnt = '".$_SESSION['userClnt']."' ORDER BY created_at_date LIMIT 1";
            $v_return = $this->dbCon->dbSelect($query);
            return $v_return['rsData'][0]['created_at_date'];
        }
        public function reportBusinessGlobalCreatedDate()
        {
            $query = "SELECT created_at_date FROM %appDBprefix%_view_report_business_global WHERE clnt = '".$_SESSION['userClnt']."' ORDER BY created_at_date LIMIT 1";
            $v_return = $this->dbCon->dbSelect($query);
            return $v_return['rsData'][0]['created_at_date'];
        }
        public function reportSalesGlobalCreatedDate()
        {
            $query = "SELECT created_at_date FROM %appDBprefix%_view_report_sales_global WHERE clnt = '".$_SESSION['userClnt']."' ORDER BY created_at_date LIMIT 1";
            $v_return = $this->dbCon->dbSelect($query);
            return $v_return['rsData'][0]['created_at_date'];
        }
        public function reportTypeContactCreatedDate()
        {
            $query = "SELECT created_at_date FROM %appDBprefix%_view_opportunity_follow_up_list WHERE clnt = '".$_SESSION['userClnt']."' ORDER BY created_at_date LIMIT 1";
            $v_return = $this->dbCon->dbSelect($query);
            return $v_return['rsData'][0]['created_at_date'];
        }
        public function comboSystemUserProfile():VOID
        {
            $query = "SELECT access_profile_id,access_profile_desc,access_profile_status FROM %appDBprefix%_view_combo_system_access_profile WHERE access_profile_id > 1 ORDER BY access_profile_id DESC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            echo json_encode($v_return);
        }
        public function comboItemStatus($data = NULL)
        {
            $v_reqMethod = $data['method'];

            if ($v_reqMethod === "PUT")
            {
                $v_item_id = !empty($data['itemID']) ? trim($data['itemID']) : NULL;
                $v_item_stage_id = !empty($data['itemStageID']) ? trim($data['itemStageID']) : NULL;

                if(is_null($v_item_id) || is_null($v_item_stage_id))
                {
                    $v_return['status'] = false;
                }
                else
                {
                    $query = "UPDATE %appDBprefix%_sale_item_data SET item_stage_id = '".$v_item_stage_id."' WHERE clnt = '".$_SESSION['userClnt']."' AND item_id = '".$v_item_id."' ";
                    $v_return['data'] = $this->dbCon->dbUpdate($query);
                    $v_return['status'] = true;

                }
                if($data['type']=='json'){
                    echo json_encode($v_return);
                }else{
                    return $v_return;
                }
            }
            elseif ($v_reqMethod === "STATUS")
            {
                $v_productCategoryID = !empty($data['productCategoryID']) ? $data['productCategoryID'] : NULL;

                if(empty($v_productCategoryID))
                {
                    $v_return['apiData']['status'] = false;
                    echo json_encode($v_return);
                }
                else
                {
                    $query = "UPDATE %appDBprefix%_lov_product_category SET product_category_status = ".$data['productCategoryStatus']." WHERE clnt = '".$_SESSION['userClnt']."' AND product_category_id = ".$v_productCategoryID;
                    $v_return['apiData'] = $this->dbCon->dbUpdate($query);
                    $v_return['apiData']['status'] = true;
                    echo json_encode($v_return);
                }
            }
            elseif ($v_reqMethod === "GET")
            {
                $v_item_stage_id = !empty($data['itemStageID']) ? $data['itemStageID'] : NULL;
                if($v_item_stage_id==1||$v_item_stage_id==2||$v_item_stage_id==4){
                    $v_item_stage_id_allowed = '1,2,4,5';
                }

                if(is_null($v_item_stage_id))
                {

                    $v_return['status'] = false;
                }
                else
                {
                    $query = "SELECT item_stage_id, item_stage_desc, item_stage_color, item_css, item_stage_status FROM %appDBprefix%_lov_system_item_stage WHERE ok = 1 AND FIND_IN_SET(item_stage_id,'".$v_item_stage_id_allowed."')";
                    $v_rsSelect = $this->dbCon->dbSelect($query);
                    $v_return['data'] = $v_rsSelect['rsData'];
                    $v_return['status'] = true;
                }

                if($data['type']=='json'){
                    echo json_encode($v_return);
                }else{
                    return $v_return;
                }
            }
            elseif ($v_reqMethod === "DELETE")
            {
                $v_productCategoryID = !empty($data['productCategoryID']) ? $data['productCategoryID'] : NULL;
                if(is_null($v_productCategoryID) || empty($v_productCategoryID))
                {
                    $v_return['apiData']['status'] = false;
                    echo json_encode($v_return);
                }
                else
                {
                    $query = "DELETE FROM %appDBprefix%_lov_product_category WHERE product_category_id = $v_productCategoryID AND clnt = '".$_SESSION['userClnt']."'";
                    $v_return['apiData'] = $this->dbCon->dbDelete($query);
                    $v_return['apiData']['status'] = true;
                    echo json_encode($v_return);
                }
            }
            else
            {
                header("HTTP/1.0 204 No Content");
            }

        }
        public function comboExpenseType($type = NULL)
        {
            $query = "SELECT expense_type_id, clnt, expense_type_desc, additional_information, created_at, created_by, expense_type_status,ok FROM %appDBprefix%_lov_expense_type WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, expense_type_desc ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            if(is_null($type))
            {
                return $v_return;
            }
            elseif($type == "json")
            {
                echo json_encode($v_return);
            }
        }
        public function comboExpenseOpportunity($type = NULL)
        {
            $query = "SELECT business_opportunity_id, business_opportunity_sequence_format, opportunity_dropdown FROM %appDBprefix%_view_business_opportunity_list WHERE  clnt = '".$_SESSION['userClnt']."' ORDER BY opportunity_dropdown ASC";
            $v_return['apiData'] = $this->dbCon->dbSelect($query);
            if(is_null($type))
            {
                return $v_return;
            }
            elseif($type == "json")
            {
                echo json_encode($v_return);
            }
        }
        public function comboCustomerPosition($data = null)
        {
            $query = "SELECT customer_id, address_id, clnt, customer_name, customer_nickname, lat, lng FROM %appDBprefix%_view_combo_customer_position WHERE (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ORDER BY clnt ASC, customer_nickname ASC";
            $v_return = $this->dbCon->dbSelect($query);
            return $v_return;
        }
    */
}




