<?php
/**
* FlashEditAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');

class FlashEditAction extends Action {
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
        $db = "cms_" . $channel_name;
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
        $id = intval($request['id']);
        $response['data']['id'] = $id;
        $sql = "select * from flash_images where id=$id";
        $row = $dao->GetRow($sql);
        $response['data']['name'] = $row['name'];
        $path_ori = $row['path'];
        $path = PATH_HTML_ROOT . "/" . $db . "/" . $path_ori;
        $response['data']['path'] = $path;
 
        $xml = file_get_contents($path);
        $count_pics = preg_match_all("/<pic>(.*?)<\/pic>/i", $xml, $pics);
        $count_names = preg_match_all("/<name>(.*?)<\/name>/i", $xml, $names);
        $count_urls = preg_match_all("/<url>(.*?)<\/url>/i", $xml, $urls);
        $response['data']['num'] = $count_names;

		$images = array();
		for($i=0;$i<$count_names;$i++)
		{
			$img_path = substr($path, 0, strrpos($path, "/")) . "/" . $pics[1][$i];
			$img['img_src'] = str_replace(PATH_MODULE . "/", "", $img_path);
			$img['name'] = $names[1][$i];
			$img['url'] = $urls[1][$i];
			$img['id'] = $i;
			$img['channel_name'] = $channel_name;
			$img['pic_id'] = $i;
			$img['path'] = urlencode( $path_ori );
			$img['flash_id'] = $id;
			$images[] = $img;
		}
		
//        $images = array();
//        if(is_dir($path))
//        {
//        	$d = dir($path);
//			while (false !== ($entry = $d->read())) {
//			    if($entry!="." && $entry!="..")
//			    {
//			    	$arr['name'] = $entry;
//			    	$arr['img_src'] = str_replace(PATH_MODULE . "/", "", $path . "/" . $entry);
//			    	$images[] = $arr;
//			    }
//			}
//			$d->close();
//        }
//        else 
//        {
//        	$this->Mkdir($path);
//        }
        $response['data']['images'] = $images;
		$response['path'] = $path_ori;
		$response['root_path'] = PATH_HTML_ROOT . "/" . $db . "/" . $path_ori;
		$response['flash_id'] = $id;
	}
    
    function Mkdir($dir)
	{
		$dir = trim($dir, '/');
		$dir_array = split('/', $dir);
		$dir_array_depth = count($dir_array);
		$dir = "";
		for($i=0;$i<$dir_array_depth;$i++)
		{
			$dir .= "/" . $dir_array[$i];
			if(!is_dir($dir))
			{
				mkdir($dir);
			}
		}
	}
}
?>
