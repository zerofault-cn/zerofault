<table width="100%" border=1 cellpadding=0 cellspacing=0 bordercolor=#d0dce0 >
<caption>��վ��������ϸͳ��</caption>
<tr bgcolor=#3399CC>
	<td align=center>���</td>
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
	echo"���޼�¼";
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
	echo "<a href='".$_SERVER['REQUEST_URI']."&offset=0'>����ǰ��</a>&nbsp;&nbsp;";
	$preoffset=$offset-$pageitem;
	echo "<a href='".$_SERVER['REQUEST_URI']."&offset=$preoffset'>��ǰһҳ��</a>&nbsp;&nbsp;";
}
if(($offset+$pageitem)<$num2)
{
	$newoffset=$offset+$pageitem;
	$endpage=$num2-$pageitem;
	echo "<a href='".$_SERVER['REQUEST_URI']."&offset=$newoffset'>����һҳ��</a>&nbsp;&nbsp;";
	echo "<a href='".$_SERVER['REQUEST_URI']."&offset=$endpage'>�����</a>&nbsp;&nbsp;";
}
echo (ceil(($num2-$offset)/$pageitem))."/".ceil($num2/$pageitem)." ÿҳ".$pageitem."��";
?>
</td>
</tr>
</table>
��ĿǰΪֹ����<span class=red><?=$num2?></span>�˷��ʼ���ͨ��ҳ!
