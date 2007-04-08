<?php

$root_path = "./";

include_once($root_path."common.php");

$tpl = new Template($root_path."templates");

$tpl->set_filenames(array(
			'header' => 'index_header.htm')
		);
$tpl->pparse('header');		

?>
