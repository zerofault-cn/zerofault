<?
$from=$_REQUEST['from'];
$singer_id=$_REQUEST['singer_id'];
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
$sql1="select distinct binary album_name from song_info where del_flag=1 and singer_id=".$singer_id." order by id";
$result1=$db->sql_query($sql1);
$album_count=0;
while($row=$db->sql_fetchrow($result1))
{
	$album_name=$row[0];
	$tmp_album_name=$album_name;
	if(strlen($album_name)>14)
	{
		$tmp_album_name=substr($album_name,0,12).'..';
	}
	$album_name_arr[]=$tmp_album_name;
	$sql2="select id,song_name,path from song_info where del_flag=1 and binary  album_name='".addslashes($album_name)."' and singer_id=".$singer_id." order by id";//循环查找当前歌手所有歌曲，并按专辑分别存储
	$result2=$db->sql_query($sql2);
	$song_count[$album_count]=$db->sql_numrows($result2);//某个专辑的歌曲总数
	while($row2=$db->sql_fetchrow($result2))
	{
		$song_id_arr[$album_count][]=$row2[0];
		$song_name=$row2[1];
		if(strlen($song_name)>20)
		{
			$song_name=substr($song_name,0,18).'..';
		}
		$song_name_arr[$album_count][]=$song_name;
		$song_path=$row2[2];
		$locate=getLocate($song_path);
		if($locate=='local')
		{
			$server_ip=getServerIp();
		}
		else
		{
			$server_ip=getIpByPath($song_path);
		}
		$play_path='http://'.$server_ip.':8088/'.$song_path;
		$song_path_arr[$album_count][]=$play_path;
		$song_select_flag_arr[$album_count][]='0';
	}
	$album_count++;
}
$sql3="select count(id) from song_info where del_flag=1  and singer_id=".$singer_id;
$result3=$db->sql_query($sql3);
$intRowCount=$db->sql_fetchfield(0,0,$result3);//歌手所有歌曲总数

$sql4="select singer_name from singer_info where singer_id=".$singer_id;
$result4=$db->sql_query($sql4);
$singer_name=$db->sql_fetchfield(0,0,$result4);//取得歌手名

$album_num_color='#ffff00';
$song_num_color='#CC00FF';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>mp3按专辑列表</title>
<link rel="stylesheet" href="style.css" type="text/css">
<style>
.album_name
{
	font-size: 30px;
	color:<?=$music_text?>;
	line-height:140%;
}
.song_name
{
	font-size: 30px;
	color:<?=$music_text?>;
	line-height:125%;
}
</style>
<script language="JavaScript" type="text/JavaScript">
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
//专辑名,一维数组
var album_name_arr=new Array(<?=$album_count?>);
//专辑歌曲数，一位数组
var song_count_arr=new Array(<?=$album_count?>);
<?
for($i=0;$i<$album_count;$i++)
{
?>
album_name_arr[<?=$i?>]="<?=$album_name_arr[$i]?>";
song_count_arr[<?=$i?>]="<?=$song_count[$i]?>";
<?
}
?>
//专辑歌名信息,即第几个专辑包含哪些歌名,二维数组
var song_name_arr=new Array(<?=$album_count?>);
//专辑id信息，即第几个专辑包含那些歌曲id，二维数组
var song_id_arr=new Array(<?=$album_count?>);
//专辑歌曲路径信息，即第几个专辑包含哪些播放路径，二维数组
var song_path_arr=new Array(<?=$album_count?>);
//专辑歌曲选择标志,二维数组
var song_select_flag_arr=new Array(<?=$album_count?>);
<?
for($i=0;$i<$album_count;$i++)
{
	?>
song_name_arr[<?=$i?>]=new Array(<?=$song_count[$album_count]?>);
song_id_arr[<?=$i?>]=new Array(<?=$song_count[$album_count]?>);
song_path_arr[<?=$i?>]=new Array(<?=$song_count[$album_count]?>);
song_select_flag_arr[<?=$i?>]=new Array(<?=$song_count[$album_count]?>);
<?
	for($j=0;$j<$song_count[$i];$j++)
	{
		?>
song_name_arr[<?=$i?>][<?=$j?>]="<?=$song_name_arr[$i][$j]?>";
song_id_arr[<?=$i?>][<?=$j?>]="<?=$song_id_arr[$i][$j]?>";
song_path_arr[<?=$i?>][<?=$j?>]="<?=$song_path_arr[$i][$j]?>";
song_select_flag_arr[<?=$i?>][<?=$j?>]="<?=$song_select_flag_arr[$i][$j]?>";
<?
	}
}
?>

var select_album_flag=0;//当前选择的专辑序号
var select_song_flag=0;//当前选择的歌曲序号
var album_item=8;//每页显示专辑数
var song_item=10;//每专辑每页显示歌曲数
var select_song_id = new Array();
var select_song_path=new Array();
var select_song_num=0;//已选择的歌曲的数目
var all_song_id = '';//用户选取的歌曲id集合
var album_n,song_n;
var select_pic_unfoc='image/music/unselect_unfoc.gif';//非焦点时的选择框图片
var select_pic_foc='image/music/unselect_foc.gif';//焦点状态下的选择框图片

function init()
{
	for(i=0; i < Math.min(album_name_arr.length,album_item); i++)
	{
		document.getElementById(i).innerHTML='<table width="100%" height="100%"border=0 cellpadding=0 cellspacing=0><tr><td id="album'+i+'" class=album_name style="cursor:hand" onClick=show('+i+') onMouseOver=\'this.style.backgroundColor="<?=$music_selectbar?>"\' onMouseOut=\'this.style.backgroundColor=""\'><span style="color:<?=$album_num_color?>">'+(i+1)+'.</span>'+album_name_arr[i]+'</td><td width=25 align=center><img name="finger'+i+'" src="image/music/right.gif" style="visibility:hidden"></td></tr></table>';
	}
	album_onfoc(0);
}
function album_onfoc(n)
{
	document.getElementById('album'+n%album_item).style.backgroundColor="<?=$music_selectbar?>";
	document.getElementById('album'+n%album_item).style.color="<?=$music_text_focus?>";
	eval("document.finger"+(n%album_item)).style.visibility = "visible";
	show(n);
}
function album_losefoc(n)
{
	song_losefoc(select_song_flag);
	document.getElementById('album'+n%album_item).style.backgroundColor="";
	document.getElementById('album'+n%album_item).style.color="<?=$music_text?>";
	eval("document.finger"+(n%album_item)).style.visibility = "hidden";
}
function song_onfoc(n)
{
	document.getElementById(n%song_item+10).style.backgroundColor="<?=$music_selectbar?>";
	document.getElementById(n%song_item+20).style.color="<?=$music_text_focus?>";
	eval("document.select"+(n%song_item)).src=select_pic_foc;
	td=document.getElementById('link'+n%song_item);
	dat =td.innerHTML;
//	alert(dat);
	dat = dat.substring(dat.indexOf("onclick="));
	td.innerHTML = '<a ' + dat;
	document.links[n%song_item].focus();
}
function song_losefoc(n)
{
	document.getElementById(n%song_item+10).style.backgroundColor="";
	document.getElementById(n%song_item+20).style.color="<?=$music_text?>";
	eval("document.select"+(n%song_item)).src=select_pic_unfoc;
	td=document.getElementById('link'+n%song_item);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("onclick="));
	td.innerHTML = '<a ' + dat;
}
function show(n) 
{
	document.getElementById('song_count').innerHTML=song_count_arr[n];
	for(i = 0; i < Math.min(song_count_arr[n],song_item); i++)
	{
		swap_select_pic(n,i);
		document.getElementById(i+10).innerHTML='<table width="100%" height="100%" border=0 cellpadding=0 cellspacing=0><tr><td id="'+(i+20)+'" class=song_name style="cursor:hand"  onMouseOver=\'this.style.backgroundColor="<?=$music_selectbar?>"\' onMouseOut=\'this.style.backgroundColor=""\' onclick=\'window.location=("'+song_path_arr[n][i]+'");\'><span style="color:<?=$song_num_color?>">'+(i+1)+'.</span>'+song_name_arr[n][i]+'</td><td align=right id="link'+i+'"><a onclick="select_song('+n+','+i+')" href="javascript:void(0)"><img name="select'+i+'" src="'+select_pic_unfoc+'" border="0"></a></td></tr></table>';
	}
	for(i=song_count_arr[n];i<song_item;i++)
	{
		document.getElementById(Math.round(i)+10).innerHTML='&nbsp;';
	}
	swap_select_pic(n,0);
	song_onfoc(0);
}

function select_song(n,i)
{
	if(song_select_flag_arr[n][i]==1)
	{
		for(j=0 ; j<select_song_num ; j++)
		{
			if(select_song_id[j]==song_id_arr[n][i]) 
			{
				flag_j=j;
			}
		}
		for(j=flag_j+1 ; j<select_song_num ; j++)
		{
			select_song_id[flag_j]=select_song_id[j];
			select_song_path[flag_j]=select_song_path[j];
			flag_j++;
		}
		select_song_num--;
		song_select_flag_arr[n][i]=0;
		swap_select_pic(n,i);
		eval("document.select"+(i%song_item)).src=select_pic_foc;
	}
	else
	{
		select_song_id[select_song_num] = song_id_arr[n][i];
		select_song_path[select_song_num]=song_path_arr[n][i];
		select_song_num++;
		song_select_flag_arr[n][i]=1;
		swap_select_pic(n,i);
		eval("document.select"+(i%song_item)).src=select_pic_foc;
	}
}

function swap_select_pic(album_n,song_n)
{
	if(song_select_flag_arr[album_n][song_n]==0)
	{
		select_pic_unfoc="image/music/unselect_unfoc.gif";
		select_pic_foc="image/music/unselect_foc.gif";
	}
	else
	{
		select_pic_unfoc="image/music/select_unfoc.gif";
		select_pic_foc="image/music/select_foc.gif";
	}
}

function album_newPage(n) 
{
	if(n%album_item == album_item-1)//往上翻
	{		
		for(i = 0; i < album_item; i++) 
		{
			document.getElementById(i).innerHTML='<table width="100%" height="100%"border=0 cellpadding=0 cellspacing=0><tr><td id="album'+i+'" class=album_name style="cursor:hand" onClick=show('+i+') onMouseOver=\'this.style.backgroundColor="<?=$music_selectbar?>"\' onMouseOut=\'this.style.backgroundColor=""\'><span style="color:<?=$album_num_color?>">'+(n-album_item+1+i+1)+'.</span>'+album_name_arr[n-album_item+1+i]+'</td><td width=25 align=center><img name="finger'+i+'" src="image/music/right.gif" style="visibility:hidden"></td></tr></table>';
		}
	}
	else //往下翻
	{
		for(i = 0; i < album_item; i++) 
		{
			if((n + i) > (album_name_arr.length - 1)) 
			{
				document.getElementById(i).innerHTML='';
			}
			else 
			{
				document.getElementById(i).innerHTML='<table width="100%" height="100%"border=0 cellpadding=0 cellspacing=0><tr><td id="album'+i+'" class=album_name style="cursor:hand" onClick=show('+i+') onMouseOver=\'this.style.backgroundColor="<?=$music_selectbar?>"\' onMouseOut=\'this.style.backgroundColor=""\'><span style="color:<?=$album_num_color?>">'+(n+i+1)+'.</span>'+album_name_arr[n+i]+'</td><td width=25 align=center><img name="finger'+i+'" src="image/music/right.gif" style="visibility:hidden"></td></tr></table>';
			}
		}
	}
	album_onfoc(n);
}

function song_newPage(album_n,song_n)
{
	if((song_n % song_item) == (song_item-1))//向前翻页
	{		
		for(i = 0; i < song_item; i++) 
		{
			swap_select_pic(album_n,song_n-(song_item-1)+i);
			document.getElementById(i+10).innerHTML='<table width="100%" height="100%" border=0 cellpadding=0 cellspacing=0><tr><td id="'+(i+20)+'" class=song_name style="cursor:hand"  onMouseOver=\'this.style.backgroundColor="<?=$music_selectbar?>"\' onMouseOut=\'this.style.backgroundColor=""\' onclick=\'window.location=("'+song_path_arr[album_n][song_n-(song_item-1)+i]+'");\'><span style="color:<?=$song_num_color?>">'+(song_n-(song_item-1)+i+1)+'.</span>'+song_name_arr[album_n][song_n-(song_item-1)+i]+'</td><td align=right id="link'+i+'"><a onclick="select_song('+album_n+','+(song_n-(song_item-1)+i)+')" href="javascript:void(0)"><img name="select'+i+'" src="'+select_pic_unfoc+'" border="0"></a></td></tr></table>';
		}
	}
	else//向后翻页
	{
		for(i = 0; i < song_item; i++) 
		{
			if((song_n + i) > (song_count_arr[album_n] - 1)) 
			{
				document.getElementById(i+10).innerHTML='&nbsp;';
			}
			else 
			{
				swap_select_pic(album_n,song_n+i);
				document.getElementById(i+10).innerHTML='<table width="100%" height="100%" border=0 cellpadding=0 cellspacing=0><tr><td id="'+(i+20)+'" class=song_name style="cursor:hand"  onMouseOver=\'this.style.backgroundColor="<?=$music_selectbar?>"\' onMouseOut=\'this.style.backgroundColor=""\' onclick=\'window.location=("'+song_path_arr[album_n][song_n+i]+'");\'><span style="color:<?=$song_num_color?>">'+(song_n+i+1)+'.</span>'+song_name_arr[album_n][song_n+i]+'</td><td align=right id="link'+i+'"><a onclick="select_song('+album_n+','+(song_n+i)+')" href="javascript:void(0)"><img name="select'+i+'" src="'+select_pic_unfoc+'" border="0"></a></td></tr></table>';
			}
		}
	}
	swap_select_pic(album_n,song_n);
	song_onfoc(song_n);
}

function array_to_string()
{
	all_song_id='';
	all_song_path='';
	for( i=0 ; i< select_song_num-1 ; i++)
	{
		var a="|";
		all_song_id+=select_song_id[i] + a;
		all_song_path+=select_song_path[i]+a;
	}
	all_song_id = all_song_id + select_song_id[i];
	all_song_path = all_song_path + select_song_path[i];
}

function end()
{
	document.getElementById('blink').innerHTML='<br><blink>【0】键查看帮助</blink>';
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
	if(keycode==38 && select_album_flag > 0)//上键切换专辑
	{
		album_losefoc(select_album_flag);
		j = select_album_flag % album_item;
		select_album_flag--;
		if(j == 0) 
		{
			album_newPage(select_album_flag);
		}
		else 
		{
			album_onfoc(select_album_flag);
		}
		select_song_flag=0;
	}
	if(keycode==40 && select_album_flag < album_name_arr.length-1)//下键切换专辑
	{
		album_losefoc(select_album_flag);
		j = select_album_flag % album_item;
		select_album_flag++;
		if(j == album_item-1) 
		{
			album_newPage(select_album_flag);
		}
		else 
		{
			album_onfoc(select_album_flag);
		}
		select_song_flag=0;
	}
	if(keycode==37 && select_song_flag > 0)//左键切换歌曲
	{
		song_losefoc(select_song_flag);
		j = select_song_flag % song_item;
		select_song_flag--;
		if(j == 0)
		{
			song_newPage(select_album_flag,select_song_flag);
		}
		else
		{
			swap_select_pic(select_album_flag,select_song_flag);
			song_onfoc(select_song_flag);
		}
	}
	if(keycode==39 && select_song_flag < song_count_arr[select_album_flag]-1)//左键切换歌曲
	{
		song_losefoc(select_song_flag);
		j = select_song_flag % song_item;
		select_song_flag++;
		if(j == (song_item-1))
		{
			song_newPage(select_album_flag,select_song_flag);
		}
		else
		{
			swap_select_pic(select_album_flag,select_song_flag);
			song_onfoc(select_song_flag);
		}
	}
	if(keycode==70)//播放键,播放光标位置所在处的歌曲
	{
		document.getElementById('blink').innerHTML='<br>正在打开,请稍候...';
		window.setTimeout('end()',5000);
		if(navigator.platform=='Win32')
		{
			location='music_mp3_play.php?song_id='+song_id_arr[select_album_flag][select_song_flag];
		}
		else
		{
			location='list://"'+song_path_arr[select_album_flag][select_song_flag]+'"';
		}
		
	}
	if(keycode==59 || keycode==186)//蓝键,连续播放当前专辑
	{
		document.getElementById('blink').innerHTML='<br>正在打开,请稍候...';
		window.setTimeout('end()',5000);
		album_song_id='';
		album_song_path='';
		for(i=0;i<song_count_arr[select_album_flag]-1;i++)
		{
			a='|';
			album_song_id+=song_id_arr[select_album_flag][i]+a;
			album_song_path+=song_path_arr[select_album_flag][i]+a;
		}
		album_song_id	= album_song_id + song_id_arr[select_album_flag][i];
		album_song_path = album_song_path + song_path_arr[select_album_flag][i];
		if(navigator.platform=='Win32')
		{
			location='music_mp3_play.php?song_id='+album_song_id;
		}
		else
		{
			location='list://"'+album_song_path+'"';
		}
		
	}
	if(keycode==221 && select_song_num != 0)//绿键,播放选择的歌曲
	{
		document.getElementById('blink').innerHTML='<br>正在打开,请稍候...';
		window.setTimeout('end()',5000);
		array_to_string();
		if(navigator.platform=='Win32')
		{
			location='music_mp3_play.php?song_id='+all_song_id;
		}
		else
		{
			location='list://"'+all_song_path+'"';
		}
	}
	if(keycode==56)//星号查看歌词
	{
		document.getElementById('blink').innerHTML='<br>正在打开,请稍候...';
		window.setTimeout('end()',5000);
		location="music_mp3_lyric.php?mp3_id="+song_id_arr[select_album_flag][select_song_flag];
	}
	if(keycode==35)//End键,加入收藏
	{
		document.getElementById('blink').innerHTML='<br>正在打开,请稍候...';
		window.setTimeout('end()',5000);
		location="music_mp3_favorite.php?action=add&mp3_id="+song_id_arr[select_album_flag][select_song_flag];
	}
	if(keycode==48)//0键帮助
	{
		document.getElementById('blink').innerHTML='<br>正在打开,请稍候...';
		window.setTimeout('end()',5000);
		location="help.php?type1=user&type2=mp3";
	}
	if(keycode==36)//返回
	{
		document.getElementById('blink').innerHTML='<br>正在返回,请稍候...';
		var from='<?=$from?>';
		if(from=='listall')
		{
			location="music_singer_listall.php";
		}
		else
		{
			location="music_singer_song.php?type_label=<?=$type_label?>&type_id=<?=$type_id?>&offset=<?=$songOffset?>&singerOffset=<?=$singerOffset?>&singer_id=<?=$singer_id?>";
		}
	}
}    
document.onkeydown=keyDown
</script>
</head>

<body leftMargin=0 topMargin=0 background="image/music/music7_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="init()">
<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10></td>
	<td width=760><?include "top.php";?></td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 驴蕣詢婕?嵌色艢蓾 *************************************************-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	    <td width="25" height="22">&nbsp;</td>
		<td width="300">&nbsp;</td>
		<td width="420">&nbsp;</td>
		<td width="15">&nbsp;</td>
	</tr>
	<tr>
		<td height=58 colspan=4 valign=top><span class=style32w style="color:#ffcc00;margin-left:1em"><?=$singer_name?>&nbsp;(<?=$album_count?>个专辑,<?=$intRowCount?>首歌曲)</span>
		</td>
	</tr>
	<tr>
		<td height=40 colspan=4 valign=top align=right>
		<table border=0 width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td>&nbsp;</td>
			<td width=30 align=center><span class=style30w style="color:<?=$song_num_color?>" id=song_count></span></td>
			<td width=132>&nbsp;</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<?
		if($album_count==0)
		{
			?>
		<tr>
			<td height=30 class=style30w>暂时没有专辑</td><td></td>
		</tr>
			<?
		}
		else
		{
			for($i=0;$i<8;$i++)
			{
				?>
		<tr>
			<td id=<?=$i?>></td>
		</tr>
				<?
			}
		}
		?>
		<tr valign=bottom><td class=style30w id=blink><br>【0】键查看帮助</td></tr>
		</table>
		</td>
		<td valign=top>
		<table width="100%" border=0 cellpadding=0 cellspacing=0 rules=rows frame=void>
		<?
		for($i=10;$i<20;$i++)
		{
			?>
		<tr>
			<td id=<?=$i?> style="border-bottom:#000000 1px groove"></td>
		</tr>
			<?
		}
		?>
		</table>
		</td>
	</tr>
	</table>
	<!--*******************************************************************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="350" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%" align=center>
		</td>
	</tr>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('music_singer_listall.php');">返<br>回</td>
	</tr>
	<tr height="34%">
		<td height="34%" align=center>
		</td>
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