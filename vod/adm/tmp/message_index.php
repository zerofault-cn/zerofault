<script language="javascript">
function del_message(id)
{
	
	if(confirm("ȷ��Ҫɾ����?"))
	{
		window.location="message_delete.php?id="+id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption class=big14>���԰�</caption>
<tr bgcolor=white>
	<td>���</td>
	<td>������</td>
	<td>���Ա���</td>
	<td>����ʱ��</td>
	<td>����</td>
</tr>
<?php
include_once "../include/mysql_connect.php";
if($offset=="")
	$offset=0;
$pageitem=20;
$sql1="select count(*) from admin_message where pid=''";
$sql2="select * from admin_message where pid='' order by id limit ".$offset.",".$pageitem;
$result1=mysql_query($sql1);
$rowCount=mysql_num_rows($result1);
$result2=mysql_query($sql2);
if($rowCount>0)
{
	$i=0;
	while($r=mysql_fetch_array($result2))
	{
		$i++;
		$id=$r['id'];
		$user=$r['user'];
		$title=$r['title'];
		$time=$r['time'];
		$sql3="select count(*) from admin_message where pid=".$id;
		$result3=mysql_query($sql3);
		if($bgcolor!='#d0d0d0')
		{
			$bgcolor='#d0d0d0';
		}
		else
		{
			$bgcolor='#f0f0f0';
		}
		?>
<tr bgcolor=<?=$bgcolor?>>
	<td><?=$i?></td>
	<td><?=$user?></td>
	<td><a href='index.php?content=message_info&id=<?=$id?>'><?=$title?></a><span style="color:blue">(<?=mysql_result($result3,0,0)?>)</span></td>
	<td><?=$time?></td>
	<td><input type=button onclick='del_message(<?=$id?>)' value='ɾ��'></td>
</tr>
		<?
	}
}
?>
<tr bgcolor=white>
	<td colspan=5 align=right><a href='index.php?content=message_insert_1'><span class=red>�������ԡ�</span></a>&nbsp;&nbsp;
	<?
if($offset!=0)
{
	echo "<a href='index.php?content=message_index&offset=0'>����ǰ��</a>&nbsp;&nbsp;";
	$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
	echo "<a href='index.php?content=message_index&offset=$preoffset'>��ǰһҳ��</a>&nbsp;&nbsp;";
}
if(($offset+$pageitem)<$rowCount)
{
	$newoffset=$offset+$pageitem;
	$endpage=$$rowCount-$pageitem;
	echo "<a href='index.php?content=message_index&offset=$newoffset'>����һҳ��</a>&nbsp;&nbsp;";
	echo "<a href='index.php?content=message_index&offset=$endpage'>�����</a>&nbsp;&nbsp;";
}
?>
��ǰ<?=ceil(($rowCount-$offset)/$pageitem)?>/<?=ceil($rowCount/$pageitem)?>,��<?=$rowCount?>��,ÿҳ<?=$pageitem?>��</td></tr>
</table>
