<?php
/**
* SubjectDoModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Subject.cls.php');

class SubjectDoModifyAction extends Action {
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
        
        $response['form']=$form;
        //print_r($form);
        $channel_name = $request['channel_name'];
         $db = "cms_" . $channel_name;
        
		
         // 对先前的错误进行处理
        if ( !$actionError->isEmpty() ){
            // 是系统错误吗？
            if ($actionError->getProp('sysError') != false){
                return $actionMap->findForward('sysError');
            }
            return $actionMap->findForward('failure');
        }        
			
        $id = intval($request['id']);
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);       
       	$subject = new Subject($db);
       	$subject->_name=$form['name'];
       	$subject->_dir_name=$form['dir_name'];
       	$subject->_parent_id=$form['parentid'];
        $subject->_category=$form['category'];
       	$subject->_id=$id;
       	
        $sql="SELECT sort FROM `subject` WHERE id=$form[parentid]";  
        $sort = $dao->GetCol($sql);
        $tmp=$sort[0]+1;
        $subject->SetSort($tmp);
        $subject->Update();
      
      if ( $subject->Update() )
        	 return "main.php?do=subject_list&channel_name=".$request['channel_name']."&channel_id=".$request['channel_id'];
	
       }  
}
?>