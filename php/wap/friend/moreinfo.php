<?php  
header("Content-type: text/vnd.wap.wml; charset=gb2312"); 
?>
<wml>
<card>
<p>
<?php
$db_conn=mysql_connect("localhost","root","");
mysql_select_db("personal");
$query1="select * from friend where id=$id";
$result1=mysql_query($query1);
$name=mysql_result($result1,0,'name');
$tele=mysql_result($result1,0,'tele');
$birthday=mysql_result($result1,0,'birthday');
$qq=mysql_result($result1,0,'qq');
$email=mysql_result($result1,0,'email');
$extend=mysql_result($result1,0,'extend');
$extend=str_replace('&quot;','\'',$extend);
$extend=htmlspecialchars($extend);
?>
姓名:<?=$name?><br/>
联系方式:<?=$tele?><br/>
生日:<?=$birthday?><br/>
QQ:<?=$qq?><br/>
E_Mail:<?=$email?><br/>
其他信息:<?=$extend?><br/>
</p>
<p>
<a href='index.php'>返回</a>&lt;------------
</p>
</card>
</wml> 