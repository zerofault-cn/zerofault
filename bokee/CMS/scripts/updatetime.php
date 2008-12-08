<?php
mysql_connect('localhost', 'root', '');
mysql_select_db('cms_sports');
$sql = "select * from rel_article_subject where category=1 order by id desc";
$rs = mysql_query($sql);
while($row = mysql_fetch_array($rs))
{
	$sql = "select * from rss_entry_attach where id=" . $row['article_id'];
	$rs1 = mysql_query($sql);
	$num = mysql_num_rows($rs1);
	if($num>0)
	{
		$row1 = mysql_fetch_array($rs1);
		$time = str_replace("-", "", $row1['datetime']);
		$time = str_replace(":", "", $time);
		$time = str_replace(" ", "", $time);
		$sql1 = "update rel_article_subject set datetime='$time' where id=" . $row['id'];
		if(mysql_query($sql1))
		echo $row['article_id'] . ": " . $row1['datetime'] . "\n";
		else
		echo "wrong " . $row['article_id'] . "\n";
	}
}

?>
