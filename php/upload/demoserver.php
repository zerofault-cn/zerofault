<?php 
// HTML_AJAX_Server class 
require_once 'HTML/AJAX/Server.php'; 

// UploadProgressMeter class were exporting 
require_once 'UploadProgressMeterStatus.class.php'; 

$server = new HTML_AJAX_Server(); 

$status = new UploadProgressMeterStatus(); 

// were registering class and method name by hand so we don't run into php4/5 case compat problems 
$server->registerClass($status,'UploadProgressMeterStatus',array('getStatus')); 

$server->handleRequest(); 
?> 
