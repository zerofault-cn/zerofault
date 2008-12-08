<?php
/**
* ArticleAddAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Article.cls.php');
require_once('mod/User.cls.php');
require_once('mod/Subject.cls.php');

class ArticleAddAction extends Action {
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
		//$response['subject_id'] = $request['subject_id'];
		$subject = new Subject($db);
		$response['data']['subject_options'] = $subject->GetSubjectSelectedOptions(0, "", $request['subject_id']);
        //获取合作媒体
		$dao = DAO::CreateInstance();
		$sql = "select * from coop_media";
		$rows_coop_media = $dao->GetPlan($sql);
		$response['coop_media'] = $rows_coop_media;
		
		//获取媒体默认
		$sql = "select name from channel where dir_name='$channel_name'";
		$media = $dao->GetOne($sql);
		$response['media'] = "博客" . str_replace("频道", "", $media);		
		
		$dao->SetCurrentSchema($db);
		//获取专题
		$sql = "select * from special order by id desc limit 50";
		$rows_special = $dao->GetPlan($sql);
		$response['special'] = $rows_special;
		
		//获取专题栏目
		$rows_special_subject = array();
		$rows_special_subject_last = array();
		$rows_special_num = count($rows_special);
		for($i=0;$i<$rows_special_num;$i++)
		{
			$sql = "select * from special_subject where special_id=" . $rows_special[$i]['id'];
			$rows = $dao->GetPlan($sql);
			$rows_num = count($rows);
			for($j=0;$j<$rows_num;$j++)
			{
				if($i<$rows_special_num-1 || $j<$rows_num-1)
				{
					$rows[$j]['id'] = $this->getNumberStr($rows_special[$i]['id']) . $this->getNumberStr($rows[$j]['id']);
					$rows_special_subject[] = $rows[$j];
				}
				else
				{
					$rows[$j]['id'] = $this->getNumberStr($rows_special[$i]['id']) . $this->getNumberStr($rows[$j]['id']);
					$rows_special_subject_last[] = $rows[$j];
				}
			}		
		}
		$response['special_subject'] = $rows_special_subject;
		$response['special_subject_last'] = $rows_special_subject_last;
		
		//设置mark
		$mark = array();
		for($i=0;$i<5;$i++)
		{
			$mark[$i]['value'] = $i+1;
		}
		$mark[0]['checked'] = "checked";
		$response['mark'] = $mark;
		
		//设置评论选项
		$comment = array();
		$comment[0]['value'] = 1;
		$comment[0]['name'] = "是";
		$comment[1]['value'] = 0;
		$comment[1]['name'] = "否";
		$comment[0]['checked'] = "checked";
		$response['comment'] = $comment;
		
		//设置广告选项
		$ad = array();
		$ad[0]['value'] = 1;
		$ad[0]['name'] = "是";
		$ad[1]['value'] = 0;
		$ad[1]['name'] = "否";
		$ad[0]['checked'] = "checked";
		$response['ad'] = $ad;
		
		//设置跳转选项
		$jump = array();
		$jump[0]['value'] = 1;
		$jump[0]['name'] = "是";
		$jump[1]['value'] = 0;
		$jump[1]['name'] = "否";
		$jump[1]['checked'] = "checked";
		$response['jump'] = $jump;

		//设置组选项
		$sql = "select id, name from article_group where subject_id=" . $request['subject_id'];
		$row = $dao->GetPlan( $sql );
		$response['group_list'] = $row;
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