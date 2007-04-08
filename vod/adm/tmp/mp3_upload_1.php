<!-- 添加MP3音乐-1 -->
<script language="javascript">
function check()
{
	if(window.document.addmp3.mp3file.value=="")
	{
		alert("您忘了选择文件");
		document.addmp3.mp3file.focus();
		return false;
	}
	str=window.document.addmp3.mp3file.value;
	str=str.substring(str.lastIndexOf('\\')+1);
//		if(/[^\x00-\xff]/g.test(str))
		{
//			alert("文件名不能含有汉字字符");
//			document.addmp3.mp3file.focus();
//			return false;
		}
	if(/[\x27]/g.test(str))
	{
		alert("文件名不能含有单引号");
		document.addmp3.mp3file.focus();
		return false;
	}
	return true;
}

</script>

<form ENCTYPE="multipart/form-data" method=post name=addmp3 action="mp3_upload_2.php" onsubmit="return check()">
<table align=center width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption>重新上传MP3文件</caption>
<tr bgcolor=white>
	<td align=right>歌手名称：</td>
	<td><?=$singer_name?></td>
</tr>
<tr bgcolor=white>
	<td align=right>专辑名称：</td>
	<td><?=$album_name?></td>
</tr>
<tr bgcolor=white>
	<td align=right>歌曲名称：</td>
	<td><?=$song_name?></td>
</tr>
<tr bgcolor=white>
	<td align=right width="25%"><span style="color:red">*</span>选择新的MP3文件：</td>
	<td><input type=file name="mp3file" size=34></td>
</tr>
<tr bgcolor=white>
	<td align=center colspan=2><input type=hidden name=mp3_id value=<?=$mp3_id?>><input type=submit value="&nbsp;提&nbsp&nbsp交&nbsp;"></td>
</tr>
<tr bgcolor=white>
	<td colspan=2>注意:只是用来重新上传以前已有的mp3，如果以前传上去的文件是错误的，或者播放不了，可以用这个来修正</td>
</tr>
</table>
</form>
