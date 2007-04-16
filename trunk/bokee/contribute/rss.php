<?php
header("Content-type: text/xml");
define('IN_MATCH', true);
$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."functions.php");

$id=$_REQUEST['id'];
if($id>0)
{
	$sql="select * from article where channel_id1=".$id." or channel_id2=".$id." or channel_id3=".$id." order by id desc limit 100";
}
else
{
	$sql="select * from article order by id desc limit 100";
}
echo $_xml ='<?xml version="1.0" encoding="gb2312"?><rss version="2.0">
     <channel>
        <title>博客投稿器</title>
        <link></link>
        <language>zh-cn</language>
        <generator>WWW.BOKEE.COM</generator>
        <copyright>Copyright 2002 - 2006 BOKEE.COM Inc. All Rights Reserved</copyright>
';

$result=$db->sql_query($sql);
while($row=$db->sql_fetchrow($result))
{
     echo  $xml_resource='
<item>
  <link><![CDATA['.$row["url"].']]></link>
  <title><![CDATA['.$row["title"].']]></title>
  <pubdate>'.date('Y-m-d H:i:s',$row["addime"]).'</pubdate>
  <author><![CDATA['.getField($row["author_id"],"blogname","author").']]></author>
  <commentnum></commentnum>
</item>
';
}  
echo '
</channel>
</rss>
';

?>
