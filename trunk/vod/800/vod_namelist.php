<?
$typeOffset=$_REQUEST["typeOffset"];
$offset=$_REQUEST["offset"];
$dentry_id=$_REQUEST['dentry_id'];
$dentry_name=$_REQUEST['dentry_name'];
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
if($dentry_id=="newup")
{
	$is_need=1;
}
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
if($dentry_id=="newup")
{
	$sql1="select ".$pageitem;
	$sql2="select prog_id,prog_name,quality,prog_path from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1006 and del_flag=1 order by prog_id desc limit 0,".$pageitem;
	$dentry_name="最新添加";
}
elseif($dentry_id=="newpub")
{
	$sql1="select ".$pageitem;
	$sql2="select prog_id,prog_name,quality,prog_path from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1006 and del_flag=1 order by pubdate desc,prog_id desc limit 0,".$pageitem;
	$dentry_name="最新大片";
}
elseif($dentry_id=="top")
{
	$sql1="select ".$pageitem;
	$sql2="select prog_id,prog_name,quality,prog_path from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1006 and del_flag=1 order by count desc limit ".$offset.",".$pageitem;
	$dentry_name="热门点播";
}
else
{
	$sql1="select count(*) from prog_info where prog_name is not null and prog_path is not null and del_flag=1 and prog_kindthr='".$dentry_id."'";
	$sql2="select prog_id,prog_name,quality,prog_path from prog_info where prog_name is not null and prog_path is not null and del_flag=1 and prog_kindthr='".$dentry_id."' order by prog_id desc limit ".$offset.",".$pageitem;
}
$result1=$db->sql_query($sql1);
$intRowCount=$db->sql_fetchfield(0,0,$result1);
$result2=$db->sql_query($sql2);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$dentry_name?></title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body leftMargin=0 topMargin=0 background="image/vod/vod2_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="onfoc(0)">

<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10></td>
	<td width=760><?include "top.php";?></td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table border=0 width="100%" cellspacing=0 cellpadding=0>
	<tr>
		<td height="25">&nbsp;</td>
		<td width="310">&nbsp;</td>
		<td width=3></td>
	</tr>
	<tr>
		<td height=60 align=right valign=top><span class=style30w style="color:#c5f300;margin-right:1em">当前类别：<?=$dentry_name?></span></td>
		<td>&nbsp;</td>
		<td></td>
	</tr>
	<tr>
		<td height=443 valign=bottom>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align=right valign=bottom><span class=style30w style="color:#ffcc00;margin-right:1em">第<?=$offset/$pageitem+1?>页&nbsp;&nbsp;共<?=ceil($intRowCount/$pageitem)?>页</span></td>
		</tr>
		</table>
		</td>
		<td valign=top>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<?
		while($row=$db->sql_fetchrow($result2))
		{
			$prog_id=$row[0];
			$prog_name=$row[1];
			if(strlen($prog_name)>16)
			{
				$prog_name=substr($prog_name,0,14).'..';
			}
			$quality=$row[2];
			$prog_path=$row[3];
			$play_path=getPlayPath($prog_path);
			$play_path_str.='"'.$play_path.'",';
			?>
		<tr>
			<td id="<?=$n?>" height=48 class=style30b onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><a style='color:<?=$vod_text?>' href='vod_introduce.php?typeOffset=<?=$typeOffset?>&nameOffset=<?=$offset?>&dentry_id=<?=$dentry_id?>&dentry_name=<?=urlencode($dentry_name)?>&prog_id=<?=$prog_id?>'><img src="image/vod/quality<?=$quality?>.gif" border=0 align=absmiddle><?=$prog_name?></a></td>
		</tr>
			<?
			$n++;
		}
		if(strlen($play_path_str)>0)
		{
			$play_path_str=substr($play_path_str,0,-1);
		}
		?>
		</table>
		</td>
		<td></td>
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
			style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?typeOffset=<?=$typeOffset?>&dentry_id=<?=$dentry_id?>&dentry_name=<?=urlencode($dentry_name)?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>');">上<br>页</a>
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
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('vod_typelist.php?offset=<?=$typeOffset?>');">返<br>回</td>
	</tr>
	<tr>
		<td height="34%" align=center 
		<?
		if(($offset+$pageitem) < $intRowCount)//表示还有下页
		{
			?>
			style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?typeOffset=<?=$typeOffset?>&dentry_id=<?=$dentry_id?>&dentry_name=<?=urlencode($dentry_name)?>&offset=<?=$offset+$pageitem?>');">下<br>页</a>
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
var play_path_arr=new Array(<?=$play_path_str?>);

function onfoc(n) {
	document.getElementById(n).style.backgroundColor="<?=$vod_selectbar?>";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:<?=$vod_text_focus?>" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	document.getElementById(n).style.backgroundColor="";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:<?=$vod_text?>" ' + dat;
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
	var key1 = keycode -48
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
	if(keycode==70)
	{
		begin();
		location=play_path_arr[key2];
	}
	if(keycode==36)
	{
		location="vod_typelist.php?offset=<?=$typeOffset?>";
	}
	if(keycode==33 && <?=$offset?>!=0)//表示不是第一页
	{
		location="?typeOffset=<?=$typeOffset?>&dentry_id=<?=$dentry_id?>&dentry_name=<?=urlencode($dentry_name)?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>";
	}
	if(keycode==34 && <?=$offset+$pageitem?> < <?=$intRowCount?>)
	{
		location="?typeOffset=<?=$typeOffset?>&dentry_id=<?=$dentry_id?>&dentry_name=<?=urlencode($dentry_name)?>&offset=<?=$offset+$pageitem?>";
	}
	if(keycode==38)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0)
			key2=<?=$n-1?>;
		onfoc(key2)
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><?=$n-1?>) 
			key2=0;
		onfoc(key2)
	}
	if(keycode==13 || keycode==36 || keycode==33 || keycode==34 || (keycode>48&&keycode<58))
	{
	//	location="http://x=50?y=10?delay=2?请稍候…….osd";
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