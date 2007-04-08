<?
include_once "../include/mysql_connect.php";

if($prog_kindthr!="")
{
	$type_condition=" and prog_info.prog_kindthr='".$prog_kindthr."' ";
}
else
{
	$type_condition="";
}

if(($from_date!="")&&($to_date!=""))
{
	$date_condition=" and movie_statistic.point_date>='".$from_date."' and movie_statistic.point_date<='".$to_date."' ";
}
else
{
	$date_condition="";
}

if($key_prog_name!="")
{
	$name_condition=" and prog_info.prog_name like '%".$key_prog_name."%' ";
}
else
{
	$name_condition="";
}

$sql1="select prog_info.prog_id,prog_info.prog_name,prog_info.prog_indate,dict_entry.dentry_id,dict_entry.dentry_name,movie_statistic.prog_path,count(movie_statistic.prog_path) from dict_entry,prog_info,movie_statistic where dict_entry.dentry_id=prog_info.prog_kindthr and movie_statistic.prog_path=prog_info.prog_path ".$name_condition.$type_condition.$date_condition." group by movie_statistic.prog_path order by 7 DESC";
$result1=mysql_query($sql1);

?>
	
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>统计结果</caption>
  
<tr bgcolor=white>
	<td align=center>序号</td>
	<td align=center>电影名称</td>
	<td align=center>上传时间</td>
	<td align=center>电影类别</td>
	<td align=center>播放路径</td>
	<td align=center>点击次数</td>
</tr>

<?
$i=1;
while($tmp=mysql_fetch_array($result1))
{
	$prog_id=$tmp[0];
	$prog_name=$tmp[1];
	$prog_indate=$tmp[2];
	$dentry_id=$tmp[3];
	$dentry_name=$tmp[4];
	$prog_path=$tmp[5];
	$statistic_num=$tmp[6];
	if(strlen($prog_name)>18)
		$tmp_prog_name=substr($prog_name,0,18)."...";
	else
		$tmp_prog_name=$prog_name;
	$prog_ip=getIpByPath($prog_path);
	$p_ip=substr(strrchr($prog_ip,"."),1);
	$server_ip=getServerIp();
	$s_ip=substr(strrchr($server_ip,"."),1);
	if($s_ip!=87&&$s_ip!=88&&$s_ip!=89&&$s_ip!=90&&$s_ip!=91&&$s_ip!=92)
	{
		$prog_ip=$server_ip;
	}
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
	<td align=center><?=$i++?></td>
	<td><a href="#<?=$prog_id?>" title="<?=$prog_name?>"><?=$tmp_prog_name?></a></td>
	<td><?=$prog_indate?></td>
	<td align=center><a href="?content=vod_prog&dentry_id=<?=$dentry_id?>"><?=$dentry_name?></a></td>
	<td><a href="lrtsp://<?=$prog_ip?>/<?=$prog_path?>" title="<?=$prog_path?>">lrtsp://.mp4</a></td>
	<td align=center><?=$statistic_num?></td>
</tr>
<?
}
?>
</table>
