<?php
/**
* TemplateListAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/Pager.cls.php');
require_once('mod/Subject.cls.php');

class TemplateListAction extends Action {
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
		$sql_all = "select count(*) as num from template where subject_id=$subject_id"; // wenzhang zongshu
		$itemSum = $dao->GetOne($sql_all);
		$request['p'] = isset($request['p'])?$request['p']:1; // page number
		$request['p'] = (int)$request['p'];                   // int number
		$request['p'] = ($request['p']<1)?1:$request['p'];
		$request['p'] = ($request['p']>ceil($itemSum/$pageSize))?ceil($itemSum/$pageSize):$request['p'];
		$url = 'main.php?do=template_list&channel_name='.$request['channel_name'].'&subject_id='.$subject_id.'&p='.$request['p'];
		$currentPageNumber = $request['p'];
		$pager = new Pager($url,$itemSum,$pageSize,$currentPageNumber);
		$response['pagebar'] = $pager->getBar();
		$response['p'] = $request['p'];
		//print_r($response['pagebar']);
		//获取栏目路径
			$subject = new Subject($db);
			$subject->GetByID($subject_id);
			$level = $subject->GetSort();
			for($i=0;$i<$level;$i++)
			{
				$subjects[$i] = $subject->GetDirName();
				$subject->GetByID($subject->GetParentId());
			}

			$subject_dir = "";
			for($i=$level-1;$i>=0;$i--)
			{
				$subject_dir .= "/" . $subjects[$i];
			}
			
		$sql = "select * from template where subject_id=" . $subject_id . " order by id desc limit ".($request['p']-1)*$pageSize.", ".$pageSize;
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		$r = array();
		$r['channel_name'] = $channel_name;
		$u = new User();
		$r['do'] = 'template_add';
		if($u->ValidatePerm($r))
		{
			$response['data']['op'] = "<a href=main.php?do=template_new_add&channel_name=$channel_name&subject_id=$subject_id target=_self>添加模板</a> | <a href=main.php?do=rss_template_add&channel_name=$channel_name&subject_id=$subject_id target=_self>添加RSS模板</a>";
		}
		$r['do'] = 'template_delete';
		if($u->ValidatePerm($r))
		{
			$deleteop = true;
		}
		$r['do'] = 'template_modify';
		if($u->ValidatePerm($r))
		{
			$modifyop = true;
		}
		for($i=0;$i<$rows_num;$i++)
		{
			$tmp_channel_name=$channel_name;
			if($channel_name=='blog')
			{
				$tmp_channel_name='blogs';
			}
			if($channel_name=='group')
			{
				$tmp_channel_name='groups';
			}
			$rows[$i]['url'] = "http://" . $tmp_channel_name . "." . DOMAIN . $subject_dir . "/" . $rows[$i]['file_name'];
			$rows[$i]['channel_name'] = $channel_name;
			$rows[$i]['p'] = $request['p'];
			if($deleteop)
			{
				$rows[$i]['operations'] .= " <a href=main.php?do=template_delete&id=" . $rows[$i]['id'] . "&channel_name=$channel_name&subject_id=$subject_id&p=" . $request['p'] . " onClick=\"javascript:return window.confirm('确定删除？');\">删除</a>";
			}
			if($modifyop)
			{
				$rows[$i]['operations'] .= " <a href=main.php?do=template_modify&id=" . $rows[$i]['id'] . "&channel_name=$channel_name&subject_id=" . $rows[$i]['subject_id'] . "&p=" . $request['p'] . ">修改</a>";
			}
		}
		$response['templates'] = $rows;
	}
}
?>