<?php
/**
* ArticleTimeModifyAction.cls.php
* @copyright bokee dot com
* @author liangbiquan@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class ArticleTimeModifyAction extends Action {

    function execute(&$actionMap,&$actionError,$request,&$response,$form){

    	
		$channel_name = $request['channel_name'];

        $db = "cms_" . $channel_name;
        $response['channel_name'] = $channel_name;
        
        $article_id = intval( $request['article_id'] );
 		$r_id = intval( $request['r_id'] );
				
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
		
		if( !empty( $article_id ) )
		{
			$sql = "select create_time from article where id=$article_id";
			$row = $dao->GetRow($sql);
			$create_time = $row['create_time'];
			$date_time = substr($create_time,0,4) ."||". substr($create_time,5,2) ."||". substr($create_time,8,2) ."||". substr($create_time,11,2) ."||". substr($create_time,14,2) ."||". substr($create_time,17,2);
        }

		if( !empty( $r_id ) )
		{
			$sql = "select datetime from rel_article_subject where id=$r_id";
			$row = $dao->GetRow($sql);
			$date_time = $this->hdate( $row['datetime'] );
        }

		$time_array = explode( "||",$date_time );

		//year
		$year_num = 0;
		for( $i=1990;$i<=2010;$i++ )
		{
			$year[$year_num]['value'] = $i;
			$year[$year_num]['name'] = $i;
			if( $i == $time_array[0] )
				$year[$year_num]['selected'] = "selected";
			$year_num++;
		}

		//month
		$month_num = 0;
		for( $i=1;$i<=12;$i++ )
		{
			$month[$month_num]['value'] = $this->format( $i );
			$month[$month_num]['name'] = $this->format( $i );
			if( $this->format($i) == $time_array[1] )
				$month[$month_num]['selected'] = "selected";
			$month_num++;
		}

		//day
		$day_num = 0;
		for( $i=1;$i<=31;$i++ )
		{
			$day[$day_num]['value'] = $this->format( $i );
			$day[$day_num]['name'] = $this->format( $i );
			if( $this->format($i) == $time_array[2] )
				$day[$day_num]['selected'] = "selected";
			$day_num++;
		}

		//hour
		$hour_num = 0;
		for( $i=0;$i<=23;$i++ )
		{
			$hour[$hour_num]['value'] = $this->format( $i );
			$hour[$hour_num]['name'] = $this->format( $i );
			if( $this->format($i) == $time_array[3] )
				$hour[$hour_num]['selected'] = "selected";
			$hour_num++;
		}
		
		//minute
		$minute_num = 0;
		for( $i=0;$i<=59;$i++ )
		{
			$minute[$minute_num]['value'] = $this->format( $i );
			$minute[$minute_num]['name'] = $this->format( $i );
			if( $this->format($i) == $time_array[4] )
				$minute[$minute_num]['selected'] = "selected";
			$minute_num++;
		}

		//second
		$second_num = 0;
		for( $i=0;$i<=59;$i++ )
		{
			$second[$second_num]['value'] = $this->format( $i );
			$second[$second_num]['name'] = $this->format( $i );
			if( $this->format($i) == $time_array[5] )
				$second[$second_num]['selected'] = "selected";
			$second_num++;
		}
		
		$response['r_id'] = $r_id;
		$response['article_id'] = $article_id;
		$response['year'] = $year;
		$response['month'] = $month;
		$response['day'] = $day;
		$response['hour'] = $hour;
		$response['minute'] = $minute;
		$response['second'] = $second;
		
    		
    }
	function hdate($ts)
	{
		 $unix_ts = mktime( substr($ts,8,2), substr($ts,10,2), substr($ts,12,2), substr($ts,4,2), substr($ts,6,2), substr($ts,0,4) );
		 $output = date("Y||m||d||H||i||s",$unix_ts);
		 return $output;
	}
	function format($num)
	{
		if( strlen($num) ==1 )
			return "0".$num;
		else
			return $num;
	}
}
?>