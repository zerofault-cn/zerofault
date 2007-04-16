<?
$conn=mysql_pconnect('localhost','root','10y9c2U5');
$sql1="select id from channel";
$result1=mysql_db_query('contribute',$sql1);
while($r=mysql_fetch_array($result1))
{
	$id=$r['id'];
	$sql2="select count(id) as count from article where channel_id1=".$id." or channel_id2=".$id." or channel_id3=".$id;

	$result2=mysql_db_query('contribute',$sql2);
	$count=mysql_result($result2,0,0);
	$sql3="update channel set article_count=".$count." where id=".$id;
	if(mysql_db_query('contribute',$sql3))
	{
		echo $id.":".$count."\r\n<br>";
	}

}

?>