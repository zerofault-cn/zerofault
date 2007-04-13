<?
$type_label=$_REQUEST['type_label'];
$type_id=$_REQUEST['type_id'];
$offset=$_REQUEST["offset"];
if(!isset($offset)||$offset=='')
{
	$offset=0;
}
if($type_label==5)
{
	header("location:music_other_song.php?type_label=".$type_label."&type_id=".$type_id);
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
include_once "color.inc.php";
$pageitem=8;
$n=0;
if($type_label==1)
{
//	$sql1="select count(distinct singer_id) from singer_info,prog_info where prog_info.publisher=singer_id and prog_info.del_flag=1 and prog_info.prog_kindsec=1026 and type_area_id=".$type_id;
//	$sql2="select distinct singer_id,singer_name,photo from singer_info,prog_info where prog_info.publisher=singer_id and prog_info.del_flag=1 and prog_info.prog_kindsec=1026 and type_area_id=".$type_id." order by binary singer_name limit ".$offset.",".$pageitem;
	$sql1="select count(distinct singer_id) from singer_info where mtv_count>0 and type_area_id=".$type_id;
	$sql2="select distinct singer_id,singer_name from singer_info where mtv_count>0 and type_area_id=".$type_id." order by binary singer_name limit ".$offset.",".$pageitem;
}
if($type_label==2)
{
//	$sql1="select count(distinct singer_id) from singer_info,prog_info where prog_info.publisher=singer_id and prog_info.del_flag=1 and prog_info.prog_kindsec=1026 and type_chorus_id=".$type_id;
//	$sql2="select distinct singer_id,singer_name from singer_info,prog_info where prog_info.publisher=singer_id and prog_info.del_flag=1 and prog_info.prog_kindsec=1026 and type_chorus_id=".$type_id." order by binary singer_name limit ".$offset.",".$pageitem;
	$sql1="select count(distinct singer_id) from singer_info where mtv_count>0 and type_chorus_id=".$type_id;
	$sql2="select distinct singer_id,singer_name from singer_info where mtv_count>0 and type_chorus_id=".$type_id." order by binary singer_name limit ".$offset.",".$pageitem;
}
if($type_label==5)
{
	$sql1="select count(distinct singer_id) from singer_info where mtv_count>0 and type_other_id=".$type_id;
	$sql2="select distinct singer_id,singer_name from singer_info where mtv_count>0 and type_other_id=".$type_id." order by binary singer_name limit ".$offset.",".$pageitem;
}
$result1=$db->sql_query($sql1);
$intRowCount=$db->sql_fetchfield(0,0,$result1);
$result2=$db->sql_query($sql2);
while($row=$db->sql_fetchrow($result2))
{
	$singer_id	=$row[0];
	$singer_name=$row[1];
	if(strlen($singer_name)>8)
	{
		$singer_name=substr($singer_name,0,8);
	}
	$photos[$n]='<img src="music_singer_photo.php?singer_id='.$singer_id.'" style="cursor:hand" onclick="window.location=(\'music_singer_song.php?type_label='.$type_label.'&type_id='.$type_id.'&singerOffset='.$offset.'&singer_id='.$singer_id.'\');" alt="'.$singer_name.' " height=132>';
	$names[$n]='<a style="color:'.$music_text.'" href="music_singer_song.php?type_label='.$type_label.'&type_id='.$type_id.'&singerOffset='.$offset.'&singer_id='.$singer_id.'" onMouseOver=\'this.style.color="'.$music_text_focus.'"\' onMouseOut=\'this.style.color="'.$music_text.'"\'>'.$singer_name.' </a>';
	$n++;
}
if($n==0)
{
	$photos[$n]='<img src="image/no_photo.jpg" height=132>';
	$names[$n]='<a style="color:'.$music_text.'" href="#">暂无歌手</a>';
	$n++;
}
$sql3="select type_name from singer_type where type_label=".$type_label." and type_id=".$type_id;
$result3=$db->sql_query($sql3);
$type_name=$db->sql_fetchfield(0,0,$result3);
$n=max($n,1);
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>音乐殿堂-歌手列表</title>
<link rel="stylesheet" href="style.css" type="text/css">

</head>

<body leftMargin=0 topMargin=0 background="image/music/music3_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="onfoc(0)">

<table width="800"  height="590" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width=20 height=10></td>
	<td width=760><?include "top.php";?></td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width=38 height=26>&nbsp;</td>
		<td width=161>&nbsp;</td>
		<td width=161>&nbsp;</td>
		<td width=161>&nbsp;</td>
		<td width=161>&nbsp;</td>
		<td width=78>&nbsp;</td>
	</tr>
	<tr>
		<td height="60" colspan=6 valign=top class="style30w"><span style="color:#c5f300;margin-left:2em"><?=$type_name?></span><span style="color:#ffcc00;margin-left:1em">第<?=$offset/$pageitem+1?>页&nbsp;&nbsp;共<?=ceil($intRowCount/$pageitem)?>页</span></td>
	</tr>
	<tr>
		<td height=30 colspan=6>&nbsp;</td>
	</tr>
	<tr>
		<td height=132>&nbsp;</td>
		<td align=center><?=$photos[0]?></td>
		<td align=center><?=$photos[1]?></td>
		<td align=center><?=$photos[2]?></td>
		<td align=center><?=$photos[3]?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
	    <td height=10 colspan=6>&nbsp;</td>
        </tr>
	<tr>
		<td height="40">&nbsp;</td>
		<td align=center id=0 class="style30b" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><?=$names[0]?></td>
		<td align=center id=1 class="style30b" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><?=$names[1]?></td>
		<td align=center id=2 class="style30b" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><?=$names[2]?></td>
		<td align=center id=3 class="style30b" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><?=$names[3]?></td>
		<td>&nbsp;</td>
        </tr>
	<tr>
	    <td height=28 colspan=6>&nbsp;</td>
        </tr>
	<tr>
		<td height=132>&nbsp;</td>
		<td align=center><?=$photos[4]?></td>
		<td align=center><?=$photos[5]?></td>
		<td align=center><?=$photos[6]?></td>
		<td align=center><?=$photos[7]?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
	    <td height=10 colspan=6>&nbsp;</td>
    </tr>
	<tr>
		<td height="40">&nbsp;</td>
		<td align=center id=4 class="style30b" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><?=$names[4]?></td>
		<td align=center id=5 class="style30b" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><?=$names[5]?></td>
		<td align=center id=6 class="style30b" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><?=$names[6]?></td>
		<td align=center id=7 class="style30b" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><?=$names[7]?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan=6>&nbsp;</td>
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
			style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?type_label=<?=$type_label?>&type_id=<?=$type_id?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>');">上<br>页</a>
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
			style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?type_label=<?=$type_label?>&type_id=<?=$type_id?>&offset=<?=$offset+$pageitem?>');">下<br>页</a>
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
	var key1 = keycode - 48;
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
	if(keycode==36) 
	{
		location="music_typelist.php?type_label=<?=$type_label?>";
	}
	if(keycode==33 && <?=$offset?>!=0) 
	{
		location="?type_label=<?=$type_label?>&type_id=<?=$type_id?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>";
	}
  	if(keycode==34 && <?=$offset+$pageitem?> < <?=$intRowCount?>) 
	{
		location="?type_label=<?=$type_label?>&type_id=<?=$type_id?>&offset=<?=$offset+$pageitem?>";
	}
	if(keycode==37)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0)
		{
			key2=<?=$n-1?>;
		}
		onfoc(key2)
	}
	if(keycode==39)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><?=$n-1?>)
		{
			key2=0;
		}
		onfoc(key2)
	}
	if(keycode==38||keycode==40)
	{
		losefoc(key2);
		if(key2<4)
		{
			key2+=4;
			if(key2><?=$n-1?>)
			{
				key2=0;
			}
		}
		else
		{
			key2-=4;
			if(key2<0)
			{
				key2=<?=$n-1?>;
			}
		}
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