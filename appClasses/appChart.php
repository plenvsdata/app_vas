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

    public function chartObconEntradaSaida($data = NULL){
        $v_dashboardID = !empty($data['dashboardID']) ? $data['dashboardID'] : NULL;
        $v_date = !empty($data['date']) ? $data['date'] : date("Y-m-d");
        $v_date = '2021-10-25';//apagar
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
    WHERE cam = 33  AND data = '".$v_date."'
    GROUP BY horario 
";
//dashboard_id = '".$v_dashboardID."'


        $v_rs = $this->dbCon->dbSelect($query);
        if($v_rs['rsStatus']){
            $v_data = array();
            foreach($v_rs['rsData'] as $key=>$value)
            {
                $v_data[] = array(
                    ['v'=>[intval($value['hora']),0,0], 'f'=>$value['horario']], intval($value['entradas']), intval($value['saidas'])
                );
            }
        }else{
            //return false
        }

        $v_data1 =  array(
            [['v'=>[7,0,0], 'f'=>'07:00'],2, 1],
            [['v'=>[8,0,0], 'f'=>'07:00'], 2, 0],

            [['v'=>[10, 0, 0], 'f'=> '10:00'], 3, 2]
        );
        return $v_data;

    }





    public function chartOpportunityType()
    {
        $query = "SELECT opportunity_id, opportunity_qty, clnt, opportunity_stage_id, opportunity_stage_desc, opportunity_stage_color, opportunity_css, min_date, max_date, opportunity_status FROM %appDBprefix%_view_chart_sales_type WHERE clnt = '".$_SESSION['userClnt']."' ";
        $v_return['apiData'] = $this->dbCon->dbSelect($query);
        $data = array();
       if($v_return['apiData']['rsData'])
       {
           foreach ($v_return['apiData']['rsData'] as $key=>$value )
           {
               $data[] = array(
                   'label'  => $value["opportunity_stage_desc"],
                   'value'  => $value["opportunity_qty"],
                   'color' => $value["opportunity_stage_color"]
               );
           }

       }
        return json_encode($data);
    }

    public function chartCustomerType()
    {
        $query = "SELECT clnt, customer_type_desc,COUNT(customer_id) as customer_qty FROM %appDBprefix%_view_customer_list WHERE clnt = '".$_SESSION['userClnt']."' GROUP BY clnt, customer_type_id ";
        $v_return['apiData'] = $this->dbCon->dbSelect($query);
        $data = array();
        if($v_return['apiData']['rsData'])
        {
            foreach ($v_return['apiData']['rsData'] as $key=>$value )
            {
                $data[] = array(
                    'label'  => $value["customer_type_desc"],
                    'value'  => $value["customer_qty"]
                );
            }

        }
        return json_encode($data);
    }

    public function chartSalesData($data=null)
    {
        //$query = "SELECT opportunity_id,GROUP_CONCAT(opportunity_id ORDER BY sold_year_week ASC SEPARATOR '|') AS opportunity_id_array,opportunity_sequence,clnt,item_id,product_id,sold_units,GROUP_CONCAT(sold_units ORDER BY sold_year_week ASC SEPARATOR '|') AS sold_units_array,sold_value,GROUP_CONCAT(sold_value ORDER BY sold_year_week ASC SEPARATOR '|') AS sold_value_array,sold_date,sold_date_order,sold_year,sold_week,sold_year_week,item_status,opportunity_type_id,opportunity_prefix,opportunity_code,opportunity_desc,opportunity_info,opportunity_type_desc,opportunity_stage_id,opportunity_stage_desc,opportunity_status,created_by,user_name,user_nickname,user_avatar FROM %appDBprefix%_view_chart_sales_weekly WHERE clnt = '".$_SESSION['userClnt']."' GROUP BY sold_year_week ORDER BY sold_year_week";
        $query = "SELECT opportunity_id,opportunity_sequence,clnt,item_id,product_id,sold_units,sold_value,sold_date,sold_date_order,sold_year,sold_month,sold_day,sold_day_name,sold_week,sold_year_week,item_status,opportunity_type_id,opportunity_prefix,opportunity_code,opportunity_desc,opportunity_info,opportunity_type_desc,opportunity_stage_id,opportunity_stage_desc,opportunity_status,created_by,user_name,user_nickname,user_avatar FROM %appDBprefix%_view_chart_sales WHERE clnt = '".$_SESSION['userClnt']."' ORDER BY sold_date_order ASC";
        $v_chartData = $this->dbCon->dbSelect($query);

        $v_chartValue = array();
        $v_chartLabel = array();
        $v_chartXlabel = array();
        $v_chartPeriod = array();
        $v_chartYKey = array();
        $v_return = array();

        foreach ($v_chartData['rsData'] as $key=>$value)
        {

            $v_chartValue[$value['sold_year_week']][$value['opportunity_sequence']] = $value['sold_units'];
            $v_chartLabel[$value['opportunity_sequence']] = '#'.$value['opportunity_sequence'].'-'.$value['opportunity_desc'];

            if(!in_array($value['sold_year_week'],$v_chartPeriod))
            {
                $v_chartPeriod[] = $value['sold_year_week'];
                $v_chartXlabel[] = date('Y',strtotime($value['sold_date'])).' Week '.date('W',strtotime($value['sold_date']));
            }
        }


        if(is_array($v_chartPeriod))
        {

            foreach ($v_chartPeriod as $key=>$value)
            {
                $v_chartReturn = array();

                $v_chartReturn['period'] = $v_chartPeriod[$key];
                $v_chartReturn['xLabel'] = $v_chartXlabel[$key];

                foreach ($v_chartLabel as $pKey=>$pValue)
                {
                    $v_chartReturn[$pKey] = key_exists($pKey,$v_chartValue[$v_chartPeriod[$key]]) ? $v_chartValue[$v_chartPeriod[$key]][$pKey] : null;
                }
                $v_return[] = $v_chartReturn;
            }
        }
        $chartReturn['data'] = $v_return;
        $chartReturn['label'] = $v_chartPeriod;
        $chartReturn['xlabels'] = $v_chartXlabel;
        $chartReturn['ykeys'] = array_keys($v_chartLabel);
        $chartReturn['labels'] = array_values($v_chartLabel);
        $chartReturn['xkey'] = 'period';
        return json_encode($chartReturn);
    }

}