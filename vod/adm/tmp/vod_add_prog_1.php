<!-- 添加电影节目-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.select_flag.value!=1)
	{
		alert("您忘了选择分类");
		return false;
	}
	if(window.document.add.prog_name.value=="")
	{
		alert("您忘了输入名称");
		document.add.prog_name.focus();
		return false;
	}
	if(window.document.add.prog_file.value=="")
	{
		alert("您忘了输入路径");
		document.add.prog_file.focus();
		return false;
	}
	str=window.document.add.prog_file.value;
	str=str.substring(str.lastIndexOf('\\')+1);
	if(/[^\x00-\xff]/g.test(str))
	{
		alert("文件名不能含有汉字字符");
		document.add.prog_file.focus();
		return false;
	}
	if(/[\x20]/g.test(str))
	{
		alert("文件名不能含有空格");
		document.add.prog_file.focus();
		return false;
	}
	return true;
}

</script>

<form action="vod_add_prog_2.php" method=post name=add onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加视频点播节目(<span style="color:red">*</span>为必填)</caption>
<tr bgcolor=white>
	<td width="25%" align=right><span style="color:red">*</span>选择类型:</td>
	<td><select name=prog_kindthr onchange="document.add.select_flag.value=1">
		<option value="">请选择</option>
		<?
		include_once "../include/mysql_connect.php";
		$sql1="select dentry_id,dentry_name from dict_entry where dtype_id=50 and del_flag=1 order by dentry_id";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>电影片名:</td>
	<td><input type=text name=prog_name></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>选择文件:</td>
	<td><input type=file name=prog_file size=30><span class=small>(文件名不能含中文和空格)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>是否缩放:</td>
	<td><input type=radio name=zoom_flag value=1>缩放&nbsp;<input type=radio name=zoom_flag value=0 checked>不缩放&nbsp;(若视频分辨率为640*480时,不需要缩放,其他都需要)</td>
</tr>
<tr bgcolor=white>
	<td align=right>影片画质:</td>
	<td><input type=radio name=quality value=1>高&nbsp;<input type=radio name=quality value=2 checked>中&nbsp;<input type=radio name=quality value=3>低<span class=small>(高:720*540;中:640*480;低:320*240)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>文件大小:</td>
	<td><input type=text name=prog_size value=0 size=5>M</td>
</tr>
<tr bgcolor=white>
	<td align=right>播放时长:</td>
	<td><input type=text name=prog_timespan value=0></td>
</tr>
<tr bgcolor=white>
	<td align=right>出版日期:</td>
	<td><input type=text name=pubdate value="0000-00-00"><span class=small>(如果是新出版的片子,请设为今天的日期)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>导演:</td>
	<td><input type=text name=director value="未知"></td>
</tr>
<tr bgcolor=white>
	<td align=right>主要演员:</td>
	<td><input type=text name=prog_acot value="未知"></td>
</tr>
<tr bgcolor=white>
	<td align=right>内容简介:</td>
	<td><textarea name=prog_describe rows=12 cols=60>暂无</textarea></td>
</tr>
<tr bgcolor=white>
	<td><input type=hidden name=select_flag></td>
	<td><input type=submit value=提交></td>
</tr>
</table>
</form>
