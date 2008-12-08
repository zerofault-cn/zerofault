<?php
/**
* PhotoListAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/Pager.cls.php');

class PhotoListAction extends Action {
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
		$subject_id= $request['subject_id'];
        $db = "cms_" . $channel_name;
        $response['data']['channel_name'] = $channel_name;
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
	
		$pageSize = 50;
		$sql_subjectname="SELECT * FROM `subject` WHERE id=$subject_id";  
		$sort = $dao->query($sql_subjectname);
		$sortname=$dao->fa($sort);
		if($sortname[id]!="")
		{
		$flashname="where subject_id=" ."'$sortname[id]'";
		}else{$flashname="";}
		$sql_all = "select count(*) from gallery "."$flashname" ." order by id desc ";
		$itemSum = $dao->GetOne($sql_all);
		$request['p'] = isset($request['p'])?$request['p']:1; // page number


		$url = 'main.php?do=photo_list&channel_name='.$request['channel_name'].'&p='.$request['p'];
		$currentPageNumber = $request['p'];
		$pager = new Pager($url,$itemSum,$pageSize,$currentPageNumber);
		$response['data']['pagebar'] = $pager->getBar();

		$sql = "select * from gallery ". $flashname ."order by id desc limit ".($request['p']-1)*$pageSize.", ".$pageSize;
        $rows = $dao->GetPlan($sql);
        $rows_num = count($rows);
        for($i=0;$i<$rows_num;$i++)
        {
        	$rows[$i]['channel_name'] = $channel_name;
        }
        $response['data']['photos'] = $rows;
	}
}
?>