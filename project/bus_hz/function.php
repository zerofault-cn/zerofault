<?php
function checkvar($input)
{
	echo "\n<hr><pre>\n";
	print_r($input);
	echo "\n</pre><hr>\n";
}

function getSid($name) {
	global $db,$site_table;
	$sql1="select id from ".SITE_TABLE." where binary name='".$name."'";
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1)>0)
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		return 0;
	}
}
function getSname($sid) {
	global $db,$site_table;
	$sql1="select name from ".SITE_TABLE." where id=".$sid;
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1)>0)
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		return 0;
	}
}
function getLname($lid) {
	global $db,$line_table;
	$sql1="select name from ".LINE_TABLE." where id=".$lid;
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1)>0)
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		return 0;
	}
}
function line_info($id) {
	global $db,$html,$line_name;
	
	$sql1="select * from ".LINE_TABLE." l where l.id=".$id;
	$result1=$db->sql_query($sql1);
	$row1=$db->sql_fetchrow($result1);
			
	$sql2="select r.direction as direction,s.id as id,s.name as name from ".SITE_TABLE." s,".ROUTE_TABLE." r where r.lid=".$id." and s.id=r.sid order by r.i";
	$result2=$db->sql_query($sql2);
	while($row2=$db->sql_fetchrow($result2))
	{
		$route_list[$row2['direction']][$row2['id']]=$row2['name'];
	}
	$line_name = $row1['name'];
	$html .= $line_name.'&nbsp;';
	$start=getSname($row1['start_sid']);
	$end=getSname($row1['end_sid']);
	$html .= '&nbsp;<a href="?action=query_site&id='.$row1['start_sid'].'" title="查看经过【'.$start.'】的所有线路">'.$start.'</a>('.$row1['start_first'].'-'.$row1['start_last'].')';
	$html .= '&nbsp;<a href="?action=query_site&id='.$row1['end_sid'].'" title="查看经过【'.$end.'】的所有线路">'.$end.'</a>('.$row1['end_first'].'-'.$row1['end_last'].')';
	$html .= '&nbsp;票价:'.$row1['fare_norm'].' '.$row1['fare_cond'];
	$html .= '&nbsp;可使用公交卡:'.$row1['ic_card'].'<br />';
	foreach($route_list as $direction=>$route_info)
	{
		$html .= '<span style="color:#FF00FF">';
		if($direction==1)
		{
			$html .= '上行';
		}
		else
		{
			$html .= '下行';
		}
		$html .= '：</span>';
		$count=0;
		foreach($route_info as $id=>$name)
		{
	
			$html .= '<a href="?action=query_site&id='.$id.'" title="查看经过【'.$name.'】的所有线路">'.$name.'</a>';
			if($count!=count($route_info)-1)
			{
				$html .= '→';
				$count++;
			}
		}
		$html .= '</br />';
	}
	$html .= '<br />';
}
function site_info($id) {
	global $db,$html,$site_name;
	$sql="select distinct(l.id),l.name,s1.name as start,s2.name as end from ".LINE_TABLE." l,".ROUTE_TABLE." r,".SITE_TABLE." s1,".SITE_TABLE." s2 where r.sid=".$id." and r.lid=l.id and l.start_sid=s1.id and l.end_sid=s2.id";
	$result=$db->sql_query($sql);
	while($row=$db->sql_fetchrow($result))
	{
		$line_arr[]=$row;
	}
	if(count($line_arr)>0)
	{
		$html .= '<table borer="0" cellspacing="1" cellpadding="1" bgcolor="#0099CC">';
		$html .= '<tr bgcolor="#ffffff"><th colspan="3">经过【'.($site_name=getSname($id)).'】的公交线路('.count($line_arr).'条)</td></tr>';
		$html .= '<tr bgcolor="#ffffff"><th align="left">序号</th><th>线路名称</th><th>起点－终点</th></tr>';
		foreach($line_arr as $key=>$line)
		{
			$html .= '<tr bgcolor="#ffffff"><td>'.($key+1).'</td><td><a href="?action=query_line&id='.$line['id'].'" title="查看线路【'.$line['name'].'】的相信信息">'.$line['name'].'</a></td><td>'.$line['start'].'→'.$line['end'].'</td></tr>';
		}
		$html .= '</table>';
	}
}
function getResult($from_sid,$to_sid) {
	global $html,$from,$to;
	$result=findNext($from_sid,$to_sid);
	$from=getSname($from_sid);
	$to=getSname($to_sid);
	$html .= '<table borer="0" cellspacing="1" cellpadding="1" bgcolor="#0099CC">';
	$html .= '<caption>从【<a href="?action=query_site&id='.$from_sid.'" title="查看经过【'.$from.'】的所有线路">'.$from.'</a>】到【<a href="?action=query_site&id='.$to_sid.'" title="查看经过【'.$to.'】的所有线路">'.$to.'</a>】的乘车方案</caption>';
	$html .= '<tr bgcolor="#ffffff">';
	$html .= '<th>序号</th>';
//	echo '<th>起点</th>';
	$html .= '<th>乘坐线路</th>';
	if(sizeof($result[0])>1)
	{
		$html .= '<th>换乘站点</th>';
		$html .= '<th>换乘线路</th>';
	}
//	echo '<th>终点</th>';
	$html .= '</tr>';
	foreach($result as $i=>$r)
	{
		$html .= '<tr bgcolor="#ffffff">';
		$html .= '<td>'.($i+1).'</td>';
//		echo '<td>'.getSname($from_sid).'</td>';
			
		foreach($r as $n=>$info)
		{
			$html .= '<td><a href="?action=query_line&id='.$info['lid'].'">'.getLname($info['lid'])."</a></td>";
			if(count($r)>0 && $n!=(count($r)-1))
			{
				$html .= '<td><a href="?action=query_site&id='.$info['sid'].'">'.getSname($info['sid'])."</a></td>";
			}
		}
		$html .= "</tr>";
	}
	$html .= '</table>';

}
function findNext($from_sid,$to_sid) {
	global $db;
	//取得该站点在它所在线路上的后续站点
	$nextSidArr=getNextSidArr($from_sid);

	$n=0;//换乘次数
	$i=0;//可行方案数
	$result=array();
	foreach($nextSidArr as $lid=>$sidArr)//遍历每条线路,在该线路上找终点
	{
		foreach($sidArr as $sid)//在一条线路上找后续站点
		{
			if($sid==$to_sid)
			{
				$result[$i][$n]['lid']=$lid;
				$result[$i][$n]['sid']=$sid;
				$i++;
				continue;//找到的站点是最近的,到下一条线路上去找
			}
		}
	}
	if(sizeof($result[$i-1])>0)
	{
		return $result;
	}

	$n++;
	//一次换乘
	foreach($nextSidArr as $lid=>$sidArr)
	{
		
		$get=0;
		if($get==1)
		{
			continue;
		}
		foreach($sidArr as $sid)
		{
			$nextSidArr2=getNextSidArr($sid);
			foreach($nextSidArr2 as $lid2=>$sidArr2)
			{
				foreach($sidArr2 as $sid2)
				{
					if($sid2==$to_sid)
					{
						$result[$i][0]['lid']=$lid;
						$result[$i][0]['sid']=$sid;
						$result[$i][1]['lid']=$lid2;
						$result[$i][1]['sid']=$sid2;
						$i++;
						$get=1;
						continue;
					}
				}
			}
		}
	}
	if(sizeof($result[$i-1])>0)
	{
		return $result;
	}
	$n++;
	//二次换乘
	foreach($nextSidArr as $lid=>$sidArr)
	{
		$get=0;
		if($get==1)
		{
			continue;
		}
		foreach($sidArr as $sid)
		{
			foreach($nextSidArr as $lid=>$sidArr)
			{
				foreach($sidArr as $sid)
				{
					$nextSidArr2=getNextSidArr($sid);
					foreach($nextSidArr2 as $lid2=>$sidArr2)
					{
						foreach($sidArr2 as $sid2)
						{
							if($sid2==$e_sid)
							{
								$result[$i][0]['lid']=$lid;
								$result[$i][0]['sid']=$sid;
								$result[$i][$n]['lid']=$lid2;
								$result[$i][$n]['sid']=$sid2;
								$i++;
								$get=1;
								continue;
							}
						}
					}
				}
			}
		}
	}
	if(sizeof($result[$i-1])>0)
	{
		return $result;
	}
	return $result;
	//二次换乘都无结果，就不用再找了
}

function getLidArrBySname($sname) {
	global $db;
	$sql1="select distinct lid from ".ROUTE_TABLE." r,".SITE_TABLE." s where s.name='".$sname."' and r.sid=s.id";
	$result1=$db->sql_query($sql1);
	$lid_arr=array();
	while($row=$db->sql_fetchrow($result1))
	{
		$lid_arr[]=$row['lid'];
	}
	return $lid_arr;
}
function getLidArrBySid($sid) {
	global $db;
	$sql1="select distinct lid from ".ROUTE_TABLE." where sid=".$sid;
	$result1=$db->sql_query($sql1);
	$lid_arr=array();
	while($row=$db->sql_fetchrow($result1))
	{
		$lid_arr[]=$row['lid'];
	}
	return $lid_arr;
}
function getNextSidArr($sid) {
	global $db;
	$lid_arr=getLidArrBySid($sid);
	foreach($lid_arr as $lid)
	{
		$sql1="select distinct r2.sid as sid from ".ROUTE_TABLE." r1,".ROUTE_TABLE." r2 where r1.lid=".$lid." and r1.sid=".$sid." and r2.direction=r1.direction and r2.i>r1.i and r2.lid=r1.lid order by r2.i";
//	echo '<br />';
		$result1=$db->sql_query($sql1);
		$sid_arr[$lid]=array();
		while($row=$db->sql_fetchrow($result1))
		{
			$sid_arr[$lid][]=$row['sid'];
		}
	}
	return $sid_arr;
}
function curl_search($action)
{
	include_once PATH_ROOT.'/include/simple_html_dom.php';
	global $singleWayLines,$table,$html,$line_name,$site_name;
	$singleWayLines = array('55','56','59','60','676');
	$c = curl_init();
	curl_setopt($c, CURLOPT_REFERER, "http://www.hzbus.com.cn/");
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	$site_name = $_REQUEST['site_name'];
	$line_name = $_REQUEST['line_name'];
	if('query_line'==$action || $_REQUEST['line_id'])
	{
		curl_setopt($c, CURLOPT_URL, "http://www.hzbus.com.cn/content/busline/line_search.jsp");
		curl_setopt($c, CURLOPT_POSTFIELDS,"line_name=".$line_name);
		$data = curl_exec($c);
		$data=str_get_html($data);
		$table=$data->find('table[width="98%"] table',0);
		$descr=$table->children(1)->plaintext;
		
		if(strlen(trim($descr))<2)
		{
			$html = '暂时没有此线路的信息!';
			return;
		}
		if(strlen(trim($descr))>2 &&strlen(trim($descr))<20)
		{
			$offset=2;
		}
		
		$descr=$table->children(1+$offset)->plaintext;
		parseLineInfo($descr,2+$offset);
		if($offset==2)
		{
			$descr=$table->children(4+$offset)->plaintext;
			parseLineInfo($descr,5+$offset);
		}
		$data->clear();
		unset($data);
	}
	if('query_site'==$action)
	{
		curl_setopt($c, CURLOPT_URL, "http://www.hzbus.com.cn/content/busline/linestop_search.jsp");
		curl_setopt($c, CURLOPT_POSTFIELDS,"stop_name=".$site_name);
		$data = curl_exec($c);
		$data=str_get_html($data);
		$table=$data->find('table[width="98%"] table',0);
		$html .= str_replace('line_search.jsp?','index.php?curl_search=1&',$table);
	}
}
function parseLineInfo($descr,$tmp_offset)
{
	include_once PATH_ROOT.'/include/simple_html_dom.php';
	global $singleWayLines,$table,$html,$line_name;
	$line_arr=explode("\n",$descr);

	$number_arr=explode("/",$line_arr[1]);
	$number=trim(str_ireplace("K",'',$number_arr[0]));

	$term_arr=explode("--",$line_arr[6]);

	$time1_arr=explode("-",$line_arr[14]);
	$time2_arr=explode("-",$line_arr[15]);
	$str = '<span style="color:#0000FF">'.($line_name=trim($line_arr[1])).', '.trim($line_arr[26]);
	$str.= ', 空调车:'.trim($line_arr[22]).' 普通车:'.trim($line_arr[18])."<br />";
	
	$str.= '起点站: '.trim($term_arr[0]).' ('.trim($time1_arr[0]).'～'.trim($time1_arr[1]).')<br />';
	$str.= '终点站: '.trim($term_arr[1]).' ('.trim($time2_arr[0]).'～'.trim($time2_arr[1]).')';
	
	$str .= '</span><br />';
	
	$route_arr=$table->children($tmp_offset)->find('table[bgcolor="3E89C0"]');
	foreach($route_arr as $r=>$route)
	{
		if($r==1 && in_array($number,$singleWayLines))
		{
			continue;
		}
		$tr_arr=$route->children();
		foreach($tr_arr as $row=>$tr)
		{
			if(!isset($flag)){
				$str.='<span style="color:#FF3399">正向：';
				$flag=0;
			}
			if($flag){
				$str.='<span style="color:#9933FF">反向：';
				$flag=0;
			}
			
			if($row==0 || $row==1)
			{
				continue;
			}
			else
			{
				$str.=trim($tr->children(1)->plaintext);
			}
			if($row!=sizeof($tr_arr)-1)
			{
				$str.='→';
			}
			else
			{
				$str.='</span><br />';
				$flag=1;
			}
		}
	}
	$html .= $str;
	$html .= '</span><br />';
}
?>