<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>网址导航</TITLE>
<META content="text/html; charset=gb2312" http-equiv="Content-Type">
<SCRIPT LANGUAGE=JAVASCRIPT>
<!--
//防止被iframe
if (top.location !== self.location) {
top.location=self.location;
}
-->
</SCRIPT>
<LINK href="style.css" type="text/css" rel="stylesheet">
</HEAD>
<BODY>
<div class="main index">
	<div class="caption">网站大全</div>
	<div class="content">
<?
define('IN_MATCH', true);
$root_path="./";
include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");

$sql="select * from url_category where flag>0 order by flag desc,sort";
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

	$sql2="select * from url_website where flag>0 and cate_id=".$id." order by flag desc,sort";
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
			"mark"=>$row2['mark']);
	}
}
$db->sql_close();

foreach($cate_arr as $key=>$val)
{
	if(''==$rotate_bg)
	{
		$rotate_bg=' rotate_bg';
	}
	else
	{
		$rotate_bg='';
	}
	?>
		<div class="cate_site_list<?=$rotate_bg?>">
			<div class="cate_title">[<?=$val["name"]?>]</div>
			<div class="site_list">
	<?
	$i=0;
	foreach($site_arr[$val["id"]] as $key2=>$val2)
	{
		if($i>8)
		{
			break;
		}
		$i++;
		?>
		<a id="url" class="<?=$val2['mark']?'red':''?>" href="<?=$val2["url"]?>" target="_blank" ><?=$val2["name"]?></a>
		<?
	}
	?>
			</div>
		</div>
	<?
}
?>
	</div>
</div>

</body>
<iframe frameborder="1" scrolling="no" id="iframe1" name="iframe1" width="800" height="60" src="" style="display:none;"></iframe>
<script language="javascript" type="text/javascript" src="admin/jquery-1.2.1.js"></script>
<script language="javascript">
$("a#url").click(function(){
	t('iframe1').src=$(this).attr("href");
});
function t(id) {
	return document.getElementById(id);
}
</script>

</html>