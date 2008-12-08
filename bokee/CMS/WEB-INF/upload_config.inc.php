<?php
/**
* Atom 模块 配置文件
* @copyright zhong zichang Wed Jan 19 15:47:22 CST 2005
* @author zczhong@hotmail.com
* @since PHP 4
*/

/* -------------------------------------------------------- *
 *            安装发布或移植时需要修改的配置                    *
 * define('DEBUG');                                         *
 * define('OS_TYPE');                                       *
 * define('DB_HOST','');                                    *
 * define('DB_USERNAME','');                                *
 * define('DB_PASSWORD','');                                *
 * define('DB_SCHEMA','');                                  *
 * define('PATH_ROOT','/var/www/Root');                       *
 * -------------------------------------------------------- */
// ---------- 平台和调试配置 ---------------- //
define('DEBUG', false);
define('OS_TYPE','UNIX');  // 操作系统类型 (WIN|UNIX|MAC)

header('Content-Type: text/html;charset=utf-8');
// ---------- 数据库访问配置信息 ------------- //
define('DB_HOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','10y9c2U5');
define('DB_SCHEMA','rss');

// ---------- 文件路径配置信息 --------------- //
// 需要初始化的路径包括 :
// . , class , inc , html , tpl , dev
define('PATH_DEV', '/var/www/dev');
define('PATH_ROOT', '/var/www/html');
define('PATH_DYNRES','/var/www/dynres/rss');
define('PATH_TEMP','/var/www/temp');
define('PATH_MODULE', PATH_ROOT.'/rss');
define('PATH_INF', PATH_MODULE.'/WEB-INF');
define('PATH_CLASS', PATH_INF.'/classes');
define('PATH_INC', PATH_INF.'/inc');
define('PATH_TPL', PATH_INF.'/tpl');
define('PATH_HTML', PATH_INF.'/html');
//define('PATH_STARES',PATH_ROOT.'');
define('PATH_FEED',PATH_DYNRES.'/feed');
define('PATH_ENTRY',PATH_DYNRES.'/entry');
define('NEW_FEED_FILE',PATH_DYNRES.'/feed.txt');// 新增的种子追加到这个位置

// ---------- URL 配置信息 ------------------ //
define('URL_ROOT','http://rss.blogchina.com');

// ---------- 用户配置信息 ------------------ //
define('EXEC_UPDATE_SPACING',420);// 限制用户对每一个种子源执行更新的时间间隔

// ----------- 其他常量的定义  --------------- //

// -------------- 路径初始化 ------------------- //
switch ( OS_TYPE ){
    case 'WIN':
        ini_set('include_path','.;'.PATH_DEV.';'.PATH_CLASS.';'.
                PATH_INC.';'.PATH_TPL.';'.PATH_HTML);
        break;
    case 'UNIX':
    case 'MAC':
        ini_set('include_path','.:'.PATH_DEV.':'.PATH_CLASS.':'.
                PATH_INC.':'.PATH_TPL.':'.PATH_HTML);
        break;
    default:
        exit('You didn\'t define OS_TYPE');
}
// ------------- 包含所有需要包含的文件 ------------ //
require_once('mvc_config.inc.php');
require_once('smarttemplate_config.inc.php');
require_once('php/mvc/ActionConfig.cls.php');
require_once('php/mvc/ActionServer.cls.php');
?>