#!/opt/bokee/php/bin/php
<?php
/**
update_group_id.php
将article表中对应的group_id复制到相应的rel_article_subject表中
*/

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

$dao = DAO::CreateInstance();
			
$sql_channel = "select * from channel";
$rows_channel = $dao->GetPlan($sql_channel);
$rows_num_channel = count($rows_channel);
for($i=0;$i<$rows_num_channel;$i++)
{
	if( $rows_channel[$i]['dir_name'] != "lady" )
		continue;

	$db = "cms_" . $rows_channel[$i]['dir_name'];
	$dao->SetCurrentSchema($db);
	$sql = "select id,group_id from article where group_id !=0";
	$rows= $dao->GetPlan( $sql );
	if( !empty( $rows ) )
	{
		for( $j=0;$j<count( $rows );$j++ )
		{
			$sql = "update rel_article_subject set group_id=" . $rows[$j]['group_id'];
			$sql.= " where source='cms' and article_id= " . $rows[$j]['id'];
			if( $dao->Update( $sql ) )
				echo $sql,"<br>";
		}
	}
	
}


?>
