<?php 
/**
* ArticleListAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/
require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Article.cls.php');
require_once('mod/User.cls.php');
require_once('com/Pager.cls.php');
require_once('mod/Subject.cls.php');

class GroupPartyListAction extends Action {
	/**
    * 
    * @access public
    * @param array &$request
    * @param array &$files
    */
    function execute(&$actionMap,&$actionError,$request,&$response,$form){
        // 事务处理
        // 将需要显示给用户的错误注入到 $response['action_erros'] 中

        //return $actionMap->findForward('success');
        //return $actionMap->findForward('sysError');   
        
		$dao = DAO::CreateInstance();
		$db = "cms_" . $request['channel_name'];
		$subject_id = $request['subject_id'];
		$dao->SetCurrentSchema($db);
		$response['subject_id'] = $subject_id;
		$response['channel_name'] = $request['channel_name'];

		// how many  per page
		$pageSize = $_REQUEST['chioce'];                                     
		if(!$pageSize)
		{
			$pageSize=20;
		}
		$pageSize_rss = $_REQUEST['chioce_rss'];
		if(!$pageSize_rss){$pageSize_rss=20;
		}
		$subject = new Subject($db);
		$subject->GetByID($subject_id);

		$sql_all = "select count(*) as num from group_party ";
		
		$itemSum = $dao->GetOne($sql_all);
		$request['p'] = isset($request['p'])?$request['p']:1; // page number
		$request['p'] = (int)$request['p'];                   // int number
		$request['p'] = ($request['p']<1)?1:$request['p'];
		$request['p'] = ($request['p']>ceil($itemSum/$pageSize))?ceil($itemSum/$pageSize):$request['p'];
		
		$request['p_rss'] = isset($request['p_rss'])?$request['p_rss']:1; // page number
		$request['p_rss'] = (int)$request['p_rss'];                   // int number
		$request['p_rss'] = ($request['p_rss']<1)?1:$request['p_rss'];
			
		$url = 'main.php?do=group_party_list&channel_name='.$request['channel_name'].'&subject_id='.$subject_id.'&p_rss='.$request['p_rss'].'&chioce='.$pageSize;
		$currentPageNumber = $request['p'];
		$pager = new Pager($url,$itemSum,$pageSize,$currentPageNumber);
		$response['pagebar'] = $pager->getBar();
		$response['p'] = $request['p'];
		$sql = "select * from group_party order by id desc limit ".($request['p']-1)*$pageSize.", ".$pageSize;
		$rows = $dao->GetPlan($sql);
		$row_num = count($rows);
		for($i=0;$i<$row_num;$i++)
		{
			
			$rows[$i]['subject_id'] = $request['subject_id'];
			$rows[$i]['channel_name'] = $request['channel_name'];
			$rows[$i]['p'] = $request['p'];
			$rows[$i]['p_rss'] = $request['p_rss'];
			$rows[$i]['bgcolor'] = ($i%2==0)?"#ffffff":"#C6E6E6";
			$rows[$i]['fontcolor']=($rows[$i]['del_flag']!=1)?"#000000":"#A0A0A0";
			if($rows[$i]['del_flag']!=1)
			{
				$rows[$i]['opration']='<a href="main.php?do=group_party_update&subject_id='.$subject_id.'&channel_name='.$request['channel_name'].'&del_flag=1&group_partyid='.$rows[$i]['id'].'" target="iframe1">隐藏</a>';
			}
			else
			{
				$rows[$i]['opration']='<a href="main.php?do=group_party_update&subject_id='.$subject_id.'&channel_name='.$request['channel_name'].'&del_flag=0&group_partyid='.$rows[$i]['id'].'" target="iframe1">显示</a>';
			}
		}
		$response['articles'] = $rows;

	}
	
	function hdate($op,$ts)
	{
		 $unix_ts = mktime( substr($ts,8,2), substr($ts,10,2), substr($ts,12,2), substr($ts,4,2), substr($ts,6,2), substr($ts,0,4) );
		 $output = date($op,$unix_ts);
		 return $output;
	}
}
?>
