<script language="javascript">
function del(id)
{
	
	if(confirm("ȷ��Ҫɾ�����û���?"))
	{
		window.location="admin_del.php?admin_id="+id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption>����Ա�б�</caption>
<tr bgcolor=white>
	<td align=center>���</td>
	<td align=center>����Ա�ʺ�</td>
	<td align=center>����Ա����</td>
	<td align=center>��Ч��</td>
	<td align=center>ӵ��Ȩ��</td>	
</tr>
<?
include_once "../include/mysql_connect.php";
include_once "admin_limit.php";
$sql1= "select * from admin_info order by admin_id";
$result1=mysql_query($sql1);
$i=0;
while($r=mysql_fetch_array($result1))
{
	$i++;
	$admin_id=$r[0];
	$admin_account=$r[1];
	$admin_name=$r[2];
	$del_flag=$r[6];
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
	<td align=center><?=$i?></td>
	<td align=center><?=$admin_account?></td>
	<td align=center><?=$admin_name?></td>
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
	?></td>
	<td align=center><input type=button onclick="javascript:window.open('admin_modify_info_1.php?admin_id=<?=$admin_id?>','','width=350,height=200,toolbar=no,status=no,scrollbars=auto,resizable=yes')" value="�޸�" title="�޸Ĺ���Ա��������Ч��־"><input type=button onclick='del(<?=$admin_id?>)' value="ɾ��" title="ɾ������Ա"></td>
</tr>
<?
}
?>
</table>
