<!-- CREATE TABLE `daily_type` (`id` TINYINT (3) UNSIGNED DEFAULT '0' AUTO_INCREMENT, `type_name` VARCHAR (64), `type_descr` VARCHAR (255), `del_flag` TINYINT (3) UNSIGNED DEFAULT '1', INDEX(`id`))  -->
<script language="javascript">
function check()
{
	
	if(window.document.add.daily_type_name.value=="")
	{
		alert("���������������");
		document.add.daily_type_name.focus();
		return false;
	}
	return true;
}
function deltype(id)
{
	
	if(confirm("ȷ��Ҫɾ����?"))
	{
		window.location="daily_delete_type.php?id="+id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=2 bgcolor=black>
<tr bgcolor=white>
	<td align=center>��������</td>
	<td align=center>���</td>
	<td align=center>��Ч��־</td>
	<td align=center>����</td>
</tr>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from daily_type order by id";
$result1=mysql_query($sql1);
$i=0;
while($r=mysql_fetch_array($result1))
{
	$i++;
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
	<td align=center><a href='index.php?content=daily_source&type=<?=$r["id"]?>'><?=$r["type_name"]?></a></td>
	<td><?=$r["type_descr"]?></td>
	<td align=center>
	<?
	$del_flag=$r["del_flag"];
	if($del_flag==1)
	{
		$k++;
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
	?></td>
	<td align=center><input type=button onclick="window.open('daily_modify_type_1.php?id=<?=$r["id"]?>','','width=400,height=220,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="�޸�"><input type=button onclick='deltype(<?=$r["id"]?>)' value='ɾ��'></td></tr>
	<?
}
?>
<caption>�����������з���<span class=small style="color:blue">(��<?=$i?>��)</span></caption>
</table>
<form action="daily_add_type_2.php" method=post name=add onsubmit="return check();">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=2 bgcolor=black>
<caption>����µķ���</caption>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>��������:</td>
	<td><input name=type_name size=30 maxlength=30></td>
</tr>
<tr bgcolor=white>
	<td align=right>��̽���:</td>
	<td><textarea name=type_descr cols=40 rows=4></textarea></td>
</tr>
<tr  bgcolor=white>
	<td></td>
	<td><input type=submit value="&nbsp;&nbsp;��&nbsp;&nbsp;��&nbsp;&nbsp;"></td>
</tr>
</table>
</form>
