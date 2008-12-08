 <?php
/**
* HeaderModifyAction.cls.php
* @copyright bokee dot com
* @author zhangfang@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Subject.cls.php');
require_once('mod/Header.cls.php');

class HeaderModifyAction extends Action {
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
        $id = $request['id'];
        $subject = new Subject($db);
        $sortarray = $subject ->GetByID($subject_id);
        $sort = $subject ->GetSort();
        $subject_name = $subject ->GetName();
        $parent_id = $subject ->GetParentId();
        
        $header=new Header($db);
        $header->GetByID($id);
        
        if($sort>=2)
        {
        	$content = $header->GetContent();
        	$response['options']="<textarea name='content' cols='80' rows='20'>$content</textarea>";
        	
        }
        else 
        {
            $child_id = $header->GetChildId();
            $childs = explode("|",$child_id);
            $response['options'] = $this->getSubjectList($dao,$childs,$subject_id);
        }
        
        $response['sort'] = $sort; 
        $response['name'] = $header->GetName();    
        $response['subject_name'] = $subject_name;    
        $response['parent_id'] = $parent_id; 
        $response['subject_id'] = $subject_id;  
        $response['id'] = $id;          
        $response['channel_name'] = $channel_name; 
	}
   
	function getSubjectList($dao,$childs,$subject_id)
	{
		if($subject_id==0)
		    $sql = "SELECT id,name FROM subject WHERE sort='2'";
		else 		
	    $sql = "SELECT id,name FROM subject WHERE parent_id = ".$subject_id." and sort='2'";
		$rows = $dao->GetPlan($sql);	
		$rows_num = count($rows);
		for($i=0;$i<$rows_num;$i++)
		{   
			for($j=0;$j<count($childs);$j++)
			{
			      if($rows[$i]['id']==$childs[$j])					   
			      	 $rows[$i]['check']="checked";			         
			}
             $subject .= "<input name = subject[] type = 'checkbox' value = " . $rows[$i]['id'] ."   ". $rows[$i]['check'].">"  . $prefix . $rows[$i]['name'] . "<br>";			
			 //$subject .= $this->getSubjectList($dao, $rows[$i]['subject_id'], $childs, $prefix . "--");
		}
		
		return $subject;
	}	
}
?>