<?php
/*
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");


//$key=array('抚宁巷','联庄社区');
//$key=array('义蓬','华东家具市场');
//$key=array('采荷新村','联庄社区');
$s_sid=getSid($key[0]);
$e_sid=getSid($key[1]);
*/
//$result=findNext($s_sid);
//echo '<pre>';
//print_r($result);
//echo '</pre>';
//getResult($result);
function getResult($from_sid,$to_sid) {
	$result=findNext($from_sid,$to_sid);
	$from=getSname($from_sid);
	$to=getSname($to_sid);
	echo '<table borer="0" cellspacing="1" cellpadding="1" bgcolor="#0099CC">';
	echo '<caption>从【<a href="site_id_'.$from_sid.'.html" title="查看经过【'.$from.'】的所有线路">'.$from.'</a>】到【<a href="site_id_'.$to_sid.'.html" title="查看经过【'.$to.'】的所有线路">'.$to.'</a>】的乘车方案</caption>';
	echo '<tr bgcolor="#ffffff">';
	echo '<th>序号</th>';
//	echo '<th>起点</th>';
	echo '<th>乘坐线路</th>';
	if(sizeof($result[0])>1)
	{
		echo '<th>换乘站点</th>';
		echo '<th>换乘线路</th>';
	}
//	echo '<th>终点</th>';
	echo '</tr>';
	foreach($result as $i=>$r)
	{
		echo '<tr bgcolor="#ffffff">';
		echo '<td>'.($i+1).'</td>';
//		echo '<td>'.getSname($from_sid).'</td>';
			
		foreach($r as $n=>$info)
		{
			echo '<td><a href="line_id_'.$info['lid'].'.html">'.getLname($info['lid'])."</a></td>";
			if(count($r)>0 && $n!=(count($r)-1))
			{
				echo '<td><a href="site_id_'.$info['sid'].'.html">'.getSname($info['sid'])."</a></td>";
			}
		}
		echo "</tr>";
	}
	echo '</table>';

}
function findNext($from_sid,$to_sid) {
	global $db;
	//取得该站点在它所在线路上的后续站点
	$nextSidArr=getNextSidArr($from_sid);

	$n=0;//换乘次数
	$i=0;//可行方案数
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
	//二次换乘都无结果，就不用再找了
}

function getLidArrBySname($sname) {
	global $db,$route_table,$site_table;
	$sql1="select distinct lid from ".$route_table." r,".$site_table." s where s.name='".$sname."' and r.sid=s.id";
	$result1=$db->sql_query($sql1);
	$lid_arr=array();
	while($row=$db->sql_fetchrow($result1))
	{
		$lid_arr[]=$row['lid'];
	}
	return $lid_arr;
}
function getLidArrBySid($sid) {
	global $db,$route_table;
	$sql1="select distinct lid from ".$route_table." where sid=".$sid;
	$result1=$db->sql_query($sql1);
	$lid_arr=array();
	while($row=$db->sql_fetchrow($result1))
	{
		$lid_arr[]=$row['lid'];
	}
	return $lid_arr;
}
function getNextSidArr($sid) {
	global $db,$route_table;
	$lid_arr=getLidArrBySid($sid);
	foreach($lid_arr as $lid)
	{
		$sql1="select distinct r2.sid as sid from ".$route_table." r1,".$route_table." r2 where r1.lid=".$lid." and r1.sid=".$sid." and r2.direction=r1.direction and r2.i>r1.i and r2.lid=r1.lid order by r2.i";
		$result1=$db->sql_query($sql1);
		$sid_arr[$lid]=array();
		while($row=$db->sql_fetchrow($result1))
		{
			$sid_arr[$lid][]=$row['sid'];
		}
	}
	return $sid_arr;
}
?>
