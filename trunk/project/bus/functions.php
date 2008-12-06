<?php
function checkvar($input)
{
	echo "\n<hr><pre>\n";
	print_r($input);
	echo "\n</pre><hr>\n";
}

function getSid($name) {
	global $db,$site_table;
	$sql1="select id from ".$site_table." where binary name='".$name."'";
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1)>0)
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		return 0;
	}
}
function getSname($sid) {
	global $db,$site_table;
	$sql1="select name from ".$site_table." where id=".$sid;
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1)>0)
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		return 0;
	}
}
function getLname($lid) {
	global $db,$line_table;
	$sql1="select name from ".$line_table." where id=".$lid;
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1)>0)
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		return 0;
	}
}
?>