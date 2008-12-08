<?php
/**
* UserDoModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/User.cls.php');

class UserDoModifyAction extends Action {
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

        $dao = DAO::CreateInstance();
		$id = intval($form['id']);
       	$user = new User();
		$user->GetByID($id);
        
	// 对先前的错误进行处理
        if ( !$actionError->isEmpty() ){
	    // 是系统错误吗？
            if ($actionError->getProp('sysError') != false){
                return $actionMap->findForward('sysError');
                
            }
            
		$sql = "select * from channel";
		//$sql = "select c.* from channel c, user_channel uc where uc.user_id=" . $id . " and c.id=uc.channel_id";
		$channel = $dao->GetPlan($sql);
		
		
		$user = new User();
		$user->GetByID($id);
		$rows = $user->GetChannelIDs();
		$channel_num = count($channel);
		$rows_num = count($rows);
		for($i=0;$i<$channel_num;$i++)
		{
			for($j=0;$j<$rows_num;$j++)
		    {					    			    	
			     if ($channel[$i]['id'] == $rows[$j]['channel_id']) {
				     $channel[$i]['checked'] = "checked";
			     }
			}
		    $j=$i+1;
			if($j%5 ==0)
			{
				$channel[$i]['br'] = "<br>";
			}
		} 
		$response['channel'] = $channel;
		            
           // $sql = "select c.* from channel c, user_channel uc where uc.user_id=" . $id . " and c.id=uc.channel_id";
			//$channel = $dao->GetPlan($sql);
            $response['channel'] = $channel;
            $role = array();
            for ($i=0;$i<5;$i++)
            {
            	$role[$i]['id'] = $i;
            	$role[$i]['name'] = $user->GetRoleName($i);
            	if ( $role[$i]['id'] == $form['role_name'] ) {
            		$role[$i]['selected'] = "selected";
            	}
            }
            $response['role'] = $role;
            $response['form'] = $form;
            return $actionMap->findForward('failure');
        }
			
        //修改用户处理
	
		$user->SetName($form['username']);
		$user->SetRealName($form['real_name']);
		$user->SetCellphone($form['cellphone']);
		$user->SetRoleId($form['role_name']);
		$user->SetEmail($form['email']);
	
		//修改频道权限
	
		$channel_id = $request['select_channel'];
		$delete_clause = "delete from user_channel where user_id=$id";
		$dao->Query($delete_clause);
		for($k=0;$k<count($channel_id);$k++)
		{   
			echo $insert_clause = "insert into user_channel set user_id = " . $id . ", channel_id = '$channel_id[$k]'";
			if(!$dao->Insert($insert_clause))
			{
				 return -1;	
			 }
	    }
		
		if($user->Update())
		{
			return $actionMap->findForward('success');
		}
		else 
        	return $actionMap->findForward('sysError');
	}

}
?>
