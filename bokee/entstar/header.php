<?
$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'header.htm'));
$title_arr=array(
	"index"=>'���ǲ�����ҳ������Ƶ����ҳ��������-Bokee.com-���ҵ�����',
	"category"=>'���ǲ��ͷ��࣭����Ƶ����ҳ��������-Bokee.com-���ҵ�����',
	"comment"=>'���ǲ������ԣ�����Ƶ����ҳ��������-Bokee.com-���ҵ�����',
	"phlist"=>'���ǲ������У�����Ƶ����ҳ��������-Bokee.com-���ҵ�����',
	"tuijian"=>'�Ƽ����ǲ��ͣ�����Ƶ����ҳ��������-Bokee.com-���ҵ�����');
$tpl->assign_vars(array("TITLE" => $title_arr[$curpage]));

$tpl->pparse('body');
$tpl->destroy();
?>