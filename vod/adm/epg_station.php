<!-- �г�����Ƶ�� -->
<script language="javascript">
function confirmdel(num)
{
	
	if(confirm("ȷ��Ҫɾ����?"))
	{
		window.location="epg_delete_station.php?station_id="+num;
	}
	else
		return;
}

</script>

<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td align=center>���</td>
	<td align=center>����</td>
	<td align=center>������ʽ</td>
	<td align=center>֡��</td>
	<td align=center>����</td>
	<td align=center>��Ч��</td>
	<td align=center><input type=button value="���ؽ�Ŀ��" onclick="window.location=('http://www.cctv.com/download/showtime.zip')"><input type=button value="�������н�Ŀ��" onclick="window.location=('index.php?content=epg_schedule_update2')"></td>
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
			echo "<span style='color:#008080'>Ӳ��</span>";
		}
		elseif($pubtype==1)
		{
			echo "<span style='color:#FF00FF'>���</span>";
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
			echo "<span style='color:green'>����</span>";
		}
	}
	else
	{
		echo "<span style='color:green'>����</span>";
	}
	?></td>
	<td align=center><?=$fps?></td>
	<td align=center>
		<?
		if($type=="tv")
		{
			$j++;
			echo "<span style='color:#0066CC'>����</span>";
		}
		if($type=="radio")
		{
			$k++;
			echo "<span style='color:#ff9922'>��̨</span>";
		}
		?></td>
	<td align=center>
	<?
	if($del_flag==1)
	{
		?>
		<span style=color:blue>��Ч</span>
		<?
	}
	else
	{
		?>
		<span style=color:red>��Ч</span>
		<?
	}
	?>
	</td>
	<td align=center>
		<input type=button onclick="window.open('epg_modify_station_1.php?station_id=<?=$station_id?>','','width=450,height=280,toolbar=no,status=no,resizable=yes');" value="�޸�"><input type=button onclick='confirmdel(<?=$station_id?>)' value="ɾ��"><input type=button onclick="window.open('epg_modify_sdp_1.php?station_id=<?=$station_id?>','','width=480,height=120,toolbar=no,status=no,resizable=yes');" value="����SDP"><input type=button value="���½�Ŀ��" onclick="window.location=('index.php?content=epg_schedule_update1&station_id=<?=$station_id?>')"></td>
</tr>
	<?
	$i++;
}
?>
<caption valign=top>����Ƶ��(<span style='color:#0066CC'><?=$j?></span>+<span style='color:#ff9922'><?=$k?></span>=<span style="color:red"><?=$i-1?></span>��)</caption>
</table>
<center><a href="#top">�ص�����</a></center>