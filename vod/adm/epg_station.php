<!-- 列出所有频道 -->
<script language="javascript">
function confirmdel(num)
{
	
	if(confirm("确定要删除吗?"))
	{
		window.location="epg_delete_station.php?station_id="+num;
	}
	else
		return;
}

</script>

<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td align=center>序号</td>
	<td align=center>名称</td>
	<td align=center>发布方式</td>
	<td align=center>帧数</td>
	<td align=center>类型</td>
	<td align=center>有效否</td>
	<td align=center><input type=button value="下载节目单" onclick="window.location=('http://www.cctv.com/download/showtime.zip')"><input type=button value="更新所有节目单" onclick="window.location=('index.php?content=epg_schedule_update2')"></td>
</tr>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from epg_station order by type desc,del_flag desc,sort_id";
$result1=mysql_query($sql1);
$i=1;
while($r=mysql_fetch_array($result1))
{
	$station_id		=$r[0];
	$station_name	=$r[1];
	$station_path	=$r[2];
	$fps			=$r[3];
	$type			=$r[4];
	$schedule_url	=$r[5];
	$pubtype		=$r[10];
	if(strlen($station_name)>16)
	{
		$tmp_station_name=substr($station_name,0,16);
	}
	else
	{
		$tmp_station_name=$station_name;
	}
	if($schedule_url=='')
		$schedule_url='#';
	$del_flag		=$r[6];
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
	<td align=center><a title="<?=$station_id?>"><?=$i?></a></td>
	<td><a href="<?=$station_path?>" title="<?=$station_name?>"><?=$tmp_station_name?></a></td>
	<td align=center><?
	if($type=='tv')
	{
		if($pubtype==0)
		{
			echo "<span style='color:#008080'>硬件</span>";
		}
		elseif($pubtype==1)
		{
			echo "<span style='color:#FF00FF'>软件</span>";
		}
		elseif($pubtype==2)
		{
			echo "<span style='color:#FF00FF'>VLC1</span>";
		}
		elseif($pubtype==3)
		{
			echo "<span style='color:#FF00FF'>VLC3</span>";
		}
		elseif($pubtype==4)
		{
			echo "<span style='color:#FF00FF'>VLC5</span>";
		}
		else
		{
			echo "<span style='color:green'>忽略</span>";
		}
	}
	else
	{
		echo "<span style='color:green'>忽略</span>";
	}
	?></td>
	<td align=center><?=$fps?></td>
	<td align=center>
		<?
		if($type=="tv")
		{
			$j++;
			echo "<span style='color:#0066CC'>电视</span>";
		}
		if($type=="radio")
		{
			$k++;
			echo "<span style='color:#ff9922'>电台</span>";
		}
		?></td>
	<td align=center>
	<?
	if($del_flag==1)
	{
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
	<td align=center>
		<input type=button onclick="window.open('epg_modify_station_1.php?station_id=<?=$station_id?>','','width=450,height=280,toolbar=no,status=no,resizable=yes');" value="修改"><input type=button onclick='confirmdel(<?=$station_id?>)' value="删除"><input type=button onclick="window.open('epg_modify_sdp_1.php?station_id=<?=$station_id?>','','width=480,height=120,toolbar=no,status=no,resizable=yes');" value="更新SDP"><input type=button value="更新节目单" onclick="window.location=('index.php?content=epg_schedule_update1&station_id=<?=$station_id?>')"></td>
</tr>
	<?
	$i++;
}
?>
<caption valign=top>已有频道(<span style='color:#0066CC'><?=$j?></span>+<span style='color:#ff9922'><?=$k?></span>=<span style="color:red"><?=$i-1?></span>个)</caption>
</table>
<center><a href="#top">回到顶部</a></center>