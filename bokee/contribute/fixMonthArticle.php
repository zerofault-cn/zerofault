<?
/*
*修正作者每月文章数,此程序每天执行一次
*/
$conn=mysql_pconnect('localhost','root','10y9c2U5');
$sql0="update author set month_article=0";
mysql_db_query('contribute',$sql0);
$sql1="select author_id,count(id) as count from article where addtime>(UNIX_TIMESTAMP()-30*86400) group by author_id";
$result1=mysql_db_query('contribute',$sql1);
while($r=mysql_fetch_array($result1))
{
	$author_id=$r['author_id'];
	$count=$r['count'];
	$sql2="update author set month_article=".$count." where id='".$author_id."'";
	if(mysql_db_query('contribute',$sql2))
	{
		echo $author_id.":".$count."\r\n<br>";
	}
	else
	{
		echo $sql2;
	}
}
?>