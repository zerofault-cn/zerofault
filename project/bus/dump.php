<?php 
// +----------------------------------------------------------------------
// | ThinkPHP                                                             
// +----------------------------------------------------------------------
// | Copyright (c) 2008 http://thinkphp.cn All rights reserved.      
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>                                  
// +----------------------------------------------------------------------
// $Id$

// ����ThinkPHP���·��
define('THINK_PATH', '../ThinkPHP/ThinkPHP');
//������Ŀ���ƣ���������壬Ĭ��Ϊ����ļ�����
define('APP_NAME', 'admin');
define('APP_PATH', './admin');
// ���ؿ�ܹ�������ļ� 
require(THINK_PATH."/ThinkPHP.php");

define('CLI',true);
define('MODULE_NAME','Index');
define('ACTION_NAME','dump');
//ʵ����һ����վӦ��ʵ��
$App = new App();
//Ӧ�ó����ʼ��
$App->run();
?>