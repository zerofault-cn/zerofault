<?
/*
*ÒÆ³ýÖØ¸´µÄÎÄÕÂ
*/
$conn=mysql_pconnect('localhost','root','10y9c2U5');
$sql1="select id,url,count(id) as count from article group by url order by id desc limit 1000";
$result1=mysql_db_query('contribute',$sql1);
while($r=mysql_fetch_array($result1))
{
	$id=$r['id'];
	$url=$r['url'];
	$count=$r['count'];
	if($count>1)
	{
		$sql2="delete from article where id!=".$id." and url='".$url."'";
		if(mysql_db_query('contribute',$sql2))
		{
			echo $id.":".$count.":ok<br>\r\n";
		}
	}
	else
	{
		echo $id.":".$count.":<br>\r\n";
	}
	
}
?>