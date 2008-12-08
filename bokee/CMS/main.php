<?php
require_once('./WEB-INF/config.inc.php');
require_once('./com/Log.cls.php');
// ------------------ 记录开始运行时间 ----------------- //
if ( DEBUG ){
    require_once('mvc/utils/FileUtils.cls.php');
    $g_time_start = FileUtils::utime();
}
// ------------------ 限制仅能在公司登录 ----------------- //
//$ip_array = array("211.152.20.34", "218.249.35.66", "211.152.20.54", "127.0.0.1");
//if(!in_array($_SERVER['REMOTE_ADDR'], $ip_array))
//{
//	log::Append("非法登录请求，来自于：" . $_SERVER['REMOTE_ADDR']);
//	die("CMS系统仅能在公司内部使用!");
//}
// ------------------- 开始应用过程 --------------------- //
// init environment and congfiguration
$doPath = urldecode(trim($_REQUEST['do']));
if ($doPath == ''){$doPath = 'index';}
$actionConfig = new ActionConfig($ACTION_CONFIGS,$FORM_BEANS);
if (!$actionConfig->setCurrentPath($doPath)) exit('Path <b>'.$doPath.'</b> isn\'t defined');
// service
$actionServer = new ActionServer();
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $actionServer->init($actionConfig,$_REQUEST);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $actionServer->init($actionConfig,$_REQUEST,$_POST);
} else {
    exit('Only support get or post method');
}
$actionServer->process();
// -------------------- 结束应用过程 ----------------------- //

// ---------------- 计算并输出时间测试结果 ------------------- //
if ( DEBUG ){
    $g_time_end = FileUtils::utime();
    $run = $g_time_end - $g_time_start;
    $run = substr($run, 0, 5) . " secs.";
    print 'Time Cost: '.$run;
}
?>
