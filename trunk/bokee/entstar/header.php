<?
$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'header.htm'));
$title_arr=array(
	"index"=>'明星博客首页－娱乐频道首页－博客网-Bokee.com-你我的网络',
	"category"=>'明星博客分类－娱乐频道首页－博客网-Bokee.com-你我的网络',
	"comment"=>'明星博客留言－娱乐频道首页－博客网-Bokee.com-你我的网络',
	"phlist"=>'明星博客排行－娱乐频道首页－博客网-Bokee.com-你我的网络',
	"tuijian"=>'推荐明星博客－娱乐频道首页－博客网-Bokee.com-你我的网络');
$tpl->assign_vars(array("TITLE" => $title_arr[$curpage]));

$tpl->pparse('body');
$tpl->destroy();
?>