<!-- 添加电视频道-1 -->
<script language="javascript">
function check()
{
	
	if(window.document.add.station_name.value=="")
	{
		alert("您忘了输入名称");
		document.add.station.focus();
		return false;
	}
	if(window.document.add.sdp_file.value=="")
	{
		alert("您忘了输入路径");
		document.add.sdp_file.focus();
		return false;
	}
	sdp_file=window.document.add.sdp_file.value;
	sdp_file_ext=sdp_file.substring(sdp_file.lastIndexOf("."));
	if(sdp_file_ext!='.sdp'&&sdp_file_ext!='.SDP')
	{
		alert("您选择的不是SDP文件");
		window.document.add.sdp_file.focus();
		return false;
	}
	return true;
}
</script>
<form action="epg_add_tv_2.php" method=post ENCTYPE="multipart/form-data" name=add onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>添加电视台SDP(<span style="color:red">*</span>为必填)</caption>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>名称:</td>
	<td><input type=text name=station_name>(即电视节目名称)</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>选择SDP文件:</td>
	<td><input type=file name=sdp_file>(后缀必须是.sdp)</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>发布类型:</td>
	<td><select name=pubtype>
		<option value="0" 
		<?
		$pubtype=2;//默认值
		if($pubtype==0)
			echo " selected";
		?>
		>硬件发布</option>
		<option value="1" 
		<?
		if($pubtype==1)
			echo " selected";
		?>
		>软件发布</option>
		<option value="2" 
		<?
		if($pubtype==2)
			echo " selected";
		?>
		>VLC1方式</option>
		<option value="3" 
		<?
		if($pubtype==3)
			echo " selected";
		?>
		>VLC3方式</option>
		<option value="4" 
		<?
		if($pubtype==4)
			echo " selected";
		?>
		>VLC5方式</option>
		</select>
		</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>帧数:</td>
	<td><input type=text name=fps size=5 value=25></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>是否需要缩放:</td>
	<td><select name=zoom_flag>
	<option value=1>缩放</option>
	<option value=0>不缩放</option>
	</select>(除视频大小为640*480时不需要缩放外,其他都需要)</td>
</tr>
<tr bgcolor=white>
	<td align=right>节目单网址</td>
	<td><input type=text name=schedule_url size=50>(可以为空)</td>
</tr>
<tr bgcolor=white>
	<td><input type=hidden name=type value=tv><input type=hidden name=force_flag value=1><input type=hidden name=del_flag value=1></td>
	<td><input type=submit value=提交上传></td>
</tr>
</table>
</form>
