<?
include_once "../include/mysql_connect.php";
$sql1="select * from flash_type order by id";
$result1=mysql_query($sql1);
?>
<script language="javascript">
function check()
{
	
	if(window.document.add.select_flag.value!=1)
	{
		alert("������ѡ�����");
		return false;
	}
	if(window.document.add.flashfile.value=="")
	{
		alert("������ѡ���ļ�");
		return false;
	}
	str=window.document.add.flashfile.value;
	str=str.substring(str.lastIndexOf('\\')+1);
//		if(/[^\x00-\xff]/g.test(str))
		{
//			alert("�ļ������ܺ��к����ַ�");
//			document.addmp3.mp3file.focus();
//			return false;
		}
	if(/[\x27]/g.test(str))
	{
		alert("�ļ������ܺ��е�����");
		document.add.flashfile.focus();
		return false;
	}
	return true;
}
function confirmdel(id)
{
	
	if(confirm("ȷ��Ҫɾ��"+id+"��?"))
	{
		window.location="flash_delete_source.php?id="+id;
	}
	else
		return;
}
</script>
</HEAD>

<form action="flash_add_source_2.php" method=post name=add ENCTYPE="multipart/form-data" onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=2 bgcolor=black>
<caption>�ϴ�Flash</caption>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>ѡ�����:</td>
	<td><select name=type_id onchange="document.add.select_flag.value=1">
		<option>ѡ�����</a>
		<?
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?=$r["id"]?>"><?=$r["type_name"]?></option>
			<?
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>ѡ��Flash�ļ�:</td>
	<td><input type=file name=flashfile size=50></td>
</tr>
<tr bgcolor=white>
	<td align=right>Flash����:</td>
	<td><input name=flash_name size=20></td>
</tr>
<tr bgcolor=white>
	<td align=right>Flash���:</td>
	<td><textarea name=intro rows=4 cols=40></textarea></td>
</tr>
<tr bgcolor=white>
	<td align=right></td>
	<td><input type=submit value="&nbsp;&nbsp;��&nbsp;&nbsp;��&nbsp;&nbsp;" ></td>
</tr>
</table>
<input type=hidden name=select_flag>
</form>
</body>
</html>
