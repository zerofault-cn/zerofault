<?php
/**
* FlashEditNewAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');

class FlashEditNewAction extends Action {
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
        $sql = "select * from flash where id=$id";
        $row = $dao->GetRow($sql);    
        $response['data']['name'] = $row['name'];
        $path_ori = $row['upload_path'];//D:/GreenAMP/www/CMS/web/root/cms_sports/TICAO/SHUANGGANG/
      
       // $dir_name = $path_ori ."pictures";
        $dir_name = $row['pic_dir'];
       // 创建一个句柄，其值是打开一个给定目录的结果
        $dir = @opendir($dir_name);
       //建立一个文字块，用以放置列表元素（文件名字）
        $file_list = array();
        $i=0;
        //使用一个while语句，读取已经打开的目录中的所有元素，如果文件的名字不是“.”或“..”，则显示列表中的名字
        while ($file_name = @readdir($dir)) {
            if (($file_name != ".") && ($file_name != "..")) {   
            	$file_name_elements = explode("." ,$file_name);
            	//print_r($file_name_elements); 
    	        //$num=sizeof($file_name_elements);    	      
    	        if(($file_name_elements[1]=="jpg")||($file_name_elements[1]=="png")||($file_name_elements[1]=="gif"))
    	        {
                 
                   $img['img_id']="$i";
                   $img['img_name']="$file_name";
                   $img_path = $dir_name."/".$file_name;
                   $img['img_src'] = str_replace(PATH_MODULE . "/", "", $img_path);
                   $img['channel_name'] = $channel_name;
                   $img['flash_id'] = $id;
                   $images[] = $img;
//                   $file_list[$i]['channel_name']="$channel_name";
//                   $file_text=PATH_HTML_ROOT."/cms_".$channel_name."/include/".$file_list[$i]['filename'].".txt";                                 
//                   $content=@file_get_contents($file_text);
//                   $file_list[$i]['text']="$content";
                  $i++;
    	        }   	        
            }
    }
     //print_r($images);     
      $response['$file_list'] = $file_list;
      //关闭打开的目录，结束PHP模块//    
      @closedir($dir);
//        $path = PATH_HTML_ROOT . "/" . $db . "/" . $path_ori;
//        $response['data']['path'] = $path;
//        
//        $xml_path = $path_ori . $row['xml_name'];
//        $xml = file_get_contents($xml_path);
//        $count_pics = preg_match_all("/<pic>(.*?)<\/pic>/i", $xml, $pics);
//        $count_names = preg_match_all("/<name>(.*?)<\/name>/i", $xml, $names);
//        $count_urls = preg_match_all("/<url>(.*?)<\/url>/i", $xml, $urls);
//        $response['data']['num'] = $count_names;

//		$images = array();
//		for($i=0;$i<$count_names;$i++)
//		{
//			$img_path = $path_ori . $pics[1][$i];//D:/GreenAMP/www/CMS/web/root/cms_sports/TICAO/SHUANGGANG/pictures/28102823482.jpg
//			$img['img_src'] = str_replace(PATH_MODULE . "/", "", $img_path);//web/root/cms_sports/TICAO/SHUANGGANG/pictures/28102823482.jpg
//			$img['name'] = $names[1][$i];
//			$img['url'] = $urls[1][$i];
//			$img['id'] = $i;
//			$img['channel_name'] = $channel_name;
//			$img['pic_id'] = $i;
//			$img['path'] = urlencode( $path_ori );
//			$img['flash_id'] = $id;
//			$images[] = $img;
//		}
		
		//print_r($images);
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
//		$response['root_path'] = PATH_HTML_ROOT . "/" . $db . "/" . $path_ori;
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