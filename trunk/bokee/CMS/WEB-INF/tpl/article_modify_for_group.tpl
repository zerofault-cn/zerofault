<?php
/**
 * article_modify.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('article_modify_for_group.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign($response['article']);
$tpl->assign('script', $response['script']);
$tpl->assign('coop_media', $response['coop_media']);
$tpl->assign('special', $response['special']);
$tpl->assign('special_subject', $response['special_subject']);
$tpl->assign('special_subject_last', $response['special_subject_last']);
$tpl->assign('mark', $response['mark']);
$tpl->assign('comment', $response['comment']);
$tpl->assign('ad', $response['ad']);
$tpl->assign('group_list', $response['group_list']);
$tpl->assign('jump_value', $response['jump_value']);
$tpl->assign('group_checked', $response['group_checked']);
$tpl->assign('group_not_checked', $response['group_not_checked']);
$tpl->assign('is_group_disabled', $response['is_group_disabled']);
$tpl->assign('html_auto_redirect', $response['html_auto_redirect']);
$tpl->output();
?>
