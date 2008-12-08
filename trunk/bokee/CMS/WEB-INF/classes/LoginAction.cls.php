<?php
/**
* LoginAction.cls.php
* @copyright bokee dot com
*/

require_once("mod/User.cls.php");
require_once('mvc/Action.cls.php');

/**
* LoginAction
* 处理登录请求
* @author yudunde@bokee.com
* @version 0.1
*/
class LoginAction extends Action {
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
        
        // 如果没有提交表单
        if ( empty($form)  ){
            $response['data']['back_url'] = $request['back_url'];
            return $actionMap->findForward('failure');
        }
        
        $response['form'] = $form;
        // 对先前的错误进行处理
        if ( !$actionError->isEmpty() ){
            // 是系统错误吗？
            if ($actionError->getProp('sysError') != false){
                return $actionMap->findForward('sysError');
            }
            return $actionMap->findForward('failure');
        }
               
        $username = $form['username'];
        $password = md5($form['password']);
        
        $user = new User();
        $result = $user->GetByNamePassword($username, $password);
	# 这个结果以后由Permit::logon($username, $password)给出
        
        if (!$result){            
			$actionError->add('action_error_notice',"$form[username],$form[password],md5($form[password],密码错误");
			return $actionMap->findForward('failure');
        }
        
        if ( !empty($form['back_url']) ){
            return $form['back_url'];
        }
        return $actionMap->findForward('success');
	}
}
?>
