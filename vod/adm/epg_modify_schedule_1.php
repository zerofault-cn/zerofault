<!-- ��ӻ���½�Ŀ��-1 -->
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
	$date_exist=$date_exist.substr($r[0],-5)."��";
}
?>
<script language="javascript">
function check()
{
	if(window.document.add.select_weekday.value!=1)
	{
		alert("������ѡ���ڼ�!");
		return false;
	}
	return true;
}
function add_date()
{
	var today=new Date();
	var new_weekday=parseInt(document.add.weekday.value);
	var now_weekday=parseInt(today.getDay());
	var new_date=today.getYear()+"��"+(today.getMonth()+1)+"��"+(today.getDate()-now_weekday+new_weekday)+"��";
	document.add.program.value=new_date;
}
</script>
<form name=add method=POST action="epg_modify_schedule_2.php" onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=2 bgcolor=black>
<caption>���¡�<?=$station_name?>����Ŀ��</caption>
<tr bgcolor=white>
	<td align=right>����:</td>
	<td><?=$date_exist?></td>
</tr>
<tr bgcolor=white>
	<td align=right>��Ŀ����ַ:</td>
	<td><a href="<?=$schedule_url?>" target="_blank" title="��Ŀ����Դ��ַ"><?=substr($schedule_url,0,50).'...'?></a></td>
</tr>
<tr bgcolor=white>
	<td align=right>ѡ������:</td>
	<td><select name=date onchange="document.add.select_date.value=1">
		<option value="">��ѡ��</option>
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
	<td align=right>��Ŀ��:</td>
	<td><textarea name=program rows=25 cols=60>����</textarea></td>
</tr>
<tr bgcolor=white>
	<td align=right><input type=hidden name=station_id value="<?=$station_id?>"><input type=hidden name=select_date></td>
	<td><input type=submit value="&nbsp;�ύ&nbsp;" name=B2></td>
</tr>
</table>
</form>