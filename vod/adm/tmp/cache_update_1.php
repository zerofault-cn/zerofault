<?
$cache_profile="../include/html_need_update.ini";
$fp=fopen($cache_profile,"r");
?>
<center>
<form action="cache_update_2.php" method=post>
<table width="60%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption >修改html缓存文件强制更新标志<br><span class=small style=color:red>在需要更新缓存文件的文件名后面打勾即可</span></caption>
<tr bgcolor=white>
	<td>php源文件名</td>
	<td>更新标志</td>
</tr>
<?
while($buffer=trim(fgets($fp,4096)))
{
//	echo $buffer;
	if(''==$buffer || substr($buffer,0,1)=='[')
	{
		continue;
	}
	else
	{
		$php_file=substr($buffer,0,strpos($buffer,'.'));
		switch($php_file)
		{
			case 'music_index':
				$descr='音乐殿堂首页';
				break;
			case 'epg_station':
				$descr='数字电视';
				break;
			case 'music_typelist':
				$descr='音乐殿堂分类';
				break;
			case 'music_singer_list':
				$descr='音乐殿堂歌手列表';
				break;
			case 'music_singer_song':
				$descr='音乐殿堂歌手歌曲列表';
				break;
			case 'music_other_song':
				$descr='歌曲其它分类方式列表';
				break;
			case 'music_singer_listall':
				$descr='MP3歌手列表';
				break;
			case 'music_mp3_song':
				$descr='歌手的MP3列表';
				break;
			case 'vod_typelist':
				$descr='VOD分类列表';
				break;
			case 'vod_namelist':
				$descr='VOD影片列表';
				break;
			case 'daily_index':
				$descr='天天在线首页';
				break;
		}
		$flag=substr($buffer,-1);
	}
	?>
<tr bgcolor=white>
	<td><?=$descr?></td>
	<td><input type=checkbox name="flag_<?=$php_file?>" value=1 <?if($flag)echo ' checked'?>></td>
</tr>
	<?
}
?>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value="确认修改"></td>
</tr>
</table>
</form>
</center>
