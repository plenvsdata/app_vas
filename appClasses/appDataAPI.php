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
           if ($origem == "VIPER") {
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

                //ToDo: remover teste
                //$v_dat = date('Y-m-d H:i:s');

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

            }
           elseif($origem == "OBCON") {
               $queryValue = array();
               $v_alarme = str_replace('#XI3POBCDEPC', '', $data);
               $v_integradora = trim(substr($v_alarme, 0, 3));
               $v_ninst = substr($v_alarme, 3,4);
               $v_clid = substr($v_alarme, 7, 6);
               $v_gloid = trim(substr($v_alarme, 13, 4));
               $v_data_str = substr($v_alarme, 17, 8);
               $v_data = substr($v_data_str,4,4).'-'.substr($v_data_str,2,2).'-'.substr($v_data_str,0,2);
               $v_hora_str = substr($v_alarme, 25, 6);
               $v_hora = substr($v_hora_str, 0,2).':'.substr($v_hora_str, 2,2).':'.substr($v_hora_str, 4,2);
               $v_dat = date('Y-m-d H:i:s', strtotime($v_data.' '.$v_hora));
               $v_reg = (int)trim(substr($v_alarme, 31, 3));
               $v_regLength = $v_reg * 8;
               $v_regData = substr($v_alarme, 34, $v_regLength);
               $v_regDataArray = str_split($v_regData,8);

               foreach($v_regDataArray as $k=>$v){

                   $v_cam = trim(substr($v, 0, 2));
                   $v_tw = substr($v, 2, 1);
                   $v_sent = substr($v, 3, 1);
                   $v_numo = trim(substr($v, 4, 3));
                   $v_tama = trim(substr($v, 7, 1));
                   $v_camArray[] = $v_cam;
                   $queryValue[] = "('" . $v_customerID . "','" . $v_integradora . "','" . $v_ninst . "','" . $v_clid . "','" . $v_gloid . "','" . $v_data . "','" . $v_hora . "','" . $v_cam . "','" . $v_tw . "','" . $v_sent . "','" . $v_numo . "','" . $v_tama . "','" . addslashes($data) . "')";

                   $v_dashboardCheck['ninst'] = $v_ninst;
                   $v_dashboardCheck['sent'] = $v_sent;
                   $v_dashboardCheck['cam'] = $v_cam;

                   $v_checkCounter = $this->appObconCounter($v_dashboardCheck,$v_customerID);
               }





               $queryValue = implode(',',$queryValue);
               $query = "INSERT INTO %appDBprefix%_alarme_" . strtolower($origem) . "_data (customer_id,integradora,ninst,clid,gloid,data,hora,cam,tw,sent,numo,tama,alarme_" . strtolower($origem) . "_completo) VALUES ".$queryValue;
               $v_alarmeCamera = implode(',',array_unique($v_camArray));

            }
           else{
               $query = "INSERT INTO %appDBprefix%_lixo (alarme) VALUES ('" . $data . "')";
               $v_dat = date("d/m/Y - H:i:s");
               $v_alarmeCamera = 'desconformidade';
           }

            $v_insertData = $this->dbCon->dbInsert($query);
            $v_return['status'] = true;
            $v_return['id'] = $v_insertData['rsInsertID'];
            $v_return['date_time'] = date("d/m/Y - H:i:s",strtotime($v_dat));
            $v_return['camera'] = $v_alarmeCamera;
            $v_return['origem'] = $origem;
        }
        return $v_return;
    }

    public function appObconCounter($data,$customerID,$dasboardAccess = false) {
        $v_customerID = $customerID;
        $v_ninst = $data['ninst'];
        $v_cam = $data['cam'];
        $v_sent = $data['sent'];

        $v_getValue = new appGetValue();
        $v_fieldData['table'] = "view_dashboard_camera";
        $v_fieldData['field'] = "dashboard_id";
        $v_fieldData['fieldID'][] = $v_customerID;
        $v_fieldData['fieldID'][] = $v_ninst;
        $v_fieldData['fieldID'][] = $v_cam;
        $v_fieldData['fieldName'][] = "customer_id";
        $v_fieldData['fieldName'][] = "ninst";
        $v_fieldData['fieldName'][] = "cam";

        $v_dashboardIDData = $v_getValue->appGetValueData($v_fieldData, false, false);
        $v_dashboardID = $v_dashboardIDData['dashboard_id'] ?? null;

        IF(is_null($v_dashboardID)) {
            echo 'Cria nova linha Counter - Dashboard não existe';
        }else{
            echo 'atualiza counter';
            echo 'v_dashboardID = '.$v_dashboardID;
            echo 'Cria nova linha Counter e já insere o dado novo';
            //$query = "INSERT INTO...";
        }
        die();
    }
}