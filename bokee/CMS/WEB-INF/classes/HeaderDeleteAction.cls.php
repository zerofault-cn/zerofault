<?php
/**
* HeaderDeleteAction.cls.php
* @copyright bokee dot com
* @author zhangfang@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Header.cls.php');

class HeaderDeleteAction extends Action {
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
        $db = "cms_" . $channel_name;
        $subject_id = intval($request['subject_id']);
        $id = intval($request['id']);        
        if($subject_id>0)
        {
       		$header = new Header($db);
   		
       		$header->GetByID($id);
       		$choice = $header->GetChoice();
       		$header->DeleteByID($id);  
       		if($choice=='Y')
       		{
       	         $header->ModifySsubByID($subject_id);
       		     $header->DeletesubByID($subject_id);
       		}

        }
        return "main.php?do=header_list&channel_name=".$request['channel_name']."&subject_id=".$request['subject_id'];        
    }	
}
?>