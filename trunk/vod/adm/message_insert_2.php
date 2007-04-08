<?php
function ubb($str)
{
	$color=Array('red','blue','green');
	$str=eregi_replace('\[url\]([a-zA-Z0-9@:%_.~#-\?&]+)\[\/url\]','<a href=\\1>\\1</a>',$str);//url
	$str=eregi_replace('\[url=http://([a-zA-Z0-9@:%_.~#-\?&]+)\](.[a-zA-Z0-9@:%_.~#-\?&]+)\[\/url\]','<a href=\\1 target=_blank>\\2</a>',$str);
	$str=eregi_replace('\[url=([a-zA-Z0-9@:%_.~#-\?&]+)\](.[a-zA-Z0-9@:%_.~#-\?&]+)\[\/url\]','<a href=http://\\1 target=_blank>\\2</a>',$str);

	$str=eregi_replace('\[img\]([a-zA-Z0-9@:%_.~#-\?&]+)\[\/img\]','<img src=\\1>',$str);//img
	
	$str=eregi_replace('\[h([1-6])\](.+)\[\/h[1-6]\]','<h\\1>\\1</h\\1>',$str);//h1-6
	
	$str=eregi_replace('\[email\]([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})\[\/email\]','<a href=mailto:\\1>\\1</a>',$str);//email
	$str=eregi_replace('\[email=([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})\](.+)\[\/email\]','<a href=mailto:\\1>\\2</a>',$str);

	$str=eregi_replace('\[b\](.+)\[\/b]','<b>\\1</b>',$str);

	$str=eregi_replace('\[i\](.+)\[\/i]','<i>\\1</i>',$str);

	$str=eregi_replace('\[size=(.+)\](.+)\[\/size\]','<font size=\\1>\\2</font>',$str);

	$str=eregi_replace('\[color=(.+)\](.+)\[\/color\]','<font color=\\1>\\2</font>',$str);

	$str=eregi_replace('\[sub\](.+)\[\/sub]','<sub>\\1</sub>',$str);//上标

	$str=eregi_replace('\[sup\](.+)\[\/sup]','<sup>\\1</sup>',$str);//下标

	for($i=0;$i<=count($color);$i++)
		$str=eregi_replace('\['.$color[$i].'\](.+)\[\/'.$color[$i].'\]','<font color='.$color[$i].'>\\1</font>',$str);
	
	$str=preg_replace("/\[quote\](.+?)\[\/quote\]/is","<blockquote><font size='1' face='Courier New'>quote:</font><hr>\\1<hr></blockquote>",$str);

	$str=preg_replace("/\[code\](.+?)\[\/code\]/is","<blockquote><font size='1' face='Times New Roman'>code:</font><hr color='lightblue'><i>\\1</i><hr color='lightblue'></blockquote>",$str);

	$str=preg_replace("/\[sig\](.+?)\[\/sig\]/is","<div style='text-align:left;color:darkgreen;margin-left:5%'><br><br>----------------------------<br>\\1<br>----------------------------</div>",$str);

	return $str;
}
function format($msg)
{
	$msg=htmlspecialchars($msg);
	$msg=str_replace(" ","&nbsp;",$msg);
	$msg=ubb($msg);
//	$msg=addslashes($msg);
	$msg=str_replace("\r",' ',$msg);
	$msg=str_replace("\n",'<br>',$msg);
	return $msg;
}
//include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
$sql1="insert into admin_message(pid,user,title,info,time,ip) values('".$pid."','".$user."','".$title."','".format($info)."',now(),'".$_SERVER["REMOTE_ADDR"]."')";
if(mysql_query($sql1))
{
	if($pid)
	{
		?>
		<script>
		alert("回复成功!");
		window.location="index.php?content=message_info&id=<?=$pid?>";
		</script>
		<?
	}
	else
	{
		?>
		<script>
		alert("留言成功!");
		window.location="index.php?content=message_index";
		</script>
		<?
	}
}
else
{
	?>
	<script>
	alert("添加记录失败,请检查重试,或者报告管理员");
	window.history.go(-1);
	</script>
	<?
}
?>