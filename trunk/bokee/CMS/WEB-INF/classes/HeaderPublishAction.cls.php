<?php
/**
* HeaderPublishAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/Header.cls.php');
require_once('sql/DAO.cls.php');

class HeaderPublishAction extends Action {
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
        $id = intval($request['id']);
        $subject_id = empty($request['subject_id'])?0:$request['subject_id'];
        
        $header = new Header($db);
       // $header->SetSubjectId($subject_id);
        $header->GetByID($id);
        $header->SetChoice('Y');
//        $header->GetChildId(); 
 //       echo $this->_child_id;       
//        if(!empty($this->_child_id))
//        {
//        	$pieces = explode("|", $rows[$i]['child_id']);
//		    for($k=0;$k<count($pieces[$i]);$k++)
//		    { 		                  	  
//		          $sql="select * from header where subject_id=".$pieces[$i][$k]." and choice='Y'";
//	              $row=$this->_dao->GetRow($sql);	                          
//	              $content .= $row['content'];  	                         	    	
//		    }
//		     $header->SetContent($content);     	
//        }        	 
        $header->Update();
        $header->UpdateChoice();         
		$header->Publish();
		$header->ModifysubByID($subject_id);
		       return "main.php?do=header_list&channel_name=".$request['channel_name']."&channel_id=".$request['channel_id']."&subject_id=".$request['subject_id'];
	}
}
?>