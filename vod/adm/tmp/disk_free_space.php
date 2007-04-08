<center>
<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption>磁盘空间使用情况</caption>
<tr bgcolor=white>
	<th>目录</th>
	<th align=right>总容量</th>
	<th align=right>已用空间</th>
	<th align=right>可用空间</th>
	<th>已用/可用</th>
</tr>
<?php
require_once 'size_readable.php';
/*
echo "1 decimal, units in brackets, max unit of MB:\n";
$total_size = disk_total_space('/');
echo size_readable($total_size, 'GB', '%01.1f (%s)');
$free_size = disk_free_space('/');
echo size_readable($free_size, 'MB', '%01.1f (%s)');
*/
$dir='/dpfs/bod';
$handle=opendir($dir);
while($file=readdir($handle))
{
	if(is_dir($dir.'/'.$file)&&($file!='.')&&($file!='..')&&($file!='daily_source'))
	{
		$subdir=$dir.'/'.$file;
		$total=size_readable(disk_total_space($subdir),'GB','%01.1f %s');
		$free=size_readable(disk_free_space($subdir),'GB','%01.1f %s');
		$used=size_readable(disk_total_space($subdir)-disk_free_space($subdir),'GB','%01.1f %s');
		$per_free=sprintf("%.1f",(disk_free_space($subdir)/disk_total_space($subdir))*100);
		$per_used=sprintf("%.1f",100-$per_free);
		?>
		<tr bgcolor=white>
			<td><?=$subdir?></td>
			<td align=right><?=$total?></td>
			<td align=right><?=$used?>(<?=$per_used?>%)</td>
			<td align=right><?=$free?>(<?=$per_free?>%)</td>
			<td>
				<table width="100%" height="22" border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td width="<?=$per_used?>%" height="100%" bgcolor="#0000FF"></td>
					<td width="<?=$per_free?>%" bgcolor="#FF00FF"></td>
				</tr>
				</table>
			</td>
		</tr>
		<?
	}
}
?>
</table>
<center>