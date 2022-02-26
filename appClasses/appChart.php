<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 25/10/2021
 * Time: 13:10
 */

namespace app\System\Chart;
use app\dbClass\appDBClass;

class appChart
{
    private $dbCon;

    public function __construct()
    {
        $this->dbCon = new appDBClass();
    }

    public function chartInOutEntradaSaida($data = NULL){
        $v_dashboardID = !empty($data['dashboardID']) ? $data['dashboardID'] : NULL;
        $v_date = date("Y-m-d");
$query = "
SELECT
   (CASE
        WHEN hora BETWEEN '00:00:00' AND '00:59:59' THEN '0:00'
        WHEN hora BETWEEN '01:00:00' AND '01:59:59' THEN '1:00'
        WHEN hora BETWEEN '02:00:00' AND '02:59:59' THEN '2:00'
        WHEN hora BETWEEN '03:00:00' AND '03:59:59' THEN '3:00'
        WHEN hora BETWEEN '04:00:00' AND '04:59:59' THEN '4:00'
        WHEN hora BETWEEN '05:00:00' AND '05:59:59' THEN '5:00'
        WHEN hora BETWEEN '06:00:00' AND '06:59:59' THEN '6:00'
        WHEN hora BETWEEN '07:00:00' AND '07:59:59' THEN '7:00'
        WHEN hora BETWEEN '08:00:00' AND '08:59:59' THEN '8:00'
        WHEN hora BETWEEN '09:00:00' AND '09:59:59' THEN '9:00'
        WHEN hora BETWEEN '10:00:00' AND '10:59:59' THEN '10:00'
        WHEN hora BETWEEN '11:00:00' AND '11:59:59' THEN '11:00'
        WHEN hora BETWEEN '12:00:00' AND '12:59:59' THEN '12:00'
        WHEN hora BETWEEN '13:00:00' AND '13:59:59' THEN '13:00'
        WHEN hora BETWEEN '14:00:00' AND '14:59:59' THEN '14:00'
        WHEN hora BETWEEN '15:00:00' AND '15:59:59' THEN '15:00'
        WHEN hora BETWEEN '16:00:00' AND '16:59:59' THEN '16:00'
        WHEN hora BETWEEN '17:00:00' AND '17:59:59' THEN '17:00'
        WHEN hora BETWEEN '18:00:00' AND '18:59:59' THEN '18:00'
        WHEN hora BETWEEN '19:00:00' AND '19:59:59' THEN '19:00'
        WHEN hora BETWEEN '20:00:00' AND '20:59:59' THEN '20:00'
        WHEN hora BETWEEN '21:00:00' AND '21:59:59' THEN '21:00'
        WHEN hora BETWEEN '22:00:00' AND '22:59:59' THEN '22:00'
        WHEN hora BETWEEN '23:00:00' AND '23:59:59' THEN '23:00'
   ELSE 0 END) AS horario,
	SUM(CASE sent WHEN 'E' THEN 1 ELSE 0 END) entradas,
	SUM(CASE sent WHEN 'S' THEN 1 ELSE 0 END) saidas,
	data,TIME_FORMAT(hora,'%k') AS hora
	FROM %appDBprefix%_view_report_obcon_data 
    WHERE dashboard_id = '".$v_dashboardID."'  AND data = '".$v_date."'
    GROUP BY horario 
";

        $v_rs = $this->dbCon->dbSelect($query);
        $v_data = array();
        if($v_rs['rsStatus']){

            foreach($v_rs['rsData'] as $value)
            {
                $v_data[] = array(
                    ['v'=>[intval($value['hora']),0,0], 'f'=>$value['horario']], intval($value['entradas']), intval($value['saidas'])
                );
            }
        }else{
            $v_data[] = array(['v'=>[12,0,0], 'f'=>'12:00'], 0, 0);

        }

        return $v_data;

    }

    public function chartInOutDashboardDia($data = NULL){
        $v_dashboardID = !empty($data['dashboardID']) ? $data['dashboardID'] : NULL;
        $v_dateStart = !empty($data['dateStart']) ? $data['dateStart'] : NULL;
        $v_dateEnd = !empty($data['dateEnd']) ? $data['dateEnd'] : NULL;

        $query = "
    SELECT entrada,count_data,DATE_FORMAT(count_data,'%d/%m') AS data_chart
	FROM %appDBprefix%_view_dashboard_obcon_count_by_day
    WHERE dashboard_id = '".$v_dashboardID."' AND count_data BETWEEN '".$v_dateStart."' AND '".$v_dateEnd."' 
";

        $v_rs = $this->dbCon->dbSelect($query);
        $v_data = array();
        if($v_rs['rsStatus']){

            foreach($v_rs['rsData'] as $value)
            {
                $v_data[] = array($value['data_chart'],intval($value['entrada']));
            }
        }else{
            $v_data[] = array(date('d/m'),0);
        }

        return $v_data;
    }

}