<?php  
header("Content-type: text/vnd.wap.wml; charset=gb2312"); 
?>

<wml>
<card>
<p>
��ӭ���ʺ���һɫ<br/>
������:<?=date("Y��m��d��")?>
<?
$week=array('0'=>'������','1'=>'����һ','2'=>'���ڶ�','3'=>'������','4'=>'������','5'=>'������','6'=>'������');
echo $week[date("w")];
?><br/>
����ʱ��:<?=date("H:i:s")?>
</p>

<p>
<a href='board/index.php?infotype=message'>������Ϣ</a><BR/>
<a href='board/index.php?infotype=tech'>��������</a><BR/>
<a href='board/index.php?infotype=feeling'>��������</a><BR/>
<a href='board/index.php?infotype=joke'>��ĬЦ��</a><BR/>
<a href='friend/index.php'>�ҵĵ绰��</a><br/>

<br/>��վ����:<br/>
<a href='http://wap.163.com'>wap.163.com</a><br/>
<a href='http://wap.sohu.com'>wap.sohu.com</a><br/>
<a href='http://wap.sina.com.cn'>wap.sina.com.cn</a><br/>
</p>
</card>
</wml>
