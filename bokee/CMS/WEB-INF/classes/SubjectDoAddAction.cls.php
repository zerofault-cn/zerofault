<?php
/**
* ArticleDoAddAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Subject.cls.php');
require_once('mod/User.cls.php');

class SubjectDoAddAction extends Action {
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
		
		$channel_name = $form['channel_name'];
        $db = "cms_" . $channel_name;
            
       	// print_r($form);
        // 对先前的错误进行处理
        if ( !$actionError->isEmpty() ){
            // 是系统错误吗？
            if ($actionError->getProp('sysError') != false){
                return $actionMap->findForward('sysError');
            }
            $response['form']=$form;
            //获取一级栏目
            
            $dao = DAO::CreateInstance();
            $dao->SetCurrentSchema($db);
            $sql = "select * from subject where sort=1 order by id asc";
            $rows_subject_1 = $dao->GetPlan($sql);
            $response['subject_1'] = $rows_subject_1;
		
            return $actionMap->findForward('failure');
        }
			
         //添加栏目处理
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
        $subject = new Subject($db);
        $subject->SetName($form['name']);
        $subject->SetDirName($form['dir_name']);
        $subject->SetParentId($form['parentid']); 
        $subject->SetCategory($form['cateid']);        
        $sql="SELECT sort FROM `subject` WHERE id=$form[parentid]";  
        $sort = $dao->GetCol($sql);
        $tmp=$sort[0]+1;
        if($form['parentid']==0)
            $subject->SetSort(1);
        else 
            $subject->SetSort($tmp);
        
        if ( $subject->Insert() )
        	 return "main.php?do=subject_list&channel_name=".$request['channel_name']."&channel_id=".$request['channel_id'];
	}

}
?>