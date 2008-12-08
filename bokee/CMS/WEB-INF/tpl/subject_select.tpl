<?php
/**
 * subject_selelct.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liangbiquan@bokee.com
**/
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('subject_select.html');
$tpl->assign('subjects',$response['subjects']);

$tpl->output();

?>