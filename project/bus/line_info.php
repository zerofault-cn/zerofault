<?php
function line_info($id) {
	global $db,$site_table,$route_table,$line_table;
	
	$sql1="select * from ".$line_table." l where l.id=".$id;
	$result1=$db->sql_query($sql1);
	$row1=$db->sql_fetchrow($result1);
			
	$sql2="select r.direction as direction,s.id as id,s.name as name from ".$site_table." s,".$route_table." r where r.lid=".$id." and s.id=r.sid order by r.i";
	$result2=$db->sql_query($sql2);
	while($row2=$db->sql_fetchrow($result2))
	{
		$route_list[$row2['direction']][$row2['id']]=$row2['name'];
	}

	
	echo $row1['name'].'&nbsp;';
	$term1=getSname($row1['term1_sid']);
	$term2=getSname($row1['term2_sid']);
	echo '&nbsp;<a href="?action=query_site&id='.$row1['term1_sid'].'" title="�鿴������'.$term1.'����������·">'.$term1.'</a>('.$row1['term1_start'].'-'.$row1['term1_end'].')';
	echo '&nbsp;<a href="?action=query_site&id='.$row1['term2_sid'].'" title="�鿴������'.$term2.'����������·">'.$term2.'</a>('.$row1['term2_start'].'-'.$row1['term2_end'].')';
	echo '&nbsp;Ʊ��:'.$row1['fare_norm'].' '.$row1['fare_cond'];
	echo '&nbsp;��ʹ�ù�����:'.$row1['ic_card'].'<br />';
	foreach($route_list as $direction=>$route_info)
	{
		echo '<span style="color:#FF00FF">';
		if($direction==1)
		{
			echo '����';
		}
		else
		{
			echo '����';
		}
		echo '��</span>';
		foreach($route_info as $id=>$name)
		{
	
			echo '<a href="?action=query_site&id='.$id.'" title="�鿴������'.$name.'����������·">'.$name.'</a>';
			if($index!=(sizeof($route_info)-1))
			{
				echo '��';
			}
		}
		echo '</br />';
	}
	echo '<br />';
}
?>