<br>

<br>
<form action='index.php?content=mysql_executeupdate' method=post>
����SQL���:<input type=text name=sql size=50>
<input type=submit value=ִ��>
<form>
<?php
include_once "../include/mysql_connect.php";
if(isset($sql)&&$sql!='')
{
	echo '<br>ִ��SQL:<span class=blue>'.$sql.'</span><br>';
	echo '<table border=1 cellspacing=0 width=100%>';
	echo '<caption>ִ�н��</caption>';
	echo '<tr><th>���</th>';
	$result1=mysql_query($sql);
	for($i=0;$i<mysql_num_fields($result1);$i++)
	{
		echo "<th align=center>".mysql_field_name($result1,$i)."</th>";
	}
	echo '</tr>';
	for($i=0;$i<mysql_num_rows($result1);$i++)
	{
		echo "<tr>";
		echo '<td>'.($i+1).'</td>';
		$row_array=mysql_fetch_row($result1);
		for($j=0;$j<mysql_num_fields($result1);$j++)
		{
			echo "<td align=center>".$row_array[$j]."</td>";
		}
		echo "</tr>";
	}
	echo '</table>';
}
?>
