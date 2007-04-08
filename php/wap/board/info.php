<?php  
header("Content-type: text/vnd.wap.wml; charset=gb2312"); 
?>
<wml>
<card>
<p>
<?php
$id=$_REQUEST['id'];
$i=$_REQUEST['i'];
$infotype=$_REQUEST['infotype'];

$db_conn=mysql_connect("localhost","root","");
mysql_select_db("phpbbs");
$query1="select info from board where id=$id";
$result1=mysql_query($query1);
$info=mysql_result($result1,0,"info");
$info=str_replace('&quot;','\'',$info);
$info=htmlspecialchars($info);
$info=str_replace('&lt;br&gt;','<br/>',$info);
$info=str_replace('&lt;br /&gt;','<br/>',$info);
$info=str_replace('&amp;nbsp;',' ',$info);
$info=str_replace('&lt;','<',$info);
$info=str_replace('&gt;','>',$info);
$len=strlen($info);
$page=ceil($len/1200);
if($i=='')
	$i=0;
$info=substr($info,$i,1200);
echo $info;
$i+=1140;
if($i<$len)
	echo " <p>------------&gt;<a href='$PHP_SELF?i=$i&amp;id=$id&amp;infotype=$infotype'>ÏÂÒ³</a></p> ";
?>
</p>
<p>
<a href='index.php?infotype=<?=$infotype?>'>·µ»Ø</a>&lt;------------
</p>
</card>
</wml> 