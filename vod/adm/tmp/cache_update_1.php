<?
$cache_profile="../include/html_need_update.ini";
$fp=fopen($cache_profile,"r");
?>
<center>
<form action="cache_update_2.php" method=post>
<table width="60%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption >�޸�html�����ļ�ǿ�Ƹ��±�־<br><span class=small style=color:red>����Ҫ���»����ļ����ļ�������򹴼���</span></caption>
<tr bgcolor=white>
	<td>phpԴ�ļ���</td>
	<td>���±�־</td>
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
				$descr='���ֵ�����ҳ';
				break;
			case 'epg_station':
				$descr='���ֵ���';
				break;
			case 'music_typelist':
				$descr='���ֵ��÷���';
				break;
			case 'music_singer_list':
				$descr='���ֵ��ø����б�';
				break;
			case 'music_singer_song':
				$descr='���ֵ��ø��ָ����б�';
				break;
			case 'music_other_song':
				$descr='�����������෽ʽ�б�';
				break;
			case 'music_singer_listall':
				$descr='MP3�����б�';
				break;
			case 'music_mp3_song':
				$descr='���ֵ�MP3�б�';
				break;
			case 'vod_typelist':
				$descr='VOD�����б�';
				break;
			case 'vod_namelist':
				$descr='VODӰƬ�б�';
				break;
			case 'daily_index':
				$descr='����������ҳ';
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
	<td colspan=2 align=center><input type=submit value="ȷ���޸�"></td>
</tr>
</table>
</form>
</center>
