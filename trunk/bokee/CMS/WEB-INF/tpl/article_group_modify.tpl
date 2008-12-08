<?php
/**
 * article_group_modify.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('article_group_modify.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('channel_name',$response['channel_name']);
$tpl->assign('subject_id',$response['subject_id']);
$tpl->assign('group_name',$response['group_name']);
$tpl->assign('url',$response['url']);
$tpl->assign('photo_selected',$response['photo_selected']);
$tpl->assign('article_selected',$response['article_selected']);
$tpl->assign('id',$response['id']);
$tpl->output();
?>