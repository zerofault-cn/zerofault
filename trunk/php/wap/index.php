<?php  
header("Content-type: text/vnd.wap.wml; charset=gb2312"); 
?>

<wml>
<card>
<p>
欢迎访问海天一色<br/>
今天是:<?=date("Y年m月d日")?>
<?
$week=array('0'=>'星期日','1'=>'星期一','2'=>'星期二','3'=>'星期三','4'=>'星期四','5'=>'星期五','6'=>'星期六');
echo $week[date("w")];
?><br/>
现在时间:<?=date("H:i:s")?>
</p>

<p>
<a href='board/index.php?infotype=message'>最新信息</a><BR/>
<a href='board/index.php?infotype=tech'>技术文章</a><BR/>
<a href='board/index.php?infotype=feeling'>人生随想</a><BR/>
<a href='board/index.php?infotype=joke'>幽默笑话</a><BR/>
<a href='friend/index.php'>我的电话薄</a><br/>

<br/>网站链接:<br/>
<a href='http://wap.163.com'>wap.163.com</a><br/>
<a href='http://wap.sohu.com'>wap.sohu.com</a><br/>
<a href='http://wap.sina.com.cn'>wap.sina.com.cn</a><br/>
</p>
</card>
</wml>
