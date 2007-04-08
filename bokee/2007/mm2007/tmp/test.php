<?php
$str=$_REQUEST['str'];
mysql_connect('localhost','root','10y9c2U5');
mysql_select_db('test');
if(mysql_query("insert into test set str='".mb_convert_encoding($str,'gbk','utf-8,gbk,gb2312')."'"))
echo 'ok';
?>