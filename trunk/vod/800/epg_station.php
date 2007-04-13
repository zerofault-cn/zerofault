<?
session_start();
$_SESSION['menu_focus']=4;
$offset=$_REQUEST["offset"];
if(!isset($offset)||$offset=="")
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
include_once "color.inc.php";
include_once "../include/db_connect.php";
$type='tv';
$pageitem=8;
$line_height=50;
$n=0;
$sql1="select count(*) from epg_station where type='".$type."' and del_flag=1";
$sql2="select * from epg_station where type='".$type."' and del_flag=1 order by sort_id,binary station_name limit ".$offset.",".$pageitem;
$result1=$db->sql_query($sql1);
$intRowCount=$db->sql_fetchfield(0,0,$result1);
$result2=$db->sql_query($sql2);
while($row=$db->sql_fetchrow($result2))
{
	$tmp_station_id	=$row['station_id'];
	$station_name	=$row['station_name'];
	$station_path	=$row['station_path'];
	$fps			=$row['fps'];
	$zoom_flag		=$row['zoom_flag'];
	$force_flag		=$row['force_flag'];
	$pubtype		=$row['pubtype'];
	if(strlen($station_name)>26)
	{
		$station_name=substr($station_name,0,26);
	}
	$sdp_path=$play_path=$station_path;
	if($type=="tv")
	{
		if($pubtype==0)
		{
			$play_path=$play_path.'=hw';
		}
		elseif($pubtype==1)
		{
			$play_path=$play_path.'=sf';
		}
		elseif($pubtype==2)
		{
			$play_path=$play_path.'=vlc1';
		}
		elseif($pubtype==3)
		{
			$play_path=$play_path.'=vlc3';
		}
		elseif($pubtype==4)
		{
			$play_path=$play_path.'=vlc5';
		}
		if($fps!=0&&$fps!="")
		{
			$play_path=$play_path."?fps=".$fps;
		}
		if($force_flag)
			$play_path.="%force";
	}
	$sdp_path=str_replace('sdp:','http:',str_replace('xml','sdp',$sdp_path));
	$sts[$n]=array($tmp_station_id,$station_name,$play_path,$sdp_path);
	$n++;
}

if(!isset($station_id)||$station_id=="")
{
	$station_id=$sts[0][0];
	$vfocus=0;
}
else
{
	for($i=0;$i<$n;$i++)
	{
		if($sts[$i][0]==$station_id)
		{
			$vfocus=$i;
		}
	}
}
$sql3="select * from epg_station where type='".$type."' and del_flag=1 order by sort_id,binary station_name";
$result3=$db->sql_query($sql3);
while($row=$db->sql_fetchrow($result3))
{
	$station_path	=$row['station_path'];
	$fps			=$row['fps'];
	$zoom_flag		=$row['zoom_flag'];
	$force_flag		=$row['force_flag'];
	$pubtype		=$row['pubtype'];
	$sdp_path=$play_path=$station_path;
	if($type=="tv")
	{
		if($pubtype==0)
		{
			$play_path=$play_path.'=hw';
		}
		elseif($pubtype==1)
		{
			$play_path=$play_path.'=sf';
		}
		elseif($pubtype==2)
		{
			$play_path=$play_path.'=vlc1';
		}
		elseif($pubtype==3)
		{
			$play_path=$play_path.'=vlc3';
		}
		elseif($pubtype==4)
		{
			$play_path=$play_path.'=vlc5';
		}
		if($fps!=0&&$fps!="")
		{
			$play_path=$play_path."?fps=".$fps;
		}
		if($force_flag)
			$play_path.="%force";
	}
	$allpath[]=$play_path;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>数字电视</title>
<link rel="stylesheet" href="style.css" type="text/css">

</head>

<body leftMargin=0 topMargin=0 onload="mm()" background="image/epg/tv1_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;">
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
	<table width="100%" border=0 cellpadding="0" cellspacing="0">
	<tr>
		<td width="102" height="15">&nbsp;</td>
		<td width="323">&nbsp;</td>
		<td width="335">&nbsp;</td>
	</tr>
	<tr>
		<td height=78 align=center><span id=tv_num class=style32w style="color:#00FF00">_</span></td>
		<td valign="top" align=right><span class=style30w style="color:#ffcc00;margin-right:1em">第<?=$offset/$pageitem+1?>页&nbsp;&nbsp;共<?=ceil($intRowCount/$pageitem)?>页</span></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height=210>&nbsp;</td>
		<td valign=top>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <?
		for($i=0;$i<$n;$i++)
		{
			?>
        <tr>
          	<td id=<?=$i?> height="<?=$line_height?>" class=style30w style="cursor:hand"  onMouseOver='this.style.backgroundColor="#004bb4"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('<?=$sts[$i][3]?>');"><?=$offset+$i?>&nbsp;<?=$sts[$i][1]?> </td>
        </tr>
			<?
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
		<td height="33%" 
		<?
		if($offset!=0)//表示不是第一页
		{
			?>
			style="cursor:hand" align=center onMouseOver='this.style.backgroundColor="#004bb4"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?type=<?=$type?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>');">上<br>页
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
		<td height="33%" style="cursor:hand" align=center onMouseOver='this.style.backgroundColor="#004bb4"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('menu_1.php');">返<br>回</a></td>
	</tr>
	<tr>
		<td height="34%" 
		<?
		if(($offset+$pageitem) < $intRowCount)
		{
			?>
			style="cursor:hand" align=center onMouseOver='this.style.backgroundColor="#004bb4"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?type=<?=$type?>&offset=<?=$offset+$pageitem?>');">下<br>页
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
var vfocus = <?=$vfocus?>;
var station_id = <?=$station_id?>;
var n=0;

//节目id，一维数组
var nums= new Array(<?=$n?>);
<?
for($i=0;$i<$n;$i++)
	{
?>
nums[<?=$i?>]="<?=$sts[$i][0]?>";
<?
	}
?>
//当前页节目播放路径,一维数组
var paths = new Array(<?=$n?>);
<?
for($i=0;$i<$n;$i++)
	{
?>
paths[<?=$i?>]="<?=$sts[$i][2]?>";
<?
	}
?>
//所有节目播放路径,一维数组
var allpath=new Array(<?=sizeof($allpath)?>);
<?
for($i=0;$i<sizeof($allpath);$i++)
	{
?>
allpath[<?=$i?>]="<?=$allpath[$i]?>";
<?
	}
?>
function mm() {
	document.getElementById(vfocus).style.backgroundColor="<?=$epg_selectbar?>";
	document.getElementById(vfocus).style.color="<?=$epg_text_focus?>";
}
function onfoc(n) {
	document.getElementById(n).style.backgroundColor="<?=$epg_selectbar?>";
	document.getElementById(n).style.color="<?=$epg_text_focus?>";
}

function losefoc(n) {
	document.getElementById(n).style.backgroundColor="";
	document.getElementById(n).style.color="<?=$epg_text?>";
}

function begin()
{
	t1 = document.getElementById(vfocus);
	dat = t1.innerHTML;
	dat = dat.substring(0,dat.indexOf("</td>"));
	dat = dat+'<img src=image/ing.gif height=24>';
	t1.innerHTML = dat + '</td>';
	window.setTimeout('end()',5000);
	
}
function end()
{
	t1 = document.getElementById(vfocus);
	dat = t1.innerHTML;
	dat = dat.substring(dat.indexOf(">")+1);
	dat = dat.substring(0,dat.indexOf("<"));
	t1.innerHTML ='<td height="<?=$line_height?>" class=style30w bgcolor="<?=$epg_selectbar?>" style="color:<?=$epg_text_focus?>">'+dat+'</td>'; 
}
var tv_num=0;
var tv_num_len=1;
function ch_len()
{
	if(tv_num_len==1)
	{
		tv_num_len=2;
		document.getElementById('tv_num').innerHTML='_ _';
	}
	else
	{
		tv_num_len=1;
		document.getElementById('tv_num').innerHTML='_';
	}
	tv_num=0;
}
if(document.all)
{
	var ie=1;
	var ns=0;
}
else
{
	var ns=1;
	var ie=0;
}
function keyDown(e)
{
	if (ns)
	{ 
		var keycode=e.which
	} 
	if (ie)
	{ 
		var keycode=event.keyCode; 
	} 
	var key1 = keycode -48
	if(keycode==13||keycode==70)
	{
	//	begin();
		location = paths[vfocus];
	//	alert(llocation);
	}
	if(keycode==190)//.键
	{
		ch_len();
	}
	if(keycode==221)//绿键
	{
		location="sdp://sntx.169ol.com:8088/sdp/list.xml=pls";
	}
	if(keycode==59 || keycode==186)//蓝键,节目单
	{
	//	location ="epg_schedule.php?type=<?=$type?>&staOffset=<?=$offset?>&station_id="+nums[vfocus];
	}
	if(keycode==33 && <?=$offset?>!=0)
	{
		location ="?type=<?=$type?>&offset=<?=max($offset-$pageitem,0)?>";
	}
	if(keycode==34 && <?=$offset+$pageitem?> < <?=$intRowCount?>)
	{
		location ="?type=<?=$type?>&offset=<?=$offset+$pageitem?>";
	}
	if(keycode==38)
	{
		losefoc(vfocus);
		vfocus--;
		if(vfocus < 0 && <?=$offset?>!=0)
		{
			location ="?type=<?=$type?>&offset=<?=max($offset-$pageitem,0)?>";
		}
		else 
		{
			if(vfocus<0)
				vfocus=<?=$n-1?>;
			onfoc(vfocus);
		}
	}
	if(keycode==40)
	{
		losefoc(vfocus);
		vfocus++;
		if((vfocus > <?=$intRowCount-$pageitem*(ceil($intRowCount/$pageitem)-1)-1?>) && (<?=$offset/$pageitem+1?>==<?=ceil($intRowCount/$pageitem)?>))//当前焦点指针大于当前页行数,并且当前页是最后页
		{
			vfocus=0;
			onfoc(vfocus);
		}
		else if(vfocus > <?=$pageitem-1?>)//当前焦点已到本页最后一行,翻下页
		{
			location ="?type=<?=$type?>&offset=<?=$offset+$pageitem?>";
		}
		else
		{
			onfoc(vfocus);
		}
	}
	if(keycode==36)
	{
		location ="menu_1.php";
	}
	if(keycode>47 && keycode<59)
	{
		tmp_keycode=keycode-48;
		if(tv_num_len==1)
		{
			tv_num=tmp_keycode;
			document.getElementById('tv_num').innerHTML=tv_num;
			if(allpath[tv_num])
			{
				location=allpath[tv_num];
			}
			else
			{
				document.getElementById('tv_num').innerHTML='无此<br>频道';
			}
		}
		if(tv_num_len==2)
		{
			if(tv_num.toString().length==2)
			{
				tv_num=0;
			}
			tv_num=tv_num*10+tmp_keycode;
			if(tv_num.toString().length==1)
			{
				document.getElementById('tv_num').innerHTML=tv_num+' _';
			}
			if(tv_num.toString().length==2)
			{
				document.getElementById('tv_num').innerHTML=tv_num;
				if(allpath[tv_num])
				{
					location=allpath[tv_num];
				}
				else
				{
					document.getElementById('tv_num').innerHTML='无此<br>频道';
				}
			}
		}
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