<?
$conn=mysql_pconnect('localhost','root','10y9c2U5');
$sql1="select author_id,count(author_id) as count from article group by author_id";
$result1=mysql_db_query('contribute',$sql1);
while($r=mysql_fetch_array($result1))
{
	$author_id=$r['author_id'];
	$count=$r['count'];
	$sql2="update author set article_count=".$count.",month_article=".$count." where id='".$author_id."'";
	echo $result2=mysql_db_query('contribute',$sql2);
	
}
?>