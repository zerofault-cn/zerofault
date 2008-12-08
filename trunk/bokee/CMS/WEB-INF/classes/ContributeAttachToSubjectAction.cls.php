<?php
/**
* FeedAttachToSubjectAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/User.cls.php');

class ContributeAttachToSubjectAction extends Action {
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
        session_start();
		$user = $_SESSION['user'];
		$u = new User();
		$u->GetByID($user['id']);
		$dao = DAO::CreateInstance();
		if($user['role_id']<=1)
		{
			//所有频道都可以管理
			$sql = "select * from channel order by id desc ";
		}
		else 
		{
			//只能管理具有权限的频道
			$channel_ids = $u->GetChannelIDs();
			$channel_num = count($channel_ids);
			$ids = "";
			for($i=0;$i<$channel_num;$i++)
			{
				$ids .= $channel_ids[$i]['channel_id'];
				if($i<($channel_num-1))
					$ids .= ", ";
			}
			$sql = "select * from channel where id in (" . $ids . ") order by id desc";
		}
		$rows_channel = $dao->GetPlan($sql);
		$rows_num_channel = count($rows_channel);
		$response['channels'] = $rows_channel;
        $subjects_array = "";
		for($i=0;$i<$rows_num_channel;$i++)
		{
			$channel_id = $rows_channel[$i]['id'];
			$subjects_array .= $this->getSubChannel($rows_channel[$i]['id'], $rows_channel[$i]['dir_name']);
    	}
    	$subjects_array = substr($subjects_array, 0, strlen($subjects_array)-2);
    	$response['data']['subjects_array'] = $subjects_array;
    	$response['data']['feed_id'] = $request['feed_id'];
	}
	
	/**
	* @access private
	* @abstract 获递归取子栏目树状图代码
	*/
	function getSubChannel($channel_id, $dir_name, $parent_id=0, $level=1)
	{
		$db_name = "cms_" . $dir_name;
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db_name);
		$sql = "select * from subject where parent_id=" . $parent_id . " and sort=" . $level . " order by id desc limit 0, 50";
		
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		$level++;
		$script = "";
		$minus = "";
		for($j=2;$j<$level;$j++)
		{
			$minus .= "--";
		}
		for($i=0;$i<$rows_num;$i++)
		{
			$id = $this->getNumberStr($channel_id) . $this->getNumberStr($rows[$i]['id']);
			$script .= "new Array(\"" . $id . "\",\"" . $minus . $rows[$i]['name'] . "\"),\n";
			$script .= $this->getSubChannel($channel_id, $dir_name, $rows[$i]['id'], $level);
		}
		return $script;
	}
	
	/**
	* @access private
	* @param int $number
	* @return stirng $string
	*/
	function getNumberStr($number)
	{
		$number = intval($number);
		if($number<10)
			return "00" . $number;
		if($number<100)
			return "0" . $number;
		return $number;
	}
}
?>