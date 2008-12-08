<?php
/**
* FlashPicDeleteNewAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
 require_once('com/FTP.cls.php');

class FlashPicDeleteNewAction extends Action {
	/**
    * 
    * @access public
    * @param array &$request
    * @param array &$files
    */
    function execute(&$actionMap,&$actionError,$request,&$response,$form){
        // 事务处理
        // 将需要显示给用户的错误注入到 $response['action_erros'] 中
        // 给forward增加参数(在进行页面跳转时使用)
        // $actionMap->addForwardParam('key_test','value_test','name_test');
        // 返回的forward是一个数组
        //return $actionMap->findForward('success');
        //return $actionMap->findForward('sysError');   
        
        $channel_name = $request['channel_name'];
        $response['data']['channel_name'] = $channel_name;

        echo $_REQUEST['img_src'];
        @unlink($_REQUEST['img_src']);//删除文件	
 /*       $xml = file_get_contents( $path );
        $count_pics = preg_match_all( "/<pic>(.*?)<\/pic>/i", $xml, $pics, PREG_PATTERN_ORDER );
        $count_names = preg_match_all( "/<name>(.*?)<\/name>/i", $xml, $names, PREG_PATTERN_ORDER );
        $count_urls = preg_match_all( "/<url>(.*?)<\/url>/i", $xml, $urls, PREG_PATTERN_ORDER );

		$content = '<?xml version="1.0" encoding="utf-8"?>';
		$content .= '<pictures>	<picturesName>';

		//图片地址
		for($i=0;$i<$count_pics;$i++)
		{
			if( $pic_id == $i )
			{
				continue;
			}
			else
			{
				$content .= $pics[0][$i];
			}
		
		}
		$content .= '</picturesName><newsName>';

		//图片名称
		for($i=0;$i<$count_names;$i++)
		{
			if( $pic_id == $i )
			{
				continue;
			}
			else
			{
				$content .= $names[0][$i];
			}
		
		}
		$content .= '</newsName><newsURL>';

		//链接地址
		for($i=0;$i<$count_urls;$i++)
		{
			if( $pic_id == $i )
			{
				continue;
			}
			else
			{
				$content .= $urls[0][$i];
			}
		
		}
		$content .= '</newsURL></pictures>';
		$fp = fopen( $path,"w" );
		fwrite( $fp,$content );
		fclose( $fp );

		$ftp = new FTP($channel_name);
		$path_remote = str_replace(PATH_HTML_ROOT, "/html", $path);
		Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 FTP上传文件 remote_path:$path_remote, local_path: $path");
		$ftp->Put($path, $path_remote);
		$ftp->Close();*/


		return "main.php?do=flash_edit_new&channel_name=$channel_name&id=".$request['flash_id'];


    }
    
 
}
?>