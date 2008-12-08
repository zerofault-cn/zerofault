<?php
/**
* FlashDoEditNewAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/FTP.cls.php');
require_once('com/Log.cls.php');

class FlashDoEditNewAction extends Action {
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
        
        $files = $_FILES;
		$channel_name = $form['channel_name'];
		$id = intval($form['id']);
		//$path = $form['path'];//D:/GreenAMP/www/CMS/web/root/cms_sports/TICAO/SHUANGGANG/
		//$dir = substr($path, 0, strrpos($path, "/"));
		$dir = $form['path'];//D:/GreenAMP/www/CMS/web/root/cms_sports/TICAO/SHUANGGANG/
		$num = $form['num'];
		
		//print_r($_FILES['file0']);
		$file_num = count($files);
		//$ftp = new FTP($channel_name);

		for($i=0;$i<$num;$i++)
		{
			if($_FILES['file'.$i]['size']>0)
			{
				$img_src_array = explode( "/" ,$form['img_src'.$i] );
				$img_src_array_length = count( $img_src_array );
			    $path_local = $dir . $img_src_array[ $img_src_array_length-2 ] . "/" . $img_src_array[ $img_src_array_length-1 ];
				
				//echo $path_local = $dir . "/" . str_replace("web/root/cms_".$channel_name."/", "", $form['img_src'.$i]);
				
				if(file_exists($path_local))
				{
					unlink($path_local);
				}
				move_uploaded_file($_FILES['file'.$i]['tmp_name'], $path_local);
//				$path_remote = "/html" . str_replace(PATH_HTML_ROOT, "", $path_local);
//				if(!$ftp->Put($path_local, $path_remote)) 
//				{
//					Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 FTP上传文件 出错。remote_path:$path_remote, local_path: $path_local");
//					return false;
//				}
			}
		}

/*		$content = '<?xml version="1.0" encoding="utf-8"?>';
		$content .= '<pictures>	<picturesName>';
		for($i=0;$i<$num;$i++)
		{
			$img_src_array = explode( "/" ,$form['img_src'.$i] );
			$img_src_array_length = count( $img_src_array );
			$content .= "<pic>" . $img_src_array[ $img_src_array_length-2 ] . "/" . $img_src_array[ $img_src_array_length-1 ] . "</pic>";
			//$content .= "<pic>" . str_replace("web/root/cms_".$channel_name."/", "", $form['img_src'.$i]) . "</pic>";
		}
		$content .= '</picturesName><newsName>';
		for($i=0;$i<$num;$i++)
		{
			$content .= "<Name>" . $form['name'.$i] . "</Name>";
		}
		$content .= '</newsName><newsURL>';
		for($i=0;$i<$num;$i++)
		{
			$content .= "<URL>" . $form['url'.$i] . "</URL>";
		}
		$content .= '</newsURL></pictures>';
		$fp = fopen($path, 'w');
		fwrite($fp, $content);
		fclose($fp);

		$ftp = new FTP($channel_name);
		$path_remote = str_replace(PATH_HTML_ROOT, "/html", $path);
		Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 FTP上传文件 remote_path:$path_remote, local_path: $path");
		$ftp->Put($path, $path_remote);
		$ftp->Close();

		return "main.php?do=flash_edit&channel_name=$channel_name&id=$id";*/
    }
}
?>