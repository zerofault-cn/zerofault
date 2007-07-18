<?php
define('IN_MATCH', true);

$root_path = "./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");

$field=$_REQUEST['field'];

$sql="select * from user_info order by ".$field." desc,id desc limit 10";
$result=$db->sql_query($sql);
$i=1;
while($row=$db->sql_fetchrow($result))
{
	$count=('smsvote'!=$field)?$row[$field]:'<input type="button" value="ͶƱ" class="liubtn" onclick="window.open(\'http://nurse.bokee.com/nurse/smspoll.php?id='.$row['id'].'\',\'\',\'width=700,height=360,toolbar=no,status=no,scrollbars=auto,resizable=yes\')"/>';
	echo '<li cclass="top'.sprintf("%02d",$i++).'"><span class="lt"><a href="'.$row["blogurl"].'" target="_blank" title="'.$row["blogname"].'">'.$row["realname"].'</a></span><span class="lr">'.$count.'</span></li>';
}

$db->sql_close();
?>