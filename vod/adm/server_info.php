<?
include_once "../include/mysql_connect.php";
include_once "../include/getplaypath.php";
$server_ip=getServerIp();
$s_ip=substr(strrchr($server_ip,"."),1);
//查询显示系统所有资源数目
$sql1_1="select count(*) from prog_info where prog_kindsec=1006 and del_flag=1 and (prog_path like '%.wmv' or prog_path like '%.WMV')";//有效的wmv
$sql1_2="select count(*) from prog_info where prog_kindsec=1006 and del_flag=1 and (prog_path like '%.mp4' or prog_path like '%.MP4')";//有效的mp4
$sql1_3="select count(*) from prog_info where prog_kindsec=1006 and del_flag=1 and (prog_path like '%.rm' or prog_path like '%.RM' or prog_path like '%.rmvb' or prog_path like '%.RMVB')";//有效的rm或rmvb
$sql4="select count(*) from singer_info";//歌手数
$sql5="select count(*) from prog_info where prog_kindsec=1026 and del_flag=1";//有效的歌曲
$sql6="select count(*) from epg_station where type='tv' and del_flag=1";//电视台
$sql7="select count(*) from song_info where del_flag=1";

$result1_1=mysql_query($sql1_1);
$movie_wmv=mysql_result($result1_1,0,0);

$result1_2=mysql_query($sql1_2);
$movie_mp4=mysql_result($result1_2,0,0);

$result1_3=mysql_query($sql1_3);
$movie_rm=mysql_result($result1_3,0,0);

$result4=mysql_query($sql4);
$singer_count=mysql_result($result4,0,0);

$result5=mysql_query($sql5);
$music_count=mysql_result($result5,0,0);

$result6=mysql_query($sql6);
$tv_count=mysql_result($result6,0,0);

$result7=mysql_query($sql7);
$mp3_count=mysql_result($result7,0,0);
?>
<table border=0 cellpadding=0 cellspacing=0 width="100%">
<tr>
	<td background="image/top_white.gif" colspan=4 height=20 valign=top align=center><img height=16 src="image/message.gif" width=16>系统信息</td>
</tr>
<tr>
	<td align=right height="100%" rowspan=8 valign=top width=10><img height="100%" src="image/point.gif" width=1></td>
	<td align=right width="40%">服务器:</td><td><span style="color:#ff00cc"><?=$s_ip?></span></td>
	<td align=left height="100%" rowspan=8 valign=top width=10><img height="100%" src="image/point.gif" width=1></td>
</tr>
<tr>
	<td align=right>WMV:</td><td><span style="color:#ee0000"></span><span class=small style="color:blue"><?=$movie_wmv?></span></td>
</tr>
<tr>
	<td align=right>MP4:</td><td><span style="color:#ee0000"></span><span class=small style="color:blue"><?=$movie_mp4?></span></td>
</tr>
<tr>
	<td align=right>RMVB:</td><td><span style="color:#ee0000"></span><span class=small style="color:blue"><?=$movie_rm?></span></td>
</tr>
<tr>
	<td align=right>歌手数:</td><td><span style="color:blue"><?=$singer_count?></span></td>
</tr>
<tr>
	<td align=right>歌曲数:</td><td><span style="color:blue"><?=$music_count?></span></td>
</tr>
<tr>
	<td align=right>MP3数:</td><td><span style="color:blue"><?=$mp3_count?></span></td>
</tr>
<tr>
	<td align=right>电视台:</td><td><span style="color:blue"><?=$tv_count?></span></td>
</tr>
<tr>
	<td background="image/bottom_white.gif" colspan=3 height=20></td>
</tr>
</table>