<?php

//使用URL功能,自动转化相应的链接
function enable_urls($str)
{
	//自动转化www开头的链接
	$str=ereg_replace("(www.[a-zA-Z0-9@:%_.~#-\?&]+)","<a href='LINKttp://\\1' target='_blank'>\\1</a>",$str);
	
	//转化http://开头和ftp://开头的链接
	$str=ereg_replace("(((f|ht){1}tp://)[a-zA-Z0-9@:%_.~#-\?&]+)","<a href='\\1' target='_blank'>\\1</a>",$str);
	$str=str_replace('LINKttp://','http://',$str);

	//转换邮件地址
	$str=ereg_replace("([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","<a href='mailto:\\1'>\\1</a>",$str);
	return $str;
}

//为了使用UBB代码,对字符串作处理
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

function str($msg,$html=false,$ubb=false,$php=false)
{
	//$msg=stripslashes($msg);//去掉字符串中的反斜线"/"
	if($php)//如果支持php代码
	{
		ob_start();
		highlight_string($msg);
		$msg=ob_get_contents();
		ob_end_clean();
		$msg=addslashes($msg);
		$msg=str_replace("\r",' ',$msg);
		$msg=str_replace("\n",'<br>',$msg);
	}
	if($ubb)
	{
		$msg=htmlspecialchars($msg);
		$msg=str_replace(" ","&nbsp;",$msg);
		$msg=ubb($msg);
		$msg=addslashes($msg);
		$msg=str_replace("\r",' ',$msg);
		$msg=str_replace("\n",'<br>',$msg);
	}
	if($html)
	{
		$msg=addslashes($msg);
		
	}
	return $msg;
}
/*
[url]http://211.83.118.100[/url]

[img]http://211.83.118.100/pictures/pictures/54.gif[/img]


[h6]h6字体大小[/h6]

[email]zerofault@163.com[/email]

[b]B初体字[/b]

[i]I斜体字[/i]


[size=8]字体大小为8[/size]

[color=red]red红色[/color]

正常字体[sub]sub下标[/sub]
正常字体[sup]sup上标[/sup]

[quote]quote引用[/quote]

[code]code代码[/code]

[sig]sig标记[/sig]
*/
?>
