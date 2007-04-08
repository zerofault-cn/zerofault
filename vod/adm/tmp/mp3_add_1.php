<!-- 添加MP3音乐-1 -->
<?
$remote_ip=$_SERVER["REMOTE_ADDR"];
$server_ip=$_SERVER["SERVER_ADDR"];
$remote_ip=substr($remote_ip,0,strrpos($remote_ip,'.'));
$server_ip=substr($server_ip,0,strrpos($server_ip,'.'));
if($remote_ip=='172.18.145'||$remote_ip=='221.10.222'||$server_ip==$remote_ip)
{
	?>
	<script>
		location='index.php?content=mp3_add_1_upload';
	</script>
	<?
}
?>
<script language="javascript">
function check()
{
	if(window.document.form1.mp3file.value=="")
	{
		alert("请输入路径");
		document.form1.mp3file.focus();
		return false;
	}
	if(window.document.form1.song_name.value=="")
	{
		alert("请输入歌名");
		document.form1.song_name.focus();
		return false;
	}
	if(window.document.form1.singer_id.value=='')
	{
		alert("您忘了选择歌手");
		return false;
	}
	if(window.document.form1.album_name.value=="")
	{
		alert("您忘了输入专辑名");
		document.form1.album_name.focus();
		return false;
	}
	full_path=window.document.form1.mp3file.value;
	file_name=full_path.substring(full_path.lastIndexOf('\\')+1);
	if(/[^\x00-\xff]/g.test(file_name))
	{
		alert("文件名不能含有汉字字符");
		document.form1.mp3file.focus();
		return false;
	}
	if(/[\x20]/g.test(file_name))
	{
		alert("文件名不能含有空格");
		document.form1.mp3file.focus();
		return false;
	}
	if(/[\x27]/g.test(full_path))
	{
		alert("文件名不能含有单引号");
		document.form1.mp3file.focus();
		return false;
	}
	return true;
}
function update_info()
{
	str=window.document.form1.mp3file.value;//E:\mp3\Music混合体\一个人....两个人.mp3
	album_name=str.substring(0,str.lastIndexOf('\\'));
	album_name=album_name.substring(album_name.lastIndexOf('\\')+1);
	song_name=str.substring(str.lastIndexOf('\\')+1);
	song_name=song_name.substring(0,song_name.lastIndexOf('.'));
	document.form1.album_name.value=album_name;
	document.form1.song_name.value=song_name;
}
</script>

</head>
<form method=post name=form1 action="mp3_add_2.php" onsubmit="return check()">
<table align=center width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption>添加MP3歌曲(<span class=blue>只添加记录</span>)</caption>
<tr bgcolor=white>
	<td align=right width="21%"><span style="color:red">*</span>选择MP3文件：</td>
	<td><input type=file name="mp3file_name" size=38></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>歌手名称：</td>
	<td><select name=singer_id onchange="document.addmp3.select_flag.value=this.options[this.selectedIndex].value">
		<option value="">请选择</option>
		<?
		include_once "../include/mysql_connect.php";
		$sql1="select singer_id,singer_name,singer_name_fc from singer_info order by singer_name_fc,type_other_id desc,binary singer_name";
		$result1=mysql_query($sql1);
		$i=0;
		while($r=mysql_fetch_array($result1))
		{
			$singer_name_fc[]=$r[2];
			if($singer_name_fc[$i]!=$singer_name_fc[$i-1])
			{
				?>
				<option value=""><?=$singer_name_fc[$i]?>-------</option>
				<?
			}
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
			$i++;
		}
		?>
		</select><span class=small>(如果没有所需歌手名,请<a href="index.php?content=music_add_singer_1">添加歌手</a>)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>歌曲名称：</td>
	<td><input type=text name=song_name size=48></td>
</tr>
<tr bgcolor=white>
	<td align=right>专辑名称：</td><td><input type=text name=album_name size=48 value=unknown></td>
</tr>
<tr bgcolor=white>
	<td align=right>歌词：</td>
	<td><textarea name=song_lyric rows=10 cols=48>暂无</textarea></td>
</tr>
<tr bgcolor=white>
	<td align=center colspan=2><input type=hidden name=select_flag><input type=submit value="&nbsp;提&nbsp&nbsp交&nbsp;"></td>
</tr>
<tr bgcolor=white>
	<td align=right colspan=2><input type=checkbox name=up_flag value=1 disabled>立即上传&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
</tr>
<tr bgcolor=white>
	<td colspan=2>
	注意:<br>
	1.程序自动判断您的网络,以确定是否使用自动上传或者手动上传.<br>
	2.如果是自动上传,建议您的MP3文件在硬盘中存放的格式为:<u>歌手名\专辑名\歌曲名.mp3</u>,并且这些名称中不要使用<u>单引号(')</u>,也不能使用<u>繁体字</u>.<br>
	3.如果不是立即上传,请在添加MP3前先将<u>文件名</u>改成<u>拼音</u>(即不能包含中文字符),并且文件名中不能包含<u>空格</u>,也不能包含<u>单引号(')</u>.<br>
	</td>
</tr>
</table>
</form>
