<table width=100% border=0 cellpadding=2 cellspacing=0 bordercolor=#c2e0a5 bgcolor=#3399CC rules=rows>
<tr style=color:#FF3300>
	<td align=left width=40%>软件名称</td>
	<td width=5%>大小</td>
	<td width=17% align=right>软件类型</td>
	<td width=6% align=right nowrap>下载次数</td>
	<td width=12% align=right>更新时间</td>
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
	echo"<span class=red>对不起,没有找到您要的软件</span>";
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
		<tr><td colspan=5 align=center><a href='download.php?id=<?=$id?>'><span class=red>下载</span></a></td>
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
		echo '共找到<font color=red>'.$i.'</font>个软件&nbsp;&nbsp;';
		?>
		</td>
	</tr>
	</table>
	<?
}
?>

