<?
/* @copyright bokee dot com
:w* @author yudunde@bokee.com
*/

/* -------------------------------------------------------- *
 *            安装发布或移植时需要修改的配置                *
 * define('DEBUG');                                         *
 * define('OS_TYPE');                                       *
 * define('DB_HOST','');                                    *
 * define('DB_USERNAME','');                                *
 * define('DB_PASSWORD','');                                *
 * define('DB_SCHEMA','');                                  *
 * define('PATH_ROOT','/var/www/Root');                     *
 * -------------------------------------------------------- */
// ---------- 平台和调试配置 ---------------- //
define('DEBUG', true);
define('OS_TYPE','WIN');  // 操作系统类型 (WIN|UNIX|MAC)
switch ( OS_TYPE ){
    case 'WIN':
		define('SLASH', '/');
        break;
    case 'UNIX':
    case 'MAC':
    	define('SLASH', '/');
 		break;
    default:
        exit('You didn\'t define OS_TYPE');
}
// ------------ 编码 ----------------------- //
header('Content-Type: text/html;charset=utf-8');
// ---------- 数据库访问配置信息 ------------- //
define('DB_HOST','localhost');
define('DB_PORT','3306');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_SCHEMA','cms');
// ---------- RSS数据库访问配置 -------------- //
define('RSS_DB_HOST', '211.152.20.27');
define('RSS_DB_PORT','3306');
define('RSS_DB_USERNAME','root');
define('RSS_DB_PASSWORD','10y9c2U5');
define('RSS_DB_SCHEMA','rss');
// ---------- 文件路径配置信息 --------------- //
// 需要初始化的路径包括 :
// . , class , inc , html , tpl , dev
define('DOMAIN', 'bokee.com');
define('PATH_ROOT', 'e:/bokee');
define('PATH_MODULE', PATH_ROOT.SLASH.'CMS');
define('PATH_INF', PATH_MODULE.SLASH.'WEB-INF');
define('PATH_CLASS', PATH_INF.SLASH.'classes');
define('PATH_TPL', PATH_INF.SLASH.'tpl');
define('PATH_TEMPLATE', PATH_INF.SLASH.'html'.SLASH.'templates'.SLASH.'init');
define('PATH_HTML', PATH_INF.SLASH.'html');
define('PATH_HTML_ROOT', PATH_MODULE.SLASH."web".SLASH."root");
define('PATH_REMOTE_HTML_ROOT', "/CMS_html");
define('PATH_IMAGES', PATH_MODULE.SLASH."web".SLASH."images");
define('PATH_PAGE_CACHE',PATH_MODULE.SLASH.'cache'); // 页面缓存的存放路径
// -------------- 路径初始化 ------------------- //
switch ( OS_TYPE ){
    case 'WIN':
        ini_set('include_path','.;'.PATH_INF.';'.PATH_CLASS.';'.PATH_TPL.';'.PATH_HTML);
        break;
    case 'UNIX':
    case 'MAC':
        ini_set('include_path','.:'.PATH_INF.':'.PATH_CLASS.':'.PATH_TPL.':'.PATH_HTML);
        break;
    default:
        exit('You didn\'t define OS_TYPE');
}
// ------------- 包含所有需要包含的文件 ------------ //
require_once('mvc_config.inc.php');
require_once('ftp_config.inc.php');
require_once('smarttemplate_config.inc.php');
require_once('mvc'.SLASH.'ActionConfig.cls.php');
require_once('mvc'.SLASH.'ActionServer.cls.php');
?>
