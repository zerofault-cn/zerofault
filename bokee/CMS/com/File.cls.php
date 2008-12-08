<?PHP
/**
 * File.cls.php
 * @copyright bokee dot com
 * @version 0.1
 */
class File {
	/**
	* 取得文件的扩展名
	* @access public
	* @param $filename file name
	* @return string file extense name
	*/
	function getExt($filename){
		$ext = substr( strrchr($filename,'.'), 1 );
		return $ext;
	}
	/**
	* append content to file
	* @access public
	* @param string $content content will be writed inot file
	* @param string $filePath file
	* @param string $mode opearate mode
	* @return string return '' when success, return description string when fail
	*/
	function writeContent( $content, $filePath, $mode='a+' ){
		
		if ( !file_exists($filePath) || is_writable($filePath) ) {
			
			if (!$handle = @fopen($filePath, $mode)) {
				return "can't open file $filePath";
			}
			
			if (!fwrite($handle, $content)) {
				return "cann't write into file $filePath";
			}
			
			fclose($handle);
			return '';
		
		} else {
			return "file $filePath isn't writable";
		}
	}
    /**
     * 
     * @access public
     * @param string $rsFile 文件路径
     * @param string $rsOption
     * @return string|boolean
     */
    function readContent( $rsFile, $rsOption = 'wt' ) {
        return @file_get_contents($rsFile,$rsOption);
    }
}
?>