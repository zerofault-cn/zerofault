<?php
	$connid=mysql_connect('211.152.20.34','root','10y9c2U5');
	mysql_select_db('cms',$connid);
	
	if(!isset($_REQUEST["channel"]))
	{
		die("地址错误,不能访问!");
	}
	else 
	{
		$channel = $_REQUEST["channel"];
		$sql = "select dir_name from channel where id = ".$channel;
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$dirName = $row["dir_name"];
		$dbName = "cms_".$dirName;	
		$link2 = mysql_select_db($dbName,$connid);	
	}

	if(!isset($_REQUEST["time"]))
	{
		$time = 30;
	}
	else
	{
		$time = $_REQUEST["time"];
	}
	if(!isset($_REQUEST["limit"]))
	{
		$limit = 12;
	}
	else
	{
		$limit = $_REQUEST["limit"];
	}	
	
	$expireTime = date('YmdHis', time() - $time * 86400);
	
	$stat_sql = "select count(a.author) as count, a.author, a.remote_url from article a, rel_article_subject b ".
		"where a.author != '' and a.id = b.article_id and category = 0 and updatetime > '".$expireTime.
		"' group by a.author order by count desc limit ".$limit;
	$stat_result = mysql_query($stat_sql);	

	while($row = mysql_fetch_array($stat_result))
	{
	$export  .= "<li><span>".$row["count"]."篇</span>·<a href='".$row["remote_url"]."'>".$row["author"]."</a></li>";
	}
	echo $export;


?>