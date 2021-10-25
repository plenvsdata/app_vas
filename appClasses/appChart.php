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

    public function chartObconEntradaSaida(){
        return 'x';
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