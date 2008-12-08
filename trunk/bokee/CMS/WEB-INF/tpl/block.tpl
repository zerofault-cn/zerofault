<?php
/**
 * block.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liut@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('block.html');
//$tpl->assign($response['action_error']);
//$tpl->assign($response['form']);
//$tpl->assign($response['data']);

$tpl->assign('SOURCES', $response['source']);
$tpl->assign('FIELDS', $response['field']);
$tpl->assign('JS', $response['js']);


$tpl->assign('TITLE', $response['stage']);

$tpl->assign('subject', $response['html']['subject']);
$tpl->assign('special', $response['html']['special']);
$tpl->assign('field', $response['html']['field']);
$tpl->assign('orderBy', $response['html']['orderBy']);
$tpl->assign('mark', $response['html']['mark']);
$tpl->assign('subject', $response['html']['subject']);

$tpl->assign('ASC', $response['html']['value']['content_asc']);
$tpl->assign('DESC', $response['html']['value']['content_desc']);


$tpl->assign('BLOCK_ID', $response['html']['value']['block_id']);
$tpl->assign('BLOCK_NAME', $response['html']['value']['block_name']);
$tpl->assign('BLOCK_FORMAT', $response['html']['value']['block_format']);
$tpl->assign('LIMIT', $response['html']['value']['content_limit']);

$tpl->assign('CHANNEL_NAME',$response['channel_name']);

$tpl->output();

?>