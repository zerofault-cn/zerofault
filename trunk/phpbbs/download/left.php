<table width=100% border=0 cellpadding=2 cellspacing=0 bordercolor=#c2e0a5 rules=rows>
<tr><td align=right width=100% bgcolor=#3399cc>软件分类</td></tr>
<?php
$query1="select * from software group by type order by id";
$query2="Select count(*) from software";
$result1=mysql_query($query1);
$result2=mysql_query($query2);
$num1=mysql_num_rows($result1);
while($r=mysql_fetch_array($result1))
{
	$type=$r["type"];
	echo "<tr><td bgcolor=#d0dce0 align=right height=32 background='/phpbbs/image/table_bg.gif'><a href='".$PHP_SELF."?searchtype=".$type."'>".$type."</td></tr>";
}
?>
<tr><td>目前有<span class=red><?=mysql_result($result2,'count(*)')?></span>个软件入库</td></tr>
</table>