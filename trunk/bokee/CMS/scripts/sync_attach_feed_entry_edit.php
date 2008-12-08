#!/opt/bokee/php/bin/php
<?php
/**
* sync_attach_feed_entry.php
* @abstract  同步附加至栏目种子的内容，将符合条件的文章从RSS服务器抓取至CMS服务器，放入rss_entry_attach表中，并在rss_article_subject中添加相应记录
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/
if(file_exists("sync.pid"))
{
	exit;
}

$fp = fopen("sync.pid", 'w');
fwrite($fp, date('Y-m-d H:i:s'));
fclose($fp);

define('DB_HOST','211.152.20.34');
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
define('PATH_PAGE_CACHE',PATH_MODULE.SLASH.'cache'); // ҳ�滺��Ĵ��·��

require_once('../sql/DAO.cls.php');
require_once('../lang/Assert.cls.php');
require_once('../com/FTP.cls.php');

$dao = DAO::CreateInstance();
$dao_rss = DAO::CreateInstanceEmpty();
if(!$dao_rss->Connect('rss', 'root', '10y9c2U5', '211.152.20.27'))
	die("connect error");
			
$sql_channel = "select * from channel";
$rows_channel = $dao->GetPlan($sql_channel);
$rows_num_channel = count($rows_channel);
for($i=0;$i<$rows_num_channel;$i++)
{
	$db = "cms_" . $rows_channel[$i]['dir_name'];
	$dao->SetCurrentSchema($db);
	$sql_feed = "select feed_id, count(id) as count from rss_feed_attach where 1 group by feed_id";
	$rows_feed = $dao->GetPlan($sql_feed);
	$rows_num_feed = count($rows_feed);
	//更新首页rss数据源
	if($db == "cms_www" || $db == "cms_sports" )
	{
		for($j=0;$j<$rows_num_feed;$j++)
		{
			$feed_id = $rows_feed[$j]['feed_id'];
			$url = "http://rss.bokee.com/main.php?do=updateContent&feed_id=$feed_id";
			$result = file_get_contents($url);
			echo "request RSS Server to update feed : $feed_id\n$result\n";
		}
	}
	
	echo "$db feed num: " . $rows_num_feed . "\n";
	for($j=0;$j<$rows_num_feed;$j++)
	{
		$sql_feed_entry_mid = "select max(entry_id) as mid from rss_entry_attach where feed_id=" . $rows_feed[$j]['feed_id'];
		$mid_local = $dao->GetOne($sql_feed_entry_mid);
		$mid_local = empty($mid_local)?0:$mid_local;
		//echo $sql_feed_entry_num . "\n";
		echo "$db local feed " . $rows_feed[$j]['feed_id'] . " entry max id : " . $mid_local . "\n";
		$sql_feed_entry_mid_ori = "select max(id) as mid from entry where feed_id=" . $rows_feed[$j]['feed_id'];
		$mid_remote = $dao_rss->GetOne($sql_feed_entry_mid_ori);
		$mid_remote = empty($mid_remote)?0:$mid_remote;
		echo "$db remote feed " . $rows_feed[$j]['feed_id'] . " entry max id : " . $mid_remote . "\n";
		if($mid_local<$mid_remote)
		{
			$sql_entry = "select * from entry where feed_id=" . $rows_feed[$j]['feed_id'] . " and id>$mid_local order by date_time asc";
			$rows_entry = $dao_rss->GetPlan($sql_entry);
			$rows_num_entry = count($rows_entry);
			echo "$db new entry num: " . $rows_num_entry . "\n";

//		$sql_feed_entry_num = "select count(id) as num from rss_entry_attach where feed_id=" . $rows_feed[$j]['feed_id'];
//		$feed_entry_num = $dao->GetOne($sql_feed_entry_num);
//		//echo $sql_feed_entry_num . "\n";
//		echo "feed entry num : " . $feed_entry_num . "\n";
//		$sql_feed_entry_num_ori = "select count(id) as num from entry where feed_id=" . $rows_feed[$j]['feed_id'];
//		$feed_entry_num_ori = $dao_rss->GetOne($sql_feed_entry_num_ori);
//		if($feed_entry_num!=$feed_entry_num_ori)
//		{
//			$limit = $feed_entry_num_ori-$feed_entry_num;
//			$sql_entry = "select * from entry where feed_id=" . $rows_feed[$j]['feed_id'] . " order by date_time asc limit " . $feed_entry_num . "," . $limit;
//			$rows_entry = $dao_rss->GetPlan($sql_entry);
//			$rows_num_entry = count($rows_entry);
//			echo "new entry num: " . $rows_num_entry . "\n";

			$ftp = new FTP('www');
			for($k=0;$k<$rows_num_entry;$k++)
			{
				//判断是否数据库中已经存在
				$sql_entry_exists = "select count(*) as num from rss_entry_attach where entry_id=" . $rows_entry[$k]['id'];
				$row = $dao->GetRow($sql_entry_exists);
				$num = $row['num'];
				if($num>0)
				{
					//如果已经存在则跳过，继续下一条
					continue;
				}
				

				//根据表rss_feed_attach来判断来源
				$source = "rss";


				//如果来源为rss,则根据url再次判断来源
				if( $source == "rss" )
				{
					$match_blogmark = "/blogmark\.bokee\.com/i";
					$match_blogmark_bc = "/blogmark\.blogchina\.com/i";
					$match_blog = "/bokee\.com\/\d+\.html/i";
					$match_blog_bc = "/blogchina\.com\/\d+\.html/i";
					$match_cms = "/bokee\.com/i";
					$match_cms_bc = "/blogchina\.com/i";
					$match_bbs = "/bbs\.bokee\.com/i";
					$match_bbs_bc = "/bbs\.blogchina\.com/i";
					$match_column = "/column\.bokee\.com/i";
					$match_column_bc = "/column\.blogchina\.com/i";
					$match_column_bco = "/www\.blogchina\.com\/new\/display/i";
					
					if($db != "cms_news")
					{
						if(preg_match($match_cms, $rows_entry[$k]['url']) || preg_match($match_cms_bc, $rows_entry[$k]['url']))
							$source = "cms";
					}
					if(preg_match($match_bbs, $rows_entry[$k]['url']) || preg_match($match_bbs, $rows_entry[$k]['url']))
						$source = "bbs";
					if(preg_match($match_blogmark, $rows_entry[$k]['url']) || preg_match($match_blogmark_bc, $rows_entry[$k]['url']))
						$source = "blogmark";
					if(preg_match($match_blog, $rows_entry[$k]['url']) || preg_match($match_blog_bc, $rows_entry[$k]['url']))
						$source = "blog";
					if(preg_match($match_column, $rows_entry[$k]['url']) || preg_match($match_column_bc, $rows_entry[$k]['url']) || preg_match($match_column_bco, $rows_entry[$k]['url']))
						$source = "column";
				}
				//根据url判断来源结束
				

				$sql_insert = "insert into rss_entry_attach set 
				title='" . $rows_entry[$k]['title'] . "',
				url='" . $rows_entry[$k]['url'] . "',
				datetime='" . $rows_entry[$k]['date_time'] . "',
				entry_id=" . $rows_entry[$k]['id'] . ",
				feed_id=" . $rows_entry[$k]['feed_id'] . ",
				source='" . $source . "',
				commentnum=" . $rows_entry[$k]['commentnum'] . ",
				author='" . $rows_entry[$k]['author'] . "'";
				if(!$dao->Insert($sql_insert))
				{
					echo "$db entry: " . $rows_entry[$k]['id'] . " added to feed: " . $rows_entry[$k]['feed_id'] . " failure!\n";
					echo $db . " " . $sql_insert . "\n";
					continue;
				}
				$article_id = $dao->LastID();
				//生成静态跳转页面
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
				$url = "http://" . $rows_channel[$i]['dir_name'] . ".bokee.com/feed/$date/" . $article_id . ".shtml";
				$fp = fopen($path, 'w');
				fwrite($fp, $page);
				fclose($fp);
				
				$ftp->Put($path, $path_remote);
				
				$sql_subject = "select subject_id from rss_feed_attach where feed_id = '".$rows_feed[$j]['feed_id']."'";
				$rows_subject = $dao->GetPlan($sql_subject);
				for($sub=0; $sub<$rows_feed[$j]['count']; $sub++)
				{
							
				//添加至rel_article_subject
				$time = str_replace(' ', '', $rows_entry[$k]['date_time']);
				$time = str_replace('-', '', $time);
				$time = str_replace(':', '', $time);
				$sql_insert = "insert into rel_article_subject set
				article_id=$article_id,
				subject_id=" . $rows_subject[$sub]['subject_id'] . ",
				title='" . $rows_entry[$k]['title'] . "',
				url='" . $url . "',
				datetime='" . $time . "',
				source='" . $source . "',
				category=1";

				if($dao->Insert($sql_insert))
				{
					echo "$db entry: " . $rows_entry[$k]['id'] . " added to feed: " . $rows_entry[$k]['feed_id'] . " success!\n";
				}
				else 
				{
					echo $sql_insert;
					echo "$db entry: " . $rows_entry[$k]['id'] . " added to feed: " . $rows_entry[$k]['feed_id'] . " failure!\n";
				}
				
				if(strlen($rows_entry[$k]['thumbnail'])>5)
				{
					$sql_insert = "insert into gallery set
					name = '" . $rows_entry[$k]['title'] . "',
					path = '" . $rows_entry[$k]['thumbnail'] . "',
					create_time = '" . $rows_entry[$k]['date_time'] . "',
					user_id=0,
					subject_id = " . $rows_subject[$sub]['subject_id'] . ",
					url = '" . $rows_entry[$k]['url'] . "',
					article_id = $article_id,
					category = 2";
					if($dao->Insert($sql_insert))
					{
						echo "$db photo: " . $rows_entry[$k]['id'] . " added to feed: " . $rows_entry[$k]['feed_id'] . " success!\n";
					}
					else 
					{
						echo $sql_insert;
						echo "$db photo: " . $rows_entry[$k]['id'] . " added to feed: " . $rows_entry[$k]['feed_id'] . " failure!\n";
					}
				}
				//cms图片category=1,rss图片category=2
				}
				
			}
			$ftp->Close();
		}
	}
unlink("sync.pid");	
	
}

?>
