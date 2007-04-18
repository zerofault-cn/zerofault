<?
$conn=mysql_pconnect('localhost','root','10y9c2U5');
$sql1="select * from subject limit 0,50000";
$result1=mysql_db_query('contributedb',$sql1);
$i=0;
while($r=mysql_fetch_array($result1))
{
	echo $i++."\n";
	$aid=$r['subjectID'];
	$blogLink=$r['blogLink'];
	if(ereg("(bokee.com)|(blogchina.com)",$blogLink))
	{
		$blogid=substr($blogLink,7,strpos($blogLink,'.')-7);
	}
	if(''==$blogid)
	{
		continue;
	}
	$blogname=$r['blogName'];
	$title=$r['subjectTitle'];
	$url=$r['subjectLink'];
	$addtime=$r['subjectTime'];
	$sql2="select id from article where url='".$url."'";
	$result2=mysql_db_query('contribute',$sql2);
	if(mysql_num_rows($result2)>0)
	{
		continue;
	}
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
		if(mysql_db_query('contribute',$sql4))
		{
			echo $author_id.':'.$aid."\r\n<br>";
		}
	}
}
?>