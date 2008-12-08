<?php
/**
* CoopMediaDoModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/CoopMedia.cls.php');

class CoopMediaDoModifyAction extends Action {
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
		
         // 对先前的错误进行处理
        if ( !$actionError->isEmpty() ){
            // 是系统错误吗？
            if ($actionError->getProp('sysError') != false){
                return $actionMap->findForward('sysError');
            }
            $response['form']=$form;
            return $actionMap->findForward('failure');
        }        
			
        //$id = intval($request['id']);
		$coopmedia = new CoopMedia();
               
       	$coopmedia->_name=$form['name'];
       	$coopmedia->_url=$form['url'];
       	$coopmedia->_linkman=$form['linkman'];
       	$coopmedia->_phone=$form['phone'];
       	$coopmedia->_id=$form['id'];
        $coopmedia->Update();
       	if ( $coopmedia->Update() )
        	return $actionMap->findForward('success');
        else 
        	return $actionMap->findForward('sysError');
	
       }  
}
?>