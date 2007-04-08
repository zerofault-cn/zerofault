<?
include "session.php";
define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/db.php");

$id = $_REQUEST['id'];
$boboimg='http://my.bobo.com.cn/bokee/changepic.php?userid='.$id;
$bobo_flag=(strlen(file_get_contents($boboimg))==711)?1:0;
$sql="update mm_info set bobo_flag=".$bobo_flag." where id=".$id;

if($db->sql_query($sql))
{
	if($bobo_flag)
	{
		echo '检验结果:有视频';
	}
	else
	{
		echo '检验结果:无视频';
	}
}
else
{
	echo 'error|sql:'.$sql;
}

$db->sql_close();

?>