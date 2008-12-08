<?php
/**
 * rss_article_list_serch.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author tom@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('rss_article_list_serch.htm');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('subject_id', $response['subject_id']);
$tpl->assign('channel_name', $response['channel_name']);
$tpl->assign('pagebar', $response['pagebar']);
$tpl->assign('p', $response['p']);

$tpl->assign('Serch_condition', $response['Serch_condition']);
$tpl->assign('Serch_content', $response['Serch_content']);
$tpl->assign('Option', $response['Option']);

$tpl->assign('rss_end', $response['rss_end']);
$tpl->assign('rss_begin', $response['rss_begin']);
$tpl->assign('p_rss', $response['p_rss']);
$tpl->assign('pagebar_rss', $response['pagebar_rss']);
$tpl->assign('articles_rss',$response['articles_rss']);
$tpl->output();
?>