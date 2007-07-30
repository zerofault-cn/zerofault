<?
include_once "session.php";
define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."profile.inc.php");

require_once($root_path."templates/admin/left.htm");//左边菜单

$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array('body' => 'user_list.htm'));

//一些参数
$testmail=0;//显示“发送测试邮件”的按钮
$pageitem=12;//每页显示个数
$passbtn_arr=array('通过审核','取消审核');

$page=$_REQUEST["page"];//页码

//搜索表单中的变量
$s_id=$_REQUEST["s_id"];
$s_blogname=$_REQUEST['s_blogname'];
$s_realname=$_REQUEST['s_realname'];
$s_area=$_REQUEST['s_area'];
$s_blogurl=$_REQUEST['s_blogurl'];
$s_city=$_REQUEST['s_city'];

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
//设置按照什么方式排序显示
if(''!=$_REQUEST['order'])
{
	$order=$_REQUEST['order'];
}
elseif(''!=$_SESSION['order'])
{
	$order=$_SESSION['order'];
}
else
{
	$order='id';//默认按id排序
}
if(!session_is_registered('order'))
{
	session_register('order');//存入变量供后面使用
}
$_SESSION['order']=$order;

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
	$old=0;//old为1时表示显示一周仍为通过审核的
}
if(!session_is_registered('old'))
{
	session_register('old');//存入变量供后面使用
}
$_SESSION['old']=$old;

if($s_area>0)
{
	$sqlext=" and area=".$s_area;
}
if(''!=$_REQUEST['submit'])//处理搜索
{
	$sql="select * from user_info where pass=".$s_pass.$sqlext." and (0";
	if(''!=$s_id)
	{
		$sql.=" or id=".$s_id;
	}
	if(''!=$s_blogname)
	{
		$sql.= " or binary blogname like '%".$s_blogname."%'";
	}
	if(''!=$s_blogurl)
	{
		$sql.= " or binary blogurl like '%".$s_blogurl."%'";
	}
	if(''!=$s_realname)
	{
		$sql.=" or realname like '%".$s_realname."%'";
	}
	if(''!=$s_city)
	{
		$sql.=" or address like '%".$s_city."%'";
	}
	$sql.=") order by ".$order." desc,id";
}
else
{
	if($old==1)
	{
		$sqlext.=" and addtime<".(time()-7*24*3600);
	}
	elseif($pass==0)
	{
		$sqlext.=" and addtime>=".(time()-7*24*3600);
	}
	$sql="select * from user_info where pass=".$s_pass.$sqlext." order by ".$order." desc,id desc";
}
echo $sql;
echo '<br>';
$result=$db->sql_query($sql);
$total=$db->sql_numrows($result);
pageft($total,$pageitem,"?submit=".$_REQUEST['submit']."&s_id=".$s_id."&s_blogname=".$s_blogname."&s_blogurl=".$s_blogurl."&s_realname=".$s_realname."&s_city=".$s_city."&s_area=".$s_area."&order=".$order);
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
	$id=$row["id"];
	$blogurl=$row['blogurl'];

	$tpl->assign_block_vars("list", array(
		"I" => $i,
		"ID" => $id,
		"AREA" => $row['area'],
		"REALNAME" => $row["realname"],
		"PHOTO" => '../photo/'.$row['area'].'/'.$row['photo'],
		"BLOGURL" => substr($blogurl,7),
		"ADDTIME" => date("y/m/d H:i",$row["addtime"]),
		"AREANAME" => $area_arr[$row['area']],
		"NETVOTE" => $row['netvote'],
		"SMSVOTE" => $row['allvote'],
		"COMM_COUNT" => $row['comm_count'],
		"PASSBTN" => $passbtn_arr[$row['pass']],//设置按钮文字
		"PASSBTNSTYLE" => $row['pass']?'display:none':'',//设置按钮显示与否
		"BGCOLOR" => $bgcolor,//设置行的背景色交替
		));
}
for($i=0;$i<sizeof($area_arr);$i++)
{
	$tpl->assign_block_vars('subnavi',array(
		"I"=>$i,
		"COLOR"=>($i==$s_area)?'#6699FF':'',
		"AREA"=>$area_arr[$i],
		"COUNT"=>$total
		));
}
$areaOption_str='';
for($i=0;$i<sizeof($area_arr);$i++)
{
	$areaOption_str .= '<option value='.$i;
	if($i==$s_area)
	{
		$areaOption_str .= ' selected';
	}
	$areaOption_str.= '>'.$area_arr[$i].'</option>';
}
$tpl->assign_vars(array(
	"AREAOPTION" => $areaOption_str,
	"S_PASS" => $s_pass,
	"BTNFUNC" => $is_admin?'':' disabled',//设置按钮可用否
	"DISPLAY" => $s_pass?'none':'',//设置“通过审核”按钮是否可见

	"COLOR20" => (0==$s_pass&&0==$old&&'id'==$order)?'#99CCFF':'',
	"COLOR21" => (1==$s_pass&&0==$old&&'id'==$order)?'#99CCFF':'',
	"COLOR22" => (1==$s_pass&&0==$old&&'smsvote'==$order)?'#99CCFF':'',
	"COLOR23" => (0==$s_pass&&1==$old&&'id'==$order)?'#99CCFF':'',
	"PAGE" => $pagenav
));

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>