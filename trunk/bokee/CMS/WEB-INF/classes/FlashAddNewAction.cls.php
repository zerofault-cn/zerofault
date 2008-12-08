<?php
/**
* FlashAddNewAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');

class FlashAddNewAction extends Action {
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
		//$id = intval($request['$id']);
        //echo "id=$id";
        //echo $id = intval($request['$id']);
        $channel_name = $request['channel_name'];
        $response['data']['channel_name'] = $channel_name;
        $subject_id = $request['subject_id'];
        $response['subject_id'] = $subject_id;    
          
    }
}