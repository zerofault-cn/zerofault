<?
/*
*пч╦╢ндубurl
*/
$conn=mysql_pconnect('localhost','root','10y9c2U5');
$sql1="select * from article where url like 'http://http://%'";
$result1=mysql_db_query('contribute',$sql1);
while($r=mysql_fetch_array($result1))
{
	$id=$r['id'];
	$url=trim($r['url']);
	if(eregi('.bokee.com',$url))
	{
		$url=str_replace('http://http://','http://',$url);
	}
	$sql3="update article set url='".$url."' where id=".$id;
	if($result3=mysql_db_query('contribute',$sql3))
	{
		echo ($i++).'|'.$id."|".$url."\n<br>";
	}
	else
	{
		echo $sql3;
	}
}
?>