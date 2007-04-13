<?
$type_label=$_REQUEST['type_label'];
$type_id=$_REQUEST['type_id'];
$singerOffset=$_REQUEST["singerOffset"];
$singer_id=$_REQUEST['singer_id'];
$offset=$_REQUEST["offset"];
if(!isset($offset)||$offset=='')
{
	$offset=0;
}
$query_str=$_SERVER["QUERY_STRING"];
if(''!=$query_str)
{
	$query_str='.'.$query_str;
	$query_str=str_replace('=','.',$query_str);
	$query_str=str_replace('&','.',$query_str);
}
$this_file=basename($_SERVER["PHP_SELF"]);
$html_file='html_cache/'.$this_file.$query_str.'.htm';
$frp=fopen("../include/html_need_update.ini","r+");
while($buffer=fgets($frp,4096))
{
	
	if(substr($buffer,0,strlen($this_file))==$this_file)
	{
		$is_need=substr(trim($buffer),-1);
		break;
	}
	else
	{
		continue;
	}
}
//$is_need=1;
if(isset($is_need) && $is_need==0 && file_exists($html_file))
{
	echo file_get_contents($html_file);
}
else
{
fseek($frp,ftell($frp)-3);
fwrite($frp,"0\r\n");
fclose($frp);
ob_start();
include_once "../include/db_connect.php";
include_once "../include/getplaypath.php";
include_once "color.inc.php";
$pageitem=9;
$n=0;
$list="";
$sql1="select introduce,singer_name from singer_info where photo is not null and introduce is not null and singer_name is not null and singer_name is not null and singer_id=".$singer_id;
$result1=$db->sql_query($sql1);
$row=$db->sql_fetchrow($result1);
$introduce=$row[0];
$singer_name=$row[1];
$row='';
$sql2="select count(prog_id) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and del_flag=1 and publisher=".$singer_id;
$sql3="select prog_path,prog_name from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and del_flag=1 and publisher=".$singer_id." order by prog_id desc limit ".$offset.",".$pageitem;
$result2=$db->sql_query($sql2);
$intRowCount=$db->sql_fetchfield(0,0,$result2);
$result3=$db->sql_query($sql3);

$sql4="select count(*) from song_info where del_flag=1  and singer_id=".$singer_id;
$result4=$db->sql_query($sql4);
$mp3Count=$db->sql_fetchfield(0,0,$result4);//歌手所有mp3歌曲总数
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$singer_name?></title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body leftMargin=0 topMargin=0 background="image/music/music4_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="onfoc(0)" onblur="javascript:marquee1.stop();">
<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10></td>
	<td width=760><?include "top.php";?></td>
	<td width=20 height="10"></td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width=45 height="25">&nbsp;</td>
		<td width="400">&nbsp;</td>
		<td width="305">&nbsp;</td>
		<td width="10">&nbsp;</td>
	</tr>
	<tr>
		<td height=30 colspan=2 align=right><span class=style30w style="color:#ffcc00;margin-right:1em">第<?=$offset/$pageitem+1?>页&nbsp;&nbsp;共<?=ceil($intRowCount/$pageitem)?>页</span></td>
		<td colspan=2></td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td valign="top">
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td width="20">&nbsp;</td>
			<td width="130">
			<table border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td width=3 height=3><img src="image/music/photo_border_left_top.gif" width=3 height=3></td>
				<td background="image/music/photo_border_top.gif"></td>
				<td width=3><img src="image/music/photo_border_right_top.gif" width=3 height=3></td>
			</tr>
			<tr>
				<td background="image/music/photo_border_left.gif"></td>
				<td><img src="music_singer_photo.php?singer_id=<?=$singer_id?>" height=136></td>
				<td background="image/music/photo_border_right.gif"></td>
			</tr>
			<tr>
				<td height=3><img src="image/music/photo_border_left_bottom.gif" width=3 height=3></td>
				<td background="image/music/photo_border_bottom.gif"></td>
				<td><img src="image/music/photo_border_right_bottom.gif" width=3 height=3></td>
			</tr>
			</table>
			</td>
			<td width=50>&nbsp;</td>
			<td class=style32w valign=center><?=$singer_name?></td>
		</tr>
		<tr>
			<td height=32 colspan=4>&nbsp;</td>
		</tr>
		<tr>
			<td class=style30b colspan=4>
			<marquee id=marquee1 direction="up" loop=-1 behavior="scroll" height="306" scrolldelay="0" scrollamount="1" border="0">
			<?=$introduce?>
			</marquee>
			</td>
		</tr>
		</table>
		</td>
		<td valign=top>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height=36>&nbsp;</td>
		</tr>
		<?
		if($intRowCount==0)
		{
			?>
		<tr>
			<td id=0 height=36 class=style30b><a href="#">暂时没有MTV</a></td>
		</tr>
			<?
			$n=1;
		}
		else
		{
			while($row=$db->sql_fetchrow($result3))
			{
				$prog_path=$row[0];
				$prog_name=$row[1];
				if(strlen($prog_name)>14)
					$prog_name=substr($prog_name,0,12).'..';
				$play_path=getPlayPath($prog_path);
				$list=$list."|".$play_path;
				?>
		<tr>
			<td id="<?=$n?>" height=45 class=style30b onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><a style='color:<?=$music_text?>' href='<?=$play_path?>' onMouseOver='this.style.color="<?=$music_text_focus?>"' onMouseOut='this.style.color="<?=$music_text?>"'><?=$n+1?>.<?=$prog_name?></a></td>
		</tr>
				<?
				$n++;
			}
		}
		if($mp3Count>0)
		{
			?>
			<tr>
				<td height=50 valign=bottom class=style30b style="color:#c5f300">按【绿键】进入MP3</td>
			</tr>
			<?
		}
		?>
        </table>	
		</td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="350" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%" align=center 
		<?
		if($offset!=0)//表示不是第一页
		{
			?>
			style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?type_label=<?=$type_label?>&type_id=<?=$type_id?>&singerOffset=<?=$singerOffset?>&singer_id=<?=$singer_id?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>');">上<br>页</a>
			<?
		}
		else
		{
			echo '>';
		}
		?>
		</td>
	</tr>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('music_singer_list.php?type_label=<?=$type_label?>&type_id=<?=$type_id?>&offset=<?=$singerOffset?>');">返<br>回</td>
	</tr>
	<tr height="34%">
		<td height="34%" align=center 
		<?
		if(($offset+$pageitem) < $intRowCount)//表示还有下页
		{
			?>
			style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?type_label=<?=$type_label?>&type_id=<?=$type_id?>&singerOffset=<?=$singerOffset?>&singer_id=<?=$singer_id?>&offset=<?=$offset+$pageitem?>');">下<br>页</a>
			<?
		}
		else
		{
			echo '>';
		}
		?>
		</td>
	</tr>
	</table>
	</td>
</tr>

</table>
</body>
<script language="JavaScript" type="text/JavaScript">
<!--
var key2=0;
function onfoc(n) {
	document.getElementById(n).style.backgroundColor="<?=$music_selectbar?>";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:<?=$music_text_focus?>" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	document.getElementById(n).style.backgroundColor="";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:<?=$music_text?>" ' + dat;
}

function begin()
{
	td= document.getElementById(key2);
	dat = td.innerHTML;
	dat +='<img src=image/ing.gif height=22>';
	td.innerHTML = dat; 
	window.setTimeout('end()',5000);
}
function end()
{
	td = document.getElementById(key2);
	dat = td.innerHTML;
	dat = dat.substring(0,dat.lastIndexOf("<"));
	td.innerHTML = dat; 
}

if(document.all)
{
	var ie=1;
}
else
{
	var ie=0;
}
function keyDown(e)
{
	if (ie)
	{
		var keycode=event.keyCode; 
	}
	else
	{
		var keycode=e.which;
	}	var key1 = keycode - 48
	var patern=/^[1-<?=$n?>]$/; 
	if (patern.exec(key1))
	{
		marquee1.stop();
		if(key1 == key2 + 1) 
			onfoc(key1 - 1);
		else 
		{
			losefoc(key2);
			onfoc(key1 - 1)
			key2 = key1 -1;
		}
		location = document.links[key2];
	}
	if(keycode==13||keycode==70)
	{
		marquee1.stop();
		begin();
		location = document.links[key2];
	}
	if(keycode==59 || keycode==186) //蓝键
	{
		marquee1.stop();
		begin();
		if(navigator.platform=='Win32')
		{
		//	location='music_mp3_play.php?song_id='+album_song_id;
		}
		else
		{
			location="list://\"<?=$list?>|\"";
		}
	}
	if(keycode==221)//绿键
	{
		location="music_mp3_song.php?type_label=<?=$type_label?>&type_id=<?=$type_id?>&singerOffset=<?=$singerOffset?>&songOffset=<?=$offset?>&singer_id=<?=$singer_id?>";
	}
	if(keycode==36)
	{
		location="music_singer_list.php?type_label=<?=$type_label?>&type_id=<?=$type_id?>&offset=<?=$singerOffset?>";
	}
	if(keycode==33 && <?=$offset?>!=0)
	{
		location="?type_label=<?=$type_label?>&type_id=<?=$type_id?>&singerOffset=<?=$singerOffset?>&singer_id=<?=$singer_id?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>";
	}
	if(keycode==34 && <?=$offset+$pageitem?> < <?=$intRowCount?>)
	{
		location="?type_label=<?=$type_label?>&type_id=<?=$type_id?>&singerOffset=<?=$singerOffset?>&singer_id=<?=$singer_id?>&offset=<?=$offset+$pageitem?>";
	}
	if(keycode==38)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0) 
			key2=<?=$n-1?>;
		onfoc(key2);
		marquee1.start();
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2 > <?=$n-1?>) 
			key2=0;
		onfoc(key2);
		marquee1.start();
	}

}
document.onkeydown=keyDown
//-->
</script>
</html>
<?
$fwp=fopen($html_file,"w"); 
fwrite($fwp,ob_get_contents());
fclose($fwp);
ob_end_flush();
}
?>