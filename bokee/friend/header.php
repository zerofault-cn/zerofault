<?
$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'header.htm'));
switch(basename($_SERVER["PHP_SELF"],'.php')) 
{
	case 'info':
		$tpl->assign_vars(array(
			"TITLE"=>'���ͽ��ѣ���ϸ����',
		));
		break;
	case 'request':
		$tpl->assign_vars(array(
			"TITLE"=>'���ͽ��ѣ���ż��׼',
		));
		break;
	case 'comment':
		$tpl->assign_vars(array(
			"TITLE"=>'���ͽ��ѣ�����',
		));
		break;
	case 'user_list':
		$tpl->assign_vars(array(
			"TITLE"=>'���ͽ��ѣ��û��б�',
		));
		break;
}
$tpl->pparse('body');
$tpl->destroy();
?>