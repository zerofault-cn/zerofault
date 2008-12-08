<?php
/**
 * subject_selelct.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liangbiquan@bokee.com
**/
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('rss_article_transfer.html');
$tpl->assign('channel_list',$response['channel_list']);
$tpl->assign('rss_string',$response['rss_string']);
$tpl->assign('mark', $response['mark']);
$tpl->output();

?>