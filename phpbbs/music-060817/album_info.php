<?
ob_start();
session_start();
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once './music_functions.php';

$album_id=$_REQUEST['album_id'];
$sql0="update album_info set album_count=album_count+1 where album_id=".$album_id;
$db->sql_query($sql0);
$sql1="select * from album_info where album_id=".$album_id;
$result1=$db->sql_query($sql1);
$singer_id=$db->sql_fetchfield('singer_id',0,$result1);
$album_name=$db->sql_fetchfield('album_name',0,$result1);
$album_pubdate=$db->sql_fetchfield('album_pubdate',0,$result1);
$album_intro=$db->sql_fetchfield('album_intro',0,$result1);
$album_count=$db->sql_fetchfield('album_count',0,$result1);

$sql2="select * from singer_info where singer_id=".$singer_id;
$result2=$db->sql_query($sql2);
$singer_name=$db->sql_fetchfield('singer_name',0,$result2);
$singer_area_id=$db->sql_fetchfield('singer_area_id',0,$result2);
$singer_chorus_id=$db->sql_fetchfield('singer_chorus_id',0,$result2);

$sql3="select * from singer_type where type_id=".$singer_area_id." and type_label=1";
$singer_area=$db->sql_fetchfield('type_name',0,$db->sql_query($sql3));
$sql4="select * from singer_type where type_id=".$singer_chorus_id." and type_label=2";
$singer_chorus=$db->sql_fetchfield('type_name',0,$db->sql_query($sql4));

$sql5="select * from song_info where album_id=".$album_id;
$result5=$db->sql_query($sql5);
?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>�������ָ���ר������<?=$singer_name?>_<?=$album_name?></title>
<link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body topMargin=0>
<center>
<?
include_once $phpbbs_root_path.'/top.php';
?>
<table width=760 border=0 cellpadding=0 cellspacing=0>
<tr>
	<td width=170 height=10><img height=1 src="../image/point1.gif" width="100%"></td>
	<td width=10><img height=10 src="../image/jiao1.gif" width=10></td>
	<td width=580><img height=1 src="../image/point1.gif" width="100%"></td>
</tr>
<tr>
	<td valign=top>
	<?
	include_once 'left.php';
	?>
	</td>
	<td height=100% align=center><img height="100%" src="../image/point1.gif" width=1></td>
	<td valign=top>
	<table width="100%" border=0 cellPadding=0 cellSpacing=0>
	<tr>
		<td height=30 colspan=2>
		������λ��:<a href="index.php">������ҳ</a>-&gt;<a href="singer_list.php?list_id=<?=$singer_area_id.$singer_chorus_id?>"><?=$singer_area?><?=$singer_chorus?></a>-&gt;<a href="singer_info.php?singer_id=<?=$singer_id?>"><?=$singer_name?></a>-&gt;<?=$album_name?>:
		</td>
	</tr>
	<tr>
		<td height=28 colspan=2><img src="image/album_info.gif"></td>
	</tr>
	<tr>
		<td width=140 align=center valign=top><img src="get_photo.php?photo_type=album&photo_id=<?=$album_id?>" width=120></td>
		<td width=440 valign=top>
		������:<a href="singer_info.php?singer_id=<?=$singer_id?>"><?=$singer_name?></a><br>
		ר����:<a href="album_info.php?album_id=<?=$album_id?>"><?=$album_name?></a><br>
		��������:<?=$album_pubdate?><br>
		��עָ��:<?=$album_count?><br>
		���:<div style="line-height:130%"><?=$album_intro?></div>
		</td>
	</tr>
	</table>
	<img src="image/album_song.gif">
	<table width="100%" border=1 cellpadding=0 cellspacing=0 bordercolor="#ffffff">
	<tr bgcolor="#3399CC">
		<td height="20">���</td>
		<td>������</td>
		<td>����ʱ��</td>
		<td align=center>����</td>
		<td align=center>����</td>
		<td align=center>����</td>
		<td align=center>���</td>
	</tr>
	<?
	if($db->sql_numrows($result5)==0)
	{
		?>
	<tr>
		<td height=30 colspan=7 align=center>��ʱû�е���</td>
	</tr>
	<tr>
		<td height=1 colspan=7><img src="../image/point1.gif" height=1 width=100%></td>
	</tr>
		<?
	}
	else
	{
		listTable2($result5);
	}
	?>
	<tr>
		<td colspan=7 align=right><a href="play.php?type=album_id&value=<?=$album_id?>">|&gt;ר����������&lt;|</a></td>
	</tr>
	</table>
	<?
	comment('music',$singer_id,$album_id);
	?>
	</td>
</tr>
</table>
<?
include_once $phpbbs_root_path.'/footer.php';
?>
</center>
</body>
</html>
<?
ob_end_flush();
?>