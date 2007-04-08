<table width="100%" border=1 cellpadding=0 cellspacing=0 bordercolor=#d0dce0 >
<caption>网站访问量详细统计</caption>
<tr bgcolor=#3399CC>
	<td align=center>序号</td>
	<td align=center>ip</td>
	<td align=center>address</td>
	<td align=center>os</td>
	<td align=center>browse</td>
	<td align=center>time</td>
</tr>
<?php
include_once "../include/mysql_connect.php";
if($offset=="")
{
	$offset=0;
}
$pageitem=20;
$sql1="select * from user_count order by id desc limit ".$offset.",".$pageitem;
$sql2="select * from user_count";
$result1=mysql_query($sql1);
$result2=mysql_query($sql2);
$num1=mysql_num_rows($result1);
$num2=mysql_num_rows($result2);
if($num1==0)
{
	echo"暂无记录";
}
else
{
	while($r=mysql_fetch_array($result1))
	{
		$id=$r["id"];
		$ip=$r["ip"];
		$address=$r["address"];
		$os=$r["os"];
		$browse=$r["browse"];
		$time=$r["time"];
		?>
		<tr>
		<td><?=$id?></td>
		<td><?=$ip?></td>
		<td><?=$address?></td>
		<td><?=$os?></td>
		<td><?=$browse?></td>
		<td><?=$time?></td>
		</tr>
		<?
	}
}
?>
<tr>
<td colspan=6 align=right>
<?
if($offset!=0)
{
	echo "<a href='".$_SERVER['REQUEST_URI']."&offset=0'>【最前】</a>&nbsp;&nbsp;";
	$preoffset=$offset-$pageitem;
	echo "<a href='".$_SERVER['REQUEST_URI']."&offset=$preoffset'>【前一页】</a>&nbsp;&nbsp;";
}
if(($offset+$pageitem)<$num2)
{
	$newoffset=$offset+$pageitem;
	$endpage=$num2-$pageitem;
	echo "<a href='".$_SERVER['REQUEST_URI']."&offset=$newoffset'>【后一页】</a>&nbsp;&nbsp;";
	echo "<a href='".$_SERVER['REQUEST_URI']."&offset=$endpage'>【最后】</a>&nbsp;&nbsp;";
}
echo (ceil(($num2-$offset)/$pageitem))."/".ceil($num2/$pageitem)." 每页".$pageitem."条";
?>
</td>
</tr>
</table>
到目前为止共有<span class=red><?=$num2?></span>人访问家易通主页!
