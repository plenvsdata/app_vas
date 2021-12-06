<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 21/01/2018
 * Time: 23:55
 */

namespace app\System\ErrorLog;
use app\dbClass\appDBClass;

class ErrorLog
{
    private $dbCon;

    public function __construct()
    {
        $this->dbCon = new appDBClass();
    }

    public function appInsertFullData($data = NULL)
    {
        $v_completo = is_array($data) ? implode(' // ',$data) : $data;

        $query = "INSERT INTO %appDBprefix%_error_log (completo) VALUES ('".addslashes($v_completo)."')";
        $v_insertData = $this->dbCon->dbInsert($query);
        $v_return['status'] = true;
        $v_return['errorID'] = $v_insertData['rsInsertID'];
        return $v_return;
    }
}