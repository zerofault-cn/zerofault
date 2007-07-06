<?
header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

define('IN_MATCH', true);

$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."functions.php");

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array('body' => 'index.htm'));

$blogID=getBlogID();
if(''!=$blogID && strlen($blogID)>2)
{
	$sql0="select blogname,email from author where blogid='".$blogID."'";
	$result0=$db->sql_query($sql0);
	$blogname=$db->sql_fetchfield(0,0,$result0);
	$email=$db->sql_fetchfield(1,0,$result0);
	$tpl->assign_vars(array(
		"MESSAGE"=>$blogID.',您好，欢迎您来投稿!',
		"DISABLE"=>'',
		"BLOGID"=>$blogID,
		"BLOGNAME"=>$blogname,
		"EMAIL"=>$email
		));
}
else
{
	$tpl->assign_vars(array(
		"MESSAGE"=>'您必须先登录博客通行证，然后才能开始投稿',
		"DISABLE"=>'disabled',
		"BLOGID"=>'',
		"BLOGNAME"=>'',
		"EMAIL"=>''
		));
}

//热门频道
$sql1="select id,name,article_count from channel order by article_count desc limit 21";
assign_block_vars_by_sql("hotChannel", $sql1);

//用户可自由投稿的频道
$sql2="select id,name from channel where sys_flag=1";
assign_block_vars_by_sql("sysChannel", $sql2);

//最新投稿文章
#$sql3="select title,left(title,34) as tmp_title,url,blogname,left(blogname,8) as tmp_blogname,blogurl from author,article where article.author_id=author.id order by article.id desc limit 8";
//assign_block_vars_by_sql("newArticle", $sql3);
$sql3="select author_id,title,url from article order by id desc limit 8";
$result3=$db->sql_query($sql3);
while($row=$db->sql_fetchrow($result3))
{
	$author_id=$row['author_id'];
	$blogname=getField($author_id,'blogname','author');
	$tmp_blogname=substr_cut($blogname,10);
	$title=$row['title'];
	$tmp_title=substr_cut($title,34);
	$url=$row['url'];
	$tpl->assign_block_vars("newArticle",array(
		"tmp_blogname"=>$tmp_blogname,
		"title"=>$title,
		"tmp_title"=>$tmp_title,
		"url"=>$url));
}


//本月热门作者
$sql4="select left(blogname,16) as tmp_blogname,blogname,blogurl,month_article from author order by month_article desc limit 14";
assign_block_vars_by_sql("hotAuthor", $sql4);


$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();

?>