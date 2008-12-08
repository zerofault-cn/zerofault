<?php
/**
* CoopMediaModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/CoopMedia.cls.php');

class CoopMediaModifyAction extends Action {
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
         
		$id = intval($request['id']);
		$subject = new CoopMedia();
		$subject->GetByID($id);	
		
		$response['form']['name'] = $subject->GetName();
		$response['form']['url'] = $subject->GetUrl();
		$response['form']['linkman'] = $subject->GetLinkman();
		$response['form']['phone'] = $subject->GetPhone();
		$response['form']['id'] = $id;   

		
      
    }	
}
?>