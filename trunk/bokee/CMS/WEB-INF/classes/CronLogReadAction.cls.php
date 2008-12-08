<?php
/**
 * CronLogReadAction.cls.php
 * @copyright bokee dot com
 * @author yudunde@bokee.com
 * @version 0.1
 */
require_once('mvc/Action.cls.php');

class CronLogReadAction extends Action {
	/**
	 * 
	 * @access public
	 * @param array &$request
	 * @param array &$files
	 */
	function execute(&$actionMap,&$actionError,$request,&$response,$form){
		$file_name = "logs/cron-log-" . date('Y-m-d') . ".txt";
		$content = @file_get_contents($file_name);
		$response['data']['content'] = $content;
	}

}
?>
