<?php
$fp=fopen('data6.csv','w');
mysql_connect('localhost','root','');
mysql_select_db('test');
mysql_query("set names utf8");
echo $sql="select l.title,l.url,l.descr,t.name from favorites_link l,favorites_link_tag lt,favorites_tag t where l.id=lt.link_id and t.id=lt.tag_id and l.id>=369 order by l.id";
$result=mysql_query($sql);
while($r=mysql_fetch_row($result))
{
	$title=$r[0];
	$url=$r[1];
	if(substr($url,0,4)!='http')
	{
		$url='http://www.favorites.cn'.$url;
	}
	$descr=$r[2];
	$descr=str_replace('<br />',"\n",$descr);
	$tag=$r[3];
	fwrite($fp,'"'.$title.'","'.$url.'","'.$descr.'","'.$tag."\"\n");
}
fclose($fp);
mysql_close();
?>