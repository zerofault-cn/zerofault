<!-- 添加或更新节目单-1 -->
<?
include_once "../include/mysql_connect.php";
$sql1="select station_name,schedule_url from epg_station where station_id='".$station_id."'";
$result1=mysql_query($sql1);
$station_name=mysql_result($result1,0,0);
$schedule_url=mysql_result($result1,0,1);
$sql2="select date from epg_schedule where station_id='".$station_id."' and date>=curdate() order by date limit 7";
$result2=mysql_query($sql2);
$date_exist="";
while($r=mysql_fetch_array($result2))
{
	$date_exist=$date_exist.substr($r[0],-5)."、";
}
?>
<script language="javascript">
function check()
{
	if(window.document.add.select_weekday.value!=1)
	{
		alert("您忘了选星期几!");
		return false;
	}
	return true;
}
function add_date()
{
	var today=new Date();
	var new_weekday=parseInt(document.add.weekday.value);
	var now_weekday=parseInt(today.getDay());
	var new_date=today.getYear()+"年"+(today.getMonth()+1)+"月"+(today.getDate()-now_weekday+new_weekday)+"日";
	document.add.program.value=new_date;
}
</script>
<form name=add method=POST action="epg_modify_schedule_2.php" onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=2 bgcolor=black>
<caption>更新《<?=$station_name?>》节目单</caption>
<tr bgcolor=white>
	<td align=right>已有:</td>
	<td><?=$date_exist?></td>
</tr>
<tr bgcolor=white>
	<td align=right>节目单网址:</td>
	<td><a href="<?=$schedule_url?>" target="_blank" title="节目单来源网址"><?=substr($schedule_url,0,50).'...'?></a></td>
</tr>
<tr bgcolor=white>
	<td align=right>选择日期:</td>
	<td><select name=date onchange="document.add.select_date.value=1">
		<option value="">请选择</option>
		<?
		for($i=0;$i<7;$i++)
		{
			?>
			<option value="<?=mktime(0,0,0,date("m"),date("d")+$i,date("Y"))?>"><?=date("Y-m-d",mktime(0,0,0,date("m"),date("d")+$i,date("Y")))?></option>
			<?
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right>节目单:</td>
	<td><textarea name=program rows=25 cols=60>暂无</textarea></td>
</tr>
<tr bgcolor=white>
	<td align=right><input type=hidden name=station_id value="<?=$station_id?>"><input type=hidden name=select_date></td>
	<td><input type=submit value="&nbsp;提交&nbsp;" name=B2></td>
</tr>
</table>
</form>