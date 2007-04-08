<script language="javascript">
function check()
{
	if(window.document.add_source.select_flag.value!=1)
	{
		alert("请选择类型");
		return false;
	}
	if(window.document.add_source.title.value=="")
	{
		alert("请输入标题");
		document.add_source.title.focus();
		return false;
	}
	if(window.document.add_source.source.value=="")
	{
		alert("请选择文件");
		document.add_source.source.focus();
		return false;
	}
	if(window.document.add_source.source.value!="")
	{
		source_file=window.document.add_source.source.value;
		source_file_ext=source_file.substring(source_file.lastIndexOf("."));	if(source_file_ext!='.wmv'&&source_file_ext!='.WMV'&&source_file_ext!='.rm'&&source_file_ext!='.RM')
		{
			alert("目前只能上传wmv或rm格式的文件");
			document.add_source.source.focus();
			return false;
		}
	}
	if(window.document.add_source.descr.value=="")
	{
		alert("请输入简要介绍");
		document.add_source.descr.focus();
		return false;
	}
	return true;
}
</script>
<form method=post action="daily_add_source_2.php" name="add_source" onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加"天天在线"内容</caption>
<tr bgcolor=white>
	<td align=right>新闻类型:</td>
	<td align=left>
	<select name=type onchange="document.add_source.select_flag.value=1">
	<option>-请选择-</option>
	<?
	include_once "../include/mysql_connect.php";
	$sql1="select * from daily_type where del_flag=1";
	$result1=mysql_query($sql1);
	while($r=mysql_fetch_array($result1))
	{
		?>
		<option value="<?=$r["id"]?>"><?=$r["type_name"]?></option>
		<?
	}
	?>
	</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>新闻标题:</td>
	<td align=left><INPUT TYPE="text" NAME="title" size=30></td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>选择rm或wmv文件:</td>
	<td align=left><INPUT TYPE=file NAME="source" size=30>(文件名不要包含中文字符)</td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>简要介绍:</td>
	<td><textarea name=descr rows=15 cols=56></textarea></td>
</tr>

<tr bgcolor=white>
	<td colspan=2 align=center><input type=hidden name=select_flag><input type="submit" value="&nbsp;上传&nbsp;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="reset" value="&nbsp;重填&nbsp;"></td>
</tr>
</table>
</form>