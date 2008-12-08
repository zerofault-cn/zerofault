<?php
/**
 * article_add.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('article_add.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('subject_id', $response['subject_id']);
$tpl->assign('channel_name', $response['channel_name']);
$tpl->assign('script', $response['script']);
$tpl->assign('coop_media', $response['coop_media']);
$tpl->assign('special', $response['special']);
$tpl->assign('special_subject', $response['special_subject']);
$tpl->assign('special_subject_last', $response['special_subject_last']);
$tpl->assign('mark', $response['mark']);
$tpl->assign('comment', $response['comment']);
$tpl->assign('ad', $response['ad']);
$tpl->assign('jump', $response['jump']);
$tpl->assign('media', $response['media']);
$tpl->assign('group_list', $response['group_list']);
$tpl->output();
?>