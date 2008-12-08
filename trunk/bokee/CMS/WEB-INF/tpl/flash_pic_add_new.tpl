<?php
/**
 * flash_add.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('flash_pic_add_new.html');
$tpl->assign('flash_path',$response['flash_path']);
$tpl->assign('channel_name',$response['channel_name']);
$tpl->assign('flash_id',$response['flash_id']);
$tpl->output();
?>