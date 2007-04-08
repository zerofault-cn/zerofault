<?php

//ʹ��URL����,�Զ�ת����Ӧ������
function enable_urls($str)
{
	//�Զ�ת��www��ͷ������
	$str=ereg_replace("(www.[a-zA-Z0-9@:%_.~#-\?&]+)","<a href='LINKttp://\\1' target='_blank'>\\1</a>",$str);
	
	//ת��http://��ͷ��ftp://��ͷ������
	$str=ereg_replace("(((f|ht){1}tp://)[a-zA-Z0-9@:%_.~#-\?&]+)","<a href='\\1' target='_blank'>\\1</a>",$str);
	$str=str_replace('LINKttp://','http://',$str);

	//ת���ʼ���ַ
	$str=ereg_replace("([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","<a href='mailto:\\1'>\\1</a>",$str);
	return $str;
}

//Ϊ��ʹ��UBB����,���ַ���������
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

	$str=eregi_replace('\[sub\](.+)\[\/sub]','<sub>\\1</sub>',$str);//�ϱ�

	$str=eregi_replace('\[sup\](.+)\[\/sup]','<sup>\\1</sup>',$str);//�±�

	for($i=0;$i<=count($color);$i++)
		$str=eregi_replace('\['.$color[$i].'\](.+)\[\/'.$color[$i].'\]','<font color='.$color[$i].'>\\1</font>',$str);
	
	$str=preg_replace("/\[quote\](.+?)\[\/quote\]/is","<blockquote><font size='1' face='Courier New'>quote:</font><hr>\\1<hr></blockquote>",$str);

	$str=preg_replace("/\[code\](.+?)\[\/code\]/is","<blockquote><font size='1' face='Times New Roman'>code:</font><hr color='lightblue'><i>\\1</i><hr color='lightblue'></blockquote>",$str);

	$str=preg_replace("/\[sig\](.+?)\[\/sig\]/is","<div style='text-align:left;color:darkgreen;margin-left:5%'><br><br>----------------------------<br>\\1<br>----------------------------</div>",$str);

	return $str;
}

function str($msg,$html=false,$ubb=false,$php=false)
{
	//$msg=stripslashes($msg);//ȥ���ַ����еķ�б��"/"
	if($php)//���֧��php����
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


[h6]h6�����С[/h6]

[email]zerofault@163.com[/email]

[b]B������[/b]

[i]Iб����[/i]


[size=8]�����СΪ8[/size]

[color=red]red��ɫ[/color]

��������[sub]sub�±�[/sub]
��������[sup]sup�ϱ�[/sup]

[quote]quote����[/quote]

[code]code����[/code]

[sig]sig���[/sig]
*/
?>
