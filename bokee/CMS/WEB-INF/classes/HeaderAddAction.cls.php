<?php
/**
* HeaderAddAction.cls.php
* @copyright bokee dot com
* @author zhangfang@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Subject.cls.php');


class HeaderAddAction extends Action {
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
	    $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
		$response['channel_name'] = $channel_name;
        $subject_id = $request['subject_id'];
        $subject = new Subject($db);
        $sortarray = $subject ->GetByID($subject_id);
        $sort = $subject ->GetSort();
        $name = $subject ->GetName();
        $parent_id = $subject ->GetParentId();

        if($sort>=2)
        {
        	$response['options']="<textarea name='content' cols='80' rows='20'></textarea>";
        	
        }
        else 
        $response['options'] = $this->getSubjectList($dao,$subject_id);
        
        $response['sort'] = $sort; 
        if($subject_id==0)
           $response['subject_name'] = $channel_name."频道";  
        else
        $response['subject_name'] = $name;    
        $response['parent_id'] = $parent_id;  
        $response['subject_id'] = $subject_id;  
        $response['channel_name'] = $channel_name; 
	}
	
	function getSubjectList($dao,$subject_id)
	{	
		if($subject_id==0)
		    $sql = "SELECT id,name FROM subject WHERE sort='2'";
		else 		
	    $sql = "SELECT id,name FROM subject WHERE parent_id = ".$subject_id." and sort='2'";
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		for($i=0;$i<$rows_num;$i++)
		{   		   
			$subject .= "<input name = subject[] type = 'checkbox' value = \"" . $rows[$i]['id'] .  "\">"  .  $rows[$i]['name'] . "<br>";			
		}
		return $subject;
//		//$sql = "SELECT id,subject_id,name FROM header WHERE parent_id = ".$parent_id." ORDER BY id,parent_id DESC";
//		if($subject_id==0)
//		    $sql = "SELECT id,subject_id,name FROM header WHERE parent_id <> '0' and choice='Y'";
//		else 
//		    $sql = "SELECT id,subject_id,name FROM header WHERE parent_id = ".$subject_id." and choice='Y'";
//		$rows = $dao->GetPlan($sql);
//		$rows_num = count($rows);
//		for($i=0;$i<$rows_num;$i++)
//		{   		   
//			$subject .= "<input name = subject[] type = 'checkbox' value = \"" . $rows[$i]['id'] .  "\">"  .  $rows[$i]['name'] . "<br>";
//			//$subject .= $this->getSubjectList($dao, $rows[$i]['subject_id'],$prefix . "--");
//		}
//		return $subject;
	}
}