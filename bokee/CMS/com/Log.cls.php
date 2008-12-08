<?PHP
/**
 * Log.cls.php
 * @copyright bokee dot com
 * @version 0.1
 */
class Log {
	/**
	* append content to file
	* @access public
	* @param string $content content will be written
	* @param int $level log level
	* @return bool
	*/
	function Append( $content, $level=0){
		$today = date('Y-m-d');
		$log_path = "";
		$time = date('H:i:s');
		$content = $time . "\r\n" . $content . "\r\n";
		switch ($level)
		{
			case 0 :
			default:
			$log_path = PATH_MODULE . "/logs/op-log-" . $today . ".txt";
			break;
		}
			
		if (!$handle = @fopen($log_path, 'a+')) {
			return false;
		}
		if (!fwrite($handle, $content)) {
			return false;
		}
		fclose($handle);
		return true;
	}
	
	function AppendCron( $content, $level=0){
		$today = date('Y-m-d');
		$log_path = "";
		$time = date('H:i:s');
		$content = $time . "\r\n" . $content . "\r\n";
		switch ($level)
		{
			case 0 :
			default:
			$log_path = PATH_MODULE . "/logs/cron-log-" . $today . ".txt";
			break;
		}
			
		if (!$handle = @fopen($log_path, 'a+')) {
			return false;
		}
		if (!fwrite($handle, $content)) {
			return false;
		}
		fclose($handle);
		return true;
	}
}
?>