<script language="javascript">
function check()
{
	
	if(window.document.add.name.value=="")
	{
		alert("�����˼�����Ŀ��");
		document.add.name.focus();
		return false;
	}
	return true;
}
function del(id)
{
	
	if(confirm("ȷ��Ҫɾ����?"))
	{
		window.location="server_stat_delete_path.php?id="+id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 cellspacing=1 cellpadding=2 bgcolor=black>
<tr bgcolor=white>
	<td align=center>ͳ����Ŀ����</td>
	<td align=center>·��</td>
	<td align=center>���</td>
	<td align=center>��Ч��־</td>
	<td align=center>����</td>
</tr>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from server_stat_path order by id";
$result1=mysql_query($sql1);
$i=0;
while($r=mysql_fetch_array($result1))
{
	$i++;
	$path=$r["path"];
	if(strpos($path,'?'))
	{
		$tmp_path=substr($path,0,strpos($path,'?'));
	}
	else
	{
		$tmp_path=$path;
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
	<td align=center><a href='index.php?content=server_stat&id=<?=$r["id"]?>'><?=$r["name"]?></a></td>
	<td><a title='<?=urldecode($path)?>'><?=$tmp_path?></a></td>	
	<td><?=$r["descr"]?></td>
	<td align=center>
	<?
	$id=$r["id"];
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
	<td align=center><input type=button onclick="window.open('','','width=400,height=220,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="�޸�" disabled><input type=button onclick='del(<?=$id?>)' value='ɾ��'></td></tr>
	<?
}
?>
<caption>ϵͳͳ����Ŀ�б�<span class=small style="color:blue">(��<?=$i?>��)</span></caption>
</table>
<form action="server_stat_add_path_2.php" method=post name=add onsubmit="return check();">
<table width="100%" border=0 cellspacing=1 cellpadding=2 bgcolor=black>
<caption>����µ�ͳ����Ŀ</caption>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>��Ŀ����:</td>
	<td><input name=name size=30 maxlength=30></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>��Ӧ·��:</td>
	<td><input name=path size=50></td>
</tr>
<tr bgcolor=white>
	<td align=right>��̽���:</td>
	<td><textarea name=descr cols=40 rows=4></textarea></td>
</tr>
<tr  bgcolor=white>
	<td></td>
	<td><input type=submit value="&nbsp;&nbsp;��&nbsp;&nbsp;��&nbsp;&nbsp;"></td>
</tr>
<tr  bgcolor=white>
	<td colspan=2>
	��ʾ��<br>
	1.��Ŀ���ƿ������ȡ.<br>
	2.·����Ҫ�����Ӧҳ��(������)��url,��Ҫͳ�����˵�(http://sntx.169ol.com:8088/menu_1.php)�ķ�����,ֻ��Ҫ����menu_1.php�Ϳ�����.<br>
	</td>
</tr>
</table>
</form>
