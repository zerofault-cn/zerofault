<?php
/**
* IncludeModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');


class IncludeModifyAction extends Action {
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
        $filename=$request['filename']; 
        $channel_name=$request['channel_name'];  
        $file=PATH_HTML_ROOT."/cms_".$channel_name."/include/".$filename; 
        $content=file_get_contents($file);
        $response['form']['filename'] = $filename; 
        $response['form']['content'] = $content; 
        $response['channel_name'] = $channel_name; 
	}
}
?>