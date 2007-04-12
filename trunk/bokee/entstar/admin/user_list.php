<?
include_once "session.php";
define('IN_MATCH', true);

$root_path ="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");

include_once("left.php");//左边菜单

$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array('body' => 'user_list.htm'));

//一些参数
$pageitem=10;//每页显示个数
$passbtn_arr=array('通过审核','取消审核');

//URL接受参数
$page=$_REQUEST["page"];//页码

//搜索表单中的变量
$s_id=$_REQUEST["s_id"];
$s_realname=$_REQUEST['s_realname'];
$s_blogurl=$_REQUEST['s_blogurl'];
$s_groupurl=$_REQUEST['s_groupurl'];
$s_category=$_REQUEST['s_category'];

//设置显示审核用户和未审核用户
if(''!=$_REQUEST['s_pass'])
{
	$s_pass=$_REQUEST['s_pass'];
}
elseif(''!=$_SESSION['s_pass'])
{
	$s_pass=$_SESSION['s_pass'];
}
else
{
	$s_pass=0;//默认显示未审核
}
if(!session_is_registered('s_pass'))
{
	session_register('s_pass');//存入变量供后面使用
}
$_SESSION['s_pass']=$s_pass;

//设置显示黑名单
if(''!=$_REQUEST['old'])
{
	$old=$_REQUEST['old'];
}
elseif(''!=$_SESSION['old'])
{
	$old=$_SESSION['old'];
}
else
{
	$old=0;//默认按id排序
}
if(!session_is_registered('old'))
{
	session_register('old');//存入变量供后面使用
}
$_SESSION['old']=$old;

if($s_category>0)//系统管理员设置的查询范围
{
	$sqlext=" and category=".$s_category;
}
if(''!=$_REQUEST['submit'])//处理搜索
{
	$sql="select * from mm_info where pass=".$s_pass.$sqlext." and (0";
	if(''!=$s_id)
	{
		$sql.=" or id=".$s_id;
	}
	if(''!=$s_blogname)
	{
		$sql.= " or binary blogname like '%".$s_blogname."%'";
	}
	if(''!=$s_realname)
	{
		$sql.=" or realname like '%".$s_realname."%'";
	}
	if(''!=$s_city)
	{
		$sql.=" or address like '%".$s_city."%'";
	}
	if(strlen($s_area)==1 && 0==$s_area)
	{
		$sql.=" or 1";
	}
	elseif($s_area>0)
	{
		$sql.=" or area=".$s_area;
	}
	$sql.=") order by ".$order." desc,id";
}
else
{
	if($s_pass==0 && $old==1)
	{
		$sqlext.=" and addtime<=".(time()-7*24*3600);//一周之前注册的且未通过审核的放入黑名单
	}
	elseif($s_pass==0 && $old==0)
	{
		$sqlext.=" and addtime>".(time()-7*24*3600);
	}
	$sql="select * from user_info where pass=".$s_pass.$sqlext." order by id desc";
}
//echo $sql;
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?submit=".$_REQUEST['submit']."&s_id=".$s_id."&s_realname=".$s_realname."&s_blogurl=".$s_blogurl."&s_groupurl=".$s_groupurl);
$result=$db->sql_query($sql." limit ".$offset.",".$pageitem);

$i=($page-1)*$pageitem;//序号
while($row=$db->sql_fetchrow($result))
{
	$i++;
	if($bgcolor!='#d0d0d0')
	{
		$bgcolor='#d0d0d0';
	}
	else
	{
		$bgcolor='#f0f0f0';
	}
	
	$tpl->assign_block_vars("list", array(
		"I" => $i,
		"ID" => $row["id"],
		"REALNAME" => $row["realname"],
		"PHOTO" => '../photo/'.$row['photo'],
		"BLOGURL" => substr($row["blogurl"],7),
		"GROUPURL" => substr($row["groupurl"],7),
		"CATEGORY" =>$row['category'],
		"CATESTR" => $cate_arr[$row['category']],
		"ADDTIME" => date("y/m/d H:i",$row["addtime"]),
		"COMM" => $row['comm'],
		"BGCOLOR" => $bgcolor,//设置行的背景色交替
		"PASSBTN" => $passbtn_arr[$row['pass']],//设置按钮文字
		"CURPAGE" => $page
		));
}

$tpl->assign_vars(array(
	"S_PASS" => $s_pass,
	"COLOR10" => (0==$s_category)?'#6699FF':'',
	"COUNT10" => (0==$s_category)?'#99ccff':'#6699ff',
	"COLOR11" => (1==$s_category)?'#6699FF':'',
	"COUNT11" => (1==$s_category)?'#99ccff':'#6699ff',
	"COLOR12" => (2==$s_category)?'#6699FF':'',
	"COUNT12" => (2==$s_category)?'#99ccff':'#6699ff',
	"COLOR13" => (3==$s_category)?'#6699FF':'',
	"COUNT13" => (3==$s_category)?'#99ccff':'#6699ff',
	"COLOR14" => (4==$s_category)?'#6699FF':'',
	"COUNT14" => (4==$s_category)?'#99ccff':'#6699ff',
	"COLOR15" => (5==$s_category)?'#6699FF':'',
	"COUNT15" => (5==$s_category)?'#99ccff':'#6699ff',
	"COLOR16" => (6==$s_category)?'#6699FF':'',
	"COUNT16" => (6==$s_category)?'#99ccff':'#6699ff',
	"COLOR17" => (7==$s_category)?'#6699FF':'',
	"COUNT17" => (7==$s_category)?'#99ccff':'#6699ff',
	"COLOR20" => (0==$s_pass && 1!=$old)?'#99CCFF':'',
	"COLOR21" => (1==$s_pass && 'id'==$order)?'#99CCFF':'',
	"COLOR22" => ('allvote'==$order)?'#99CCFF':'',
	"COLOR23" => (1==$old)?'#99CCFF':'',
	"PASSALLBTNSTYLE" => (1==$s_pass)?'display:none':'',
	"COUNT" => '('.$total.')',
	"PAGE" => $pagenav
));


$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>