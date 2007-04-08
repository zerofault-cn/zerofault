<!-- 修改电视电台频道信息-1 -->
<html>
<head>
<title>修改电影节目</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from epg_station where station_id='".$station_id."'";
$result1=mysql_query($sql1);
$station_name=mysql_result($result1,0,1);
$station_path=mysql_result($result1,0,2);
$fps	=mysql_result($result1,0,3);
$type	=mysql_result($result1,0,4);
$schedule_url=mysql_result($result1,0,5);
$del_flag=mysql_result($result1,0,6);
$zoom_flag=mysql_result($result1,0,7);
$force_flag=mysql_result($result1,0,8);
$sort_id=mysql_result($result1,0,9);
$pubtype=mysql_result($result1,0,10);
$sql2="select count(*) from epg_station where type='".$type."'";
$result2=mysql_query($sql2);
$rowCount=mysql_result($result2,0,0);
?>
<body>
<form action="epg_modify_station_2.php" method=post name=modify>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>修改频道信息</caption>
<tr bgcolor=white>
	<td align=right>类型:</td>
	<td><?
		if($type=="tv")
		{
			$j++;
			echo "<span style='color:#0066CC'>电视机</span>";
		}
		if($type=="radio")
		{
			$k++;
			echo "<span style='color:#ff9922'>收音机</span>";
		}
		?></td>
</tr>
<tr bgcolor=white>
	<td align=right>名称:</td>
	<td><input type=text name=station_name value="<?=$station_name?>" size=18>&nbsp;&nbsp;
		发布方式:<select name=pubtype>
		<option value="0" 
		<?
		if($pubtype==0)
			echo " selected";
		?>
		>硬件发布</option>
		<option value="1" 
		<?
		if($pubtype==1)
			echo " selected";
		?>
		>软件发布</option>
		<option value="2" 
		<?
		if($pubtype==2)
			echo " selected";
		?>
		>VLC1方式</option>
		<option value="3" 
		<?
		if($pubtype==3)
			echo " selected";
		?>
		>VLC3方式</option>
		<option value="4" 
		<?
		if($pubtype==4)
			echo " selected";
		?>
		>VLC5方式</option>
		</select>
		</td>
</tr>
<tr bgcolor=white>
	<td align=right>播放路径</td>
	<td><input type=text name=station_path size=48 value="<?=$station_path?>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>帧数:</td>
	<td><input type=text name=fps size=5 value="<?=$fps?>"
		<?
		if($type=="radio")
		echo " readonly";
		?>
		><span class=small>(硬件方式可以为0)</span> | 设定显示顺序:<select name=sort_id>
		<?
		for($i=1;$i<=$rowCount;$i++)
		{
			if($i%7==1)
			{
				echo "<option value=0>--".ceil($i/7)."--</option>";
			}
			echo '<option value='.$i;
			if($i==$sort_id)
				echo ' selected';
			echo '>'.$i.'</option>';
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right>缩放标志:</td>
	<td><select name=zoom_flag
		<?
		if($type=="radio")
		echo " readonly";
		?>
		>
		<option value="1" 
		<?
		if($zoom_flag==1)
			echo " selected";
		?>
		>缩放</option>
		<option value="0" 
		<?
		if($zoom_flag==0)
			echo " selected";
		?>
		>不缩放</option></select><span class=small>(除组播连续剧不需要缩放外,其他节目都需要)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>有效标志:</td>
	<td><select name=del_flag>
		<option value="1" 
		<?
		if($del_flag==1)
			echo " selected";
		?>
		>有效</option>
		<option value="-1" 
		<?
		if($del_flag==-1)
			echo " selected";
		?>
		>无效</option></select><span class=small>(只有设置为有效用户才能看到)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>更新标志:</td>
	<td><select name=force_flag
		<?
		if($type=="radio")
		echo " readonly";
		?>
		>
		<option value="1" 
		<?
		if($force_flag==1)
			echo " selected";
		?>
		>强制更新</option>
		<option value="-1" 
		<?
		if($force_flag==0)
			echo " selected";
		?>
		>不更新</option></select><span class=small>(只有当sdp文件更新后才设置为强制更新)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>节目单网址</td>
	<td><input type=text name="schedule_url" size=48 value="<?=$schedule_url?>"></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value=提交修改>&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
<input type=hidden name=station_id value="<?=$station_id?>">
</form>
</body>
</html>
