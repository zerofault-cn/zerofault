<?php
/**
 * coopmedia_list.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('coop_media_list.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('coopmedia',$response['coopmedia']);
$tpl->assign('pagebar', $response['pagebar']);
$tpl->assign('p', $response['p']);
$tpl->output();
?>