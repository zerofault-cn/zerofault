<?
ob_start();
session_start();
$phpbbs_root_path="..";
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once $phpbbs_root_path.'/include/toPinyin.php';
include_once './music_functions.php';
?>
<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>��������_�û��ϴ�����</title>
<link rel="stylesheet" href="../style.css" type="text/css">
</head>
<script language="javascript">
function check2()
{
	var str=document.song.mp3file.value;
	if(str=="")
	{
		alert("��ѡ���ļ���");
		document.song.mp3file.focus();
		return false;
	}
	if(str.substring(str.lastIndexOf('.'))!='.mp3' && str.substring(str.lastIndexOf('.'))!='.MP3')
	{
		alert("��ѡ��Ĳ���MP3�ļ���");
		document.song.mp3file.focus();
		return false;
	}
	if(document.song.singer_name.value=="")
	{
		alert("��������д��������");
		document.song.singer_name.focus();
		return false;
	}
	if(document.song.song_name.value=="")
	{
		alert("��������д��������");
		document.song.song_name.focus();
		return false;
	}
	return true;
}
</script>
<body topMargin=0>
<center>
<!-- TOP -->
<?
include_once $phpbbs_root_path.'/top.php';
?>
<!-- TOP over -->
<table width=760 border=0 cellpadding=0 cellspacing=0>
<tr>
	<td width=170 height=10><img src="../image/point1.gif" width="100%" height=1></td>
	<td width=10><img src="../image/jiao1.gif" width=10 height=10></td>
	<td width=580><img src="../image/point1.gif" width="100%" height=1></td>
</tr>
<tr>
	<td valign=top>
	<!-- LEFT -->
	<?
	include_once 'left.php';
	?>
	<!-- LEFT over -->
	</td>
	<td height="100%" align="center"><img height="100%" src="../image/point1.gif" width=1></td>
	<td valign=top>
	<!-- main -->
<?php
$flag=$_REQUEST['flag'];
$upflag=$_REQUEST['upflag'];
$song_id=$_REQUEST['song_id'];
if($upflag=='lyrics')
{
	$song_name=getSongName($song_id);
	$singer_name=getSingerNameBySong($song_id);
	$album_name=getAlbumNameBySong($song_id);
	?>
	<form method="post" action="<?=$PHP_SELF?>" name="lyrics" enctype="multipart/form-data">
	&emsp;������:<input type="text" name="song_name" value="<?=$song_name?>" readonly><br>
	&emsp;������:<input type="text" name="singer_name" value="<?=$singer_name?>" readonly><br>
	&emsp;ר����:<input type="text" name="album_name" value="<?=$album_name?>" readonly><br>
	ѡ���ļ�:<input type="file" name="lyricfile" size="50"><br>
	<input type="hidden" name="song_id" value="<?=$song_id?>">
	<input type="hidden" name="flag" value="uplyrics">
	<input type="hidden" name="upflag" value="notnull">
	<input type="submit" value="�ύ">
	</form>
	<?
}
if($upflag=='')
{
	?>
	<form name="song" method="post" action="<?=$PHP_SELF?>" enctype="multipart/form-data" onsubmit="return check2();">
	<table border="1" cellspacing=0 cellpadding=3 bordercolor="#e4ebed">
	<caption><span class=red>���ϴ��ĸ�����ֱ�Ӹ�������ҳ��</span></caption>
	<tr>
		<td>����·��:</td>
		<td><input type="file" name="mp3file" size="50"></td>
	</tr>
	<tr>
		<td>���·��:</td>
		<td><input type="file" name="lyricfile" size="50">(���Բ���)</td>
	</tr>
	<tr>
		<td align="right">������:</td>
		<td><input type="text" name="singer_name" size="12">
		����������ĸ:<input name="singer_name_fc" size="1">
		���ַ���:<select name="singer_area_id" onchange="document.song.select_area.value=1">
		<option value="">��������</option>
		<option value="">----------</option>
		<?
		$sql1="select type_id,type_name from singer_type where type_label=1 order by type_id";
		$result1=$db->sql_query($sql1);
		while($r=$db->sql_fetchrow($result1))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?></select>
		<select name="singer_chorus_id" onchange="document.song.select_chorus.value=1">
		<option value="">�ݳ���ʽ</option>
		<option value="">--------</option>
		<?
		$sql2="select type_id,type_name from singer_type where type_label=2 order by type_id";
		$result2=$db->sql_query($sql2);
		while($r=$db->sql_fetchrow($result2))
		{
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
		}
		?></select></td>
	</tr>
	<tr>
		<td align="right">������:</td>
		<td><input type="text" name="song_name" size="30"></td>
	</tr>
	<tr>
		<td align="right">ר����:</td>
		<td><input type="text" name="album_name" size="30" value=""></td>
	</tr>
	<tr>
		<td align="right"></td>
		<td><input type="hidden" name="flag" value="upmp3">
		<input type="hidden" name="upflag" value="notnull">
		<input type="hidden" name="select_area">
		<input type="hidden" name="select_chorus">
		<input type="submit" name="submit" value="��ʼ�ϴ�"></td>
	</tr>
	</form>
	</table>
	<?
}
if($flag=="upmp3")
{
	$singer_name=$_REQUEST['singer_name'];
	$singer_name_fc=$_REQUEST['singer_name_fc'];
	$singer_area_id=$_REQUEST['singer_area_id'];
	$singer_chorus_id=$_REQUEST['singer_chorus_id'];
	$song_name=$_REQUEST['song_name'];
	$album_name=$_REQUEST['album_name'];

	$singer_id=0;
	$album_id=0;
	$updir="f:/mp3/song/".$singer_name;
	if(!file_exists($updir))
	{
		mkdir($updir,0700);
	}
	if(''!=$album_name)
	{
		$updir.='/'.$album_name;
		if(!file_exists($updir))
		{
			mkdir($updir,0700);
		}
	}
	$upflag1=copy($_FILES['mp3file']['tmp_name'],$updir.'/'.$song_name.'.mp3');//�����ļ���musicĿ¼��
	if($_FILES['lyricfile']['size']!=0)
	{
		$upflag2=copy($_FILES['lyricfile']['tmp_name'],$updir.'/'.$song_name.'.lrc');//�����ļ���musicĿ¼��
	}
	else
	{
		$upflag2=1;
	}
	if(''==$singer_name_fc)
	{
		$singer_name_fc=substr(words($singer_name),0,1);
	}
	$singer_name_fc=strtoupper($singer_name_fc);
	if($_FILES['lyricfile']['size']!=0)
	{
		$song_lyric=substr($updir.'/'.$song_name.'.lrc',3);
	}
	$song_path=substr($updir.'/'.$song_name.'.mp3',3);

	$sql1="select * from song_info where song_path='".$song_path."'";
	$sql2="select singer_id from singer_info where singer_name='".$singer_name."'";
	$sql3="insert into singer_info set singer_name='".$singer_name."',singer_name_fc='".$singer_name_fc."',singer_area_id=".$singer_area_id.",singer_chorus_id=".$singer_chorus_id;
	$sql4="select album_id from album_info where album_name='".$album_name."'";
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1))//�Ѵ��ڴ˸���
	{
		echo $message="���ݿ����Ѿ�������ͬ������Ϣ!";
		echo '<button name=button1 onclick="javascript:history.go(-1);">����</button><br>';
	}
	else
	{
		$result2=$db->sql_query($sql2);
		if($db->sql_numrows($result2))//�Ѵ��ڴ˸���
		{
			$singer_id=$db->sql_fetchfield(0,0,$result2);//��ѯ�õ�����id
		}
		elseif($db->sql_query($sql3))//�����˸���
		{
			$singer_id=$db->sql_nextid();//ȡ�ô˸���id
		}
		$result4=$db->sql_query($sql4);
		$sql5="insert info album_info set singer_id=".$singer_id.",album_name='".$album_name."'";
		if(''!=$album_name)//ר������Ϊ��
		{
			if($db->sql_numrows($result4))//�Ѵ��ڴ�ר��
			{
				$album_id=$db->sql_fetchfield(0,0,$result4);
			}
			elseif($db->sql_query($sql5))
			{
				$album_id=$db->sql_nextid();
			}
		}
		$sql6="insert into song_info set singer_id=".$singer_id.",album_id=".$album_id.",song_name='".$song_name."',song_path='".$song_path."',song_lyric='".$song_lyric."',song_addtime=CURDATE()";
		if($singer_id!=0)
		{
			if($upflag1 && $upflag2 && $db->sql_query($sql6))
			{
				echo $message="<p>�ļ�: ".$_FILES['mp3file']['name']."�ϴ��ɹ�!<br />";
			}
			else 
			{
				echo $message="<p>�ϴ�ʧ��!<br />";
			}
		}
		echo '<button name=button1 onclick="javascript:history.go(-1);">�����ϴ�</button><br>';
	}
}

if($flag=='uplyrics')
{
	$song_lyric=substr(getSongPath($song_id),0,-3).'lrc';
	$upflag1=copy($_FILES['lyricfile']['tmp_name'],'f:/'.$song_lyric);
	$sql1="update song_info set song_lyric='".$song_lyric."' where song_id='".$song_id."'";
	if($upflag1 && $db->sql_query($sql1))
	{
		echo '�ϴ��ɹ�,лл!<br /><button name=button1 onclick="javascript:history.go(-2);">����</button>';
	}
}
?>
	<!-- main over -->
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