<?
//计算起始日期
if(strlen($from_month)<2)
{
	$from_month='0'.$from_month;
}
if(strlen($from_day)<2)
{
	$from_day='0'.$from_day;
}
$from_date=$from_year.'-'.$from_month.'-'.$from_day;
//计算结束日期
if(strlen($to_month)<2)
{
	$to_month='0'.$to_month;
}
if(strlen($to_day)<2)
{
	$to_day='0'.$to_day;
}
$to_date=$to_year.'-'.$to_month.'-'.$to_day;
//如果有选择类型,则在sql语句后添加附加条件
if($prog_kindthr!="")
{
	$extent=" and prog_kindthr=".$prog_kindthr;
}
else
{
	$extent="";
}
include_once "../include/mysql_connect.php";
include_once "../include/getplaypath.php";
$sql1="select prog_id,prog_name,prog_path,prog_indate,del_flag,publisher from prog_info where prog_kindsec=1006 and binary prog_name like '%".$key_prog_name."%' ".$extend." and prog_indate>'".$from_date."' and prog_indate<'".$to_date."' order by prog_id";
$result1=mysql_query($sql1);
?>
<script language="javascript">
function delrecord(prog_id)
{
	
	if(confirm("确定要删除该记录吗?"))
	{
		window.location="prog_delete.php?del_flag=record&prog_id="+prog_id;
	}
	else
		return;
}
function delfile(prog_id)
{
	if(confirm("确定要删除该文件吗？")&&confirm("删除将无法恢复哦！真的确认？"))
	{
		window.location="prog_delete.php?del_flag=file&prog_id="+prog_id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td>序号</td>
	<td>名称</td>
	<td>播放</td>
	<td>录入时间</td>
	<td align=center>文件</td>
	<td align=center>海报</td>
	<td align=center>有效否</td>
	<td align=center>操作</td>
</tr>
<?
$i=0;
while($r=mysql_fetch_array($result1))
{
	$i++;
	$prog_id=$r[0];
	$prog_name=$r[1];
	$prog_path=$r[2];
	$prog_indate=$r[3];
	$del_flag=$r[4];
	$publisher=$r[5];
	if(strlen($prog_name)>18)
	{
		$tmp_prog_name=eregi_replace($key_prog_name,"<span style='color:red'>".$key_prog_name."</span>",substr($prog_name,0,18)).'...';
	}
	else
	{
		$tmp_prog_name=eregi_replace($key_prog_name,"<span style='color:red'>".$key_prog_name."</span>",$prog_name);
	}
	if(strpos($publisher,','))
	{
		$pics = explode(",",$publisher);
		$pic_file=$pics[0];	
	}
	else
	{
		$pic_file=$publisher;
	}
	if($bgcolor!='#d0d0d0')
	{
		$bgcolor='#d0d0d0';
	}
	else
	{
		$bgcolor='#f0f0f0';
	}
	$play_path=getPlayPath($prog_path);
	?>
<tr bgcolor=<?=$bgcolor?>>
	<td align=center><?=$i?></td>
	<td><a href="<?=$play_path?>" title="<?=$prog_name?>"><?=$tmp_prog_name?></a></td>
	<td><?=substr(strrchr($prog_path,"."),1)?></td>
	<td><?=$prog_indate?></td>
	<td align=center>
	<?
	$prog_locate=getLocate($prog_path);
	if($prog_locate=='local')
	{
		$f_unknown=0;
		$f_exist=file_exists("/dpfs/".$prog_path);
		if($f_exist)
		{
			?>
			<a style='color:blue' href='#<?=$prog_id?>' title='文件路径:/dpfs/<?=$prog_path?>'>有</a>
			<?
		}
		else
		{
			?>
			<a style='color:red' href='#<?=$prog_id?>' title='文件路径:/dpfs/<?=$prog_path?>'>无</a>
			<?
		}
	}
	else
	{
		$f_unknown=1;
		?>
		<a style='color:green' href='#<?=$prog_id?>' title="本服务器无法判断文件所在">未知</a>
		<?
	}
	?>
	</td>
	<td align=center>
	<?
	$pic_exist=file_exists("../haibao/".$pic_file);
	if($pic_file!=""&&$pic_exist)
	{
		?>
		<a href=# style="color:blue" onclick="window.open('../haibao/<?=$pic_file?>','','width=450,height=320,toolbar=no,status=no,scrollbars=auto,resizable=yes');" title="查看海报">有</a>
		<?
	}
	else
	{
		?>
		<a href=# style="color:red" onclick="window.open('pic_upload_1.php?pic_type=haibao&id=<?=$prog_id?>&name=<?=$prog_name?>','','width=450,height=120,toolbar=no,status=no,scrollbars=auto,resizable=yes');" title="上传海报">无</a>
		<?
	}
	?>
	</td>
	<td align=center>
	<?
	if($del_flag==1)
	{
		$k++;
		?>
		<span style=color:blue>有效</span>
		<?
	}
	else
	{
		?>
		<span style=color:red>无效</span>
		<?
	}
	?>
	</td>
	<td align=center><input type=button onclick="window.open('vod_modify_prog_1.php?prog_id=<?=$prog_id?>','','width=450,height=605,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="修改"><input type=button onclick='delrecord(<?=$prog_id?>)'
		<?
		if($f_exist||$f_unknown)
			echo " disabled";
		?>
		value="删除记录"><input type=button onclick='delfile(<?=$prog_id?>)'
		<?
		if(!$f_exist||$f_unknown)
			echo " disabled";
		?>
		value="删除文件"></td>
</tr>
<?
}
if($i==0)
{
	?>
	<tr bgcolor=white>
		<td colspan=8 align=center>没有找到包含关键字<span style="color:#1E90FF"><?=$key_prog_name?></span>的记录</td>
	</tr>
	<?
}
?>

<caption>共搜索到<span style="color:#3399cc"><?=$i?></span>个</caption>
</table>
