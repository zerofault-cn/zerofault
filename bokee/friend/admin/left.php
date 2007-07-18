<?
$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array('body' => 'left.htm'));

$tpl->pparse('body');
$tpl->destroy();
?>