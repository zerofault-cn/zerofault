<?php
/**
* CoopMediaDoAddAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/CoopMedia.cls.php');
require_once('mod/User.cls.php');

class CoopMediaDoAddAction extends Action {
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

        if ( !$actionError->isEmpty() ){
            // 是系统错误吗？
            if ($actionError->getProp('sysError') != false){
                return $actionMap->findForward('sysError');
            }
            $response['form'] = $form;
            return $actionMap->findForward('failure');
        }
			
        //添加合作媒体处理
		$coopmedia = new CoopMedia();
		$coopmedia->SetName($form['name']);
		$coopmedia->SetUrl($form['url']);
	    $coopmedia->SetLinkman($form['linkman']);
		$coopmedia->SetPhone($form['phone']);
		if($coopmedia->Insert() == -1)
		{
			return $actionMap->findForward('sysError');
		}
		else 
        	return $actionMap->findForward('success');
	}

}
?>