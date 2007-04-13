<?
$type_label=$_REQUEST['type_label'];
$othertype=$_REQUEST['othertype'];
$value=$_REQUEST['value'];
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
include "color.inc.php";
$pageitem=9;
$n=0;
if($othertype=="pinyin")
{
	$flet = substr($value,0,1);
	$elet = substr($value,1)."zzzzzzzzz";
	$sql1="select count(prog_id) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_acot>='".$flet."' and prog_acot<='".$elet."' and del_flag=1";
	$sql2="select prog_path,prog_name from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_acot>='".$flet."' and prog_acot<='".$elet."' and del_flag=1 order by prog_acot limit ".$offset.",".$pageitem;
}
else if($othertype=="wordcount")
{
	if($value>5)
	{
		$sql1="select count(*) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_timespan>='".$value."' and del_flag=1";
		$sql2="select prog_path,prog_name from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_timespan>='".$value."' and del_flag=1 order by prog_size,binary prog_name limit ".$offset.",".$pageitem;
	}
	else
	{
		$sql1="select count(*) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_timespan='".$value."' and del_flag=1";
		$sql2="select prog_path,prog_name from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_timespan='".$value."' and del_flag=1 order by binary prog_name limit ".$offset.",".$pageitem;
	}
}
else
{
	if($type_label==2)
	{
		$sql1="select count(distinct prog_id) from singer_info,prog_info where prog_name is not null and prog_path is not null and prog_info.prog_kindsec=1026 and singer_info.type_chorus_id=".$type_id." and singer_info.singer_id=prog_info.publisher and prog_info.del_flag=1";
		$sql2="select distinct prog_path,prog_name from singer_info,prog_info where prog_name is not null and prog_path is not null and prog_info.prog_kindsec=1026 and singer_info.type_chorus_id=".$type_id." and singer_info.singer_id=prog_info.publisher and prog_info.del_flag=1 limit ".$offset.",".$pageitem;
	}
	if($type_label==5)
	{
		$sql1="select count(distinct prog_id) from singer_info,prog_info where prog_name is not null and prog_path is not null and prog_info.prog_kindsec=1026 and singer_info.type_other_id=".$type_id." and singer_info.singer_id=prog_info.publisher and prog_info.del_flag=1";
		$sql2="select distinct prog_path,prog_name from singer_info,prog_info where prog_name is not null and prog_path is not null and prog_info.prog_kindsec=1026 and singer_info.type_other_id=".$type_id." and singer_info.singer_id=prog_info.publisher and prog_info.del_flag=1 limit ".$offset.",".$pageitem;
	}
}
$result1=$db->sql_query($sql1);
$intRowCount=$db->sql_fetchfield(0,0,$result1);
$result2=$db->sql_query($sql2);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>无标题文档</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body leftMargin=0 topMargin=0 background="image/music/music5_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="onfoc(0)">
<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10></td>
	<td width=760><?include "top.php";?></td>
	<td width=20 >&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width=45 height="25">&nbsp;</td>
		<td width="370">&nbsp;</td>
		<td width="335">&nbsp;</td>
		<td width="10">&nbsp;</td>
	</tr>
	<tr>
		<td height=30 colspan=2 align=right><span class=style30w style="color:#ffcc00;margin-right:1em">第<?=$offset/$pageitem+1?>页&nbsp;&nbsp;共<?=ceil($intRowCount/$pageitem)?>页</span></td>
		<td colspan=2></td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td valign="top"></td>
		<td valign=top>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height=16></td>
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
			while($row=$db->sql_fetchrow($result2))
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
		?>
		</table>
		</td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="180" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%" align=center 
		<?
		if($offset!=0)//表示不是第一页
		{
			?>
			style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?type_label=<?=$type_label?>&type_id=<?=$type_id?>&othertype=<?=$othertype?>&value=<?=$value?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>');">上<br>页</a>
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
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('music_typelist.php?type_label=<?=$type_label?>');">返<br>回</td>
	</tr>
	<tr height="34%">
		<td height="34%" align=center 
		<?
		if(($offset+$pageitem) < $intRowCount)//表示还有下页
		{
			?>
			style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?type_label=<?=$type_label?>&type_id=<?=$type_id?>&othertype=<?=$othertype?>&value=<?=$value?>&offset=<?=$offset+$pageitem?>');">下<br>页</a>
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
	}
	var key1 = keycode - 48
	var patern=/^[1-<?=$n?>]$/; 
	if (patern.exec(key1))
	{
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
		begin();
		location = document.links[key2];
	}
	if(keycode==59 || keycode==186) 
	{
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
	if(keycode==36)
	{
		location="music_typelist.php?type_label=<?=$type_label?>";
	}
	if(keycode==33 && <?=$offset?>!=0)
	{
		location="?type_label=<?=$type_label?>&type_id=<?=$type_id?>&othertype=<?=$othertype?>&value=<?=$value?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>";
	}
	if(keycode==34 && <?=$offset+$pageitem?> < <?=$intRowCount?>)
	{
		location="?type_label=<?=$type_label?>&type_id=<?=$type_id?>&othertype=<?=$othertype?>&value=<?=$value?>&offset=<?=$offset+$pageitem?>";
	}
	if(keycode==38)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0) 
			key2=<?=$n-1?>;
		onfoc(key2);
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2 > <?=$n-1?>) 
			key2=0;
		onfoc(key2);
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