<?
$type_label=$_REQUEST['type_label'];
if($type_label==6)
{
	header("location:music_mp3_favorite.php");
	exit;
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
switch ($type_label)
{
	case "1":
	  $show_postion = "歌手乐队分类";
	  break;
	case "2":
	  $show_postion = "演唱方式分类";
	  break;
	case "3":
	  $show_postion = "歌名字数分类";
	  break;
	case "4":
	  $show_postion = "歌名首字母分类";
	  break;
	case "5":
	  $show_postion = "其他音乐分类";
	  break;	
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>分类列表</title>
<link rel="stylesheet" href="style.css" type="text/css">

</head>

<body leftMargin=0 topMargin=0 background="image/music/music2_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="document.links[0].focus()">
<table width="800"  height="590" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width=20 height=10>&nbsp;</td>
	<td width=760><?include "top.php";?></td>
	<td width=20 >&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width=250 height=75>&nbsp;</td>
		<td width=319>&nbsp;</td>
		<td width=191>&nbsp;</td>
	</tr>
	<tr>
		<td height=64>&nbsp;</td>
		<td class=style30w valign="top"><span class=style30w style="color:#c5f300;margin-right:0em"><?=$show_postion?>&gt;&gt;</span></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td valign=top>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<?
		include_once "../include/db_connect.php";
		include_once "color.inc.php";
		$i=0;
		if($type_label==1||$type_label==2||$type_label==5)
		{
			$sql1="select type_id from singer_type where type_label=".$type_label." and type_id!=0 order by type_id";
			$result1=$db->sql_query($sql1);
			while($row=$db->sql_fetchrow($result1))
			{
				$type_id=$row[0];
				$i++;
				?>
				<tr>
					<td><a href="music_singer_list.php?type_label=<?=$type_label?>&type_id=<?=$type_id?>" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image<?=$i?>','','image/music/<?=$type_label?>-<?=$type_id?>_2.gif',1);setkey2(<?=($i-1)?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image<?=$i?>','','image/music/<?=$type_label?>-<?=$type_id?>_2.gif',1)"><img src="image/music/<?=$type_label?>-<?=$type_id?>_1.gif" name="Image<?=$i?>" border="0"></a></td>
				</tr>
				<?
			}
		}
		elseif($type_label==3)
		{
			for($i=1;$i<7;$i++)
			{
				?>
				<tr>
					<td><a href="music_other_song.php?type_label=<?=$type_label?>&othertype=wordcount&value=<?=$i?>" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image<?=$i?>','','image/music/<?=$type_label?>-<?=$i?>_2.gif',1);setkey2(<?=($i-1)?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image<?=$i?>','','image/music/<?=$type_label?>-<?=$i?>_2.gif',1)"><img src="image/music/<?=$type_label?>-<?=$i?>_1.gif" name="Image<?=$i?>" border="0"></a></td>
				</tr>
				<?
			}
		}
		elseif($type_label==4)
		{
			$type_id[]='ad';
			$type_id[]='eh';
			$type_id[]='il';
			$type_id[]='mp';
			$type_id[]='qu';
			$type_id[]='wz';
			for($i=1;$i<sizeof($type_id)+1;$i++)
			{
				?>
				<tr>
					<td><a href="music_other_song.php?type_label=<?=$type_label?>&othertype=pinyin&value=<?=$type_id[$i-1]?>" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image<?=$i?>','','image/music/<?=$type_label?>-<?=$i?>_2.gif',1);setkey2(<?=($i-1)?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image<?=$i?>','','image/music/<?=$type_label?>-<?=$i?>_2.gif',1)"><img src="image/music/<?=$type_label?>-<?=$i?>_1.gif" name="Image<?=$i?>" border="0"></a></td>
				</tr>
				<?
			}
		}
		?>
		</table></td>
		<td>&nbsp;</td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="180" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%"></td>
	</tr>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('music_index.php');">返<br>回</td>
	</tr>
	<tr>
		<td height="34%"></td>
	</tr>
	</table>
	</td>
</tr>
</table>
</body>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
var key2=0;
function setkey2(i)
{
	key2=i;
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
	var key1 = keycode -48;
	var patern=/^[1-<?=$i?>]$/; 
	if (patern.exec(key1)) {
		document.links[key1-1].focus();
		location = document.links[key1 - 1];
		
	}
	if(keycode==36)//HOME键
	{
		location="music_index.php";
	}
	if(keycode==38)
	{
		key2--;
		if(key2<0)
		{
			key2=<?=$i-1?>;
		}
		if(navigator.platform=='Win32')
		{
			document.links[key2].focus();
		}
	}
	if(keycode==40)
	{
		key2++;
		if(key2><?=$i-1?>)
		{
			key2=0;
		}
		if(navigator.platform=='Win32')
		{
			document.links[key2].focus();
		}
	}
}    
document.onkeydown=keyDown
//onfoc(0);
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