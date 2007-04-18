<?
include_once "session.php";
define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");

include_once("left.php");//左边菜单

$tpl = new Template($root_path."templates/admin");
$tpl->set_filenames(array('body' => 'user_list.htm'));

//一些参数
$testmail=0;//显示“发送测试邮件”的按钮
$pageitem=10;//每页显示个数
$passbtn_arr=array('通过审核','取消审核');
$area_arr=array('','中部','南部','北部');

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
	$s_pass=2;//默认显示未审核
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
	$old=0;//默认按id排序
}
if(!session_is_registered('old'))
{
	session_register('old');//存入变量供后面使用
}
$_SESSION['old']=$old;

//设置分赛区管理员查询数据的范围
if($_SESSION['admin_area']==1 || $_SESSION['admin_area']==2 || $_SESSION['admin_area']==3)
{
	$sqlext=" and area=".$_SESSION['admin_area'];
	$s_area=$_SESSION['admin_area'];
}
elseif($s_area>0)//系统管理员设置的查询范围
{
	$sqlext=" and area=".$s_area;
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
	if(0==$s_pass)
	{
		$sqlext.=" and addtime>".(time()-7*24*3600);
	}
	else
	{
		$sql="select * from mm_info where pass=".$s_pass.$sqlext." order by ".$order." desc,id desc";
	}
}
//echo $sql;
//echo '<br>';
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
	$bokeeurl=substr($blogurl,7);
	if(strpos($bokeeurl,'/')>0)
	{
		$bokeeurl=substr($bokeeurl,0,strpos($bokeeurl,'/'));
	}
	$bobo_flag=$row['bobo_flag'];
	$boboimg='http://my.bobo.com.cn/bokee/changepic.php?userid='.$id;
	$viewurl='http://my.bobo.com.cn/bokee/zhong.php?flag=view&userid='.$id.'&bokeeURL='.$bokeeurl;

	$tpl->assign_block_vars("list", array(
		"I" => $i,
		"ID" => $id,
		"AREA" => $row['area'],
		"REALNAME" => $row["realname"],
		"PHOTO" => '../photo/'.$row['area'].'/'.$row['photo'],
		"BLOGURL" => $bokeeurl,
		"TIME" => date("y/m/d H:i",$row["addtime"]),
		"AREANAME" => $area_arr[$row['area']],
		"HBUN"=>$row['hbun_vote'],
		"HBTE"=>$row['hbte_vote'],
		"HBIVR"=>$row['hbivr_vote'],
		"NETVOTE" => $row['netvote'],
		"SMSVOTE" => $row['smsvote'],
		"ALLVOTE" => $row['allvote'],
		"COMM_COUNT" => $row['comm_count'],
		"PASSBTN" => $passbtn_arr[$row['pass']],//设置按钮文字
		"TESTMAILSTYLE" => $testmail?'':'display:none',//设置是否显示测试邮件按钮
		"PASSBTNSTYLE" => $row['pass']?'display:none':'',//设置按钮显示与否
		"BGCOLOR" => $bgcolor,//设置行的背景色交替
		"BOBO" => (1==$bobo_flag)?'有':'无',
		"BOBOLINK" => $bobo_flag?$viewurl:'bobo_update.php?id='.$id,
		"CURPAGE" => $page
		));
}
$tpl->assign_vars(array(
	"S_PASS" => $s_pass,
	"BTNFN" => $btnfn,//设置按钮可用否
	"TESTMAILSTYLE" => $testmail?'':'display:none',//设置是否显示测试邮件按钮
	"PASSBTNSTYLE" => $s_pass?'display:none':'',//设置“通过审核”按钮是否可见
	"COLOR10" => (0==$s_area)?'#6699FF':'',
	"COLOR11" => (1==$s_area)?'#6699FF':'',
	"COLOR12" => (2==$s_area)?'#6699FF':'',
	"COLOR13" => (3==$s_area)?'#6699FF':'',
	"COLOR20" => (2==$s_pass)?'#99CCFF':'',
	"COLOR21" => (1==$s_pass && 'id'==$order)?'#99CCFF':'',
	"COLOR22" => (1==$s_pass && 'allvote'==$order)?'#99CCFF':'',
	"COLOR23" => (0==$s_pass && 'id'==$order)?'#99CCFF':'',
	"COUNT" => '('.$total.'名)',
	"PAGE" => $pagenav
));

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();
?>