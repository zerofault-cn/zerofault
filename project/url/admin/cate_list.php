<?
define('IN_MATCH', true);
$root_path="../";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include "session.php";

$action=$_REQUEST['action'];
if('add'==$action)
{
	$table=$_REQUEST['table'];
	$cate_id=$_REQUEST['cate_id'];
	$site_id=$_REQUEST['site_id'];
	$name=$_REQUEST['name'];
	$url=$_REQUEST['url'];
	$sort=$_REQUEST['sort'];
	$descr=$_REQUEST['descr'];
	if('url_website'==$table)
	{
		if($site_id>0)
		{
			$sql1="select * from url_website where name='".$name."' and id!=".$site_id;
			$sql2="update url_website set name='".$name."',url='".$url."',descr='".$descr."' where id=".$site_id;
		}
		else
		{
			$sql1="select * from url_website where binary name='".$name."'";
			$sql2="insert into url_website set cate_id=".$cate_id.",name='".$name."',url='".$url."',descr='".$descr."',addtime=UNIX_TIMESTAMP(),sort=".$sort.",flag=1";
		}
	}
	else
	{
		$sql1="select * from url_category where binary name='".$name."'";
		$sql2="insert into url_category set name='".$name."',descr='".$descr."',addtime=UNIX_TIMESTAMP(),sort=".$sort.",flag=1";
	}
	if($db->sql_numrows($db->sql_query($sql1))>0)
	{
	//	echo $sql1;
	//	echo '<br />';
	//	echo $sql2;
	//	echo '<script>parent.alert("该条目已经添加过了!");</script>';
		echo '-1';
		exit;
	}
	if($db->sql_query($sql2))
	{
	//	echo '<script>parent.location.reload();parent.addsite('.$id.');</script>';
		echo '1';
	}
	else
	{
		echo 'sql2:'.$sql2;
	}
	exit;
}
if('del'==$action)
{
	$table=$_REQUEST['table'];
	$id=$_REQUEST['id'];
	if('category'==$table)
	{
		$sql1="select * from url_website where cate_id=".$id;
		if($db->sql_numrows($db->sql_query($sql1))>0)
		{
			echo '-1';
			exit;
		}
	}
	$sql="delete from ".$table." where id=".$id;
	if($db->sql_query($sql))
	{
		echo '1';
	}
	else
	{
		echo 'sql:'.$sql;
	}
	exit;
}
if('modify'==$action)
{
	$table=$_REQUEST['table'];
	$id=$_REQUEST['id'];
	$field=$_REQUEST['field'];
	$value=$_REQUEST['value'];
	$sql="update ".$table." set ".$field."='".$value."' where id=".$id;
	if($db->sql_query($sql))
	{
		echo '1';
	}
	else
	{
		echo 'sql:'.$sql;
	}
	exit;
}
$sql="select * from url_category order by flag desc,sort";
$result=$db->sql_query($sql);
$cate_arr=array();
$site_arr=array();
while($row=$db->sql_fetchrow($result))
{
	$id=$row['id'];
	$cate_arr[]=array(
		"id"=>$id,
		"name"=>$row['name'],
		"descr"=>$row['descr'],
		"addtime"=>date("Y-m-d H:i:s",$row['addtime']),
		"sort"=>$row['sort'],
		"flag"=>$row['flag']);
	$max_cate_sort=max($max_cate_sort,$row['sort']);

	$sql2="select * from url_website where cate_id=".$id." order by flag desc,sort";
	$result2=$db->sql_query($sql2);
	$site_arr[$id]=array();
	while($row2=$db->sql_fetchrow($result2))
	{
		$site_arr[$id][]=array(
			"id"=>$row2['id'],
			"name"=>$row2['name'],
			"url"=>$row2['url'],
			"descr"=>$row2['descr'],
			"addtime"=>date("Y-m-d H:i:s",$row2['addtime']),
			"sort"=>$row2['sort'],
			"flag"=>$row2['flag'],
			"mark"=>$row2['mark'],
			);
		$max_sort[$id]=max($max_sort[$id],$row2['sort']);
	}
}
$db->sql_close();

//include_once("left.php");//左边菜单
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网址导航后台管理</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script language="javascript" type="text/javascript" src="jquery-1.2.1.js"></script>
<script language="javascript" type="text/javascript" src="function.js"></script>
</head>
<body>
<div style="width:800px;margin-top:10px;margin-left:auto;margin-right:auto;border:1px solid #000;padding:10px;">
	<div style="text-align:center;line-height:20px;color:#000000;FILTER: glow(color:#308148,strength=3);">网址导航分类及链接管理</div>
	<div id="addcate" style="border:1px dotted #bbb;padding:3px;line-height:140%;">
		<input type="button" id="toAddCate" value="添加新分类" />
		<div id="addCateForm">
			分类名称：<input type="text" id="cate_name" name="cate_name" size="10" tabindex="1" />
			排序：<input type="text" id="cate_sort" name="cate_sort" value="<?=($max_cate_sort+10)?>" size="4">
			<input type="button" value="提交" id="submit_addCate" /> <input type="button" value="取消" id="cancel_addCate" /><br />
			简介：<input type="text" id="cate_descr" name="cate_descr" size="40" tabindex="2" />
		</div>
	</div>
	<ol class="cate_list">
<?
$show_arr=array("显示","隐藏");
$mark_arr=array("突出","普通");
$class_arr=array("gray","");
foreach($cate_arr as $key=>$val)
{
	$i=0;
	//列举分类
	?>
		<li id="<?=$val["id"]?>" class="<?=$class_arr[$val["flag"]]?>">
			<div class="cate">
				<span class="cate_func">
					排序:<label id="<?=$val["id"]?>"><?=$val["sort"]?></label>
					<span style="margin-left:100px;"><!-- 空位 --></span>
					<!-- 显示与隐藏 -->
					[<a href="javascript:void(0)" id="<?=$val["id"]?>" class="show" value='<?=intval(!$val["flag"])?>'><?=$show_arr[$val["flag"]]?></a>]
					[<a href="javascript:void(0)" id="<?=$val["id"]?>" class="delete">删除</a>]
				</span>
				<span class="cate_info">
					<label id="<?=$val["id"]?>"><?=$val["name"]?></label>
					&nbsp;&nbsp;[<a href="javascript:void(0)" class="toAddSite" value="0">添加网站</a>]
					&nbsp;&nbsp;<a href="javascript:void(0)" class="toShowSite" value="0"><?=(sizeof($site_arr[$val["id"]])>10?($val['id']==$all?'[显示最新10个]':'[显示全部'.sizeof($site_arr[$val["id"]]).'个网站]'):'')?></a>
				</span>
				
			</div>
			<ol class="site_list">
				<div class="addSiteForm" id="<?=$val["id"]?>">
					网站：<input type="text" class="site_name" name="site_name" size="10" tabindex="1" />
					排序：<input type="text" class="site_sort" name="site_sort" value="<?=($max_sort[$val['id']]+10)?>" size="4">
					<input type="button" value="提交" class="submit">
					<input type="button" value="取消" class="cancel"><br />
					网址：<input type="text" class="site_url" name="site_url" size="20" tabindex="2" /><br />
					简介：<input type="text" class="site_descr" name="site_descr" size="40" tabindex="3" />
				</div>
	<?
	foreach($site_arr[$val["id"]] as $key2=>$val2)
	{
		?>
				<li id="<?=$val2["id"]?>" class="<?=$class_arr[$val2["flag"]]?>">
					<span class="site_func">
						排序:<label id="<?=$val2["id"]?>"><?=$val2["sort"]?></label>&nbsp;&nbsp;&nbsp;&nbsp;
						<span function="as a parent">[<a href="javascript:void(0)" id="<?=$val2["id"]?>" class="show" value='<?=intval(!$val2["flag"])?>'><?=$show_arr[$val2["flag"]]?></a>&nbsp;&nbsp;
						<a href="javascript:void(0)" id="<?=$val2["id"]?>" class="mark" value='<?=intval(!$val2["mark"])?>'><?=$mark_arr[$val2["mark"]]?></a>]</span>
						<span function="add a parent">[<a href="javascript:void(0)" id="<?=$val2["id"]?>" class="delete">删除</a>]</span>
					</span>
					<span class="site_info">
						<a class="<?=($val2["flag"]&&$val2["mark"])?'red':''?>" id="<?=$val2["id"]?>" href="<?=$val2["url"]?>" title="<?=$val2['descr']?>" target="_blank"><?=$val2["name"]?></a>&nbsp;&nbsp;<a href="javascript:void(0)" class="toEditSite">[修改]</a>
					</span>
					<div class="clear"></div>
				</li>
		<?
	}
	?>
			</ol>
		</li>
<?
}
?>
	</ol>
</div>
</body>
</html>