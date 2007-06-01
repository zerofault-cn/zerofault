<?php

define('IN_MATCH', true);

$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
$tpl = new Template($root_path."templates");

$tpl->set_filenames(array('body' => 'article.htm'));
$id=$_REQUEST['id'];
$sql="select * from article where id=".$id;
$result=$db->sql_query($sql);
$row=$db->sql_fetchrow($result);
$tpl->assign_vars(array(
	"TITLE" => $row['title'],
	"DATETIME"=>$row['datetime'],
	"CONTENT"=>format($row['content'])
	));
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>