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
	global $db,$result;
	
	$sql1="select * from ".LINE_TABLE." l where l.id=".$id;
	$result1=$db->sql_query($sql1);
	$row1=$db->sql_fetchrow($result1);
			
	$sql2="select r.direction as direction,s.id as id,s.name as name from ".SITE_TABLE." s,".ROUTE_TABLE." r where r.lid=".$id." and s.id=r.sid order by r.i";
	$result2=$db->sql_query($sql2);
	while($row2=$db->sql_fetchrow($result2))
	{
		$route_list[$row2['direction']][$row2['id']]=$row2['name'];
	}

	$result .= $row1['name'].'&nbsp;';
	$term1=getSname($row1['term1_sid']);
	$term2=getSname($row1['term2_sid']);
	$result .= '&nbsp;<a href="site_id_'.$row1['term1_sid'].'.html" title="�鿴������'.$term1.'����������·">'.$term1.'</a>('.$row1['term1_start'].'-'.$row1['term1_end'].')';
	$result .= '&nbsp;<a href="site_id_'.$row1['term2_sid'].'.html" title="�鿴������'.$term2.'����������·">'.$term2.'</a>('.$row1['term2_start'].'-'.$row1['term2_end'].')';
	$result .= '&nbsp;Ʊ��:'.$row1['fare_norm'].' '.$row1['fare_cond'];
	$result .= '&nbsp;��ʹ�ù�����:'.$row1['ic_card'].'<br />';
	foreach($route_list as $direction=>$route_info)
	{
		$result .= '<span style="color:#FF00FF">';
		if($direction==1)
		{
			$result .= '����';
		}
		else
		{
			$result .= '����';
		}
		$result .= '��</span>';
		$count=0;
		foreach($route_info as $id=>$name)
		{
	
			$result .= '<a href="site_id_'.$id.'.html" title="�鿴������'.$name.'����������·">'.$name.'</a>';
			if($count!=count($route_info)-1)
			{
				$result .= '��';
				$count++;
			}
		}
		$result .= '</br />';
	}
	$result .= '<br />';
}
function site_info($id) {
	global $db,$result;
	$sql="select distinct(l.id),l.name,s1.name as term1,s2.name as term2 from ".LINE_TABLE." l,".ROUTE_TABLE." r,".SITE_TABLE." s1,".SITE_TABLE." s2 where r.sid=".$id." and r.lid=l.id and l.term1_sid=s1.id and l.term2_sid=s2.id";
	$result=$db->sql_query($sql);
	while($row=$db->sql_fetchrow($result))
	{
		$line_arr[]=$row;
	}
	if(count($line_arr)>0)
	{
		echo '<table borer="0" cellspacing="1" cellpadding="1" bgcolor="#0099CC">';
		echo '<tr bgcolor="#ffffff"><th colspan="3">������'.getSname($id).'���Ĺ�����·('.count($line_arr).'��)</td></tr>';
		echo '<tr bgcolor="#ffffff"><th align="left">���</th><th>��·����</th><th>��㣭�յ�</th></tr>';
		foreach($line_arr as $key=>$line)
		{
			echo '<tr bgcolor="#ffffff"><td>'.($key+1).'</td><td><a href="line_id_'.$line['id'].'.html" title="�鿴��·��'.$line['name'].'����������Ϣ">'.$line['name'].'</a></td><td>'.$line['term1'].'��'.$line['term2'].'</td></tr>';
		}
		echo '</table>';
	}
}
function getResult($from_sid,$to_sid) {
	$result=findNext($from_sid,$to_sid);
	$from=getSname($from_sid);
	$to=getSname($to_sid);
	echo '<table borer="0" cellspacing="1" cellpadding="1" bgcolor="#0099CC">';
	echo '<caption>�ӡ�<a href="site_id_'.$from_sid.'.html" title="�鿴������'.$from.'����������·">'.$from.'</a>������<a href="site_id_'.$to_sid.'.html" title="�鿴������'.$to.'����������·">'.$to.'</a>���ĳ˳�����</caption>';
	echo '<tr bgcolor="#ffffff">';
	echo '<th>���</th>';
//	echo '<th>���</th>';
	echo '<th>������·</th>';
	if(sizeof($result[0])>1)
	{
		echo '<th>����վ��</th>';
		echo '<th>������·</th>';
	}
//	echo '<th>�յ�</th>';
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
	//ȡ�ø�վ������������·�ϵĺ���վ��
	$nextSidArr=getNextSidArr($from_sid);

	$n=0;//���˴���
	$i=0;//���з�����
	$result=array();
	foreach($nextSidArr as $lid=>$sidArr)//����ÿ����·,�ڸ���·�����յ�
	{
		foreach($sidArr as $sid)//��һ����·���Һ���վ��
		{
			if($sid==$to_sid)
			{
				$result[$i][$n]['lid']=$lid;
				$result[$i][$n]['sid']=$sid;
				$i++;
				continue;//�ҵ���վ���������,����һ����·��ȥ��
			}
		}
	}
	if(sizeof($result[$i-1])>0)
	{
		return $result;
	}

	$n++;
	//һ�λ���
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
	//���λ���
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
	//���λ��˶��޽�����Ͳ���������
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
?>