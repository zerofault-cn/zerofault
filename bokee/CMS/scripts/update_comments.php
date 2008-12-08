#!/opt/bokee/php/bin/php
<?php
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
define('PATH_PAGE_CACHE',PATH_MODULE.SLASH.'cache'); // 页面缓存的存放路径

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

	//更新评论数
	$sql_comment = "select * from rss_entry_attach where source='column' or source='bbs' or source='blog' order by datetime desc limit 10000";
	$rows_comment = $dao->GetPlan($sql_comment);
	$count_comment = count($rows_comment);
	for($a=0;$a<$count_comment;$a++)
	{
		$sql_remote_comment = "select commentnum from entry where id=" . $rows_comment[$a]['entry_id'];
		$comment_num = $dao_rss->GetOne($sql_remote_comment);
		if($comment_num)
		{
			$sql_update_comment = "update rss_entry_attach set commentnum = $comment_num where id=" . $rows_comment[$a]['id'];
			if($dao->Query($sql_update_comment))
			{
				echo "$db update rss_entry_attach id " . $rows_comment[$a]['id'] . " commentnum : " . $comment_num . "\n";
			}
			else 
			{
				echo "$db update commentnum failure: " . $sql_update_comment . "\n";
			}
		}
	}
}

?>