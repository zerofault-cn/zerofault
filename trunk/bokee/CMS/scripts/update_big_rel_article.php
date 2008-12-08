<?php
define('DB_HOST','localhost');
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
define('PATH_PAGE_CACHE',PATH_MODULE.SLASH.'cache'); // 页面缓存的存放路径

require_once('../lang/Assert.cls.php');
require_once('../com/FTP.cls.php');

$db = "cms_sports";
mysql_connect('localhost', 'root', '');
mysql_select_db('cms_sports');
$sql = "select count(*) as num from rel_article_subject where article_id>1000000";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
$count = $row['num'];
$ftp = new FTP();
for($i=0;$i<$count;$i++)
{
	$sql = "select * from rel_article_subject where article_id>1000000 order by id asc limit 1";
	$rs = mysql_query($sql);
	if(mysql_num_rows($rs)==0)
	{
		$ftp->Close();
		exit;
	}
	$row = mysql_fetch_array($rs);
	$sql1 = "select * from rss_entry_attach where entry_id=" . $row['article_id'];
	$rs1 = mysql_query($sql1);
	$row1 = mysql_fetch_array($rs1);
	
	$page = "<html> \n <head> \n <title></title> \n </head> \n <body>";
				$page.= "<script language='javascript'> \n";
				$page.= "location.href='" . $row1['url'] . "' \n";
				$page.=	"</script> \n";
				$page.=	"</body> \n </html> \n";
				$date = date('Y-m-d');
				if(!is_dir(PATH_HTML_ROOT . "/$db/feed"))
					mkdir(PATH_HTML_ROOT . "/$db/feed");
				if(!is_dir(PATH_HTML_ROOT . "/$db/feed/$date"))
					mkdir(PATH_HTML_ROOT . "/$db/feed/$date");
				$path = PATH_HTML_ROOT . "/$db/feed/$date/" . $row1['id'] . ".shtml";
				$path_remote = "/html/$db/feed/$date/" . $row1['id'] . ".shtml";
				$url = "http://sports.bokee.com/feed/$date/" . $row1['id'] . ".shtml";
				$fp = fopen($path, 'w');
				fwrite($fp, $page);
				fclose($fp);
				
				$ftp->Put($path, $path_remote);
	$sql2 = "update rel_article_subject set article_id=" . $row1['id'] . ", url='" . $url . "' where article_id=" . $row['article_id'];
	mysql_query($sql2);
	echo $sql2 . "\n";
}
$ftp->Close();
?>
