<?
$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'header.htm'));
switch(basename($_SERVER["PHP_SELF"],'.php')) 
{
	case 'info':
		$tpl->assign_vars(array(
			"TITLE"=>'博客交友－详细资料',
		));
		break;
	case 'request':
		$tpl->assign_vars(array(
			"TITLE"=>'博客交友－择偶标准',
		));
		break;
	case 'comment':
		$tpl->assign_vars(array(
			"TITLE"=>'博客交友－留言',
		));
		break;
	case 'user_list':
		$tpl->assign_vars(array(
			"TITLE"=>'博客交友－用户列表',
		));
		break;
}
$tpl->pparse('body');
$tpl->destroy();
?>