<?php
/**
* UserListAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/User.cls.php');
require_once('mod/Channel.cls.php');
require_once('com/Pager.cls.php');
require_once('com/Log.cls.php');

class UserListAction extends Action {
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
		if(!User::Authorize())
		{
			return $actionMap->findForward('login');
		}
		$dao = DAO::CreateInstance();
		
		$pageSize = 20;                                        	// how many  per page 
		$sql_all = "select count(*) as num from user"; 			// wenzhang zongshu
		$itemSum = $dao->GetOne($sql_all);
		$request['p'] = isset($request['p'])?$request['p']:1; 	// page number
		$request['p'] = (int)$request['p'];                   	// int number
		$request['p'] = ($request['p']<1)?1:$request['p'];
		$request['p'] = ($request['p']>ceil($itemSum/$pageSize))?ceil($itemSum/$pageSize):$request['p'];
		$currentPageNumber = $request['p'];
		$url = 'main.php?do=user_list&p='.$request['p'];
		$pager = new Pager($url,$itemSum,$pageSize,$currentPageNumber);
		$response['pagebar'] = $pager->getBar();
		$response['p'] = $request['p'];
		
		$sql = "select * from user order by id desc limit ".($request['p']-1)*$pageSize.", ".$pageSize;
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		
		for($i=0;$i<$rows_num;$i++)
		{
			$u = new User;
			$rows[$i]['role_name'] = $u->GetRoleName($rows[$i]['role_id']);

			/* Modified by Jing Xiang @ Sept. 1st, 2005 */
			
			if ($rows[$i]['role_id'] <=1 )
			{
				$rows[$i]['channel_name'] = "所有频道";
			} 
			else 
			{
				$sql_channel = "select channel_id from user_channel where user_id=" .  $rows[$i]['id'] . " order by id asc";
				$row = $dao->GetPlan( $sql_channel );
				//如果管理两个以上的频道
				if( $dao->CountAffectedRows() > 1 )
				{
					$str_channel = "<select>";
					for( $j=0;$j<count($row);$j++ )
					{
						$channel = new Channel ();
						$channel->GetByID( $row[$j]['channel_id'] );
						$str_channel .= "<option>" . $channel->GetName() . "</option>";
					}
					$str_channel .= "</select>";
					$rows[$i]['channel_name'] = $str_channel;
				}
				else
				{
					//只有一个频道的情况
					$channel = new Channel ();
					$channel->GetByID( $row[0]['channel_id'] );
					$rows[$i]['channel_name'] = $channel->GetName();
				}
			}					
			/* Old Method
			if($rows[$i]['role_id']<=2)
			{
				$rows[$i]['channel_name'] = "所有频道";
			}
			else 
			{
				$channel = new Channel();
				$channel->GetByID($rows[$i]['channel_id']);
				$rows[$i]['channel_name'] = $channel->GetName();
			}			*/
		}
		$response['user'] = $rows;
	}
}
