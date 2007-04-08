<!-- 添加音乐节目-1 -->
<script language="javascript">
function check()
{
	if(window.document.add.select_flag.value!=1)
	{
		alert("您忘了选择歌手!");
		return false;
	}
	if(window.document.add.prog_name.value=="")
	{
		alert("您忘了输入名称!");
		document.add.prog_name.focus();
		return false;
	}
	if(window.document.add.prog_path.value=="")
	{
		alert("您忘了输入路径!");
		document.add.prog_path.focus();
		return false;
	}
	str=window.document.add.prog_path.value;
	str=str.substring(str.lastIndexOf('\\')+1);
	if(/[^\x00-\xff]/g.test(str))
	{
		alert("文件名不能含有汉字字符");
		document.add.prog_path.focus();
		return false;
	}
	if(/[\x20]/g.test(str))
	{
		alert("文件名不能含有空格");
		document.add.prog_path.focus();
		return false;
	}
	return true;
}

</script>

<form action="music_add_prog_2.php" method=post name=add onsubmit="return check()">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>添加歌曲(<span style="color:red">*</span>为必填)</caption>
<tr bgcolor=white>
	<td width="25%" align=right><span style="color:red">*</span>选择歌手:</td>
	<td><select name=singer_id onchange="document.add.select_flag.value=1">
		<option value="">请选择</option>
		<?
		include_once "../include/mysql_connect.php";
		$sql1="select singer_id,singer_name from singer_info order by type_other_id desc,binary singer_name";
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?>
		</select><span class=small>(提示:如果不能确定歌手,可以选择其对应的类型)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>选择文件:</td>
	<td><input type=file name=prog_path size=30><span class=small>(文件名不能包含中文)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>歌名:</td>
	<td><input type=text name=prog_name></td>
</tr>
<tr bgcolor=white>
	<td align=right>是否缩放:</td>
	<td><input type=radio name=zoom_falg value=1 checked>缩放&nbsp;<input type=radio name=zoom_falg value=0>不缩放&nbsp;(若视频分辨率为640*480时,不需要缩放,其他都需要)</td>
</tr>
<tr bgcolor=white>
	<td align=right>影片画质:</td>
	<td><input type=radio name=quality value=1>高&nbsp;<input type=radio name=quality value=2 checked>中&nbsp;<input type=radio name=quality value=3>低<span class=small>(高:720*540;中:640*480;低:320*240)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>文件大小:</td>
	<td><input type=text name=prog_size value=0 size=3>M</td>
</tr>
<tr bgcolor=white>
	<td align=right>发行日期:</td>
	<td><input type=text name=pubdate value="0000-00-00"></td>
</tr>
<tr bgcolor=white>
	<td><input type=hidden name=select_flag><input type=hidden name=prog_describe value=""></td>
	<td><input type=submit value=提交></td>
</tr>
</table>
</form>
