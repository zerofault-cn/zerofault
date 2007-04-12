<?
define('IN_MATCH', true);
$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."functions.php");
$curpage='index';
include_once("header.php");//公共头部

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'index.htm'));
//第一屏左侧留言总排行
$sql1="select id,realname,blogurl,comm from user_info where pass=1 order by comm desc limit 22";
assign_block_vars_by_sql("comm_phlist", $sql1);

//第一屏中最热门的明星
$sql2="select id,realname,blogurl,groupurl,photo,flower,egg,(flower+egg) as count from user_info where pass=1 order by count desc limit 8";
assign_block_vars_by_sql("hot_user_list", $sql2);


//第一屏中网络留言
$sql3="select u.realname,c.id,c.user_id,c.username,LEFT(c.content,50) as content,FROM_UNIXTIME(c.addtime,'%m-%d %h:%i') as time from user_info u,comment c where u.pass=1 and u.id=c.user_id order by c.id desc limit 5";
assign_block_vars_by_sql("new_comm_list", $sql3);

//第一屏右侧鲜花月排行
$sql4="select id,realname,month_flower from user_info where pass=1 order by month_flower desc limit 8";
assign_block_vars_by_sql("month_flower_phlist", $sql4,1);


//第一屏右侧鸡蛋月排行
$sql5="select id,realname,month_egg from user_info where pass=1 order by month_egg desc limit 8";
assign_block_vars_by_sql("month_egg_phlist", $sql5,1);

for($j=1;$j<=7;$j++)
{
	//各类别左侧的月留言排行
	$sql1="select id,realname,blogurl,month_comm as comm from user_info where pass=1 and category=".$j." order by month_comm desc limit 15";
	assign_block_vars_by_sql("cat".$j."_month_comm_phlist",$sql1);
	//各类别中间的热门列表
	$sql2="select id,realname,blogurl,groupurl,photo,flower,egg,(flower+egg) as count from user_info where pass=1 and category=".$j." order by count desc limit 8";
	assign_block_vars_by_sql("cat".$j."_hot_user_list",$sql2);
	//各类别右侧的鲜花排行列表
	$sql3="select id,realname,month_flower from user_info where pass=1 and category=".$j." order by month_flower desc limit 7";
	assign_block_vars_by_sql("cat".$j."_month_flower_phlist", $sql3,1);
	//各类别右侧的鸡蛋排行列表
	$sql4="select id,realname,month_egg from user_info where pass=1 and category=".$j." order by month_egg desc limit 7";
	assign_block_vars_by_sql("cat".$j."_month_egg_phlist", $sql4,1);
}

//第九屏最新加入明星列表
$sql9="select id,realname,blogurl,groupurl,photo,flower,egg from user_info where pass=1 order by id desc limit 14";
assign_block_vars_by_sql("new_user_list", $sql9);


$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();

include_once("footer.php")//公共页脚
?>