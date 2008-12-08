<?php
mysql_connect('localhost', 'root', '');
mysql_select_db('cms_sports');
$sql_count = "select count(*) as num from rss_entry_attach";
$rs_count = mysql_query($sql_count);
$row = mysql_fetch_array($rs_count);
$count = $row['num'];
for($i=0;$i<$count;$i++)
{
	echo "item:" . $i . "\n";
	$sql = "select id, entry_id from rss_entry_attach order by id desc limit $i, 1";
	$rs = mysql_query($sql);
	if(mysql_num_rows($rs)==0)
	{
		exit;
	}
	$row = mysql_fetch_array($rs);
	$entry_id = $row['entry_id'];
	$sql1 = "select id from rss_entry_attach where entry_id=" . $row['entry_id'] . " and id<>" . $row['id'];
	$rs1 = mysql_query($sql1);
	if(mysql_num_rows($rs1)>0)
	{
		echo "--------------found entry: " .  $row['id'] . "\n";
		while ($row1 = mysql_fetch_array($rs1)) {
			$sql2 = "delete from rel_article_subject where article_id=" . $row1['id'];
			mysql_query($sql2);
			$sql3 = "delete from rss_entry_attach where id=" . $row1['id'];
			mysql_query($sql3);
			echo "--------------delete entry: " .  $row1['id'] . "\n";
		}
	}
}


?>
