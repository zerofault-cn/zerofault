<script language="javascript">
function check()
{
	
	if(window.document.add.select_flag.value!=1)
	{
		alert("您忘了选择分类");
		return false;
	}
	if(window.document.add.file_name.value=="")
	{
		alert("您忘了输入名称");
		document.add.file_name.focus();
		return false;
	}
	if(window.document.add.torrent_file.value!="")
	{
		torrent_file=window.document.add.torrent_file.value;
		torrent_file_ext=torrent_file.substring(torrent_file.lastIndexOf("."));
		if(torrent_file_ext!='.torrent')
		{
			alert("种子文件后缀必须是.torrent");
			document.add.torrent_file.focus();
			return false;
		}
		else
			return true;
	}
	else
	{
		alert("您没有选择文件");
		return false;
	}
	return true;
}
function confirmdel(file_id)
{
	
	if(confirm("确定要删除吗?"))
	{
		window.location="bt_delete_source.php?file_id="+file_id;
	}
	else
		return;
}
</script>
<form action="bt_add_source_2.php" method=post name=add ENCTYPE="multipart/form-data" onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加BT_source</caption>
<tr bgcolor=white>
	<td align=right>选择分类:</td>
	<td><select name=file_type_id onchange="document.add.select_flag.value=1">
		<option >选择分类</a>
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
		</select>&nbsp;&nbsp;<a href="index.php?content=bt_add_type_1">添加分类</a></td>
</tr>
<tr bgcolor=white>
	<td align=right>选择种子文件:</td>
	<td><input type=file name=torrent_file size=40></td>
</tr>
<tr bgcolor=white>
	<td align=right>种子名:</td>
	<td><input name=file_name size=10></td>
</tr>
<tr bgcolor=white>
	<td align=right>文件大小:</td>
	<td><input name=file_size size=10></td>
</tr>
<tr bgcolor=white>
	<td align=right></td>
	<td><input type=submit value="&nbsp;&nbsp;提&nbsp;&nbsp;交&nbsp;&nbsp;" ></td>
</tr>
</table>
<input type=hidden name=select_flag>
</form>
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>已存在资源列表</caption>
<tr bgcolor=white>
	<td align=center>所在分类</td>
	<td align=center>种子名称</td>
	<td align=center>种子URL</td>
	<td align=center>文件大小</td>
	<td align=center>操作</td>
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
	<td align=center><button onclick='confirmdel(<?=$r["file_id"]?>)'>删除</button></td>
</tr>
<?
	}
	?>
</table>
