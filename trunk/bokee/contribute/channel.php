<?
error_reporting(0);
header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

define('IN_MATCH', true);
$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."functions.php");

$tpl = new Template($root_path."templates");
$mode=$_REQUEST['mode'];
if($mode=='export')
{
	$tpl->set_filenames(array('body' => 'channel_export.htm'));
}
else
{
	$tpl->set_filenames(array('body' => 'channel.htm'));
}
$id=$_REQUEST['id'];
$tpl->assign_vars(array(
	"ID"=>$id
	));

$blogID=getBlogID();
if(''!=$blogID)
{
	$sql0="select blogname,email from author where blogid='".$blogID."'";
	$result0=$db->sql_query($sql0);
	$blogname=$db->sql_fetchfield(0,0,$result0);
	$email=$db->sql_fetchfield(1,0,$result0);
	$tpl->assign_vars(array(
		"MESSAGE"=>$blogID.'，您好，欢迎您来投稿!',
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

//当前频道名
$sql1="select name from channel where id=".$id;
assign_vars_by_sql($sql1);

//本频道活跃作者
//$sql2="select left(blogname,16) as tmp_blogname,blogname,blogurl,count(*) as month_article from author,article where article.author_id=author.id and article.addtime>(UNIX_TIMESTAMP()-30*86400) and (article.channel_id1=".$id." or article.channel_id2=".$id." or article.channel_id3=".$id.") group by author_id order by month_article desc limit 28";
//assign_block_vars_by_sql("activeAuthor", $sql2);
$sql2="select author_id,count(author_id) as count from article where addtime>(UNIX_TIMESTAMP()-30*86400) and (channel_id1=".$id." or channel_id2=".$id." or channel_id3=".$id.") group by author_id order by count desc limit 28";
$result2=$db->sql_query($sql2);
while($row=$db->sql_fetchrow($result2))
{
	$author_id=$row['author_id'];
	$count=$row['count'];
	$blogname=getField($author_id,'blogname','author');
	$tmp_blogname=substr_cut($blogname,16);
	$blogid=getField($author_id,'blogid','author');
	$blogurl='http://'.$blogid.'.bokee.com/';
	$tpl->assign_block_vars("activeAuthor",array(
		"blogname"=>$blogname,
		"tmp_blogname"=>$tmp_blogname,
		"blogurl"=>$blogurl,
		"month_article"=>$count
		));
}
//本频道本月热门作者
$sql3="select author_id,vote from article where addtime>(UNIX_TIMESTAMP()-30*86400) and (channel_id1=".$id." or channel_id2=".$id." or channel_id3=".$id.")";
$result3=$db->sql_query($sql3);
while($row=$db->sql_fetchrow($result3))
{
	$author_id=$row['author_id'];
	$vote=$row['vote'];
	$arr[$author_id]+=$vote;
}
arsort($arr);
//array_slice($arr,0,20);
$i=0;
while(list($key,$val)=each($arr))
{
	$i++;
	$blogname=getField($key,'blogname','author');
	$tmp_blogname=substr_cut($blogname,10);
	$blogurl=getField($key,'blogurl','author');
	$blogid=getField($key,'blogid','author');
	if(strlen($blogurl)<18)
	{
		$blogurl='http://'.$blogid.'.bokee.com/';
	}
	$tpl->assign_block_vars("hotAuthor",array(
		"blogname"=>$blogname,
		"tmp_blogname"=>$tmp_blogname,
		"blogurl"=>$blogurl,
		"vote"=>$val
		));
	if($i>=21)
	{
		break;
	}
}

//最新投稿文章
$pageitem=20;
if($mode=='export')
{
	$pageitem=12;
}
//$sql4="select article.id,author_id,title,left(title,40) as tmp_title,url,blogname,left(blogname,10) as tmp_blogname,blogurl,FROM_UNIXTIME(addtime,'%m/%d %H:%i') as datetime from author,article where article.author_id=author.id and (channel_id1=".$id." or channel_id2=".$id." or channel_id3=".$id.") order by article.id desc";
$sql4="select id,author_id,title,url,addtime from article where channel_id1=".$id." or channel_id2=".$id." or channel_id3=".$id." order by addtime desc";
$result4=$db->sql_query($sql4);
$total=$db->sql_numrows($result4);
pageft($total,$pageitem,"?mode=".$mode."&id=".$id);
//assign_block_vars_by_sql("newArticle",$sql4." limit ".$offset.",".$pageitem);
$result4=$db->sql_query($sql4." limit ".$offset.",".$pageitem);
while($row=$db->sql_fetchrow($result4))
{
	$article_id=$row['id'];
	$author_id=$row['author_id'];
	$title=$row['title'];
	$tmp_title=substr_cut($title,40);
	$url=$row['url'];
	$datetime=date("m/d H:i",$row['addtime']);
	$blogname=getField($author_id,'blogname','author');
	$tmp_blogname=substr_cut($blogname,10);
	$tpl->assign_block_vars("newArticle",array(
		"article_id"=>$article_id,
		"author_id"=>$author_id,
		"blogname"=>$blogname,
		"tmp_blogname"=>$tmp_blogname,
		"title"=>$title,
		"tmp_title"=>$tmp_title,
		"url"=>$url,
		"datetime"=>$datetime
		));
}
$tpl->assign_vars(array(
	"PAGENAV"=>$pagenav
	));

//热门文章
//$sql5="select article.id,author_id,title,left(title,40) as tmp_title,url,blogname,left(blogname,10) as tmp_blogname,blogurl,article.vote from author,article where article.author_id=author.id and (channel_id1=".$id." or channel_id2=".$id." or channel_id3=".$id.") order by vote desc limit 14";
//assign_block_vars_by_sql("hotArticle", $sql5);
$limit=14;
if($mode=='export')
{
	$limit=6;
}

$sql5="select id,author_id,title,url,vote from article where channel_id1=".$id." or channel_id2=".$id." or channel_id3=".$id." order by vote desc limit ".$limit;
$result5=$db->sql_query($sql5);
while($row=$db->sql_fetchrow($result5))
{
	$article_id=$row['id'];
	$author_id=$row['author_id'];
	$title=$row['title'];
	$tmp_title=substr_cut($title,40);
	$url=$row['url'];
	$vote=$row['vote'];
	$blogname=getField($author_id,'blogname','author');
	$tmp_blogname=substr_cut($blogname,10);
	$tpl->assign_block_vars("hotArticle",array(
		"article_id"=>$article_id,
		"author_id"=>$author_id,
		"blogname"=>$blogname,
		"tmp_blogname"=>$tmp_blogname,
		"title"=>$title,
		"tmp_title"=>$tmp_title,
		"url"=>$url,
		"vote"=>$vote
		));
}

$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();

?>