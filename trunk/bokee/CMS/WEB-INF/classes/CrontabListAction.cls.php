<?php
/**
* CrontabListAction.cls.php
* @copyright bokee dot com
* @author zhangfang@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');


class CrontabListAction extends Action {
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
//       $dir_name = ".\crontab";
//      // 创建一个句柄，其值是打开一个给定目录的结果
//       $dir = opendir($dir_name);
//      //建立一个文字块，用以放置列表元素（文件名字）
//      $file_list = array();
//      $i=0;
//      //使用一个while语句，读取已经打开的目录中的所有元素，如果文件的名字不是“.”或“..”，则显示列表中的名字
//      while ($file_name = readdir($dir)) {
//            if (($file_name != ".") && ($file_name != "..")) {       	
//                //$file_list [$i]= "$file_name";
//                //$file_list [$i]=$array();
//                $file_list[$i]['fileid']="$i";
//                $file_list[$i]['filename']="$file_name";
//                $i++;
//                }
//      }
//     
//      $response['$file_list'] = $file_list;
//      //关闭打开的目录，结束PHP模块//
//      closedir($dir);

	}
}
?>