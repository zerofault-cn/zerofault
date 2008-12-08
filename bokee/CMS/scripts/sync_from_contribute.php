#!/opt/bokee/php/bin/php
<?php
/**
* sync_attach_feed_entry.php
* @abstract  同步附加至栏目种子的内容，将符合条件的文章从RSS服务器抓取至CMS服务器，放入rss_entry_attach表中，并在rss_article_subject中添加相应记�?
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/
/*
if(file_exists("sync.pid"))
{
	exit;
}

$fp = fopen("sync.pid", 'w');
fwrite($fp, date('Y-m-d H:i:s'));
fclose($fp);
*/
define('DB_HOST','localhost');
define('DB_PORT','3306');
define('DB_USERNAME','root');
define('DB_PASSWORD','10y9c2U5');
define('DB_SCHEMA','cms');
define('PATH_ROOT', '/opt/bokee/www');
define('SLASH', '/');
define('PATH_MODULE', PATH_ROOT.SLASH.'CMS');
define('PATH_INF', PATH_MODULE.SLASH.'WEB-INF');
define('PATH_CLASS', PATH_INF.SLASH.'classes');
define('PATH_TPL', PATH_INF.SLASH.'tpl');
define('PATH_TEMPLATE', PATH_INF.SLASH.'html'.SLASH.'templates'.SLASH.'init');
define('PATH_HTML', PATH_INF.SLASH.'html');
define('PATH_HTML_ROOT', PATH_MODULE.SLASH."web".SLASH."root");
define('PATH_IMAGES', PATH_MODULE.SLASH."web".SLASH."images");
define('PATH_PAGE_CACHE',PATH_MODULE.SLASH.'cache'); // 页面缓存的存放路�?

require_once('../sql/DAO.cls.php');
require_once('../lang/Assert.cls.php');
require_once('../com/FTP.cls.php');

$dao = DAO::CreateInstance();
$dao_rss = DAO::CreateInstanceEmpty();
if(!$dao_rss->Connect('contribute', 'root', '10y9c2U5', '221.238.254.205'))
	die("connect error");
			
//获取频道名，如果为空，则默认置为www
$channel_name=$_REQUEST['channel_name'];
$id=$_REQUEST['id'];
if(''==$channel_name)
{
	$channel_name='www';
}
//$channel_name='column';
$db="cms_".$channel_name;
$dao->SetCurrentSchema($db);
if(''!=$id && $id>0)
{
	$sql_ext=" id=".$id." and ";
}
//从rss_entry_atttach表获取需要同步的投稿器源（即channel_id），暂时用blogmark做标记
$sql_feed = "select feed_id, count(id) as count from rss_feed_attach where ".$sql_ext." source='blogmark' group by feed_id";
$rows_feed = $dao->GetPlan($sql_feed);
$rows_num_feed = count($rows_feed);
//需要同步的来源数
echo "$db feed num: " . $rows_num_feed . "<br>\n";

for($j=0;$j<$rows_num_feed;$j++)
{
	//获取当前feed_id对应的本地最大entry_id
	$sql_feed_entry_mid = "select max(entry_id) as mid from rss_entry_attach where feed_id=".$rows_feed[$j]['feed_id'];
	$mid_local = $dao->GetOne($sql_feed_entry_mid);
	$mid_local = empty($mid_local)?0:$mid_local;
	echo "$db local feed " . $rows_feed[$j]['feed_id'] . " entry max id : " . $mid_local . "<br>\n";
	//获取投稿器数据库里当前feed_id对应的最大article id
	$sql_feed_entry_mid_ori = "select max(id) as mid from article where channel_id1=".$rows_feed[$j]['feed_id']." or channel_id2=".$rows_feed[$j]['feed_id']." or channel_id3=".$rows_feed[$j]['feed_id'];
	$mid_remote = $dao_rss->GetOne($sql_feed_entry_mid_ori);
	$mid_remote = empty($mid_remote)?0:$mid_remote;
	echo "$db remote feed " . $rows_feed[$j]['feed_id'] . " entry max id : " . $mid_remote . "<br>\n";
	if($mid_local<$mid_remote)
	{
		$sql_entry = "select * from article where id>".$mid_local." and (channel_id1=".$rows_feed[$j]['feed_id']." or channel_id2=".$rows_feed[$j]['feed_id']." or channel_id3=".$rows_feed[$j]['feed_id'].")";
		$rows_entry = $dao_rss->GetPlan($sql_entry);
		$rows_num_entry = count($rows_entry);
		echo "$db new entry num: " . $rows_num_entry . "<br>\n";

		$ftp = new FTP('www');
		for($k=0;$k<$rows_num_entry;$k++)
		{
			$source='blogmark';
			$sql_insert="insert into rss_entry_attach set title='".conv($rows_entry[$k]['title'])."',url='".$rows_entry[$k]['url']."',datetime='".date("Y-m-d H:i:s",$rows_entry[$k]['addtime'])."',entry_id=".$rows_entry[$k]['id'].",feed_id=".$rows_feed[$j]['feed_id'].",source='".$source."',commentnum=".$rows_entry[$k]['vote'].",author='".conv(getField($rows_entry[$k]['author_id'],'blogname','author'))."'";
			if(!$dao->Insert($sql_insert))
			{
				echo "$db entry: " . $rows_entry[$k]['id'] . " added to feed: " . $rows_entry[$k]['feed_id'] . " failure!<br>\n";
				echo $db . " " . $sql_insert . "<br>\n";
				continue;
			}
			$article_id = $dao->LastID();
			//生成静�?�跳转页�?
			$page = "<html> \n <head> \n <title></title> \n </head> \n <body>";
			$page.= "<script language='javascript'> \n";
			$page.= "location.href='" . $rows_entry[$k]['url'] . "' \n";
			$page.=	"</script> \n";
			$page.=	"</body> \n </html> \n";
			$date = date('Y-m-d');
			if(!is_dir(PATH_HTML_ROOT . "/$db/feed"))
				mkdir(PATH_HTML_ROOT . "/$db/feed");
			if(!is_dir(PATH_HTML_ROOT . "/$db/feed/$date"))
				mkdir(PATH_HTML_ROOT . "/$db/feed/$date");
			$path = PATH_HTML_ROOT . "/$db/feed/$date/" . $article_id . ".shtml";
			$path_remote = "/html/$db/feed/$date/" . $article_id . ".shtml";
				
			if($channel_name == 'blog')
			{
				$dnsName = 'blogs';
			}
			else
			{
				$dnsName = $channel_name;
			}
			$url = "http://" . $dnsName . ".bokee.com/feed/$date/" . $article_id . ".shtml";
			$fp = fopen($path, 'w');
			fwrite($fp, $page);
			fclose($fp);

			$ftp->Put($path, $path_remote);
				
			$sql_subject = "select subject_id from rss_feed_attach where feed_id = '".$rows_feed[$j]['feed_id']."'";
			$rows_subject = $dao->GetPlan($sql_subject);
			for($sub=0; $sub<$rows_feed[$j]['count']; $sub++)
			{
				//添加至rel_article_subject
				$time = date("Y-m-d H:i:s", $rows_entry[$k]['addtime']);
				$sql_insert = "insert into rel_article_subject set
				article_id=$article_id,
				subject_id=" . $rows_subject[$sub]['subject_id'] . ",
				title='" . conv($rows_entry[$k]['title']) . "',
				url='" . $url . "',
				datetime='" . $time . "',
				source='".$source."',
				category=1";
				if($dao->Insert($sql_insert))
				{
					echo "$db entry: " . $rows_entry[$k]['id'] . " added to subject: " . $rows_feed[$j]['feed_id'] . " success!<br>\n";
				}
				else 
				{
					echo $sql_insert;
					echo "$db entry: " . $rows_entry[$k]['id'] . " added to subject: " . $rows_feed[$j]['feed_id'] . " failure!<br>\n";
				}
			}
		}
		$ftp->Close();
	}
}

echo 'done';
function getField($id,$field,$table)
{
	global $dao_rss;
	$sql0="select ".$field." from ".$table." where id=".$id;
	return $dao_rss->GetOne($sql0);
}
function conv($str)
{
	return mb_convert_encoding($str,"utf-8","utf-8,gbk,gb2312");
}
?>
