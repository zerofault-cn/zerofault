<table width=100% border=0 cellpadding=2 cellspacing=0 bordercolor=#c2e0a5 bgcolor=#3399CC rules=rows>
<tr style=color:#FF3300>
	<td align=left width=40%>�������</td>
	<td width=5%>��С</td>
	<td width=17% align=right>�������</td>
	<td width=6% align=right nowrap>���ش���</td>
	<td width=12% align=right>����ʱ��</td>
</tr>
</table>
<?php
$offset=$_REQUEST['offset'];
$searchtype=$_REQUEST['searchtype'];
if($offset=="")
{
	$offset=0;
}
$pageitem=6;
if($searchtype=="")
{
	$query1="select * from software order by id desc limit ".$pageitem;
	$query2=$query1;
}
else
{
	$query1="select * from software where type='".$searchtype."' order by id desc limit ".$offset.",".$pageitem;
	$query2="select * from software where type='".$searchtype."'";
}
$result1=mysql_query($query1);
$result2=mysql_query($query2);
$num1=mysql_num_rows($result1);
$num2=mysql_num_rows($result2);
if($num1==0)
{
	echo"û�пɹ���ѯ����Ϣ";
}
else
{
	$i=0;
	while($r=mysql_fetch_array($result1))
	{
		$i++;
		$id=$r["id"];
		$name=$r["name"];
		$path=$r["path"];
		$info=$r["info"];
		$count=$r["count"];
		$time=$r["time"];
		$size=$r["size"];
		$type=$r["type"];
		$size=$size/1024;
		$size=sprintf ("%.1f", $size);
		?>
		<table width=100% border=1 cellpadding=0 cellspacing=0 bordercolor=#c2e0a5 bgcolor=white>
		<tr><td width=40%><font color=blue><?=$name?></font></td>
			<td width=5%><?=$size?>KB</td>
			<td width=15% align=right><a href='?searchtype=<?=$type?>'><font color=blue><?=$type?></font></a></td>
			<td width=5% align=right><?=$count?></td>
			<td width=15% align=right><?=$time?></td>
		</tr>
		<tr><td colspan=5 bgcolor=white><?=$info?></td></tr>
		<tr><td colspan=5 align=center><a href='download.php?id=<?=$id?>'><span class=red>����</span></a></td>
		</tr>
		</table><br>
		<?
	}
	?>
	<table width=100%>
	<tr><td align=left>
	<?
	if($offset!=0)
	{
		$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
		echo "<a href='?offset=".$preoffset."&infotype=".$infotype."&searchtype=".$type."'>��һҳ</a>&nbsp;&nbsp;";
	}
	else
	{
		echo '��һҳ&nbsp;&nbsp;';
	}
	if(($offset+$pageitem)<$num2)
	{
		$newoffset=$offset+$pageitem;
		$endpage=$num2-$pageitem;
		echo "<a href='?offset=".$newoffset."&infotype=".$infotype."&searchtype=".$type."'>��һҳ</a>";
	}
	else
	{
		echo '��һҳ';
	}
	?>
		</td>
		<td align=right>
		<?
		echo '��ǰ'.(ceil(($num2-$offset)/$pageitem)).'/'.ceil($num2/$pageitem).',��'.$num2.'��,ÿҳ'.$pageitem.'��';
		?>
		</td>
	</tr>
	</table>
	<?
}
?>
