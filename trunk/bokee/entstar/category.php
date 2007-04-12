<?
define('IN_MATCH', true);
$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."functions.php");

$cate_arr=array('','娱乐明星','体育明星','文化名人','网络红人','影视角色','草根博客','其他','new'=>'最新加入明星');
$curpage="category";
include_once("header.php");//公共头部

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'category.htm'));

$page=$_REQUEST["page"];
$i=$_REQUEST['i'];
if(''==$i)
{
	$i=1;
}
$pageitem=15;
if($i=='new')
{
	$sql="select id,realname,blogurl,groupurl,photo,flower,egg from user_info order by id desc";
}
else
{
	$sql="select id,realname,blogurl,groupurl,photo,flower,egg from user_info where category=".$i." order by id desc";
}
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?i=".$i);
assign_block_vars_by_sql("cat_user_list",$sql." limit ".$offset.",".$pageitem);

$tpl->assign_vars(array(
	"CAPTION" =>$cate_arr[$i],
	"PAGE" => $pagenav
));

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();

include_once("footer.php")//公共页脚
?>