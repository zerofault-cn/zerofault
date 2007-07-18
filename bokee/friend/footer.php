<?
$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'footer.htm'));
$tpl->pparse('body');
$tpl->destroy();
?>