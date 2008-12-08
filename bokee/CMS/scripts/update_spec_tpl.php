#!/opt/bokee/php/bin/php
<?php
/**
* UpdateSpecificTplAction.cls.php
* @copyright bokee dot com
* @author liangbiquan@bokee.com
* @version 0.1
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

require_once('../lang/Assert.cls.php');
require_once('../mod/TemplateA.cls.php');	
		  
//定义需要更新的频道名称及模版id
$arr = Array( Array(1 => "sports", 2 => 43),
  Array(1 => "lady", 2 => 94),
  Array(1 => "cul", 2 => 58),
  Array(1 => "ent", 2 => 110),
  Array(1 => "sex", 2 => 109),
  Array(1 => "life", 2 => 68),
  Array(1 => "travel", 2 => 43),
  Array(1 => "media", 2 => 51),
  Array(1 => "game", 2 => 108),
  Array(1 => "edu", 2 => 224),
  Array(1 => "mobile",2 => 43),
  );

for( $i=0;$i<count($arr);$i++ )
{
	$db = "cms_" . $arr[$i][1];
	//$tpl = new TempateA( $db );
	//$tpl->GetTemplateById( $arr[$][2] );
	//$template->Publish();
	echo "channel:" . $arr[$i][1] . "is ok \n";

}
?>