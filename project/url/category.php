<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>网址导航－分类列表</TITLE>
<META content="text/html; charset=gb2312" http-equiv="Content-Type">
<SCRIPT LANGUAGE=JAVASCRIPT>
<!--
if (top.location !== self.location) {
top.location=self.location;
}
-->
</SCRIPT>
<META content="MSHTML 5.00.2920.0" name=GENERATOR>
<LINK href="style.css" type="text/css" rel="stylesheet">
</HEAD>
<BODY>
<div class="main category">
	<div class="content">
		<div class="cate_site_title"></div>
<?
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");

$sql="select * from category where flag>0 order by sort";
$result=$db->sql_query($sql);
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

	$sql2="select * from website where flag>0 and cate_id=".$id." order by flag desc,sort";
	$result2=$db->sql_query($sql2);
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
			"mark"=>$row2['mark']);
	}
}
$db->sql_close();
//echo '<pre>';
//print_r($site_arr);
//echo '</pre>';
while(list($key,$val)=each($cate_arr))
{
	if(sizeof($site_arr[$val["id"]])==0)
	{
		continue;
	}
	?>
		<div class="cate_site_list">
			<div class="cate_title"><?=$val["name"]?></div>
			<div class="site_list">
	<?
	while(list($key2,$val2)=@each($site_arr[$val["id"]]))
	{
		?>
		<span class="site"><a class="<?=$val2['mark']?'red':''?>" href="<?=$val2["url"]?>" title="<?=$val2["name"]?>" target="_blank" ><?=$val2["name"]?></a></span>
		<?
	}
		?>
		<a class="more red" href="#">更多>></a>
			</div>
		</div>
	<?
}
?>
	</div>
</div>

</body>
<iframe frameborder="0" scrolling="no" id="iframe1" name="iframe1" width="0" height="0" src=""></iframe>
</html>