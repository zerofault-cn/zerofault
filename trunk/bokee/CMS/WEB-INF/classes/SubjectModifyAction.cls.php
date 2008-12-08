<?php
/**
* SubjectModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Subject.cls.php');

class SubjectModifyAction extends Action {
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
        $response['channel_name'] = $channel_name;      
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
        
		$id = intval($request['id']);
		$subject = new Subject($db);
		$subject->GetByID($id);
		$list=$subject->getSubject($subject->getSubjectList());
		
		$sql = "select parent_id from subject where id=$id";
		$pid = $dao->GetOne($sql);		
		for($i=0;$i<count($list);$i++)
		{
			if($list[$i]['subid']==$pid)
			{
				$list[$i]['selected']="selected";
			}
		}
		
		$cateid=$subject->GetCategory();
		$categorylist=array();
		if($cateid==0)
		{
                 $categorylist = array (
                            "0"  => array ( "id" => "0",
                                       "catename" => "只显示此栏目下文章",
                                       "selected"=>"selected"                                    
                                     ),
                            "1"  => array ( "id" => "1",
                                      "catename" => "全频道文章滚动"                                                                        ),
                );
		}
		else{
                 $categorylist = array (
                            "0"  => array ( "id" => "0",
                                       "catename" => "只显示此栏目下文章"                                                          ),
                            "1"  => array ( "id" => "1",
                                      "catename" => "全频道文章滚动",   
                                      "selected"=>"selected"                                                                       ),
                );
		}				

        $response['list']=$list;
		$response['name'] = $subject->GetName();
		$response['dir_name'] = $subject->GetDirName();				
        $response['id'] =$id;
        $response['categorylist'] = $categorylist;	      
    }	
}
?>