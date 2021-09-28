<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 30/01/2018
 * Time: 21:44
 */

namespace app\System\API;

use app\dbClass\appDBClass;

class appDataAPI
{
    private $dbCon;

    public function __construct()
    {
        $this->dbCon = new appDBClass();
    }

    public function appCustomerLicenceData($data = NULL)
    {
        $v_customerID = !empty($data['customerID']) ? $data['customerID'] : NULL;

        if(empty($v_customerID) || !isset($data['customerID']) )
        {
            $v_return['customer_status'] = 0;
            return $v_return;
        }
        else
        {
            $query = "SELECT customer_licence_status as customer_status FROM %appDBprefix%_customer_data WHERE customer_id = '".addslashes($v_customerID)."'";
            $v_return = $this->dbCon->dbSelect($query);
            return $v_return['rsData'][0];
        }
    }

    public function appCustomerTokenData($data = NULL)
    {
        $v_customerTokenIn = !empty($data['customerTokenIn']) ? $data['customerTokenIn'] : NULL;
        $v_customerTokenOut = !empty($data['customerTokenOut']) ? $data['customerTokenOut'] : NULL;
        $v_customerToken = $v_customerTokenIn.$v_customerTokenOut;
        if(strlen($v_customerToken) < 64 || (is_null($v_customerTokenIn) || is_null($v_customerTokenOut)))
        {
            $v_return['customer_status'] = 0;
        }
        else
        {
            $query = "SELECT customer_id, customer_nome_fantasia, customer_licence_status as customer_status FROM %appDBprefix%_customer_data WHERE customer_token = '".addslashes($v_customerToken)."' AND customer_status = 1";
            $v_return = $this->dbCon->dbSelect($query);
        }
        return $v_return['rsData'][0];
    }

}