<?
$conn=mysql_pconnect('localhost','root','10y9c2U5');
$sql1="select * from article limit 0,50000";
$result1=mysql_db_query('contribute',$sql1);
while($r=mysql_fetch_array($result1))
{
	$id=$r['id'];
	$url=$r['url'];
	$sql2="select subjectType,number from subject where subjectLink='".$url."'";

	$result2=mysql_db_query('contributedb',$sql2);
	if($r2=mysql_fetch_array($result2))
	{
		$channel_id1=$r2['subjectType'];
		$vote=$r2['number'];
		
		$sql3="update article set channel_id1=".$channel_id1.",vote=vote+".$vote." where id=".$id;
		if($result3=mysql_db_query('contribute',$sql3))
		{
			echo $id.":".$channel_id1."\r\n<br>";
		}
		else
		{
			echo $sql3;
		}
		
	}
	if($r2=mysql_fetch_array($result2))
	{
		$channel_id2=$r2['subjectType'];
		$vote=$r2['number'];
		
		$sql3="update article set channel_id2=".$channel_id2.",vote=vote+".$vote." where id=".$id;
		if($result3=mysql_db_query('contribute',$sql3))
		{
			echo $id.":".$channel_id2."\r\n<br>";
		}
		else
		{
			echo $sql3;
		}
	}
	if($r2=mysql_fetch_array($result2))
	{
		$channel_id3=$r2['subjectType'];
		$vote=$r2['number'];
		
		$sql3="update article set channel_id3=".$channel_id3.",vote=vote+".$vote." where id=".$id;
		if($result3=mysql_db_query('contribute',$sql3))
		{
			echo $id.":".$channel_id3."\r\n<br>";
		}
		else
		{
			echo $sql3;
		}
	}
}
?>