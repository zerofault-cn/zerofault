<?php
/**
* BlockListAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/Block.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/Pager.cls.php');

class BlockListAction extends Action {
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
        $subject_id = empty($request['subject_id'])?0:$request['subject_id'];
        $special_id = empty($request['special_id'])?0:$request['special_id'];
        $special_subject_id = empty($request['special_subject_id'])?0:$request['special_subject_id'];
        $response['subject_id'] = $subject_id;
        //连接数据库 
        $dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db);
		// fenye xiangguan
		$pageSize = 20;                                        // how many  per page 
		$sql_all = "select count(*) as num from template_block where subject_id = '$subject_id'"; // wenzhang zongshu
		$itemSum = $dao->GetOne($sql_all);
		$request['p'] = isset($request['p'])?$request['p']:1; // page number
		$request['p'] = (int)$request['p'];                   // int number
		$request['p'] = ($request['p']<1)?1:$request['p'];
		$request['p'] = ($request['p']>ceil($itemSum/$pageSize))?ceil($itemSum/$pageSize):$request['p'];
		$url = 'main.php?do=block_list&channel_name='.$request['channel_name'].'&subject_id='.$subject_id.'&p='.$request['p'];
		$currentPageNumber = $request['p'];
		$pager = new Pager($url,$itemSum,$pageSize,$currentPageNumber);
		$response['pagebar'] = $pager->getBar();
		$response['p'] = $request['p'];
		//print_r($response['pagebar']);
		$sql = "select * from template_block where subject_id = '$subject_id' order by id desc limit ".($request['p']-1)*$pageSize.", ".$pageSize;
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		for($i=0;$i<$rows_num;$i++)
		{
			$rows[$i]['channel_name'] = $channel_name;
			if(strpos($rows[$i]['name'], "*@*@*") !== false)
			{
				$rows[$i]['link'] = "main.php?do=block_hotcomment_modify&id=" . $rows[$i]['id'] . "&channel_name=$channel_name&subject_id=" . $rows[$i]['subject_id'];
			}
			else if(strpos($rows[$i]['name'], "@*@*@") !== false)
			{
				$rows[$i]['link'] = "main.php?do=block_photo_modify&id=" . $rows[$i]['id'] . "&channel_name=$channel_name&subject_id=" . $rows[$i]['subject_id'];
			}
			else 
			{
				$rows[$i]['link'] = "main.php?do=block_modify&id=" . $rows[$i]['id'] . "&channel_name=$channel_name&subject_id=" . $rows[$i]['subject_id'];
			}
		}
		$response['template_block'] = $rows;
	}
}
?>