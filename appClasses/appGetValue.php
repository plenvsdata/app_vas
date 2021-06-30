<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 30/01/2018
 * Time: 21:44
 */

namespace app\System\Lov;
use app\dbClass\appDBClass;

class appGetValue
{
    private $dbCon;

    public function __construct()
    {
        $this->dbCon = new appDBClass();
    }

    public function appGetValueData($data = NULL,$clntCheck=false,$methodDebug=false)
    {
        if(!empty($data['table']) && !empty($data['field']) && !empty($data['fieldID'] && !empty($data['fieldName'])))
        {
            $v_where = "";

            if(is_array($data['field'])){
                $v_fields = implode(',',$data['field']);
            } else {
                $v_fields = $data['field'];
            }

            if(is_array($data['fieldName'])) {
                foreach ($data['fieldName'] AS $key=>$value) {
                    $v_where .= " AND ".$value." = '".addslashes($data['fieldID'][$key])."'";
                }
            } else {
                $v_where .= " AND ".$data['fieldName']." = '".addslashes($data['fieldID'])."'";
            }
            $query = "SELECT ".$v_fields." FROM %appDBprefix%_".$data['table']." WHERE 1=1 ";

            if($clntCheck == true) {
                $query .= "AND (clnt = '0' OR clnt = '".$_SESSION['userClnt']."') ";
            }
            $query .= $v_where;

            if($methodDebug == true) {
                echo $query;
                die();
            }

            $v_return = $this->dbCon->dbSelect($query);
            return $v_return['rsData'];
        }
    }

    public function appGetValueDataOR($data = NULL,$clntCheck=false)
    {
        if(!empty($data['table']) && !empty($data['field']) && !empty($data['fieldID'] && !empty($data['fieldName'])))
        {
            $v_where = "";

            if(is_array($data['field'])){
                $v_fields = implode(',',$data['field']);
            } else {
                $v_fields = $data['field'];
            }

            if(is_array($data['fieldName'])) {
                foreach ($data['fieldName'] AS $key=>$value) {
                    $v_where .= $value." = '".addslashes($data['fieldID'][$key])."' OR ";
                }
            } else {
                $v_where .= $data['fieldName']." = '".addslashes($data['fieldID'])."' OR ";
            }
            $query = "SELECT ".$v_fields." FROM %appDBprefix%_".$data['table']." WHERE 1=1 AND ";

            if($clntCheck == true) {
                $query .= "(clnt = '0' OR clnt = '".$_SESSION['userClnt']."') AND ";
            }
            $query .= '('.rtrim($v_where," OR ").')';

            //echo $query;
            //echo '<hr>';


            $v_return = $this->dbCon->dbSelect($query);
            return $v_return['rsData'];
        }
    }

}