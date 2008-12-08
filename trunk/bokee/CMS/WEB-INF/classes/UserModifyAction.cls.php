<?php
/**
* UserModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/User.cls.php');

class UserModifyAction extends Action {
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
		$id = intval($request['id']);
		$user = new User();
		$user->GetByID($id);
		$roleid = $user->GetRoleId();
		
		//处理用户权限
		$role = array();
		for ($i=0;$i<5;$i++)
		{
			$role[$i]['id'] = $i;
			$role[$i]['name'] = $user->GetRoleName($i);
			
			if ( $role[$i]['id'] == $roleid ) {
				$role[$i]['selected'] = "selected";
			}
		}
		
	
		$sql = "select * from channel";
		//$sql = "select c.* from channel c, user_channel uc where uc.user_id=" . $id . " and c.id=uc.channel_id";
		$channel = $dao->GetPlan($sql);
		
		

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
		

		$response['role'] = $role;
		$response['form']['username'] = $user->GetName();
		$response['form']['cellphone'] = $user->GetCellphone();
		$response['form']['email'] = $user->GetEmail();
		$response['form']['real_name'] = $user->GetRealName();
		$response['form']['id'] = $user->GetId();
		
        
	}
}
?>