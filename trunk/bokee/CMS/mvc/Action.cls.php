<?php
/**
* Action.cls.php
* @copyright bokee dot com 
*/
/**
* Action
* @version 0.1
*/
//require_once ('mod/User.cls.php');

class Action {
    
    /**
    * 动作执行
    * @access public
    * @param array &$actionConfig
    * @param array &$request
    * @param array &$response
    * @param ActionError &$actionError ActionError Object
    * @param array &$files
    */
    function execute(&$actionMap,&$actionError,$request,&$response,$form){

        // 将所有需要显示的数据注入到$response数组中，包括$actionError中的数据
        // 返回一个 forward array
        //include_once('php/sql/MySQL.cls.php');
        //$db = MySQL::createInstance();
        // 事务处理
        // 将需要显示给用户的错误注入到 $response['action_erros'] 中
        // 给forward增加参数(在进行页面跳转时使用)
        // $actionMap->addParam2Forward('key_test','value_test','name_test');
        // 返回的forward是一个数组
        //return $actionMap->findForward('success');
        //return $actionMap->findForward('sysError');

	/* insert the authorization result with all executions */
	// protected 参数，Action的所有sub-class都拥有此变量。
	// 如果为false值，将返回权限不足提示。
	// 但是应该在列出菜单前现判断权限，以防止列出无权限操作
	// 这一步权限检查则特别为恶意操作而设置。

//	$u = new User;
//	$auth = $u->ValidatePerm($request);
//	if (! $auth) {
//		return $actionMap->findForward('authError');
//	}

    }
}
?>
