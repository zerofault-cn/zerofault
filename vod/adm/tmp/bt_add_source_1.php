<script language="javascript">
function check()
{
	
	if(window.document.add.select_flag.value!=1)
	{
		alert("������ѡ�����");
		return false;
	}
	if(window.document.add.file_name.value=="")
	{
		alert("��������������");
		document.add.file_name.focus();
		return false;
	}
	if(window.document.add.torrent_file.value!="")
	{
		torrent_file=window.document.add.torrent_file.value;
		torrent_file_ext=torrent_file.substring(torrent_file.lastIndexOf("."));
		if(torrent_file_ext!='.torrent')
		{
			alert("�����ļ���׺������.torrent");
			document.add.torrent_file.focus();
			return false;
		}
		else
			return true;
	}
	else
	{
		alert("��û��ѡ���ļ�");
		return false;
	}
	return true;
}
function confirmdel(file_id)
{
	
	if(confirm("ȷ��Ҫɾ����?"))
	{
		window.location="bt_delete_source.php?file_id="+file_id;
	}
	else
		return;
}
</script>
<form action="bt_add_source_2.php" method=post name=add ENCTYPE="multipart/form-data" onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>���BT_source</caption>
<tr bgcolor=white>
	<td align=right>ѡ�����:</td>
	<td><select name=file_type_id onchange="document.add.select_flag.value=1">
		<option >ѡ�����</a>
		<?
		include_once "../include/mysql_connect.php";
		$sql1="select * from bt_file_type order by file_type_id";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?=$r["file_type_id"]?>"><?=$r["file_type_name"]?></option>
			<?
		}
		?>
		</select>&nbsp;&nbsp;<a href="index.php?content=bt_add_type_1">��ӷ���</a></td>
</tr>
<tr bgcolor=white>
	<td align=right>ѡ�������ļ�:</td>
	<td><input type=file name=torrent_file size=40></td>
</tr>
<tr bgcolor=white>
	<td align=right>������:</td>
	<td><input name=file_name size=10></td>
</tr>
<tr bgcolor=white>
	<td align=right>�ļ���С:</td>
	<td><input name=file_size size=10></td>
</tr>
<tr bgcolor=white>
	<td align=right></td>
	<td><input type=submit value="&nbsp;&nbsp;��&nbsp;&nbsp;��&nbsp;&nbsp;" ></td>
</tr>
</table>
<input type=hidden name=select_flag>
</form>
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>�Ѵ�����Դ�б�</caption>
<tr bgcolor=white>
	<td align=center>���ڷ���</td>
	<td align=center>��������</td>
	<td align=center>����URL</td>
	<td align=center>�ļ���С</td>
	<td align=center>����</td>
</tr>
	<?
	$sql2="select * from bt_file_info,bt_file_type where bt_file_type.file_type_id=bt_file_info.file_type_id order by bt_file_info.time desc";
	$result2=mysql_query($sql2);
	while($r=mysql_fetch_array($result2))
	{
?>
<tr bgcolor=white>
	<td align=center><?=$r["file_type_name"]?></td>
	<td><?=$r["file_name"]?></td>
	<td><?=$r["file_url"]?></td>
	<td align=center><?=$r["file_size"]?></td>
	<td align=center><button onclick='confirmdel(<?=$r["file_id"]?>)'>ɾ��</button></td>
</tr>
<?
	}
	?>
</table>
