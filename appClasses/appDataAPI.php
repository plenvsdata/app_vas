<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 30/01/2018
 * Time: 21:44
 */

namespace app\System\API;

use app\dbClass\appDBClass;
use app\System\Lov\appGetValue;

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

    public function appCustomerAlarme($data = NULL,$origem,$customerID)
    {
        $v_customerID = $customerID;
        if (is_null($data)) {
            $v_return['customer_status'] = 0;
        } else {

            if ($origem != "OBCON") {
                $v_alarme = str_replace('#XI3PALERT', '', $data);
                $v_ori = substr($v_alarme, 0, 1);
                $v_idr = substr($v_alarme, 1, 6);
                $v_nor = ($v_ori == 'O') ? NULL : substr($v_alarme, 7, 50);
                if (!is_null($v_nor)) {
                    $v_nor = "'" . $v_nor . "'";
                } else {
                    $v_nor = "NULL";
                }

                $v_cod = ($v_ori == 'O') ? trim(substr($v_alarme, 7, 10)) : trim(substr($v_alarme, 57, 10));
                $v_dat = ($v_ori == 'O') ? trim(substr($v_alarme, 17, 20)) : trim(substr($v_alarme, 67, 20));
                $v_datReturn = $v_dat;
                $v_dat = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $v_dat)));

                $v_nuc = ($v_ori == 'O') ? trim(substr($v_alarme, 37, 3)) : trim(substr($v_alarme, 87, 3));
                $v_alarmeCamera = $v_nuc;
                $v_apl = ($v_ori == 'O') ? trim(substr($v_alarme, 40, 10)) : trim(substr($v_alarme, 90, 10));
                $v_ins = ($v_ori == 'O') ? trim(substr($v_alarme, 50, 2)) : trim(substr($v_alarme, 100, 2));
                $v_org = ($v_ori == 'O') ? trim(substr($v_alarme, 52, 5)) : trim(substr($v_alarme, 102, 5));
                $v_sub = ($v_ori == 'O') ? trim(substr($v_alarme, 57, 10)) : trim(substr($v_alarme, 107, 10));
                $v_nsb = ($v_ori == 'O') ? trim(substr($v_alarme, 67, 5)) : trim(substr($v_alarme, 117, 5));
                $v_sbn = ($v_ori == 'O') ? trim(substr($v_alarme, 72, 10)) : trim(substr($v_alarme, 122, 10));
                $v_cor = ($v_ori == 'O') ? trim(substr($v_alarme, 82, 2)) : trim(substr($v_alarme, 132, 2));
                $v_ips = 'NULL';
                $v_pos = 'NULL';

                $v_getValue = new appGetValue();

                $v_fieldData['table'] = "lov_system_origem";
                $v_fieldData['field'] = "origem_id";
                $v_fieldData['fieldID'] = $v_org;
                $v_fieldData['fieldName'] = "origem_desc";
                $v_origemIDData = $v_getValue->appGetValueData($v_fieldData, false, false);
                $v_origemID = $v_origemIDData['origem_id'];

                $v_fieldData['table'] = "lov_system_subtipo";
                $v_fieldData['field'] = "subtipo_id";
                $v_fieldData['fieldID'] = $v_sub;
                $v_fieldData['fieldName'] = "subtipo_desc";
                $v_subtipoIDData = $v_getValue->appGetValueData($v_fieldData, false, false);
                $v_subtipoID = isset($v_subtipoIDData['subtipo_id']) ? $v_subtipoIDData['subtipo_id'] : 1;
                $query = "INSERT INTO %appDBprefix%_alarme_" . strtolower($origem) . "_data (customer_id,ori,idr,nor,cod,dat,nuc,apl,ins,origem_id,subtipo_id,nsb,sbn,cor,ips,pos,alarme_" . strtolower($origem) . "_completo) VALUES ('" . $v_customerID . "','" . $v_ori . "','" . $v_idr . "'," . $v_nor . ",'" . $v_cod . "','" . $v_dat . "','" . $v_nuc . "','" . $v_apl . "','" . $v_ins . "','" . $v_origemID . "','" . $v_subtipoID . "','" . $v_nsb . "','" . $v_sbn . "','" . $v_cor . "'," . $v_ips . "," . $v_pos . ",'" . addslashes($data) . "')";

            } else {
                $v_obconData = explode(',', $data);
                $v_clid = $v_obconData[0];
                $v_ninst = $v_obconData[1];
                $v_data = date('Y-m-d', strtotime(str_replace('_', '-', $v_obconData[2])));;
                $v_hora = date('H:i:s', strtotime(str_replace('_', ':', $v_obconData[3])));
                $v_cam = $v_obconData[4];
                $v_alarmeCamera = $v_cam;
                $v_tw = $v_obconData[5];
                $v_sent = $v_obconData[6];
                $v_numo = $v_obconData[7];
                $v_tama = $v_obconData[8];

                $v_event_date = date('d/m/Y', strtotime(str_replace('_', '-', $v_obconData[2])));
                $v_event_time = date('H:i:s', strtotime(str_replace('_', ':', $v_obconData[3])));
                $v_dat = $v_event_date . ' ' . $v_event_time;

                $query = "INSERT INTO %appDBprefix%_alarme_" . strtolower($origem) . "_data (customer_id,clid,ninst,data,hora,cam,tw,sent,numo,tama,alarme_" . strtolower($origem) . "_completo) VALUES ('" . $v_customerID . "','" . $v_clid . "','" . $v_ninst . "','" . $v_data . "','" . $v_hora . "','" . $v_cam . "','" . $v_tw . "','" . $v_sent . "','" . $v_numo . "','" . $v_tama . "','" . addslashes($data) . "')";
            }

            $v_insertData = $this->dbCon->dbInsert($query);
            $v_return['status'] = true;
            $v_return['id'] = $v_insertData['rsInsertID'];
            $v_return['date_time'] = date("d/m/Y - H:i:s",strtotime($v_dat));
            $v_return['camera'] = $v_alarmeCamera;
            $v_return['origem'] = $origem;
            return $v_return;
        }
    }
}