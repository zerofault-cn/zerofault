<?php
/**
* HeaderDoModifyAction.cls.php
* @copyright bokee dot com
* @author zhangfang@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Header.cls.php');

class HeaderDoModifyAction extends Action {
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

        if ( !$actionError->isEmpty() ){
            // 是系统错误吗？
            if ($actionError->getProp('sysError') != false){
                return $actionMap->findForward('sysError');
            }
            $response['form'] = $form;
            return $actionMap->findForward('failure');
        }
		
        $channel_name = $request['channel_name'];
		$db = "cms_" . $channel_name;
		$response['channel_name'] = $channel_name;	
		$sort = $request['sort'];
		$id = $request['id'];		
		$header = new Header($db);
		$header->SetId($id);
		$header->GetByID($id);		
	    $header->SetSubjectId($form['subject_id']);
	    
	    $header->SetParentId($form['parent_id']);
        $datetime = date('Y-m-d H:i:m',time());
        $header->SetUpdateDate($datetime);
        $header->SetName($form['name']);
		if($sort >= 2)
		{
			$header->SetContent($form['content']);
            $header->SetUpdateDate($datetime);  
            $header->SetId($id);  
            $header->Update();
           	$header->ModifysubByID($form['subject_id']);	 
		}
		else
		 {
			 $subject = $request['subject'];
			 $num = count($subject);
			 for($i=0;$i<$num;$i++)
			 {		
                $sql = "select * from header where subject_id=$subject[$i] and choice='Y'";
                $rows = $header->Query($sql);
                print_r($rows);
		        $content .= $rows [0]['content']; 
		        if($i<$num-1)	        
                   $child_id .= $subject[$i]."|";
                else 
                   $child_id .= $subject[$i];
			 } 
			 $header->SetId($id);
			 $header->SetContent($content);
			 $header->SetChildId($child_id);
			 $header->Update();
		 }		
	    return "main.php?do=header_list&channel_name=".$request['channel_name']."&channel_id=".$request['channel_id']."&subject_id=".$request['subject_id'];
	}
}
?>