<!-- ��ӵ�Ӱ���-1 -->
<script language="javascript">
function check()
{
	
	if(window.document.add.dentry_name.value=="")
	{
		alert("���������������");
		document.add.dentry_name.focus();
		return false;
	}
	return true;
}

function delrecord(dentry_id)
{
	
	if(confirm("ȷ��Ҫɾ����?"))
	{
		window.location="vod_delete_type.php?dentry_id="+dentry_id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption>�Ѵ��ڵĵ�Ӱ����</caption>
<tr bgcolor=white>
	<td align=center>���</td>
	<td align=center>�������</td>
	<td align=center>��Ч��</td>
	<td align=center>����</td>
</tr>
<?
include_once "../include/mysql_connect.php";
//setcookie("lastpage",$_SERVER["REQUEST_URI"]);
$sql1="select dentry_id,dentry_name,del_flag from dict_entry where dtype_id=50 order by dentry_id";
$result1=mysql_query($sql1);
$i=0;
while($r=mysql_fetch_array($result1))
{
	$i++;
	$dentry_id=$r[0];
	$dentry_name=$r[1];
	$del_flag=$r[2];
	$sql2="select count(*) from prog_info where prog_kindthr=".$dentry_id;
	$result2=mysql_query($sql2);
	$prog_count=mysql_result($result2,0,0);
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
	<td align=center><a href="index.php?content=vod_prog&dentry_id=<?=$dentry_id?>"><?=$dentry_name?></a></td>
	<td align=center>
	<?
	if($del_flag==1) 
		echo "<span style=color:blue>��Ч</span>";
	else
		echo "<span style=color:red>��Ч</span>";
	?>
	</td>
	<td align=center>
		<input type=button onclick="window.open('vod_modify_type_1.php?dentry_id=<?=$dentry_id?>','','width=400,height=300,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="�޸�">
		<input type=button onclick='delrecord(<?=$dentry_id?>)' value="ɾ��"
		<?
		if($prog_count>0)
		{
			echo ' disabled';
		}
		?>>
		</td>
</tr>
<?
}
?>

<form action="vod_add_type_2.php" method=post name=add onsubmit="return check();">
<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption>����µķ���</caption>
<tr bgcolor=white>
	<td align=right>��������:</td>
	<td><input name=dentry_name></td>
</tr>
<tr bgcolor=white>
	<td align=right>��̽���:</td>
	<td><textarea name=dentry_describe cols=30 rows=4>������</textarea></td>
</tr>
<tr  bgcolor=white>
	<td></td>
	<td><input type=submit value="&nbsp;&nbsp;��&nbsp;&nbsp;��&nbsp;&nbsp;"></td>
</tr>
</table>
</form>
