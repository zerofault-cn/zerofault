<?php
/**
* HeaderListAction.cls.php
* @copyright bokee dot com
* @author zhangfang@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Header.cls.php');
require_once('com/Pager.cls.php');

class HeaderListAction extends Action {
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
      // $response['channel_name'] = $channel_name;
        $subject_id = empty($request['subject_id'])?0:$request['subject_id'];
//        $special_id = empty($request['special_id'])?0:$request['special_id'];
//        $special_subject_id = empty($request['special_subject_id'])?0:$request['special_subject_id'];
//        $response['subject_id'] = $subject_id;
        //连接数据库 
        $dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db);
		// fenye xiangguan
		$pageSize = 20;                                        // how many  per page 
		$sql_all = "select count(*) as num from header where subject_id=$subject_id"; //zongshu
		$itemSum = $dao->GetOne($sql_all);
		$request['p'] = isset($request['p'])?$request['p']:1; // page number
		$request['p'] = (int)$request['p'];                   // int number
		$request['p'] = ($request['p']<1)?1:$request['p'];
		$request['p'] = ($request['p']>ceil($itemSum/$pageSize))?ceil($itemSum/$pageSize):$request['p'];
		$url = 'main.php?do=header_list&channel_name='.$request['channel_name'].'&subject_id='.$subject_id.'&p='.$request['p'];
		$currentPageNumber = $request['p'];
		$pager = new Pager($url,$itemSum,$pageSize,$currentPageNumber);
		$response['pagebar'] = $pager->getBar();
		$response['p'] = $request['p'];
		//print_r($response['pagebar']);
		$header = new Header($db);
		$sql = "select * from header where subject_id=" . $subject_id . "  order by id desc limit ".($request['p']-1)*$pageSize.", ".$pageSize;
		$rows = $header -> Query($sql);
		$rows_num = count($rows);
		//print_r($rows);
		for($i=0;$i<$rows_num;$i++)
		{
		    $sql1="SELECT name FROM subject WHERE id = ".$rows[$i]['subject_id'].""; 
			$row = $header -> Query($sql1);
			//print_r($row);
            $rows[$i]['subject_name']=$row[0]['name'];
            $rows[$i]['channel_name']=$channel_name;
            $rows[$i]['url'] = "http://" . $channel_name . "." . DOMAIN .  "/header/" . $rows[$i]['subject_id'] . ".html" ;
		}
		//print_r($rows);
		$response['headers'] = $rows;
	}
}
?>