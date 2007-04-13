<?
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
include_once "../include/toPinyin.php";
$fc_col=3;
$singer_col=4;
$singer_row=13;
$singer_name_height=33;
$singer_name_count=$singer_col*$singer_row;
$sql1="select distinct singer_name_fc from singer_info where mp3_count>0 order by singer_name_fc";
$result1=$db->sql_query($sql1);
$fc_count=0;//按歌手名首字母分组的组数,fc即first char
while($row=$db->sql_fetchrow($result1))
{
	$singer_name_fc=$row[0];
	if($singer_name_fc=='')
	{
		continue;
	}
	$singer_name_fc_arr[]=$singer_name_fc;
	$sql2="select singer_id,singer_name from singer_info where mp3_count>0 and singer_name_fc='".$singer_name_fc."' order by singer_name limit 0,".$singer_name_count;
	$result2=$db->sql_query($sql2);
	$fc_singer_count[$fc_count]=$db->sql_numrows($result2);//每一组的歌手数
	while($row2=$db->sql_fetchrow($result2))
	{
		$singer_id_arr[$fc_count][]=$row2[0];
		$singer_name=$row2[1];
		if(strlen($singer_name)>8)
		{
			$singer_name=substr($singer_name,0,8).' ';
		}
		$singer_name_arr[$fc_count][]=$singer_name;
	}
	$fc_count++;
}
$fc_foc=floor($fc_count/2);
$singer_foc=floor($fc_singer_count[$fc_foc]/2);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>所有歌手</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script language="JavaScript" type="text/JavaScript">
//歌手名首字母集合，一维数组
var singer_name_fc_arr=new Array(<?=$fc_count?>);
<?
for($i=0;$i<$fc_count;$i++)
{
?>
singer_name_fc_arr[<?=$i?>]="<?=$singer_name_fc_arr[$i]?>";
<?
}
?>

//按首字母分组的歌手id集合，二维数组
var singer_id_arr=new Array(<?=$fc_count?>);
//按首字母分组的歌手名的集合,二维数组
var singer_name_arr=new Array(<?=$fc_count?>);
<?
for($i=0;$i<$fc_count;$i++)
{
?>
singer_id_arr[<?=$i?>]=new Array(<?=sizeof($singer_id_arr[$i])?>);
singer_name_arr[<?=$i?>]=new Array(<?=sizeof($singer_name_arr[$i])?>);
<?
	for($j=0;$j<sizeof($singer_id_arr[$i]);$j++)
	{
?>
singer_id_arr[<?=$i?>][<?=$j?>]="<?=$singer_id_arr[$i][$j]?>";
singer_name_arr[<?=$i?>][<?=$j?>]="<?=$singer_name_arr[$i][$j]?>";
<?
	}
}
?>

var fc_col=<?=$fc_col?>;//左边的字母索引列数
var singer_col=<?=$singer_col?>;//右边的按首字母分组的歌手列表列数
var key2=<?=$fc_foc?>;//左边字母索引的默认焦点位置
var key3=Math.floor((singer_id_arr[key2].length)/2);//右边歌手的默认焦点位置
function init()
{
	var left_dat='<table width="100%" height="100%" border=0 cellpadding=0 cellspacing=0>';
	for(i=0; i < <?=$fc_count?>; i++)
	{
		if(i%fc_col==0)
		{
			left_dat+='<tr>';
		}
		left_dat+='<td id="'+i+'" align=center class=style30b style="cursor:hand" onClick=show('+i+') onMouseOver=\'this.style.backgroundColor="<?=$music_selectbar?>"\' onMouseOut=\'this.style.backgroundColor=""\'>'+singer_name_fc_arr[i]+'</td>';
		if(i%fc_col==(fc_col-1))
		{
			left_dat+='</tr>';
		}
	}
	left_dat+='</table>';
	document.getElementById('left').innerHTML=left_dat;
	fc_onfoc(key2);
}

function show(n) 
{
	var fc_id=n;
	var right_dat='<table width="100%" border=0 cellpadding=0 cellspacing=0>';
	for(i = 0; i < singer_id_arr[fc_id].length; i++)
	{
		if(i % singer_col==0)
		{
			right_dat+='<tr>';
		}
		right_dat+='<td id="'+(i+40)+'" height="<?=$singer_name_height?>" onMouseOver=\'this.style.backgroundColor="<?=$music_selectbar?>"\' onMouseOut=\'this.style.backgroundColor=""\'><a class=style30w style="color:<?=$music_text?>" href="music_mp3_song.php?from=listall&singer_id='+singer_id_arr[fc_id][i]+'">'+singer_name_arr[fc_id][i]+'</a></td>';
		if(i % singer_col==(singer_col-1))
		{
			right_dat+='</tr>';
		}
	}
	right_dat+='</table>';
	document.getElementById('right').innerHTML=right_dat;
	singer_onfoc(key3);
}

function fc_onfoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	t2.innerHTML = '<table width="100%" height="100%" bgcolor="<?=$music_selectbar?>" border=0 cellpadding=0 cellspacing=0><tr><td align=center valign=center class=style30b id=fc><span style="color:<?=$music_text_focus?>">' + dat + '</span></td></tr></table>';
	show(n);
}

function fc_losefoc(n) {
	t2 = document.getElementById(n);
	t3 = document.getElementById('fc');
	dat = t3.innerHTML;
	dat = dat.substring(dat.indexOf(">")+1);
	dat = dat.substring(0,dat.indexOf("<"));
	t2.innerHTML = dat;
}
function singer_onfoc(n) {
	n+=40;
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<table width="100%" height="100%" bgcolor="<?=$music_selectbar?>" border=0 cellpadding=0 cellspacing=0><tr><td valign=center id=singer><a class=style30w style="color:<?=$music_text_focus?>" ' + dat + '</a></td></tr></table>';
	document.links[n-40].focus();
}

function singer_losefoc(n) {
	n+=40;
	t2 = document.getElementById(n);
	t3 = document.getElementById('singer');
	dat = t3.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<a class=style30w style="color:<?=$music_text?>"  ' + dat;
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
	if(keycode==13)
	{
		document.getElementById('blink').innerHTML='正在打开页面,请稍候...';
		location = document.links[key2];
	}
	if(keycode==36)
	{
		location="music_index.php";
	}
	if(keycode==37)
	{
		singer_losefoc(key3);
		key3--;
		if(key3<0)
		{
			key3=singer_id_arr[key2].length-1;
		}
		singer_onfoc(key3)
	}
	if(keycode==39)
	{
		singer_losefoc(key3);
		key3++;
		if(key3>singer_id_arr[key2].length-1) 
		{
			key3=0;
		}
		singer_onfoc(key3)
	}
	if(keycode==38)
	{
		fc_losefoc(key2);
		key2--;
		if(key2<0)
		{
			key2=<?=$fc_count?>-1
		}
		key3=Math.floor((singer_id_arr[key2].length)/2);
		fc_onfoc(key2);
	}
	if(keycode==40)
	{
		fc_losefoc(key2);
		key2++;
		if(key2 > <?=$fc_count-1?>)
		{
			key2=0;
		}
		key3=Math.floor((singer_id_arr[key2].length)/2);
		fc_onfoc(key2);
		
	}
	if(keycode==54)
	{
		location="music_mp3_favorite.php";
	}
}
document.onkeydown=keyDown

</script>
</head>
<body leftMargin=0 topMargin=0 background="image/music/music6_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="init()">
<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10>&nbsp;</td>
	<td width=760><?include "top.php";?></td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table border=0 width="100%" cellspacing=0 cellpadding=0>
	<tr>
		<td width=24 height=22>&nbsp;</td>
		<td width="726">&nbsp;</td>
		<td width=10>&nbsp;</td>
	</tr>
	<tr>
		<td></td>
		<td height=50 valign=top><span class=style30w style="color:#c5f300;margin-left:2em">所有MP3歌手列表：</span></td>
		<td></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td valign=top>
		<table width="100%" height=452 border=0 cellspacing=0 cellpadding=0>
		<tr>
			<td width=122 id=left valign=top><!-- 左边歌手首字母 --></td>
			<td width=12>&nbsp;<!-- 中间间隔 --></td>
			<td id=right><!-- 右边歌手名称 --></td>
		</tr>
		</table>
		<table width="100%" border=0 cellspacing=0 cellpadding=0>
		<tr>
			<td height=6></td>
		</tr>
		<tr>
			<td valign=top class=style30w id=blink>
			<blink>&nbsp;上下键选择歌手名首字母，左右键选择歌手</blink></td>
		</tr>
		</table>
		</td>
		<td></td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="180" border=0 cellpadding=0 cellspacing=0 class=style24w>
	<tr>
		<td height="33%"></td>
	</tr>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$daily_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('music_index.php');">返<br>回</td>
	</tr>
	<tr>
		<td height="34%"></td>
	</tr>
	</table>
	</td>
</tr>
</table>
</body>
</html>
<?
$fwp=fopen($html_file,"w"); 
fwrite($fwp,ob_get_contents());
fclose($fwp);
ob_end_flush();
}
?>