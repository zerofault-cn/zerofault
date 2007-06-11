<?
define('IN_MATCH', true);

header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$root_path ="./";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."functions.php");

$blogID=getBlogID();
if(''==$blogID)
{
	echo '<script>parent.alert("您的博客通行证已经超时，或者您在其他页面退出了博客通行证");parent.location.reload();</script>';
	exit;
}
if($_POST['Submit'])
{
	$title=$_POST['title'];
	$url=$_POST['url'];
	$blogname=$_POST['blogname'];
	$blogurl=$_POST['blogurl'];
	$email=$_POST['email'];
	$channel_id=$_POST['id'];
	$sql1="select id from article where url='".$url."'";
	$result1=$db->sql_query($sql1);
	if($db->sql_numrows($result1)>0)
	{
		echo '<script>parent.alert("这篇文章已经被投稿，请不要重复投稿!");</script>';
		exit;
	}
	$sql2="select id from author where blogid='".$blogID."'";
	$result2=$db->sql_query($sql2);
	if($db->sql_numrows($result2)>0)
	{
		$author_id=$db->sql_fetchfield(0,0,$result2);
		$sql3="update author set blogname='".$blogname."',blogurl='".$blogurl."',email='".$email."' where id=".$author_id;
		$db->sql_query($sql3);
	}
	else
	{
		$sql3="insert into author set blogid='".$blogID."',blogurl='".$blogurl."',blogname='".$blogname."',email='".$email."'";
		$result3=$db->sql_query($sql3);
		$author_id=$db->sql_nextid();
	}
	$sql_ext='';
	if(''!=$author_id)
	{
		if(is_array($id))
		{
			for($i=0;$i<sizeof($id);$i++)
			{
				$sql_ext.=",channel_id".($i+1)."=".$id[$i];
			}
		}
		else
		{
			$sql_ext.=",channel_id1=".$id;
		}
		$sql4="insert into article set author_id=".$author_id.",title='".htmlspecialchars($title)."',url='".$url."',addtime=UNIX_TIMESTAMP()".$sql_ext;
		if($db->sql_query($sql4))
		{
			echo '
			<script>
				parent.alert("投稿成功，感谢您的支持!");
				parent.document.addForm.title.value="";
				parent.document.addForm.url.value="http://";
				var c = parent.document.getElementsByName("id[]");
				for(i=0;i<c.length;i++)
				{
					c[i].checked =false;
				}
				</script>';
			exit;
		}
	}

}
$db->sql_close();

?>