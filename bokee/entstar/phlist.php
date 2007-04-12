<?
define('IN_MATCH', true);
$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."functions.php");

$cate_arr=array('','娱乐明星','体育明星','文化名人','网络红人','影视角色','草根博客','其他');
$curpage="phlist";
include_once("header.php");//公共头部

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'phlist.htm'));

$field=$_REQUEST["field"];
if(''==$field)
{
	$field='comm';
}
$i=$_REQUEST['i'];
if(''==$i)
{
	$i=1;
}
if(0!=$i)
{
	$sql_ext=" where category=".$i;
}
$pageitem=27;
$sql1="select id,realname,blogurl,".$field." as all_count,month_".$field." as month_count from user_info ".$sql_ext." order by all_count desc limit ".$pageitem;
assign_block_vars_by_sql("cat_comm_phlist1",$sql1,1);

$sql2="select id,realname,blogurl,".$field." as all_count,month_".$field." as month_count from user_info ".$sql_ext." order by all_count desc limit ".$pageitem.",".$pageitem;
assign_block_vars_by_sql("cat_comm_phlist2",$sql2,$pageitem+1);

for($i=0;$i<$pageitem;$i++)
{
	if($bg1!='#EAE9E9')
	{
		$bg1='#EAE9E9';
	}
	else
	{
		$bg1='#FFF';
	}
	if($bg2!='#FFF')
	{
		$bg2='#FFF';
	}
	else
	{
		$bg2='#EAE9E9';
	}
	$bg1_arr[]['bg']=$bg1;
	$bg2_arr[]['bg']=$bg2;
}
//assign_block_vars("cat_comm_phlist1",$bg1_arr);
//assign_block_vars("cat_comm_phlist2",$bg2_arr);

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();

include_once("footer.php")//公共页脚
?>