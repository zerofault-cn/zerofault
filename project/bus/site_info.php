<?php
function site_info($id) {
	global $db,$site_table,$route_table,$line_table;
	$sql="select distinct(l.id),l.name,s1.name as term1,s2.name as term2 from ".$line_table." l,".$route_table." r,".$site_table." s1,".$site_table." s2 where r.sid=".$id." and r.lid=l.id and l.term1_sid=s1.id and l.term2_sid=s2.id";
	$result=$db->sql_query($sql);
	while($row=$db->sql_fetchrow($result))
	{
		$line_arr[]=$row;
	}
	if(count($line_arr)>0)
	{
		echo '<table borer="0" cellspacing="1" cellpadding="1" bgcolor="#0099CC">';
		echo '<tr bgcolor="#ffffff"><td colspan="3">������'.getSname($id).'���Ĺ�����·('.count($line_arr).'��)</td></tr>';
		echo '<tr bgcolor="#ffffff"><th align="left">���</th><th>��·����</th><th>��㣭�յ�</th></tr>';
		foreach($line_arr as $key=>$line)
		{
			echo '<tr bgcolor="#ffffff"><td>'.($key+1).'</td><td><a href="?action=query_line&id='.$line['id'].'" title="�鿴��·��'.$line['name'].'����������Ϣ">'.$line['name'].'</a></td><td>'.$line['term1'].'��'.$line['term2'].'</td></tr>';
		}
		echo '</table>';
	}
}
?>
