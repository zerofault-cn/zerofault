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
if($offset=="")
$offset=0;
$pageitem=6;
if($newsearchtype=="multi")
{
	if($section=="multi")
		$sql1="select * from software where name like '%".$keyword."%' or info like '%".$keyword."%' order by id desc limit ".$offset.",".$pageitem;
	else
		$sql1="select * from software where ".$section." like '%".$keyword."%' order by id desc limit ".$offset.",".$pageitem;
}
else
{
	if($section=="multi")
		$sql1="select * from software where (name like '%".$keyword."%' or info like '%".$keyword."%') and type='".$newsearchtype."' order by id desc limit ".$offset.",".$pageitem;
	else
		$sql1="select * from software where ".$section." like '%".$keyword."%' and type='".$newsearchtype."' order by id desc limit ".$offset.",".$pageitem;
}
$result1=mysql_query($sql1);
$num1=mysql_num_rows($result1);
if($num1==0)
{
	echo"<span class=red>�Բ���,û���ҵ���Ҫ�����</span>";
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
		<tr><td width=40%><font color=blue><?php
				if($section=='name'||$section=='multi')
					echo eregi_replace($keyword,"<font color=red>$keyword</font>",$name);
				else
					echo $name;
				?></font></td>
			<td width=5%><?=$size?>KB</td>
			<td width=15% align=right><a href='<?=$PHP_SELF?>?searchtype=<?=$type?>'><font color=blue><?=$type?></font></a></td>
			<td width=5% align=right><?=$count?></td>
			<td width=15% align=right><?=$time?></td>
		</tr>
		<tr><td colspan=5 bgcolor=white>
			<?php
			if($section=='info'||$section=='multi')
				echo eregi_replace($keyword,"<font color=red>$keyword</font>",$info);
			else
				echo $info;
			?></td>
		</tr>
		<tr><td colspan=5 align=center><a href='download.php?id=<?=$id?>'><span class=red>����</span></a></td>
		</tr>
		</table>
		<br>
		<?
	}
	?>
	<table width=100%>
	<tr><td align=left></td>
		<td align=right>
		<?
		echo '���ҵ�<font color=red>'.$i.'</font>�����&nbsp;&nbsp;';
		?>
		</td>
	</tr>
	</table>
	<?
}
?>

