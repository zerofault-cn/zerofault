<?php
/**
* SubjectAddAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Subject.cls.php');


class SubjectAddAction extends Action {
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
        
        $id = intval($request['id']);
        $channel_name = $request['channel_name'];
        $db = "cms_" . $channel_name;
        $response['channel_name'] = $channel_name;
        
        $dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db);
         
//		$sql = "select * from subject order by id asc";
//		$rows_subject_1 = $dao->GetPlan($sql);	
//		$num=sizeof($rows_subject_1);
//		for($i=0;$i<$num;$i++)
//		{
//			
//			if($rows_subject_1[$i]['id']==$id)
//			{
//				$rows_subject_1[$i]['selected'] = "selected";
//			}
//		}      
//       
//	 $response['subject_1'] = $rows_subject_1;
     
        $subject = new Subject($db);
		$subject->GetByID($id);
		$list=$subject->getSubject($subject->getSubjectList());
        
	    for($i=0;$i<count($list);$i++)
		{
			if($list[$i]['subid']==$id)
			{
				$list[$i]['selected']="selected";
			}
		}
		$response['subject_1'] = $list;
    }
}
?>