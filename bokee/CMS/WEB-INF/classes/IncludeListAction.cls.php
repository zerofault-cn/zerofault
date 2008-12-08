<?php
/**
* IncludeListAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');


class IncludeListAction extends Action {
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
        //把要读取的目录的全路径名存入一个名字为$dir_name的变量中
        
        
       $channel_name = $request['channel_name'];
       $response['channel_name'] = $channel_name;
       
       $dir_name = PATH_HTML_ROOT."/cms_".$channel_name."/include";
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
    	        if(!$file_name_elements[2]==txt)
    	        {
                   $file_list[$i]['fileid']="$i";
                   $file_list[$i]['filename']="$file_name";
                   $file_list[$i]['channel_name']="$channel_name";
                   $file_text=PATH_HTML_ROOT."/cms_".$channel_name."/include/".$file_list[$i]['filename'].".txt";                                 
                   $content=@file_get_contents($file_text);
                   $file_list[$i]['text']="$content";
                   $i++;
    	        }   	        
            }
    }
          
      $response['$file_list'] = $file_list;
      //关闭打开的目录，结束PHP模块//    
      @closedir($dir);

	}
}
?>