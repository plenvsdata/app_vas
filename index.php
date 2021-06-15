<?php

echo 'teste';
die();


class appDBClass
{
    private $con;
    public $result;
    private $db;
    public $dbErrNo;

    public function __construct()
    {
        $this->db = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/dbInfo.php");
        $this->dbConnect();
    }

    private function dbConnect()
    {
        if(!$this->con){
            $this->con = new mysqli($this->db['dbServer'], $this->db['dbUser'], $this->db['dbPwd'], $this->db['dbName'], $this->db['dbPort']);
        }


        if(mysqli_connect_error())
        {
            echo '<b>There was a problem connecting to database! </b><br />errno: '.mysqli_connect_errno();
            die();
        }
        $this->con->set_charset("utf8");
        return $this->con;
    }

    public function dbSelect($query,$output='array')
    {
        $chk = mysqli_query($this->con,str_replace("%appDBprefix%",$this->db['dbPrefix'],$query));
        $cnt = mysqli_num_rows($chk);
        if($cnt > 0)
        {
            $rtn['rsTotal'] = $cnt;
            $rtn['rsData'] = mysqli_fetch_all($chk,MYSQLI_ASSOC);
            $rtn['rsStatus'] = true;
        }
        else
        {
            $rtn['rsTotal'] = 0;
            $rtn['rsData'] = false;
            $rtn['rsStatus'] = false;
        }

        if($output=="json")
        {
            $rtn = json_encode($rtn);
        }

        return $rtn;
    }

    public function dbInsert($query)
    {
        $chk = mysqli_query($this->con,str_replace("%appDBprefix%",$this->db['dbPrefix'],$query));
        if($chk)
        {
            $rtn['rsInsertID'] = mysqli_insert_id($this->con);
            $rtn['affectedRows'] = mysqli_affected_rows($this->con);
            $rtn['insertStatus'] = true;
        }
        else
        {
            $rtn['insertStatus'] = false;
            $rtn['insertErrMsg'] = mysqli_error($this->con);
            $rtn['insertErrNo'] = mysqli_errno($this->con);
        }
        return $rtn;
    }

    public function dbProcedure($query,$return=true)
    {

        $chk = mysqli_query($this->con,$query);

        if($chk)
        {
            $rtn['procedureStatus'] = true;
            if($return){
                $rtn['rsData'] = mysqli_fetch_all($chk,MYSQLI_ASSOC);
                $chk->close();
                $this->con->next_result();
            }
        }
        else
        {
            $rtn['procedureStatus'] = false;
            $rtn['procedureErrMsg'] = mysqli_error($this->con);
            $rtn['procedureErrNo'] = mysqli_errno($this->con);
            $rtn['procedureErrTest'] = 'teste';
        }

        return $rtn;
    }


    public function dbUpdate($query)
    {
        if(mysqli_query($this->con,str_replace("%appDBprefix%",$this->db['dbPrefix'],$query)))
        {
            $rtn['affectedRows'] = mysqli_affected_rows($this->con);
            $rtn['updateStatus'] = true;
        }
        else
        {
            $rtn['updateStatus'] = false;
            $v_errCode = $rtn['errorCode'] = mysqli_errno($this->con);
            $v_errMsg = $rtn['errorMsg'] = mysqli_error($this->con);
            $v_checkDuplicate = strpos(strtolower($v_errMsg),'duplicate');

            if($v_checkDuplicate === false) {
                $rtn['duplicateData'] = false;
            } else {
                $rtn['duplicateData'] = true;
            }
        }
        return $rtn;
    }

    public function dbDelete($query)
    {
        if(mysqli_query($this->con,str_replace("%appDBprefix%",$this->db['dbPrefix'],$query)))
        {
            $rtn['affectedRows'] = mysqli_affected_rows($this->con);
            $rtn['deleteStatus'] = true;
        }
        else
        {
            $rtn['deleteStatus'] = false;
            //ToDo: Error Log
            //die('Erro: '.mysqli_error($this->con));
        }
        return $rtn;
    }

    public function dbQuery($query)
    {
        $chk = mysqli_query($this->con,str_replace("%appDBprefix%",$this->db['dbPrefix'],$query));
        $cnt = mysqli_num_rows($chk);
        if($cnt > 0)
        {
            $rtn['rsTotal'] = $cnt;
            $rtn['rsData'] = mysqli_fetch_all($chk,MYSQLI_ASSOC);
        }
        else
        {
            $rtn = null;
        }
        return $rtn;
    }

    public function __destruct()
    {
        mysqli_close($this->con);
    }


}
$dbCon = new appDBClass();

$v_teste = !empty($_REQUEST) ? $_REQUEST : 'erro';

echo $v_teste;

print_r($v_teste);
die();

/*
$query = 'INSERT INTO %appDBprefix%_teste SET string_teste = "'.addslashes($v_teste).'"';
$v_importData = $dbCon->dbInsert($query);
*/

echo $v_teste;
echo '</br>';