<?
$conn=mysql_pconnect('localhost','root','10y9c2U5');
$sql1="select * from article limit 0,50000";
$result1=mysql_db_query('contributedb',$sql1);
while($r=mysql_fetch_array($result1))
{
	$blogLink=$r['blogLink'];
	$blogid=substr($blogLink,7,strpos($blogLink,'.')-7);
	if(''==$blogid)
	{
		continue;
	}
	$blogname=$r['blogName'];
	$email=$r['contactEmail'];
	$title=$r['articleTitle'];
	$url=$r['articleLink'];
	$addtime=$r['articleTime'];
	$sql2="select id from author where blogid='".$blogid."'";
	$result2=mysql_db_query('contribute',$sql2);
	if(mysql_num_rows($result2)>0)
	{
		$author_id=mysql_result($result2,0,0);
	}
	else
	{
		$sql3="insert into author set blogid='".$blogid."',blogname='".$blogname."',email='".$email."'";
		$result3=mysql_db_query('contribute',$sql3);
		$author_id=mysql_insert_id();
	}
	if(''!=$author_id)
	{
		$sql4="insert into article set author_id=".$author_id.",title='".$title."',url='".$url."',addtime=".$addtime;
		mysql_db_query('contribute',$sql4);
	}
}
?>